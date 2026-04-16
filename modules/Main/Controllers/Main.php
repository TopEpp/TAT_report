<?php

namespace Modules\Main\Controllers;

use App\Controllers\BaseController;
use Modules\Main\Models\Main_model;
use Modules\Main\Models\Activity_model;
use Modules\Report\Models\Report_model;
use Modules\Setting\Models\Setting_model;
use CodeIgniter\API\ResponseTrait;
// use App\Libraries\DataGovApi; // ยังไม่ได้ใช้ — ข้อมูลมาจาก hardcode ชั่วคราว

class Main extends BaseController
{

	use ResponseTrait;

	public function index()
	{
		$data['session'] = session();
		$ses_data = ['report_type' => 'none'];
		$data['session']->set($ses_data);
		$data['Mydate'] = $this->Mydate;
		$Setting_model = new Setting_model();
		$year = date('Y');
		$month = date('m');
		$Setting_model->genRaio($year, $month);
		// return view("Modules\Main\Views\index", $data);

		// http_redirect(base_url('main/daily'));
		return redirect()->to('main/daily');
	}

	public function daily()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();

		$Setting_model = new Setting_model();
		$Setting_model->updateVisaRatioMonth(date('Y'), date('m'));

		$data['session'] = session();
		$ses_data = ['report_type' => 'daily'];
		$data['session']->set($ses_data);

		$data['Mydate'] = $this->Mydate;
		// $date = date('Y-m-d');
		$month = date('m');

		$data['year'] = date('Y');
		$data['month'] = $month;
		$data['month_label'] = $this->month_th_short[(int)$month];
		$data['start_date'] = '01-01-' . (date('Y'));
		// $data['end_date'] = date('d-m-Y');
		$data['country_type'] = 'all';

		$end_date = $Model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_date'] = $day . '-' . $month . '-' . $year;

		if (!empty($_GET['start_date'])) {
			$data['start_date'] = $_GET['start_date'];
		}
		if (!empty($_GET['end_date'])) {
			$data['end_date'] = $_GET['end_date'];
		}

		list($day, $month, $year) = explode('-', $data['start_date']);
		$start_date = $year . '-' . $month . '-' . $day;
		$start_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['start_date_label'] = $start_date;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['end_date_label'] = $end_date;
		$data['year'] = $year;

		$date_now =  strtotime($start_date);
		$date2    =  strtotime($end_date);

		if ($date_now > $date2) {
			list($day, $month, $year) = explode('-', $data['start_date']);
			$end_date = $year . '-' . $month . '-' . $day;
			$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
			$data['end_date_label'] = $end_date;
			$data['year'] = $year;
		}


		$data['to_date'] = $end_date;
		$prev_date = date('Y-m-d', strtotime($end_date . ' -15 day'));
		$data['period'] = $data['Mydate']->date_range($prev_date, $end_date);

		$data['SumDateData'] = $Model->getSumDate($end_date);
		$data['SumMonthData'] = $Model->getSumMonth($start_date, $end_date);
		$data['SumDateData_past'] = $Model->getSumDate($end_date_past);
		$data['SumMonthData_past'] = $Model->getSumMonth($start_date_past, $end_date_past);

		$data['SumNatDateData'] = $Model->getSumNatDate($end_date);
		$data['SumNatMonthData'] = $Model->getSumNatMonth($start_date, $end_date);
		$data['SumPortDateData'] = $Model->getSumPortDate($end_date);
		$data['SumPortMonthData'] = $Model->getSumPortMonth($start_date, $end_date);

		$data['SumRegionDateData'] = $Model->getSumRegionDate($end_date);
		$data['SumRegionMonthData'] = $Model->getSumRegionMonth($start_date, $end_date);
		$data['SumCountryDateData'] = $Model->getSumCountryDate($end_date);
		$data['SumCountryMonthData'] = $Model->getSumCountryMonth($start_date, $end_date);

		$data['region'] = $Report_model->getSTDRegion('standard');
		$data['sub_region'] = $Model->getSubRegion();
		$data['country_region'] = $Report_model->getCountryByRegion('standard');

