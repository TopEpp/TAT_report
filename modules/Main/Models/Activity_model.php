<?php

namespace Modules\Main\Models;

use CodeIgniter\Model;

/**
 * Activity_model (Light) — สำหรับ realtime2 dashboard
 * อ้างอิง: TAT.ACTIVITY (Oracle, schema TAT)
 * - ใช้ Buddhist Year (พ.ศ.) เป็นหลัก เพราะ ACT_YEAR เก็บเป็น พ.ศ.
 * - filter: ACT_START_DATE/ACT_END_DATE NOT NULL (ตาม pattern ของ Activity module เดิม)
 */
class Activity_model extends Model
{
	protected $table = 'TAT.ACTIVITY';
	protected $primaryKey = 'ACT_ID';
	protected $allowedFields = [];

	/* ===========================================================
	 * Helper: build base filter โดยใช้ปี ค.ศ. (CE)
	 * รองรับทั้ง ACT_START_DATE/END_DATE และ ACT_YEAR (พ.ศ.)
	 * =========================================================== */
	private function applyYearFilter($builder, $ce_year)
	{
		$thaiYear = $ce_year + 543;
		$builder->where("(
			(EXTRACT(YEAR FROM ACTIVITY.ACT_START_DATE) = $ce_year
				OR EXTRACT(YEAR FROM ACTIVITY.ACT_END_DATE) = $ce_year)
			OR ACTIVITY.ACT_YEAR = $thaiYear
		)");
	}

	/* ===========================================================
	 * 1) Summary: total events ปีปัจจุบัน vs ปีก่อน
	 * =========================================================== */
	function getActivitySummary($ce_year)
	{
		$out = ['total' => 0, 'total_prev' => 0, 'yoy' => 0];
		try {
			// ปีปัจจุบัน
			$builder = $this->db->table('TAT.ACTIVITY');
			$builder->select('COUNT(ACT_ID) AS CNT');
			$builder->where('ACT_START_DATE IS NOT NULL');
			$this->applyYearFilter($builder, $ce_year);
			$row = $builder->get()->getRowArray();
			$out['total'] = (int)($row['CNT'] ?? 0);

			// ปีก่อน
			$builder = $this->db->table('TAT.ACTIVITY');
			$builder->select('COUNT(ACT_ID) AS CNT');
			$builder->where('ACT_START_DATE IS NOT NULL');
			$this->applyYearFilter($builder, $ce_year - 1);
			$row = $builder->get()->getRowArray();
			$out['total_prev'] = (int)($row['CNT'] ?? 0);

			$out['yoy'] = $out['total_prev'] > 0
				? round(($out['total'] - $out['total_prev']) / $out['total_prev'] * 100, 2)
				: 0;
		} catch (\Exception $e) {}
		return $out;
	}

	/* ===========================================================
	 * 2) By Province — return [province_name => count]
	 * =========================================================== */
	function getActivityByProvince($ce_year)
	{
		$out = [];
		try {
			$builder = $this->db->table('TAT.ACTIVITY');
			$builder->select('MD_PROVINCE.PROVINCE_NAME_TH AS NAME, COUNT(ACT_ID) AS CNT');
			$builder->join('TAT.MD_PROVINCE', 'ACTIVITY.ACT_PROVICE_ID = MD_PROVINCE.PROVINCE_ID', 'left');
			$builder->where('ACT_START_DATE IS NOT NULL');
			$this->applyYearFilter($builder, $ce_year);
			$builder->groupBy('MD_PROVINCE.PROVINCE_NAME_TH');
			$builder->orderBy('CNT', 'DESC');
			$rows = $builder->get()->getResultArray();
			foreach ($rows as $r) {
				if (!empty($r['NAME'])) {
					$out[$r['NAME']] = (int)$r['CNT'];
				}
			}
		} catch (\Exception $e) {}
		return $out;
	}

	/* ===========================================================
	 * 3) By Region — return [region_name => count]
	 * =========================================================== */
	function getActivityByRegion($ce_year)
	{
		$out = [];
		try {
			$builder = $this->db->table('TAT.ACTIVITY');
			$builder->select('MD_REGION.REGION_NAME_TH AS NAME, COUNT(ACT_ID) AS CNT');
			$builder->join('TAT.MD_REGION', 'ACTIVITY.ACT_REGION = MD_REGION.REGION_ID', 'left');
			$builder->where('ACT_START_DATE IS NOT NULL');
			$this->applyYearFilter($builder, $ce_year);
			$builder->groupBy('MD_REGION.REGION_NAME_TH');
			$builder->orderBy('CNT', 'DESC');
			$rows = $builder->get()->getResultArray();
			foreach ($rows as $r) {
				if (!empty($r['NAME'])) {
					$out[$r['NAME']] = (int)$r['CNT'];
				}
			}
		} catch (\Exception $e) {}
		return $out;
	}

