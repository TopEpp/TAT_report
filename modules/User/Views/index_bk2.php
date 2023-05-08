<?php $session = session(); ?>
<?php $this->extend('templates/main') ?>
<?php $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <h5 class="h5 mb-0 text-gray-800">จัดการหน่วยงาน / ผู้ใช้งาน</h5>
        </div>
        <div class="col-md-6" align="right">
          <button class="btn btn-orange" onclick="addOrg(0,0)">เพิ่มกระทรวง</button>
        </div>
      </div>
      <br>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover  tree " width="100%" cellspacing="0">
                <thead style="background-color: #E5E5E5;border:1px solid #e3e6f0;">
                    <tr>
                        <th class="text-left">กระทรวง / หน่วยงาน / ผู้ใช้งาน</th>
                        <th class="text-center" width="10%">เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                  <?php echo genOrg($org,$user,0);?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 


function genOrg($org,$user,$parent=0,&$tr=''){
  if(!empty($org[$parent])){
    foreach($org[$parent] as $key => $o) {
        $class_parent ='';
        if($parent!=0){
          $class_parent = 'treegrid-parent-'.$parent;
          $addOrgBtn = '<button onclick="addUser('.$o['org_id'].')"  class="btn btn-primary btn-sm edit-org" ><i class="fas fa-plus"></i> </button>';
        }else{
          $addOrgBtn = '<button onclick="addOrg('.$o['org_id'].',0)" id="'.$o['org_id'].'" class="btn btn-primary btn-sm edit-org" ><i class="fas fa-plus"></i> </button>';
        }
        $tr .= '<tr class="treegrid-'.$o['org_id'].' '.$class_parent.' " >
                <td>'.$o['org_name'].'</td>
                <td class="text-right">
                  <input type="hidden" name="data_org_name'.$o['org_id'].'" id="data_org_name'.$o['org_id'].'" value="'.$o['org_name'].'">
                  '.$addOrgBtn.'
                  <button onclick="editOrg('.$o['org_parent'].','.$o['org_id'].')" id="'.$o['org_id'].'" class="btn btn-primary btn-sm edit-org" ><i class="fas fa-edit"></i> </button>
                  <button onclick="delOrg('.$o['org_id'].')" class="btn btn-primary btn-sm"><i class="fas fa-trash-alt"></i></button>
                </td>
               </tr>';

        if(!empty($user[$o['org_id']])){
          $tr .= genUser($user[$o['org_id']]);
        }
        
        genOrg($org,$user,$o['org_id'],$tr);
    }
  }
  

  return $tr;
}

function genUser($user,$tr=''){
  foreach($user as $key => $u) {
      
      $class_parent = 'treegrid-parent-'.$u['org_id'];
      
      $tr .= '<tr class="treegrid-u'.$u['user_id'].' '.$class_parent.' " >
              <td>'.$u['first_name'].' '.$u['last_name'].'</td>
              <td class="text-right">
                <button id="'.$u['user_id'].'" class="btn btn-primary btn-sm edit-profile" data-toggle="modal" data-target="#user_profile"><i class="fas fa-edit"></i> </button>
                <button onclick="UserDel('.$u['user_id'].')" class="btn btn-primary btn-sm"><i class="fas fa-trash-alt"></i></button>
              </td>
             </tr>';

  }

  return $tr;
}

?>

<div class="modal fade" id="user_profile" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <form class="" action="<?php echo base_url('/user/user_update/'); ?>" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">จัดการผู้ใช้งาน</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="form-group row">
            <div class="col-md-12" align="center">
              <img id="output" src="<?php echo base_url('public/uploads/user/images.png'); ?>" width="250px" height="200px"  style="margin-bottom: 10px;"/>
            </div>
            <div class="col-md-12">
              <div class="custom-file">
                <input type="file" name="user_img" class="custom-file-input" id="customFile" accept="image/*" onchange="loadFile(event)" >
                <label class="custom-file-label" for="customFile">เลือกไฟล์</label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">ชื่อผู้ใช้งาน</label>
            <input type="text" class="form-control username" id="user_name" name="user_name"  placeholder="ชื่อผู้ใช้งาน">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">รหัสผ่าน</label>
            <input type="password" class="form-control" id="password" name="password"  placeholder="รหัสผ่าน">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">ชื่อ-นามสกุล</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อ-นามสกุล">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">อีเมลล์</label>
            <input type="text" class="form-control emails" id="email" name="email" placeholder="อีเมลล์">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">เบอร์โทรศัพท์</label>
            <input type="text" class="form-control phone" id="phone" name="phone" placeholder="เบอร์โทรศัพท์">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">สถานะ</label>
            <select class="form-control" name="status" id="status">
              <option value="">เลือก</option>
              <option value="1">ใช้งาน</option>
              <option value="0">ไม่ใช้งาน</option>
            </select>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">สถานะผู้ใช้งาน</label>
            <select class="form-control" name="user_type" id="user_type">
              <option value="">เลือก</option>
              <option value="1">Admin</option>
              <option value="2">User</option>
            </select>
          </div>
          <input type="hidden" name="user_id" id="user_id" value="">
          <input type="hidden" name="user_org_id" id="user_org_id" value="">
      </div>
      <div class="modal-footer">
        <button type="submit" id="user-submit" class="btn btn-orange">บันทึก</button>
        <button type="button" class="btn btn-orange" data-dismiss="modal">ยกเลิก</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_org" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form id="form_org" method="post">
      <input type="hidden" name="org_id" id="org_id" value="">
      <input type="hidden" name="org_parent" id="org_parent" value="">
      <div class="modal-header">
        <h5 class="modal-title">จัดการหน่วยงาน</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="org_name">ชื่อหน่วยงาน</label>
          <input type="text" class="form-control" id="org_name" name="org_name" placeholder="">
        </div>   
      </div>
      <div class="modal-footer">
        <button type="button" id="budget_submit" class="btn btn-orange" onclick="update_org()">บันทึก</button>
        <button type="button" class="btn btn-orange" data-dismiss="modal">ยกเลิก</button>
      </div>
    </form>
    </div>

  </div>
