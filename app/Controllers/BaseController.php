<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\Template;
use App\Libraries\Date_thai;
use App\Libraries\Mydate;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];
	protected $Api_Code = 'AIzaSyDou8McmYTeSRhLyioyyfIuLvQX-sdK82o'; 
	protected $month_th = array( 1=>"มกราคม", 2=>"กุมภาพันธ์", 3=>"มีนาคม", 4=>"เมษายน", 5=>"พฤษภาคม", 6=>"มิถุนายน", 7=>"กรกฎาคม", 8=>"สิงหาคม", 9=>"กันยายน", 10=>"ตุลาคม", 11=>"พฤศจิกายน", 12=>"ธันวาคม");
	protected $month_th_short = array( 1=>"ม.ค.", 2=>"ก.พ.", 3=>"มี.ค.", 4=>"เม.ย.", 5=>"พ.ค.", 6=>"มิ.ย.", 7=>"ก.ค.", 8=>"ส.ค.", 9=>"ก.ย.", 10=>"ต.ค.", 11=>"พ.ย.", 12=>"ธ.ค.");
	protected $month_en = array( 1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');
	protected $month_en_short = array(1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec');
	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		$this->Date_thai = new Date_thai();
		$this->Mydate = new Mydate();
		$session = session();
		$router = service('router');
		$controller  = $router->controllerName();
		if($controller != '\Modules\Language\Controllers\Language' && $controller != '\Modules\Login\Controllers\Login'){
			$ses_data['redirect_url'] = current_url();
			$session->set($ses_data);
		}
		
		$session = \Config\Services::session();
		$language = \Config\Services::language();
		$language->setLocale($session->lang);
	}
}
