<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">Import Raw Data</div>
			<div class="card-body">
				<form action="<?= base_url('import/import_file'); ?>" method="post" id="form_import" class="needs-validation" enctype="multipart/form-data">

					<div class="row">
						<div class="col-md-2">
							Report Date
						</div>
						<div class="col-md-9">
							File Raw Data
						</div>
						<div class="col-md-1">

						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<input type="text" id="REPORT_DATE" name="REPORT_DATE" class="form-control date_picker" value="" required>
						</div>
						<div class="col-md-9">
							<input type="file" name="import_file" id="import_file" class="form-control" accept=".xls,.xlsx" required>
						</div>
						<div class="col-md-1">
							<button type="submit" class="btn btn-primary">Upload</button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-4 col-4">Raw Data</div>
					<div class="col-md-4 col-4"></div>
					<div class="col-md-2 col-2" style="text-align:right; padding-top: 5px;">
						ข้อมูลวันที่ :
					</div>
					<div class="col-md-2 col-2">
						<input type="text" id="data_date" name="data_date" class="form-control date_picker" value="<?php echo $to_date_label; ?>">
					</div>

				</div>
			</div>
			<div class="card-body">
				<table class="table table-striped table-bordered" id="myTable">
					<thead>
						<tr>
							<th>REPORT_DATE</th>
							<th>DIRECTION</th>
							<th>NATION</th>
							<th>VISA</th>
							<th>OFFICE</th>
							<th>HEAD_OFFICE</th>
							<th>NUM</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data as $d) { ?>
							<tr>
								<td><?php echo $Mydate->date_thai2eng($d['REPORT_DATE_CHAR'], 543, '/') ?></td>
								<td><?php echo $d['DIRECTION'] ?></td>
								<td><?php echo $d['NATION'] ?></td>
								<td><?php echo $d['VISA'] ?></td>
								<td><?php echo $d['OFFICE'] ?></td>
								<td><?php echo $d['HEAD_OFFICE'] ?></td>
								<td><?php echo $d['NUM'] ?></td>
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
		$('.date_picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: 'th-th',
		});

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


		$('#data_date').change(function() {
			var date = this.value;
			date = date.split('/');
			report_date = (date[2] - 543) + '-' + date[1] + '-' + date[0];

			window.location.href = base_url + '/import?d=' + report_date;
		});


	});
</script>
<?= $this->endSection() ?>