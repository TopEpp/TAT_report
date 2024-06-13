<?php
namespace Modules\Setting\Models;
use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Mydate;
use App\Libraries\Hash;
class Setting_model extends Model
{
	function getCountry(){
		$builder = $this->db->table('MD_COUNTRY');
	    $builder->select('*');
	    $builder->where('IS_MASTER','Y');
	    $builder->orderBy('COUNTRY_NAME_EN');
	    $data = $builder->get()->getResultArray();
	    return $data;
	}

	function getPort($cate_type=''){
		$builder = $this->db->table('MD_PORT');
	    $builder->select('MD_PORT.* ');
	    if($cate_type){
	    	$builder->where('PORT_CATEGORY_ID',1);
	    }
		$builder->where('IS_DELETED', 1);
	    $data = $builder->get()->getResultArray();
	    return $data;
	}

	function getVisa(){
		$builder = $this->db->table('MD_VISA');
	    $builder->select('*');
		$builder->where('IS_DELETED', 1);
	    $data = $builder->get()->getResultArray();
	    return $data;
	}

	function savePortRatio($input){
		$builder_delete = $this->db->table('MD_PORT_RATIO');
		$builder_delete->where('PORT_ID',$input['port_id']);
		$builder_delete->where('YEAR',$input['year']);
		$builder_delete->where('MONTH',$input['month']);
		$builder_delete->where('VISA_ID',$input['visa_id']);
		$builder_delete->where('COUNTRY_ID',$input['country_id']);
		$builder_delete->delete();

		$builder = $this->db->table('MD_PORT_RATIO');
		$builder->set('PORT_ID',$input['port_id']);
		$builder->set('YEAR',$input['year']);
		$builder->set('MONTH',$input['month']);
		$builder->set('RATIO',$input['ratio']);
		$builder->set('VISA_ID',$input['visa_id']);
		$builder->set('COUNTRY_ID',$input['country_id']);
		$builder->insert();

		$this->updateCalReportDaily($input['year'],$input['month'],'',$input['port_id'],$input['country_id']);
	}


	function saveVisaRatio($input){
		if($input['country_id']=='all'){
			$builder_delete = $this->db->table('MD_VISA_RATIO');
			$builder_delete->where('YEAR',$input['year']);
			$builder_delete->where('MONTH',$input['month']);
			$builder_delete->where('VISA_ID',$input['visa_id']);
			$builder_delete->delete();

			$builder = $this->db->table('MD_COUNTRY');
			$builder->select('COUNTRYID ');
			$builder->where('MARKET_TYPE IS NOT NULL');
			$co = $builder->get()->getResultArray();
			foreach ($co as $key => $value) {
				$builder = $this->db->table('MD_VISA_RATIO');
				$builder->set('YEAR',$input['year']);
				$builder->set('MONTH',$input['month']);
				$builder->set('RATIO',$input['ratio']);
				$builder->set('VISA_ID',$input['visa_id']);
				$builder->set('COUNTRY_ID',$value['COUNTRYID']);
				$builder->insert();
			}
		}else{
			$builder_delete = $this->db->table('MD_VISA_RATIO');
			$builder_delete->where('YEAR',$input['year']);
			$builder_delete->where('MONTH',$input['month']);
			$builder_delete->where('VISA_ID',$input['visa_id']);
			$builder_delete->where('COUNTRY_ID',$input['country_id']);
			$builder_delete->delete();

			$builder = $this->db->table('MD_VISA_RATIO');
			$builder->set('YEAR',$input['year']);
			$builder->set('MONTH',$input['month']);
			$builder->set('RATIO',$input['ratio']);
			$builder->set('VISA_ID',$input['visa_id']);
			$builder->set('COUNTRY_ID',$input['country_id']);
			$builder->insert();
		}

		$this->updateCalReportDaily($input['year'],$input['month']);
		
	}

