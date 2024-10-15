<?php

namespace Modules\Report\Controllers;

use App\Controllers\BaseController;
use Modules\Report\Models\Report_model;
use Modules\Setting\Models\Setting_model;
use Modules\Main\Models\Main_model;
use Modules\Import\Models\Import_model;
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
			$data['month'] = $month = $date_explode[1];
			$data['year'] = $year = $date_explode[0];


		}else{
			list($year, $month, $day) = explode('-', $data['to_date']);
			$data['month'] = $month;
			$data['year'] = $year;
		}

		
		
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
			$data['month'] = $month = $date_explode[1];
			$data['year'] = $year = $date_explode[0];
		}else{
			list($year, $month, $day) = explode('-', $data['to_date']);
			$data['month'] = $month;
			$data['year'] = $year;
		}

		$data['to_date_label'] = $day . '/' . $month . '/' . $year;

		$date_lastyear = ($data['year'] - 1) . '-' . $data['month'] . '-' . $day;

		$data['month_label'] = $this->month_th_short[(int)$data['month']];

		$data['data_day'] = $Model->getPortDateData($date);
		$data['data_month'] = $Model->getPortMonthData($day, $data['month'], $data['year']);

		$data['data_day_lastyear'] = $Model->getPortDateData($date_lastyear);
		$data['data_month_lastyear'] = $Model->getPortMonthData($day, $data['month'], ($data['year'] - 1));
		$data['export_type'] = @$_GET['export_type'];
		$data['api_code'] = $this->Api_Code;
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
		$data['country_id'] = '';
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
		if (!empty($_GET['country_id'])) {
			$data['country_id'] = $_GET['country_id'];
		}

		// echo '<pre>'; print_r($data); exit;
		$data['country_select'] = $Model->getCountryAllRow();
		$data['region'] = $Model->getSTDRegion($data['country_type']);
		$data['country'] = $Model->getCountryByRegion($data['country_type']);
		$data['data1'] = $Model->getNatBetweenDateData($data['start_date1'], $data['end_date1'], $data['country_type'],$data['country_id']);
		$data['data2'] = $Model->getNatBetweenDateData($data['start_date2'], $data['end_date2'], $data['country_type'],$data['country_id']);
		$data['export_type'] = @$_GET['export_type'];
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
		$data['country_id'] = '';
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
		if (!empty($_GET['country_id'])) {
			$data['country_id'] = $_GET['country_id'];
		}

		if (!empty($data['port_type'])) {
			list($day, $month, $year) = explode('-', $data['start_date1']);
			$start_period = $year . '-' . $month . '-' . $day;

			list($day, $month, $year) = explode('-', $data['end_date1']);
			$end_period = $year . '-' . $month . '-' . $day;


			$data['period'] = $data['Mydate']->date_range(date('Y-m-d', strtotime($start_period)), date('Y-m-d', strtotime($end_period)));
			$data['port_colunm'] = $Model->getPortColunm($data['port_type']);
			$data['country_row'] = $Model->getCountryCompareRow($data['start_date1'], $data['end_date1'], $data['country_type'], $data['port_type']);
			$data['data'] = $Model->getPortCompareData($data['start_date1'], $data['end_date1'], $data['country_type'], $data['port_type'],$data['country_id']);
		}

		$data['country_select'] = $Model->getCountryAllRow();
		$data['region'] = $Model->getSTDRegion($data['country_type']);
		$data['country'] = $Model->getCountryByRegion($data['country_type']);

		$data['export_type'] = @$_GET['export_type'];
		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('port_compare.xlsx', 'Modules\Report\Views\export\port_compare', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\port_compare', $data, 'L');
		} else {
			return view('Modules\Report\Views\port_compare', $data);
		}
	}

	public function port_compare_monthly()
	{
		$Model = new Report_model();
		$Main_model = new Main_model();
		$data['session'] = session();
		// $date = date('Y-m-d');
		$date = $Main_model->getMaxDate();
		$data['to_date'] = $date;
		$data['Mydate'] = $this->Mydate;
		$data['port'] = $Model->getPortGroupType();
		$data['year'] = date('Y');
		$data['m_start'] = 1; $data['m_end'] = 12;
		$data['month_label'] = $this->month_en;
		$data['month_label_short'] = $this->month_en_short;
		
		$data['country_type'] = 'all';
		$data['country_id'] = '';
		$data['port_type'] = array();

		$end_date = $Main_model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_month'] = $month;

		if (!empty($_GET['year'])) {
			$data['year'] = $_GET['year'];
		}
		if (!empty($_GET['m_start'])) {
			$data['m_start'] = $_GET['m_start'];
		}
		if (!empty($_GET['m_end'])) {
			$data['m_end'] = $_GET['m_end'];
		}else{
			$data['m_end'] = $data['end_month'];
		}
		if (!empty($_GET['country_type'])) {
			$data['country_type'] = $_GET['country_type'];
		}
		if (!empty($_GET['port_type'])) {
			$data['port_type'] = explode(',', $_GET['port_type']);
		}
		if (!empty($_GET['country_id'])) {
			$data['country_id'] = $_GET['country_id'];
		}

		$m_start = $data['m_start']; $m_end = $data['m_end'];
		for($m_start;$m_start<=$m_end;$m_start++){
			$data['period'][$m_start] = $data['month_label_short'][$m_start];
		}

		if (!empty($data['port_type'])) {
			$data['port_colunm'] = $Model->getPortColunm($data['port_type']);
			$data['country_row'] = $Model->getCountryCompareRowMonthly($data['year'],$data['m_start'], $data['m_end'], $data['country_type'], $data['port_type']);
			$data['data'] = $Model->getPortCompareDataMonthly($data['year'],$data['m_start'], $data['m_end'], $data['country_type'], $data['port_type'],$data['country_id']);
		}

		$data['country_select'] = $Model->getCountryAllRow();
		$data['region'] = $Model->getSTDRegion($data['country_type']);
		$data['country'] = $Model->getCountryByRegion($data['country_type']);
		$data['select_year'] = $Model->getSelectYear();


		$data['export_type'] = @$_GET['export_type'];
		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('port_compare_monthly.xlsx', 'Modules\Report\Views\export\port_compare_monthly', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\port_compare_monthly', $data, 'L');
		} else {
			return view('Modules\Report\Views\port_compare_monthly', $data);
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
		$data['to_date'] = $date;
		$data['Mydate'] = $this->Mydate;
		$data['country_type'] = 'all';

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

		if (!empty($_GET['country_type'])) {
			$data['country_type'] = $_GET['country_type'];
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

		$data['region'] = $Model->getSTDRegion($data['country_type']);
		$data['country'] = $Model->getCountryByRegion($data['country_type']);

		$data['export_type'] = @$_GET['export_type'];
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
		$data['to_date'] = $date;
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
		$data['export_type'] = @$_GET['export_type'];
		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('port_daily.xlsx', 'Modules\Report\Views\export\port_daily', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\port_daily', $data, 'L');
		} else {
			return view('Modules\Report\Views\port_daily', $data);
		}
	}

	public function port_monthly()
	{
		$Model = new Report_model();
		$Main_model = new Main_model();
		$Setting_model = new Setting_model();
		$date = $Main_model->getMaxDate();
		$data['to_date'] = $date;
		$data['session'] = session();
		$data['Mydate'] = $this->Mydate;
		$data['year'] = date('Y');
		$data['m_start'] = 1; $data['m_end'] = 12;
		$data['month_label'] = $this->month_en;
		$m_start = $data['m_start']; $m_end = $data['m_end'];
		for($m_start;$m_start<$m_end;$m_start++){
			$data['period'][$m_start] = $data['month_label'][$m_start];
		}
		
		$data['data'] = $Model->getPortMonthly($data['year'],$data['m_start'], $data['m_end']);
		$data['port'] = $Model->getPortGroupType();


		$data['export_type'] = @$_GET['export_type'];
		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('port_monthly.xlsx', 'Modules\Report\Views\export\port_monthly', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\port_monthly', $data, 'L');
		} else {
			return view('Modules\Report\Views\port_monthly', $data);
		}
	}

	public function monthly()
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '300');
		$data = array();
		$Model_import = new Import_model();
		$Model = new Report_model();
		$data['session'] = session();
		$data['Mydate'] = $this->Mydate;
		$data['month_label'] = $this->month_th;
		$data['year'] = date('Y');
		$data['month'] = date('m');
		$data['year2'] = date('Y');
		$data['month2'] = date('m');
		$data['port_type'] = array();
		$data['point_type'] = array();
		$data['country_type'] = 'all';
		if (!empty($_GET['m'])) {
			$data['month'] = $_GET['m'];
			$data['month2'] = $_GET['m2'];
		}
		if (!empty($_GET['y'])) {
			$data['year'] = $_GET['y']-543;
			$data['year2'] = $_GET['y2']-543;
		}
		if (!empty($_GET['country_type'])) {
			$data['country_type'] = $_GET['country_type'];
		}
		if (!empty($_GET['port_type'])) {
			$data['port_type'] = explode(',', $_GET['port_type']);
		}
		if (!empty($_GET['point_type'])) {
			$data['point_type'] = explode(',', $_GET['point_type']);
		}

		
		$data['port'] = $Model->getPortGroupTypeMonthly();
		$data['port_colunm'] = $Model_import->getPortMonthly($data['port_type']);
		$data['point_select'] = $Model_import->getPointMonthly();
		$data['point'] = $Model_import->getPointMonthly($data['point_type']);
		$data['data'] = $Model_import->getRawDataMonthly($data['year'],$data['month'],$data['year2'],$data['month2']);
		$data['region'] = $Model->getSTDRegion($data['country_type']);
		$data['country'] = $Model->getCountryByRegion($data['country_type']);

		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('monthly.xlsx', 'Modules\Report\Views\export\monthly', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\monthly', $data, 'L');
		} else {
			return view('Modules\Report\Views\monthly', $data);
		}
	}


	################################### Export ##########################################
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
		$session = session();
		$html = view($view, $data);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf = new \Mpdf\Mpdf([
			'default_font' => 'tatsana',
			'default_font_size' => 10,
			'mode' => 'utf-8',
			'format' => 'A4',
			'margin_top' => 10,
			'margin_header' => 2, // 30mm not pixel
			'margin_footer' => 2, // 10mm
			'orientation' => $orientation, // L แนวนอน P แนวตั้งง

		]);
		if ($orientation == 'P') {
			$mpdf->SetWatermarkImage(base_url('public/img/watermark_P.png'), 1, array(3000, 3000));
		} else {
			$mpdf->SetWatermarkImage(base_url('public/img/watermark_L.png'), 1, array(3000, 3000));
		}
		$mpdf->showWatermarkImage = true;


		$footer = '<table width="100%" border=0 style="border:0px ">
                <tr border=0 style="border:0px ">
                  <td align="left" border=0 style="border:0px ">
                    <img src="' . base_url('public/img/logotat.png') . '">
                    
                  </td>
                  <td align="right" border=0 style="border:0px ">
                    Source of Data : Tourism Authority of Thailand <br>
                    As of : ' . date('d M Y H:i:s') . '<br>
                    '.$session->get('name').'
                  </td>
                </tr>
              </table>';
		$mpdf->SetFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

	function departure(){
		$Model = new Report_model();
		$data['session'] = session();
		$data['Mydate'] = $this->Mydate;
		$data['month_label'] = $this->month_en_short;
		$data['year'] = date('Y');
		$data['port_id'] = '';
		$data['port_type'] = array();
		// $data['port_type'] = @$_GET['port_type'];
		if (!empty($_GET['port_type'])) {
			$data['port_type'] = explode(',', $_GET['port_type']);
		}
		if (!empty($_GET['year'])) {
			$data['year'] = $_GET['year'];
		}
		// if (!empty($_GET['port_id'])) {
		// 	$data['port_id'] = $_GET['port_id'];
		// }

		// $data['port'] = $Model->getPortGroupType();
		$data['select_year'] = $Model->getSelectYear();
		$data['select_port'] = $Model->getSelectPortAll();
		$data['data'] = $Model->getDepartureDaily($data['year'],$data['port_type']);
		$data['export_type'] = @$_GET['export_type'];
		if (@$_GET['export_type'] == 'excel') {
			$this->export_excel('departure.xlsx', 'Modules\Report\Views\export\departure', $data);
		} else if (@$_GET['export_type'] == 'pdf') {
			$this->export_pdf('Modules\Report\Views\export\departure', $data,'L');
		} else {
			return view('Modules\Report\Views\departure', $data);
		}

	}
}
