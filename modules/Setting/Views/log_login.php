<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row align-items-end">
					<div class="col-md-3 col-12 mb-2 mb-md-0" style="font-size:1.1em;">Log Login</div>
					<div class="col-md-3 col-6">
						<label class="mb-1">วันที่เริ่มต้น</label>
						<input type="text" id="start_date" class="form-control date_picker" value="<?php echo $Mydate->date_thai2eng($start_date, 543, '/') ?>">
					</div>
					<div class="col-md-3 col-6">
						<label class="mb-1">วันที่สิ้นสุด</label>
						<input type="text" id="end_date" class="form-control date_picker" value="<?php echo $Mydate->date_thai2eng($end_date, 543, '/') ?>">
					</div>
					<div class="col-md-3 col-12 mt-2 mt-md-0">
						<button class="btn btn-primary" onclick="ChangeFilter()"><i class="fas fa-search"></i> ค้นหา</button>
						<button class="btn btn-success" onclick="ExportExcel()"><i class="fas fa-file-excel"></i> Excel</button>
					</div>
				</div>
			</div>
			<div class="card-body">
				<table class="table table-striped table-bordered" id="myTable">
					<thead>
						<tr>
							<th>LOGIN DATE</th>
							<th>USER ID</th>
							<th>USERNAME</th>
							<th>ORG ID</th>
							<th>IP ADDRESS</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data as $d) { ?>
							<tr>
								<td><?php echo $d['LOGIN_DATE'] ?></td>
								<td><?php echo $d['USER_ID'] ?></td>
								<td><?php echo $d['USERNAME'] ?></td>
								<td><?php echo $d['ORG_ID'] ?></td>
								<td><?php echo $d['IP_ADDRESS'] ?></td>
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
	// แปลงค่าจาก date_picker (dd/mm/พ.ศ.) → dd-mm-ค.ศ. สำหรับส่งเป็น query param
	function toCeDmy(val) {
		var p = val.split('/');
		if (p.length !== 3) return '';
		return p[0] + '-' + p[1] + '-' + (p[2] - 543);
	}

	function ChangeFilter() {
		var start = toCeDmy($('#start_date').val());
		var end = toCeDmy($('#end_date').val());
		window.location.href = base_url + '/setting/log_login?start=' + start + '&end=' + end;
	}

	function ExportExcel() {
		var start = toCeDmy($('#start_date').val());
		var end = toCeDmy($('#end_date').val());
		window.location.href = base_url + '/setting/log_login?start=' + start + '&end=' + end + '&export_type=excel';
	}

	$(document).ready(function() {
		$('.date_picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: 'th-th',
		});

		$('#myTable').DataTable({
			order: [],
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
<?= $this->endSection() ?>
