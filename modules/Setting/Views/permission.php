<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Permission Group Title
      </div>
      <div class="card-body">
        <table class="table table-striped table-bordered" id="myTable">
          <thead>
            <tr>
              <th>Title</th>
              <th width="15%">Dashboard</th>
              <th width="15%">Report</th>
              <th width="15%">Import</th>
              <th width="15%">Setting</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($group as $d) { ?>
              <tr>
                <td><?php echo $d['GROUP_ID']?></td>
                <td align="center"><?php if($d['DASHBOARD']){ echo '<i class="fa fa-check" style="color:green"></i>';}?></td>
                <td align="center"><?php if($d['REPORT']){ echo '<i class="fa fa-check" style="color:green"></i>';}?></td>
                <td align="center"><?php if($d['IMPORT']){ echo '<i class="fa fa-check" style="color:green"></i>';}?></td>
                <td align="center"><?php if($d['SETTING']){ echo '<i class="fa fa-check" style="color:green"></i>';}?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Permission User
      </div>
      <div class="card-body">
        <table class="table table-striped table-bordered" id="myTable">
          <thead>
            <tr>
              <th>User</th>
              <th width="15%">Dashboard</th>
              <th width="15%">Report</th>
              <th width="15%">Import</th>
              <th width="15%">Setting</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($user as $d) { ?>
              <tr>
                <td><?php echo $d['USERNAME']?></td>
                <td align="center"><?php if($d['DASHBOARD']){ echo '<i class="fa fa-check" style="color:green"></i>';}?></td>
                <td align="center"><?php if($d['REPORT']){ echo '<i class="fa fa-check" style="color:green"></i>';}?></td>
                <td align="center"><?php if($d['IMPORT']){ echo '<i class="fa fa-check" style="color:green"></i>';}?></td>
                <td align="center"><?php if($d['SETTING']){ echo '<i class="fa fa-check" style="color:green"></i>';}?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
  $(document).ready(function() {
    // $('#myTable').DataTable({
    //   language: {
    //     "lengthMenu": "แสดง _MENU_ รายการ",
    //     "search": "ค้นหา:",
    //     "zeroRecords": "ไม่มีข้อมูล",
    //     "info": "รายการที่ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
    //     "infoEmpty": "ไม่มีข้อมูล",
    //     "paginate": {
    //       "first": "First",
    //       "last": "Last",
    //       "next": "ถัดไป",
    //       "previous": "ก่อนหน้า"
    //     },
    //   }
    // });
  });


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

</script>
<?= $this->endSection() ?>