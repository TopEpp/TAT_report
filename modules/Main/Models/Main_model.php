<?php

namespace Modules\Main\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Mydate;
use App\Libraries\Hash;

class Main_model extends Model
{
	protected $table = 'REPORT_CAL_DAILY'; //CAL_SUM_DATA_REPORT
	protected $table_out = 'REPORT_RAW_DATA';
	protected $table_month = 'CAL_MONTHLY_RAW_REPORT';
	protected $primaryKey = 'REC_ID';
	protected $allowedFields = [];

	function getMaxDate()
	{
		$builder = $this->db->table($this->table);
		$builder->select("TO_CHAR(REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE");
		$builder->orderBy('REPORT_DATE DESC');
		$builder->limit(1);

		$data = $builder->get()->getRowArray();

		return $data['REPORT_DATE'];
	}

	function getSumDate($date,$country_id='')
	{
		$data = array();
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table);
		$builder->select(" SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ", $date);
		$builder->where('PORT_DAILY',1);
		if($country_id){
			$builder->where('COUNTRY_ID',$country_id);
		}
		$data = $builder->get()->getRowArray();
		return $data['NUM'];
	}

	function validateDate($date, $format = 'Y-m-d'){
	    $d = DateTime::createFromFormat($format, $date);
	    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
	    return $d && $d->format($format) === $date;
	}

	function getSumMonth($start_date, $end_date,$country_id='')
	{
		list($year, $month, $day) = explode('-', $start_date);
		if(!checkdate($month, $day, $year)){
			$start_date = $year.'-'.$month.'-'.($day-1);
		}

		list($year, $month, $day) = explode('-', $end_date);
		if(!checkdate($month, $day, $year)){
			$end_date = $year.'-'.$month.'-'.($day-1);
		}

		$data = array();
		$builder = $this->db->table($this->table);
		$builder->select("SUM({$this->table}.SUM) AS NUM");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		if($country_id){
			$builder->where('COUNTRY_ID',$country_id);
		}
		$data = $builder->get()->getRowArray();
		return $data['NUM'];
	}

	function getSumNatDate($date)
	{
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table);
		$builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN , SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ", $date);
		$builder->where('PORT_DAILY',1);
		$builder->groupBy("{$this->table}.COUNTRY_ID,MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN ");
		$builder->orderBy("NUM DESC");
		$data = $builder->get()->getResultArray();

		return $data;
	}

	function getSumNatMonth($start_date, $end_date)
	{
		$builder = $this->db->table($this->table);
		$builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN , SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		$builder->groupBy("{$this->table}.COUNTRY_ID,MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN ");
		$builder->orderBy("NUM DESC");
		$data = $builder->get()->getResultArray();

		return $data;
	}

	function getSumPortDate($date)
	{
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table);
		$builder->select("{$this->table}.OFFICE_ID, MD_PORT.PORT_NAME , MD_PORT.PORT_TYPE , SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ", $date);
		$builder->where('PORT_DAILY',1);
		$builder->groupBy("{$this->table}.OFFICE_ID, MD_PORT.PORT_NAME, MD_PORT.PORT_TYPE ");
		$builder->orderBy("NUM DESC");
		$data = $builder->get()->getResultArray();

		return $data;
	}

	function getSumPortMonth($start_date, $end_date)
	{
		$builder = $this->db->table($this->table);
		$builder->select("{$this->table}.OFFICE_ID, MD_PORT.PORT_NAME , MD_PORT.PORT_TYPE ,SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		$builder->groupBy("{$this->table}.OFFICE_ID, MD_PORT.PORT_NAME,MD_PORT.PORT_TYPE  ");
		$builder->orderBy("NUM DESC");
		$data = $builder->get()->getResultArray();

		return $data;
	}

	function getSumChart($to_date)
	{
		$data_chart = array();
		$builder = $this->db->table($this->table);
		$builder->select(" TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$to_date}','YYYY-MM-DD')-15 AND TO_DATE('{$to_date}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		$builder->groupBy("{$this->table}.REPORT_DATE");
		$builder->orderBy("REPORT_DATE");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['current'][$d['REPORT_DATE']] = $d['NUM'];
		}

		list($year, $month, $day) = explode('-', $to_date);
		$to_date_past = ($year - 1) . '-' . $month . '-' . $day;

		list($year, $month, $day) = explode('-', $to_date_past);
		if(!checkdate($month, $day, $year)){
			$to_date_past = $year.'-'.$month.'-'.($day-1);
		}

		$builder = $this->db->table($this->table);
		$builder->select(" TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$to_date_past}','YYYY-MM-DD')-15 AND TO_DATE('{$to_date_past}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		$builder->groupBy("{$this->table}.REPORT_DATE");
		$builder->orderBy("REPORT_DATE");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['past'][$d['REPORT_DATE']] = $d['NUM'];
		}

		return $data_chart;
	}

	function getSumChartYear($year)
	{
		$data_chart = array();
		$builder = $this->db->table($this->table);
		$builder->select(" TO_CHAR({$this->table}.REPORT_DATE,'MM') AS REPORT_MONTH, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where('PORT_DAILY',1);
		$builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') = ", $year);
		$builder->groupBy("TO_CHAR({$this->table}.REPORT_DATE,'MM') ");
		$builder->orderBy("REPORT_MONTH");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['current'][$d['REPORT_MONTH']*1] = $d['NUM'];
		}

		$builder = $this->db->table($this->table);
		$builder->select(" TO_CHAR({$this->table}.REPORT_DATE,'MM') AS REPORT_MONTH, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where('PORT_DAILY',1);
		$builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') = ", ($year-1));
		$builder->groupBy("TO_CHAR({$this->table}.REPORT_DATE,'MM') ");
		$builder->orderBy("REPORT_MONTH");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['past'][$d['REPORT_MONTH']*1] = $d['NUM'];
		}

		return $data_chart;
	}

	function getSumRegionDate($date)
	{
		$data = array();
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table);
		$builder->select("MD_COUNTRY.STD_REGION_ID, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
		$builder->join('MD_SUB_REGION', "MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ", $date);
		$builder->where('PORT_DAILY',1);
		$builder->groupBy("MD_COUNTRY.STD_REGION_ID");
		$res = $builder->get()->getResultArray();
		foreach ($res as $r) {
			$data[$r['STD_REGION_ID']] = $r['NUM'];
		}

		return $data;
	}

	function getSumRegionMonth($start_date, $end_date)
	{
		$data = array();
		$builder = $this->db->table($this->table);
		$builder->select("MD_COUNTRY.STD_REGION_ID, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->join('MD_SUB_REGION', "MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		$builder->groupBy("MD_COUNTRY.STD_REGION_ID");
		$res = $builder->get()->getResultArray();
		foreach ($res as $r) {
			$data[$r['STD_REGION_ID']] = $r['NUM'];
		}

		return $data;
	}

	function getSumCountryDate($date)
	{
		$data = array();
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table);
		$builder->select("MD_COUNTRY.COUNTRYID, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
		$builder->join('MD_SUB_REGION', "MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ", $date);
		$builder->where('PORT_DAILY',1);
		$builder->groupBy("MD_COUNTRY.COUNTRYID");
		$res = $builder->get()->getResultArray();
		foreach ($res as $r) {
			$data[$r['COUNTRYID']] = $r['NUM'];
		}

		return $data;
	}

	function getSumCountryMonth($start_date, $end_date)
	{
		$data = array();
		$builder = $this->db->table($this->table);
		$builder->select("MD_COUNTRY.COUNTRYID, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->join('MD_SUB_REGION', "MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		$builder->groupBy("MD_COUNTRY.COUNTRYID");
		$res = $builder->get()->getResultArray();
		foreach ($res as $r) {
			$data[$r['COUNTRYID']] = $r['NUM'];
		}

		return $data;
	}

	function update_country()
	{
		$builder = $this->db->table('MD_COUNTRY');
		$builder->select('COUNTRYID,COUNTRYSHORTNAMEEN');
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$c = explode(' (', $d['COUNTRYSHORTNAMEEN']);
			$th = @$c[1];
			$en = @$c[0];
			$th = @substr($th, 0, -1);
			$en = ucfirst(strtolower($en));

			echo $th . ' ' . $en . '<br>';

			$builder_set = $this->db->table('MD_COUNTRY');
			$builder_set->set('COUNTRY_NAME_TH', $th);
			$builder_set->set('COUNTRY_NAME_TH2', $th);
			$builder_set->set('COUNTRY_NAME_EN', $en);
			$builder_set->where('COUNTRYID', $d['COUNTRYID']);
			$builder_set->update();
		}
	}

	function getSubRegion()
	{
		$data = array();
		$builder = $this->db->table('MD_SUB_REGION');
		$builder->select('*');
		$builder->where('MD_SUB_REGION.IS_STANDARD', 'Y');
		$builder->orderBy('MD_SUB_REGION.REPORT_ORDER_SEQ');
		$res = $builder->get()->getResultArray();
		foreach ($res as $row) {
			$data[$row['STD_REGION_ID']][] = $row;
		}
		return $data;
	}

	################################ MONTHLY REPORT #################################

	function getSumMonthly($year)
	{
		$data = array();
		$builder = $this->db->table($this->table_month);
		$builder->select("{$this->table_month}.MONTH, SUM({$this->table_month}.NUM) AS NUM ");
		$builder->where("{$this->table_month}.YEAR", $year);
		$builder->groupBy("{$this->table_month}.MONTH");
		$builder->orderBy("{$this->table_month}.MONTH");
		$res = $builder->get()->getResultArray();
		foreach ($res as $row) {
			$data[$row['MONTH']] = $row['NUM'];
		}
		return $data;
	}

	function getSumMonthlyRegion($month, $year)
	{
		$data = array();
		$builder = $this->db->table($this->table_month);
		$builder->select("MD_COUNTRY.STD_REGION_ID, SUM({$this->table_month}.NUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
		$builder->join('MD_SUB_REGION', "MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
		$builder->where("{$this->table_month}.MONTH", $month);
		$builder->where("{$this->table_month}.YEAR", $year);
		$builder->groupBy("MD_COUNTRY.STD_REGION_ID");
		$res = $builder->get()->getResultArray();
		foreach ($res as $r) {
			$data[$r['STD_REGION_ID']] = $r['NUM'];
		}
		return $data;
	}

	function getSumMonthlyCountry($month, $year, $limit)
	{
		$data = array();
		$builder = $this->db->table($this->table_month);
		$builder->select("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN, {$this->table_month}.NUM");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
		$builder->where("{$this->table_month}.MONTH", $month);
		$builder->where("{$this->table_month}.YEAR", $year);
		$builder->orderBy('NUM DESC');
		// $builder->groupBy("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN");
		$builder->limit($limit);
		$res = $builder->get()->getResultArray();
		foreach ($res as $row) {
			$data[$row['COUNTRYID']] = $row;

			$builder_past = $this->db->table($this->table_month);
			$builder_past->select("MD_COUNTRY.COUNTRYID, SUM({$this->table_month}.NUM) AS NUM ");
			$builder_past->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
			$builder_past->where("{$this->table_month}.MONTH", $month);
			$builder_past->where("{$this->table_month}.YEAR", ($year - 1));
			$builder_past->where("{$this->table_month}.COUNTRY_ID", $row['COUNTRYID']);
			$builder_past->groupBy("MD_COUNTRY.COUNTRYID");
			$res_past = $builder_past->get()->getRowArray();


			if (@$res_past['NUM'] > 0) {
				$data[$row['COUNTRYID']]['NUM_PAST'] = $res_past['NUM'];
				$data[$row['COUNTRYID']]['CHANGE'] = $row['NUM']>0 ? number_format( ($row['NUM'] - $res_past['NUM']) / $row['NUM'] * 100, 2) . ' %' : '-';
			} else {
				$data[$row['COUNTRYID']]['NUM_PAST'] = 0;
				$data[$row['COUNTRYID']]['CHANGE'] = '-';
			}
		}

		return $data;
	}

	function getSumMonthlyRegionPeriod($month, $month2, $year)
	{

		$data = array();
		$builder = $this->db->table($this->table_month);
		$builder->select("MD_COUNTRY.STD_REGION_ID, SUM({$this->table_month}.NUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
		$builder->join('MD_SUB_REGION', "MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
		$builder->where("{$this->table_month}.MONTH >=", $month);
		$builder->where("{$this->table_month}.MONTH <=", $month2);
		$builder->where("{$this->table_month}.YEAR", $year);
		$builder->groupBy("MD_COUNTRY.STD_REGION_ID");
		$res = $builder->get()->getResultArray();
		foreach ($res as $r) {
			$data[$r['STD_REGION_ID']] = $r['NUM'];
		}
		return $data;
	}

	/**
	 * ดึงยอดรวม region จาก REPORT_CAL_DAILY ตาม date range (สำหรับเดือนที่ยังไม่ครบ)
	 */
	function getSumDailyRegionByDateRange($startDate, $endDate)
	{
		$data = array();
		$builder = $this->db->table($this->table);
		$builder->select("MD_COUNTRY.STD_REGION_ID, SUM({$this->table}.SUM) AS NUM");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
		$builder->join('MD_SUB_REGION', "MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$startDate}','YYYY-MM-DD') AND TO_DATE('{$endDate}','YYYY-MM-DD')");
		$builder->where('PORT_DAILY', 1);
		$builder->groupBy("MD_COUNTRY.STD_REGION_ID");
		$res = $builder->get()->getResultArray();
		foreach ($res as $r) {
			$data[$r['STD_REGION_ID']] = $r['NUM'];
		}
		return $data;
	}

	/**
	 * ดึง Top ประเทศจาก REPORT_CAL_DAILY ตาม date range (สำหรับเดือนที่ยังไม่ครบ)
	 * คืน array key=COUNTRYID => ['COUNTRYID','COUNTRY_NAME_EN','NUM']
	 */
	function getSumDailyCountryByDateRange($startDate, $endDate)
	{
		$data = array();
		$builder = $this->db->table($this->table);
		$builder->select("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN, SUM({$this->table}.SUM) AS NUM");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$startDate}','YYYY-MM-DD') AND TO_DATE('{$endDate}','YYYY-MM-DD')");
		$builder->where('PORT_DAILY', 1);
		$builder->groupBy("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN");
		$res = $builder->get()->getResultArray();
		foreach ($res as $row) {
			$data[$row['COUNTRYID']] = $row;
		}
		return $data;
	}

	/**
	 * ดึงยอดรวมรายประเทศจาก monthly table (ไม่ query ปีก่อน)
	 * คืน array key=COUNTRYID => ['COUNTRYID','COUNTRY_NAME_EN','NUM']
	 */
	function getSumMonthlyCountryPeriodSimple($month, $month2, $year)
	{
		$data = array();
		$builder = $this->db->table($this->table_month);
		$builder->select("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN, SUM({$this->table_month}.NUM) AS NUM");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
		$builder->where("{$this->table_month}.MONTH >=", $month);
		$builder->where("{$this->table_month}.MONTH <=", $month2);
		$builder->where("{$this->table_month}.YEAR", $year);
		$builder->groupBy("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN");
		$res = $builder->get()->getResultArray();
		foreach ($res as $row) {
			$data[$row['COUNTRYID']] = $row;
		}
		return $data;
	}

	function getSumMonthlyCountryPeriod($month, $month2, $year, $limit)
	{
		$data = array();
		$builder = $this->db->table($this->table_month);
		$builder->select("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN, SUM({$this->table_month}.NUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
		$builder->where("{$this->table_month}.MONTH >=", $month);
		$builder->where("{$this->table_month}.MONTH <=", $month2);
		$builder->where("{$this->table_month}.YEAR", $year);
		$builder->orderBy('NUM DESC');
		$builder->groupBy("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN");
		$builder->limit($limit);
		$res = $builder->get()->getResultArray();
		foreach ($res as $row) {
			$data[$row['COUNTRYID']] = $row;

			$builder_past = $this->db->table($this->table_month);
			$builder_past->select("MD_COUNTRY.COUNTRYID, SUM({$this->table_month}.NUM) AS NUM ");
			$builder_past->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
			$builder_past->where("{$this->table_month}.MONTH >=", $month);
			$builder_past->where("{$this->table_month}.MONTH <=", $month2);
			$builder_past->where("{$this->table_month}.YEAR", ($year - 1));
			$builder_past->where("{$this->table_month}.COUNTRY_ID", $row['COUNTRYID']);
			$builder_past->groupBy("MD_COUNTRY.COUNTRYID");
			$res_past = $builder_past->get()->getRowArray();


			if (@$res_past['NUM'] > 0) {
				$data[$row['COUNTRYID']]['NUM_PAST'] = $res_past['NUM'];
				$data[$row['COUNTRYID']]['CHANGE'] = $row['NUM']>0 ? number_format( ($row['NUM'] - $res_past['NUM']) / $row['NUM'] * 100, 2) . ' %' : '-';
			} else {
				$data[$row['COUNTRYID']]['CHANGE'] = '-';
			}
		}

		return $data;
	}

	function saveLog($type,$ip,$session){
		$date_export = date('Y-m-d H:i:s');

		$builder = $this->db->table('LOG_EXPORT_INFO');
		$builder->set('USER_ID',$session->get('user_id'));
		$builder->set('USERNAME',$session->get('username'));
		$builder->set('ORG_ID',$session->get('org_id'));
		$builder->set('DATE_EXPORT', 'to_date(' . '\'' . $date_export . '\'' . ',\'YYYY-MM-DD hh24:mi:ss\')', false);
		$builder->set('IP_ADDRESS',$ip);
		$builder->set('TYPE_EXPORT',$type);
		$builder->insert();

		return true;
	}

	function saveLogLogin($type,$ip,$session){
		$date_export = date('Y-m-d H:i:s');

		$builder = $this->db->table('LOG_LOGIN');
		$builder->set('USER_ID',$session->get('user_id'));
		$builder->set('USERNAME',$session->get('username'));
		$builder->set('ORG_ID',$session->get('org_id'));
		$builder->set('DATE_LOGIN', 'to_date(' . '\'' . $date_export . '\'' . ',\'YYYY-MM-DD hh24:mi:ss\')', false);
		$builder->set('IP_ADDRESS',$ip);
		$builder->set('LOG_TYPE',$type);
		$builder->insert();

		return true;
	}

	######################## OUT #############################
	function getSumOutDate($date)
	{
		$data = array();
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table_out);
		$builder->select(" SUM({$this->table_out}.NUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("TO_CHAR( {$this->table_out}.REPORT_DATE, 'YYYY-MM-DD') = ", $date);
		$builder->where('PORT_DAILY',1);
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		$data = $builder->get()->getRowArray();
		return $data['NUM'];
	}

	function getSumOutSumPort($year)
	{
		$builder = $this->db->table($this->table_out);
		$builder->select(" SUM({$this->table_out}.NUM) AS NUM, MD_PORT.PORT_ID, MD_PORT.PORT_NAME, MD_PORT.PORT_TYPE ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("TO_CHAR( {$this->table_out}.REPORT_DATE, 'YYYY') = ", $year);
		$builder->where('PORT_DAILY',1);
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		$builder->groupBy('MD_PORT.PORT_ID, MD_PORT.PORT_NAME, MD_PORT.PORT_TYPE');
		$builder->orderBy('NUM','DESC');
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['SUM_PORT'][$d['PORT_ID']]['PORT_ID'] = $d['PORT_ID'];
			$data_chart['SUM_PORT'][$d['PORT_ID']]['PORT_NAME'] = $d['PORT_NAME'];
			$data_chart['SUM_PORT'][$d['PORT_ID']]['NUM'] = $d['NUM'];
			@$data_chart['SUM_TYPE'][$d['PORT_TYPE']] += $d['NUM'];
		}

		return $data_chart;
	}

	function getSumOutMonth($start_date, $end_date)
	{
		list($year, $month, $day) = explode('-', $start_date);
		if(!checkdate($month, $day, $year)){
			$start_date = $year.'-'.$month.'-'.($day-1);
		}

		list($year, $month, $day) = explode('-', $end_date);
		if(!checkdate($month, $day, $year)){
			$end_date = $year.'-'.$month.'-'.($day-1);
		}

		$data = array();
		$builder = $this->db->table($this->table_out);
		$builder->select("SUM({$this->table_out}.NUM) AS NUM");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		$data = $builder->get()->getRowArray();
		return $data['NUM'];
	}

	function getSumOutChart($to_date,$port_type='')
	{
		$data_chart = array();
		$builder = $this->db->table($this->table_out);
		$builder->select(" TO_CHAR({$this->table_out}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table_out}.NUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID  ");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$to_date}','YYYY-MM-DD')-15 AND TO_DATE('{$to_date}','YYYY-MM-DD') ");
		// $builder->where('PORT_DAILY',1);
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		if($port_type){
			$builder->where('PORT_TYPE',$port_type);
		}
		$builder->groupBy("{$this->table_out}.REPORT_DATE");
		$builder->orderBy("REPORT_DATE");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['current'][$d['REPORT_DATE']] = $d['NUM'];
		}

		list($year, $month, $day) = explode('-', $to_date);
		$to_date_past = ($year - 1) . '-' . $month . '-' . $day;

		list($year, $month, $day) = explode('-', $to_date_past);
		if(!checkdate($month, $day, $year)){
			$to_date_past = $year.'-'.$month.'-'.($day-1);
		}

		$builder = $this->db->table($this->table_out);
		$builder->select(" TO_CHAR({$this->table_out}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table_out}.NUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID ");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$to_date_past}','YYYY-MM-DD')-15 AND TO_DATE('{$to_date_past}','YYYY-MM-DD') ");
		// $builder->where('PORT_DAILY',1);
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		if($port_type){
			$builder->where('PORT_TYPE',$port_type);
		}
		$builder->groupBy("{$this->table_out}.REPORT_DATE");
		$builder->orderBy("REPORT_DATE");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['past'][$d['REPORT_DATE']] = $d['NUM'];
		}

		return $data_chart;
	}

	function getSumOutChartYear($year,$port_type='')
	{
		$data_chart = array();
		$builder = $this->db->table($this->table_out);
		$builder->select(" TO_CHAR({$this->table_out}.REPORT_DATE,'MM') AS REPORT_MONTH, SUM({$this->table_out}.NUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID  ");
		// $builder->where('PORT_DAILY',1);
		$builder->where("TO_CHAR( {$this->table_out}.REPORT_DATE, 'YYYY') = ", $year);
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		if($port_type){
			$builder->where('PORT_TYPE',$port_type);
		}
		$builder->groupBy("TO_CHAR({$this->table_out}.REPORT_DATE,'MM') ");
		$builder->orderBy("REPORT_MONTH");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['current'][($d['REPORT_MONTH']*1)-1] = $d['NUM'];
		}

		$builder = $this->db->table($this->table_out);
		$builder->select(" TO_CHAR({$this->table_out}.REPORT_DATE,'MM') AS REPORT_MONTH, SUM({$this->table_out}.NUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID  ");
		// $builder->where('PORT_DAILY',1);
		$builder->where("TO_CHAR( {$this->table_out}.REPORT_DATE, 'YYYY') = ", ($year-1));
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		if($port_type){
			$builder->where('PORT_TYPE',$port_type);
		}
		$builder->groupBy("TO_CHAR({$this->table_out}.REPORT_DATE,'MM') ");
		$builder->orderBy("REPORT_MONTH");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['past'][($d['REPORT_MONTH']*1)-1] = $d['NUM'];
		}

		return $data_chart;
	}

	function getSumPortType($start_date, $end_date,$country_id='')
	{
		$builder = $this->db->table($this->table);
		$builder->select("MD_PORT.PORT_TYPE ,SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		if($country_id){
			$builder->where('COUNTRY_ID',$country_id);
		}
		$builder->groupBy("MD_PORT.PORT_TYPE ");
		$data = $builder->get()->getResultArray();

		return $data;
	}

	function getSumChartCountry($to_date,$country_id)
	{
		$data_chart = array();
		$builder = $this->db->table($this->table);
		$builder->select(" TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$to_date}','YYYY-MM-DD')-30 AND TO_DATE('{$to_date}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		$builder->where('COUNTRY_ID',$country_id);
		$builder->groupBy("{$this->table}.REPORT_DATE");
		$builder->orderBy("REPORT_DATE");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['current'][$d['REPORT_DATE']] = $d['NUM'];
		}

		list($year, $month, $day) = explode('-', $to_date);
		$to_date_past = ($year - 1) . '-' . $month . '-' . $day;

		list($year, $month, $day) = explode('-', $to_date_past);
		if(!checkdate($month, $day, $year)){
			$to_date_past = $year.'-'.$month.'-'.($day-1);
		}

		$builder = $this->db->table($this->table);
		$builder->select(" TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$to_date_past}','YYYY-MM-DD')-30 AND TO_DATE('{$to_date_past}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY',1);
		$builder->where('COUNTRY_ID',$country_id);
		$builder->groupBy("{$this->table}.REPORT_DATE");
		$builder->orderBy("REPORT_DATE");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['past'][$d['REPORT_DATE']] = $d['NUM'];
		}

		return $data_chart;
	}

	function getOuterChartDate($year){
		$data_chart = array();
		$builder = $this->db->table($this->table_out);
		$builder->select("
		    (CAST(ROUND(({$this->table_out}.REPORT_DATE - DATE '1970-01-01') * 86400000) AS NUMBER)) AS DATE_GROUP, 
		    SUM({$this->table_out}.NUM) AS NUM
		");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID ");
		$builder->where("TO_CHAR({$this->table_out}.REPORT_DATE, 'YYYY') =", $year);
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		$builder->groupBy("(CAST(ROUND(({$this->table_out}.REPORT_DATE - DATE '1970-01-01') * 86400000) AS NUMBER))");
		$builder->orderBy("DATE_GROUP");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['current'][$d['DATE_GROUP']] = $d['NUM'];
		}

		$builder = $this->db->table($this->table_out);
		$builder->select("
		    (CAST(ROUND(({$this->table_out}.REPORT_DATE - DATE '1970-01-01') * 86400000) AS NUMBER)) AS DATE_GROUP, 
		    SUM({$this->table_out}.NUM) AS NUM
		");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID ");
		$builder->where('PORT_TYPE', 'ด่านอากาศ');
		$builder->where("TO_CHAR({$this->table_out}.REPORT_DATE, 'YYYY') =", $year);
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		$builder->groupBy("(CAST(ROUND(({$this->table_out}.REPORT_DATE - DATE '1970-01-01') * 86400000) AS NUMBER))");
		$builder->orderBy("DATE_GROUP");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['current_air'][$d['DATE_GROUP']] = $d['NUM'];
		}

		$builder = $this->db->table($this->table_out);
		$builder->select("
		    (CAST(ROUND((ADD_MONTHS({$this->table_out}.REPORT_DATE, +12) - DATE '1970-01-01') * 86400000) AS NUMBER)) AS DATE_GROUP, 
		    SUM({$this->table_out}.NUM) AS NUM
		");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID ");
		$builder->where("TO_CHAR({$this->table_out}.REPORT_DATE, 'YYYY') = ", $year-1);
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		$builder->groupBy("(CAST(ROUND((ADD_MONTHS({$this->table_out}.REPORT_DATE, +12) - DATE '1970-01-01') * 86400000) AS NUMBER))");
		$builder->orderBy("DATE_GROUP");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['past'][$d['DATE_GROUP']] = $d['NUM'];
		}

		return $data_chart;
	}

	function getSumChartRegion($to_date, $region_ids)
	{
		$data_chart = array();
		$region_list = implode(',', $region_ids);

		$builder = $this->db->table($this->table);
		$builder->select(" TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
		$builder->join('MD_SUB_REGION', "MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$to_date}','YYYY-MM-DD')-30 AND TO_DATE('{$to_date}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY', 1);
		$builder->where("MD_COUNTRY.STD_REGION_ID IN ({$region_list})");
		$builder->groupBy("{$this->table}.REPORT_DATE");
		$builder->orderBy("REPORT_DATE");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['current'][$d['REPORT_DATE']] = $d['NUM'];
		}

		list($year, $month, $day) = explode('-', $to_date);
		$to_date_past = ($year - 1) . '-' . $month . '-' . $day;

		list($year, $month, $day) = explode('-', $to_date_past);
		if (!checkdate($month, $day, $year)) {
			$to_date_past = $year . '-' . $month . '-' . ($day - 1);
		}

		$builder = $this->db->table($this->table);
		$builder->select(" TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table}.SUM) AS NUM ");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
		$builder->join('MD_SUB_REGION', "MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table}.OFFICE_ID AND PORT_CATEGORY_ID = 1");
		$builder->where("REPORT_DATE BETWEEN TO_DATE('{$to_date_past}','YYYY-MM-DD')-30 AND TO_DATE('{$to_date_past}','YYYY-MM-DD') ");
		$builder->where('PORT_DAILY', 1);
		$builder->where("MD_COUNTRY.STD_REGION_ID IN ({$region_list})");
		$builder->groupBy("{$this->table}.REPORT_DATE");
		$builder->orderBy("REPORT_DATE");
		$data = $builder->get()->getResultArray();
		foreach ($data as $d) {
			$data_chart['past'][$d['REPORT_DATE']] = $d['NUM'];
		}

		return $data_chart;
	}

	// =====================================================================
	// Forecast_inter helpers — pull monthly history for overall/region/country
	// =====================================================================

	/**
	 * ดึง monthly arrivals รายภูมิภาค (STD_REGION_ID) ของปี ใช้ใน forecast_inter
	 * คืน [ month => [ std_region_id => NUM ] ]
	 */
	function getSumMonthlyRegionByYear($year)
	{
		$data = array();
		$builder = $this->db->table($this->table_month);
		$builder->select("{$this->table_month}.MONTH, MD_COUNTRY.STD_REGION_ID, SUM({$this->table_month}.NUM) AS NUM");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
		$builder->where("{$this->table_month}.YEAR", $year);
		$builder->groupBy("{$this->table_month}.MONTH, MD_COUNTRY.STD_REGION_ID");
		$res = $builder->get()->getResultArray();
		foreach ($res as $r) {
			$m = (int)$r['MONTH'];
			$rid = (int)$r['STD_REGION_ID'];
			if (!isset($data[$m])) $data[$m] = array();
			$data[$m][$rid] = (float)$r['NUM'];
		}
		return $data;
	}

	/**
	 * ดึง monthly arrivals รายประเทศของปี
	 * คืน [ country_id => [ 'name' => ..., 'monthly' => [m => NUM] ] ]
	 */
	function getSumMonthlyCountryByYear($year)
	{
		$data = array();
		$builder = $this->db->table($this->table_month);
		$builder->select("{$this->table_month}.MONTH, {$this->table_month}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN, SUM({$this->table_month}.NUM) AS NUM");
		$builder->join('MD_COUNTRY', "MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
		$builder->where("{$this->table_month}.YEAR", $year);
		$builder->groupBy("{$this->table_month}.MONTH, {$this->table_month}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN");
		$res = $builder->get()->getResultArray();
		foreach ($res as $r) {
			$cid = (int)$r['COUNTRY_ID'];
			$m = (int)$r['MONTH'];
			if (!isset($data[$cid])) {
				$data[$cid] = array('name' => $r['COUNTRY_NAME_EN'], 'monthly' => array());
			}
			$data[$cid]['monthly'][$m] = (float)$r['NUM'];
		}
		return $data;
	}

	/**
	 * รวม sentiment จาก INTER_SENTIMENT (TAT project)
	 * Impact: 1=positive, 2=negative, 3=neutral
	 * คืน [ 'markets' => [ market_id => ['pos'=>n, 'neg'=>n, 'neu'=>n, 'score'=>, 'total'=>] ],
	 *        'overall' => [ 'pos'=>, 'neg'=>, 'neu'=>, 'score'=>, 'total'=> ] ]
	 */
	function getInterSentimentAggregate($year, $month_start = null, $month_end = null)
	{
		$result = array('markets' => array(), 'overall' => array('pos'=>0,'neg'=>0,'neu'=>0,'total'=>0,'score'=>0));
		try {
			$builder = $this->db->table('INTER_SENTIMENT');
			$builder->select('MARKET_ID, SENTIMENT_IMPACT, COUNT(*) AS CNT');
			$builder->where('YEAR', $year);
			if ($month_start !== null) $builder->where('MONTH >=', $month_start);
			if ($month_end !== null) $builder->where('MONTH <=', $month_end);
			$builder->groupBy('MARKET_ID, SENTIMENT_IMPACT');
			$rows = $builder->get()->getResultArray();
			foreach ($rows as $r) {
				$mid = (int)$r['MARKET_ID'];
				$imp = (int)$r['SENTIMENT_IMPACT'];
				$cnt = (int)$r['CNT'];
				if (!isset($result['markets'][$mid])) {
					$result['markets'][$mid] = array('pos'=>0,'neg'=>0,'neu'=>0,'total'=>0,'score'=>0);
				}
				if ($imp == 1) $result['markets'][$mid]['pos'] += $cnt;
				else if ($imp == 2) $result['markets'][$mid]['neg'] += $cnt;
				else if ($imp == 3) $result['markets'][$mid]['neu'] += $cnt;
				$result['markets'][$mid]['total'] += $cnt;
				if ($imp == 1) $result['overall']['pos'] += $cnt;
				else if ($imp == 2) $result['overall']['neg'] += $cnt;
				else if ($imp == 3) $result['overall']['neu'] += $cnt;
				$result['overall']['total'] += $cnt;
			}
			foreach ($result['markets'] as $mid => $d) {
				$t = max(1, $d['total']);
				$result['markets'][$mid]['score'] = round(($d['pos'] - $d['neg']) / $t * 100, 2);
			}
			$t = max(1, $result['overall']['total']);
			$result['overall']['score'] = round(($result['overall']['pos'] - $result['overall']['neg']) / $t * 100, 2);
		} catch (\Throwable $e) {
			// DB/schema missing — fallback ค่าว่าง
		}
		return $result;
	}

	/**
	 * ดึงรายชื่อ market ทั้งหมด พร้อม country_id mapping — ใช้ join ชื่อประเทศ
	 * คืน [ market_id => ['name'=>..., 'country_id'=>..., 'country_name_en'=>...] ]
	 */
	function getMarketMap()
	{
		$out = array();
		try {
			$builder = $this->db->table('MD_DEP_MARKET');
			$builder->select('MD_DEP_MARKET.MARKET_ID, MD_DEP_MARKET.MARKET_NAME, MD_DEP_MARKET.MARKET_COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN');
			$builder->join('MD_COUNTRY', 'MD_COUNTRY.COUNTRYID = MD_DEP_MARKET.MARKET_COUNTRY_ID', 'left');
			$rows = $builder->get()->getResultArray();
			foreach ($rows as $r) {
				$out[(int)$r['MARKET_ID']] = array(
					'name' => $r['MARKET_NAME'],
					'country_id' => (int)$r['MARKET_COUNTRY_ID'],
					'country_name_en' => $r['COUNTRY_NAME_EN'],
				);
			}
		} catch (\Throwable $e) {}
		return $out;
	}

}
