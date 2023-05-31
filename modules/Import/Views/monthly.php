<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<style>
	@media screen and (max-width: 600px) {
		.table-responsive {
			overflow-x: auto !important;
		}
	}

	.table-responsive {
		overflow-x: inherit;
	}

	.table thead th {
		background: #379FA6;
		border-bottom: 0;
		padding: 16px
	}

	.ColorTableBody {
		border-radius: 1em;
		overflow: hidden;
	}

	.table-responsive {
		overflow-x: initial
	}

	.ColorTableBody thead tr {
		margin: 20px;
	}

	table {
		border-radius: 12px;
		background-color: #F6F6F6;
	}

	table.dataTable thead th,
	table.dataTable thead td {
		border-bottom: 0px
	}

	.table-responsive {
		border-radius: 12px;
	}

	table.dataTable {
		margin-top: 0px !important;
	}
</style>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">Import Monthly Data</div>
			<div class="card-body">
				<form action="<?= base_url('import/import_file_monthly'); ?>" method="post" id="form_import" class="needs-validation" enctype="multipart/form-data">

					<div class="row">
						<div class="col-md-2">
							Month
						</div>
						<div class="col-md-2">
							Year
						</div>
						<div class="col-md-7">
							File Raw Data
						</div>
						<div class="col-md-1">

						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<select class="form-control" id="month" name="month" required>
							<?php foreach($month_label as $m_id=>$name){ ?>
								<option value="<?php echo $m_id?>"  ><?php echo $name?></option>
							<?php } ?>
							</select>
						</div>
						<div class="col-md-2">
							<select class="form-control" id="year" name="year" required>
							<?php for($i=date('Y');$i >= date('Y')-5;$i--){ ?>
								<option value="<?php echo $i?>"><?php echo $i?></option>
							<?php }?>
							</select>
						</div>
						<div class="col-md-7">
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
					<div class="col-md-4 col-4">Monthly Data</div>
					<div class="col-md-4 col-4"></div>
					<div class="col-md-2 col-2" style="text-align:right; padding-top: 5px;">
						
					</div>

				</div>
			</div>
			<div class="card-body">
				<table class="table table-striped table-bordered ColorTableBody shadow-lg" id="myTable">
					<thead>
						<tr>
							<th>YEAR</th>
							<th>MONTH</th>
							<th>NATION</th>
							<th>NUM</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach( $data as $d){ ?>
						<tr>
							<td><?php echo $d['YEAR']?></td>
							<td><?php echo $month_label[$d['MONTH']]?></td>
							<td><?php echo $d['COUNTRY_NAME_EN']?></td>
							<td><?php echo $d['NUM']?></td>
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