a<?php $this->extend('templates/main') ?>
<?= $this->section("stylesheet") ?>
<link href="<?php echo base_url('public/vendor/dropzonejs/dropzone.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('public/vendor/select2/css/select2.min.css') ?>" rel="stylesheet" />
<?php $this->endSection() ?>
<!-- content -->
<?php $this->section('content') ?>
<style>
  #upload {
    opacity: 0;
  }

  #upload-label {
    position: absolute;
    top: 50%;
    left: 1rem;
    transform: translateY(-50%);
  }

  .image-area {
    border: 2px dashed rgba(255, 255, 255, 0.7);
    padding: 1rem;
    position: relative;
  }

  .image-area::before {
    content: 'Uploaded image result';
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.8rem;
    z-index: 1;
  }

  .image-area img {
    z-index: 2;
    position: relative;
  }
</style>


<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">เพิ่มผู้ใช้งาน</div>
      <div class="card-body">
        <form action="<?= base_url('user/user_save'); ?>" method="post" id="form_user" class="needs-validation" enctype="multipart/form-data"
          novalidate="">
          <input type="hidden" name="USER_ID" id="USER_ID" value="<?php if(!empty($data)){ echo @$data['USER_ID'];}?>">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group" style="text-align: center">
                <div class="image-area">
                  <img id="imageResult" class="img-profile rounded-circle"
                    src="<?php echo base_url(((@$data['USER_PHOTO_FILE'] != '' ?'public/uploads/user/'.@$data['USER_PHOTO_FILE'] : 'public/img/no_image.png'))); ?>" style="width: 170px;height: 170px;">
                </div>
                <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                  <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0"
                    accept="image/*" name="USER_PHOTO_FILE">
                  <label id="upload-label" for="upload" class="font-weight-light text-muted"><?php echo @$data['USER_PHOTO_FILE'] ?></label>
                  <div class="input-group-append">
                    <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i
                        class="fa fa-cloud-upload mr-2 text-muted"></i><small
                        class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8" style="align-self: center;">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">ชื่อผู้ใช้งาน <span style="color:red">*</span></label>
                    <input type="text" class="form-control" id="USER_NAME" name="USER_NAME"
                      value="<?php if(!empty($data)){ echo @$data['USER_NAME'];}?>" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">รหัสผ่าน<span style="color:red">*</span> <span style="font-size: 12px;color:#858796 !important">(รหัสผ่านอย่างน้อย 6 ตัวอักษร)</span></label>
                    <input type="password" class="password form-control" id="password" name="USER_PASSWORD"
                      value="" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">ยืนยันรหัสผ่าน <span style="color:red">*</span></label>
                    <input type="password" class="re_password form-control" id="re_password" name="RE_PASSWORD"
                      value="" required>
                  </div>
                </div>
              </div>
              <div class="row">
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">ประเภทหน่วยงาน <span class="text-danger">*</span></label>
                    <select id="user_type_org" name="USER_TYPE_ORG" class="form-control" onchange="check_type_org()" required>
                      <option value="">เลือก</option>
                      <option value="3" <?php echo (@$data['USER_TYPE_ORG'] == 3 ? "selected": "")?>>ททท. สำนักงานใหญ่</option>
                      <option value="1" <?php echo (@$data['USER_TYPE_ORG'] == 1 ? "selected": "")?>>สำนักงานในประเทศ</option>
                      <option value="2" <?php echo (@$data['USER_TYPE_ORG'] == 2 ? "selected": "")?>>สำนักงานต่างประเทศ</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <label for="">หน่วยงาน <span class="text-danger">*</span></label>
                    <select name="USER_ORG_ID" id="user_org_id" class="form-control" required>
                    <option value="">เลือก</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-8">
                <div class="form-group">
                    <label for="">กลุ่มผู้ใช้งาน <span class="text-danger">*</span></label>
                    <br>
                     <?php foreach($user_role as $role){ $check = ''; if(@$data_role[$role['USER_ROLE_ID']]){ $check='checked="checked"';} ?>
                      <label class="form-check-label" style="padding-right: 10px;"><input <?php echo $check;?>  type="checkbox" name="USER_ROLE_TYPE[]" value="<?php echo $role['USER_ROLE_ID']?>"> <?php echo $role['USER_ROLE_NAME']?></label>
                     <?php }?>
                   
                    <input type="hidden" name="USER_PERMISSION_TYPE" id="USER_PERMISSION_TYPE" value="<?php echo @$data['USER_PERMISSION_TYPE'] ?>">
                   <!--  <select name="USER_PERMISSION_TYPE" id="USER_PERMISSION_TYPE"  class="form-control" required>
                      <option value="">เลือก</option>
                      <?php foreach($user_type as $ut){ ?>
                        <option value="<?php echo $ut['USER_TYPE_ID']?>"><?php echo $ut['USER_TYPE_NAME']?></option>
                      <?php } ?>
                    </select> -->
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">สถานะการใช้งาน</label>
                    <div class="form-check">
                      <input value="1" type="checkbox" class="form-check-input" id="USER_ACTIVE_STATUS" name="USER_ACTIVE_STATUS" <?php echo (@$data['USER_ACTIVE_STATUS'] == "1" ? "checked" : "");?>>
                      <label class="form-check-label" for="">ใช้งาน</label>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-md-12" style="text-align:right;">
              <button type="reset" class="btn btn-danger m-1" onclick="clearData()">ล้างค่า</button>
              <a href="<?php echo base_url('user'); ?>" class="btn btn-primary m-1">กลับหน้าหลัก</a>
              <button type="submit" id="button_submit" class="btn btn-primary m-1">บันทึก</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<?php $this->endSection() ?>

