<?php

namespace Modules\Report\Controllers;

use App\Controllers\BaseController;
use Modules\Report\Models\Report_model;
use Modules\Setting\Models\Setting_model;
use Modules\Main\Models\Main_model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Report extends BaseController
{

	public function index()
	{
	}

	public function nation()
	{
		$Model = new Report_model();
		$Main_model = new Main_model();
		$data['session'] = session();
		$data['Mydate'] = $this->Mydate;

		$date = $Main_model->getMaxDate();
		// $date = date('Y-m-d');
		$day = date('d');
		$data['year'] = date('Y');
		$data['month'] = date('m');
		$data['to_date'] = $date;
		if (!empty($_GET['d'])) {
			$date = $_GET['d'];
			$data['to_date'] = $date;
			$date_explode = explode('-', $date);

			$day = $date_explode[2];
			$data['month'] = $date_explode[1];
			$data['year'] = $date_explode[0];
		}

		list($year, $month, $day) = explode('-', $data['to_date']);
		$data['to_date_label'] = $day . '/' . $month . '/' . $year;

		$date_lastyear = ($data['year'] - 1) . '-' . $data['month'] . '-' . $day;

		$data['month_label'] = $this->month_th_short[(int)$data['month']];

		$data['data_day'] = $Model->getNatDateData($date);
		$data['data_month'] = $Model->getNatMonthData($day, $data['month'], $data['year']);

		$data['data_day_lastyear'] = $Model->getNatDateData($date_lastyear);
		$data['data_month_lastyear'] = $Model->getNatMonthData($day, $data['month'], ($data['year'] - 1));
		$data['export_type'] = @$_GET['export_type'];
		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('nation.xlsx', 'Modules\Report\Views\export\nation', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\nation', $data);
		} else {
			return view('Modules\Report\Views\nation', $data);
		}
	}

	public function port()
	{
		$Model = new Report_model();
		$Main_model = new Main_model();
		$data['session'] = session();
		$data['Mydate'] = $this->Mydate;

		$date = $Main_model->getMaxDate();
		// $date = date('Y-m-d');
		$day = date('d');
		$data['year'] = date('Y');
		$data['month'] = date('m');
		$data['to_date'] = $date;
		if (!empty($_GET['d'])) {
			$date = $_GET['d'];
			$data['to_date'] = $date;
			$date_explode = explode('-', $date);

			$day = $date_explode[2];
			$data['month'] = $date_explode[1];
			$data['year'] = $date_explode[0];
		}

		list($year, $month, $day) = explode('-', $data['to_date']);
		$data['to_date_label'] = $day . '/' . $month . '/' . $year;

		$date_lastyear = ($data['year'] - 1) . '-' . $data['month'] . '-' . $day;

		$data['month_label'] = $this->month_th_short[(int)$data['month']];

		$data['data_day'] = $Model->getPortDateData($date);
		$data['data_month'] = $Model->getPortMonthData($day, $data['month'], $data['year']);

		$data['data_day_lastyear'] = $Model->getPortDateData($date_lastyear);
		$data['data_month_lastyear'] = $Model->getPortMonthData($day, $data['month'], ($data['year'] - 1));
		$data['export_type'] = @$_GET['export_type'];
		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('port.xlsx', 'Modules\Report\Views\export\port', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\port', $data);
		} else {
			return view('Modules\Report\Views\port', $data);
		}
	}

	public function nation_compare()
	{
		$Model = new Report_model();
		$Main_model = new Main_model();
		$data['session'] = session();
		// $date = date('Y-m-d');
		$date = $Main_model->getMaxDate();
		$data['to_date'] = $date;
		$data['Mydate'] = $this->Mydate;

		list($year, $month, $day) = explode('-', $date);
		$to_date = $day . '-' . $month . '-' . ($year);
		$data['start_date1'] = $data['start_date2'] = $data['end_date1'] = $data['end_date2'] = $to_date; // date('d-m-Y');
		$data['country_type'] = 'all';
		if (!empty($_GET['start1'])) {
			$data['start_date1'] = $_GET['start1'];
		}
		if (!empty($_GET['start2'])) {
			$data['start_date2'] = $_GET['start2'];
		}
		if (!empty($_GET['end1'])) {
			$data['end_date1'] = $_GET['end1'];
		}
		if (!empty($_GET['end2'])) {
			$data['end_date2'] = $_GET['end2'];
		}
		if (!empty($_GET['show_type'])) {
			$data['show_type'] = $_GET['show_type'];
		}
		if (!empty($_GET['country_type'])) {
			$data['country_type'] = $_GET['country_type'];
		}

		// echo '<pre>'; print_r($data); exit;
		$data['region'] = $Model->getSTDRegion($data['country_type']);
		$data['country'] = $Model->getCountryByRegion($data['country_type']);
		$data['data1'] = $Model->getNatBetweenDateData($data['start_date1'], $data['end_date1'], $data['country_type']);
		$data['data2'] = $Model->getNatBetweenDateData($data['start_date2'], $data['end_date2'], $data['country_type']);

		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('nation_compare.xlsx', 'Modules\Report\Views\export\nation_compare', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\nation_compare', $data);
		} else {
			return view('Modules\Report\Views\nation_compare', $data);
		}
	}

	public function port_compare()
	{
		$Model = new Report_model();
		$Main_model = new Main_model();
		$data['session'] = session();
		// $date = date('Y-m-d');
		$date = $Main_model->getMaxDate();
		$data['to_date'] = $date;
		$data['Mydate'] = $this->Mydate;
		$data['port'] = $Model->getPortGroupType();

		list($year, $month, $day) = explode('-', $date);
		$to_date = $day . '-' . $month . '-' . ($year);

		$data['start_date1'] = $data['end_date1'] = $to_date; //date('d-m-Y');
		$data['country_type'] = 'all';
		$data['port_type'] = array();
		if (!empty($_GET['start1'])) {
			$data['start_date1'] = $_GET['start1'];
		}
		if (!empty($_GET['end1'])) {
			$data['end_date1'] = $_GET['end1'];
		}
		if (!empty($_GET['country_type'])) {
			$data['country_type'] = $_GET['country_type'];
		}
		if (!empty($_GET['port_type'])) {
			$data['port_type'] = explode(',', $_GET['port_type']);
		}

		if (!empty($data['port_type'])) {
			list($day, $month, $year) = explode('-', $data['start_date1']);
			$start_period = $year . '-' . $month . '-' . $day;

			list($day, $month, $year) = explode('-', $data['end_date1']);
			$end_period = $year . '-' . $month . '-' . $day;


			$data['period'] = $data['Mydate']->date_range(date('Y-m-d', strtotime($start_period)), date('Y-m-d', strtotime($end_period)));
			$data['port_colunm'] = $Model->getPortColunm($data['port_type']);
			$data['country_row'] = $Model->getCountryCompareRow($data['start_date1'], $data['end_date1'], $data['country_type'], $data['port_type']);
			$data['data'] = $Model->getPortCompareData($data['start_date1'], $data['end_date1'], $data['country_type'], $data['port_type']);
		}

		$data['region'] = $Model->getSTDRegion($data['country_type']);
		$data['country'] = $Model->getCountryByRegion($data['country_type']);

		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('port_compare.xlsx', 'Modules\Report\Views\export\port_compare', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\port_compare', $data, 'L');
		} else {
			return view('Modules\Report\Views\port_compare', $data);
		}
	}

	public function market()
	{
		$Model = new Report_model();
		$Main_model = new Main_model();
		$data['session'] = session();
		$date = date('Y-m-d');
		$date = $Main_model->getMaxDate();
		$data['to_date'] = $date;
		$data['Mydate'] = $this->Mydate;

		if (empty($_GET['d1']) && empty($_GET['d2'])) {
			list($year, $month, $day) = explode('-', $date);
			$date_start = date($day . '/' . $month . '/' . $year);
			$date_end = date($day . '/' . $month . '/' . $year);
		} else {
			list($day, $month, $year) = explode('-', $_GET['d1']);
			$date_start = $day . '/' . $month . '/' . $year;
			list($day, $month, $year) = explode('-', $_GET['d2']);
			$date_end = $day . '/' . $month . '/' . $year;
		}

		$data['date_start'] = $date_start;
		$data['date_end'] = $date_end;
		$data['data'] = $Model->getMarketData($date_start, $date_end);
		$data['country'] = $Model->getCountryByMarket();
		$data['export_type'] = @$_GET['export_type'];
		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('market.xlsx', 'Modules\Report\Views\export\market', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\market', $data);
		} else {
			return view('Modules\Report\Views\market', $data);
		}
	}

	public function nation_daily()
	{
		$Model = new Report_model();
		$Main_model = new Main_model();
		$data['session'] = session();
		$date = $Main_model->getMaxDate();
		$data['Mydate'] = $this->Mydate;

		if (empty($_GET['d1']) && empty($_GET['d2'])) {
			list($year, $month, $day) = explode('-', $date);
			$date_start = date($day . '/' . $month . '/' . $year);
			$date_end = date($day . '/' . $month . '/' . $year);
		} else {
			list($year, $month, $day) = explode('-', $_GET['d1']);
			$date_start = $day . '/' . $month . '/' . $year;
			list($year, $month, $day) = explode('-', $_GET['d2']);
			$date_end = $day . '/' . $month . '/' . $year;
		}

		$data['date_start'] = $date_start;
		$data['date_end'] = $date_end;

		list($day, $month, $year) = explode('/', $date_start);
		$start_period = $year . '-' . $month . '-' . $day;
		list($day, $month, $year) = explode('/', $date_end);
		$end_period = $year . '-' . $month . '-' . $day;

		$data['period'] = $data['Mydate']->date_range(date('Y-m-d', strtotime($start_period)), date('Y-m-d', strtotime($end_period)));
		$data['data'] = $Model->getNatDaily($date_start, $date_end);
		// $data['country'] = $Model->getCountryForNatDaily($date_start,$date_end);

		$data['region'] = $Model->getSTDRegion('standard');
		$data['country'] = $Model->getCountryByRegion('standard');

		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('nation_daily.xlsx', 'Modules\Report\Views\export\nation_daily', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\nation_daily', $data, 'L');
		} else {
			return view('Modules\Report\Views\nation_daily', $data);
		}
	}

	public function port_daily()
	{
		$Model = new Report_model();
		$Main_model = new Main_model();
		$Setting_model = new Setting_model();
		$date = $Main_model->getMaxDate();
		$data['session'] = session();
		$data['Mydate'] = $this->Mydate;

		if (empty($_GET['d1']) && empty($_GET['d2'])) {
			list($year, $month, $day) = explode('-', $date);
			$date_start = date($day . '/' . $month . '/' . $year);
			$date_end = date($day . '/' . $month . '/' . $year);
		} else {
			list($year, $month, $day) = explode('-', $_GET['d1']);
			$date_start = $day . '/' . $month . '/' . $year;
			list($year, $month, $day) = explode('-', $_GET['d2']);
			$date_end = $day . '/' . $month . '/' . $year;
		}

		$data['date_start'] = $date_start;
		$data['date_end'] = $date_end;

		list($day, $month, $year) = explode('/', $date_start);
		$start_period = $year . '-' . $month . '-' . $day;
		list($day, $month, $year) = explode('/', $date_end);
		$end_period = $year . '-' . $month . '-' . $day;

		$data['period'] = $data['Mydate']->date_range(date('Y-m-d', strtotime($start_period)), date('Y-m-d', strtotime($end_period)));
		$data['data'] = $Model->getPortDaily($date_start, $date_end);
		$data['port'] = $Model->getPortGroupType();

		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('port_daily.xlsx', 'Modules\Report\Views\export\port_daily', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\port_daily', $data, 'L');
		} else {
			return view('Modules\Report\Views\port_daily', $data);
		}
	}


	####### Export #######
	function export_excel($file, $view, $data)
	{

		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();
		// Redirect output to a client’s web browser (Xlsx)

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=$file");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		// header('Cache-Control: max-age=1');
		$htmlString = view($view, $data);
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
		$spreadsheet = $reader->loadFromString($htmlString);

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;
	}

	function export_pdf($view, $data, $orientation = 'P')
	{
		$html = view($view, $data);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf = new \Mpdf\Mpdf([
			'default_font' => 'tatsana',
			'default_font_size' => 12,
			'mode' => 'utf-8',
			'format' => 'A4',
			'margin_top' => 10,
			'margin_header' => 2, // 30mm not pixel
			'margin_footer' => 2, // 10mm
			'orientation' => $orientation, // L แนวนอน P แนวตั้งง
		]);

		$footer = '<table width="100%" border=0 style="border:0px ">
                <tr border=0 style="border:0px ">
                  <td align="left" border=0 style="border:0px ">
                    <img src="' . base_url('public/img/logotat.png') . '">
                  </td>
                  <td align="right" border=0 style="border:0px ">
                    Source of Data : Tourism Authority of Thailand <br>
                    As of : ' . date('d M Y H:i:s') . '
                  </td>
                </tr>
              </table>';
		$mpdf->SetFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}
}
