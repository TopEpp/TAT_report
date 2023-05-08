<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<div class="row" >
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">Country</div>
  			<div class="card-body">
  				<table class="table table-striped table-bordered"  id="myTable">
  					<thead>
  						<tr>
  							<th>ชื่อภาษาอังกฤษ</th>
  							<th>ชื่อภาษาไทย</th>
  							<th>ภูมิภาค</th>
  							<th></th>
  						</tr>
  					</thead>
  					<tbody>
  					<?php foreach($data as $d){?>
  						<tr>
  							<td><?php echo $d['COUNTRY_NAME_EN']?></td>
  							<td><?php echo $d['COUNTRY_NAME_TH']?></td>
  							<td><?php echo $d['REGIONID']?></td>
  							<td align="center">
	                            <a href="#" class="btn btn-primary" onclick="editData()"><i class="fa fa-pen"></i></a>
	                            <a href="#" class="btn btn-primary" onclick="deleteData()"><i class="fa fa-trash"></i></a>
	                        </td>
  						</tr>
  					<?php } ?>
  					</tbody>
  				</table>

  			</div>
		</div>
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
</script>
<?=$this->endSection()?>