</div>



<?php $this->endSection() ?>

<?=$this->section("scripts")?>
<link rel="stylesheet" href="<?php echo base_url('public/vendor/jquery-treegrid/css/jquery.treegrid.css')?>">

<script type="text/javascript" src="<?php echo base_url('public/vendor/jquery-treegrid/js/jquery.treegrid.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/vendor/jquery-treegrid/js/jquery.treegrid.bootstrap3.js')?>"></script>

<!-- Page level plugins -->
<script src="<?= base_url('public/vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('public/vendor/datatables/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('modules/User/Scripts/user.js');?>"></script>
<!-- Page level custom scripts -->
<script src="<?= base_url('public/js/demo/datatables-demo.js')?>"></script>


<?php if (@$session->getFlashdata('success')): ?>
<script>
  $(document).ready(function() {
    swal({
    title: "<p style='font-size:24px;'>ได้ทำการบันทึกข้อมูลเรียบร้อยแล้ว<p>",
    type: 'success'
    });
  });
</script>
<?php endif; ?>


<script type="text/javascript">
    var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
    var output = document.getElementById('output');
    output.src = reader.result;
     };
     reader.readAsDataURL(event.target.files[0]);
    };

    $(document).ready(function() {
        $('.tree').treegrid();
        // $('.tree').treegrid({
        //   source: $('#base_url').val()+"/user/getDataTree"
        // });
    });

    function addOrg(parent,id){
      $('#org_parent').val(parent);
      $('#modal_org').modal('show');
    }

    function editOrg(parent,id){
      var data_org_name = $('#data_org_name'+id).val();

      $('#org_id').val(id);
      $('#org_parent').val(parent);
      $('#org_name').val(data_org_name);

      $('#modal_org').modal('show');
    }

    function delOrg(id){
      swal({
        title: "ยืนยันการลบข้อมูล?",
        text: "คุณต้องการลบข้อมูลนี้หรือไม่!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยัน ",
        cancelButtonText: "ยกเลิก ",
      }).then(function () {
        $.ajax({
          url: $('#base_url').val()+"/user/delete_org/"+id,
          type: "GET",
          success: function (data) {
            swal("ลบข้อมูลเรียบร้อย!", "", "success").then((value) => {
              location.reload();
            });
          },
        });
      });
    }

    function addUser(org_id){
      $('#user_org_id').val(org_id);
      $('#user_profile').modal('show');
    }

    function update_org(){
      $.ajax({
        url: $('#base_url').val()+"/user/update_org",
        type: "POST",
        data:$('#form_org').serialize(),
        success: function (data) {
          var class_parent ='';
          if($('#org_parent').val()!=0){
            $class_parent = 'treegrid-parent-'+$('#org_parent').val();
            var addOrgBtn = '<button onclick="addUser('+$('#org_id').val()+')"  class="btn btn-primary btn-sm edit-org" ><i class="fas fa-plus"></i> </button>';
          }else{
            var addOrgBtn = '<button onclick="addOrg('+$('#org_id').val()+',0)" id="'+$('#org_id').val()+'" class="btn btn-primary btn-sm edit-org" ><i class="fas fa-plus"></i> </button>';
          }

          var tr = '<tr class="treegrid-'+$('#org_id').val()+' '+class_parent+' " >'+
                '<td>'+$('#org_name').val()+'</td>'+
                '<td class="text-right">'+
                  '<input type="hidden" name="data_org_name'+$('#org_id').val()+'" id="data_org_name'+$('#org_id').val()+'" value="'+$('#org_name').val()+'">'+
                  addOrgBtn+
                  '<button onclick="editOrg('+$('#org_parent').val()+','+$('#org_id').val()+')" id="'+$('#org_id').val()+'" class="btn btn-primary btn-sm edit-org" ><i class="fas fa-edit"></i> </button>'+
                  '<button onclick="delOrg('+$('#org_id').val()+')" class="btn btn-primary btn-sm"><i class="fas fa-trash-alt"></i></button>'+
                '</td>'+
               '</tr>';

          if($('#org_parent').val()==0){
            alert('tree');
            $('.tree').treegrid('add', ['<tr class="treegrid-'+$('#org_id').val()+'><td>Added root</td></tr>']);
          }else{
            alert('.treegrid-'+$('#org_parent').val());
            alert('<tr class="treegrid-xx treegrid-parent-'+$('#org_parent').val()+'><td>Added root</td></tr>');;
            $('.treegrid-'+$('#org_parent').val()).treegrid('add', ['<tr class="treegrid-xx treegrid-parent-'+$('#org_parent').val()+'><td>Added root</td><td>Added root</td></tr>']);
          }

          $.toast({
             heading: 'success',
             text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
             showHideTransition: 'slide',
             icon: 'warning',
             position: 'bottom-right'
           });


        },
      });
    }

</script>
<?=$this->endSection()?>
