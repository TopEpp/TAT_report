<?php

namespace Modules\Main\Controllers;

use App\Controllers\BaseController;
use Modules\Main\Models\Main_model;
use Modules\Report\Models\Report_model;
use Modules\Setting\Models\Setting_model;
use CodeIgniter\API\ResponseTrait;

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
			'orientation' =>'L', // L แนวนอน P แนวตั้งง
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

		$img = $_POST['imgBase64'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = $uploadfile . $_POST['imgName'] . '.png';
		// @unlike($file);
		$success = file_put_contents($file, $data);

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
		if(@$_GET['export']=='pdf'){
			$this->export_pdf('Modules\Main\Views\export\departure', $data , $orientation);
		}else{
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

		
		if(@$_GET['export']=='pdf'){
			$this->export_pdf('Modules\Main\Views\export\country', $data);
		}else{
			return view('Modules\Main\Views\export\country_view', $data);

		}
		
	}
}