		$data['SumChartData'] = $Model->getSumChart($end_date);
		$data['SumChartDataYear'] = $Model->getSumChartYear($data['year']);
		$data['api_code'] = $this->Api_Code;
		return view("Modules\Main\Views\daily", $data);
	}

	function update_country()
	{
		$Model = new Main_model();
		$Model->update_country();
	}

	function monthly()
	{


		// $Model = new Main_model();
		// $Report_model = new Report_model();
		// $data['session'] = session();
		// $ses_data = ['report_type' => 'monthly'];
		// $data['session']->set($ses_data);

		// $data['Mydate'] = $this->Mydate;
		// $data['month'] = date('m');
		// $data['year'] = date('Y');
		// $data['to_date'] = date('d-m-Y');
		// $data['limit'] = 5;
		// $data['month_label'] = $this->month_th;

		// if (!empty($_GET['month'])) {
		// 	$data['month'] = $_GET['month'];
		// }
		// if (!empty($_GET['year'])) {
		// 	$data['year'] = $_GET['year'];
		// }
		// if (!empty($_GET['limit'])) {
		// 	$data['limit'] = $_GET['limit'];
		// }

		// $data['SumMonth'] = $Model->getSumMonthly($data['year']);
		// $data['SumMonth_past'] = $Model->getSumMonthly(($data['year'] - 1));
		// $data['SumRegionDateData'] = $Model->getSumMonthlyRegion($data['month'], $data['year']);
		// $data['SumRegionDateData_past'] = $Model->getSumMonthlyRegion($data['month'], $data['year'] - 1);
		// $data['SumCountry'] = $Model->getSumMonthlyCountry($data['month'], $data['year'], $data['limit']);


		// $data['export_type'] = @$_GET['export_type'];

		// if (@$_GET['export_type'] == 'pdf') {
		// 	$this->export_pdf('Modules\Main\Views\export\monthly', $data);
		// } else {
		// 	return view("Modules\Main\Views\monthly", $data);
		// }

		$Model = new Main_model();
		$data['session'] = session();
		$ses_data = ['report_type' => 'monthly'];
		$data['session']->set($ses_data);
		$data['Mydate'] = $this->Mydate;
		$data['month'] = 1;
		$data['month2'] = date('m');
		$data['year'] = date('Y');
		$data['limit'] = 5;
		$data['month_label'] = $this->month_th;
		$data['to_date'] = date('d-m-Y');

		if (!empty($_GET['month'])) {
			$data['month'] = $_GET['month'];
		}
		if (!empty($_GET['month2'])) {
			$data['month2'] = $_GET['month2'];
		}
		if (!empty($_GET['year'])) {
			$data['year'] = $_GET['year'];
		}
		if (!empty($_GET['limit'])) {
			$data['limit'] = $_GET['limit'];
		}

		$data['SumMonth'] = $Model->getSumMonthly($data['year']);
		$data['SumMonth_past'] = $Model->getSumMonthly(($data['year'] - 1));
		$data['SumRegionDateData'] = $Model->getSumMonthlyRegionPeriod($data['month'], $data['month2'], $data['year']);
		$data['SumRegionDateData_past'] = $Model->getSumMonthlyRegionPeriod($data['month'], $data['month2'], $data['year'] - 1);
		$data['SumCountry'] = $Model->getSumMonthlyCountryPeriod($data['month'], $data['month2'], $data['year'], $data['limit']);
		$data['export_type'] = @$_GET['export_type'];

		if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Main\Views\export\monthly_period', $data);
		} else {
			return view("Modules\Main\Views\monthly_period", $data);
		}
	}

	function monthly_period()
	{
		$Model = new Main_model();
		$data['session'] = session();
		$ses_data = ['report_type' => 'monthly'];
		$data['session']->set($ses_data);
		$data['Mydate'] = $this->Mydate;
		$data['month'] = 1;
		$data['month2'] = date('m');
		$data['year'] = date('Y');
		$data['limit'] = 5;
		$data['month_label'] = $this->month_th;
		$data['to_date'] = date('d-m-Y');

		if (!empty($_GET['month'])) {
			$data['month'] = $_GET['month'];
		}
		if (!empty($_GET['month2'])) {
			$data['month2'] = $_GET['month2'];
		}
		if (!empty($_GET['year'])) {
			$data['year'] = $_GET['year'];
		}
		if (!empty($_GET['limit'])) {
			$data['limit'] = $_GET['limit'];
		}

		$data['SumMonth'] = $Model->getSumMonthly($data['year']);
		$data['SumMonth_past'] = $Model->getSumMonthly(($data['year'] - 1));
		$data['SumRegionDateData'] = $Model->getSumMonthlyRegionPeriod($data['month'], $data['month2'], $data['year']);
		$data['SumRegionDateData_past'] = $Model->getSumMonthlyRegionPeriod($data['month'], $data['month2'], $data['year'] - 1);
		$data['SumCountry'] = $Model->getSumMonthlyCountryPeriod($data['month'], $data['month2'], $data['year'], $data['limit']);
		$data['export_type'] = @$_GET['export_type'];

		if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Main\Views\export\monthly_period', $data);
		} else {
			return view("Modules\Main\Views\monthly_period", $data);
		}
	}


	################## EXPORT ##################



	public function export_dashboard()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();
		$data['session'] = session();
		$ses_data = ['report_type' => 'daily'];
		$data['session']->set($ses_data);

		$data['Mydate'] = $this->Mydate;
		// $date = date('Y-m-d');
		$month = date('m');

		$data['year'] = date('Y');
		$data['month'] = $month;
		$data['month_label'] = $this->month_th_short[(int)$month];
		$data['start_date'] = '01-01-' . date('Y');
		// $data['end_date'] = date('d-m-Y');
		$data['country_type'] = 'all';

		$end_date = $Model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_date'] = $day . '-' . $month . '-' . $year;

		if (!empty($_GET['start_date'])) {
			$data['start_date'] = $_GET['start_date'];
		}
		if (!empty($_GET['end_date'])) {
			$data['end_date'] = $_GET['end_date'];
		}

		list($day, $month, $year) = explode('-', $data['start_date']);
		$start_date = $year . '-' . $month . '-' . $day;
		$start_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['start_date_label'] = $start_date;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['end_date_label'] = $end_date;

		if ($date_now > $date2) {
			list($day, $month, $year) = explode('-', $data['start_date']);
			$end_date = $year . '-' . $month . '-' . $day;
			$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
			$data['end_date_label'] = $end_date;
			$data['year'] = $year;
		}


		$data['to_date'] = $end_date;
		$prev_date = date('Y-m-d', strtotime($end_date . ' -15 day'));
		$data['period'] = $data['Mydate']->date_range($prev_date, $end_date);

		$data['SumDateData'] = $Model->getSumDate($end_date);
		$data['SumMonthData'] = $Model->getSumMonth($start_date, $end_date);
		$data['SumDateData_past'] = $Model->getSumDate($end_date_past);
		$data['SumMonthData_past'] = $Model->getSumMonth($start_date_past, $end_date_past);

		$data['SumNatDateData'] = $Model->getSumNatDate($end_date);
		$data['SumNatMonthData'] = $Model->getSumNatMonth($start_date, $end_date);
		$data['SumPortDateData'] = $Model->getSumPortDate($end_date);
		$data['SumPortMonthData'] = $Model->getSumPortMonth($start_date, $end_date);

		// $data['SumRegionDateData'] = $Model->getSumRegionDate($end_date);
		// $data['SumRegionMonthData'] = $Model->getSumRegionMonth($start_date, $end_date);
		// $data['SumCountryDateData'] = $Model->getSumCountryDate($end_date);
		// $data['SumCountryMonthData'] = $Model->getSumCountryMonth($start_date, $end_date);

		// $data['region'] = $Report_model->getSTDRegion('standard');
		// $data['sub_region'] = $Model->getSubRegion();
		// $data['country_region'] = $Report_model->getCountryByRegion('standard');

		// $data['SumChartData'] = $Model->getSumChart($end_date);
		// $data['api_code'] = $this->Api_Code;

		// return view('Modules\Main\Views\export\dashboard', $data);
		$this->export_pdf('Modules\Main\Views\export\dashboard_v1', $data);
	}



	function export_pdf($view, $data, $orientation = 'L')
	{
		$html = view($view, $data);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf = new \Mpdf\Mpdf([
			'default_font' => 'tatsana',
			'default_font_size' => 10,
			'mode' => 'utf-8',
			'format' => 'A4',
			'margin_top' => 3,
			'margin_bottom' => 2,
			'margin_left' => 2,
			'margin_right' => 2,
			'margin_header' => 0, // 30mm not pixel
			'margin_footer' => 0, // 10mm
			'orientation' => 'L', // L แนวนอน P แนวตั้งง
		]);

		// $footer = '<table width="100%" border=0 style="border:0px">
		//         <tr border=0 style="border:0px ">
		//           <td align="left" border=0 style="border:0px ">
		//             <img src="' . base_url('public/img/logotat.png') . '">
		//           </td>
		//           <td align="right" border=0 style="border:0px;color:white ">
		//             Source of Data : Tourism Authority of Thailand <br>
		//             As of : ' . date('d M Y H:i:s') . '
		//           </td>
		//         </tr>
		//       </table>';
		// $mpdf->SetFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

	public function export_dashboard_v2()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();
		$data['session'] = session();
		$ses_data = ['report_type' => 'daily'];
		$data['session']->set($ses_data);

		$data['Mydate'] = $this->Mydate;
		// $date = date('Y-m-d');
		$month = date('m');

		$data['year'] = date('Y');
		$data['month'] = $month;
		$data['month_label'] = $this->month_th_short[(int)$month];
		$data['start_date'] = '01-01-' . date('Y');
		// $data['end_date'] = date('d-m-Y');
		$data['country_type'] = 'all';

		$end_date = $Model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_date'] = $day . '-' . $month . '-' . $year;

		if (!empty($_GET['start_date'])) {
			$data['start_date'] = $_GET['start_date'];
		}
		if (!empty($_GET['end_date'])) {
			$data['end_date'] = $_GET['end_date'];
		}

		list($day, $month, $year) = explode('-', $data['start_date']);
		$start_date = $year . '-' . $month . '-' . $day;
		$start_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['start_date_label'] = $start_date;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$day_past = $day - 1;
		if ($day_past <= 0) {
			$day_past = 1;
			$month_past = $month - 1;
			if ($month_past <= 0) {
				$month_past = 12;
			}
			$a_date = $year . '-' . $month_past . '-' . $day_past;
			$end_date_past = date("Y-m-t", strtotime($a_date));
		} else {
			$end_date_past = $year . '-' . $month . '-' . $day_past;
		}

		list($year, $month, $day) = explode('-', $end_date_past);
		$data['end_date_past'] = $day . '-' . $month . '-' . $year;

		$data['end_date_label'] = $end_date;

		$data['to_date'] = $end_date;
		$prev_date = date('Y-m-d', strtotime($end_date . ' -15 day'));
		$data['period'] = $data['Mydate']->date_range($prev_date, $end_date);

		$data['SumDateData'] = $Model->getSumDate($end_date);
		$data['SumMonthData'] = $Model->getSumMonth($start_date, $end_date);
		$data['SumNatDateData'] = $Model->getSumNatDate($end_date);
		$data['SumNatDateData_past'] = $Model->getSumNatDate($end_date_past);
		$data['SumNatMonthData'] = $Model->getSumNatMonth($start_date, $end_date);

		$data['SumMarketDate'] = $Report_model->getMarketData($data['end_date'], $data['end_date']);
		$data['SumMarketDate_past'] = $Report_model->getMarketData($data['end_date_past'], $data['end_date_past']);
		$data['SumMarketMonth'] = $Report_model->getMarketData($data['start_date'], $data['end_date']);
		$data['country_market'] = $Report_model->getCountryByMarket();


		// echo '<pre>';
		// print_r($data['SumMarketDate']);
		// echo '</pre>';
		// die();
		// return view('Modules\Main\Views\export\dashboard', $data);
		$this->export_pdf2('Modules\Main\Views\export\dashboard', $data);
	}

	public function export_dashboard_view()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();
		$data['session'] = session();
		$ses_data = ['report_type' => 'daily'];
		$data['session']->set($ses_data);

		$data['Mydate'] = $this->Mydate;
		// $date = date('Y-m-d');
		$month = date('m');

		$data['year'] = date('Y');
		$data['month'] = $month;
		$data['month_label'] = $this->month_th_short[(int)$month];
		$data['start_date'] = '01-01-' . date('Y');
		// $data['end_date'] = date('d-m-Y');
		$data['country_type'] = 'all';

		$end_date = $Model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_date'] = $day . '-' . $month . '-' . $year;

		if (!empty($_GET['start_date'])) {
			$data['start_date'] = $_GET['start_date'];
		}
		if (!empty($_GET['end_date'])) {
			$data['end_date'] = $_GET['end_date'];
		}

		list($day, $month, $year) = explode('-', $data['start_date']);
		$start_date = $year . '-' . $month . '-' . $day;
		$start_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['start_date_label'] = $start_date;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$day_past = $day - 1;
		if ($day_past <= 0) {
			$day_past = 1;
			$month_past = $month - 1;
			if ($month_past <= 0) {
				$month_past = 12;
			}
			$a_date = $year . '-' . $month_past . '-' . $day_past;
			$end_date_past = date("Y-m-t", strtotime($a_date));
		} else {
			$end_date_past = $year . '-' . $month . '-' . $day_past;
		}

		list($year, $month, $day) = explode('-', $end_date_past);
		$data['end_date_past'] = $day . '-' . $month . '-' . $year;

		$data['end_date_label'] = $end_date;

		$data['to_date'] = $end_date;
		$prev_date = date('Y-m-d', strtotime($end_date . ' -15 day'));
		$data['period'] = $data['Mydate']->date_range($prev_date, $end_date);

		$data['SumDateData'] = $Model->getSumDate($end_date);
		$data['SumMonthData'] = $Model->getSumMonth($start_date, $end_date);
		$data['SumNatDateData'] = $Model->getSumNatDate($end_date);
		$data['SumNatDateData_past'] = $Model->getSumNatDate($end_date_past);
		$data['SumNatMonthData'] = $Model->getSumNatMonth($start_date, $end_date);

		$data['SumMarketDate'] = $Report_model->getMarketData($data['end_date'], $data['end_date']);
		$data['SumMarketDate_past'] = $Report_model->getMarketData($data['end_date_past'], $data['end_date_past']);
		$data['SumMarketMonth'] = $Report_model->getMarketData($data['start_date'], $data['end_date']);
		$data['country_market'] = $Report_model->getCountryByMarket();


		return view('Modules\Main\Views\export\dashboard_view', $data);
	}

	function export_pdf2($view, $data, $orientation = 'P')
	{
		$html = view($view, $data);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf = new \Mpdf\Mpdf([
			'default_font' => 'tatsana',
			'default_font_size' => 10,
			'mode' => 'utf-8',
			'format' => 'A4',
			'margin_top' => 0,
			'margin_bottom' => 0,
			'margin_left' => 2,
			'margin_right' => 2,
			'margin_header' => 0, // 30mm not pixel
			'margin_footer' => 0, // 10mm
			'orientation' => 'L', // L แนวนอน P แนวตั้งง
		]);
		// $mpdf->curlAllowUnsafeSslRequests = true;
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

	function saveImg2Report()
	{
		$uploaddir = ROOTPATH;
		$uploaddir = explode('system', $uploaddir);
		$uploaddir = $uploaddir[0];
		$uploadpath = 'public/uploads/main/';
		$uploadfile = $uploaddir . $uploadpath;

		$imgName = $_POST['imgName'] ?? 'export';
		$file = $uploadfile . $imgName . '.png';

		// รองรับ file upload (FormData)
		if (isset($_FILES['imgFile']) && $_FILES['imgFile']['error'] === UPLOAD_ERR_OK) {
			move_uploaded_file($_FILES['imgFile']['tmp_name'], $file);
		}
		// รองรับ base64 (PNG หรือ JPEG)
		elseif (isset($_POST['imgBase64'])) {
			$img = $_POST['imgBase64'];
			$img = preg_replace('/^data:image\/(png|jpeg);base64,/', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			@file_put_contents($file, $data);
		}

		return $this->setResponseFormat('json')->respond($file);
	}

	function saveImg2ReportJPG()
	{
		$uploaddir = ROOTPATH;
		$uploaddir = explode('system', $uploaddir);
		$uploaddir = $uploaddir[0];
		$uploadpath = 'public/uploads/main/';
		$uploadfile = $uploaddir . $uploadpath;

		$img = $_POST['imgBase64'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = $uploadfile . $_POST['imgName'] . '.png';

		// Remove the old image file if it exists
		if (file_exists($file)) {
			unlink($file);
		}

		$success = file_put_contents($file, $data);
		$this->convPNGtoJPG($file, $_POST['imgName']);

		return $this->setResponseFormat('json')->respond($file);
	}

	function export_region_pdf()
	{
		$imgName = $this->request->getGet('img');
		$uploaddir = ROOTPATH;
		$uploaddir = explode('system', $uploaddir);
		$uploaddir = $uploaddir[0];
		$imgPath = $uploaddir . 'public/uploads/main/' . $imgName . '.png';

		if (!file_exists($imgPath)) {
			return $this->response->setStatusCode(404, 'Image not found');
		}

		// ตรวจสอบประเภทไฟล์
		$imgInfo = getimagesize($imgPath);
		$imgW = $imgInfo[0];
		$imgH = $imgInfo[1];
		$imgType = image_type_to_extension($imgInfo[2], false); // png, jpeg, etc.
		$ratio = $imgW / $imgH;

		// ใช้ custom format ขนาดพอดีกับรูป (landscape)
		$pageW = 287; // A4 landscape width mm
		$imgH_mm = $pageW / $ratio;

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => [$pageW + 10, $imgH_mm + 10],
			'margin_top' => 5,
			'margin_bottom' => 5,
			'margin_left' => 5,
			'margin_right' => 5,
		]);

		$mpdf->Image($imgPath, 5, 5, $pageW, $imgH_mm, $imgType, '', true, false);

		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output('region_dashboard.pdf', 'I');
	}

	function convPNGtoJPG($filePath, $file_name)
	{
		$uploaddir = ROOTPATH;
		$uploaddir = explode('system', $uploaddir);
		$uploaddir = $uploaddir[0];
		$uploadpath = 'public/uploads/main/';
		$uploadfile = $uploaddir . $uploadpath;
		$file = $uploadfile . $file_name;
		$jpgFile = $file . ".jpg";

		// Remove the old JPG image file if it exists
		if (file_exists($jpgFile)) {
			unlink($jpgFile);
		}

		$image = imagecreatefrompng($filePath);
		$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
		imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
		imagealphablending($bg, TRUE);
		imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
		imagedestroy($image);
		$quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
		imagejpeg($bg, $file . ".jpg", $quality);
		imagedestroy($bg);
	}

	function saveLog()
	{
		$Model = new Main_model();
		$session = session();
		$type = $this->request->getPost('type');
		$ip = $this->request->getIPAddress();

		return $Model->saveLog($type, $ip, $session);
	}


	function departure()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();
		$Setting_model = new Setting_model();

		$data['session'] = session();
		$ses_data = ['report_type' => 'daily'];
		$data['session']->set($ses_data);

		$data['Mydate'] = $this->Mydate;
		$month = date('m');

		$data['year'] = date('Y');
		$data['month'] = $month;
		$data['month_label'] = $this->month_th_short[(int)$month];
		$data['start_date'] = '01-01-' . (date('Y'));
		$data['country_type'] = 'all';

		$end_date = $Model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_date'] = $day . '-' . $month . '-' . $year;

		if (!empty($_GET['start_date'])) {
			$data['start_date'] = $_GET['start_date'];
		}
		if (!empty($_GET['end_date'])) {
			$data['end_date'] = $_GET['end_date'];
		}

		list($day, $month, $year) = explode('-', $data['start_date']);
		$start_date = $year . '-' . $month . '-' . $day;
		$start_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['start_date_label'] = $start_date;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['end_date_label'] = $end_date;
		$data['year'] = $year;

		$data['check_noti_month'] = false;
		$data['check_noti_month_label'] = '';
		if ($day < cal_days_in_month(CAL_GREGORIAN, $month, $year)) {
			$data['check_noti_month'] = $month * 1;
			$data['check_noti_month_label'] = '* หมายเหตุ : ข้อมูลถึงวันที่ ' . $this->Mydate->date_eng2thai($end_date, 543, 'S', 'S');
		}

		$date_now =  strtotime($start_date);
		$date2    =  strtotime($end_date);

		if ($date_now > $date2) {
			list($day, $month, $year) = explode('-', $data['start_date']);
			$end_date = $year . '-' . $month . '-' . $day;
			$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
			$data['end_date_label'] = $end_date;
			$data['year'] = $year;
		}


		$data['to_date'] = $end_date;
		$prev_date = date('Y-m-d', strtotime($end_date . ' -15 day'));
		$data['period'] = $data['Mydate']->date_range($prev_date, $end_date);

		// $data['SumDateData'] = $Model->getSumOutDate($end_date);
		// $data['SumMonthData'] = $Model->getSumOutMonth($start_date, $end_date);
		// $data['SumDateData_past'] = $Model->getSumOutDate($end_date_past);
		// $data['SumMonthData_past'] = $Model->getSumOutMonth($start_date_past, $end_date_past);

		$data['DataChartDate'] = $Model->getOuterChartDate($data['year']);
		$data['SumChartData'] = $Model->getSumOutChart($end_date);
		$data['SumChartDataYear'] = $Model->getSumOutChartYear($data['year']);

		// $data['SumChartData_Air'] = $Model->getSumOutChart($end_date,'ด่านอากาศ');
		$data['SumChartDataYear_Air'] = $Model->getSumOutChartYear($data['year'], 'ด่านอากาศ');

		$data['SumPort'] = $Model->getSumOutSumPort($data['year']);

		return view("Modules\Main\Views\departure", $data);
	}

	function export_departure()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();
		$Setting_model = new Setting_model();

		$data['session'] = session();
		$ses_data = ['report_type' => 'daily'];
		$data['session']->set($ses_data);

		$data['Mydate'] = $this->Mydate;
		$month = date('m');

		$data['year'] = date('Y');
		$data['month'] = $month;
		$data['month_label'] = $this->month_th_short[(int)$month];
		$data['start_date'] = '01-01-' . (date('Y'));
		$data['country_type'] = 'all';

		$end_date = $Model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_date'] = $day . '-' . $month . '-' . $year;

		if (!empty($_GET['start_date'])) {
			$data['start_date'] = $_GET['start_date'];
		}
		if (!empty($_GET['end_date'])) {
			$data['end_date'] = $_GET['end_date'];
		}

		list($day, $month, $year) = explode('-', $data['start_date']);
		$start_date = $year . '-' . $month . '-' . $day;
		$start_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['start_date_label'] = $start_date;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['end_date_label'] = $end_date;
		$data['year'] = $year;

		$data['check_noti_month'] = false;
		$data['check_noti_month_label'] = '';
		if ($day < cal_days_in_month(CAL_GREGORIAN, $month, $year)) {
			$data['check_noti_month'] = $month * 1;
			$data['check_noti_month_label'] = '* หมายเหตุ : ข้อมูลถึงวันที่ ' . $this->Mydate->date_eng2thai($end_date, 543, 'S', 'S');
		}

		$date_now =  strtotime($start_date);
		$date2    =  strtotime($end_date);

		if ($date_now > $date2) {
			list($day, $month, $year) = explode('-', $data['start_date']);
			$end_date = $year . '-' . $month . '-' . $day;
			$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
			$data['end_date_label'] = $end_date;
			$data['year'] = $year;
		}


		$data['to_date'] = $end_date;
		$prev_date = date('Y-m-d', strtotime($end_date . ' -15 day'));
		$data['period'] = $data['Mydate']->date_range($prev_date, $end_date);

		// $data['SumDateData'] = $Model->getSumOutDate($end_date);
		// $data['SumMonthData'] = $Model->getSumOutMonth($start_date, $end_date);
		// $data['SumDateData_past'] = $Model->getSumOutDate($end_date_past);
		// $data['SumMonthData_past'] = $Model->getSumOutMonth($start_date_past, $end_date_past);

		$data['DataChartDate'] = $Model->getOuterChartDate($data['year']);
		$data['SumChartData'] = $Model->getSumOutChart($end_date);
		$data['SumChartDataYear'] = $Model->getSumOutChartYear($data['year']);

		// $data['SumChartData_Air'] = $Model->getSumOutChart($end_date,'ด่านอากาศ');
		$data['SumChartDataYear_Air'] = $Model->getSumOutChartYear($data['year'], 'ด่านอากาศ');

		$data['SumPort'] = $Model->getSumOutSumPort($data['year']);

		$orientation = @$_GET['orientation'];
		if (@$_GET['export'] == 'pdf') {
			$this->export_pdf('Modules\Main\Views\export\departure', $data, $orientation);
		} else {
			return view('Modules\Main\Views\export\departure_view', $data);
		}
	}

	function country()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();
		$Setting_model = new Setting_model();
		// $Setting_model->updateVisaRatioMonth(date('Y'),date('m'));
		$data['session'] = session();
		$ses_data = ['report_type' => 'daily'];
		$data['session']->set($ses_data);

		$data['Mydate'] = $this->Mydate;
		// $date = date('Y-m-d');
		$month = date('m');
		$data['country_id'] = 154; //CHina
		$data['year'] = date('Y');
		$data['month'] = $month;
		$data['month_label'] = $this->month_th_short[(int)$month];
		$data['start_date'] = '01-01-' . (date('Y'));
		// $data['end_date'] = date('d-m-Y');
		$data['country_type'] = 'all';

		$end_date = $Model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_date'] = $day . '-' . $month . '-' . $year;

		if (!empty($_GET['start_date'])) {
			$data['start_date'] = $_GET['start_date'];
		}
		if (!empty($_GET['end_date'])) {
			$data['end_date'] = $_GET['end_date'];
		}
		if (!empty($_GET['country_id'])) {
			$data['country_id'] = $_GET['country_id'];
		}

		list($day, $month, $year) = explode('-', $data['start_date']);
		$start_date = $year . '-' . $month . '-' . $day;
		$start_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['start_date_label'] = $start_date;
		$data['start_date_label_past'] = $start_date_past;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['end_date_label'] = $end_date;
		$data['end_date_label_past'] = $end_date_past;
		$data['year'] = $year;

		$date_now =  strtotime($start_date);
		$date2    =  strtotime($end_date);

		if ($date_now > $date2) {
			list($day, $month, $year) = explode('-', $data['start_date']);
			$end_date = $year . '-' . $month . '-' . $day;
			$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
			$data['end_date_label'] = $end_date;
			$data['year'] = $year;
		}

		$prev_date = date('Y-m-d', strtotime($end_date . ' -6 day'));
		$data['prev_date'] = $prev_date;
		$data['period'] = $data['Mydate']->date_range($prev_date, $end_date);
		$data['country'] = $Report_model->getCountryAllRow();

		list($year, $month, $day) = explode('-', $prev_date);
		$prev_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['prev_date_past'] = $prev_date_past;

		list($year, $month, $day) = explode('-', $end_date);
		$data['to_date_past'] = ($year - 1) . '-' . $month . '-' . $day;


		$prev_date_week = date('Y-m-d', strtotime($prev_date . ' -7 day'));
		$end_date_week = date('Y-m-d', strtotime($end_date . ' -7 day'));


		$data['SumDateData'] = $Model->getSumDate($end_date, $data['country_id']);
		$data['SumMonthData'] = $Model->getSumMonth($start_date, $end_date, $data['country_id']);
		$data['SumDateData_past'] = $Model->getSumDate($end_date_past, $data['country_id']);
		$data['SumMonthData_past'] = $Model->getSumMonth($start_date_past, $end_date_past, $data['country_id']);
		$data['SumWeekData'] = $Model->getSumMonth($prev_date, $end_date, $data['country_id']);
		$data['SumWeekData_past'] = $Model->getSumMonth($prev_date_week, $end_date_week, $data['country_id']);

		$data['SumPortType'] = $Model->getSumPortType($start_date, $end_date, $data['country_id']);
		$data['DataChart'] = $Model->getSumChartCountry($end_date, $data['country_id']);

		// echo $prev_date.' - '.$end_date.'<br>';
		// echo $prev_date_week.' - '.$end_date_week;

		return view("Modules\Main\Views\country", $data);
	}

	function export_country()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();
		$Setting_model = new Setting_model();
		// $Setting_model->updateVisaRatioMonth(date('Y'),date('m'));
		$data['session'] = session();
		$ses_data = ['report_type' => 'daily'];
		$data['session']->set($ses_data);

		$data['Mydate'] = $this->Mydate;
		// $date = date('Y-m-d');
		$month = date('m');
		$data['country_id'] = 154; //CHina
		$data['year'] = date('Y');
		$data['month'] = $month;
		$data['month_label'] = $this->month_th_short[(int)$month];
		$data['start_date'] = '01-01-' . (date('Y'));
		// $data['end_date'] = date('d-m-Y');
		$data['country_type'] = 'all';

		$end_date = $Model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_date'] = $day . '-' . $month . '-' . $year;

		if (!empty($_GET['start_date'])) {
			$data['start_date'] = $_GET['start_date'];
		}
		if (!empty($_GET['end_date'])) {
			$data['end_date'] = $_GET['end_date'];
		}
		if (!empty($_GET['country_id'])) {
			$data['country_id'] = $_GET['country_id'];
		}

		list($day, $month, $year) = explode('-', $data['start_date']);
		$start_date = $year . '-' . $month . '-' . $day;
		$start_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['start_date_label'] = $start_date;
		$data['start_date_label_past'] = $start_date_past;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['end_date_label'] = $end_date;
		$data['end_date_label_past'] = $end_date_past;
		$data['year'] = $year;

		$date_now =  strtotime($start_date);
		$date2    =  strtotime($end_date);

		if ($date_now > $date2) {
			list($day, $month, $year) = explode('-', $data['start_date']);
			$end_date = $year . '-' . $month . '-' . $day;
			$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
			$data['end_date_label'] = $end_date;
			$data['year'] = $year;
		}

		$data['to_date'] = $end_date;
		$prev_date = date('Y-m-d', strtotime($end_date . ' -6 day'));
		$data['prev_date'] = $prev_date;
		$data['period'] = $data['Mydate']->date_range($prev_date, $end_date);
		$data['country'] = $Report_model->getCountryAllRow();

		list($year, $month, $day) = explode('-', $prev_date);
		$prev_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['prev_date_past'] = $prev_date_past;

		list($year, $month, $day) = explode('-', $end_date);
		$data['to_date_past'] = ($year - 1) . '-' . $month . '-' . $day;


		$prev_date_week = date('Y-m-d', strtotime($prev_date . ' -7 day'));
		$end_date_week = date('Y-m-d', strtotime($end_date . ' -7 day'));


		$data['SumDateData'] = $Model->getSumDate($end_date, $data['country_id']);
		$data['SumMonthData'] = $Model->getSumMonth($start_date, $end_date, $data['country_id']);
		$data['SumDateData_past'] = $Model->getSumDate($end_date_past, $data['country_id']);
		$data['SumMonthData_past'] = $Model->getSumMonth($start_date_past, $end_date_past, $data['country_id']);
		$data['SumWeekData'] = $Model->getSumMonth($prev_date, $end_date, $data['country_id']);
		$data['SumWeekData_past'] = $Model->getSumMonth($prev_date_week, $end_date_week, $data['country_id']);

		$data['SumPortType'] = $Model->getSumPortType($start_date, $end_date, $data['country_id']);
		$data['DataChart'] = $Model->getSumChartCountry($end_date, $data['country_id']);


		if (@$_GET['export'] == 'pdf') {
			$this->export_pdf('Modules\Main\Views\export\country', $data);
		} else {
			return view('Modules\Main\Views\export\country_view', $data);
		}
	}

	function region()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();
		$data['session'] = session();
		$ses_data = ['report_type' => 'daily'];
		$data['session']->set($ses_data);

		$data['Mydate'] = $this->Mydate;
		$data['Date_thai'] = $this->Date_thai;
		$month = date('m');
		$data['year'] = date('Y');
		$data['month'] = $month;
		$data['month_label'] = $this->month_th_short[(int)$month];
		$data['start_date'] = '01-01-' . (date('Y'));
		$data['country_type'] = 'all';

		$end_date = $Model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_date'] = $day . '-' . $month . '-' . $year;

		if (!empty($_GET['start_date'])) {
			$data['start_date'] = $_GET['start_date'];
		}
		if (!empty($_GET['end_date'])) {
			$data['end_date'] = $_GET['end_date'];
		}

		list($day, $month, $year) = explode('-', $data['start_date']);
		$start_date = $year . '-' . $month . '-' . $day;
		$start_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['start_date_label'] = $start_date;
		$data['start_date_label_past'] = $start_date_past;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
		$data['end_date_label'] = $end_date;
		$data['end_date_label_past'] = $end_date_past;
		$data['year'] = $year;

		$date_now = strtotime($start_date);
		$date2 = strtotime($end_date);

		if ($date_now > $date2) {
			list($day, $month, $year) = explode('-', $data['start_date']);
			$end_date = $year . '-' . $month . '-' . $day;
			$end_date_past = ($year - 1) . '-' . $month . '-' . $day;
			$data['end_date_label'] = $end_date;
			$data['year'] = $year;
		}

		// Region mapping: name => [STD_REGION_IDs]
		$regionMap = [
			['name' => 'GRAND TOTAL', 'ids' => [], 'color' => '#1a329a', 'titleColor' => '#0e1f6b'],
			['name' => 'ASEAN', 'ids' => [13], 'color' => '#ebabc0', 'titleColor' => '#c44d75'],
			['name' => 'NORTH-EAST ASIA', 'ids' => [15, 38], 'color' => '#f9c9b2', 'titleColor' => '#d47830'],
			['name' => 'SOUTH ASIA', 'ids' => [23, 39], 'color' => '#b5a000', 'titleColor' => '#b5a000'],
			['name' => 'EUROPE', 'ids' => [2, 44, 36, 37], 'color' => '#c6a7cb', 'titleColor' => '#7b4a85'],
			['name' => 'THE AMERICAS', 'ids' => [7, 45], 'color' => '#64b5da', 'titleColor' => '#1a6e99'],
			['name' => 'MIDDLE EAST', 'ids' => [20, 47], 'color' => '#9bc1a7', 'titleColor' => '#3d7a52'],
			['name' => 'OCEANIA', 'ids' => [5, 46], 'color' => '#b2dfe8', 'titleColor' => '#2a8a9e'],
			['name' => 'AFRICA', 'ids' => [6, 40], 'color' => '#b6c8c7', 'titleColor' => '#4a7170'],
		];

		// Region sum data
		$data['SumRegionMonthData'] = $Model->getSumRegionMonth($start_date, $end_date);
		$data['SumRegionMonthData_past'] = $Model->getSumRegionMonth($start_date_past, $end_date_past);

		// Collect all region IDs for INBOUND total
		$allRegionIds = [];
		foreach ($regionMap as $r) {
			if (!empty($r['ids'])) {
				$allRegionIds = array_merge($allRegionIds, $r['ids']);
			}
		}
		$allRegionIds = array_unique($allRegionIds);

		// Chart data for each region
		$regionCharts = [];
		foreach ($regionMap as $idx => $region) {
			if (empty($region['ids'])) {
				// INBOUND = all regions combined
				$regionCharts[$idx] = $Model->getSumChartRegion($end_date, $allRegionIds);
				$regionMap[$idx]['sumMonth'] = array_sum($data['SumRegionMonthData']);
				$regionMap[$idx]['sumMonth_past'] = array_sum($data['SumRegionMonthData_past']);
			} else {
				$regionCharts[$idx] = $Model->getSumChartRegion($end_date, $region['ids']);
				$sum = 0;
				$sum_past = 0;
				foreach ($region['ids'] as $rid) {
					$sum += @$data['SumRegionMonthData'][$rid];
					$sum_past += @$data['SumRegionMonthData_past'][$rid];
				}
				$regionMap[$idx]['sumMonth'] = $sum;
				$regionMap[$idx]['sumMonth_past'] = $sum_past;
			}
		}

		$data['regionMap'] = $regionMap;
		$data['regionCharts'] = $regionCharts;

		return view('Modules\Main\Views\region', $data);
	}

	function realtime()
	{
		$data = array();
		$data['session'] = session();
		$ses_data = ['report_type' => 'realtime'];
		$data['session']->set($ses_data);
		$data['Mydate'] = $this->Mydate;

		// ============================================================
		// ข้อมูลจริงรายเดือน (ก.พ. 2568 - มี.ค. 2569) จากแหล่งข้อมูลภายใน
		// ============================================================
		// ลำดับ: ก.พ.68, มี.ค.68, เม.ย.68, พ.ค.68, มิ.ย.68, ก.ค.68, ส.ค.68, ก.ย.68, ต.ค.68, พ.ย.68, ธ.ค.68, ม.ค.69, ก.พ.69, มี.ค.69
		$realOcc     = [77.62, 74.99, 74.69, 68.30, 66.09, 68.16, 68.69, 66.73, 70.94, 72.78, 78.09, 77.52, 77.24, null];
		$realOil95   = [36.12, 36.50, 37.20, 36.95, 36.40, 36.75, 37.10, 36.80, 36.50, 36.20, 35.90, 35.75, 36.10, 36.65];
		$realCpi     = [100.74, 100.64, 100.58, 100.18, 100.50, 100.51, 100.39, 100.46, 100.41, 100.25, 100.33, 100.03, 99.91, 99.67];
		$realTravel  = [24253241, 22975884, 22521810, 24912474, 23485511, 22363928, 21544757, 22372298, 21590792, 23172963, 23079730, 26491703, 23230424, 23230424];
		$realSent    = [60.86, 59.86, 60.37, 61.42, 58.72, 56.33, 59.69, 60.54, 63.42, 62.38, 64.41, 24.41, 24.03, 59.15];
		$realTourist = [25633814, 26527872, 26604374, 27066883, 25319078, 25802437, 24434297, 24795743, 25884768, 25118127, 26682688, 29713504, 27447304, 2715473];
		$realMonthLabels = ['ก.พ.68','มี.ค.68','เม.ย.68','พ.ค.68','มิ.ย.68','ก.ค.68','ส.ค.68','ก.ย.68','ต.ค.68','พ.ย.68','ธ.ค.68','ม.ค.69','ก.พ.69','มี.ค.69'];

		// ใช้ 14 เดือนทั้งหมดสำหรับ chart
		$data['months'] = $realMonthLabels;
		$data['occ_monthly']       = $realOcc;
		$data['cpi_monthly']       = $realCpi;
		$data['sentiment_monthly'] = $realSent;
		$data['oil_monthly']       = $realOil95;
		$data['travel_monthly']    = array_map(function($v) { return round($v / 1000000, 2); }, $realTravel);
		$data['tourist_monthly']   = array_map(function($v) { return round($v / 1000000, 2); }, $realTourist);

		// Metric Card 1: นักท่องเที่ยว จากข้อมูลจริง (เดือนล่าสุดที่มีข้อมูล)
		$latestTouristReal = $realTourist[12]; // ก.พ. 69 = 27,447,304
		$prevTouristReal   = $realTourist[11]; // ม.ค. 69 = 29,713,504
		$tourist_current = $latestTouristReal;
		$tourist_change = $prevTouristReal > 0 ? round(($latestTouristReal - $prevTouristReal) / $prevTouristReal * 100, 1) : 0;
		// YoY: ก.พ.69 vs ก.พ.68 (index 0)
		$tourist_yoy = $realTourist[0]; // ก.พ.68 = 25,633,814
		$data['tourist_yoy_change'] = $tourist_yoy > 0 ? round(($latestTouristReal - $tourist_yoy) / $tourist_yoy * 100, 1) : 0;

		$data['tourist_current'] = $tourist_current;
		$data['tourist_change'] = $tourist_change;
		$data['data_date'] = 'ก.พ. 2569';

		// ค่าล่าสุดสำหรับ Factor Cards
		$latestOccReal = 77.24;       // ก.พ. 69
		$latestCpiReal = 99.67;       // มี.ค. 69
		$latestTravelReal = 23230424; // มี.ค. 69
		$latestSentReal = 59.15;      // มี.ค. 69
		$latestTouristVal = $latestTouristReal; // ก.พ. 69

		$data['factors'] = [
			['name' => 'จำนวนการเดินทาง', 'value' => number_format($latestTravelReal), 'unit' => 'คน', 'r' => 0.91, 'change' => 0, 'bar_percent' => min(100, round($latestTravelReal / 30000000 * 100)), 'color' => '#2ecc71', 'source' => 'data', 'source_name' => 'ข้อมูลภายใน (มี.ค. 69)'],
			['name' => 'ราคาน้ำมัน 95', 'value' => 36.65, 'unit' => 'บาท/ลิตร', 'r' => -0.67, 'change' => 0, 'bar_percent' => min(100, round(36.65 / 55 * 100)), 'color' => '#e74c3c', 'source' => 'data', 'source_name' => 'ข้อมูลภายใน (มี.ค. 69)'],
			['name' => 'Sentiment', 'value' => $latestSentReal, 'unit' => 'คะแนน', 'r' => 0.78, 'change' => 0, 'bar_percent' => min(100, round($latestSentReal)), 'color' => '#f39c12', 'source' => 'data', 'source_name' => 'ข้อมูลภายใน (มี.ค. 69)'],
			['name' => 'อัตราเข้าพัก', 'value' => $latestOccReal, 'unit' => '%', 'r' => 0.83, 'change' => 0, 'bar_percent' => min(100, round($latestOccReal)), 'color' => '#3498db', 'source' => 'data', 'source_name' => 'ข้อมูลภายใน (ก.พ. 69)'],
			['name' => 'CPI Index', 'value' => $latestCpiReal, 'unit' => '', 'r' => -0.44, 'change' => 0, 'bar_percent' => min(100, round(($latestCpiReal - 90) / 15 * 100)), 'color' => '#9b59b6', 'source' => 'data', 'source_name' => 'ข้อมูลภายใน (มี.ค. 69)']
		];

		// Metric Cards ที่ยังเป็น mock
		$data['tourist_forecast'] = 3540000;
		$data['forecast_confidence'] = 78;
		$data['health_index'] = 80;
		$data['health_level'] = 'ดี';

		// Charts: ราคาน้ำมัน vs อัตราเข้าพัก (14 เดือน)
		$data['scatter_oil'] = $realOil95;
		$data['scatter_occ'] = $realOcc;
		$data['scatter_labels'] = $realMonthLabels;

		// แหล่งข้อมูลที่ใช้งานจริงใน Dashboard
		$data['data_sources'] = [
			['name' => 'นักท่องเที่ยว', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'อัตราเข้าพัก', 'detail' => '(ก.พ. 68 - ก.พ. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'ราคาน้ำมัน 95', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'CPI ดัชนีราคาผู้บริโภค', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'จำนวนการเดินทาง', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'Sentiment', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
		];

		// ============================================================
		// คำนวณ Pearson Correlation (r) จากข้อมูลจริง
		// ============================================================
		// ใช้เฉพาะเดือนที่มีข้อมูลครบทุกตัว (ตัด null ออก)
		$pairData = [];
		for ($i = 0; $i < count($realOcc); $i++) {
			if ($realOcc[$i] !== null && $realOil95[$i] !== null && $realCpi[$i] !== null
				&& $realTravel[$i] !== null && $realSent[$i] !== null) {
				$pairData[] = [
					'occ' => $realOcc[$i],
					'oil' => $realOil95[$i],
					'cpi' => $realCpi[$i],
					'travel' => $realTravel[$i] / 1000000, // แปลงเป็นล้านคน
					'sent' => $realSent[$i],
				];
			}
		}

		// ============================================================
		// คำนวณ Pearson Correlation (r) จากข้อมูลจริง 12 เดือน
		// ============================================================

		// Pearson r function
		$pearsonR = function($x, $y) {
			$px = []; $py = [];
			$n = min(count($x), count($y));
			for ($i = 0; $i < $n; $i++) {
				if ($x[$i] !== null && $y[$i] !== null) {
					$px[] = $x[$i];
					$py[] = $y[$i];
				}
			}
			$n = count($px);
			if ($n < 3) return 0;
			$mx = array_sum($px) / $n;
			$my = array_sum($py) / $n;
			$sxy = 0; $sx2 = 0; $sy2 = 0;
			for ($i = 0; $i < $n; $i++) {
				$dx = $px[$i] - $mx;
				$dy = $py[$i] - $my;
				$sxy += $dx * $dy;
				$sx2 += $dx * $dx;
				$sy2 += $dy * $dy;
			}
			$denom = sqrt($sx2 * $sy2);
			return $denom == 0 ? 0 : round($sxy / $denom, 4);
		};

		// เตรียม array 13 เดือน (ก.พ.68 - ก.พ.69) สำหรับคำนวณ r
		// ตัด มี.ค.69 ออก เพราะนักท่องเที่ยว 2.7M = ข้อมูลไม่ครบเดือน
		$chartTourist = array_map(function($v) { return $v / 1000000; }, array_slice($realTourist, 0, 13));
		$chartTravel  = array_map(function($v) { return $v / 1000000; }, array_slice($realTravel, 0, 13));
		$chartOil     = array_slice($realOil95, 0, 13);
		$chartSent    = array_slice($realSent, 0, 13);
		$chartOcc     = array_slice($realOcc, 0, 13);
		$chartCpi     = array_slice($realCpi, 0, 13);

		// คำนวณ r ทุกปัจจัย vs นักท่องเที่ยว (ข้อมูลจริง 13 เดือน)
		$rTravel = $pearsonR($chartTravel, $chartTourist);
		$rOcc    = $pearsonR($chartOcc, $chartTourist);
		$rOil    = $pearsonR($chartOil, $chartTourist);
		$rCpi    = $pearsonR($chartCpi, $chartTourist);
		$rSent   = $pearsonR($chartSent, $chartTourist);

		// อัปเดตค่า r ใน Factor Cards
		$data['factors'][0]['r'] = $rTravel;  // จำนวนการเดินทาง
		$data['factors'][1]['r'] = $rOil;     // ราคาน้ำมัน
		$data['factors'][2]['r'] = $rSent;    // Sentiment
		$data['factors'][3]['r'] = $rOcc;     // อัตราเข้าพัก
		$data['factors'][4]['r'] = $rCpi;     // CPI

		// Correlation Bar Chart (ทุกปัจจัย vs นักท่องเที่ยว เรียงจากมากไปน้อย)
		$corrAll = [
			['name' => 'การเดินทาง', 'r' => $rTravel],
			['name' => 'อัตราเข้าพัก', 'r' => $rOcc],
			['name' => 'Sentiment', 'r' => $rSent],
			['name' => 'ราคาน้ำมัน', 'r' => $rOil],
			['name' => 'CPI', 'r' => $rCpi],
		];
		usort($corrAll, function($a, $b) { return $b['r'] <=> $a['r']; });
		$data['correlations'] = $corrAll;

		// Correlation Matrix (6×6) — นักท่องเที่ยว + 5 ปัจจัย
		$allSeries = [
			$chartTourist,
			$chartTravel,
			$chartOil,
			$chartSent,
			$chartOcc,
			$chartCpi,
		];
		$matrixSize = count($allSeries);
		$corrMatrix = [];
		for ($i = 0; $i < $matrixSize; $i++) {
			$row = [];
			for ($j = 0; $j < $matrixSize; $j++) {
				if ($i === $j) {
					$row[] = 1.0;
				} else {
					$row[] = $pearsonR($allSeries[$i], $allSeries[$j]);
				}
			}
			$corrMatrix[] = $row;
		}
		$data['corr_matrix'] = $corrMatrix;
		$data['corr_labels'] = ['นักท่องเที่ยว', 'การเดินทาง', 'ราคาน้ำมัน', 'Sentiment', 'อัตราเข้าพัก', 'CPI'];

		return view('Modules\Main\Views\realtime', $data);
	}

	function realtime_inter()
	{
		$data = array();
		$Model = new Main_model();
		$data['session'] = session();
		$ses_data = ['report_type' => 'realtime_inter'];
		$data['session']->set($ses_data);
		$data['Mydate'] = $this->Mydate;

		// ============================================================
		// ข้อมูลจาก DB: International Tourist Arrivals
		// ============================================================
		$currentYear = date('Y');       // CE year (2026)
		$prevYear = $currentYear - 1;   // 2025
		$currentYearThai = $currentYear + 543; // 2569
		$prevYearThai = $prevYear + 543;       // 2568

		// ดึงวันที่ล่าสุดจาก DB (try-catch กรณี DB เชื่อมไม่ได้)
		$maxDate = null;
		$monthly2569 = [];
		$monthly2568 = [];
		$partialMonthTotal = 0;
		$hasPartialMonth = false;
		$maxDay = 25;
		$maxMonth = 3;

		$chartMonthly2569 = [];
		$chartMonthly2568 = [];

		try {
			$maxDate = $Model->getMaxDate();
			if ($maxDate) {
				$maxDateParts = explode('-', $maxDate);
				$maxDay = (int)$maxDateParts[2];
				$maxMonth = (int)$maxDateParts[1];

				// 1) ดึงจาก CAL_MONTHLY_RAW_REPORT (ข้อมูลหลัก)
				$monthly2569 = $Model->getSumMonthly($currentYear);
				$monthly2568 = $Model->getSumMonthly($prevYear);

				// 2) ดึงจาก REPORT_CAL_DAILY group by month (เสริมเดือนที่ขาด)
				$chartYearData = $Model->getSumChartYear($currentYear);
				$dailyCur = isset($chartYearData['current']) ? $chartYearData['current'] : [];
				$dailyPast = isset($chartYearData['past']) ? $chartYearData['past'] : [];

				// รวมข้อมูล: monthly เป็นหลัก, daily เสริมเดือนที่ขาด
				$chartMonthly2569 = $monthly2569;
				$chartMonthly2568 = $monthly2568;
				foreach ($dailyCur as $dm => $dv) {
					if (!isset($chartMonthly2569[$dm])) $chartMonthly2569[$dm] = $dv;
				}
				foreach ($dailyPast as $dm => $dv) {
					if (!isset($chartMonthly2568[$dm])) $chartMonthly2568[$dm] = $dv;
				}

				// 3) เดือนปัจจุบัน: ดึงข้อมูลถึงวันล่าสุดที่มีข้อมูล ($maxDate)
				$currentM = $maxMonth;
				$currentDay = $maxDay;
				$mPad = str_pad($currentM, 2, '0', STR_PAD_LEFT);
				$dayPad = str_pad($currentDay, 2, '0', STR_PAD_LEFT);

				// ปีปัจจุบัน (2569): ดึงถึง maxDate (วันล่าสุดที่มีข้อมูล)
				$mStart = $currentYear . '-' . $mPad . '-01';
				$mEnd = $maxDate;
				$currentMonthSum = (float)$Model->getSumMonth($mStart, $mEnd);
				if ($currentMonthSum > 0) $chartMonthly2569[$currentM] = $currentMonthSum;

				// ปีก่อน (2568) สำหรับ Chart: ใช้ข้อมูลเต็มเดือน (ไม่ override $chartMonthly2568)
				// ถ้ายังไม่มีเดือนปัจจุบัน ดึงเต็มเดือนมาเสริม
				if (!isset($chartMonthly2568[$currentM])) {
					$lastDay = date('t', mktime(0, 0, 0, $currentM, 1, $prevYear));
					$mStartPastFull = $prevYear . '-' . $mPad . '-01';
					$mEndPastFull = $prevYear . '-' . $mPad . '-' . $lastDay;
					$pastMonthSumFull = (float)$Model->getSumMonth($mStartPastFull, $mEndPastFull);
					if ($pastMonthSumFull > 0) $chartMonthly2568[$currentM] = $pastMonthSumFull;
				}

				// ปีก่อน (2568) สำหรับ YTD: ตัดถึงวันที่เดียวกับ maxDate (เช่น 1-2 เม.ย.)
				$mStartPast = $prevYear . '-' . $mPad . '-01';
				$mEndPast = $prevYear . '-' . $mPad . '-' . $dayPad;
				$ytdPastMonthSum = (float)$Model->getSumMonth($mStartPast, $mEndPast);

				// สร้าง ytdMonthly2568 แยกสำหรับ YTD (copy จาก chart แล้ว override เดือนปัจจุบัน)
				$ytdMonthly2568 = $chartMonthly2568;
				if ($ytdPastMonthSum > 0) {
					$ytdMonthly2568[$currentM] = $ytdPastMonthSum;
				} else {
					unset($ytdMonthly2568[$currentM]);
				}
			}
		} catch (\Exception $e) {
			// DB connection failed
		}

		// สร้าง array ข้อมูลรายเดือน
		$data['month_labels'] = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
		$data['month_labels_th'] = $this->month_th_short;

		$dbHasData = !empty($chartMonthly2569) || !empty($chartMonthly2568);

		$arrivals2568 = [];
		$arrivals2569Actual = [];
		$latestMonthWithData = 0;
		for ($m = 1; $m <= 12; $m++) {
			$arrivals2568[] = isset($chartMonthly2568[$m]) ? round($chartMonthly2568[$m] / 1000000, 2) : null;
			$arrivals2569Actual[] = isset($chartMonthly2569[$m]) ? round($chartMonthly2569[$m] / 1000000, 2) : null;
			if (isset($chartMonthly2569[$m])) $latestMonthWithData = $m;
		}
		$data['data_period'] = $latestMonthWithData > 0
			? 'ม.ค. - ' . $this->month_th_short[$latestMonthWithData] . ' ' . $currentYearThai
			: '-';
		$data['arrivals_2568'] = $arrivals2568;
		$data['arrivals_2569_actual'] = $arrivals2569Actual;

		// Forecast (hardcoded)
		$forecast = array_fill(0, 12, null);
		$forecastValues = [3 => 3.15, 4 => 2.95, 5 => 2.50, 6 => 2.35, 7 => 2.55, 8 => 2.48, 9 => 2.30, 10 => 2.65, 11 => 2.85, 12 => 3.20];
		foreach ($forecastValues as $fm => $fv) {
			// แสดง forecast เฉพาะเดือนที่ไม่มี actual
			if ($arrivals2569Actual[$fm - 1] === null) {
				$forecast[$fm - 1] = $fv;
			}
		}
		$data['arrivals_2569_forecast'] = $forecast;

		// YTD summary — ช่วง ม.ค. ถึงเดือนปัจจุบัน (เช่น ม.ค.-เม.ย. ถ้าวันนี้คือ เม.ย.)
		// ใช้ ytdMonthly2568 (ตัดวันที่เดือนปัจจุบัน) ไม่ใช่ chartMonthly2568 (เต็มเดือน)
		$ytdSource = $dbHasData ? $chartMonthly2569 : $monthly2569;
		$ytdSourcePast = $dbHasData ? (isset($ytdMonthly2568) ? $ytdMonthly2568 : $chartMonthly2568) : $monthly2568;
		$ytdTotal = 0;
		$ytdTotalPast = 0;
		$ytdMonths = [];
		for ($m = 1; $m <= $maxMonth; $m++) {
			$val = isset($ytdSource[$m]) ? $ytdSource[$m] : 0;
			$prevVal = isset($ytdSourcePast[$m]) ? $ytdSourcePast[$m] : 0;
			$ytdTotal += $val;
			$ytdTotalPast += $prevVal;
			if ($val <= 0 && $prevVal <= 0) continue;
			$yoy = $prevVal > 0 ? round(($val - $prevVal) / $prevVal * 100, 1) : 0;
			// เดือนปัจจุบันที่ยังไม่ครบ ให้แสดงช่วงวันที่ เช่น "เม.ย.(1-3)"
			$monthLabel = $this->month_th_short[$m];
			if ($m == $maxMonth && $maxDay < 28) {
				$monthLabel .= '(1-' . $maxDay . ')';
			}
			$ytdMonths[] = [
				'month' => $monthLabel,
				'actual' => round($val / 1000000, 2),
				'actual_past' => round($prevVal / 1000000, 2),
				'yoy' => $yoy,
			];
		}
		$ytdYoy = $ytdTotalPast > 0 ? round(($ytdTotal - $ytdTotalPast) / $ytdTotalPast * 100, 1) : 0;
		$data['ytd_total'] = round($ytdTotal / 1000000, 2);
		$data['ytd_total_past'] = round($ytdTotalPast / 1000000, 2);
		$data['ytd_yoy'] = $ytdYoy;
		$data['ytd_months'] = $ytdMonths;
		$data['ytd_period'] = $this->month_th_short[1] . ' - ' . $maxDay . ' ' . $this->month_th_short[$maxMonth];
		$data['current_year_thai'] = $currentYearThai;
		$data['prev_year_thai'] = $prevYearThai;

		// Top Markets — ดึงจาก REPORT_CAL_DAILY (1 ม.ค. ถึงวันนี้ = ช่วงเดียวกับ YTD)
		$topMarkets = [];
		if ($dbHasData) {
			try {
				$endDateStr = $maxDate ?: date('Y-m-d');
				$startCur = $currentYear . '-01-01';
				$endCur = $endDateStr;
				$startPast = $prevYear . '-01-01';
				$endPast = $prevYear . '-' . $mPad . '-' . $dayPad; // ช่วงเดียวกับปีปัจจุบัน

				// getSumNatMonth: REPORT_CAL_DAILY พร้อมชื่อประเทศ เรียง DESC
				$countriesCur = $Model->getSumNatMonth($startCur, $endCur);
				// getSumCountryMonth: REPORT_CAL_DAILY ปีก่อนช่วงเดียวกัน
				$countriesPastRaw = $Model->getSumCountryMonth($startPast, $endPast);

				$count = 0;
				foreach ($countriesCur as $c) {
					if ($count >= 10) break;
					$curNum = (int)$c['NUM'];
					$pastNum = isset($countriesPastRaw[$c['COUNTRY_ID']]) ? (int)$countriesPastRaw[$c['COUNTRY_ID']] : 0;
					$change = $pastNum > 0 ? round(($curNum - $pastNum) / $pastNum * 100, 1) : 0;
					$topMarkets[] = [
						'name' => $c['COUNTRY_NAME_EN'],
						'change' => $change,
						'current' => $curNum,
						'past' => $pastNum,
					];
					$count++;
				}
			} catch (\Exception $e) {}
		}
		$data['top_markets'] = $topMarkets;

		// ============================================================
		// Event & External metrics (hardcoded — ไม่มีในฐานข้อมูล)
		// ============================================================
		// ============================================================
		// Flight Dashboard (hardcoded — ไม่มีในฐานข้อมูล)
		// ============================================================
		$data['flight_period'] = '11-31 มี.ค. 2026';
		$data['flight_airports'] = '4 สนามบิน';
		$data['flight_days'] = 21;

		$data['flight_total'] = 8679;
		$data['flight_operated'] = 7175;
		$data['flight_cancelled'] = 1359;
		$data['flight_cancel_pct'] = 15.7;
		$data['flight_operated_pct'] = 82.7;
		$data['flight_avg_cancel_day'] = 64.7;

		$data['airport_cancels'] = [
			['code' => 'BKK', 'name' => 'Suvarnabhumi', 'cancelled' => 483, 'total' => 3502, 'pct' => 13.8, 'color' => '#2563eb'],
			['code' => 'HKT', 'name' => 'Phuket', 'cancelled' => 509, 'total' => 2293, 'pct' => 22.2, 'color' => '#dc2626', 'note' => 'สูงสุด'],
			['code' => 'DMK', 'name' => 'Don Mueang', 'cancelled' => 269, 'total' => 2228, 'pct' => 12.1, 'color' => '#f59e0b'],
			['code' => 'CNX', 'name' => 'Chiang Mai', 'cancelled' => 98, 'total' => 656, 'pct' => 14.9, 'color' => '#059669'],
		];

		// ยกเลิกรายวัน แยกสนามบิน (11-31 มี.ค.)
		$data['daily_cancel_labels'] = [];
		for ($d = 11; $d <= 31; $d++) {
			$data['daily_cancel_labels'][] = $d . ' มี.ค.';
		}
		$data['daily_cancel_bkk'] = [32,30,28,25,22,22,23,22,20,21,22,20,22,20,18,20,20,18,8,6,5];
		$data['daily_cancel_hkt'] = [28,25,22,18,20,22,25,24,22,25,28,26,24,25,22,24,25,22,6,5,4];
		$data['daily_cancel_dmk'] = [15,12,10,12,14,12,13,14,12,14,15,14,13,12,10,12,13,12,5,4,3];
		$data['daily_cancel_cnx'] = [6,5,4,5,5,4,5,5,4,5,5,5,4,5,4,4,5,4,2,2,2];

		// % ยกเลิกสูงสุด รายสายการบิน
		$data['airline_cancels'] = [
			['name' => 'Qatar Airways', 'pct' => 93.60, 'color' => '#dc2626'],
			['name' => 'Air Arabia', 'pct' => 77.20, 'color' => '#dc2626'],
			['name' => 'Etihad Airways', 'pct' => 59.40, 'color' => '#f59e0b'],
			['name' => 'Spring Airlines', 'pct' => 44.10, 'color' => '#f59e0b'],
			['name' => 'China Eastern', 'pct' => 23.00, 'color' => '#2563eb'],
			['name' => 'Thai AirAsia', 'pct' => 14.90, 'color' => '#2563eb'],
			['name' => 'Myanmar Airways Intl', 'pct' => 14.30, 'color' => '#2563eb'],
			['name' => 'IndiGo', 'pct' => 12.20, 'color' => '#2563eb'],
			['name' => 'China Southern', 'pct' => 12.10, 'color' => '#2563eb'],
			['name' => 'Thai Lion Air', 'pct' => 7.30, 'color' => '#2563eb'],
		];

		// เส้นทางที่ยกเลิกมากที่สุด
		$data['route_cancels'] = [
			['route' => 'Doha → HKT', 'count' => 70],
			['route' => 'Sharjah → HKT', 'count' => 60],
			['route' => 'Abu Dhabi → HKT', 'count' => 51],
			['route' => 'Doha → BKK', 'count' => 42],
			['route' => 'Shanghai → HKT', 'count' => 37],
			['route' => 'Nanjing → HKT', 'count' => 36],
			['route' => 'Shanghai → CNX', 'count' => 33],
			['route' => 'Hong Kong → BKK', 'count' => 29],
			['route' => 'Kuwait → BKK', 'count' => 29],
			['route' => 'Guangzhou → BKK', 'count' => 28],
		];

		// TOP %Change Regions — ดึงจาก REPORT_CAL_DAILY (1 ม.ค. ถึงวันนี้ = ช่วงเดียวกับ YTD)
		$regionChanges = [];
		$curDay = $maxDay;
		$curMonthNum = $maxMonth;
		if ($dbHasData) {
			try {
				$endDateStr = $maxDate ?: date('Y-m-d');
				$startCur = $currentYear . '-01-01';
				$endCur = $endDateStr;
				$startPast = $prevYear . '-01-01';
				$endPast = $prevYear . '-' . $mPad . '-' . $dayPad;

				// getSumRegionMonth: REPORT_CAL_DAILY group by STD_REGION_ID
				$regCurrent = $Model->getSumRegionMonth($startCur, $endCur);
				$regPast = $Model->getSumRegionMonth($startPast, $endPast);

				$regionMap = [
					'ASEAN' => [13],
					'NORTH-EAST ASIA' => [15],
					'SOUTH ASIA' => [23, 39],
					'EUROPE' => [2, 44, 36, 37],
					'THE AMERICAS' => [7, 45],
					'OCEANIA' => [5, 46],
					'MIDDLE EAST' => [20, 47],
				];

				$grandCurrent = 0;
				$grandPast = 0;
				$regionRows = [];

				foreach ($regionMap as $name => $ids) {
					$cur = 0; $prev = 0;
					foreach ($ids as $rid) {
						$cur += isset($regCurrent[$rid]) ? (float)$regCurrent[$rid] : 0;
						$prev += isset($regPast[$rid]) ? (float)$regPast[$rid] : 0;
					}
					$grandCurrent += $cur;
					$grandPast += $prev;
					$diff = $prev > 0 ? round(($cur - $prev) / $prev * 100, 2) : 0;
					$regionRows[] = ['region' => $name, 'prev' => (int)$prev, 'current' => (int)$cur, 'diff' => $diff, 'is_total' => false];
				}

				usort($regionRows, function($a, $b) { return $a['diff'] <=> $b['diff']; });

				$grandDiff = $grandPast > 0 ? round(($grandCurrent - $grandPast) / $grandPast * 100, 2) : 0;
				array_unshift($regionRows, ['region' => 'GRAND TOTAL', 'prev' => (int)$grandPast, 'current' => (int)$grandCurrent, 'diff' => $grandDiff, 'is_total' => true]);

				if ($grandCurrent > 0 || $grandPast > 0) {
					$regionChanges = $regionRows;
					$monthNames = ['','JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
					$data['region_period'] = '1 JAN - ' . $curDay . ' ' . $monthNames[$curMonthNum];
				}
			} catch (\Exception $e) {}
		}

		// Fallback
		if (empty($regionChanges)) {
			$regionChanges = [
				['region' => 'GRAND TOTAL', 'prev' => 9549004, 'current' => 9316909, 'diff' => -2.43, 'is_total' => true],
				['region' => 'MIDDLE EAST', 'prev' => 119857, 'current' => 86521, 'diff' => -27.81, 'is_total' => false],
				['region' => 'ASEAN', 'prev' => 2491871, 'current' => 2031118, 'diff' => -18.49, 'is_total' => false],
				['region' => 'OCEANIA', 'prev' => 222393, 'current' => 217200, 'diff' => -2.34, 'is_total' => false],
				['region' => 'THE AMERICAS', 'prev' => 484270, 'current' => 485051, 'diff' => 0.16, 'is_total' => false],
				['region' => 'NORTH-EAST ASIA', 'prev' => 2620487, 'current' => 2675973, 'diff' => 2.12, 'is_total' => false],
				['region' => 'EUROPE', 'prev' => 2936277, 'current' => 3050711, 'diff' => 3.90, 'is_total' => false],
				['region' => 'SOUTH ASIA', 'prev' => 637113, 'current' => 733984, 'diff' => 15.20, 'is_total' => false],
			];
			$data['region_period'] = 'JAN-MAR';
		}
		$data['region_changes'] = $regionChanges;

		$data['event_name'] = 'US-Iran Conflict';
		$data['event_date'] = '28 ก.พ. 2569';
		$data['event_desc'] = '28 ก.พ. 2569: เส้นทางบิน Middle East Hub ถูกปิด/ยอดความถี่, ราคาน้ำมันพุ่ง +17%, Forward Booking ตลาดตะวันออกกลาง-แอฟริกา-ลาตินอเมริกาลด 23-38%, ความเสี่ยงสูงต่อ Q2/Q3 2569.';

		$data['seat_capacity_change'] = -9.2;
		$data['seat_capacity_desc'] = 'W5 (22-28 มี.ค.) vs W1 Baseline (22-28 ก.พ.)';
		$data['seat_capacity_detail'] = '1,000,890 vs 1,102,863 ที่นั่ง/สัปดาห์ · OAG';

		$data['fbi_change'] = -19.6;
		$data['fbi_desc'] = 'FBI W8 (12-18 เม.ย.) vs W1 Baseline (22-28 ก.พ.)';
		$data['fbi_detail'] = 'FBI W8=80.4 vs W1=100 · ForwardKeys';

		$data['sentiment_neg'] = 55.4;
		$data['sentiment_detail'] = '23,332 neg จาก 42,103 keyphrases · Meltwater';
		$data['sentiment_breakdown'] = 'Pos 2.5% · Neu 42.1% · Total Mentions 9,341';

		return view('Modules\Main\Views\realtime_inter', $data);
	}

	function realtime2()
	{
		$data = array();
		$data['session'] = session();
		$ses_data = ['report_type' => 'realtime2'];
		$data['session']->set($ses_data);
		$data['Mydate'] = $this->Mydate;

		// ============================================================
		// ข้อมูลจริงรายเดือน (ก.พ. 2568 - มี.ค. 2569) — ของเดิม
		// ============================================================
		$realOcc     = [77.62, 74.99, 74.69, 68.30, 66.09, 68.16, 68.69, 66.73, 70.94, 72.78, 78.09, 77.52, 77.24, null];
		$realOil95   = [36.12, 36.50, 37.20, 36.95, 36.40, 36.75, 37.10, 36.80, 36.50, 36.20, 35.90, 35.75, 36.10, 36.65];
		$realCpi     = [100.74, 100.64, 100.58, 100.18, 100.50, 100.51, 100.39, 100.46, 100.41, 100.25, 100.33, 100.03, 99.91, 99.67];
		$realTravel  = [24253241, 22975884, 22521810, 24912474, 23485511, 22363928, 21544757, 22372298, 21590792, 23172963, 23079730, 26491703, 23230424, 23230424];
		$realSent    = [60.86, 59.86, 60.37, 61.42, 58.72, 56.33, 59.69, 60.54, 63.42, 62.38, 64.41, 24.41, 24.03, 59.15];
		$realTourist = [25633814, 26527872, 26604374, 27066883, 25319078, 25802437, 24434297, 24795743, 25884768, 25118127, 26682688, 29713504, 27447304, 2715473];
		$realMonthLabels = ['ก.พ.68','มี.ค.68','เม.ย.68','พ.ค.68','มิ.ย.68','ก.ค.68','ส.ค.68','ก.ย.68','ต.ค.68','พ.ย.68','ธ.ค.68','ม.ค.69','ก.พ.69','มี.ค.69'];

		$data['months'] = $realMonthLabels;
		$data['occ_monthly']       = $realOcc;
		$data['cpi_monthly']       = $realCpi;
		$data['sentiment_monthly'] = $realSent;
		$data['oil_monthly']       = $realOil95;
		$data['travel_monthly']    = array_map(function($v) { return round($v / 1000000, 2); }, $realTravel);
		$data['tourist_monthly']   = array_map(function($v) { return round($v / 1000000, 2); }, $realTourist);

		$latestTouristReal = $realTourist[12];
		$prevTouristReal   = $realTourist[11];
		$tourist_current = $latestTouristReal;
		$tourist_change = $prevTouristReal > 0 ? round(($latestTouristReal - $prevTouristReal) / $prevTouristReal * 100, 1) : 0;
		$tourist_yoy = $realTourist[0];
		$data['tourist_yoy_change'] = $tourist_yoy > 0 ? round(($latestTouristReal - $tourist_yoy) / $tourist_yoy * 100, 1) : 0;
		$data['tourist_current'] = $tourist_current;
		$data['tourist_change'] = $tourist_change;
		$data['data_date'] = 'ก.พ. 2569';

		$latestOccReal = 77.24;
		$latestCpiReal = 99.67;
		$latestTravelReal = 23230424;
		$latestSentReal = 59.15;

		$data['factors'] = [
			['name' => 'จำนวนการเดินทาง', 'value' => number_format($latestTravelReal), 'unit' => 'คน', 'r' => 0.91, 'change' => 0, 'bar_percent' => min(100, round($latestTravelReal / 30000000 * 100)), 'color' => '#2ecc71', 'source' => 'data', 'source_name' => 'ข้อมูลภายใน (มี.ค. 69)'],
			['name' => 'ราคาน้ำมัน 95', 'value' => 36.65, 'unit' => 'บาท/ลิตร', 'r' => -0.67, 'change' => 0, 'bar_percent' => min(100, round(36.65 / 55 * 100)), 'color' => '#e74c3c', 'source' => 'data', 'source_name' => 'ข้อมูลภายใน (มี.ค. 69)'],
			['name' => 'Sentiment', 'value' => $latestSentReal, 'unit' => 'คะแนน', 'r' => 0.78, 'change' => 0, 'bar_percent' => min(100, round($latestSentReal)), 'color' => '#f39c12', 'source' => 'data', 'source_name' => 'ข้อมูลภายใน (มี.ค. 69)'],
			['name' => 'อัตราเข้าพัก', 'value' => $latestOccReal, 'unit' => '%', 'r' => 0.83, 'change' => 0, 'bar_percent' => min(100, round($latestOccReal)), 'color' => '#3498db', 'source' => 'data', 'source_name' => 'ข้อมูลภายใน (ก.พ. 69)'],
			['name' => 'CPI Index', 'value' => $latestCpiReal, 'unit' => '', 'r' => -0.44, 'change' => 0, 'bar_percent' => min(100, round(($latestCpiReal - 90) / 15 * 100)), 'color' => '#9b59b6', 'source' => 'data', 'source_name' => 'ข้อมูลภายใน (มี.ค. 69)']
		];

		$data['tourist_forecast'] = 3540000;
		$data['forecast_confidence'] = 78;
		$data['health_index'] = 80;
		$data['health_level'] = 'ดี';

		$data['scatter_oil'] = $realOil95;
		$data['scatter_occ'] = $realOcc;
		$data['scatter_labels'] = $realMonthLabels;

		$data['data_sources'] = [
			['name' => 'นักท่องเที่ยว', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'อัตราเข้าพัก', 'detail' => '(ก.พ. 68 - ก.พ. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'ราคาน้ำมัน 95', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'CPI ดัชนีราคาผู้บริโภค', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'จำนวนการเดินทาง', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'Sentiment', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'ข้อมูลภายใน (รายเดือน)', 'type' => 'data', 'api_url' => ''],
			['name' => 'CCI ดัชนีความเชื่อมั่นผู้บริโภค', 'detail' => '(ก.พ. 68 - ก.พ. 69)', 'source' => 'สนค. กระทรวงพาณิชย์', 'type' => 'data', 'api_url' => 'https://index.tpso.go.th/consumerconfidence/overall-consumer'],
			['name' => 'Google Trends', 'detail' => '(ก.พ. 68 - มี.ค. 69)', 'source' => 'Google Trends · 5 keywords ท่องเที่ยว', 'type' => 'data', 'api_url' => 'https://trends.google.com'],
			['name' => 'Social Listening รายภาค', 'detail' => '(ธ.ค. 2568)', 'source' => 'Social Listening 5 ภาค', 'type' => 'data', 'api_url' => ''],
		];

		// Pearson r function
		$pearsonR = function($x, $y) {
			$px = []; $py = [];
			$n = min(count($x), count($y));
			for ($i = 0; $i < $n; $i++) {
				if ($x[$i] !== null && $y[$i] !== null) {
					$px[] = $x[$i];
					$py[] = $y[$i];
				}
			}
			$n = count($px);
			if ($n < 3) return 0;
			$mx = array_sum($px) / $n;
			$my = array_sum($py) / $n;
			$sxy = 0; $sx2 = 0; $sy2 = 0;
			for ($i = 0; $i < $n; $i++) {
				$dx = $px[$i] - $mx;
				$dy = $py[$i] - $my;
				$sxy += $dx * $dy;
				$sx2 += $dx * $dx;
				$sy2 += $dy * $dy;
			}
			$denom = sqrt($sx2 * $sy2);
			return $denom == 0 ? 0 : round($sxy / $denom, 4);
		};

		$chartTourist = array_map(function($v) { return $v / 1000000; }, array_slice($realTourist, 0, 13));
		$chartTravel  = array_map(function($v) { return $v / 1000000; }, array_slice($realTravel, 0, 13));
		$chartOil     = array_slice($realOil95, 0, 13);
		$chartSent    = array_slice($realSent, 0, 13);
		$chartOcc     = array_slice($realOcc, 0, 13);
		$chartCpi     = array_slice($realCpi, 0, 13);

		$rTravel = $pearsonR($chartTravel, $chartTourist);
		$rOcc    = $pearsonR($chartOcc, $chartTourist);
		$rOil    = $pearsonR($chartOil, $chartTourist);
		$rCpi    = $pearsonR($chartCpi, $chartTourist);
		$rSent   = $pearsonR($chartSent, $chartTourist);

		// ============================================================
		// [NEW] ข้อมูลจาก Excel "Data Dashboard ตลาดในประเทศ"
		//   1. CCI (Consumer Confidence Index)        · สนค.
		//   2. Google Trends (Tourism keywords)        · Google
		//   3. Social Listening รายภาค (5 ภาค)         · ภายใน
		// ============================================================

		// --- CCI: ดัชนีความเชื่อมั่นผู้บริโภค (ก.พ. 68 - มี.ค. 69) match 14 เดือน ---
		$cci_overall = [52.0,50.8,48.8,48.9,46.7,48.4,47.9,49.4,50.9,51.8,51.8, 52.6,53.0, null];
		$cci_current = [43.9,43.2,40.5,40.1,37.8,39.7,39.2,39.6,40.9,42.6,43.2, 43.9,43.3, null];
		$cci_future  = [57.4,55.9,54.4,54.8,52.6,54.2,53.7,56.0,57.6,58.0,57.6, 58.4,59.4, null];
		$data['cci_overall'] = $cci_overall;
		$data['cci_current'] = $cci_current;
		$data['cci_future']  = $cci_future;
		$data['cci_latest']  = 53.0;
		$data['cci_latest_current'] = 43.3;
		$data['cci_latest_future']  = 59.4;
		$data['cci_latest_month']   = 'ก.พ. 2569';
		$data['cci_prev']           = 52.6;
		$data['cci_delta']          = round(53.0 - 52.6, 2);

		// --- GT Keyword Dataset (5 keywords × 12 เดือน × 5 ปี) สำหรับ Radar filter ---
		// fields per month: [ที่เที่ยว, ที่พัก, คาเฟ่, ตั๋วราคาถูก, ที่พักราคาถูก]
		$data['gt_radar_dataset'] = [
			2565 => [ // ค.ศ. 2022
				1=>[34.6,47.0,41.6,1.0,2.0],   2=>[31.5,44.25,39.0,1.0,2.0],
				3=>[33.75,56.5,38.25,1.0,2.5], 4=>[54.5,82.0,56.0,1.25,4.75],
				5=>[39.0,57.2,46.8,1.4,2.8],   6=>[33.0,49.0,41.0,2.0,2.5],
				7=>[42.0,56.6,48.4,1.8,2.4],   8=>[33.5,46.5,42.5,1.0,2.0],
				9=>[31.25,45.0,37.75,1.5,2.0], 10=>[45.4,64.6,46.4,2.0,3.2],
				11=>[40.75,61.75,40.5,2.0,3.0],12=>[53.25,62.75,49.75,1.75,3.25],
			],
			2566 => [ // ค.ศ. 2023
				1=>[54.6,66.0,58.8,2.0,3.4],   2=>[46.5,62.25,52.75,2.0,3.75],
				3=>[54.25,81.5,58.25,2.75,4.5],4=>[65.4,89.0,69.8,2.6,5.8],
				5=>[42.0,59.0,52.75,2.0,3.5],  6=>[45.25,57.75,58.25,2.0,3.0],
				7=>[54.0,66.8,66.0,2.0,3.6],   8=>[42.0,53.0,57.75,2.0,3.0],
				9=>[38.5,52.25,49.25,2.0,3.0], 10=>[50.0,70.0,60.4,2.4,4.0],
				11=>[44.25,67.0,49.0,2.0,3.0], 12=>[60.4,70.4,67.8,2.0,3.6],
			],
			2567 => [ // ค.ศ. 2024
				1=>[39.5,55.5,45.25,1.75,3.0], 2=>[41.5,58.5,51.75,1.5,3.0],
				3=>[40.0,62.8,49.8,2.0,3.0],   4=>[48.0,71.5,63.5,1.25,3.25],
				5=>[33.75,54.25,48.5,1.0,2.25],6=>[32.6,49.4,49.0,1.0,2.0],
				7=>[37.5,55.75,56.0,1.0,2.0],  8=>[33.0,48.0,53.25,1.25,2.0],
				9=>[27.4,45.0,46.0,1.0,1.8],   10=>[40.5,63.0,54.5,1.5,2.5],
				11=>[37.0,59.0,45.5,1.5,2.5],  12=>[46.4,63.2,62.8,1.4,2.6],
			],
			2568 => [ // ค.ศ. 2025
				1=>[29.5,45.0,42.0,1.25,2.0],  2=>[26.0,44.75,43.5,1.0,2.0],
				3=>[27.0,48.0,43.2,1.4,2.0],   4=>[38.5,56.0,56.0,1.0,2.25],
				5=>[26.25,44.0,44.75,1.0,2.0], 6=>[25.6,40.6,42.4,1.0,1.8],
				7=>[29.5,49.0,50.25,1.0,2.0],  8=>[26.2,46.4,46.8,1.0,2.0],
				9=>[24.5,45.25,40.0,1.25,2.0], 10=>[34.75,63.5,49.25,1.75,2.75],
				11=>[30.4,63.4,43.0,1.6,2.6],  12=>[40.75,61.0,60.0,1.25,2.5],
			],
			2569 => [ // ค.ศ. 2026 (มีแค่ ม.ค.-มี.ค.)
				1=>[26.75,48.5,41.0,1.75,2.0], 2=>[23.5,44.0,38.5,1.5,2.0],
				3=>[24.5,45.5,38.5,1.5,2.0],
			],
		];
		$data['gt_kw_keys'] = ['ที่เที่ยว','ที่พัก','คาเฟ่','ตั๋วราคาถูก','ที่พักราคาถูก'];
		// dropdown options: list ของเดือนที่มีข้อมูลในแต่ละปี (เรียงใหม่สุด → เก่าสุด)
		$gt_options = [];
		$thai_short_full = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
		foreach ([2569, 2568, 2567, 2566] as $yr) {
			if (!isset($data['gt_radar_dataset'][$yr])) continue;
			$months = array_keys($data['gt_radar_dataset'][$yr]);
			rsort($months);
			foreach ($months as $mo) {
				$gt_options[] = [
					'key'   => $yr . '-' . $mo,
					'label' => $thai_short_full[$mo] . ' ' . $yr,
				];
			}
		}
		$data['gt_radar_options'] = $gt_options;
		$data['gt_radar_default'] = '2569-3'; // มี.ค. 2569 = latest available

		// --- Google Trends: คำค้นท่องเที่ยว เฉลี่ย 5 keywords (ก.พ.68-มี.ค.69) ---
		$gt_avg    = [23.45,24.32,30.75,23.60,22.28,26.35,24.48,22.60,30.40,28.20,33.10, 24.00,21.90,22.40];
		$gt_travel = [26.0, 27.0, 38.5, 26.25,25.6, 29.5, 26.2, 24.5, 34.75,30.4, 40.75, 26.75,23.5, 24.5];
		$gt_stay   = [44.75,48.0, 56.0, 44.0, 40.6, 49.0, 46.4, 45.25,63.5, 63.4, 61.0,  48.5, 44.0, 45.5];
		$gt_cafe   = [43.5, 43.2, 56.0, 44.75,42.4, 50.25,46.8, 40.0, 49.25,43.0, 60.0,  41.0, 38.5, 38.5];
		$data['gt_avg']    = $gt_avg;
		$data['gt_travel'] = $gt_travel;
		$data['gt_stay']   = $gt_stay;
		$data['gt_cafe']   = $gt_cafe;
		$data['gt_latest'] = 22.40;
		$data['gt_latest_month'] = 'มี.ค. 2569';
		$data['gt_prev']   = 21.90;
		$data['gt_delta']  = round(22.40 - 21.90, 2);

		// คำนวณ Pearson r ของ CCI/GT vs จำนวนนักท่องเที่ยว (13 เดือน ก.พ.68-ก.พ.69)
		$chartCci = array_slice($cci_overall, 0, 13);
		$chartGt  = array_slice($gt_avg, 0, 13);
		$rCci     = $pearsonR($chartCci, $chartTourist);
		$rGt      = $pearsonR($chartGt, $chartTourist);

		// --- Leading Indicators Score ---
		$norm_cci = max(0, min(100, ($data['cci_latest'] - 30) / (70 - 30) * 100));
		$norm_gt  = max(0, min(100, ($data['gt_latest']  - 15) / (40 - 15) * 100));
		$norm_or  = max(0, min(100, ($latestOccReal     - 55) / (85 - 55) * 100));
		$leading_score = round($norm_cci * 0.4 + $norm_gt * 0.3 + $norm_or * 0.3, 1);
		$data['leading_score']    = $leading_score;
		$data['leading_norm_cci'] = round($norm_cci, 1);
		$data['leading_norm_gt']  = round($norm_gt, 1);
		$data['leading_norm_or']  = round($norm_or, 1);

		if ($leading_score >= 60) {
			$data['leading_signal']      = 'positive';
			$data['leading_signal_text'] = 'สัญญาณบวก';
			$data['leading_signal_desc'] = 'ปัจจัยภายในประเทศสนับสนุนการท่องเที่ยว — ความเชื่อมั่นสูง ดีมานด์ที่พักแข็งแกร่ง ค้นหาท่องเที่ยวเพิ่ม';
		} elseif ($leading_score >= 40) {
			$data['leading_signal']      = 'neutral';
			$data['leading_signal_text'] = 'สัญญาณกลาง';
			$data['leading_signal_desc'] = 'ปัจจัยผสม — เฝ้าระวัง CCI/GT/OR เดือนต่อไปเพื่อยืนยันทิศทาง';
		} else {
			$data['leading_signal']      = 'negative';
			$data['leading_signal_text'] = 'สัญญาณลบ';
			$data['leading_signal_desc'] = 'ปัจจัยภายในอ่อนแอ — เสี่ยงต่อการชะลอของการท่องเที่ยวในประเทศ';
		}

		$data['cci_corr'] = $rCci;
		$data['gt_corr']  = $rGt;
		$data['or_corr']  = $rOcc;
		$data['li_month_labels'] = $realMonthLabels;

		// --- Regional Sentiment Map (ธ.ค. 2568) ---
		$data['regional_sentiment_period'] = 'ธ.ค. 2568';
		$data['regional_sentiment'] = [
			[
				'region'     => 'ภาคเหนือ',
				'mentions'   => 10916273,
				'engagements'=> 147417607,
				'pos_pct'    => 94.02,
				'neg_pct'    => 5.98,
				'pos_theme'  => 'Phayao Countdown · เชียงใหม่ฤดูหนาว · ดอยอินทนนท์ · เหมยขาบ',
				'neg_theme'  => 'มาเฟียประตูท่าแพ · อุบัติเหตุรถเช่า · พลัดตกลานหินแตก',
				'color'      => '#059669',
			],
			[
				'region'     => 'ภาคตะวันออกเฉียงเหนือ',
				'mentions'   => 5885293,
				'engagements'=> 81458277,
				'pos_pct'    => 98.02,
				'neg_pct'    => 1.98,
				'pos_theme'  => 'Buriram Countdown · Korat · NakhonPhanom Winter Fest · Sky Walk เขาใหญ่',
				'neg_theme'  => 'เหตุปะทะชายแดน ไทย-กัมพูชา ทำ นทท. หวั่นความปลอดภัย บุรีรัมย์',
				'color'      => '#10b981',
			],
			[
				'region'     => 'ภาคกลางรวมกรุงเทพฯ',
				'mentions'   => 8762400,
				'engagements'=> 107986873,
				'pos_pct'    => 91.23,
				'neg_pct'    => 8.77,
				'pos_theme'  => 'ICONSIAM · centralwOrld Countdown · Siam Paragon · สกายวอล์คสุพรรณบุรี',
				'neg_theme'  => 'Skyflyers เอเชียทีคเสียงดังรบกวน · หัวรถจักรชนโบกี้ กาญจนบุรี',
				'color'      => '#f59e0b',
			],
			[
				'region'     => 'ภาคตะวันออก',
				'mentions'   => 7778397,
				'engagements'=> 54305390,
				'pos_pct'    => 87.80,
				'neg_pct'    => 12.20,
				'pos_theme'  => 'Pattaya Countdown · The Sealebration of Light · สวนสัตว์เขาเขียว',
				'neg_theme'  => 'พฤติกรรมไม่เหมาะสมชาวรัสเซีย · สาวสองรุม นทท.อินเดีย · ลวนลามทุ่นลอย',
				'color'      => '#ef4444',
			],
			[
				'region'     => 'ภาคใต้',
				'mentions'   => 6621995,
				'engagements'=> 49497444,
				'pos_pct'    => 85.88,
				'neg_pct'    => 14.12,
				'pos_theme'  => 'Hatyai/Songkhla/Satun Countdown · เขื่อนรัชชประภา · Patong Fest',
				'neg_theme'  => 'รถตู้ป้ายเหลืองสนามบินภูเก็ต · ฟื้นฟูหาดใหญ่ล่าช้า · เฝ้าระวังน้ำท่วม',
				'color'      => '#dc2626',
			],
		];
		$data['regional_sentiment_total'] = [
			'mentions'    => 51604676,
			'engagements' => 458685227,
			'pos_pct'     => 94.68,
			'neg_pct'     => 5.32,
		];
		// Sentiment trend (14 เดือน · ทั้งประเทศ พ.ย.67-ธ.ค.68)
		$data['rs_trend_labels'] = ['พ.ย.67','ธ.ค.67','ม.ค.68','ก.พ.68','มี.ค.68','เม.ย.68','พ.ค.68','มิ.ย.68','ก.ค.68','ส.ค.68','ก.ย.68','ต.ค.68','พ.ย.68','ธ.ค.68'];
		$data['rs_trend_mentions'] = [78203259,92973952,73281691,58654051,49465472,85796568,34879171,27377454,36483176,22836955,24879258,29371987,34795732,51604676];
		$data['rs_trend_pos']      = [96.53,94.06,92.11,92.27,90.12,89.40,95.65,91.85,82.39,92.24,93.79,94.54,92.82,94.68];
		$data['rs_trend_neg']      = [3.47,5.94,7.89,7.73,9.88,10.60,4.35,8.15,17.61,7.76,6.21,5.46,7.18,5.32];

		// อัปเดตค่า r ใน Factor Cards
		$data['factors'][0]['r'] = $rTravel;
		$data['factors'][1]['r'] = $rOil;
		$data['factors'][2]['r'] = $rSent;
		$data['factors'][3]['r'] = $rOcc;
		$data['factors'][4]['r'] = $rCpi;

		// Correlation Bar Chart — เพิ่ม CCI + GT (เรียงด้วย abs r)
		$corrAll = [
			['name' => 'การเดินทาง',  'r' => $rTravel],
			['name' => 'อัตราเข้าพัก', 'r' => $rOcc],
			['name' => 'CCI',         'r' => $rCci],
			['name' => 'Google Trends','r' => $rGt],
			['name' => 'Sentiment',   'r' => $rSent],
			['name' => 'ราคาน้ำมัน',  'r' => $rOil],
			['name' => 'CPI',         'r' => $rCpi],
		];
		usort($corrAll, function($a, $b) { return abs($b['r']) <=> abs($a['r']); });
		$data['correlations'] = $corrAll;

		// Correlation Matrix (8×8) — นักท่องเที่ยว + 7 ปัจจัย
		$allSeries = [
			$chartTourist, $chartTravel, $chartOil, $chartSent, $chartOcc, $chartCpi, $chartCci, $chartGt,
		];
		$matrixSize = count($allSeries);
		$corrMatrix = [];
		for ($i = 0; $i < $matrixSize; $i++) {
			$row = [];
			for ($j = 0; $j < $matrixSize; $j++) {
				$row[] = $i === $j ? 1.0 : $pearsonR($allSeries[$i], $allSeries[$j]);
			}
			$corrMatrix[] = $row;
		}
		$data['corr_matrix'] = $corrMatrix;
		$data['corr_labels'] = ['นักท่องเที่ยว', 'การเดินทาง', 'ราคาน้ำมัน', 'Sentiment', 'อัตราเข้าพัก', 'CPI', 'CCI', 'Google Trends'];

		// ============================================================
		// [NEW-A] Provincial Performance — Top 10 จังหวัด (2568P)
		// ============================================================
		// fields: name, tier, region, visitors_2568, visitors_2567, yoy, or_avg
		$data['top_provinces'] = [
			['name' => 'กรุงเทพมหานคร',    'tier' => '22 เมืองหลัก', 'region' => 'กลาง',     'visitors' => 32024065, 'visitors_prev' => 31709748, 'yoy' => 0.99,  'or' => 76.47],
			['name' => 'ชลบุรี',            'tier' => '22 เมืองหลัก', 'region' => 'ตะวันออก', 'visitors' => 17258825, 'visitors_prev' => 16208402, 'yoy' => 6.48,  'or' => 80.66],
			['name' => 'กาญจนบุรี',         'tier' => '22 เมืองหลัก', 'region' => 'ตะวันตก',  'visitors' => 14742115, 'visitors_prev' => 14587708, 'yoy' => 1.06,  'or' => 68.81],
			['name' => 'ประจวบคีรีขันธ์',   'tier' => '22 เมืองหลัก', 'region' => 'ตะวันตก',  'visitors' => 10712737, 'visitors_prev' => 10556810, 'yoy' => 1.48,  'or' => 72.27],
			['name' => 'เพชรบุรี',          'tier' => '22 เมืองหลัก', 'region' => 'ตะวันตก',  'visitors' => 10543949, 'visitors_prev' => 10412850, 'yoy' => 1.26,  'or' => 69.19],
			['name' => 'นครราชสีมา',        'tier' => '22 เมืองหลัก', 'region' => 'อีสานใต้', 'visitors' => 9211199,  'visitors_prev' => 8644710,  'yoy' => 6.55,  'or' => 76.31],
			['name' => 'พระนครศรีอยุธยา',   'tier' => '22 เมืองหลัก', 'region' => 'กลาง',     'visitors' => 9006927,  'visitors_prev' => 9344166,  'yoy' => -3.61, 'or' => 59.34],
			['name' => 'เชียงใหม่',         'tier' => '22 เมืองหลัก', 'region' => 'เหนือ',    'visitors' => 8571537,  'visitors_prev' => 7928565,  'yoy' => 8.11,  'or' => 76.74],
			['name' => 'ฉะเชิงเทรา',        'tier' => '22 เมืองหลัก', 'region' => 'ตะวันออก', 'visitors' => 6463376,  'visitors_prev' => 6130981,  'yoy' => 5.42,  'or' => 46.48],
			['name' => 'สุพรรณบุรี',        'tier' => '55 เมืองรอง',  'region' => 'กลาง',     'visitors' => 5902058,  'visitors_prev' => 5684491,  'yoy' => 3.83,  'or' => 60.14],
		];
		$data['top_provinces_period'] = '2568P (12 เดือน) · YoY vs 2567';

		// ============================================================
		// [NEW-B] 6 Region Master Table (2568P) — รวมทุก indicator
		// ============================================================
		// CCI ก.พ. 2569 รายภาค: กทม.+ปริมณฑล=57.2, กลาง=50.9, อีสาน=54.3, ใต้=51.5, เหนือ=52.1
		// ภาคตะวันตก/ตะวันออก ไม่มีใน CCI breakdown → ใช้ ภาคกลาง (50.9) เป็น proxy
		// Sentiment ธ.ค. 2568 รายภาค (จาก data_Social)
		// ภาคตะวันตก ไม่มีใน Social → ใช้ "ภาคกลางรวม กทม." (91.23%) เป็น proxy
		$data['region_master'] = [
			[
				'name' => 'ภาคตะวันตก',
				'visitors' => 50181031, 'visitors_prev' => 49640172, 'yoy' => 1.09,
				'or' => 68.40,
				'cci' => 50.9,    'cci_note' => 'ใช้ค่า "ภาคกลาง" เป็น proxy',
				'pos_pct' => 91.23, 'mentions' => null, 'sentiment_note' => 'ใช้ค่า "ภาคกลางรวม กทม." เป็น proxy',
				'color' => '#0891b2',
			],
			[
				'name' => 'ภาคตะวันออกเฉียงเหนือ',
				'visitors' => 47675969, 'visitors_prev' => 45562680, 'yoy' => 4.64,
				'or' => 66.45,
				'cci' => 54.3, 'cci_note' => '',
				'pos_pct' => 98.02, 'mentions' => 5885293, 'sentiment_note' => '',
				'color' => '#10b981',
			],
			[
				'name' => 'ภาคตะวันออก',
				'visitors' => 43883932, 'visitors_prev' => 41934170, 'yoy' => 4.65,
				'or' => 72.68,
				'cci' => 50.9, 'cci_note' => 'ใช้ค่า "ภาคกลาง" เป็น proxy',
				'pos_pct' => 87.80, 'mentions' => 7778397, 'sentiment_note' => '',
				'color' => '#ef4444',
			],
			[
				'name' => 'ภาคเหนือ',
				'visitors' => 38277925, 'visitors_prev' => 36194148, 'yoy' => 5.76,
				'or' => 66.02,
				'cci' => 52.1, 'cci_note' => '',
				'pos_pct' => 94.02, 'mentions' => 10916273, 'sentiment_note' => '',
				'color' => '#059669',
			],
			[
				'name' => 'ภาคกลาง',
				'visitors' => 35862941, 'visitors_prev' => 34926502, 'yoy' => 2.68,
				'or' => 57.63,
				'cci' => 50.9, 'cci_note' => '',
				'pos_pct' => 91.23, 'mentions' => 8762400, 'sentiment_note' => 'รวม กทม.',
				'color' => '#f59e0b',
			],
			[
				'name' => 'ภาคใต้',
				'visitors' => 30859228, 'visitors_prev' => 30409650, 'yoy' => 1.48,
				'or' => 74.07,
				'cci' => 51.5, 'cci_note' => '',
				'pos_pct' => 85.88, 'mentions' => 6621995, 'sentiment_note' => '',
				'color' => '#dc2626',
			],
		];
		$data['region_master_period'] = '2568P · CCI ก.พ.69 · Sentiment ธ.ค.68';

		// ============================================================
		// [NEW-C] Long-term Recovery Trend 2562-2568P (7 ปี)
		// ============================================================
		$data['lt_years']        = ['2562','2563','2564','2565','2566','2567','2568P'];
		$data['lt_total']        = [229748960, 124789607, 75640669, 204865613, 252075778, 270377850, 278765091];
		$data['lt_main_cities']  = [144868415, 76444861,  47816678, 127486684, 153054308, 162279588, 166963169];
		$data['lt_minor_cities'] = [84880545,  48344746,  27823991, 77378929,  99021470,  108098262, 111801922];

		// คำนวณ YoY % ของ ทั้งประเทศ
		$lt_yoy = [null];
		for ($i = 1; $i < count($data['lt_total']); $i++) {
			$prev = $data['lt_total'][$i-1];
			$lt_yoy[] = $prev > 0 ? round(($data['lt_total'][$i] - $prev) / $prev * 100, 2) : null;
		}
		$data['lt_yoy'] = $lt_yoy;

		// COVID dip annotations
		$data['lt_milestones'] = [
			['year_idx' => 1, 'label' => 'COVID Wave 1', 'note' => '-45.7% YoY'],
			['year_idx' => 2, 'label' => 'Peak COVID',    'note' => '-39.4% YoY · ต่ำสุด'],
			['year_idx' => 3, 'label' => 'Reopening',     'note' => '+170.8% YoY · ฟื้นตัว'],
			['year_idx' => 6, 'label' => 'Pre-COVID +21%','note' => 'ทะลุระดับก่อนโควิด'],
		];

		// Forecast 2569 — Linear regression (last 4 ปี post-COVID)
		$post_covid = array_slice($data['lt_total'], 3); // 2565-2568
		$n = count($post_covid);
		$x_vals = range(0, $n-1);
		$mean_x = array_sum($x_vals) / $n;
		$mean_y = array_sum($post_covid) / $n;
		$num = 0; $den = 0;
		for ($i = 0; $i < $n; $i++) {
			$num += ($x_vals[$i] - $mean_x) * ($post_covid[$i] - $mean_y);
			$den += pow($x_vals[$i] - $mean_x, 2);
		}
		$slope = $den != 0 ? $num / $den : 0;
		$intercept = $mean_y - $slope * $mean_x;
		$forecast_2569 = $intercept + $slope * $n; // ปีถัดไป
		$data['lt_forecast_2569'] = round($forecast_2569);
		$data['lt_forecast_yoy'] = round(($forecast_2569 - end($data['lt_total'])) / end($data['lt_total']) * 100, 2);

		// ============================================================
		// [NEW-D] Tier Battle — 22 เมืองหลัก vs 55 เมืองรอง รายเดือน 2568P
		// ============================================================
		$data['tier_months']        = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
		$data['tier_main_monthly']  = [14110349,13383574,13335570,14589462,13832061,13172645,12991736,13832883,13315823,14226087,14095949,16077030];
		$data['tier_minor_monthly'] = [10142892,9592310, 9186240, 10323012,9653450, 9191283, 8553021, 8539415, 8274969, 8946876, 8983781, 10414673];

		// คำนวณ ratio (% หลัก) รายเดือน
		$tier_ratio = [];
		for ($i = 0; $i < 12; $i++) {
			$total = $data['tier_main_monthly'][$i] + $data['tier_minor_monthly'][$i];
			$tier_ratio[] = $total > 0 ? round($data['tier_main_monthly'][$i] / $total * 100, 1) : 0;
		}
		$data['tier_ratio'] = $tier_ratio;

		// สรุป YoY ของแต่ละ tier
		$tier_main_2568_total  = array_sum($data['tier_main_monthly']);
		$tier_minor_2568_total = array_sum($data['tier_minor_monthly']);
		// อ้างอิง 2567 จาก data section C
		$tier_main_2567_total  = 162279588;
		$tier_minor_2567_total = 108098262;
		$data['tier_main_yoy']  = round(($tier_main_2568_total - $tier_main_2567_total) / $tier_main_2567_total * 100, 2);
		$data['tier_minor_yoy'] = round(($tier_minor_2568_total - $tier_minor_2567_total) / $tier_minor_2567_total * 100, 2);
		$data['tier_main_total']  = $tier_main_2568_total;
		$data['tier_minor_total'] = $tier_minor_2568_total;
		$data['tier_main_share']  = round($tier_main_2568_total / ($tier_main_2568_total + $tier_minor_2568_total) * 100, 1);
		$data['tier_minor_share'] = round($tier_minor_2568_total / ($tier_main_2568_total + $tier_minor_2568_total) * 100, 1);

		// ============================================================
		// [NEW-E] GT Keywords Radar — 5 keywords (มี.ค. 69 vs ปีก่อน)
		// ============================================================
		// ข้อมูลล่าสุด มี.ค. 69 จาก Excel
		$data['gt_kw_labels']    = ['ที่เที่ยว','ที่พัก','คาเฟ่','ตั๋วราคาถูก','ที่พักราคาถูก'];
		$data['gt_kw_current']   = [24.5, 45.5, 38.5, 1.5, 2.0];   // มี.ค. 2569
		$data['gt_kw_prev_yr']   = [27.0, 48.0, 43.2, 2.0, 3.0];   // มี.ค. 2568 (ปีก่อน)
		$data['gt_kw_2yrs_ago']  = [40.0, 62.8, 49.8, 2.0, 3.0];   // มี.ค. 2567 (2 ปีก่อน)

		// คำนวณ %change YoY ราย keyword
		$gt_kw_yoy = [];
		foreach ($data['gt_kw_current'] as $i => $cur) {
			$prev = $data['gt_kw_prev_yr'][$i];
			$gt_kw_yoy[] = $prev > 0 ? round(($cur - $prev) / $prev * 100, 1) : 0;
		}
		$data['gt_kw_yoy'] = $gt_kw_yoy;
		$data['gt_kw_period'] = 'มี.ค. 2569 vs มี.ค. 2568 (YoY)';

		// Insight: leisure vs price-sensitive
		$leisure_avg = ($data['gt_kw_current'][0] + $data['gt_kw_current'][1] + $data['gt_kw_current'][2]) / 3;
		$price_avg   = ($data['gt_kw_current'][3] + $data['gt_kw_current'][4]) / 2;
		$data['gt_leisure_avg'] = round($leisure_avg, 2);
		$data['gt_price_avg']   = round($price_avg, 2);

		// ============================================================
		// [NEW-F] CCI Regional — 5 ภาค (ม.ค. vs ก.พ. 69)
		// ============================================================
		$data['cci_regions'] = [
			['region' => 'กทม.และปริมณฑล', 'jan' => 58.3, 'feb' => 57.2, 'color' => '#0891b2'],
			['region' => 'ภาคกลาง',         'jan' => 50.9, 'feb' => 50.9, 'color' => '#f59e0b'],
			['region' => 'ภาคอีสาน',        'jan' => 53.5, 'feb' => 54.3, 'color' => '#10b981'],
			['region' => 'ภาคใต้',          'jan' => 50.8, 'feb' => 51.5, 'color' => '#dc2626'],
			['region' => 'ภาคเหนือ',        'jan' => 52.4, 'feb' => 52.1, 'color' => '#059669'],
		];
		// คำนวณ delta (ก.พ. - ม.ค.)
		foreach ($data['cci_regions'] as $i => $r) {
			$data['cci_regions'][$i]['delta'] = round($r['feb'] - $r['jan'], 2);
		}
		$data['cci_regions_period'] = 'ม.ค. → ก.พ. 2569';

		// CCI ระดับชาติ (รวม)
		$data['cci_national_jan'] = 52.6;
		$data['cci_national_feb'] = 53.0;
		$data['cci_national_delta'] = round(53.0 - 52.6, 2);

		// ============================================================
		// [NEW-G/H/J/K] Activity Data จาก TAT.ACTIVITY (Oracle)
		// ============================================================
		$ActModel = new Activity_model();
		$ce_year = (int)date('Y'); // 2026

		// G — Summary + by Province + by Region (เพื่อ join กับ table ที่มีอยู่)
		$act_summary  = $ActModel->getActivitySummary($ce_year);
		$act_by_prov  = $ActModel->getActivityByProvince($ce_year);
		$act_by_reg   = $ActModel->getActivityByRegion($ce_year);

		$data['act_summary']     = $act_summary;
		$data['act_by_province'] = $act_by_prov;
		$data['act_by_region']   = $act_by_reg;

		// J — Type Mix
		$act_by_type = $ActModel->getActivityByType($ce_year);
		// top 10 + รวม "อื่นๆ"
		if (count($act_by_type) > 10) {
			$top10 = array_slice($act_by_type, 0, 10);
			$rest  = array_slice($act_by_type, 10);
			$rest_sum = array_sum(array_column($rest, 'count'));
			if ($rest_sum > 0) {
				$top10[] = ['name' => 'อื่นๆ', 'count' => $rest_sum];
			}
			$act_by_type = $top10;
		}
		$data['act_by_type'] = $act_by_type;
		$data['act_type_total'] = array_sum(array_column($act_by_type, 'count'));

		// H — by Month (12 เดือน — ปีปัจจุบัน + ปีก่อน)
		$act_by_month_cur  = $ActModel->getActivityByMonth($ce_year);
		$act_by_month_prev = $ActModel->getActivityByMonth($ce_year - 1);
		$data['act_by_month_cur']   = array_values($act_by_month_cur);
		$data['act_by_month_prev']  = array_values($act_by_month_prev);
		$data['act_year_thai']      = $ce_year + 543;
		$data['act_year_thai_prev'] = ($ce_year - 1) + 543;

		// K — Upcoming + Active Now
		$data['act_upcoming']   = $ActModel->getUpcomingActivity(8);
		$data['act_active_now'] = $ActModel->getActiveNow(5);

		// G/L — เพิ่ม events ใน Region Master (cross-indicator)
		foreach ($data['region_master'] as $i => $rm) {
			$active_events = 0;
			foreach ($act_by_reg as $rname => $cnt) {
				if ($rname === $rm['name']) {
					$active_events = $cnt;
					break;
				}
			}
			$data['region_master'][$i]['events']         = $active_events;
			$data['region_master'][$i]['events_per_mil'] = $rm['visitors'] > 0
				? round($active_events / ($rm['visitors'] / 1000000), 2) : 0;
		}

		// G — เพิ่ม events ใน Top 10 จังหวัด
		foreach ($data['top_provinces'] as $i => $p) {
			$evt = isset($act_by_prov[$p['name']]) ? $act_by_prov[$p['name']] : 0;
			$data['top_provinces'][$i]['events'] = $evt;
		}

		// คำนวณ Pearson r: events vs visitors (Top 10 จว.)
		$evtArr = array_column($data['top_provinces'], 'events');
		$visArr = array_column($data['top_provinces'], 'visitors');
		if (count($evtArr) >= 3 && array_sum($evtArr) > 0) {
			$data['act_corr_visitors'] = $pearsonR($evtArr, $visArr);
		} else {
			$data['act_corr_visitors'] = 0;
		}

		// ============================================================
		// [NEW-M] Activity Impact Analysis (Events vs Visitors รายเดือน 2568)
		// ============================================================
		// ดึง events ปี 2568 (CE 2025) เพื่อจับคู่กับ visitors monthly 2568P
		$act_by_month_2568 = $ActModel->getActivityByMonth(2025);
		$act_2568_arr = array_values($act_by_month_2568);
		$data['mim_events_2568'] = $act_2568_arr;

		// visitors รายเดือน 2568P = main + minor (หน่วย ล้านคน)
		$visitors_2568_monthly = [];
		$visitors_2568_raw = [];
		for ($i = 0; $i < 12; $i++) {
			$total = $data['tier_main_monthly'][$i] + $data['tier_minor_monthly'][$i];
			$visitors_2568_raw[]     = $total;
			$visitors_2568_monthly[] = round($total / 1000000, 2);
		}
		$data['mim_visitors_2568'] = $visitors_2568_monthly;
		$data['mim_months']        = $data['tier_months'];

		// 1) Pearson r: events vs visitors รายเดือน
		$mim_corr = $pearsonR($act_2568_arr, $visitors_2568_monthly);
		$data['mim_corr'] = $mim_corr;
		// แปลความ
		if (abs($mim_corr) >= 0.7)      $data['mim_corr_strength'] = 'สูง';
		elseif (abs($mim_corr) >= 0.4)  $data['mim_corr_strength'] = 'ปานกลาง';
		elseif (abs($mim_corr) >= 0.2)  $data['mim_corr_strength'] = 'ต่ำ';
		else                            $data['mim_corr_strength'] = 'ต่ำมาก';

		// 2) Linear Regression: visitors = a + b * events
		$n = 12;
		$mean_e = array_sum($act_2568_arr) / $n;
		$mean_v = array_sum($visitors_2568_raw) / $n;
		$num = 0; $den = 0;
		for ($i = 0; $i < $n; $i++) {
			$num += ($act_2568_arr[$i] - $mean_e) * ($visitors_2568_raw[$i] - $mean_v);
			$den += pow($act_2568_arr[$i] - $mean_e, 2);
		}
		$slope     = $den != 0 ? $num / $den : 0; // visitors เพิ่มต่อ 1 event (ระดับ raw)
		$intercept = $mean_v - $slope * $mean_e;
		$data['mim_slope']     = round($slope);     // visitors เพิ่ม per 1 event
		$data['mim_intercept'] = round($intercept);
		$data['mim_slope_million'] = round($slope, 0);

		// 3) Median Split: เดือนที่ events เยอะ (above median) vs น้อย (below median)
		$evt_sorted = $act_2568_arr;
		sort($evt_sorted);
		$median = ($evt_sorted[5] + $evt_sorted[6]) / 2; // median ของ 12 เดือน
		$high_visitors = []; $low_visitors = [];
		$high_months = []; $low_months = [];
		$thai_short = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
		for ($i = 0; $i < 12; $i++) {
			if ($act_2568_arr[$i] >= $median) {
				$high_visitors[] = $visitors_2568_raw[$i];
				$high_months[]   = $thai_short[$i];
			} else {
				$low_visitors[]  = $visitors_2568_raw[$i];
				$low_months[]    = $thai_short[$i];
			}
		}
		$high_avg = count($high_visitors) > 0 ? array_sum($high_visitors) / count($high_visitors) : 0;
		$low_avg  = count($low_visitors)  > 0 ? array_sum($low_visitors)  / count($low_visitors)  : 0;
		$data['mim_high_avg']    = round($high_avg / 1000000, 2);
		$data['mim_low_avg']     = round($low_avg / 1000000, 2);
		$data['mim_high_months'] = $high_months;
		$data['mim_low_months']  = $low_months;
		$data['mim_lift_pct']    = $low_avg > 0
			? round(($high_avg - $low_avg) / $low_avg * 100, 1) : 0;
		$data['mim_median']      = $median;

		// 4) Avg visitors per event (ภาพรวม 2568)
		$total_events_2568   = array_sum($act_2568_arr);
		$total_visitors_2568 = array_sum($visitors_2568_raw);
		$data['mim_total_events']   = $total_events_2568;
		$data['mim_total_visitors'] = $total_visitors_2568;
		$data['mim_visit_per_event'] = $total_events_2568 > 0
			? round($total_visitors_2568 / $total_events_2568) : 0;

		// 5) Scatter data (ทุกเดือน เป็นจุด)
		$scatter_pts = [];
		for ($i = 0; $i < 12; $i++) {
			$scatter_pts[] = [
				'x'    => $act_2568_arr[$i],
				'y'    => $visitors_2568_monthly[$i],
				'name' => $thai_short[$i],
			];
		}
		$data['mim_scatter'] = $scatter_pts;

		// ============================================================
		// [NEW-M+] Per-Province dataset สำหรับ filter ใน client
		// visitors monthly รายจังหวัด ปี 2568P (Excel — Top 10 จว.)
		// + events monthly จาก DB (รายจังหวัด)
		// ============================================================
		// Visitors monthly รายจังหวัด ปี 2568P (77 จังหวัด — เรียงตามตัวอักษรไทย)
		$province_visitors_monthly = [
			'กระบี่'             => [241881,290027,293292,202400,144523,234588,216691,220169,193473,226565,262655,224797],
			'กรุงเทพมหานคร'      => [2703279,2205898,2261223,2519116,2580102,2249047,2312585,2759280,2908570,3297953,2858749,3368263],
			'กาญจนบุรี'          => [1201273,1171096,1068805,1257348,1259783,1193124,1246111,1186277,1240763,1216868,1310413,1390254],
			'กาฬสินธุ์'          => [85332,263819,95102,430155,189423,143815,190184,185711,198093,226544,219635,286058],
			'กำแพงเพชร'          => [78768,72654,72284,69643,69840,66226,71044,69196,68370,80872,83089,98910],
			'ขอนแก่น'            => [428628,403221,411300,457055,424787,449447,395727,378838,361228,361669,339822,431650],
			'จันทบุรี'           => [297544,249914,325830,356183,383801,345943,337927,332547,314584,320530,309797,340267],
			'ฉะเชิงเทรา'         => [547350,541812,564988,585865,493386,505856,550341,523553,502858,518615,478381,650371],
			'ชลบุรี'             => [1181144,1225138,1343524,1820605,1471447,1362646,1275555,1705794,1400026,1365052,1482357,1625537],
			'ชัยนาท'             => [102121,97592,97281,117716,108269,104551,96664,99289,97221,92265,96320,107810],
			'ชัยภูมิ'            => [181288,162795,148880,158331,186754,198838,209832,166540,150845,153729,156318,189035],
			'ชุมพร'              => [163601,149746,160721,157630,152680,150264,158033,165402,148687,154852,154715,168507],
			'ตรัง'               => [142389,155336,154994,175240,165440,123964,136815,131438,116397,120681,92905,139755],
			'ตราด'               => [154324,151831,186584,207637,198138,157828,138197,115174,109262,116676,133864,138087],
			'ตาก'                => [212779,185436,176665,201256,190988,181908,166229,173469,170321,186981,188592,220996],
			'นครนายก'            => [244683,247634,240934,301816,240910,261614,280904,269189,250701,216511,232690,285583],
			'นครปฐม'             => [391022,395434,391414,400478,382198,358268,434384,427017,432389,488180,437118,467521],
			'นครพนม'             => [166667,210421,173369,193526,187299,163828,200134,180346,175734,188842,163163,187664],
			'นครราชสีมา'         => [762574,704599,764572,787024,713555,786587,725315,745041,704200,789139,812007,916586],
			'นครศรีธรรมราช'      => [433096,336747,358944,393991,324670,319958,372903,393537,425752,403764,310590,399975],
			'นครสวรรค์'          => [227829,204621,184908,242521,228623,200236,188605,189548,181870,177578,176536,223134],
			'นนทบุรี'            => [335014,337134,359316,344373,346983,325593,345601,350779,322425,292725,292554,345625],
			'นราธิวาส'           => [35185,45362,44052,47846,55963,47129,36932,44997,47707,35807,27899,37467],
			'น่าน'               => [159860,124701,112904,142732,138548,125495,85457,106405,106630,132438,148714,168667],
			'บึงกาฬ'             => [81413,69637,82863,69698,68884,91448,79724,80809,85853,75177,67002,83604],
			'บุรีรัมย์'          => [318706,308808,361075,324943,300006,308976,285921,289064,308234,316145,312743,310669],
			'ปทุมธานี'           => [263076,267874,266072,240681,248695,259217,276818,290411,265714,241650,273173,302330],
			'ประจวบคีรีขันธ์'    => [958732,880390,873211,977410,923193,846072,906759,876318,767386,819098,861584,1022584],
			'ปราจีนบุรี'         => [124821,120090,128023,116394,124333,118393,114941,120073,120751,123903,119052,148098],
			'ปัตตานี'            => [35347,36997,35212,38604,45379,39450,41478,44153,44195,41047,28622,41454],
			'พระนครศรีอยุธยา'    => [773647,754042,764460,890653,696916,723541,782079,707148,712493,702503,738580,760865],
			'พะเยา'              => [107685,102889,82743,99432,82462,80306,73679,75148,67379,94027,106264,129962],
			'พังงา'              => [165582,102751,147969,143876,131726,125172,116323,113899,148760,169484,152795,178361],
			'พัทลุง'             => [147097,142990,168450,163726,164440,157147,153231,136139,145989,140695,132570,152667],
			'พิจิตร'             => [66330,62665,58376,74961,70616,66538,71097,68286,69537,73704,70645,90923],
			'พิษณุโลก'           => [307291,265173,242163,258284,268804,267738,235115,241811,231465,273450,272536,303859],
			'ภูเก็ต'             => [328377,387422,361538,289592,286387,340263,222938,287759,274431,306679,269802,297430],
			'มหาสารคาม'          => [59040,66350,55936,77107,76192,79188,51837,50482,41998,48596,50359,59194],
			'มุกดาหาร'           => [158433,150906,142078,159103,145021,147088,135441,125121,111547,147505,154799,180337],
			'ยะลา'               => [92164,99778,95841,94044,99331,112665,89870,98072,79401,81633,68940,108143],
			'ยโสธร'              => [55916,46311,45867,58153,62372,48438,57318,53014,46392,49822,50372,56948],
			'ระนอง'              => [80140,72112,77447,88978,81556,78065,76169,80424,72219,77662,81407,86135],
			'ระยอง'              => [398063,411378,444781,491719,550318,487035,468409,451596,416063,400009,387927,487394],
			'ราชบุรี'            => [235212,244394,250432,296775,304410,292071,232722,239287,222475,227494,236479,251217],
			'ร้อยเอ็ด'           => [76691,68633,74755,84183,90035,75860,72591,82089,83623,80961,78846,90255],
			'ลพบุรี'             => [407135,413127,366930,383297,383567,387419,393113,363267,365589,360146,400554,442127],
			'ลำปาง'              => [175364,144998,115963,130273,128327,116386,115114,121303,117631,165480,191831,232537],
			'ลำพูน'              => [119143,100669,85934,110441,105459,95804,100651,108970,99741,112384,134266,150973],
			'ศรีสะเกษ'           => [93499,88243,88562,103116,102403,97726,87630,96459,86692,93353,91599,101970],
			'สกลนคร'             => [186360,165028,167888,167842,153317,147034,156411,170585,131289,156382,145869,187145],
			'สงขลา'              => [298115,329766,309739,288266,289875,287101,216385,253692,254558,283049,175069,168573],
			'สตูล'               => [140844,133230,144154,204719,207909,182275,160848,174907,155399,170417,106847,130404],
			'สมุทรปราการ'        => [319026,302801,291341,320788,298606,293532,227014,247381,230027,246615,229261,254802],
			'สมุทรสงคราม'        => [521433,495669,480027,473853,489475,446614,362795,353888,364348,393260,398276,467566],
			'สมุทรสาคร'          => [153220,148036,153388,148062,138019,141072,124527,115388,120070,117877,114578,134212],
			'สระบุรี'            => [428908,408173,389643,414253,392596,395185,396219,390022,377960,442608,485206,523168],
			'สระแก้ว'            => [126373,120705,114674,126787,125712,94773,80374,88973,86775,91608,97112,77469],
			'สิงห์บุรี'          => [72330,71046,75909,88646,84619,83129,80640,80344,77205,64913,69043,81129],
			'สุพรรณบุรี'         => [646878,608292,522063,593312,488913,475835,415137,391078,383866,407740,433929,535015],
			'สุราษฎร์ธานี'       => [348627,360250,404426,432952,395537,353831,395382,424495,401509,397748,389285,518928],
			'สุรินทร์'           => [113805,114687,116077,113637,105819,106136,95482,90463,91017,90604,104874,107203],
			'สุโขทัย'            => [110686,83119,82741,92504,106650,98077,79028,80516,77287,112773,122863,122644],
			'หนองคาย'            => [226113,227231,229846,245491,213473,211925,226526,214634,202600,232031,212355,234074],
			'หนองบัวลำภู'        => [34847,30619,31149,37938,34251,31807,33581,29485,29281,31436,32984,34110],
			'อำนาจเจริญ'         => [23746,22853,21669,28450,27542,23568,23363,21812,21239,22088,23353,29740],
			'อุดรธานี'           => [338399,316557,337672,373627,352720,343984,299768,336188,329823,360142,339841,372994],
			'อุตรดิตถ์'          => [112774,99323,105491,96118,90878,89185,93979,94652,84680,96230,109958,119548],
			'อุทัยธานี'          => [96193,87232,84481,85175,82187,79983,84938,84365,81246,92940,89990,110212],
			'อุบลราชธานี'        => [444077,454439,447164,433361,350693,260333,234979,229799,226831,260950,256653,267435],
			'อ่างทอง'            => [102817,102556,104337,111397,102862,97321,96830,101387,103372,85682,83759,99725],
			'เชียงราย'           => [644347,549565,459741,501564,487600,418004,353058,359306,330826,480177,557243,624133],
			'เชียงใหม่'          => [928142,866338,566973,635336,715003,655817,473833,540427,513561,735456,943449,997202],
			'เพชรบุรี'           => [954669,889994,903595,941610,948426,799651,882740,837599,767359,806545,801184,1010577],
			'เพชรบูรณ์'          => [315984,245963,192112,226436,228167,210352,189543,190679,194573,217193,247498,305809],
			'เลย'                => [219249,201424,186841,187701,199363,344191,182567,173670,171009,185170,189049,226765],
			'แพร่'               => [129341,113892,108156,121583,112043,104071,88016,95670,91478,114426,124393,142541],
			'แม่ฮ่องสอน'         => [109403,85501,81946,85136,84314,90383,77656,80255,77940,89460,94179,126025],
		];

		// ดึง events รายจังหวัด รายเดือน 2568 จาก DB
		$prov_events_monthly = $ActModel->getActivityByMonthByProvince(2025);

		$province_dataset = [];
		foreach ($province_visitors_monthly as $pname => $vis_arr) {
			// Visitor monthly เป็น "ล้านคน" 2 ตำแหน่ง สำหรับ chart
			$vis_million = array_map(function($v){ return round($v / 1000000, 3); }, $vis_arr);
			$evt_arr = isset($prov_events_monthly[$pname])
				? array_values($prov_events_monthly[$pname])
				: array_fill(0, 12, 0);
			$province_dataset[$pname] = [
				'name'     => $pname,
				'visitors' => $vis_million,
				'events'   => $evt_arr,
			];
		}
		// "ภาพรวมประเทศ" รวมเข้า dataset เป็น key พิเศษ
		$province_dataset['__ALL__'] = [
			'name'     => 'ภาพรวมประเทศ (77 จังหวัด)',
			'visitors' => $visitors_2568_monthly, // ของ all-province จาก main+minor
			'events'   => $act_2568_arr,
		];
		$data['mim_dataset']   = $province_dataset;
		$data['mim_thai_short']= $thai_short;

		return view('Modules\Main\Views\realtime2', $data);
	}
}
