<?php
namespace Modules\User\Models;
use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Mydate;
use App\Libraries\Hash;
class User_model extends Model
{
  protected $table = 'TAT.USERS';
  protected $primaryKey = 'USER_ID';
  protected $allowedFields = [];

  function getUserType(){
    $builder = $this->db->table('MD_USER_TYPE');
    $builder->select('*');
    $builder->where('STATUS_DATA',1);
    $data = $builder->get()->getResultArray();
    return $data;
  }

  function getUserRole(){
    $builder = $this->db->table('MD_USER_ROLE');
    $builder->select('*');
    $builder->where('STATUS_DATA',1);
    $data = $builder->get()->getResultArray();
    return $data;
  }

 public function saveUser($input,$randomname)
  {
    $builder = $this->db->table('TAT.USERS');
    $builder->set('USER_NAME', $input['USER_NAME']);
    if($input['USER_PASSWORD']){
      $builder->set('USER_PASSWORD',Hash::encrypt($input['USER_PASSWORD']));
    }
    
    // $builder->set('USER_FIRSTNAME', $input['USER_FIRSTNAME']);
    // $builder->set('USER_LASTNAME', $input['USER_LASTNAME']);
    $builder->set('USER_ORG_ID', $input['USER_ORG_ID']);
    $builder->set('USER_TYPE_ORG', $input['USER_TYPE_ORG']);
    // $builder->set('USER_TEL_NO', $input['USER_TEL_NO']);
    // $builder->set('USER_EMAIL_ADDR', $input['USER_EMAIL_ADDR']);
    if($randomname){
      $builder->set('USER_PHOTO_FILE', $randomname);  
    }
    
    $builder->set('USER_PERMISSION_TYPE', $input['USER_PERMISSION_TYPE']);

    if ($input['USER_ACTIVE_STATUS'] == ''){ // ระงับ
      $builder->set('USER_ACTIVE_STATUS', 2);
    }else{
      $builder->set('USER_ACTIVE_STATUS', $input['USER_ACTIVE_STATUS']);
    }

    if($input['USER_TYPE_ORG']==1){ ### หน่วยงานภายในประเทศ
      $builder_org = $this->db->table('TAT.MD_DEPARTMENT');
      $builder_org->where('DEPARTMENT_ID',$input['USER_ORG_ID']);
      $row_org = $builder_org->get()->getRowArray();

      $builder->set('USER_AREA_ID', $row_org['DEPARTMENT_PROVINCE']);
      $builder->set('USER_REGION_ID', $row_org['DEPARTMENT_REGION']);
    }else if($input['USER_TYPE_ORG']==2){
      $builder_org = $this->db->table('TAT.MD_DEP_REGION');
      $builder_org->where('DEP_REGION_ID',$input['USER_ORG_ID']);
      $row_org = $builder_org->get()->getRowArray();

      $builder->set('USER_REGION_ID', $row_org['REGION_DATA_ID']);
    }

    if (empty($input['USER_ID'])) {
      $db = db_connect('default'); 
      // $USER_ID = $this->genUserID();
      // $builder->set('USER_ID', $USER_ID);
      $builder->insert();
      $USER_ID = $db->insertID();
    } else {
      $USER_ID = $input['USER_ID'];
      $builder->where('USER_ID', $input['USER_ID']);
      $builder->update();
    }

    if(!empty($input['USER_ROLE_TYPE'])){
      $builder_del_role = $this->db->table('TAT.USERS_ROLES');
      $builder_del_role->where('USER_ID', $USER_ID);
      $builder_del_role->delete();

      foreach ($input['USER_ROLE_TYPE'] as $key => $role) {
        $builder_role = $this->db->table('TAT.USERS_ROLES');
        $builder_role->set('USER_ID', $USER_ID);
        $builder_role->set('ROLE_ID', $role);
        $builder_role->insert();
      }
    }

    return $USER_ID;
  }
  public function deleteUser($id){
    $builder = $this->db->table('TAT.USERS');
    $builder->where('USER_ID', $id);
    $builder->set('USER_ACTIVE_STATUS', 0);
    $builder->update();
  }
  public function genUserID()
  {
    $builder = $this->db->table('DUAL');
        $builder->select("USERS_SEQ.NEXTVAL as ID", false);
        $query = $builder->get();
        $row = $query->getRowArray();
        return $row['ID'];
  }