	function saveVisa($input){
		$builder = $this->db->table('MD_VISA');
		$builder->set('VISA_NAME', $input['visa_name']);
		$builder->set('VISA_TYPE', $input['visa_type_name']);
		$builder->set('VISA_TYPE_ID', $input['visa_type_id']);

		if(!empty($input['visa_id'])){
			$builder->where('VISA_ID', $input['visa_id']);
			$builder->update();
		}else{
			$builder->insert();
		}
	}

	function deleteVisa($id){
		$builder = $this->db->table('MD_VISA');
		$builder->set('IS_DELETED', 0);
		$builder->where('VISA_ID', $id);
		$builder->update();
	}

	function savePort($input){
		$builder = $this->db->table('MD_PORT');
		$builder->set('PORT_NAME',$input['port_name']);
		$builder->set('PORT_TYPE_ID',$input['port_type']);
		$builder->set('PORT_CATEGORY_ID',$input['port_cate']);

		// set port typename , catename
		$builder->set('PORT_TYPE', $input['port_type_name']);
		$builder->set('PORT_CATEGORY', $input['port_category']);

		if(!empty($input['port_id'])){
			$builder->where('PORT_ID',$input['port_id']);
			$builder->update();
		}else{
			$builder->insert();
		}
	}

	function deletePort($id){
		$builder = $this->db->table('MD_PORT');
		$builder->set('IS_DELETED', 0);
		$builder->where('PORT_ID', $id);
		$builder->update();
	}

	function getPortRatio($port_id,$month='',$year=''){
		$builder = $this->db->table('MD_PORT_RATIO');
		$builder->select('MD_PORT_RATIO.* , MD_COUNTRY.COUNTRY_NAME_EN, MD_VISA.VISA_NAME ');
		$builder->join('MD_COUNTRY','MD_COUNTRY.COUNTRYID = MD_PORT_RATIO.COUNTRY_ID');
		$builder->join('MD_VISA','MD_VISA.VISA_ID = MD_PORT_RATIO.VISA_ID');
		$builder->where('PORT_ID',$port_id);
		if($month){
			$builder->where('MD_PORT_RATIO.MONTH',$month);
		}
		if($year){
			$builder->where('MD_PORT_RATIO.YEAR',$year);
		}
		$builder->orderBy('YEAR,MONTH');
		$data = $builder->get()->getResultArray();
	    return $data;
	}

	function getVisaRatio($visa_id,$month='',$year=''){
		$builder = $this->db->table('MD_VISA_RATIO');
		$builder->select('MD_VISA_RATIO.* , MD_COUNTRY.COUNTRY_NAME_EN, MD_VISA.VISA_NAME ');
		$builder->join('MD_COUNTRY','MD_COUNTRY.COUNTRYID = MD_VISA_RATIO.COUNTRY_ID');
		$builder->join('MD_VISA','MD_VISA.VISA_ID = MD_VISA_RATIO.VISA_ID');
		$builder->where('MD_VISA_RATIO.VISA_ID',$visa_id);
		if($month){
			$builder->where('MD_VISA_RATIO.MONTH',$month);
		}
		if($year){
			$builder->where('MD_VISA_RATIO.YEAR',$year);
		}
		$builder->orderBy('YEAR,MONTH,COUNTRY_NAME_EN');
		$data = $builder->get()->getResultArray();
	    return $data;
	}

	function updateVisaRatio($year){
		set_time_limit(1000);
		$builder = $this->db->table('MD_VISA');
		$builder->select('VISA_ID');
		$builder->where('VISA_TYPE_ID',1);
		$builder->where('IS_DELETED',1);
		$data = $builder->get()->getResultArray();
		foreach ($data as $key => $value) {
			$builder_co = $this->db->table('MD_COUNTRY');
			$builder_co->select('COUNTRYID');
			$builder_co->where('MARKET_TYPE IS NOT NULL');
			$co = $builder_co->get()->getResultArray();
			foreach ($co as $c) {

				for ($i=1; $i <= 12 ; $i++) { 
					$builder_delete = $this->db->table('MD_VISA_RATIO');
					$builder_delete->where('YEAR',$year);
					$builder_delete->where('MONTH',$i);
					$builder_delete->where('VISA_ID',$value['VISA_ID']);
					$builder_delete->where('COUNTRY_ID',$c['COUNTRYID']);
					$builder_delete->delete();

					$builder_insert = $this->db->table('MD_VISA_RATIO');
					$builder_insert->set('YEAR',$year);
					$builder_insert->set('MONTH',$i);
					$builder_insert->set('RATIO',1);
					$builder_insert->set('VISA_ID',$value['VISA_ID']);
					$builder_insert->set('COUNTRY_ID',$c['COUNTRYID']);
					$builder_insert->insert();
				}
			
			}
		}
	}

