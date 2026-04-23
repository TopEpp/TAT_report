<?php
namespace Modules\Report\Models;

use CodeIgniter\Model;

/**
 * CountryGroup_model
 *
 * อ่านโครงสร้างประเทศตาม 4 แบบ: STD_GOV, STD_TAT, ALL_GOV, ALL_TAT
 * ใช้ตารางใหม่ MD_COUNTRY_GROUP + MD_COUNTRY_GROUP_NODE (ไม่แตะ MD_STD_REGION / MD_DEP_MARKET)
 */
class CountryGroup_model extends Model
{
    const DEFAULT_CODE = 'STD_GOV';
    const VALID_CODES = ['STD_GOV', 'STD_TAT', 'ALL_GOV', 'ALL_TAT'];

    /** list 4 groups สำหรับ dropdown */
    public function getGroups()
    {
        return $this->db->table('MD_COUNTRY_GROUP')
            ->select('GROUP_ID, GROUP_CODE, SCOPE, SOURCE, NAME_TH, NAME_EN, SORT_ORDER')
            ->where('IS_ACTIVE', 'Y')
            ->orderBy('SORT_ORDER')
            ->get()->getResultArray();
    }

    public function getGroupByCode($code)
    {
        $code = in_array($code, self::VALID_CODES, true) ? $code : self::DEFAULT_CODE;
        return $this->db->table('MD_COUNTRY_GROUP')
            ->where('GROUP_CODE', $code)->get()->getRowArray();
    }

    /**
     * ดึง node ทั้งหมดของ group เรียงตาม SORT_ORDER
     * return: indexed list พร้อม fields พื้นฐาน
     */
    public function getNodes($code)
    {
        $g = $this->getGroupByCode($code);
        if (!$g) return [];
        return $this->db->table('MD_COUNTRY_GROUP_NODE')
            ->select('NODE_ID, PARENT_NODE_ID, NODE_TYPE, NAME_EN, NAME_TH, COUNTRY_ID, SORT_ORDER, IS_OTHERS')
            ->where('GROUP_ID', $g['GROUP_ID'])
            ->orderBy('SORT_ORDER')
            ->get()->getResultArray();
    }

    /**
     * ดึงโครงสร้างเป็น tree สำหรับ render 2-level (Ministry) หรือ 3-level (TAT)
     * return: [
     *   ['node' => regionNode, 'children' => [
     *      ['node' => countryOrTatNode, 'children' => [...countries]]
     *   ]],
     *   ...
     * ]
     */
    public function getHierarchy($code)
    {
        $nodes = $this->getNodes($code);
        $byId = [];
        foreach ($nodes as $n) $byId[$n['NODE_ID']] = $n + ['children' => []];

        $roots = [];
        foreach ($byId as $id => $n) {
            if (empty($n['PARENT_NODE_ID'])) {
                $roots[] =& $byId[$id];
            } else {
                $pid = $n['PARENT_NODE_ID'];
                if (isset($byId[$pid])) $byId[$pid]['children'][] =& $byId[$id];
            }
        }
        unset($n);
        return $roots;
    }

    /**
     * list ประเทศทั้งหมดใน group (flat) พร้อม region/TAT office parent info
     * return: [['country_id'=>, 'name_en'=>, 'region_id'=>, 'region_name'=>, 'tat_office_id'=>, 'tat_office_name'=>], ...]
     */
    public function getCountries($code)
    {
        $nodes = $this->getNodes($code);
        $byId = [];
        foreach ($nodes as $n) $byId[$n['NODE_ID']] = $n;

        $out = [];
        foreach ($nodes as $n) {
            if ($n['NODE_TYPE'] !== 'COUNTRY' || empty($n['COUNTRY_ID'])) continue;
            $regionId = $regionName = $tatId = $tatName = null;

            $parent = $byId[$n['PARENT_NODE_ID']] ?? null;
            if ($parent) {
                if ($parent['NODE_TYPE'] === 'TAT_OFFICE') {
                    $tatId = $parent['NODE_ID'];
                    $tatName = $parent['NAME_EN'];
                    $grand = $byId[$parent['PARENT_NODE_ID']] ?? null;
                    if ($grand) {
                        $regionId = $grand['NODE_ID'];
                        $regionName = $grand['NAME_EN'];
                    }
                } else {
                    $regionId = $parent['NODE_ID'];
                    $regionName = $parent['NAME_EN'];
                }
            }

            $out[] = [
                'node_id'         => $n['NODE_ID'],
                'country_id'      => $n['COUNTRY_ID'],
                'country_name_en' => $n['NAME_EN'],
                'sort_order'      => $n['SORT_ORDER'],
                'region_id'       => $regionId,
                'region_name'     => $regionName,
                'tat_office_id'   => $tatId,
                'tat_office_name' => $tatName,
            ];
        }
        return $out;
    }

