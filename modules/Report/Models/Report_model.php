<?php
namespace Modules\Report\Models;
use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Mydate;
use App\Libraries\Hash;
class Report_model extends Model
{
	protected $table = 'REPORT_CAL_DAILY';//CAL_SUM_DATA_REPORT
	protected $table_out = 'REPORT_RAW_DATA';
  	protected $primaryKey = 'REC_ID';
  	protected $allowedFields = [];

  	function getNationReport($date){
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$date);
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.COUNTRY_ID,MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("NUM DESC");
	    $data = $builder->get()->getResultArray();

	    return $data;
  	}

  	function getNatDateData($date){
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN , SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$date);
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.COUNTRY_ID,MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("NUM DESC");
	    $data = $builder->get()->getResultArray();

	    return $data;
  	}

	function getNatMonthData($day,$month,$year){
		$date_start = '01/01/'.$year;
		$date_end = $day.'/'.$month.'/'.$year;
		$builder = $this->db->table($this->table);


		list($day, $month, $year) = explode('/', $date_end);
		if(!checkdate($month, $day, $year)){
			$date_end = ($day-1).'/'.$month.'/'.$year;
		}


	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN , SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    // $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'DD') <= ",$day);
	    // $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'MM') <= ",$month);
	    // $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') = ",$year);
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$date_start}','dd/mm/yyyy') AND TO_DATE('{$date_end}','dd/mm/yyyy') ");
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.COUNTRY_ID,MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("NUM DESC");
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getPortDateData($date){
		$builder = $this->db->table('MD_PORT');
	    $builder->select("MD_PORT.PORT_ID, MD_PORT.PORT_NAME , MD_PORT.PORT_TYPE , MD_PORT.PORT_LATLONG,
	    					CASE WHEN SUM({$this->table}.SUM ) IS NOT NULL THEN  SUM({$this->table}.SUM ) ELSE 0 END AS NUM ");
	   
	    $builder->join($this->table,"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID AND TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = '{$date}' ",'LEFT');
	    $builder->where('MD_PORT.PORT_CATEGORY_ID',1);
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("MD_PORT.PORT_ID, MD_PORT.PORT_NAME, MD_PORT.PORT_TYPE, MD_PORT.PORT_LATLONG ");
	    $builder->orderBy("NUM DESC,PORT_NAME");
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getPortMonthData($day,$month,$year){
		$date_start = '01/01/'.$year;
		$date_end = $day.'/'.$month.'/'.$year;

		list($day, $month, $year) = explode('/', $date_end);
		if(!checkdate($month, $day, $year)){
			$date_end = ($day-1).'/'.$month.'/'.$year;
		}

	    $builder = $this->db->table('MD_PORT');
	    $builder->select("MD_PORT.PORT_ID, MD_PORT.PORT_NAME , MD_PORT.PORT_TYPE , MD_PORT.PORT_LATLONG,
	    					CASE WHEN SUM({$this->table}.SUM ) IS NOT NULL THEN  SUM({$this->table}.SUM ) ELSE 0 END AS NUM ");
	    $builder->join($this->table,"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$date_start}','dd/mm/yyyy') AND TO_DATE('{$date_end}','dd/mm/yyyy') ");
	    $builder->where('MD_PORT.PORT_CATEGORY_ID',1);
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("MD_PORT.PORT_ID, MD_PORT.PORT_NAME,MD_PORT.PORT_TYPE , MD_PORT.PORT_LATLONG ");
	    $builder->orderBy("NUM DESC,PORT_NAME");
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getPortDaily($date_start,$date_end){
		$data_daily = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.OFFICE_ID, TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$date_start}','dd/mm/yyyy') AND TO_DATE('{$date_end}','dd/mm/yyyy') ");
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.REPORT_DATE,{$this->table}.OFFICE_ID");
	    $builder->orderBy("REPORT_DATE");
	    $data = $builder->get()->getResultArray();
	    foreach($data as $d){
	    	$data_daily[$d['OFFICE_ID']][$d['REPORT_DATE']] = $d['NUM'];
	    }

	    return $data_daily;
	}

	function getPortMonthly($year,$m_start,$m_end){
		$data_daily = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.OFFICE_ID, TO_CHAR({$this->table}.REPORT_DATE,'MM') AS REPORT_MONTH, SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$m_start}','mm') AND TO_DATE('{$m_end}','mm') ");
	    $builder->where("TO_CHAR(REPORT_DATE,'yyyy') ",$year);
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("TO_CHAR({$this->table}.REPORT_DATE,'MM'),{$this->table}.OFFICE_ID");
	    $builder->orderBy("REPORT_MONTH");
	    // echo $builder->getCompiledSelect();

	    $data = $builder->get()->getResultArray();
	    foreach($data as $d){
	    	$data_daily[$d['OFFICE_ID']][$d['REPORT_MONTH']*1] = $d['NUM'];
	    }

	    return $data_daily;
	}

	function getNatDaily($date_start,$date_end){
		$data_daily = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$date_start}','dd/mm/yyyy') AND TO_DATE('{$date_end}','dd/mm/yyyy') ");
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.REPORT_DATE,{$this->table}.COUNTRY_ID");
	    $builder->orderBy("REPORT_DATE");
	    $data = $builder->get()->getResultArray();
	    foreach($data as $d){
	    	$data_daily[$d['COUNTRY_ID']][$d['REPORT_DATE']] = $d['NUM'];
	    }

	    return $data_daily;
	}

	function getCountryForNatDaily($date_start,$date_end){
		$data = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID  ");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$date_start}','dd/mm/yyyy') AND TO_DATE('{$date_end}','dd/mm/yyyy') ");
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("MD_COUNTRY.COUNTRY_NAME_EN,{$this->table}.COUNTRY_ID");
	    $builder->orderBy("COUNTRY_NAME_EN");
	    $data = $builder->get()->getResultArray();
	    return $data;
	}

	function getNatBetweenDateData($start_date,$end_date,$country_type,$country_id){
		$data = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN, SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','dd-mm-yyyy') AND TO_DATE('{$end_date}','dd-mm-yyyy') ");
	    if($country_type=='standard'){
	    	// $builder->where('MD_COUNTRY.IS_STANDARD','Y');
	    }	
	    if($country_id!==''){
	    	$builder->where("{$this->table}.COUNTRY_ID",$country_id);
	    }
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("COUNTRY_NAME_EN");
	    // $builder->orderBy("NUM DESC");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $row){
	    	$data[$row['COUNTRY_ID']] = $row;
	    }
	    return $data;
  	}

  	function getPortCompareData($start_date,$end_date,$country_type,$port_type,$country_id){
  		$data = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_PORT.PORT_ID, TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE , MD_COUNTRY.COUNTRY_NAME_EN , 
	    					 SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->whereIn("{$this->table}.OFFICE_ID",$port_type);
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','dd-mm-yyyy') AND TO_DATE('{$end_date}','dd-mm-yyyy') ");
	    if($country_type=='standard'){
	    	// $builder->where('MD_COUNTRY.IS_STANDARD','Y');
	    }	

	    if($country_id!==''){
	    	$builder->where("{$this->table}.COUNTRY_ID",$country_id);
	    }
	    
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.COUNTRY_ID, MD_PORT.PORT_ID, {$this->table}.REPORT_DATE,MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("COUNTRY_NAME_EN");
	    // $builder->orderBy("NUM DESC");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $row){
	    	$data[$row['COUNTRY_ID']][$row['PORT_ID']][$row['REPORT_DATE']] = $row;
	    }
	    return $data;
  	}

  	function getPortCompareDataMonthly($year,$m_start,$m_end,$country_type,$port_type,$country_id){
  		$data = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_PORT.PORT_ID, TO_CHAR({$this->table}.REPORT_DATE,'MM') AS REPORT_MONTH , MD_COUNTRY.COUNTRY_NAME_EN , 
	    					 SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->whereIn("{$this->table}.OFFICE_ID",$port_type);
	    // $builder->where("REPORT_DATE BETWEEN TO_DATE('{$m_start}','mm') AND TO_DATE('{$m_end}','mm') ");
	    $builder->where("TO_CHAR(REPORT_DATE,'yyyy') ",$year);
	    if($country_type=='standard'){
	    	// $builder->where('MD_COUNTRY.IS_STANDARD','Y');
	    }	

	    if($country_id!==''){
	    	$builder->where("{$this->table}.COUNTRY_ID",$country_id);
	    }
	    
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.COUNTRY_ID, MD_PORT.PORT_ID, TO_CHAR({$this->table}.REPORT_DATE,'MM'),MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("COUNTRY_NAME_EN");
	    // $builder->orderBy("NUM DESC");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $row){
	    	$data[$row['COUNTRY_ID']][$row['PORT_ID']][$row['REPORT_MONTH']*1] = $row;
	    }
	    return $data;
  	}

  	function getCountryAllRow(){
		$builder = $this->db->table('MD_COUNTRY');
	    $builder->select("MD_COUNTRY.COUNTRYID AS COUNTRY_ID,  MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->where('MARKET_TYPE is not null');
	    $builder->orderBy("COUNTRY_NAME_EN");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $row){
	    	$data[$row['COUNTRY_ID']] = $row['COUNTRY_NAME_EN'];
	    }
	    return $data;
  	}

  	function getCountryCompareRow($start_date,$end_date,$country_type,$port_type){
  		$data = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID,  MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->whereIn("{$this->table}.OFFICE_ID",$port_type);
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','dd-mm-yyyy') AND TO_DATE('{$end_date}','dd-mm-yyyy') ");
	    if($country_type=='standard'){
	    	// $builder->where('MD_COUNTRY.IS_STANDARD','Y');
	    }	
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("COUNTRY_NAME_EN");
	    // $builder->orderBy("NUM DESC");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $row){
	    	$data[$row['COUNTRY_ID']] = $row['COUNTRY_NAME_EN'];
	    }
	    return $data;
  	}

  	function getCountryCompareRowMonthly($year,$m_start,$m_end,$country_type,$port_type){
  		$data = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID,  MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->whereIn("{$this->table}.OFFICE_ID",$port_type);
	    // $builder->where("REPORT_DATE BETWEEN TO_DATE('{$m_start}','mm') AND TO_DATE('{$m_end}','mm') ");
	    $builder->where("TO_CHAR(REPORT_DATE,'yyyy') ",$year);
	    if($country_type=='standard'){
	    	// $builder->where('MD_COUNTRY.IS_STANDARD','Y');
	    }	
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("COUNTRY_NAME_EN");
	    // $builder->orderBy("NUM DESC");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $row){
	    	$data[$row['COUNTRY_ID']] = $row['COUNTRY_NAME_EN'];
	    }
	    return $data;
  	}

  	function getPortColunm($port_type){
  		$data = array();
		$builder = $this->db->table('MD_PORT');
		$builder->select('*');
		$builder->where('PORT_CATEGORY_ID',1);
		$builder->where('PORT_DAILY',1);
		$builder->whereIn("PORT_ID",$port_type);
		$builder->orderBy('PORT_TYPE_ID,PORT_NAME');
		$res = $builder->get()->getResultArray();
	    return $res;
  	}

	function getPortGroupType(){
		$data = array();
		$builder = $this->db->table('MD_PORT');
		$builder->select('*');
		$builder->where('PORT_CATEGORY_ID',1);
		$builder->where('PORT_DAILY',1);
		$builder->orderBy('PORT_NAME');
		$res = $builder->get()->getResultArray();
	    foreach($res as $r){
	    	$data[$r['PORT_TYPE_ID']][] = $r; 
	    }

	    return $data;
	}

	function getSTDRegion($standard=''){
		$data = array();
		$builder = $this->db->table('MD_STD_REGION');
		$builder->select('*');
		if($standard=='standard'){
			$builder->where('IS_STANDARD','Y');
		}else{
			$builder->where('IS_OTHERS','N');
		}
		$builder->orderBy('MD_REPORT_ORDER_SEQ');
		$res = $builder->get()->getResultArray();
		foreach($res as $row){
			$data[$row['PARENT_ID']][] = $row;
		}
	    return $data;
	}

	function getCountryByRegion($standard=''){
		$data = array();
		$builder = $this->db->table('MD_COUNTRY');
		$builder->select('COUNTRYID,STDREGIONID,REGIONID,IS_STANDARD,IS_MASTER,STD_REGION_ID,COUNTRY_NAME_TH,COUNTRY_NAME_EN,MARKET_TYPE');
		if($standard=='standard'){
			// $builder->where('IS_STANDARD','Y');
		}
		$builder->where('IS_MASTER','Y');
		$builder->orderBy('COUNTRY_NAME_EN');
		$res = $builder->get()->getResultArray();
		foreach($res as $row){
			if($standard=='standard'){
				$data[$row['STD_REGION_ID']][$row['COUNTRYID']] = $row;
			}else{
				$data[$row['REGIONID']][$row['COUNTRYID']] = $row;
			}
		}
	    return $data;
	}

	function getCountryByMarket(){
		$data = array();
		$builder = $this->db->table('MD_COUNTRY');
		$builder->select('*');
		$builder->where('IS_MASTER','Y');
		$builder->orderBy('COUNTRY_NAME_EN');
		$res = $builder->get()->getResultArray();
		foreach($res as $row){
			$data[$row['MARKET_TYPE']][$row['COUNTRYID']] = $row;
		}
	    return $data;
	}

	function getMarketData($start_date,$end_date){
		$data = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN , SUM({$this->table}.SUM) AS NUM,MARKET_TYPE ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','dd-mm-yyyy') AND TO_DATE('{$end_date}','dd-mm-yyyy') ");	
	    $builder->where('PORT_DAILY',1);
	    $builder->groupBy("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN,MARKET_TYPE ");
	    $builder->orderBy("NUM DESC");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $row){
	    	$data[$row['MARKET_TYPE']][] = $row;
	    	// @$data[$row['MARKET_TYPE']]['SUM'] += $row['NUM'];
	    }
	    return $data;
	}

	function getPortGroupTypeMonthly(){
		$data = array();
		$builder = $this->db->table('MD_PORT');
		$builder->select('MD_PORT.PORT_ID,MD_PORT.PORT_NAME_FULL,PORT_ORDER_MONTHLY,MD_PORT.PORT_TYPE_ID');
		$builder->join('REPORT_RAW_MONTHLY','REPORT_RAW_MONTHLY.PORT_ID = MD_PORT.PORT_ID','LEFT');
		$builder->where('PORT_MONTHLY',1);
		$builder->where('MD_PORT.PORT_NAME_FULL is not null');
		$builder->orderby('PORT_ORDER_MONTHLY');
		$builder->groupBy('MD_PORT.PORT_ID,MD_PORT.PORT_NAME_FULL,PORT_ORDER_MONTHLY,MD_PORT.PORT_TYPE_ID');
		$res = $builder->get()->getResultArray();
	    foreach($res as $r){
	    	$data[$r['PORT_TYPE_ID']][] = $r; 
	    }

	    return $data;
	}

	function getDepartureDaily($year,$port_type=''){
		$data = array();
		$builder = $this->db->table($this->table_out);
		$builder->select(" TO_CHAR({$this->table_out}.REPORT_DATE,'DD-MM-YYYY') AS REPORT_DATE,
						   SUM({$this->table_out}.NUM) AS NUM ");
		$builder->join('MD_PORT', "MD_PORT.PORT_ID = {$this->table_out}.OFFICE_ID");
		// $builder->where('PORT_DAILY',1);
		$builder->where("TO_CHAR( {$this->table_out}.REPORT_DATE, 'YYYY') = ", $year);
		$builder->where('DIRECTION','ขาออก');
		$builder->where('VISA_ID',16);
		$builder->where('COUNTRY_ID',147);
		if($port_type){
			$builder->whereIn("MD_PORT.PORT_ID",$port_type);
		}
		
		$builder->groupBy("TO_CHAR({$this->table_out}.REPORT_DATE,'DD-MM-YYYY') ");
		$builder->orderBy("REPORT_DATE");
		$res = $builder->get()->getResultArray();
		foreach ($res as $d) {
			$data[$d['REPORT_DATE']] = $d['NUM'];
		}

		return $data;
	}

	function getSelectYear(){
		$data = array();
		$builder = $this->db->table($this->table_out);
		$builder->select(" TO_CHAR({$this->table_out}.REPORT_DATE,'YYYY') AS REPORT_YEAR");
		$builder->groupBy("TO_CHAR({$this->table_out}.REPORT_DATE,'YYYY') ");
		$builder->orderBy("REPORT_YEAR");
		$res = $builder->get()->getResultArray();
		foreach ($res as $d) {
			$data[] = $d['REPORT_YEAR'];
		}

		return $data;
	}

	function getSelectPortAll(){
		$data = array();
		$builder = $this->db->table('MD_PORT');
		$builder->select("*");
		$builder->orderBy('PORT_ORDER,PORT_NAME');
		$res = $builder->get()->getResultArray();
		foreach ($res as $d) {
			$data[$d['PORT_TYPE_ID']][$d['PORT_ID']] = $d['PORT_NAME'];
		}

		return $data;
	}
}