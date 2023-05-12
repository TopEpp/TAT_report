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
	    $data = $builder->get()->getResultArray();
	    return $data;
	}

	function getVisa(){
		$builder = $this->db->table('MD_VISA');
	    $builder->select('*');
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
}