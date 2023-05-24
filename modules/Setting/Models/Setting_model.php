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
		$builder_delete->where('RATIO',$input['ratio']);
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
	}


	function saveVisaRatio($input){
		$builder_delete = $this->db->table('MD_VISA_RATIO');
		$builder_delete->where('YEAR',$input['year']);
		$builder_delete->where('MONTH',$input['month']);
		$builder_delete->where('RATIO',$input['ratio']);
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

	function getPortRatio($port_id){
		$builder = $this->db->table('MD_PORT_RATIO');
		$builder->select('MD_PORT_RATIO.* , MD_COUNTRY.COUNTRY_NAME_EN, MD_VISA.VISA_NAME ');
		$builder->join('MD_COUNTRY','MD_COUNTRY.COUNTRYID = MD_PORT_RATIO.COUNTRY_ID');
		$builder->join('MD_VISA','MD_VISA.VISA_ID = MD_PORT_RATIO.VISA_ID');
		$builder->where('PORT_ID',$port_id);
		$builder->orderBy('YEAR,MONTH');
		$data = $builder->get()->getResultArray();
	    return $data;
	}

	function getVisaRatio($visa_id){
		$builder = $this->db->table('MD_VISA_RATIO');
		$builder->select('MD_VISA_RATIO.* , MD_COUNTRY.COUNTRY_NAME_EN, MD_VISA.VISA_NAME ');
		$builder->join('MD_COUNTRY','MD_COUNTRY.COUNTRYID = MD_VISA_RATIO.COUNTRY_ID');
		$builder->join('MD_VISA','MD_VISA.VISA_ID = MD_VISA_RATIO.VISA_ID');
		$builder->where('MD_VISA_RATIO.VISA_ID',$visa_id);
		$builder->orderBy('YEAR,MONTH');
		$data = $builder->get()->getResultArray();
	    return $data;
	}
}