    /**
     * แปลงเป็น legacy format ที่ view เดิม (genTableData) ใช้:
     *   region[parent_id][] = [MD_STD_REG_ID, MD_STD_REG_NAMEEN, PARENT_ID, IS_OTHERS, IS_STANDARD, NODE_TYPE]
     *   country[region_id][country_id] = [COUNTRYID, COUNTRY_NAME_EN, STD_REGION_ID, REGIONID, IS_MASTER, MARKET_TYPE]
     * TAT_OFFICE ถูกเก็บเป็น region node ชั้นกลาง → ทำงานกับ recursion เดิมได้เลย
     */
    public function getLegacyFormat($code)
    {
        $nodes = $this->getNodes($code);
        $region = [];
        $country = [];
        foreach ($nodes as $n) {
            $parentId = (int)($n['PARENT_NODE_ID'] ?: 0);
            $nodeId   = (int)$n['NODE_ID'];

            if ($n['NODE_TYPE'] === 'REGION' || $n['NODE_TYPE'] === 'TAT_OFFICE') {
                $region[$parentId][] = [
                    'MD_STD_REG_ID'       => $nodeId,
                    'MD_STD_REG_NAMEEN'   => $n['NAME_EN'],
                    'MD_STD_REG_NAMETH'   => $n['NAME_TH'] ?? $n['NAME_EN'],
                    'PARENT_ID'           => $parentId,
                    'IS_OTHERS'           => $n['IS_OTHERS'],
                    'IS_STANDARD'         => 'Y',
                    'NODE_TYPE'           => $n['NODE_TYPE'],
                    'MD_REPORT_ORDER_SEQ' => $n['SORT_ORDER'],
                ];
            } elseif ($n['NODE_TYPE'] === 'COUNTRY' && !empty($n['COUNTRY_ID'])) {
                $cid = (int)$n['COUNTRY_ID'];
                $country[$parentId][$cid] = [
                    'COUNTRYID'       => $cid,
                    'COUNTRY_NAME_EN' => $n['NAME_EN'],
                    'COUNTRY_NAME_TH' => $n['NAME_TH'] ?? $n['NAME_EN'],
                    'STDREGIONID'     => $parentId,
                    'STD_REGION_ID'   => $parentId,
                    'REGIONID'        => $parentId,
                    'IS_STANDARD'     => 'Y',
                    'IS_MASTER'       => 'Y',
                    'MARKET_TYPE'     => '',
                ];
            }
        }
        return ['region' => $region, 'country' => $country];
    }

    /**
     * map code ↔ legacy country_type เพื่อ backward-compat
     */
    public static function legacyTypeFromCode($code)
    {
        return (strpos((string)$code, 'STD_') === 0) ? 'standard' : 'all';
    }

    public static function codeFromLegacyType($type)
    {
        return ($type === 'standard') ? 'STD_GOV' : 'ALL_GOV';
    }

    /**
     * return list COUNTRY_ID เฉพาะที่อยู่ใน group (ใช้กรอง query ตัวเลขรายงาน)
     */
    public function getCountryIds($code)
    {
        $g = $this->getGroupByCode($code);
        if (!$g) return [];
        $rows = $this->db->table('MD_COUNTRY_GROUP_NODE')
            ->select('COUNTRY_ID')->distinct()
            ->where('GROUP_ID', $g['GROUP_ID'])
            ->where('NODE_TYPE', 'COUNTRY')
            ->where('COUNTRY_ID IS NOT NULL', null, false)
            ->get()->getResultArray();
        return array_values(array_map(fn($r) => (int)$r['COUNTRY_ID'], $rows));
    }
}
