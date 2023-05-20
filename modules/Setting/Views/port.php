<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<div class="row" >
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">PORT</div>
  			<div class="card-body">
  				<table class="table table-striped table-bordered"  id="myTable">
  					<thead>
  						<tr>
  							<th>ชื่อด่าน</th>
  							<th>ประเภทด่าน</th>
  							<th>ประเภท</th>
  							<th></th>
  						</tr>
  					</thead>
  					<tbody>
  					<?php foreach($data as $d){?>
  						<tr>
  							<td><?php echo $d['PORT_NAME']?> <?php if($port_ratio[$d['PORT_ID']]>0){ ?> <a onclick="openDetail('<?php echo $d['PORT_ID']?>','<?php echo $d['PORT_NAME']?>')"><i class="fa fa-certificate" style="color:orange; cursor: pointer;"></i></a> <?php }?></td>
  							<td><?php echo $d['PORT_TYPE']?></td>
  							<td><?php echo $d['PORT_CATEGORY']?></td>
  							<td align="center">
                    <a href="#" class="btn btn-primary" onclick="editPort('<?php echo $d['PORT_ID']?>')"><i class="fa fa-pencil"></i></a>
                    <a href="#" class="btn btn-primary" onclick="editPortRatio('<?php echo $d['PORT_ID']?>','<?php echo $d['PORT_NAME']?>')"><i class="fa fa-cog"></i></a>
                </td>
                <input type="hidden" id="port_name_<?php echo $d['PORT_ID']?>" value="<?php echo $d['PORT_NAME']?>">
                <input type="hidden" id="port_cate_<?php echo $d['PORT_ID']?>" value="<?php echo $d['PORT_CATEGORY_ID']?>">
                <input type="hidden" id="port_type_<?php echo $d['PORT_ID']?>" value="<?php echo $d['PORT_TYPE_ID']?>">
  						</tr>
  					<?php } ?>
  					</tbody>
  				</table>

  			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<form method="post" action="" id="form_ratio">
<div class="modal fade" id="modalPort" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
           <div class="col-md-12">
             ประเทศ
           </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <select class="form-control" id="country_id" name="country_id">
              <option value="">เลือก</option>
              <?php foreach ($country as $key => $c): ?>
                <option value="<?php echo $c['COUNTRYID']?>"><?php echo $c['COUNTRY_NAME_EN']?></option>
              <?php endforeach ?>?>
            </select>
          </div>
        </div>
        <div class="row">
           <div class="col-md-8">
             Visa
           </div>
           <div class="col-md-4">
             ตัวคูณ
           </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <select class="form-control" id="visa_id" name="visa_id">
              <option value="">เลือก</option>
              <?php foreach ($visa as $key => $c): ?>
                <option value="<?php echo $c['VISA_ID']?>"><?php echo $c['VISA_NAME']?></option>
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
             <?php foreach($month_label as $key=> $m){?>
              <option value="<?php echo $key?>"><?php echo $m?></option>
             <?php } ?>
             </select>
           </div>
           <div class="col-md-4">
             <select class="form-control" name="year" id="year">
              <?php for($y=date('Y') ; $y>date('Y')-5; $y--){?>
                <option value="<?php echo $y?>"><?php echo $y+543?></option>
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
        <input type="hidden" name="port_id" id="port_id" value="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="savePortRatio();">บันทึก</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- Modal -->
<form method="post" action="" id="form_manage">
<div class="modal fade" id="modalPortManage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">จัดการข้อมูลด่าน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>ชื่อด่าน</label>
            <input type="text" class="form-control" name="port_name" id="port_name_manage" value="">
          </div>
          <div class="col-md-12">
            <label>ประเภทด่าน</label>
            <select class="form-control" name="port_type" id="port_type_manage">
              <option value="1">ด่านบก</option>
              <option value="2">ด่านอากาศ</option>
            </select>
          </div>
          <div class="col-md-12">
            <label>ประเภท</label>
            <select class="form-control" name="port_cate" id="port_cate_manage">
              <option value="1">ด่านที่รวมในการศึกษานี้</option>
              <option value="2">ด่านไม่รวมในการศึกษา</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="port_id" id="port_id_manage" value="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="savePort();">บันทึก</button>
      </div>
    </div>
  </div>
</div>
</form>

<div class="modal fade" id="modalPortDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<?=$this->section("scripts")?>
<script type="text/javascript">
var tableData;
$(document).ready( function () {
  tableData = $('#myTable').DataTable({
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

function editPort(id){
  $('#port_id_manage').val(id);
  $('#port_name_manage').val( $('#port_name_'+id).val() );
  $('#port_type_manage').val( $('#port_type_'+id).val() );
  $('#port_cate_manage').val( $('#port_cate_'+id).val() );
  $('#modalPortManage').modal('show');
}

function savePort(){
  $.ajax({
        type: 'POST',
        url: base_url+'/setting/savePort',
        data : $('#form_manage').serialize(),
        success: function(data) {
          $('#modalPortManage').modal('hide');
        },
    });
}

function savePortRatio(){
  $.ajax({
        type: 'POST',
        url: base_url+'/setting/savePortRatio',
        data : $('#form_ratio').serialize(),
        success: function(data) {
          $('#modalPort').modal('hide');
        },
    });
}

function editPortRatio(id,name){
  $('#port_id').val(id);
  $('#ratio').val('');
  
  $('#port_name_label').html(name);
   $.ajax({
        type: 'GET',
        url: base_url+'/setting/getPortRatio/'+id,
        success: function(data) {
          if(data){
            // $('#table_ratio').html('');
            var html = '';
            var month = [ "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
            $.each( data, function( key, value ) {
              html = html +'<tr><td>'+value.COUNTRY_NAME_EN+'</td><td>'+value.VISA_NAME+'</td><td>'+( parseInt(value.YEAR) +543)+'</td><td>'+month[value.MONTH-1]+'</td><td>สัดส่วน : '+value.RATIO+'</td></tr>';
            });
            $('#table_ratio').html(html);
          }
          
        },
    });

  $('#modalPort').modal('show');
}

function openDetail(id,name){  
  $('#port_name_label_detail').html(name);
   $.ajax({
        type: 'GET',
        url: base_url+'/setting/getPortRatio/'+id,
        success: function(data) {
          if(data){
            // $('#table_ratio').html('');
            var html = '';
            var month = [ "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
            $.each( data, function( key, value ) {
              html = html +'<tr><td>'+value.COUNTRY_NAME_EN+'</td><td>'+value.VISA_NAME+'</td><td>'+( parseInt(value.YEAR) +543)+'</td><td>'+month[value.MONTH-1]+'</td><td>สัดส่วน : '+value.RATIO+'</td></tr>';
            });
            $('#table_ratio_detail').html(html);
          }
          
        },
    });

  $('#modalPortDetail').modal('show');
}
</script>
<?=$this->endSection()?>