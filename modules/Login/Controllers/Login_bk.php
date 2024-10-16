<?php
namespace Modules\Login\Controllers;
use App\Controllers\BaseController;
use Modules\User\Models\User_model;
use Modules\Main\Models\Main_model;
use Modules\Permission\Models\Permission_model;
use App\Libraries\Hash;

class Login extends BaseController{

  public function index(){
    // if(session()->get('logged_in')){
    //   return redirect()->to('/main');
    // }
    // return view('Modules\Login\Views\index.php');

    $AuthorizationHeader = $this->getAuthorizationHeader();

    if(isset($AuthorizationHeader)){
   
      $userPrincipalName = @$AuthorizationHeader->userPrincipalName;
      $userPrincipalName = explode('@tat', $userPrincipalName);
      $username = @$userPrincipalName[0];

      if($username){
        return $this->authHeader($username,$AuthorizationHeader);

      }else{
        return view('Modules\Login\Views\index.php');
      }
      
    }else{
      return view('Modules\Login\Views\index.php');
    }
  }

  function getAuthorizationHeader(){
      $headers = $token = $file = null;
      if (isset($_SERVER['Authorization'])) {
          $headers = trim($_SERVER["Authorization"]);
      }
      else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
          $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
      } elseif (function_exists('apache_request_headers')) {
          $requestHeaders = apache_request_headers();
          // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
          $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
          //print_r($requestHeaders);
          if (isset($requestHeaders['Authorization'])) {
              $headers = trim($requestHeaders['Authorization']);
          }
      }

      if (isset($_SERVER['Access-Token'])) {
          $token = trim($_SERVER["Access-Token"]);
      }elseif (function_exists('apache_request_headers')) {
          $requestHeaders = apache_request_headers();
          // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
          $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
          //print_r($requestHeaders);
          if (isset($requestHeaders['Access-Token'])) {
              $token = trim($requestHeaders['Access-Token']);
          }
      }