  public function getAllUsers($id = '')
  {

    $data = array();
    $builder = $this->db->table('TAT.USERS');

    $builder->select("TAT.USERS.*,TAT.MD_DEP_REGION.DEP_REGION_ID,TAT.MD_DEP_REGION.DEP_REGION_TH,TAT.MD_DEPARTMENT.DEPARTMENT_ID,TAT.MD_DEPARTMENT.DEPARTMENT_NAME_TH,MD_USER_TYPE.USER_TYPE_NAME");
    $builder->join('TAT.MD_DEP_REGION', 'TAT.MD_DEP_REGION.DEP_REGION_ID = TAT.USERS.USER_ORG_ID', 'left');
    $builder->join('TAT.MD_DEPARTMENT', 'TAT.MD_DEPARTMENT.DEPARTMENT_ID = TAT.USERS.USER_ORG_ID', 'left');
    $builder->join('TAT.MD_USER_TYPE', 'TAT.MD_USER_TYPE.USER_TYPE_ID = TAT.USERS.USER_PERMISSION_TYPE', 'left');
    $builder->where('TAT.USERS.USER_ACTIVE_STATUS != 0');
//     $sql = $builder->getCompiledSelect();
// echo $sql;
// die();
    if ($id) {
      $builder->where('TAT.USERS.USER_ID', $id);
      $data = $builder->get()->getRowArray();
      return $data;
    }

    $data = $builder->get()->getResultArray();
    return $data;
  }

  function getRole($id){
    $data = array();
    $builder = $this->db->table('TAT.USERS_ROLES');
    $builder->select('*');
    $builder->where('USER_ID',$id);
    $query = $builder->get()->getResultArray();
    foreach ($query as $key => $value) {
      $data[$value['ROLE_ID']] = $value['ROLE_ID'];
    }
    return $data;
  }
  
  public function getOrgRegion()
  {
    $data = array();
    $builder = $this->db->table('TAT.MD_DEP_REGION');
    $builder->select('*');
    
    $query = $builder->get()->getResultArray();
    $data = $query;
    return $data;
  }

  public function getOrgTAT()
  {
      $data = array();
      $builder = $this->db->table('TAT.MD_DEPARTMENT');
      $builder->select('*');
      $builder->where('DEPARTMENT_REGION',0);
      $query = $builder->get()->getResultArray();
      $data = $query;
      return $data;
  }

  public function getOrgDepartment()
  {
      $data = array();
      $builder = $this->db->table('TAT.MD_DEPARTMENT');
      $builder->select('*');
      $builder->where('DEPARTMENT_REGION <>',0);
      $query = $builder->get()->getResultArray();
      $data = $query;
      return $data;
  }

  public function getUserGroupOrg()
  {
    $builder = $this->db->table('users');
    $builder->select('*');
    $query = $builder->get()->getResultArray();
    foreach ($query as $key => $value) {
      $data[$value['org_id']][$value['user_id']] = $value;
    }
    return $data;
  }

  public function getTreeOrg($parent=0,&$data=array())
  {
    $builder = $this->db->table('organizations');
    $builder->select('*');
    $builder->where('org_parent',$parent);
    $query = $builder->get()->getResultArray();
    foreach ($query as $key => $value) {
      $data[$value['org_parent']][$value['org_id']] = $value;
      $this->getTreeOrg($value['org_id'],$data);
    }
    return $data;
  }


  public function user_update($input,$images)
  {
    $builder = $this->db->table('users');
    $builder->set('username',$input['username']);
    if (!empty($input['password'])) {
      $builder->set('password',password_hash($input['password'],PASSWORD_DEFAULT));
    }
    $builder->set('org_id',$input['user_org_id']);
    $builder->set('first_name',$input['first_name']);
    $builder->set('last_name',$input['last_name']);
    $builder->set('email',$input['email']);
    $builder->set('phone',str_replace('-', '',$input['phone']));
    $builder->set('status',$input['status']);
    $builder->set('user_type',2);

    if (!empty($images->getName())) {
      $new_img = $images->getRandomName();
      $images->move(ROOTPATH.'public/uploads/user/', $new_img);
      $builder->set('user_img',$new_img);
    }

    if (!empty($input['user_id'])) {
      $builder->where('user_id',$input['user_id']);
      $builder->update();
    } else {
      $builder->insert();
    }

  }

  public function get_user($user_id)
  {
    $builder = $this->db->table('users');
    $builder->select('*');
    $builder->where('user_id',$user_id);
    $query = $builder->get();
    return $query->getRowArray();
  }

  public function check_username($user_id,$user_name)
  {
    if (!empty($user_id)) {
      $builder = $this->db->table('users');
      $builder->select('*');
      $builder->where('user_id',$user_id);
      $builder->where('username',$user_name);
      $result = $builder->countAllResults();

      if ($result == 0) {
        $builder = $this->db->table('users');
        $builder->select('*');
        $builder->where('username',$user_name);
        return $builder->countAllResults();
      }
    } else {
      $builder = $this->db->table('users');
      $builder->select('*');
      $builder->where('username',$user_name);
      return $builder->countAllResults();
    }
  }


  // public function delete_user($id)
  // {
  //   $builder = $this->db->table('users');
  //   $builder->where('user_id',$id);
  //   $builder->delete();
  // }