	/* ===========================================================
	 * 4) By Type — return list [['name'=>..,'count'=>..], ...]
	 * =========================================================== */
	function getActivityByType($ce_year)
	{
		$out = [];
		try {
			$builder = $this->db->table('TAT.ACTIVITY');
			$builder->select('MD_ACTIVITY_TYPE.ACT_TYPE_TH AS NAME, COUNT(ACT_ID) AS CNT');
			$builder->join('TAT.MD_ACTIVITY_TYPE', 'ACTIVITY.ACT_TYPE = MD_ACTIVITY_TYPE.ACT_TYPE_ID', 'left');
			$builder->where('ACT_START_DATE IS NOT NULL');
			$this->applyYearFilter($builder, $ce_year);
			$builder->groupBy('MD_ACTIVITY_TYPE.ACT_TYPE_TH');
			$builder->orderBy('CNT', 'DESC');
			$rows = $builder->get()->getResultArray();
			foreach ($rows as $r) {
				$out[] = [
					'name'  => $r['NAME'] ?? 'ไม่ระบุ',
					'count' => (int)$r['CNT'],
				];
			}
		} catch (\Exception $e) {}
		return $out;
	}

	/* ===========================================================
	 * 5) By Month — return [1..12 => count]
	 *   ใช้ ACT_START_DATE เป็นหลัก (ไม่นับซ้ำกรณี ACT_END_DATE คนละเดือน)
	 * =========================================================== */
	function getActivityByMonth($ce_year)
	{
		$out = array_fill(1, 12, 0);
		try {
			$thaiYear = $ce_year + 543;
			$builder = $this->db->table('TAT.ACTIVITY');
			$builder->select("EXTRACT(MONTH FROM ACT_START_DATE) AS M, COUNT(ACT_ID) AS CNT");
			$builder->where('ACT_START_DATE IS NOT NULL');
			$builder->where("(
				EXTRACT(YEAR FROM ACT_START_DATE) = $ce_year
				OR ACT_YEAR = $thaiYear
			)");
			$builder->groupBy("EXTRACT(MONTH FROM ACT_START_DATE)");
			$builder->orderBy("M", "ASC");
			$rows = $builder->get()->getResultArray();
			foreach ($rows as $r) {
				$m = (int)$r['M'];
				if ($m >= 1 && $m <= 12) $out[$m] = (int)$r['CNT'];
			}
		} catch (\Exception $e) {}
		return $out;
	}

