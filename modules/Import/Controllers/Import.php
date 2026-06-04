<?php

namespace Modules\Import\Controllers;

use Modules\Import\Models\Import_model;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\SimpleXLSX;
use App\Libraries\Mydate;
use Modules\Main\Models\Main_model;
use Modules\Setting\Models\Setting_model;

class Import extends BaseController
{

	use ResponseTrait;

	public function index()
	{
		$data = array();
		$Model = new Import_model();
		$Main_model = new Main_model();
		$Setting_model = new Setting_model();
		$year = date('Y');
		$month = date('m');
		$Setting_model->genRaio($year, $month);

		if(date('d')>28){
			$month_next = $month+1;
			if($month_next>12){
				$month_next = 1;
				$year = $year+1;
			}
			$Setting_model->genRaio($year, $month_next);
		}
		

		$this->Mydate = new Mydate();
		$data['Mydate'] = $this->Mydate;
		$data['date'] = $Main_model->getMaxDate();
		if (!empty($_GET['d'])) {
			$data['date'] = $_GET['d'];
		}

		list($year, $month, $day) = explode('-', $data['date']);
		$data['to_date_label'] = $day . '/' . $month . '/' . $year;

		// $Model->clearDataDaily();
		$data['data'] = $Model->getRawData($data['date']);

		$data['check_ratio_port'] = true;
		if(date('d')>=2){
			$data['check_ratio_port'] = $Model->checkRatioPort(date('Y'),date('m'));
		}

		// ปฏิทินสถานะการนำเข้า: default = เดือนของวันที่ข้อมูลล่าสุด, เลื่อนเดือนผ่าน ?cm=YYYY-MM
		list($cal_year, $cal_month) = explode('-', substr($data['date'], 0, 7));
		if (!empty($_GET['cm']) && preg_match('/^\d{4}-\d{2}$/', $_GET['cm'])) {
			list($cal_year, $cal_month) = explode('-', $_GET['cm']);
		}
		$cal_year = (int)$cal_year; $cal_month = (int)$cal_month;
		$data['cal_year'] = $cal_year;
		$data['cal_month'] = $cal_month;
		$data['cal_data'] = $Model->getImportCalendar($cal_year, $cal_month);
		$data['cal_prev'] = date('Y-m', mktime(0, 0, 0, $cal_month - 1, 1, $cal_year));
		$data['cal_next'] = date('Y-m', mktime(0, 0, 0, $cal_month + 1, 1, $cal_year));
		$data['cal_max_date'] = $Main_model->getMaxDate();

		return view('Modules\Import\Views\index', $data);
	}

	function import_file()
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '3000');
		$Model = new Import_model();
		$data['session'] = session();
		$input = $this->request->getPost();
		$file = $this->request->getFiles();

		if ($xlsx = SimpleXLSX::parse($file['import_file'])) {
			$input['import_file_name'] = $file['import_file']->getClientName();
			$data['text'] = $Model->import_file($input, $xlsx);
		}

		return view('Modules\Import\Views\detail', $data);
	}

	public function monthly()
	{
		$data = array();
		$Model = new Import_model();
		$Main_model = new Main_model();
		$data['month_label'] = $this->month_en;
		$data['year'] = date('Y');
		$data['data'] = $Model->getDataMonthly($data['year']);

		return view('Modules\Import\Views\monthly', $data);
	}

	function import_file_monthly()
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '3000');
		$Model = new Import_model();
		$data['session'] = session();
		$input = $this->request->getPost();
		$file = $this->request->getFiles();

		if ($xlsx = SimpleXLSX::parse($file['import_file'])) {
			$data['text'] = $Model->import_file_monthly($input, $xlsx);
		}

		return view('Modules\Import\Views\detail', $data);
	}

	public function raw_monthly()
	{
		$data = array();
		$Model = new Import_model();
		$Main_model = new Main_model();
		$data['month_label'] = $this->month_en;
		$data['year'] = date('Y');
		$data['month'] = date('m');
		if (!empty($_GET['m'])) {
			$data['month'] = $_GET['m'];
		}
		if (!empty($_GET['y'])) {
			$data['year'] = $_GET['y'];
		}
		$data['port'] = $Model->getPortMonthly();
		$data['point'] = $Model->getPointMonthly();
		$data['data'] = $Model->getRawDataMonthly($data['year'],$data['month']);

		return view('Modules\Import\Views\raw_monthly', $data);
	}

	function import_file_raw_monthly()
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '3000');
		$Model = new Import_model();
		$data['session'] = session();
		$input = $this->request->getPost();
		$file = $this->request->getFiles();

		if ($xlsx = SimpleXLSX::parse($file['import_file'])) {
			$data['text'] = $Model->import_file_raw_monthly($input, $xlsx);
		}

		return view('Modules\Import\Views\detail', $data);
	}

	function updateCalReportDaily($year,$month,$day){
		$Model = new Import_model();
		$Model->updateCalReportDaily($year,$month,$day);
	}
}
