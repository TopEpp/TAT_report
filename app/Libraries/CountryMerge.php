<?php

namespace App\Libraries;

/**
 * CountryMerge
 *
 * ยุบยอดของ "ประเทศต้นทาง" เข้าไปรวมกับ "ประเทศปลายทาง" ตามกฎของ ททท.
 * (เช่น ITALY = ITALY + VATICAN CITY STATE) โดยทำที่ชั้นข้อมูล
 * ก่อนส่งเข้า view ทำให้ทุกหน้า/ทุก export ได้ยอดเดียวกันโดยไม่ต้องแก้ renderer
 *
 * กฎเก็บในตาราง MD_COUNTRY_MERGE แยกตาม GROUP_CODE
 * -> รูปแบบกระทรวง (STD_GOV/ALL_GOV) ไม่ถูกยุบ ยังแสดงประเทศต้นทางแยกตามเดิม
 *
 * ทุกเมธอดคืนค่า array ชุดใหม่เสมอ ไม่แก้ของเดิม
 */
class CountryMerge
{
    /** คีย์มาตรฐานของ country id ใน row ที่ได้จาก model */
    const DEFAULT_ID_KEY = 'COUNTRY_ID';

    /** คีย์ตัวเลขที่ต้องบวกรวมกันเวลายุบ row */
    const DEFAULT_SUM_KEYS = ['NUM'];

    /**
     * คีย์ที่เป็น "ตัวระบุ" ไม่ใช่ "ตัววัด" -> ห้ามบวก ให้คงค่าของปลายทางไว้
     * (ไม่งั้น COUNTRY_ID 88 + 100 จะกลายเป็น 188)
     */
    const IDENTIFIER_KEYS = [
        'COUNTRY_ID', 'COUNTRYID', 'PORT_ID', 'OFFICE_ID', 'NODE_ID',
        'REGION_ID', 'REGIONID', 'STDREGIONID', 'STD_REGION_ID', 'MD_STD_REG_ID',
        'MARKET_TYPE', 'REPORT_DATE', 'REPORT_MONTH', 'YEAR', 'MONTH',
    ];

    /**
     * ยุบ array ที่ key เป็น country id
     *
     * รองรับทุกรูปทรงที่ model คืนมา:
     *   [cid => number]                     เช่น getSumCountryMonth()
     *   [cid => [date => number]]           เช่น getNatDaily()
     *   [cid => [port => [date => row]]]    เช่น getPortCompareData()
     *   [cid => row]                        เช่น getNatBetweenDateData()
     *
     * @param array $data  ข้อมูลจาก model
     * @param array $merge [sourceCountryId => targetCountryId]
     * @return array ชุดใหม่ที่ยอด source ถูกบวกเข้า target และ source ถูกตัดออก
     */
    public static function foldMap(array $data, array $merge)
    {
        if (empty($merge) || empty($data)) {
            return $data;
        }

        $result = $data;

        foreach ($merge as $sourceId => $targetId) {
            if (!array_key_exists($sourceId, $result)) {
                continue;
            }

            $sourceValue = $result[$sourceId];
            unset($result[$sourceId]);

            $result[$targetId] = array_key_exists($targetId, $result)
                ? self::sumDeep($result[$targetId], $sourceValue)
                : $sourceValue;
        }

        return $result;
    }

    /**
     * ยุบ list ของ row (array แบบ index ต่อเนื่อง) เช่น getMarketData() หรือการ์ด ranking
     *
     * ถ้า target อยู่ใน list อยู่แล้ว -> บวกยอดเข้า target แล้วตัด row ของ source ทิ้ง
     * ถ้าไม่มี target ใน list        -> เปลี่ยน id ของ row source ให้เป็น target แทน
     *                                    (กันยอดหายกรณี target ไม่ติดมาใน result set)
     *
     * @param array  $rows    list ของ row
     * @param array  $merge   [sourceCountryId => targetCountryId]
     * @param string $idKey   ชื่อคีย์ที่เก็บ country id
     * @param array  $sumKeys ชื่อคีย์ตัวเลขที่ต้องบวกรวม
     * @return array list ชุดใหม่ (index เรียงใหม่)
     */
    public static function foldRows(
        array $rows,
        array $merge,
        $idKey = self::DEFAULT_ID_KEY,
        array $sumKeys = self::DEFAULT_SUM_KEYS
    ) {
        if (empty($merge) || empty($rows)) {
            return $rows;
        }

        $indexByCountry = [];
        foreach ($rows as $i => $row) {
            if (isset($row[$idKey])) {
                $indexByCountry[(int)$row[$idKey]] = $i;
            }
        }

        $result  = $rows;
        $dropped = [];

        foreach ($merge as $sourceId => $targetId) {
            if (!isset($indexByCountry[(int)$sourceId])) {
                continue;
            }
            $sourceIndex = $indexByCountry[(int)$sourceId];

            if (!isset($indexByCountry[(int)$targetId])) {
                $result[$sourceIndex][$idKey] = $targetId;
                $indexByCountry[(int)$targetId] = $sourceIndex;
                continue;
            }

            $targetIndex = $indexByCountry[(int)$targetId];
            foreach ($sumKeys as $key) {
                $result[$targetIndex][$key] = (float)@$result[$targetIndex][$key]
                                            + (float)@$result[$sourceIndex][$key];
            }
            $dropped[$sourceIndex] = true;
        }

        if (empty($dropped)) {
            return $result;
        }

        return array_values(array_filter(
            $result,
            fn($i) => !isset($dropped[$i]),
            ARRAY_FILTER_USE_KEY
        ));
    }

    /**
     * บวกค่าสองก้อนเข้าด้วยกันแบบลงลึก
     * - array + array                  -> ไล่บวกทีละคีย์
     * - ตัวเลข + ตัวเลข                 -> บวกกัน
     * - คีย์ที่เป็นตัวระบุ / ค่าที่ไม่ใช่ตัวเลข -> คงค่าของ target ไว้
     *
     * @param mixed       $target ค่าฝั่งประเทศปลายทาง
     * @param mixed       $source ค่าฝั่งประเทศต้นทางที่จะยุบเข้ามา
     * @param string|null $key    ชื่อคีย์ของค่านี้ (ใช้เช็คว่าเป็นตัวระบุหรือไม่)
     */
    private static function sumDeep($target, $source, $key = null)
    {
        if (is_array($target) && is_array($source)) {
            $merged = $target;
            foreach ($source as $childKey => $value) {
                $merged[$childKey] = array_key_exists($childKey, $merged)
                    ? self::sumDeep($merged[$childKey], $value, $childKey)
                    : $value;
            }
            return $merged;
        }

        if ($key !== null && in_array((string)$key, self::IDENTIFIER_KEYS, true)) {
            return $target;
        }

        if (is_numeric($target) && is_numeric($source)) {
            return $target + $source;
        }

        return $target;
    }
}