	/* ===========================================================
	 * 5b) By Month-by-Province — return [province_name => [1..12 => count]]
	 *     ใช้สำหรับ Activity Impact Analysis filter รายจังหวัด
	 * =========================================================== */
	function getActivityByMonthByProvince($ce_year)
	{
		$out = [];
		try {
			$thaiYear = $ce_year + 543;
			$builder = $this->db->table('TAT.ACTIVITY');
			$builder->select("MD_PROVINCE.PROVINCE_NAME_TH AS NAME,
				EXTRACT(MONTH FROM ACT_START_DATE) AS M,
				COUNT(ACT_ID) AS CNT");
			$builder->join('TAT.MD_PROVINCE', 'ACTIVITY.ACT_PROVICE_ID = MD_PROVINCE.PROVINCE_ID', 'left');
			$builder->where('ACT_START_DATE IS NOT NULL');
			$builder->where("(
				EXTRACT(YEAR FROM ACT_START_DATE) = $ce_year
				OR ACT_YEAR = $thaiYear
			)");
			$builder->groupBy("MD_PROVINCE.PROVINCE_NAME_TH, EXTRACT(MONTH FROM ACT_START_DATE)");
			$rows = $builder->get()->getResultArray();
			foreach ($rows as $r) {
				$name = $r['NAME'] ?? '';
				$m = (int)$r['M'];
				if (!$name || $m < 1 || $m > 12) continue;
				if (!isset($out[$name])) $out[$name] = array_fill(1, 12, 0);
				$out[$name][$m] = (int)$r['CNT'];
			}
		} catch (\Exception $e) {}
		return $out;
	}

	/* ===========================================================
	 * 6) Upcoming — กิจกรรมที่กำลังจะมา (start >= วันนี้)
	 * =========================================================== */
	function getUpcomingActivity($limit = 10)
	{
		$out = [];
		try {
			$builder = $this->db->table('TAT.ACTIVITY');
			$builder->select("
				ACTIVITY.ACT_ID,
				ACTIVITY.ACT_NAME_TH,
				TO_CHAR(ACTIVITY.ACT_START_DATE,'YYYY-MM-DD') AS START_DATE,
				TO_CHAR(ACTIVITY.ACT_END_DATE,'YYYY-MM-DD') AS END_DATE,
				MD_PROVINCE.PROVINCE_NAME_TH AS PROVINCE,
				MD_REGION.REGION_NAME_TH AS REGION,
				MD_ACTIVITY_TYPE.ACT_TYPE_TH AS TYPE_NAME,
				MD_ACTIVITY_LEVEL.LEVEL_NAME AS LEVEL_NAME
			");
			$builder->join('TAT.MD_PROVINCE', 'ACTIVITY.ACT_PROVICE_ID = MD_PROVINCE.PROVINCE_ID', 'left');
			$builder->join('TAT.MD_REGION', 'ACTIVITY.ACT_REGION = MD_REGION.REGION_ID', 'left');
			$builder->join('TAT.MD_ACTIVITY_TYPE', 'ACTIVITY.ACT_TYPE = MD_ACTIVITY_TYPE.ACT_TYPE_ID', 'left');
			$builder->join('TAT.MD_ACTIVITY_LEVEL', 'ACTIVITY.ACT_LEVEL = MD_ACTIVITY_LEVEL.LEVEL_ID', 'left');
			$builder->where('ACT_START_DATE IS NOT NULL');
			$builder->where('TRUNC(ACT_START_DATE) >= TRUNC(SYSDATE)');
			$builder->orderBy('ACT_START_DATE', 'ASC');
			$builder->limit($limit);
			$rows = $builder->get()->getResultArray();
			$out = $rows;
		} catch (\Exception $e) {}
		return $out;
	}

	/* ===========================================================
	 * 7) Active Now — กิจกรรมที่กำลังจัดอยู่ (วันนี้อยู่ระหว่าง start-end)
	 * =========================================================== */
	function getActiveNow($limit = 10)
	{
		$out = ['count' => 0, 'list' => []];
		try {
			$builder = $this->db->table('TAT.ACTIVITY');
			$builder->select('COUNT(ACT_ID) AS CNT');
			$builder->where('ACT_START_DATE IS NOT NULL');
			$builder->where('TRUNC(ACT_START_DATE) <= TRUNC(SYSDATE)');
			$builder->where('TRUNC(ACT_END_DATE)   >= TRUNC(SYSDATE)');
			$row = $builder->get()->getRowArray();
			$out['count'] = (int)($row['CNT'] ?? 0);

			// ดึงรายการ
			$builder = $this->db->table('TAT.ACTIVITY');
			$builder->select("
				ACTIVITY.ACT_NAME_TH,
				TO_CHAR(ACTIVITY.ACT_START_DATE,'YYYY-MM-DD') AS START_DATE,
				TO_CHAR(ACTIVITY.ACT_END_DATE,'YYYY-MM-DD') AS END_DATE,
				MD_PROVINCE.PROVINCE_NAME_TH AS PROVINCE,
				MD_ACTIVITY_TYPE.ACT_TYPE_TH AS TYPE_NAME
			");
			$builder->join('TAT.MD_PROVINCE', 'ACTIVITY.ACT_PROVICE_ID = MD_PROVINCE.PROVINCE_ID', 'left');
			$builder->join('TAT.MD_ACTIVITY_TYPE', 'ACTIVITY.ACT_TYPE = MD_ACTIVITY_TYPE.ACT_TYPE_ID', 'left');
			$builder->where('ACT_START_DATE IS NOT NULL');
			$builder->where('TRUNC(ACT_START_DATE) <= TRUNC(SYSDATE)');
			$builder->where('TRUNC(ACT_END_DATE)   >= TRUNC(SYSDATE)');
			$builder->orderBy('ACT_START_DATE', 'DESC');
			$builder->limit($limit);
			$out['list'] = $builder->get()->getResultArray();
		} catch (\Exception $e) {}
		return $out;
	}
}
