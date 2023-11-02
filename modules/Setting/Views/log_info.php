<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-4 col-4">Log Export Info</div>

				</div>
			</div>
			<div class="card-body">
				<table class="table table-striped table-bordered" id="myTable">
					<thead>
						<tr>
							<th>EXPORT DATE</th>
							<th>USER ID</th>
							<th>USERNAME</th>
							<th>ORG ID</th>
							<th>IP ADDRESS</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data as $d) { ?>
							<tr>
								<td><?php echo $d['EXPORT_DATE'] ?></td>
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


		// $('#data_date').change(function() {
		// 	var date = this.value;
		// 	date = date.split('/');
		// 	report_date = (date[2] - 543) + '-' + date[1] + '-' + date[0];

		// 	window.location.href = base_url + '/setting/log_info?d=' + report_date;
		// });


	});
</script>
<?= $this->endSection() ?>