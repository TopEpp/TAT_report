<?php

namespace Modules\Main\Controllers;

use App\Controllers\BaseController;
use Modules\Main\Models\Main_model;
use Modules\Report\Models\Report_model;
use Modules\Setting\Models\Setting_model;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\DataGovApi;

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

		$Model = new Main_model();

		// ============================================================
		// ข้อมูลจริงจาก DB
		// ============================================================

		// หาวันที่ล่าสุดในระบบ
		$max_date = $Model->getMaxDate(); // YYYY-MM-DD
		list($max_year, $max_month, $max_day) = explode('-', $max_date);

		// --- Metric Card 1: นักท่องเที่ยวเดือนปัจจุบัน (จาก DB) ---
		$current_month_start = $max_year . '-' . $max_month . '-01';
		$current_month_end = $max_date;
		$tourist_current = (int) $Model->getSumMonth($current_month_start, $current_month_end);

		// --- MoM%: เปรียบเทียบกับเดือนก่อน (ช่วงเดียวกัน) ---
		$prev_month = (int)$max_month - 1;
		$prev_year = (int)$max_year;
		if ($prev_month < 1) {
			$prev_month = 12;
			$prev_year--;
		}
		$prev_month_str = str_pad($prev_month, 2, '0', STR_PAD_LEFT);
		$prev_month_start = $prev_year . '-' . $prev_month_str . '-01';
		$prev_month_end = $prev_year . '-' . $prev_month_str . '-' . $max_day;
		$tourist_prev = (int) $Model->getSumMonth($prev_month_start, $prev_month_end);

		$tourist_change = 0;
		if ($tourist_prev > 0) {
			$tourist_change = round(($tourist_current - $tourist_prev) / $tourist_prev * 100, 1);
		}

		$data['tourist_current'] = $tourist_current;
		$data['tourist_change'] = $tourist_change;
		$data['data_date'] = $max_date; // วันที่ข้อมูลล่าสุด

		// --- YoY%: เปรียบเทียบกับปีก่อน (ช่วงเดียวกัน) ---
		$yoy_start = ($max_year - 1) . '-' . $max_month . '-01';
		$yoy_end = ($max_year - 1) . '-' . $max_month . '-' . $max_day;
		$tourist_yoy = (int) $Model->getSumMonth($yoy_start, $yoy_end);
		$data['tourist_yoy_change'] = 0;
		if ($tourist_yoy > 0) {
			$data['tourist_yoy_change'] = round(($tourist_current - $tourist_yoy) / $tourist_yoy * 100, 1);
		}

		// --- Trend Chart: นักท่องเที่ยวรายเดือน (จาก DB) ---
		$chartYearData = $Model->getSumChartYear((int)$max_year);
		$tourist_monthly = [];
		$tourist_monthly_past = [];
		for ($m = 1; $m <= 12; $m++) {
			$tourist_monthly[$m] = isset($chartYearData['current'][$m]) ? round($chartYearData['current'][$m] / 1000000, 2) : null;
			$tourist_monthly_past[$m] = isset($chartYearData['past'][$m]) ? round($chartYearData['past'][$m] / 1000000, 2) : null;
		}

		$data['months'] = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
		$data['tourist_monthly'] = array_values($tourist_monthly);        // ปีปัจจุบัน (ล้านคน)
		$data['tourist_monthly_past'] = array_values($tourist_monthly_past); // ปีก่อน (ล้านคน)
		$data['chart_year'] = (int)$max_year;
		$data['chart_year_past'] = (int)$max_year - 1;

		// ============================================================
		// ข้อมูลจริงจาก API (data.go.th)
		// ============================================================
		$api = new DataGovApi();

		// --- ราคาน้ำมัน ดีเซล B7 (จาก EPPO via data.go.th) ---
		$oilData = $api->getOilPriceMonthly((int)$max_year);
		$latestOil = $api->getLatestOilPrice();
		$oil_monthly = [];
		for ($m = 1; $m <= 12; $m++) {
			$oil_monthly[] = $oilData['months'][$m] ?? null;
		}
		$data['oil_monthly'] = $oil_monthly;
		$data['oil_source'] = $oilData['source'];
		$data['oil_year'] = $oilData['year'];

		// --- CPI Index (จาก TPSO via data.go.th) ---
		$cpiData = $api->getCpiMonthly((int)$max_year);
		$cpi_monthly = [];
		for ($m = 1; $m <= 12; $m++) {
			$cpi_monthly[] = $cpiData['months'][$m] ?? null;
		}
		$data['cpi_monthly'] = $cpi_monthly;
		$data['cpi_source'] = $cpiData['source'];
		$data['cpi_year'] = $cpiData['year'];
		$data['cpi_base_year'] = $cpiData['base_year'] ?? '2019';

		// --- RSI ดัชนีความเชื่อมั่น (จาก FPO via data.go.th) ---
		$rsiData = $api->getRsiMonthly(((int)$max_year) + 543);
		$sentiment_monthly = [];
		for ($m = 1; $m <= 12; $m++) {
			$sentiment_monthly[] = $rsiData['months'][$m] ?? null;
		}
		$data['sentiment_monthly'] = $sentiment_monthly;
		$data['sentiment_source'] = $rsiData['source'];
		$data['sentiment_year'] = $rsiData['year_ce'];
		$latestRsi = $api->getLatestRsi();

		// --- อัตราเข้าพัก (จาก จังหวัด via data.go.th) ---
		$occData = $api->getOccupancyRate(((int)$max_year) + 543);

		// --- CPI: เลือกแหล่งที่ข้อมูลใหม่กว่า ---
		$cpiWB = $api->getCpiWorldBank();
		$cpiFromDataGov = !empty($cpiData['months']) ? end($cpiData['months']) : null;
		$cpiDataGovYear = $cpiData['year'] ?? 0;
		$cpiWBYear = $cpiWB ? $cpiWB['year'] : 0;

		// ใช้ World Bank ถ้าปีใหม่กว่า data.go.th
		if ($cpiWB && $cpiWBYear > $cpiDataGovYear) {
			$latestCpi = $cpiWB['value'];
			$cpiBaseYear = $cpiWB['base_year'];
			$cpiSourceName = $cpiWB['source'] . ' (ปี ' . $cpiWBYear . ')';
		} else {
			$latestCpi = $cpiFromDataGov ?? 107.78;
			$cpiBaseYear = $cpiData['base_year'] ?? '2019';
			$cpiSourceName = 'TPSO via data.go.th (ปี ' . $cpiDataGovYear . ')';
		}

		// --- Factor Cards: ผสมข้อมูลจริง + mock ---
		$latestOilPrice = $latestOil ? $latestOil['price'] : 31.94;
		$latestRsiVal = $latestRsi ? $latestRsi['value'] : 70.0;
		$latestOccVal = $occData ? $occData['value'] : 70.0;

		$data['factors'] = [
			['name' => 'จำนวนการเดินทาง', 'value' => 2.95, 'unit' => 'ล้านคน', 'r' => 0.91, 'change' => 0, 'bar_percent' => 75, 'color' => '#2ecc71', 'source' => 'mock', 'source_name' => 'ยังไม่มีแหล่งข้อมูล'],
			['name' => 'ราคาน้ำมัน', 'value' => $latestOilPrice, 'unit' => 'บาท/ลิตร', 'r' => -0.67, 'change' => 0, 'bar_percent' => min(100, round($latestOilPrice / 55 * 100)), 'color' => '#e74c3c', 'source' => 'api', 'source_name' => 'EPPO via data.go.th'],
			['name' => 'Sentiment (RSI)', 'value' => $latestRsiVal, 'unit' => 'คะแนน', 'r' => 0.78, 'change' => 0, 'bar_percent' => min(100, round($latestRsiVal)), 'color' => '#f39c12', 'source' => 'api', 'source_name' => $rsiData['source']],
			['name' => 'อัตราเข้าพัก' . ($occData ? ' (ปี ' . $occData['year_be'] . ')' : ''), 'value' => $latestOccVal, 'unit' => '%', 'r' => 0.83, 'change' => 0, 'bar_percent' => min(100, round($latestOccVal)), 'color' => '#3498db', 'source' => $occData ? 'api' : 'mock', 'source_name' => $occData ? $occData['source'] : 'ยังไม่มีแหล่งข้อมูล'],
			['name' => 'CPI Index', 'value' => $latestCpi, 'unit' => '(ฐาน ' . $cpiBaseYear . ')', 'r' => -0.44, 'change' => 0, 'bar_percent' => min(100, round(($latestCpi - 90) / 30 * 100)), 'color' => '#9b59b6', 'source' => 'api', 'source_name' => $cpiSourceName]
		];

		// Metric Cards ที่ยังเป็น mock
		$data['tourist_forecast'] = 3540000;
		$data['forecast_confidence'] = 78;
		$data['health_index'] = 80;
		$data['health_level'] = 'ดี';

		// Monthly mock data (เฉพาะตัวที่ยังไม่มี API)
		$data['travel_monthly'] = [3.4, 3.1, 3.2, 3.0, 2.6, 2.4, 2.7, 2.8, 2.3, 2.8, 3.1, 3.5];
		$data['occ_monthly'] = [72, 74, 72, 68, 62, 60, 63, 65, 61, 68, 71, 76]; // รายเดือนยังเป็น mock (data.go.th มีแค่รายปี)

		// แหล่งข้อมูลรวม (พร้อม API URL)
		$oilLatestLabel = $latestOil ? ' (ข้อมูลถึง ' . $latestOil['date'] . ')' : '';
		$rsiYearLabel = !empty($rsiData['year_ce']) ? ' (ข้อมูลปี ' . ($rsiData['year_ce'] + 543) . ')' : '';
		$occYearLabel = $occData && !empty($occData['year_be']) ? ' (ข้อมูลปี ' . $occData['year_be'] . ')' : '';

		$data['data_sources'] = [
			['name' => 'นักท่องเที่ยว (ข้อมูล ณ ' . $max_date . ')', 'source' => 'สำนักงานตรวจคนเข้าเมือง (สตม.) via TAT Oracle DB', 'type' => 'db', 'api_url' => ''],
			['name' => 'ราคาน้ำมัน ดีเซล B7' . $oilLatestLabel, 'source' => $oilData['source'], 'type' => 'api', 'api_url' => 'https://data.go.th/api/3/action/datastore_search?resource_id=7d56918d-adbf-42b7-bd36-e4b33d425027&filters={"Country":"TH-THAILAND","Item":"1052-HSD (B7)"}&sort=_id desc&limit=12'],
			['name' => 'CPI รายเดือน (ฐานปี ' . ($cpiData['base_year'] ?? '2019') . ', ข้อมูลถึงปี ' . ($cpiData['year'] ?? '-') . ')', 'source' => $cpiData['source'], 'type' => 'api', 'api_url' => 'https://data.go.th/api/3/action/datastore_search?resource_id=6eb23973-01db-49c8-b783-d9d614a7e03e&filters={"INDICATOR_CODE":"ASI.C.CPI.SEC.0"}&sort=_id desc&limit=12'],
			['name' => 'CPI รายปี (ฐานปี 2010, ข้อมูลถึงปี ' . ($cpiWB ? $cpiWB['year'] : '-') . ')', 'source' => $cpiWB ? $cpiWB['source'] : 'World Bank', 'type' => 'api', 'api_url' => 'https://api.worldbank.org/v2/country/TH/indicator/FP.CPI.TOTL?format=json&date=2020:2026'],
			['name' => 'RSI ดัชนีความเชื่อมั่นอนาคตเศรษฐกิจภูมิภาค' . $rsiYearLabel, 'source' => $rsiData['source'], 'type' => 'api', 'api_url' => 'https://data.go.th/api/3/action/datastore_search?resource_id=6e839c50-aadd-4be0-83c1-881164117836&limit=20'],
			['name' => 'อัตราเข้าพัก ค่าเฉลี่ยระดับชาติ' . $occYearLabel, 'source' => $occData ? $occData['source'] : 'ยังไม่มีข้อมูล', 'type' => $occData ? 'api' : 'mock', 'api_url' => 'https://data.go.th/api/3/action/datastore_search?resource_id=f8c47ebc-2e9b-4479-9463-5d34b7deca41&filters={"จังหวัด":"รวมทั้งหมด"}&sort=_id desc'],
			['name' => 'จำนวนการเดินทาง', 'source' => 'ยังไม่มีแหล่งข้อมูล API ฟรี', 'type' => 'mock', 'api_url' => ''],
		];

		// Correlation (mock - ต้องคำนวณจากข้อมูลจริง)
		$data['correlations'] = [
			['name' => 'การเดินทาง', 'r' => 0.91],
			['name' => 'อัตราเข้าพัก', 'r' => 0.83],
			['name' => 'Sentiment', 'r' => 0.78],
			['name' => 'ราคาน้ำมัน', 'r' => -0.67],
			['name' => 'CPI', 'r' => -0.44]
		];

		$data['corr_matrix'] = [
			[1.00, 0.91, -0.43, 0.62, 0.55, -0.28],
			[0.91, 1.00, -0.52, 0.78, 0.71, -0.33],
			[-0.43, -0.52, 1.00, -0.67, -0.41, 0.38],
			[0.62, 0.78, -0.67, 1.00, 0.83, -0.44],
			[0.55, 0.71, -0.41, 0.83, 1.00, -0.41],
			[-0.28, -0.33, 0.38, -0.44, -0.41, 1.00]
		];
		$data['corr_labels'] = ['นักท่องเที่ยว', 'การเดินทาง', 'ราคาน้ำมัน', 'Sentiment', 'อัตราเข้าพัก', 'CPI'];

		return view('Modules\Main\Views\realtime', $data);
	}
}
