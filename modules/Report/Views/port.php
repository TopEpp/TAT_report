<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
<?php
$sumDay = 0;
foreach ($data_day as $k => $subArray) {
	$sumDay += $subArray['NUM'];
}
$sumDay = ceil($sumDay);

$sumMonth = 0;
foreach ($data_month as $k => $subArray) {
	$sumMonth += $subArray['NUM'];
}
$sumMonth = ceil($sumMonth);

$report_date = $Mydate->date_eng2thai($to_date, 543);

$numberDay = $numberMonth = array();
$i = 1;
foreach ($data_day_lastyear as $v) {
	$numberDay[$v['PORT_ID']] = $i++;
}

$i = 1;
foreach ($data_month_lastyear as $v) {
	$numberMonth[$v['PORT_ID']] = $i++;
}
?>
<style>
	.radiusTable1 {
		border-radius: 1em;
		overflow: hidden;
		/* background-color: red; */
	}

	.radiusTable1 tbody tr:nth-of-type(odd) {
		background-color: #D6EFF2;

	}

	.radiusTable1 thead th {
		background: #70D3DE;
		/* font-weight:bold; */
	}

	.radiusTable2 {
		border-radius: 1em;
		overflow: hidden;
		/* background-color: red; */
	}

	.radiusTable2 tbody tr:nth-of-type(odd) {
		background-color: #FFE4C8;
	}

	.radiusTable2 thead th {
		background: #FACE74;
	}
</style>
<div class="row">
	<div class="col-md-6 col-12 text-center text-md-left" style="font-size: 1.4em;">
		<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
	</div>
	<div class="col-md-6 col-12 py-2 py-md-0" style="text-align: right;">
		<a target="_blank" href="<?php echo base_url('report/port/?export_type=excel&d=' . $to_date); ?>" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" href="<?php echo base_url('report/port/?export_type=pdf&d=' . $to_date); ?>" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	<div class="col-md-12 text-center py-2">
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายด่าน วันที่ :
		<input type="text" name="report_data" id="report_data" class="form-control date_picker" style="width: 200px;display: inline;" value="<?php echo $Mydate->date_thai2eng($to_date_label, 543, '/') ?> ">
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-12 py-2">
		<div style="text-align:center;" class="py-2 pt-4">
			ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543); ?>
		</div>
		<table class="table table-striped radiusTable1 shadow-lg" id="table1" style="border-bottom:none">
			<thead>
				<tr>
					<th>ลำดับ<br><?php echo $year + 543; ?></th>
					<th>ลำดับ<br><?php echo $year + 542; ?></th>
					<th>ด่าน</th>
					<th>จำนวนนักท่องเที่ยว</th>
					<th>สัดส่วน</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($data_day as $k => $v) {
					$icon = '';
					if (!empty($numberDay[$v['PORT_ID']])) {
						if ($i == $numberDay[$v['PORT_ID']]) {
							$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">(' . $numberDay[$v['PORT_ID']] . ')</span>';
						} else if ($i < $numberDay[$v['PORT_ID']]) {
							$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">(' . $numberDay[$v['PORT_ID']] . ')</span>';
						} else if ($i > $numberDay[$v['PORT_ID']]) {
							$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">(' . $numberDay[$v['PORT_ID']] . ')</span>';
						}
					}

				?>
					<tr>
						<td align="center"> <b><?php echo $i++ ?></b> </td>
						<td align="center"> <?php echo @$numberDay[$v['PORT_ID']] ?> </td>
						<td> <?php echo $v['PORT_NAME'] ?> </td>
						<td align="right"> <?php echo number_format($v['NUM']); ?> </td>
						<td align="center"> <?php if ($sumDay > 0) {
												echo number_format($v['NUM'] / $sumDay * 100, 2);
											} ?> %</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<span style="font-size:0.8em">* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)</span>
	</div>
	<div class="col-md-6 col-12 py-2">
		<div style="text-align:center;" class="py-2 pt-4">
			สะสม วันที่ 1 ม.ค. - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?>
		</div>
		<table class="table table-striped radiusTable2 shadow-lg" id="table2" style="border-bottom:none">
			<thead>
				<tr>
					<th>ลำดับ<br><?php echo $year + 543; ?></th>
					<th>ลำดับ<br><?php echo $year + 542; ?></th>
					<th>ด่าน</th>
					<th>จำนวนนักท่องเที่ยว</th>
					<th>สัดส่วน</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach ($data_month as $k => $v) {
					$icon = '';
					if (!empty($numberMonth[$v['PORT_ID']])) {
						if ($i == $numberMonth[$v['PORT_ID']]) {
							$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['PORT_ID']] . ')</span>';
						} else if ($i < $numberMonth[$v['PORT_ID']]) {
							$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['PORT_ID']] . ')</span>';
						} else if ($i > $numberMonth[$v['PORT_ID']]) {
							$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['PORT_ID']] . ')</span>';
						}
					}
				?>
					<tr>
						<td align="center"> <b><?php echo $i++ ?></b> </td>
						<td align="center"> <?php echo @$numberMonth[$v['PORT_ID']] ?> </td>
						<td> <?php echo $v['PORT_NAME'] ?> </td>
						<td align="right"> <?php echo number_format($v['NUM']); ?> </td>
						<td align="center"> <?php if ($sumMonth > 0) {
												echo number_format($v['NUM'] / $sumMonth * 100, 2);
											} ?> %</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<span style="font-size:0.8em">* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)</span>
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

		$('.date_picker').change(function() {
			var date = this.value;
			date = date.split('/');
			report_date = (date[2] - 543) + '-' + date[1] + '-' + date[0];

			window.location.href = base_url + '/report/port?d=' + report_date;
		});

		$('#table1').DataTable({
			paging: false,
			searching: false,
			info: false,
			order: [
				[3, 'desc']
			],
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

		$('#table2').DataTable({
			paging: false,
			searching: false,
			info: false,
			order: [
				[3, 'desc']
			],
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