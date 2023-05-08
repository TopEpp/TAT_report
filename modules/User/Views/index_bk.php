<?php $session = session(); ?>
<?php $this->extend('templates/main') ?>
<?php $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <h5 class="h5 mb-0 text-gray-800">จัดการ ผู้ใช้งาน</h5>
        </div>
        <div class="col-md-6" align="right">
          <button class="btn btn-orange" data-toggle="modal" data-target="#user_profile">เพิ่มบัญชี</button>
        </div>
      </div>
      <br>
        <div class="table-responsive">
            <table class="table table-bordered dataTable" width="100%" cellspacing="0">
                <thead style="background-color: #E5E5E5;border:1px solid #e3e6f0;">
                    <tr>
                        <th class="text-center">ชื่อผู้ใช้งาน</th>
                        <th class="text-center">ชื่อ-นามสกุล</th>
                        <th class="text-center">อีเมลล์</th>
                        <th class="text-center">เบอร์โทรศัพท์</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-center">สถานะผู้ใช้งาน</th>
                        <th class="text-center">เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($data as $key => $value): ?>
                  <tr>
                    <td class="text-center"><?php echo $value['username']; ?></td>
                    <td class="text-center"><?php echo $value['first_name'].' '.$value['last_name']; ?></td>
                    <td class="text-center"><?php echo $value['email']; ?></td>
                    <td class="text-center phone"><?php echo $value['phone']; ?></td>
                    <td class="text-center"><?= ($value['status'] == '1') ? 'ใช้งาน' : 'ไม่ใช้งาน'; ?></td>
                    <td class="text-center"><?= ($value['user_type'] == '1') ? 'Admin' : 'User'; ?></td>
                    <td class="text-center">
                      <button id='<?php echo $value['user_id'] ?>' class="btn btn-orange edit-profile" data-toggle="modal" data-target="#user_profile"><i class="fas fa-edit"></i> </button>
                      <button onclick="UserDel(<?php echo $value['user_id']; ?>)" class="btn btn-orange"><i class="fas fa-trash-alt"></i></button>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="user_profile" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <form class="" action="<?php echo base_url('/user/user_update/'); ?>" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">จัดการ ผู้ใช้งาน</h5>
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
      </div>
      <div class="modal-footer">
        <button type="submit" id="user-submit" class="btn btn-orange">บันทึก</button>
        <button type="button" class="btn btn-orange" data-dismiss="modal">ยกเลิก</button>
      </div>
    </form>
    </div>
  </div>
</div>
<script>
var loadFile = function(event) {
var reader = new FileReader();
reader.onload = function(){
var output = document.getElementById('output');
output.src = reader.result;
 };
 reader.readAsDataURL(event.target.files[0]);
};
</script>
<?php $this->endSection() ?>

<?=$this->section("scripts")?>
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
<?=$this->endSection()?>
