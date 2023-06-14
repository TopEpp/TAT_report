<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
<style>
	.radiusTableport_daily thead th {

		background: rgba(55, 159, 166, 1);
		padding: 16px;
	}

	.table thead th {
		border-bottom: none;
	}

	.radiusTableport_daily {
		border-radius: 1em;
		overflow: hidden;

	}

	.radiusTableport_daily tbody tr:nth-of-type(odd) {
		background: rgba(214, 239, 242, 1);
	}

	.table-bordered th,
	.table-bordered td {
		border-left: none
	}
</style>

<div class="row">
	<div class="col-md-6 text-center text-md-left" >
		
	</div>
	<div class="col-md-6 col-12 py-2" style="text-align: right;">
		<a target="_blank" onclick="export_report('excel')" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" onclick="export_report('pdf')" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	<div class="col-md-12 text-center py-2" style="font-size: 1.4em;">
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน รายด่าน
	</div>

</div>
<div class="row py-2">
	<div class="col-md-2"></div>
	<div class="col-md-4 col-12 py-2 py-md-0">
		วันที่เริ่มต้น <input type="text" name="report_data1" id="report_data1" class="form-control date_picker" style="display: inline;" value="<?php echo $Mydate->date_thai2eng($date_start, 543, '/') ?>">
	</div>
	<div class="col-md-4 col-12 py-2 py-md-0">
		วันที่สิ้นสุด <input type="text" name="report_data2" id="report_data2" class="form-control date_picker" style="display: inline;" value="<?php echo $Mydate->date_thai2eng($date_end, 543, '/') ?>">
	</div>
	<div class="col-md-2 col-12 mt-auto py-2 text-center text-md-left py-md-0">
		<div class="btn btn-primary" onclick="ChangeDate()">ตกลง</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 col-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered radiusTableport_daily">
				<thead>
					<tr>
						<th>ด่าน</th>
						<?php foreach ($period as $d) {
							echo "<th>{$Mydate->date_eng2thai($d, 543, 'S', 'S')}</th>";
						} ?>

					</tr>
				</thead>
				<tbody>
					<tr>
						<td style='background-color: rgba(97, 190, 201, 1);'><b>ไม่ใช่ด่านอากาศ</b></td>
						<?php foreach ($port[1] as $p) {
							foreach ($period as $d) {
								@$sum[$d] += @$data[$p['PORT_ID']][$d];
								@$sum_type1[$d] += @$data[$p['PORT_ID']][$d];
							}
						} ?>
						<?php foreach ($period as $d) {
							echo "<td style='background-color: rgba(97, 190, 201, 1);'  align='right'> <b> " . number_format(@$sum_type1[$d]) . "</b> </td>";
						} ?>
					</tr>
					<?php foreach ($port[1] as $p) { ?>
						<tr>
							<td data-label="ด่าน"><?php echo $p['PORT_NAME'] ?></td>
							<?php foreach ($period as $d) {
								echo "<td data-label='" . $Mydate->date_eng2thai($d, 543, 'S', 'S') . "' align='right'>" . number_format(@$data[$p['PORT_ID']][$d]) . "</td>";
								
							} ?>
						</tr>
					<?php } ?>
					<tr>
						<td style="background-color: rgba(97, 190, 201, 1);"><b>รวมด่านอากาศ</b></td>
						<?php foreach ($port[2] as $p) {
							foreach ($period as $d) {
								@$sum[$d] += @$data[$p['PORT_ID']][$d];
								@$sum_type2[$d] += @$data[$p['PORT_ID']][$d];
							}
						} ?>
						<?php foreach ($period as $d) {
							echo "<td  style='background-color: rgba(97, 190, 201, 1);' align='right'> <b>" . number_format(@$sum_type2[$d]) . "</b> </td>";
						} ?>
					</tr>
					<?php foreach ($port[2] as $p) { ?>
						<tr>
							<td data-label="ด่าน"><?php echo $p['PORT_NAME'] ?></td>
							<?php foreach ($period as $d) {
								echo "<td data-label='" . $Mydate->date_eng2thai($d, 543, 'S', 'S') . "'  align='right'>" . number_format(@$data[$p['PORT_ID']][$d]) . "</td>";
								
							} ?>
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td style='background-color: rgba(97, 190, 201, 1);'><b>รวมทั้งหมด</b></td>
						<?php foreach ($period as $d) {
							echo "<td   style='background-color: rgba(97, 190, 201, 1);' align='right'> <b>" . number_format(@$sum[$d]) . "</b> </td>";
						} ?>
					</tr>
				</tfoot>
			</table>
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
			endDate: new Date('<?php echo $to_date; ?>')
		});
	});

	function ChangeDate() {
		var date = $('#report_data1').val();
		date = date.split('/');
		report_date1 = (date[2] - 543) + '-' + date[1] + '-' + date[0];

		var date = $('#report_data2').val();
		date = date.split('/');
		report_date2 = (date[2] - 543) + '-' + date[1] + '-' + date[0];

		window.location.href = base_url + '/report/port_daily?d1=' + report_date1 + '&d2=' + report_date2;
	}

	function export_report(type) {
		var date = $('#report_data1').val();
		date = date.split('/');
		report_date1 = (date[2] - 543) + '-' + date[1] + '-' + date[0];

		var date = $('#report_data2').val();
		date = date.split('/');
		report_date2 = (date[2] - 543) + '-' + date[1] + '-' + date[0];

		window.open(base_url + '/report/port_daily/?export_type=' + type + '&d1=' + report_date1 + '&d2=' + report_date2);
	}
</script>
<?= $this->endSection() ?>