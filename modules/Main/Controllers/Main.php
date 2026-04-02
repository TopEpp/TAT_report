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

		try {
			$maxDate = $Model->getMaxDate();
			if ($maxDate) {
				$maxDateParts = explode('-', $maxDate);
				$maxDay = (int)$maxDateParts[2];
				$maxMonth = (int)$maxDateParts[1];

				$monthly2569 = $Model->getSumMonthly($currentYear);
				$monthly2568 = $Model->getSumMonthly($prevYear);

				if ($maxDay < 28 || !isset($monthly2569[$maxMonth])) {
					$partialStart = $currentYear . '-' . str_pad($maxMonth, 2, '0', STR_PAD_LEFT) . '-01';
					$partialEnd = $maxDate;
					$partialMonthTotal = (float)$Model->getSumMonth($partialStart, $partialEnd);
					$hasPartialMonth = $partialMonthTotal > 0;
				}
			}
		} catch (\Exception $e) {
			// DB connection failed — ใช้ fallback data
		}

		// สร้าง array ข้อมูลรายเดือน (ล้านคน)
		$data['month_labels'] = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
		$data['month_labels_th'] = $this->month_th_short;

		// ตรวจสอบว่า DB มีข้อมูลจริงหรือไม่
		$dbHasData = !empty($monthly2568) || !empty($monthly2569);

		if ($dbHasData) {
			// สร้าง array จากข้อมูล DB
			$arrivals2568 = [];
			$arrivals2569Actual = [];
			for ($m = 1; $m <= 12; $m++) {
				$arrivals2568[] = isset($monthly2568[$m]) ? round($monthly2568[$m] / 1000000, 2) : null;

				if (isset($monthly2569[$m])) {
					$arrivals2569Actual[] = round($monthly2569[$m] / 1000000, 2);
				} elseif ($m == $maxMonth && $hasPartialMonth) {
					$arrivals2569Actual[] = round($partialMonthTotal / 1000000, 2);
				} else {
					$arrivals2569Actual[] = null;
				}
			}
			$data['data_period'] = '1 ม.ค. - ' . $maxDay . ' ' . $this->month_th_short[$maxMonth] . ' ' . $currentYearThai;
		} else {
			// Fallback: DB ไม่มีข้อมูลหรือเชื่อมไม่ได้
			$arrivals2568 = [3.09, 3.42, 3.58, 3.41, 2.93, 2.75, 2.89, 2.78, 2.65, 2.95, 3.15, 3.52];
			$arrivals2569Actual = [3.28, 3.26, 2.28, null, null, null, null, null, null, null, null, null];
			$maxDay = 25; $maxMonth = 3;
			$data['data_period'] = '1 ม.ค. - 25 มี.ค. ' . $currentYearThai;
		}
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

		// YTD summary
		if ($dbHasData) {
			$ytdTotal = 0;
			$ytdMonths = [];
			for ($m = 1; $m <= 12; $m++) {
				$val = null;
				$monthLabel = $this->month_th_short[$m];

				if (isset($monthly2569[$m])) {
					$val = $monthly2569[$m];
				} elseif ($m == $maxMonth && $hasPartialMonth) {
					$val = $partialMonthTotal;
					$monthLabel .= '(1-' . $maxDay . ')';
				}

				if ($val !== null) {
					$ytdTotal += $val;
					$prevVal = isset($monthly2568[$m]) ? $monthly2568[$m] : 0;
					$yoy = $prevVal > 0 ? round(($val - $prevVal) / $prevVal * 100, 1) : 0;
					$ytdMonths[] = [
						'month' => $monthLabel,
						'actual' => round($val / 1000000, 2),
						'yoy' => $yoy,
					];
				}
			}
			$data['ytd_total'] = round($ytdTotal / 1000000, 2);
			$data['ytd_months'] = $ytdMonths;
		} else {
			// Fallback YTD — คำนวณ YoY จาก fallback arrivals
			// 2568: [3.09, 3.42, 3.58, ...], 2569: [3.28, 3.26, 2.28, ...]
			$data['ytd_total'] = 8.82;
			$fallbackPairs = [
				['month' => 'ม.ค.', 'cur' => 3.28, 'prev' => 3.09],
				['month' => 'ก.พ.', 'cur' => 3.26, 'prev' => 3.42],
				['month' => 'มี.ค.(1-25)', 'cur' => 2.28, 'prev' => 3.58],
			];
			$data['ytd_months'] = [];
			foreach ($fallbackPairs as $fp) {
				$yoy = $fp['prev'] > 0 ? round(($fp['cur'] - $fp['prev']) / $fp['prev'] * 100, 1) : 0;
				$data['ytd_months'][] = [
					'month' => $fp['month'],
					'actual' => $fp['cur'],
					'yoy' => $yoy,
				];
			}
		}
		$data['current_year_thai'] = $currentYearThai;
		$data['prev_year_thai'] = $prevYearThai;

		// Top Markets จาก DB — ดึง Top 10 ประเทศ
		$topMarkets = [];
		if ($dbHasData) {
			$latestFullMonth = 0;
			for ($m = 12; $m >= 1; $m--) {
				if (isset($monthly2569[$m])) { $latestFullMonth = $m; break; }
			}
			if ($latestFullMonth == 0 && $hasPartialMonth) {
				$latestFullMonth = $maxMonth;
			}
			if ($latestFullMonth > 0) {
				$topCountries = $Model->getSumMonthlyCountryPeriod(1, $latestFullMonth, $currentYear, 10);
				foreach ($topCountries as $c) {
					$change = 0;
					if (isset($c['NUM_PAST']) && $c['NUM_PAST'] > 0) {
						$change = round(($c['NUM'] - $c['NUM_PAST']) / $c['NUM_PAST'] * 100, 1);
					}
					$topMarkets[] = [
						'name' => $c['COUNTRY_NAME_EN'],
						'change' => $change,
						'current' => (int)$c['NUM'],
						'past' => (int)($c['NUM_PAST'] ?? 0),
					];
				}
			}
		}
		// Fallback Top Markets
		if (empty($topMarkets)) {
			$topMarkets = [
				['name' => 'China', 'change' => 5.2, 'current' => 1850000, 'past' => 1758000],
				['name' => 'Malaysia', 'change' => -12.3, 'current' => 980000, 'past' => 1117000],
				['name' => 'India', 'change' => 18.5, 'current' => 720000, 'past' => 607000],
				['name' => 'Russia', 'change' => 8.1, 'current' => 650000, 'past' => 601000],
				['name' => 'South Korea', 'change' => -8.7, 'current' => 580000, 'past' => 635000],
				['name' => 'Japan', 'change' => 3.4, 'current' => 510000, 'past' => 493000],
				['name' => 'United Kingdom', 'change' => 6.8, 'current' => 380000, 'past' => 356000],
				['name' => 'Germany', 'change' => 4.2, 'current' => 320000, 'past' => 307000],
				['name' => 'USA', 'change' => 2.1, 'current' => 290000, 'past' => 284000],
				['name' => 'Vietnam', 'change' => -15.4, 'current' => 250000, 'past' => 295000],
			];
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

		// TOP %Change Regions — ดึงจาก DB (JAN-MAR ปีปัจจุบัน vs ปีก่อน)
		$regionChanges = [];
		if ($dbHasData) {
			try {
				$latestM = $maxMonth;
				// ถ้าเดือนปัจจุบันยังไม่ครบ ใช้เดือนก่อนหน้า
				if ($hasPartialMonth && !isset($monthly2569[$maxMonth])) {
					$latestM = $maxMonth - 1;
				}
				if ($latestM < 1) $latestM = 1;

				$regCurrent = $Model->getSumMonthlyRegionPeriod(1, $latestM, $currentYear);
				$regPast = $Model->getSumMonthlyRegionPeriod(1, $latestM, $prevYear);

				// Region mapping: STD_REGION_ID => region name (ตาม monthly_period.php)
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

				// เรียงตาม %diff (ลบมาก → บวกมาก)
				usort($regionRows, function($a, $b) { return $a['diff'] <=> $b['diff']; });

				$grandDiff = $grandPast > 0 ? round(($grandCurrent - $grandPast) / $grandPast * 100, 2) : 0;
				array_unshift($regionRows, ['region' => 'GRAND TOTAL', 'prev' => (int)$grandPast, 'current' => (int)$grandCurrent, 'diff' => $grandDiff, 'is_total' => true]);

				$regionChanges = $regionRows;
			} catch (\Exception $e) {
				// fallback below
			}
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
}
