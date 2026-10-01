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
		$data['flags'] = Setting_model::PERMISSION_FLAGS;
		$data['canManage'] = $this->_canManagePermission();

		return view('Modules\Setting\Views\permission',$data);
	}

	// กลุ่ม route /setting ไม่มี filter auth → endpoint ที่เขียนข้อมูลสิทธิ์ต้องเช็คเอง
	private function _canManagePermission()
	{
		$session = session();
		$menu = $session->get('user_menu');
		return $session->get('logged_in') && !empty($menu['SETTING']);
	}

	private function _permissionResponse($status, $data, $message, $code = 200)
	{
		return $this->setResponseFormat('json')->respond([
			'status'  => $status,
			'data'    => $data,
			'message' => $message,
		], $code);
	}

	/**
	 * ตรวจ type + key ของสิทธิ์ · คืน error message หรือ null ถ้าผ่าน
	 * group = รหัสหน่วยงาน (ตัวเลข ตรงกับ title ใน AD) · user = username AD
	 */
	private function _validatePermissionKey($type, $key)
	{
		if (!isset(Setting_model::PERMISSION_TABLES[$type])) {
			return 'ประเภทสิทธิ์ไม่ถูกต้อง';
		}
		if ($type === 'group' && !preg_match('/^\d{1,10}$/', $key)) {
			return 'รหัสหน่วยงานต้องเป็นตัวเลข 1-10 หลัก';
		}
		if ($type === 'user' && !preg_match('/^[A-Za-z0-9._-]{1,200}$/', $key)) {
			return 'Username ใช้ได้เฉพาะ a-z 0-9 . _ - (ไม่เกิน 200 ตัวอักษร)';
		}
		return null;
	}

	// รับเฉพาะ AJAX จากผู้มีสิทธิ์ Setting (custom header ปลอมข้ามโดเมนไม่ได้ = กัน CSRF แบบเบา)
	private function _guardPermissionWrite()
	{
		if (!$this->request->isAJAX()) {
			return $this->_permissionResponse('error', null, 'Invalid request', 400);
		}
		if (!$this->_canManagePermission()) {
			return $this->_permissionResponse('error', null, 'ไม่มีสิทธิ์จัดการข้อมูลสิทธิ์', 403);
		}
		return null;
	}

	public function savePermission()
	{
		$denied = $this->_guardPermissionWrite();
		if ($denied) {
			return $denied;
		}

		$type        = (string) $this->request->getPost('type');
		$key         = trim((string) $this->request->getPost('key'));
		$originalKey = trim((string) $this->request->getPost('original_key'));
		$flags       = (array) $this->request->getPost('flags');

		$error = $this->_validatePermissionKey($type, $key);
		if (!$error && $originalKey !== '') {
			$error = $this->_validatePermissionKey($type, $originalKey);
		}
		if ($error) {
			return $this->_permissionResponse('error', null, $error, 422);
		}

		$Model = new Setting_model();
		if ($originalKey !== '' && !$Model->permissionExists($type, $originalKey)) {
			return $this->_permissionResponse('error', null, 'ไม่พบข้อมูลเดิม อาจถูกลบไปแล้ว', 404);
		}
		if ($key !== $originalKey && $Model->permissionExists($type, $key)) {
			return $this->_permissionResponse('error', null, 'มี "' . $key . '" อยู่แล้ว ให้กดแก้ไขแถวเดิมแทน', 409);
		}

		try {
			$Model->savePermission($type, $key, $flags, $originalKey);
		} catch (\Throwable $e) {
			log_message('error', 'savePermission failed [' . $type . ':' . $key . ']: ' . $e->getMessage());
			return $this->_permissionResponse('error', null, 'บันทึกไม่สำเร็จ กรุณาลองใหม่', 500);
		}

		return $this->_permissionResponse('success', ['type' => $type, 'key' => $key], 'บันทึกข้อมูลสำเร็จ');
	}

	public function deletePermission()
	{
		$denied = $this->_guardPermissionWrite();
		if ($denied) {
			return $denied;
		}

		$type = (string) $this->request->getPost('type');
		$key  = trim((string) $this->request->getPost('key'));

		$error = $this->_validatePermissionKey($type, $key);
		if ($error) {
			return $this->_permissionResponse('error', null, $error, 422);
		}

		try {
			(new Setting_model())->deletePermission($type, $key);
		} catch (\Throwable $e) {
			log_message('error', 'deletePermission failed [' . $type . ':' . $key . ']: ' . $e->getMessage());
			return $this->_permissionResponse('error', null, 'ลบไม่สำเร็จ กรุณาลองใหม่', 500);
		}

		return $this->_permissionResponse('success', ['type' => $type, 'key' => $key], 'ลบข้อมูลสำเร็จ');
	}

	/**
	 * อ่านช่วงวันที่จาก GET (?start=&end= รูปแบบ dd-mm-yyyy ค.ศ.)
	 * ถ้าไม่ส่งมา → default เดือนปัจจุบัน (วันที่ 1 → วันนี้)
	 * คืน array: [start(dd-mm-yyyy), end(dd-mm-yyyy)]
	 */
	private function _logDateRange()
	{
		$start = $this->request->getGet('start');
		$end   = $this->request->getGet('end');

		$isValid = function ($d) {
			return !empty($d) && preg_match('/^\d{2}-\d{2}-\d{4}$/', $d);
		};

		if ($isValid($start) && $isValid($end)) {
			return [$start, $end];
		}

		// default: ตั้งแต่วันที่ 1 ของเดือนปัจจุบัน ถึงวันนี้
		return [date('01-m-Y'), date('d-m-Y')];
	}

	public function log_info()
	{
		$Model = new Setting_model();
		list($start, $end) = $this->_logDateRange();

		$data['Mydate'] = $this->Mydate;
		$data['start_date'] = $start;
		$data['end_date'] = $end;
		$data['data'] = $Model->getLogInfo($start, $end);

		if ($this->request->getGet('export_type') === 'excel') {
			helper('excel_export');
			$data['range_label'] = $start . ' - ' . $end;
			$html = view('Modules\Setting\Views\export\log_info', $data);
			return tat_stream_xlsx_from_html('log_info.xlsx', $html);
		}

		return view('Modules\Setting\Views\log_info',$data);
	}

	public function log_login()
	{
		$Model = new Setting_model();
		list($start, $end) = $this->_logDateRange();

		$data['Mydate'] = $this->Mydate;
		$data['start_date'] = $start;
		$data['end_date'] = $end;
		$data['data'] = $Model->getLogLogin($start, $end);

		if ($this->request->getGet('export_type') === 'excel') {
			helper('excel_export');
			$data['range_label'] = $start . ' - ' . $end;
			$html = view('Modules\Setting\Views\export\log_login', $data);
			return tat_stream_xlsx_from_html('log_login.xlsx', $html);
		}

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
