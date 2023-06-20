<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Visa
        <button type="button" class="btn btn-primary btn-sm float-right rounded" onclick="manageVisa()">
          <i class="fa fa-plus"></i> เพิ่มข้อมูล VISA
        </button>
      </div>
      <div class="card-body">
        <table class="table table-striped table-bordered" id="myTable">
          <thead>
            <tr>
              <th>Visa</th>
              <th>ประเภท</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $d) { ?>
              <tr>
                <td><?php echo $d['VISA_NAME'] ?> <?php if ($visa_ratio[$d['VISA_ID']] > 0) { ?> <a onclick="openDetail('<?php echo $d['VISA_ID'] ?>','<?php echo $d['VISA_NAME'] ?>')"><i class="fa fa-certificate" style="color:orange; cursor: pointer;"></i></a> <?php } ?></td>
                <td><?php echo $d['VISA_TYPE'] ?></td>
                <td align="center">
                  <a href="#" class="btn btn-primary" onclick="manageVisa('<?= $d['VISA_ID'] ?>')"><i class="fa fa-pen"></i></a>
                  <a href="#" class="btn btn-primary" onclick="editCalVISA('<?php echo $d['VISA_ID'] ?>','<?php echo $d['VISA_NAME'] ?>')"><i class="fa fa-cog"></i></a>
                  <button type="button" class="btn btn-primary" onclick="deleteVisa('<?= $d['VISA_ID'] ?>')"><i class="fa fa-trash"></i></button>

                  <input type="hidden" id="visa_id_<?= $d['VISA_ID'] ?>" value="<?= $d['VISA_ID'] ?>">
                  <input type="hidden" id="visa_name_<?= $d['VISA_ID'] ?>" value="<?= $d['VISA_NAME'] ?>">
                  <input type="hidden" id="visa_type_<?= $d['VISA_ID'] ?>" value="<?= $d['VISA_TYPE_ID'] ?>">
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="manageVisa" tabindex="-1" role="dialog" aria-labelledby="manageVisa" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">จัดการข้อมูล VISA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formVisa" action="">
          <div class="row">
            <div class="col-md-12">
              <label for="" class="form-label">Visa <span class="text-danger">*</span></label>
              <input type="text" id="visa_name" name="visa_name" class="form-control">
              <div id="valid_visa_name" class="text-danger d-none pt-1">*กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-md-12 pt-2">
              <label for="" class="form-label">ประเภท</label>
              <select name="visa_type_id" id="visa_type_id" class="form-control">
                <option value="1">นักท่องเที่ยว</option>
                <option value="2">ไม่นับเป็นนักท่องเที่ยว</option>
              </select>
            </div>
          </div>
          <input type="hidden" id="visa_id" name="visa_id">
          <input type="hidden" id="visa_type_name" name="visa_type_name">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="saveVisa()">บันทึก</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<form method="post" action="" id="form_ratio">
  <div class="modal fade" id="modalVisa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">จัดการสัดส่วน - <b><label id="port_name_label"></label></b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              ประเทศ
            </div>
            <div class="col-md-4">
              ตัวคูณ
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <select class="form-control" id="country_id" name="country_id">
                <option value="">เลือก</option>
                <?php foreach ($country as $key => $c) : ?>
                  <option value="<?php echo $c['COUNTRYID'] ?>"><?php echo $c['COUNTRY_NAME_EN'] ?></option>
                  <?php endforeach ?>?>
              </select>
            </div>
            <div class="col-md-4">
              <input class="form-control" id="ratio" name="ratio">
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              เดือน
            </div>
            <div class="col-md-4">
              ปี
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <select class="form-control" name="month" id="month">
                <?php foreach ($month_label as $key => $m) { ?>
                  <option value="<?php echo $key ?>"><?php echo $m ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-4">
              <select class="form-control" name="year" id="year">
                <?php for ($y = date('Y'); $y > date('Y') - 5; $y--) { ?>
                  <option value="<?php echo $y ?>"><?php echo $y + 543 ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="row" style="margin-top:20px;">
            <div class="col-md-12">
              <label>ข้อมูลสัดส่วน</label>
              <table class="table table-striped table-bordered" id="table_ratio">
                <tr>
                  <td align="center">ไม่มีข้อมูล</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="visa_id" id="visa_id" value="">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
          <button type="button" class="btn btn-primary" onclick="saveVisaRatio();">บันทึก</button>
        </div>
      </div>
    </div>
  </div>
</form>


<!-- Modal -->
<div class="modal fade" id="modalVisaDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">จัดการสัดส่วน - <b><label id="port_name_label_detail"></label></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row" style="margin-top:20px;">
          <div class="col-md-12">
            <label>ข้อมูลสัดส่วน</label>
            <table class="table table-striped table-bordered" id="table_ratio_detail">
              <tr>
                <td align="center">ไม่มีข้อมูล</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#myTable').DataTable({
      language: {
        "lengthMenu": "แสดง _MENU_ รายการ",
        "search": "ค้นหา:",
        "zeroRecords": "ไม่มีข้อมูล",
        "info": "รายการที่ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
        "infoEmpty": "ไม่มีข้อมูล",
        "paginate": {
          "first": "First",
          "last": "Last",
          "next": "ถัดไป",
          "previous": "ก่อนหน้า"
        },
      }
    });
  });

  function validation_form() {
    if ($('#visa_name').val() == '') {
      $('#valid_visa_name').removeClass('d-none')
      return false;
    } else {
      $('#valid_visa_name').addClass('d-none')
      return true;
    }
  }

  function manageVisa(id = '') {
    if (id) {
      $('#visa_id').val($(`#visa_id_${id}`).val())
      $('#visa_name').val($(`#visa_name_${id}`).val())
      $('#visa_type_id').val($(`#visa_type_${id}`).val())
    } else {
      $('#visa_id').val('')
      $('#visa_name').val('')
      $('#visa_type_id').val('1')
    }

    $('#manageVisa').modal('show');
  }

  function saveVisa() {
    if (validation_form()) {

      $('#visa_type_name').val($("#visa_type_id option:selected").text());

      $.ajax({
        method: "POST",
        url: base_url + "/setting/saveVisa",
        data: $('#formVisa').serialize(),
        success: function(res) {
          $('#manageVisa').modal('hide');
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            iconColor: '#007c83',
            title: 'บันทึกข้อมูลสำเร็จ',
            showConfirmButton: false,
            timer: 1500
          }).then(() => {
            window.location.reload()
          })
        }
      })
    }
  }

  function deleteVisa(id) {
    Swal.fire({
      title: 'ยืนยันการลบข้อมูล?',
      text: "หากต้องการกู้ข้อมูลโปรดติดต่อเจ้าหน้าที่",
      icon: 'warning',
      showCancelButton: true,
      iconColor: '#ffa500',
      confirmButtonColor: '#007c83',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ตกลง',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          method: 'post',
          url: base_url + '/setting/deleteVisa',
          data: {
            id: id
          },
          success: function(res) {
            if (res) {
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                iconColor: '#007c83',
                title: 'ทำการลบข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                window.location.reload()
              })
            }
          }
        })
      }
    })
  }

  function editCalVISA(id, name) {
    $('#visa_id').val(id);
    $('#ratio').val('');

    $('#port_name_label').html(name);

    $.ajax({
      type: 'GET',
      url: base_url + '/setting/getVisaRatio/' + id,
      success: function(data) {
        if (data) {
          // $('#table_ratio').html('');
          var html = '';
          var month = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
          $.each(data, function(key, value) {
            html = html + '<tr><td>' + value.COUNTRY_NAME_EN + '</td><td>' + (parseInt(value.YEAR) + 543) + '</td><td>' + month[value.MONTH - 1] + '</td><td>สัดส่วน : ' + value.RATIO + '</td></tr>';
          });
          $('#table_ratio').html(html);
        }

      },
    });

    $('#modalVisa').modal('show');
  }

  function saveVisaRatio() {
    if($('#country_id').val()==''){
      alert('กรุณาเลือกประเทศ');
      $('#country_id').focus();
      return false;
    }

    if($('#ratio').val()==''){
      alert('กรุณาระบุสัดส่วน');
      $('#ratio').focus();
      return false;
    }

    $.ajax({
      type: 'POST',
      url: base_url + '/setting/saveVisaRatio',
      data: $('#form_ratio').serialize(),
      success: function(data) {
        $('#modalPort').modal('hide');
      },
    });
  }

  function openDetail(id, name) {
    $('#port_name_label_detail').html(name);
    $.ajax({
      type: 'GET',
      url: base_url + '/setting/getVisaRatio/' + id,
      success: function(data) {
        if (data) {
          // $('#table_ratio').html('');
          var html = '';
          var month = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
          $.each(data, function(key, value) {
            html = html + '<tr><td>' + value.COUNTRY_NAME_EN + '</td><td>' + value.VISA_NAME + '</td><td>' + (parseInt(value.YEAR) + 543) + '</td><td>' + month[value.MONTH - 1] + '</td><td>สัดส่วน : ' + parseFloat(value.RATIO) + '</td></tr>';
          });
          $('#table_ratio_detail').html(html);
        }

      },
    });

    $('#modalVisaDetail').modal('show');
  }
</script>
<?= $this->endSection() ?>