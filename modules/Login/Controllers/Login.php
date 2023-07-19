<?php
namespace Modules\Login\Controllers;
use App\Controllers\BaseController;
use Modules\User\Models\User_model;
use Modules\Permission\Models\Permission_model;
use App\Libraries\Hash;

class Login extends BaseController{

  public function index(){
    if(session()->get('logged_in')){
      return redirect()->to('/main');
    }
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
          
          $C = explode(',', $userInfo['memberof'][1]);
          $C = explode('=', $C[0]);
          $C = $C[1];
          // echo 'C='.$C;
          // echo '<pre>';
          // print_r($userInfo);
          // exit;
          $userPermission = $this->getPermissionAD($userInfo['title'][0],$userInfo['samaccountname'][0],$C);

          // if(!empty($userInfo['samaccountname'][0])
          //    && ( $userInfo['title'][0]==410202 ||  $userInfo['title'][0]==420101 
          //         ||  $userInfo['title'][0]==200100 
          //         ||  $userInfo['title'][0]==300100 
          //         ||  $userInfo['title'][0]==400100 
          //         ||  $userInfo['title'][0]==500100
          //         ||  $userInfo['title'][0]==600100 
          //         ||  $userInfo['title'][0]==700100 
          //         ||  $userInfo['title'][0]==800100 
          //         ||  $userInfo['title'][0]==900100
          //         ||  $userInfo['title'][0]==310302
          //          ) 
          //   || $userInfo['samaccountname'][0] == 'sriwan.choo'
          //   || $userInfo['samaccountname'][0] == 'prakong.phan'
          //   || $userInfo['samaccountname'][0] == 'nitiya.supa'
          //   || $userInfo['samaccountname'][0] == 'phacharaporn.sawa'
          //   || $userInfo['samaccountname'][0] == 'panjaporn.siri'
          //   || $userInfo['samaccountname'][0] == 'titiwat.pati'

          //   || $userInfo['samaccountname'][0] == 'natchapol.phro'
          //   || $C == 'C9' || $C == 'C10' || $C == 'C11'
          //   ){
          if(!empty($userInfo['samaccountname'][0]) && $userPermission['DASHBOARD']){
              // $userPermission = array('DASHBOARD'=>1,'REPORT'=>1);
              // if( $userInfo['title'][0]==410202 ||  $userInfo['title'][0]==420101 ){
              //   $userPermission = array('DASHBOARD'=>1,'REPORT'=>1,'IMPORT'=>1,'SETTING'=>1);
              // }
              $userRole['REPORT'] = 'REPORT';
              $ses_data = [
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
    return redirect()->to('https://marketingdb.tat.or.th/web/guest/index');
  }

  public function tat(){
    $TatAuthUsr = $this->request->getVar('TatAuthUsr');
    $AuthUrl = $this->request->getVar('AuthUrl');

    

    $User_model = new User_model();
    $userInfo = $User_model
                ->where('USER_NAME', $TatAuthUsr)
                ->where('USER_ACTIVE_STATUS', 1)
                ->first();
    if(!empty($userInfo['USER_ID']) && $AuthUrl!=''){

      $userId = $userInfo['USER_ID'];
      if ($userInfo['USER_PHOTO_FILE'] != '') {
        $user_img = base_url('public/uploads/user/'.$userInfo['USER_PHOTO_FILE']);
      }else{
        $user_img = base_url('public/img/default-profile.jpeg');
      }
      $session = session();

      $Permission = new Permission_model();
      $userPermission = $Permission->getPermission($userInfo['USER_PERMISSION_TYPE'],$userInfo['USER_TYPE_ORG']);
      $userRole = $User_model->getRole($userInfo['USER_ID']);

      if($userInfo['USER_PERMISSION_TYPE']==3 && $userInfo['USER_TYPE_ORG']==1){
        $userInfo['USER_AREA_ID'] = $Permission->getAreaId($userInfo['USER_ORG_ID']);
        $userInfo['USER_REGION_ID'] = $Permission->getAreaRegionId($userInfo['USER_ORG_ID']);
      }

      if($userInfo['USER_TYPE_ORG']==2){
        $userInfo['USER_REGION_ID'] = $Permission->getRegionId($userInfo['USER_ORG_ID']);
      }

      $ses_data = [
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

      return redirect()->to($AuthUrl);
    }
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

}

 ?>
