<?php

namespace Modules\Main\Controllers;

use App\Controllers\BaseController;
use Modules\Main\Models\Main_model;
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
}
