<?php namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class Auth implements FilterInterface{

	public function before(RequestInterface $request, $arguments = null){
		// if user not logged in
		if(!session()->get('logged_in')){
		// then redirct to login page
			$session = session();
			$ses_data['redirect_url'] = current_url();
			$session->set($ses_data);

		// return redirect()->to('/login');
		return redirect()->to('https://marketingdb.tat.or.th/web/guest/index');
		}
	}

	//--------------------------------------------------------------------
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
	// Do something here
	}
}
?>