<?=$this->section("scripts")?>
<script type="text/javascript" src="<?= base_url('public/vendor/dropzonejs/dropzone.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/vendor/select2/js/select2.min.js') ?>"></script>
<script>
    $('#password').on('change', function() {
      if($(this).val().length < 6) {
        Swal.fire('กรุณากรอกข้อมูลต่อไปนี้','กำหนดรหัสผ่านอย่างน้อย 6 ตัวอักษร','warning');
    }
    });
    $('#re_password').on('change', function() {
      if($(this).val().length < 6) {
        Swal.fire('กรุณากรอกข้อมูลต่อไปนี้','กำหนดรหัสผ่านอย่างน้อย 6 ตัวอักษร','warning');
    }
    });

  document.querySelector('#button_submit').onclick = function () {
        var password = document.querySelector('#password').value;
        var re_password = document.querySelector('#re_password').value;
        if (password != re_password) {
        Swal.fire('กรุณากรอกข้อมูลต่อไปนี้','รหัสผ่านไม่ตรงกัน','warning');
        return false;
        }else
        if (password < 6 || re_password < 6) {
        Swal.fire('กรุณากรอกข้อมูลต่อไปนี้','กำหนดรหัสผ่านอย่างน้อย 6 ตัวอักษร','warning');
        return false;
        }
        }