	function updateVisaRatioMonth($year,$m){
		set_time_limit(1000);
		$builder = $this->db->table('MD_VISA_RATIO');
		$builder->select('VISA_ID');
		$builder->where('YEAR',$year);
		$builder->where('MONTH',$m);
		$data = $builder->get()->getRowArray();
		if(empty($data['VISA_ID'])){
			$builder = $this->db->table('MD_VISA');
			$builder->select('VISA_ID');
			$builder->where('VISA_TYPE_ID',1);
			$builder->where('IS_DELETED',1);
			$data = $builder->get()->getResultArray();
			foreach ($data as $key => $value) {
				$builder_co = $this->db->table('MD_COUNTRY');
				$builder_co->select('COUNTRYID');
				$builder_co->where('MARKET_TYPE IS NOT NULL');
				$co = $builder_co->get()->getResultArray();
				foreach ($co as $c) {

					$builder_delete = $this->db->table('MD_VISA_RATIO');
					$builder_delete->where('YEAR',$year);
					$builder_delete->where('MONTH',$m);
					$builder_delete->where('VISA_ID',$value['VISA_ID']);
					$builder_delete->where('COUNTRY_ID',$c['COUNTRYID']);
					$builder_delete->delete();

					$builder_insert = $this->db->table('MD_VISA_RATIO');
					$builder_insert->set('YEAR',$year);
					$builder_insert->set('MONTH',$m);
					$builder_insert->set('RATIO',1);
					$builder_insert->set('VISA_ID',$value['VISA_ID']);
					$builder_insert->set('COUNTRY_ID',$c['COUNTRYID']);
					$builder_insert->insert();
					
				
				}
			}
		}
	}

	function updateCalReportDaily($year,$month,$day='',$port='',$country=''){
		$builder_delete = $this->db->table('REPORT_CAL_DAILY');
		if($day){ $builder_delete->where("TO_CHAR( REPORT_DATE, 'DD') = ",$day); }
		if($port){ $builder_delete->where("OFFICE_ID",$port); }
		if($country){ $builder_delete->where("COUNTRY_ID",$country); }
		$builder_delete->where("TO_CHAR( REPORT_DATE, 'MM') = ",intval($month));
	    $builder_delete->where("TO_CHAR( REPORT_DATE, 'YYYY') = ",$year);
		$builder_delete->delete();

		$builder = $this->db->table('CAL_DAILY_REPORT');
		if($day){ $builder->where("TO_CHAR( REPORT_DATE, 'DD') = ",$day); }
		if($port){ $builder->where("OFFICE_ID",$port); }
		if($country){ $builder->where("COUNTRY_ID",$country); }
	    $builder->where("TO_CHAR( REPORT_DATE, 'MM') = ",intval($month));
	    $builder->where("TO_CHAR( REPORT_DATE, 'YYYY') = ",$year);
	    $data = $builder->get()->getResultArray();

	    // echo ' COUNT :: '.count($data); $c=0;
		foreach ($data as $key => $value) {
			// $c++;
			$builder_insert = $this->db->table('REPORT_CAL_DAILY');
			$builder_insert->set('COUNTRY_ID',$value['COUNTRY_ID']);
			$builder_insert->set('REPORT_DATE',$value['REPORT_DATE']);
			$builder_insert->set('OFFICE_ID',$value['OFFICE_ID']);
			$builder_insert->set('COUNTRY_NAME_TH',$value['COUNTRY_NAME_TH']);
			$builder_insert->set('COUNTRY_NAME_EN',$value['COUNTRY_NAME_EN']);
			$builder_insert->set('SUM',$value['SUM']);
			$builder_insert->insert();
		}

		// echo ' :: '.$c;
	}