      if($token){
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Authorization: Bearer {$token}" 
            ]
        ];

        $context = stream_context_create($opts);
        $file = file_get_contents('https://graph.microsoft.com/v1.0/me/?$select=id,displayName,givenName,surname,department,userType,userPrincipalName,jobTitle,employeeId', false, $context);

      }
      
      return json_decode($file);
  }

  function page(){
    return view('Modules\Login\Views\index.php');
  }

  public function auth(){
    $session = session();

    $username = $this->request->getVar('user_name');
    $password = $this->request->getVar('password');

    $pastAuthUsr = $this->request->getVar('pastAuthUsr');
    $pastAuthPwd = $this->request->getVar('pastAuthPwd');
    if($pastAuthUsr){
        $username = $pastAuthUsr;
        $password = $pastAuthPwd;
    }


    if (function_exists('ldap_connect')) {
      if($this->loginAD($username,$password)){
          $url = $this->request->getVar('URL');
          if(empty($url)){
            $url = base_url();
          }
          return redirect()->to($url);
      }
    }

    return redirect()->to('welcome');
  }

  function auth2(){

    $session = session();

    $username = $this->request->getVar('user_name');
    $password = $this->request->getVar('password');

    $pastAuthUsr = $this->request->getVar('pastAuthUsr');
    $pastAuthPwd = $this->request->getVar('pastAuthPwd');
    if($pastAuthUsr){
        $username = $pastAuthUsr;
        $password = $pastAuthPwd;
    }

    $User_model = new User_model();
    $userInfo = $User_model
                ->where('USER_NAME', $username)
                ->where('USER_ACTIVE_STATUS', 1)
                ->first();

    // echo '<pre>'; print_r($userInfo); exit;
      if(empty($userInfo['USER_PASSWORD'])){
        
        session()->setFlashdata('error','Username หรือ Password ผิด กรุณากรอกใหม่');
        return redirect()->back()->withInput();
      }


      $checkPassword = Hash::check($password, $userInfo['USER_PASSWORD']);
      if(!$checkPassword)
      {
        session()->setFlashdata('error','Username หรือ Password ผิด กรุณากรอกใหม่');
        return redirect()->back()->withInput();
      }
      else
      {

        $userId = $userInfo['USER_ID'];
        if ($userInfo['USER_PHOTO_FILE'] != '') {
          $user_img = base_url('public/uploads/user/'.$userInfo['USER_PHOTO_FILE']);
        }else{
          $user_img = base_url('public/img/default-profile.jpeg');
        }
        $session = session();
        $userRole = array();

        $userPermission = array('DASHBOARD'=>1,'REPORT'=>1,'IMPORT'=>1,'SETTING'=>1);
        $ses_data = [
        'user_id' => $userInfo['USER_ID'],
        'org_id' => $userInfo['USER_ORG_ID'],
        'username' => $userInfo['USER_NAME'],
        'name' =>  $userInfo['USER_NAME_TH'],
        'user_type' => $userInfo['USER_TYPE_ORG'],
        'user_permission_type'=>$userInfo['USER_PERMISSION_TYPE'],
        'user_area_id' => $userInfo['USER_AREA_ID'],
        'user_region_id' => $userInfo['USER_REGION_ID'],
        'user_img' => $user_img,
        'user_menu' => $userPermission,
        'user_role' => $userRole,
        'logged_in' => TRUE
        ];
        $session->set($ses_data);

        $Main = new Main_model();
        $ip = $this->request->getIPAddress();
        $Main->saveLogLogin('REPORT',$ip,$session);

        $redirect_url = $session->get('redirect_url');
        if($redirect_url){
          return redirect()->to($redirect_url);
        }
        return redirect()->to('/main');
      }
  }

  function loginAD($username='',$pass=''){
    // return false;
    $session = session();
    $response = '';
    $server   = "pdc2012.tat.or.th";
    $user     = $username."@tat.or.th";
    $dn = 'DC=tat,DC=or,DC=th';

    $ad = @ldap_connect($server);

    if(!$ad) {
      $server =" adc2012.tat.or.th";
      $ad = @ldap_connect($server);
    }

    if(!$ad) {
      $msg = "Can not connect server";
      $response = false;

    }else {
      $b = @ldap_bind($ad,$user,$pass);
      if(!$b) {
        $msg = "Login false";
        $response = false;
      }else{
          $userInfo = $this->get_entry_system_attrs($username,$ad,$dn);
          // echo '<pre>'; print_r($userInfo); exit();
          
          $C = explode(',', $userInfo['memberof'][1]);
          $C = explode('=', $C[0]);
          $C = $C[1];
          
          $userPermission = $this->getPermissionAD($userInfo['title'][0],$userInfo['samaccountname'][0],$C);

          if(!empty($userInfo['samaccountname'][0]) && $userPermission['DASHBOARD']  || ( $C == 'C9' || $C == 'C10' || $C == 'C11') ){
              if( $C == 'C9' || $C == 'C10' || $C == 'C11' ){
                $userPermission = array('DASHBOARD'=>1,'REPORT'=>1);
              }
              $userRole['REPORT'] = 'REPORT';
              $ses_data = [
              'user_id' => $userInfo['title'][0],
              'org_id' => substr($userInfo['title'][0], 0, -2).'00',
              'username' => $userInfo['samaccountname'][0],
              'name' =>  $userInfo['cn'][0],
              'user_type' => 3,
              'user_permission_type'=>1,
              'user_area_id' => 0,
              'user_region_id' => 0,
              'user_img' => '',
              'user_menu' => $userPermission,
              'user_role' => $userRole,
              'logged_in' => TRUE
              ];
              $session->set($ses_data);



              $Main = new Main_model();
              $ip = $this->request->getIPAddress();
              // echo '<pre>';
              // echo 'ip '.$ip;
              // print_r($ses_data);
              // print_r($session); exit;

              $Main->saveLogLogin('REPORT',$ip,$session);

              $msg = "Login success";
              $response = true;
          }else{
            $response = false;
          }
      }

    }


    return $response;

  }

  function get_entry_system_attrs($username,$ldap_connection, $ldap_base_dn, $deref=LDAP_DEREF_NEVER )
  {
    $atts_data = array();
    $search_filter = "(&(sAMAccountName=".$username."))";
    $result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter);
    if (FALSE !== $result){
        $entries = ldap_get_entries($ldap_connection, $result);
        if ($entries['count'] > 0){
            $odd = 0;
            foreach ($entries[0] AS $key => $value){
                if (0 === $odd%2){
                    $ldap_columns[] = $key;
                }
                $odd++;
            }
            
            $header_count = 0;
           
            for ($i = 0; $i < $entries['count']; $i++){
               
                $td_count = 0;
                foreach ($ldap_columns AS $col_name){
                    
                    if (isset($entries[$i][$col_name])){
                        $output = NULL;
                        if ('lastlogon' === $col_name || 'lastlogontimestamp' === $col_name){
                            $output = date('D M d, Y @ H:i:s', ($entries[$i][$col_name][0] / 10000000) - 11676009600); // See note below
                        }else{
                            @$output = $entries[$i][$col_name];
                        }
                        

                        $atts_data[$col_name] = $output;
                    }
                }
               
            }
           
        }
    }
    ldap_unbind($ldap_connection);
    return $atts_data;
  }

  public function logout(){
    $session = session();
    $session->destroy();
    // return redirect()->to('/');
    // return redirect()->to('https://marketingdb.tat.or.th/web/guest/index');
    return redirect()->to('https://time-auth.tat.or.th/oauth2/sign_out?rd=https%3A%2F%2Flogin.windows.net%2F8d7435c8-c945- 4942-80bf-c883fc3e4187%2Foauth2%2Flogout%3Fpost_logout_redirect_uri%3Dhttps%3A%2F%2Ftime-dashboard.tat.or.th');
  }


  public function welcome(){
    $session = session();
    $session->destroy();
    
    return view('Modules\Login\Views\welcome.php');
  }

  function getPermissionAD($group_id,$username,$c){
    $User_model = new User_model();
    $userPermission = $User_model->getPermissionAD($group_id,$username,$c);
    return $userPermission;
  }

  public function authHeader($username,$AuthorizationHeader)
  {
    $session = session();

    $User_model = new User_model();
    $userInfo = $User_model
      ->where('USER_NAME', $username)
      ->where('USER_ACTIVE_STATUS', 1)
      ->first();

    if ($userInfo ) {

      $userId = $userInfo['USER_ID'];
      if ($userInfo['USER_PHOTO_FILE'] != '') {
        $user_img = base_url('public/uploads/user/'.$userInfo['USER_PHOTO_FILE']);
      }else{
        $user_img = base_url('public/img/default-profile.jpeg');
      }
      $session = session();
      $userRole = array();

      $userPermission = array('DASHBOARD'=>1,'REPORT'=>1,'IMPORT'=>1,'SETTING'=>1);

      $ses_data = [
      'user_id' => $userInfo['USER_ID'],
      'org_id' => $userInfo['USER_ORG_ID'],
      'username' => $userInfo['USER_NAME'],
      'name' =>  $userInfo['USER_NAME_TH'],
      'user_type' => $userInfo['USER_TYPE_ORG'],
      'user_permission_type'=>$userInfo['USER_PERMISSION_TYPE'],
      'user_area_id' => $userInfo['USER_AREA_ID'],
      'user_region_id' => $userInfo['USER_REGION_ID'],
      'user_img' => $user_img,
      'user_menu' => $userPermission,
      'user_role' => $userRole,
      'logged_in' => TRUE
      ];
      $session->set($ses_data);

      $Main = new Main_model();
      $ip = $this->request->getIPAddress();
      $Main->saveLogLogin('REPORT',$ip,$session);

      $url = $this->request->getVar('URL');
      if (empty($url)) {
        $url = base_url();
        $redirect_url = $session->get('redirect_url');
        if ($redirect_url) {
          return redirect()->to($redirect_url);
        }
      } else {
        return redirect()->to($url);
      }

      return redirect()->to('/main');
    }else{
      $C = null;
      $userInfo['title'][0] = $AuthorizationHeader->jobTitle;
      $userInfo['samaccountname'][0] = $username;
      $employeeId = $AuthorizationHeader->jobTitle;

      $userPermission = $this->getPermissionAD($userInfo['title'][0],$userInfo['samaccountname'][0],$C);
      if($userPermission){
        
        $userRole['REPORT'] = 'REPORT';
        $ses_data = [
        'user_id' => $employeeId,
        'org_id' => substr($userInfo['title'][0], 0, -2).'00',
        'username' => $userInfo['samaccountname'][0],
        'name' =>  $AuthorizationHeader->displayName,
        'user_type' => 3,
        'user_permission_type'=>1,
        'user_area_id' => 0,
        'user_region_id' => 0,
        'user_img' => '',
        'user_menu' => $userPermission,
        'user_role' => $userRole,
        'logged_in' => TRUE
        ];
        $session->set($ses_data);

        $Main = new Main_model();
        $ip = $this->request->getIPAddress();

        $Main->saveLogLogin('REPORT',$ip,$session);
        return redirect()->to('/main');
      }else{
        return view('Modules\Login\Views\index.php');
      }

      // return view('Modules\Login\Views\index.php');
    }
  }

}

 ?>
