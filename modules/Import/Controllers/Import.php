<?php

namespace Modules\Import\Controllers;

use Modules\Import\Models\Import_model;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\SimpleXLSX;
use App\Libraries\Mydate;
use Modules\Main\Models\Main_model;

class Import extends BaseController
{

	use ResponseTrait;

	public function index()
	{
		$data = array();
		$Model = new Import_model();
		$Main_model = new Main_model();

		$this->Mydate = new Mydate();
		$data['Mydate'] = $this->Mydate;
		$data['date'] = $Main_model->getMaxDate();
		if (!empty($_GET['d'])) {
			$data['date'] = $_GET['d'];
		}

		list($year, $month, $day) = explode('-', $data['date']);
		$data['to_date_label'] = $day . '/' . $month . '/' . $year;

		$data['data'] = $Model->getRawData($data['date']);


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
			$data['text'] = $Model->import_file($input, $xlsx);
		}

		return view('Modules\Import\Views\detail', $data);
	}
}
