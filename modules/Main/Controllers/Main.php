<?php

namespace Modules\Main\Controllers;
use App\Controllers\BaseController;
use Modules\Main\Models\Main_model;
use Modules\Report\Models\Report_model;

class Main extends BaseController{

	public function index(){
		$Model = new Main_model();
		$Report_model = new Report_model();
		$data['session'] = session();
		$data['Mydate'] = $this->Mydate;
		// $date = date('Y-m-d');
		$month = date('m');

		$data['year'] = date('Y');
		$data['month'] = $month;
		$data['month_label'] = $this->month_th_short[(int)$month];
		$data['start_date'] = '01-01-'.date('Y');
		// $data['end_date'] = date('d-m-Y');
		$data['country_type'] = 'all';
		
		$end_date = $Model->getMaxDate();
		list($year, $month, $day) = explode('-', $end_date);
		$data['end_date'] = $day.'-'.$month.'-'.$year;

		if(!empty($_GET['start_date'])){
			$data['start_date'] = $_GET['start_date'];
			
		}
		if(!empty($_GET['end_date'])){
			$data['end_date'] = $_GET['end_date'];
		}

		list($day, $month, $year) = explode('-', $data['start_date']);
			$start_date = $year.'-'.$month.'-'.$day;
			$data['start_date_label'] = $start_date;
			
		list($day, $month, $year) = explode('-', $data['end_date']);
			$end_date = $year.'-'.$month.'-'.$day;
			$data['end_date_label'] = $end_date;

		

		$data['to_date'] = $end_date;
		$prev_date = date('Y-m-d', strtotime($end_date .' -15 day'));
		$data['period'] = $data['Mydate']->date_range($prev_date,$end_date);

		$data['SumDateData'] = $Model->getSumDate($end_date);
		$data['SumMonthData'] = $Model->getSumMonth($start_date,$end_date);

		$data['SumNatDateData'] = $Model->getSumNatDate($end_date);
		$data['SumNatMonthData'] = $Model->getSumNatMonth($start_date,$end_date);
		$data['SumPortDateData'] = $Model->getSumPortDate($end_date);
		$data['SumPortMonthData'] = $Model->getSumPortMonth($start_date,$end_date);

		$data['SumRegionDateData'] = $Model->getSumRegionDate($end_date);
		$data['SumRegionMonthData'] = $Model->getSumRegionMonth($start_date,$end_date);
		$data['SumCountryDateData'] = $Model->getSumCountryDate($end_date);
		$data['SumCountryMonthData'] = $Model->getSumCountryMonth($start_date,$end_date);

		$data['region'] = $Report_model->getSTDRegion('standard');
		$data['sub_region'] = $Model->getSubRegion();
		$data['country_region'] = $Report_model->getCountryByRegion('standard');

		$data['SumChartData'] = $Model->getSumChart($end_date);
		$data['api_code'] = $this->Api_Code;
		return view("Modules\Main\Views\index",$data);
	}
	
	function update_country(){
		$Model = new Main_model();
		$Model->update_country();
	}


	
}

?>
