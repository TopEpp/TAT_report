<?php
namespace Modules\User\Controllers;
use App\Controllers\BaseController;
use Modules\User\Models\User_model;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Hash;
class User extends BaseController
{

  protected $template;
  use ResponseTrait;

  public function index()
  {
    $User = new User_model();
    $data['session'] = session();
    $data['data'] = $User->getAllUsers();

    return view("Modules\User\Views\index",$data);
  }

  public function manage($id = '')
  {
    $User = new User_model();
    $data['session'] = session();
    $data['user_type'] = $User->getUserType();
    $data['user_role'] = $User->getUserRole();
    $data['dep_region'] = $User->getOrgRegion();
    $data['dep_center'] = $User->getOrgTAT();
		$data['department'] = $User->getOrgDepartment();
    $data['data'] = $User->getAllUsers($id);
    $data['data_role'] = $User->getRole($id);
    return view('Modules\User\Views\manage',$data);
  }
  public function user_save()
  {
    $User_model = new User_model();
    $file=$this->request->getFile('USER_PHOTO_FILE');
    $randomname = '';
    if($file->isValid())
      {
        $randomname = $file->getRandomName();
        $file->move('./public/uploads/user',$randomname);
      }
    $input = $this->request->getPost();
    $ID = $User_model->saveUser($input,$randomname);
    return redirect('user');
  }
  public function user_delete($id){
    $session = session();
    $User_model = new User_model();
    $input = $User_model->deleteUser($id);
  }


  public function user_update()
  {
    $User = new User_model();
    $input = $this->request->getVar();
    $images = $this->request->getFile('user_img');
    $User->user_update($input,$images);
    return true;
  }

  public function getDataTree(){
    $User = new User_model();
    $data_user = $User->getUserGroupOrg();
    $data_org = $User->getTreeOrg();

    $data =  $this->genDataTree($data_org,$data_user);
    return $this->setResponseFormat('json')->respond($data);
  }

  public function genDataTree($org,$user,$parent=0){
    $data = array();
    if(!empty($org[$parent])){
      foreach($org[$parent] as $key => $o) {
        $children = $this->genDataTree($org,$user,$o['org_id']);

        if(!empty($user[$o['org_id']])){
          $children = $this->genUser($user[$o['org_id']]);
        }

        if($parent==0){
          $is_level = 'org_root';
        }else{
          $is_level = 'org';
        }

        $data[] = array('id' => "org-".$o['org_id'], 'text' => "{$o['org_name']}", 'data' => $o, 'children' => $children, 'is_level'=>$is_level, 'level' => $o['org_parent'] );

      }
    }
    return $data;
  }

  public function genUser($user,$tr=''){
    foreach($user as $key => $u) {
        $is_level = 'user';
        $data[] = array('id' => "user-".$u['user_id'], 'text' => $u['first_name'].' '.$u['last_name'], 'data' => $u, 'is_level'=>$is_level, 'level' => $u['org_id'] );
    }

    return $data;
  }

  public function update_org()
  {
    $User = new User_model();
    $data = $this->request->getVar();
    $User->update_org($data);
    return true;
  }

  public function delete_org($id){
    $User = new User_model();
    $User->delete_org($id);
    return true;
  }

  public function get_user()
  {
    $User = new User_model();
    $user_id = $this->request->getVar('user_id');
    $data = $User->get_user($user_id);
    echo json_encode($data);
  }

  public function check_username()
  {
    $User = new User_model();
    $user_id = $this->request->getVar('user_id');
    $user_name = $this->request->getVar('username');
    $data = $User->check_username($user_id,$user_name);
    echo json_encode($data);
  }

  public function delete_user($id = '')
  {
    $User = new User_model();
    $User->delete_user($id);
    return redirect()->to('/user');
  }

  public function genNewUser(){
    $User = new User_model();
    $data = $User->genNewUser();
  }

  public function genNewPassword(){
    $User = new User_model();
    $data = $User->genNewPassword();
  }
}

 ?>