</script>
I<script type="text/javascript">
  Dropzone.autoDiscover = false;
  var temp_file = new Array();
  $(document).ready(function () {
    CheckOrg();
    $('#ROUTE_TARGET').select2();
    $('#ROUTE_TYPE').select2();

    $('.date_picker').datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
      language: 'th-th',
    });

    $("#ROUTE_ATTACH_DROP").dropzone({
      maxFiles: 2,
      maxFilesize: 256,
      acceptedFiles: 'image/*,application/pdf',
      addRemoveLinks: true,
      url: base_url + "/services/attachFile/route",
      success: function (file, response) {
        var file_name = response.file;
        temp_file.push(file_name);
        $('#ROUTE_ATTACH').val(temp_file);
      }
    });


  });


  function clearData() {
    $('#form_user')[0].reset();
  }

  function check_type_org() {
    var department = <?php echo json_encode(@$department) ?>;
    var dep_region = <?php echo json_encode(@$dep_region) ?>;
    var dep_center = <?php echo json_encode(@$dep_center) ?>;
    var select_type_org = document.getElementById("user_type_org");
    var select_org = document.getElementById("user_org_id");

    if (select_type_org.value == 1) {
      $('#USER_PERMISSION_TYPE').val(3);

      while (select_org.hasChildNodes()) {
      select_org.removeChild(select_org.firstChild);
      }
      for (var i = 0; i < department.length; i++) {
            var org=department[i];
            var el1=document.createElement("option");
            el1.value=org.DEPARTMENT_ID;
            el1.textContent=org.DEPARTMENT_NAME_TH;
            select_org.appendChild(el1);
      }
    }else if(select_type_org.value==2){
      $('#USER_PERMISSION_TYPE').val(2);
         while (select_org.hasChildNodes()) {
           select_org.removeChild(select_org.firstChild);
          }
      for (var i=0; i < dep_region.length; i++) {
         var org=dep_region[i];
         var el2=document.createElement("option");
          el2.value=org.DEP_REGION_ID;
          el2.textContent=org.DEP_REGION_TH;
          select_org.appendChild(el2);
        }
    }else if (select_type_org.value == 3) {
      $('#USER_PERMISSION_TYPE').val(3);
      while (select_org.hasChildNodes()) {
      select_org.removeChild(select_org.firstChild);
      }
      for (var i = 0; i < dep_center.length; i++) {
            var org=dep_center[i];
            var el1=document.createElement("option");
            el1.value=org.DEPARTMENT_ID;
            el1.textContent=org.DEPARTMENT_NAME_TH;
            select_org.appendChild(el1);
      }
    }
  }

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#imageResult')
          .attr('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  $(function () {
    $('#upload').on('change', function () {
      readURL(input);
    });
  });

  var input = document.getElementById('upload');
  var infoArea = document.getElementById('upload-label');

  input.addEventListener('change', showFileName);

  function showFileName(event) {
    var input = event.srcElement;
    var fileName = input.files[0].name;
    infoArea.textContent = 'File name: ' + fileName;
    document.getElementById("upload").value = fileName;
  }

function CheckOrg() {
  var user_type_org = <?php echo json_encode(@$data['USER_TYPE_ORG']); ?>;
  var user_org_id = <?php echo json_encode(@$data['USER_ORG_ID']) ?>;
  var department = <?php echo json_encode($department) ?>;
  var dep_region = <?php echo json_encode($dep_region) ?>;
  var dep_center = <?php echo json_encode($dep_center) ?>;
  var select_user_org_id = document.getElementById("user_org_id");

  
  if (user_type_org == 1) {
      for (var i = 0; i < department.length; i++) {
            var org=department[i];
            var el1=document.createElement("option");
            el1.value=org.DEPARTMENT_ID;
            el1.textContent=org.DEPARTMENT_NAME_TH;
            select_user_org_id.appendChild(el1);
            if (user_org_id == org.DEPARTMENT_ID) {
              el1.selected = true;
            }
      }
  }else if(user_type_org == 2){
    for (var i=0; i < dep_region.length; i++) {
       var org=dep_region[i];
       var el2=document.createElement("option");
        el2.value=org.DEP_REGION_ID;
        el2.textContent=org.DEP_REGION_TH;
        select_user_org_id.appendChild(el2);
        if (user_org_id == org.DEP_REGION_ID) {
              el2.selected = true;
            }
      }
  }else if(user_type_org == 3){
    for (var i = 0; i < dep_center.length; i++) {
            var org=dep_center[i];
            var el1=document.createElement("option");
            el1.value=org.DEPARTMENT_ID;
            el1.textContent=org.DEPARTMENT_NAME_TH;
            select_user_org_id.appendChild(el1);
            if (user_org_id == org.DEPARTMENT_ID) {
              el1.selected = true;
            }
      }
  }
}


</script>
<?=$this->endSection()?>
