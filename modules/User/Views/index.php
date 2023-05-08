<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<style type="text/css">

    .container_icon {
      position: relative;
      text-align: center;
      color: white;
      margin-bottom: 5px;
    }

    .centered {
      position: absolute;
      top: 80%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
      height: 35px;
      background: #FFF;
      padding-top: 5px;
    }

</style>

<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4" style="text-align:center;"><h5>จัดการข้อมูลผู้ใช้งาน</h5></div>
    <div class="col-md-4"></div>
</div>


<div class="row">
    <div class="col-md-12" style="text-align:right;">
        <a href="<?php echo base_url('user/manage/0')?>"><button class="btn btn-primary" >เพิ่มข้อมูล</button></a>
        <a href="<?php echo base_url('permission')?>"><button class="btn btn-primary" >กำหนดสิทธิผู้ใช้งาน</button></a>
    </div>
</div>

<div class="row">
    <div class="col-md-12" >
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อผู้ใช้งาน</th>
                    <th>หน่วยงาน</th>
                    <th>ประเภทผู้ใช้งาน</th>
                    <th>ประเภทหน่วยงาน</th>
                    <th>สถานะ</th>
                    <th class="text-center">เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
            <?php $i=0; foreach($data as $id=>$row){ $i++; $USER_TYPE_ORG[1] = 'สำนักงานในประเทศ'; $USER_TYPE_ORG[2] = 'สำนักงานต่างประเทศ'; $USER_TYPE_ORG[3] = 'ททท. สำนักงานใหญ่'; ?>
                <tr id="tr_<?php echo $row['USER_ID'];?>">
                    <td align="center"><?php echo $i?></td>
                    <td><?php echo $row['USER_NAME']?></td>
                    <?php if ($row['USER_TYPE_ORG'] == 1) { ?>
                      <td><?php echo $row['DEPARTMENT_NAME_TH']?>
                    <?php } elseif($row['USER_TYPE_ORG'] ==2) {?>
                      <td><?php echo $row['DEP_REGION_TH']?></td>
                    <?php } else{?>
                      <td><?php echo $row['DEP_REGION_TH']?></td>
                    <?php } ?>
                    <td align="center"><?php echo $row['USER_TYPE_NAME'];?></td>
                    <td align="center"><?php echo @$USER_TYPE_ORG[$row['USER_TYPE_ORG']];?></td>
                    <td align="center"><?php echo ($row['USER_ACTIVE_STATUS'] == '1') ? "ปกติ" : "ระงับ";?></td>
                    <td class="text-center">
                        <a href="<?php echo base_url('user/manage/'.$row['USER_ID'])?>" ><i class="fa fa-pen"></i></a>
                        <a href="#" onclick="deleteUser('<?php echo $row['USER_ID'];?>')" ><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>
</div>



<?php $this->endSection() ?>

<?=$this->section("scripts")?>

<script type="text/javascript">
$(document).ready( function () {
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

function deleteUser(id) {
    Swal.fire({
      title: 'คุณต้องการลบข้อมูลหรือไม่ ?',
      text: "คลิกปุ่มตกลงเพื่อยืนยันการลบข้อมูล",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ตกลง',
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(
          'ทำการลบข้อมูลสำเร็จ',
          'ข้อมูลถูกลบสำเร็จ',
          'success'
        ).then(() => {
          $.ajax({
            type: 'POST',
            url: base_url+'/user/user_delete/'+id,
            success: function(data) {
              if (data.success) {
                location.reload();
              } else {
                console.log(data.message);
                $('#tr_'+id).remove();
              }
            },
          }).then( () => {
            location.reload();
          });
        })
      }
    });
  }
</script>
<?=$this->endSection()?>