  public function update_org($input){
    $builder = $this->db->table('organizations');
    $data = [
        'org_name' => $input['org_name'],
        'org_parent'    => $input['org_parent'],
        'org_name_short' => $input['org_name_short']
      ];

    if ($input['org_id'] != '') {
        $builder->where('org_id',$input['org_id']);
        $builder->update($data);
    } else {
        $builder->insert($data);
    }

  }

  public function delete_org($org_id){
    $builder_detail = $this->db->table('organizations');
    $builder_detail->where('org_id',$org_id);
    $builder_detail->delete();

  }

  public function getMainOrgForSelect(){
    $builder = $this->db->table('organizations');
    $builder->select('*');
    $builder->where('org_parent',0);
    $builder->orderBy('org_name');
    $res = $builder->get()->getResultArray();
    return $res;
  }

  public function getOrgForSelect(){
    $builder = $this->db->table('organizations');
    $builder->select('*');
    $builder->where('org_parent <>',0);
    $builder->orderBy('org_name');
    $res = $builder->get()->getResultArray();
    return $res;
  }

  public function getOrgData($org_id){
    $builder = $this->db->table('organizations');
    $builder->select('*');
    $builder->where('org_id',$org_id);
    $res = $builder->get()->getRowArray();
    return $res;
  }

  function genNewUser(){
    // $builder = $this->db->table('TAT.TAT_USER_TEMP');
    // $builder->select('*');
    // $builder->where('IS_DEP_RPT5','Y');
    // $query = $builder->get()->getResultArray();
    // foreach ($query as $key => $value) {
    //     // $builder = $this->db->table('TAT.USERS');
    //     // $builder->set('USER_NAME',$value['USER_USERNAME']);
    //     // $builder->set('USER_PASSWORD',password_hash($value['USER_PASSWORD'],PASSWORD_DEFAULT));
    //     // $builder->set('USER_NAME_TH',$value['USER_NAME_TH']);
    //     // $builder->set('USER_NAME_EN',$value['USER_NAME_EN']);
    //     // $builder->insert();
    // }

    // $builder_del = $this->db->table('TAT.USERS_ROLES');
    // $builder_del->where('USER_ID <>',0);
    // $builder_del->delete();

    // $builder_user = $this->db->table('TAT.USERS');
    // $builder_user->select('*');
    // $query = $builder_user->get()->getResultArray();
    // foreach ($query as $key => $value) {
    //     $builder = $this->db->table('TAT.USERS_ROLES');
    //     $builder->set('USER_ID',$value['USER_ID']);
    //     $builder->set('ROLE_ID','ADD');
    //     $builder->insert();

    //     $builder = $this->db->table('TAT.USERS_ROLES');
    //     $builder->set('USER_ID',$value['USER_ID']);
    //     $builder->set('ROLE_ID','EDIT');
    //     $builder->insert();

    //     $builder = $this->db->table('TAT.USERS_ROLES');
    //     $builder->set('USER_ID',$value['USER_ID']);
    //     $builder->set('ROLE_ID','DELETE');
    //     $builder->insert();

    //     $builder = $this->db->table('TAT.USERS_ROLES');
    //     $builder->set('USER_ID',$value['USER_ID']);
    //     $builder->set('ROLE_ID','REPORT');
    //     $builder->insert();
    // }
  }

  function genNewPassword(){
    $builder = $this->db->table('TAT.TAT_USER_TEMP');
    $builder->select('*');
    $query = $builder->get()->getResultArray();
    foreach ($query as $key => $value) {
        $builder_update = $this->db->table('TAT.USERS');
        $builder_update->set('USER_PASSWORD',password_hash($value['USER_PASSWORD'],PASSWORD_DEFAULT));
        $builder_update->where('USER_NAME',$value['USER_USERNAME']);
        $builder_update->update();

        echo $value['USER_USERNAME'].' '.password_hash($value['USER_PASSWORD'],PASSWORD_DEFAULT).'<br>';
    }
  }

  function getPermissionAD($group_id,$username,$C){
    $userPermission = array();
    $builder = $this->db->table('TAT.REPORT_PERMISSION_GROUP');
    $builder->select('*');
    $builder->where('GROUP_ID',$group_id);
    $row = $builder->get()->getRowArray();
    if(!empty($row)){
      return $row;
    }else{
      if($username){
        $builder = $this->db->table('TAT.REPORT_PERMISSION_USER');
        $builder->select('*');
        $builder->where('USERNAME',$username);
        $row = $builder->get()->getRowArray();
        if(!empty($row)){
          return $row;
        }
      }
      
    }

    // if($C == 'C9' || $C == 'C10' || $C == 'C11'){
    $userPermission = array('DASHBOARD'=>1,'REPORT'=>1);
    // }

    return $userPermission;
  }


}

 ?>
