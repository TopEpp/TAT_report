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
	protected $table = 'REPORT_RAW_DATA';
  	protected $primaryKey = 'REC_ID';
  	protected $allowedFields = [];

  	function getNationReport($date){
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN");
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where('MD_VISA.VISA_TYPE_ID',1);
	    $builder->where("{$this->table}.DIRECTION",'ขาเข้า');
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$date);
	    $builder->groupBy("{$this->table}.COUNTRY_ID,MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("NUM DESC");
	    $data = $builder->get()->getResultArray();

	    return $data;
  	}

  	function getNatDateData($date){
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN , 
	    					SUM(
						       NUM * ( CASE WHEN ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') ) IS NOT NULL 
						            THEN    ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') )
						                    
						                    ELSE 1
						            END  ) ) AS NUM
						            ");
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("{$this->table}.DIRECTION",'ขาเข้า');
	    $builder->where('MD_VISA.VISA_TYPE_ID',1);
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$date);
	    $builder->groupBy("{$this->table}.COUNTRY_ID,MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("NUM DESC");
	    $data = $builder->get()->getResultArray();

	    return $data;
  	}

	function getNatMonthData($day,$month,$year){
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN , 
	    					SUM(
						       NUM * ( CASE WHEN ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') ) IS NOT NULL 
						            THEN    ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') )
						                    
						                    ELSE 1
						            END  ) ) AS NUM
						            ");
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("{$this->table}.DIRECTION",'ขาเข้า');
	    $builder->where('MD_VISA.VISA_TYPE_ID',1);
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'DD') <= ",$day);
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'MM') <= ",$month);
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') = ",$year);
	    $builder->groupBy("{$this->table}.COUNTRY_ID,MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("NUM DESC");
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getPortDateData($date){
		$builder = $this->db->table('MD_PORT');
	    $builder->select("MD_PORT.PORT_ID, MD_PORT.PORT_NAME , MD_PORT.PORT_TYPE ,
					    	SUM(
						       (CASE WHEN NUM IS NULL THEN 0 ELSE NUM END)  * ( CASE WHEN ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') ) IS NOT NULL 
						            THEN    ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') )
						                    
						                    ELSE 1
						            END  ) ) AS NUM
						            ");
	   
	    $builder->join($this->table,"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  
	    				AND {$this->table}.DIRECTION = 'ขาเข้า'
	    				AND TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = '{$date}' ",'LEFT');
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID AND MD_VISA.VISA_TYPE_ID = 1",'LEFT');
	    $builder->where('MD_PORT.PORT_CATEGORY_ID',1);
	    $builder->groupBy("MD_PORT.PORT_ID, MD_PORT.PORT_NAME, MD_PORT.PORT_TYPE ");
	    $builder->orderBy("NUM DESC,PORT_NAME");
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getPortMonthData($day,$month,$year){
	    $builder = $this->db->table('MD_PORT');
	    $builder->select("MD_PORT.PORT_ID, MD_PORT.PORT_NAME , MD_PORT.PORT_TYPE ,
					    	SUM(
						       (CASE WHEN NUM IS NULL THEN 0 ELSE NUM END)  * ( CASE WHEN ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') ) IS NOT NULL 
						            THEN    ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') )
						                    
						                    ELSE 1
						            END  ) ) AS NUM
						            ");
	   
	    $builder->join($this->table,"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  
	    				AND {$this->table}.DIRECTION = 'ขาเข้า'
	    				AND TO_CHAR( {$this->table}.REPORT_DATE, 'DD') <= '{$day}'
	    				AND TO_CHAR( {$this->table}.REPORT_DATE, 'MM') <= '{$month}'
	    				AND TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') = '{$year}' ",'LEFT');
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID AND MD_VISA.VISA_TYPE_ID = 1",'LEFT');
	    $builder->where('MD_PORT.PORT_CATEGORY_ID',1);
	    // $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'DD') <= ",$day);
	    // $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'MM') <= ",$month);
	    // $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') = ",$year);
	    $builder->groupBy("MD_PORT.PORT_ID, MD_PORT.PORT_NAME,MD_PORT.PORT_TYPE  ");
	    $builder->orderBy("NUM DESC,PORT_NAME");
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getPortDaily($date_start,$date_end){
		$data_daily = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.OFFICE_ID, TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, 
	    					SUM(
						       NUM * ( CASE WHEN ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') ) IS NOT NULL 
						            THEN    ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') )
						                    
						                    ELSE 1
						            END  ) ) AS NUM
						            ");
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("{$this->table}.DIRECTION",'ขาเข้า');
	    $builder->where('MD_VISA.VISA_TYPE_ID',1);
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$date_start}','dd/mm/yyyy') AND TO_DATE('{$date_end}','dd/mm/yyyy') ");
	    $builder->groupBy("{$this->table}.REPORT_DATE,{$this->table}.OFFICE_ID");
	    $builder->orderBy("REPORT_DATE");
	    $data = $builder->get()->getResultArray();
	    foreach($data as $d){
	    	$data_daily[$d['OFFICE_ID']][$d['REPORT_DATE']] = $d['NUM'];
	    }

	    return $data_daily;
	}

	function getNatDaily($date_start,$date_end){
		$data_daily = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, 
	    					SUM(
						       NUM * ( CASE WHEN ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') ) IS NOT NULL 
						            THEN    ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') )
						                    
						                    ELSE 1
						            END  ) ) AS NUM
						            ");
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("{$this->table}.DIRECTION",'ขาเข้า');
	    $builder->where('MD_VISA.VISA_TYPE_ID',1);
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$date_start}','dd/mm/yyyy') AND TO_DATE('{$date_end}','dd/mm/yyyy') ");
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
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID  ");
	    $builder->where("{$this->table}.DIRECTION",'ขาเข้า');
	    $builder->where('MD_VISA.VISA_TYPE_ID',1);
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$date_start}','dd/mm/yyyy') AND TO_DATE('{$date_end}','dd/mm/yyyy') ");
	    $builder->groupBy("MD_COUNTRY.COUNTRY_NAME_EN,{$this->table}.COUNTRY_ID");
	    $builder->orderBy("COUNTRY_NAME_EN");
	    $data = $builder->get()->getResultArray();
	    return $data;
	}

	function getNatBetweenDateData($start_date,$end_date,$country_type){
		$data = array();
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN , 
	    					SUM(
						       NUM * ( CASE WHEN ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') ) IS NOT NULL 
						            THEN    ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') )
						                    
						                    ELSE 1
						            END  ) ) AS NUM
						            ");
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("{$this->table}.DIRECTION",'ขาเข้า');
	    $builder->where('MD_VISA.VISA_TYPE_ID',1);
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','dd-mm-yyyy') AND TO_DATE('{$end_date}','dd-mm-yyyy') ");
	    if($country_type=='standard'){
	    	// $builder->where('MD_COUNTRY.IS_STANDARD','Y');
	    }	
	    $builder->groupBy("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("COUNTRY_NAME_EN");
	    // $builder->orderBy("NUM DESC");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $row){
	    	$data[$row['COUNTRY_ID']] = $row;
	    }
	    return $data;
  	}

  	function getPortCompareData($start_date,$end_date,$country_type,$port_type){
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_PORT.PORT_ID, TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE , MD_COUNTRY.COUNTRY_NAME_EN , 
	    					SUM(
						       NUM * ( CASE WHEN ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') ) IS NOT NULL 
						            THEN    ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') )
						                    
						                    ELSE 1
						            END  ) ) AS NUM
						            ");
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("{$this->table}.DIRECTION",'ขาเข้า');
	    $builder->where('MD_VISA.VISA_TYPE_ID',1);
	    $builder->whereIn("{$this->table}.OFFICE_ID",$port_type);
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','dd-mm-yyyy') AND TO_DATE('{$end_date}','dd-mm-yyyy') ");
	    if($country_type=='standard'){
	    	// $builder->where('MD_COUNTRY.IS_STANDARD','Y');
	    }	
	    $builder->groupBy("{$this->table}.COUNTRY_ID, MD_PORT.PORT_ID, {$this->table}.REPORT_DATE,MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("COUNTRY_NAME_EN");
	    // $builder->orderBy("NUM DESC");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $row){
	    	$data[$row['COUNTRY_ID']][$row['PORT_ID']][$row['REPORT_DATE']] = $row;
	    }
	    return $data;
  	}

  	function getCountryCompareRow($start_date,$end_date,$country_type,$port_type){
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID,  MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("{$this->table}.DIRECTION",'ขาเข้า');
	    $builder->where('MD_VISA.VISA_TYPE_ID',1);
	    $builder->whereIn("{$this->table}.OFFICE_ID",$port_type);
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','dd-mm-yyyy') AND TO_DATE('{$end_date}','dd-mm-yyyy') ");
	    if($country_type=='standard'){
	    	// $builder->where('MD_COUNTRY.IS_STANDARD','Y');
	    }	
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
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN , 
	    					SUM(
						       NUM * ( CASE WHEN ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') ) IS NOT NULL 
						            THEN    ( SELECT RATIO
						            FROM MD_PORT_RATIO
						            WHERE MD_PORT_RATIO.PORT_ID = REPORT_RAW_DATA.OFFICE_ID
						                    AND MD_PORT_RATIO.COUNTRY_ID = REPORT_RAW_DATA.COUNTRY_ID
						                    AND MD_PORT_RATIO.MONTH = TO_CHAR( {$this->table}.REPORT_DATE, 'MM')
						                    AND MD_PORT_RATIO.YEAR = TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY') )
						                    
						                    ELSE 1
						            END  ) ) AS NUM
						            ");
	    $builder->join('MD_VISA',"MD_VISA.VISA_ID = {$this->table}.VISA_ID");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("{$this->table}.DIRECTION",'ขาเข้า');
	    $builder->where('MD_VISA.VISA_TYPE_ID',1);
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','dd-mm-yyyy') AND TO_DATE('{$end_date}','dd-mm-yyyy') ");	
	    $builder->groupBy("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("COUNTRY_NAME_EN");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $row){
	    	$data[$row['COUNTRY_ID']] = $row;
	    	@$data['SUM'] += $row['NUM'];
	    }
	    return $data;
	}
}