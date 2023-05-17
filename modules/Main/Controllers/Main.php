<?php

namespace Modules\Main\Controllers;

use App\Controllers\BaseController;
use Modules\Main\Models\Main_model;
use Modules\Report\Models\Report_model;
use CodeIgniter\API\ResponseTrait;

class Main extends BaseController
{

	use ResponseTrait;

	public function index()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();
		$data['session'] = session();
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
		$data['start_date_label'] = $start_date;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$data['end_date_label'] = $end_date;



		$data['to_date'] = $end_date;
		$prev_date = date('Y-m-d', strtotime($end_date . ' -15 day'));
		$data['period'] = $data['Mydate']->date_range($prev_date, $end_date);

		$data['SumDateData'] = $Model->getSumDate($end_date);
		$data['SumMonthData'] = $Model->getSumMonth($start_date, $end_date);

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
		$data['api_code'] = $this->Api_Code;
		return view("Modules\Main\Views\index", $data);
	}

	function update_country()
	{
		$Model = new Main_model();
		$Model->update_country();
	}

	public function export_dashboard()
	{
		$Model = new Main_model();
		$Report_model = new Report_model();
		$data['session'] = session();
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
		$data['start_date_label'] = $start_date;

		list($day, $month, $year) = explode('-', $data['end_date']);
		$end_date = $year . '-' . $month . '-' . $day;
		$data['end_date_label'] = $end_date;



		$data['to_date'] = $end_date;
		$prev_date = date('Y-m-d', strtotime($end_date . ' -15 day'));
		$data['period'] = $data['Mydate']->date_range($prev_date, $end_date);

		$data['SumDateData'] = $Model->getSumDate($end_date);
		$data['SumMonthData'] = $Model->getSumMonth($start_date, $end_date);

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
		$data['api_code'] = $this->Api_Code;

		// return view('Modules\Main\Views\export\dashboard', $data);

		$this->export_pdf('Modules\Main\Views\export\dashboard', $data);
	}

	################## EXPORT ##################

	function export_pdf($view, $data, $orientation = 'P')
	{
		$html = view($view, $data);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf = new \Mpdf\Mpdf([
			'default_font' => 'tatsana',
			'default_font_size' => 10,
			'mode' => 'utf-8',
			'format' => 'A4',
			'margin_top' => 3,
			'margin_left' => 2,
			'margin_right' => 2,
			'margin_header' => 2, // 30mm not pixel
			'margin_footer' => 2, // 10mm
			'orientation' => 'L', // L แนวนอน P แนวตั้งง
		]);

		$footer = '<table width="100%" border=0 style="border:0px">
                <tr border=0 style="border:0px ">
                  <td align="left" border=0 style="border:0px ">
                    <img src="' . base_url('public/img/logotat.png') . '">
                  </td>
                  <td align="right" border=0 style="border:0px;color:white ">
                    Source of Data : Tourism Authority of Thailand <br>
                    As of : ' . date('d M Y H:i:s') . '
                  </td>
                </tr>
              </table>';
		$mpdf->SetFooter($footer);
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
		// $file = UPLOAD_DIR . $_POST['imgName'] . '.png';
		$file = $uploadfile . $_POST['imgName'] . '.png';
		$success = file_put_contents($file, $data);

		return $this->setResponseFormat('json')->respond($file);
	}
}
