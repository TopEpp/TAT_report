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
	protected $table = 'CAL_SUM_DATA_REPORT';
	protected $table_month = 'CAL_MONTHLY_REPORT';
  	protected $primaryKey = 'REC_ID';
  	protected $allowedFields = [];

  	function getMaxDate(){
  		$builder = $this->db->table('REPORT_RAW_DATA');
  		$builder->select("TO_CHAR(REPORT_RAW_DATA.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE");
  		$builder->orderBy('REPORT_DATE DESC');
  		$builder->limit(1);
  		
  		$data = $builder->get()->getRowArray();

  		return $data['REPORT_DATE'];

  	}

	function getSumDate($date){
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table);
	    $builder->select(" SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$date);
	    $data = $builder->get()->getRowArray();

	    return $data['NUM'];
	}

	function getSumMonth($start_date,$end_date){
		$builder = $this->db->table($this->table);
	    $builder->select("SUM({$this->table}.SUM) AS NUM");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
	    $data = $builder->get()->getRowArray();

	    return $data['NUM'];
	}

	function getSumNatDate($date){
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN , SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$date);
	    $builder->groupBy("{$this->table}.COUNTRY_ID,MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("NUM DESC");
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getSumNatMonth($start_date,$end_date){
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.COUNTRY_ID, MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN , SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
	    $builder->groupBy("{$this->table}.COUNTRY_ID,MD_COUNTRY.COUNTRY_NAME_TH, MD_COUNTRY.COUNTRY_NAME_EN ");
	    $builder->orderBy("NUM DESC");
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getSumPortDate($date){
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.OFFICE_ID, MD_PORT.PORT_NAME , MD_PORT.PORT_TYPE , SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$date);
	    $builder->groupBy("{$this->table}.OFFICE_ID, MD_PORT.PORT_NAME, MD_PORT.PORT_TYPE ");
	    $builder->orderBy("NUM DESC");
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getSumPortMonth($start_date,$end_date){
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.OFFICE_ID, MD_PORT.PORT_NAME , MD_PORT.PORT_TYPE ,SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
	    $builder->groupBy("{$this->table}.OFFICE_ID, MD_PORT.PORT_NAME,MD_PORT.PORT_TYPE  ");
	    $builder->orderBy("NUM DESC");
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getSumChart($to_date){
		$data_chart = array();
		$builder = $this->db->table($this->table);
	    $builder->select(" TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$to_date}','YYYY-MM-DD')-15 AND TO_DATE('{$to_date}','YYYY-MM-DD') ");
	    $builder->groupBy("{$this->table}.REPORT_DATE");
	    $builder->orderBy("REPORT_DATE");
	    $data = $builder->get()->getResultArray();
	    foreach($data as $d){
	    	$data_chart['current'][$d['REPORT_DATE']] = $d['NUM'];
	    }

	    list($year, $month, $day) = explode('-', $to_date);
	    $to_date_past = ($year-1).'-'.$month.'-'.$day;
	    $builder = $this->db->table($this->table);
	    $builder->select(" TO_CHAR({$this->table}.REPORT_DATE,'YYYY-MM-DD') AS REPORT_DATE, SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$to_date_past}','YYYY-MM-DD')-15 AND TO_DATE('{$to_date_past}','YYYY-MM-DD') ");
	    $builder->groupBy("{$this->table}.REPORT_DATE");
	    $builder->orderBy("REPORT_DATE");
	    $data = $builder->get()->getResultArray();
	    foreach($data as $d){
	    	$data_chart['past'][$d['REPORT_DATE']] = $d['NUM'];
	    }

	    return $data_chart;
	}

	function getSumRegionDate($date){
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table);
	    $builder->select("MD_COUNTRY.STD_REGION_ID, SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_SUB_REGION',"MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$date);
	    $builder->groupBy("MD_COUNTRY.STD_REGION_ID");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $r){
	    	$data[$r['STD_REGION_ID']] = $r['NUM'];
	    }

	    return $data;
	}

	function getSumRegionMonth($start_date,$end_date){
		$data = array();
		$builder = $this->db->table($this->table);
	    $builder->select("MD_COUNTRY.STD_REGION_ID, SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->join('MD_SUB_REGION',"MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
	    $builder->groupBy("MD_COUNTRY.STD_REGION_ID");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $r){
	    	$data[$r['STD_REGION_ID']] = $r['NUM'];
	    }

	    return $data;
	}

	function getSumCountryDate($date){
		$date_ex = explode('-', $date);
		$month = $date_ex[1];
		$year = $date_ex[0];
		$builder = $this->db->table($this->table);
	    $builder->select("MD_COUNTRY.COUNTRYID, SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_SUB_REGION',"MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$date);
	    $builder->groupBy("MD_COUNTRY.COUNTRYID");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $r){
	    	$data[$r['COUNTRYID']] = $r['NUM'];
	    }

	    return $data;
	}

	function getSumCountryMonth($start_date,$end_date){
		$data = array();
		$builder = $this->db->table($this->table);
	    $builder->select("MD_COUNTRY.COUNTRYID, SUM({$this->table}.SUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table}.COUNTRY_ID");
	    $builder->join('MD_PORT',"MD_PORT.PORT_ID = {$this->table}.OFFICE_ID  AND PORT_CATEGORY_ID = 1");
	    $builder->join('MD_SUB_REGION',"MD_COUNTRY.REGIONID = MD_SUB_REGION.SUB_REGION_ID");
	    $builder->where("REPORT_DATE BETWEEN TO_DATE('{$start_date}','YYYY-MM-DD') AND TO_DATE('{$end_date}','YYYY-MM-DD') ");
	    $builder->groupBy("MD_COUNTRY.COUNTRYID");
	    $res = $builder->get()->getResultArray();
	    foreach($res as $r){
	    	$data[$r['COUNTRYID']] = $r['NUM'];
	    }

	    return $data;
	}

	function update_country(){
		$builder = $this->db->table('MD_COUNTRY');
		$builder->select('COUNTRYID,COUNTRYSHORTNAMEEN');
		$data = $builder->get()->getResultArray();
	    foreach($data as $d){
	    	$c = explode(' (', $d['COUNTRYSHORTNAMEEN']);
	    	$th = @$c[1];
	    	$en = @$c[0];
	    	$th = @substr($th,0,-1);
	    	$en =ucfirst(strtolower($en));

	    	echo $th.' '.$en.'<br>';

	    	$builder_set = $this->db->table('MD_COUNTRY');
	    	$builder_set->set('COUNTRY_NAME_TH',$th);
	    	$builder_set->set('COUNTRY_NAME_TH2',$th);
	    	$builder_set->set('COUNTRY_NAME_EN',$en);
	    	$builder_set->where('COUNTRYID',$d['COUNTRYID']);
	    	$builder_set->update();
	    }
	}

	function getSubRegion(){
		$data = array();
		$builder = $this->db->table('MD_SUB_REGION');
		$builder->select('*');
		$builder->where('MD_SUB_REGION.IS_STANDARD','Y');
		$builder->orderBy('MD_SUB_REGION.REPORT_ORDER_SEQ');
		$res = $builder->get()->getResultArray();
		foreach($res as $row){
			$data[$row['STD_REGION_ID']][] = $row;
		}
	    return $data;
	}

	################################ MONTHLY REPORT #################################

	function getSumMonthly($year){
		$builder = $this->db->table($this->table_month);
	    $builder->select("{$this->table_month}.MONTH, SUM({$this->table_month}.NUM) AS NUM ");
		$builder->where("{$this->table_month}.YEAR",$year);
		$builder->groupBy("{$this->table_month}.MONTH");
		$builder->orderBy("{$this->table_month}.MONTH");
		$res = $builder->get()->getResultArray();
		foreach($res as $row){
			$data[$row['MONTH']] = $row['NUM'];
		}
	    return $data;
	}

	function getSumMonthlyRegion($month,$year){
		$builder = $this->db->table($this->table_month);
	    $builder->select("MD_STD_REGION.MD_STD_REG_ID, MD_STD_REGION.MD_STD_REG_NAMEEN, SUM({$this->table_month}.NUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
	    $builder->join('MD_STD_REGION',"MD_STD_REGION.MD_STD_REG_ID = MD_COUNTRY.STD_REGION_ID ");
	    $builder->where("{$this->table_month}.MONTH",$month);
	    $builder->where("{$this->table_month}.YEAR",$year);
	    $builder->groupBy("MD_STD_REGION.MD_STD_REG_ID, MD_STD_REGION.MD_STD_REG_NAMEEN");
	    $builder->orderBy('MD_STD_REG_NAMEEN');
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getSumMonthlyCountry($month,$year,$limit){
		$builder = $this->db->table($this->table_month);
	    $builder->select("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN, {$this->table_month}.NUM, {$this->table_month}.GROWTH_RATE ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
	    $builder->where("{$this->table_month}.MONTH",$month);
	    $builder->where("{$this->table_month}.YEAR",$year);
	    $builder->orderBy('NUM DESC');
	    // $builder->groupBy("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN");
	    $builder->limit($limit);
	    $res = $builder->get()->getResultArray();
		foreach($res as $row){
			$data[$row['COUNTRYID']] = $row;

			$builder_past = $this->db->table($this->table_month);
			$builder_past->select("MD_COUNTRY.COUNTRYID, SUM({$this->table_month}.NUM) AS NUM ");
		    $builder_past->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
		    $builder_past->where("{$this->table_month}.MONTH",$month);
		    $builder_past->where("{$this->table_month}.YEAR",($year-1));
		    $builder_past->where("{$this->table_month}.COUNTRY_ID",$row['COUNTRYID']);
		    $builder_past->groupBy("MD_COUNTRY.COUNTRYID");
		    $res_past = $builder_past->get()->getRowArray();

		    
		    if(@$res_past['NUM']>0){
		    	$data[$row['COUNTRYID']]['NUM_PAST'] = $res_past['NUM'];
		    	$data[$row['COUNTRYID']]['CHANGE'] = number_format($row['NUM']/$res_past['NUM']*100,2).' %';
		    }else{
		    	$data[$row['COUNTRYID']]['NUM_PAST'] = 0;
		    	$data[$row['COUNTRYID']]['CHANGE'] = '-';
		    }
		    

		}

	    return $data;
	}

	function getSumMonthlyRegionPeriod($month,$month2,$year){
		$builder = $this->db->table($this->table_month);
	    $builder->select("MD_STD_REGION.MD_STD_REG_ID, MD_STD_REGION.MD_STD_REG_NAMEEN, SUM({$this->table_month}.NUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
	    $builder->join('MD_STD_REGION',"MD_STD_REGION.MD_STD_REG_ID = MD_COUNTRY.STD_REGION_ID ");
	    $builder->where("{$this->table_month}.MONTH >=",$month);
	    $builder->where("{$this->table_month}.MONTH <=",$month2);
	    $builder->where("{$this->table_month}.YEAR",$year);
	    $builder->groupBy("MD_STD_REGION.MD_STD_REG_ID, MD_STD_REGION.MD_STD_REG_NAMEEN");
	    $builder->orderBy('MD_STD_REG_NAMEEN');
	    $data = $builder->get()->getResultArray();

	    return $data;
	}

	function getSumMonthlyCountryPeriod($month,$month2,$year,$limit){
		$builder = $this->db->table($this->table_month);
	    $builder->select("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN, SUM({$this->table_month}.NUM) AS NUM ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
	    $builder->where("{$this->table_month}.MONTH >=",$month);
	    $builder->where("{$this->table_month}.MONTH <=",$month2);
	    $builder->where("{$this->table_month}.YEAR",$year);
	    $builder->orderBy('NUM DESC');
	    $builder->groupBy("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN");
	    $builder->limit($limit);
		$res = $builder->get()->getResultArray();
		foreach($res as $row){
			$data[$row['COUNTRYID']] = $row;

			$builder_past = $this->db->table($this->table_month);
			$builder_past->select("MD_COUNTRY.COUNTRYID, SUM({$this->table_month}.NUM) AS NUM ");
		    $builder_past->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
		    $builder_past->where("{$this->table_month}.MONTH >=",$month);
		    $builder_past->where("{$this->table_month}.MONTH <=",$month2);
		    $builder_past->where("{$this->table_month}.YEAR",($year-1));
		    $builder_past->where("{$this->table_month}.COUNTRY_ID",$row['COUNTRYID']);
		    $builder_past->groupBy("MD_COUNTRY.COUNTRYID");
		    $res_past = $builder_past->get()->getRowArray();

		    
		    if(@$res_past['NUM']>0){
		    	$data[$row['COUNTRYID']]['NUM_PAST'] = $res_past['NUM'];
		    	$data[$row['COUNTRYID']]['CHANGE'] = number_format($row['NUM']/$res_past['NUM']*100,2).' %';
		    }else{
		    	$data[$row['COUNTRYID']]['CHANGE'] = '-';
		    }
		    

		}

	    return $data;
	}




	 
}