	function getPermissionGroup(){
		$builder = $this->db->table('REPORT_PERMISSION_GROUP');
		$builder->select('*');
		$data = $builder->get()->getResultArray();

		return $data;
	}

	function getPermissionUser(){
		$builder = $this->db->table('REPORT_PERMISSION_USER');
		$builder->select('*');
		$data = $builder->get()->getResultArray();

		return $data;
	}

	function getLogInfo(){
		$builder = $this->db->table('LOG_EXPORT_INFO');
	    $builder->select("LOG_EXPORT_INFO.*, TO_CHAR( DATE_EXPORT, 'DD/MM/YYYY hh24:mi:ss') as EXPORT_DATE ");
	    $builder->orderBy('REC_ID','DESC');
	    $builder->limit(100);
	    $data = $builder->get()->getResultArray();
	    return $data;
	}

	function getLogLogin(){
		$builder = $this->db->table('LOG_LOGIN');
	    $builder->select("LOG_LOGIN.*, TO_CHAR( DATE_LOGIN, 'DD/MM/YYYY hh24:mi:ss') as LOGIN_DATE ");
	    $builder->where('LOG_TYPE','REPORT');
	    $builder->orderBy('REC_ID','DESC');
	    $builder->limit(100);
	    $data = $builder->get()->getResultArray();
	    return $data;
	}

	function genRaio($year,$month){
		$builder = $this->db->table('MD_VISA_RATIO');
		$builder->select('RATIO_ID');
		$builder->where('YEAR',$year);
		$builder->where('MONTH',$month);
		$data = $builder->get()->getRowArray();
		if(empty($data['RATIO_ID'])){
			$yearx = $year;
			$monthx = $month-1;
			if(($month-1)==0){
				$monthx = 12;
				$yearx = $year-1;
			}

			$builder_temp = $this->db->table('MD_VISA_RATIO');
			$builder_temp->select('*');
			$builder_temp->where('YEAR',$yearx);
			$builder_temp->where('MONTH',$monthx);
			$data_temp = $builder_temp->get()->getResultArray();
			foreach ($data_temp as $key => $value) {

				$builder_insert = $this->db->table('MD_VISA_RATIO');
				$builder_insert->set('YEAR',$year);
				$builder_insert->set('MONTH',$month);
				$builder_insert->set('RATIO',$value['RATIO']);
				$builder_insert->set('VISA_ID',$value['VISA_ID']);
				$builder_insert->set('COUNTRY_ID',$value['COUNTRY_ID']);
				$builder_insert->insert();
			}
		}

		$builder = $this->db->table('MD_PORT_RATIO');
		$builder->select('RATIO');
		$builder->where('YEAR',$year);
		$builder->where('MONTH',$month);
		$data = $builder->get()->getRowArray();
		if(empty($data['RATIO'])){
			$yearx = $year;
			$monthx = $month-1;
			if(($month-1)==0){
				$monthx = 12;
				$yearx = $year-1;
			}

			$builder_temp = $this->db->table('MD_PORT_RATIO');
			$builder_temp->select('*');
			$builder_temp->where('YEAR',$yearx);
			$builder_temp->where('MONTH',$monthx-1);
			$data_temp = $builder_temp->get()->getResultArray();
			foreach ($data_temp as $key => $value) {

				$builder = $this->db->table('MD_PORT_RATIO');
				$builder->set('PORT_ID',$value['PORT_ID']);
				$builder->set('YEAR',$year);
				$builder->set('MONTH',$month);
				$builder->set('RATIO',$value['RATIO']);
				$builder->set('VISA_ID',$value['VISA_ID']);
				$builder->set('COUNTRY_ID',$value['COUNTRY_ID']);
				$builder->insert();
			}
		}

	}


}