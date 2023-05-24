<?php

namespace Modules\Setting\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Modules\Setting\Models\Setting_model;

class Setting extends BaseController{

	use ResponseTrait;

	public function index(){
		$data['session'] = session();
		$data['Mydate'] = $this->Mydate;
		return view("Modules\Setting\Views\index",$data);
	}

	public function country(){
		$data['session'] = session();
		$Model = new Setting_model();
		$data['data'] = $Model->getCountry();
		return view("Modules\Setting\Views\country",$data);
	}

	public function port(){
		$data['session'] = session();
		$Model = new Setting_model();
		$data['country'] = $Model->getCountry();
		$data['data'] = $Model->getPort();
		foreach($data['data'] as $port){
			$data['port_ratio'][$port['PORT_ID']] = count( $Model->getPortRatio($port['PORT_ID']) );
		}
		$data['visa'] = $Model->getVisa();
		$data['month_label'] = $this->month_th;
		return view("Modules\Setting\Views\port",$data);
	}

	public function visa(){
		$data['session'] = session();
		$Model = new Setting_model();
		$data['country'] = $Model->getCountry();
		$data['data'] = $Model->getVisa();
		foreach($data['data'] as $visa){
			$data['visa_ratio'][$visa['VISA_ID']] = count( $Model->getVisaRatio($visa['VISA_ID']) );
		}
		$data['month_label'] = $this->month_th;
		return view('Modules\Setting\Views\visa',$data);
	}

	public function saveVisa(){
		$Model = new Setting_model();
		$input = $this->request->getPost();
		$Model->saveVisa($input);
		return true;
	}
 	
 	public function savePort(){
 		$Model = new Setting_model();
 		$input = $this->request->getPost();
 		$Model->savePort($input);
 		return true;
	}

	public function deleteVisa(){
		$id = $this->request->getPost('id');
		$Model = new Setting_model();
		$Model->deleteVisa($id);
		return $id;
	}

	public function deletePort(){
		$id = $this->request->getPost('id');
		$Model = new Setting_model();
		$Model->deletePort($id);
		return $id;
	}

 	public function savePortRatio(){
 		$Model = new Setting_model();
 		$input = $this->request->getPost();
 		$Model->savePortRatio($input);
 		return true;
	}

	public function getPortRatio($port_id){
		$Model = new Setting_model();
 		$data = $Model->getPortRatio($port_id);
 		return $this->setResponseFormat('json')->respond($data);
	}

	function saveVisaRatio(){
		$Model = new Setting_model();
 		$input = $this->request->getPost();
 		$Model->saveVisaRatio($input);
 		return true;
	}

	public function getVisaRatio($visa_id){
		$Model = new Setting_model();
 		$data = $Model->getVisaRatio($visa_id);
 		return $this->setResponseFormat('json')->respond($data);
	}
}

?>
