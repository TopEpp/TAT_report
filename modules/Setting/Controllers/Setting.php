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

		### Gen Ratio ###
		$year = date('Y');
		$month = date('m');
		$Model->genRaio($year, $month);
		### ### ### ### ###

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

		### Gen Ratio ###
		$year = date('Y');
		$month = date('m');
		$Model->genRaio($year, $month);
		### ### ### ### ###
		
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
 		$res = $Model->savePortRatio($input);
 		return $this->setResponseFormat('json')->respond($res);
	}

	public function getPortRatio($port_id){
		$Model = new Setting_model();
		$month = @$_GET['month'];
		$year = @$_GET['year'];
 		$data = $Model->getPortRatio($port_id,$month,$year);
 		return $this->setResponseFormat('json')->respond($data);
	}

	function saveVisaRatio(){
		$Model = new Setting_model();
 		$input = $this->request->getPost();
 		$res = $Model->saveVisaRatio($input);
 		return $this->setResponseFormat('json')->respond($res);
	}

	public function getVisaRatio($visa_id){
		$Model = new Setting_model();
		$month = @$_GET['month'];
		$year = @$_GET['year'];
 		$data = $Model->getVisaRatio($visa_id,$month,$year);
 		return $this->setResponseFormat('json')->respond($data);
	}

	public function updateVisaRatio($year){
		$Model = new Setting_model();
		$data = $Model->updateVisaRatio($year);
	}

	public function updateCalReportDaily(){
		$Model = new Setting_model();
		$year = @$_GET['year'];
		$month = @$_GET['month'];
		$day = @$_GET['day'];

		$Model->updateCalReportDaily($year,$month,$day);
	}

	public function permission()
	{
		$Model = new Setting_model();
		$data['group'] = $Model->getPermissionGroup();
		$data['user'] = $Model->getPermissionUser();

		return view('Modules\Setting\Views\permission',$data);
	}

	public function log_info()
	{
		$Model = new Setting_model();
		$data['Mydate'] = $this->Mydate;
		$data['data'] = $Model->getLogInfo();

		return view('Modules\Setting\Views\log_info',$data);
	}

	public function log_login()
	{
		$Model = new Setting_model();
		$data['Mydate'] = $this->Mydate;
		$data['data'] = $Model->getLogLogin();

		return view('Modules\Setting\Views\log_login',$data);
	}

	function genRaio(){
		$Model = new Setting_model();
		$year = date('Y');
		$month = date('m');
		$data = $Model->genRaio($year,$month);
	}
}

?>
