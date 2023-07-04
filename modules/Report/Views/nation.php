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

	if ($v['NUM'] == 0) {
		$numberDay[$v['COUNTRY_ID']] = '';
	} else {
		$numberDay[$v['COUNTRY_ID']] = $i++;
	}
}

$i = 1;
foreach ($data_month_lastyear as $v) {

	if ($v['NUM'] == 0) {
		$numberMonth[$v['COUNTRY_ID']] = '';
	} else {
		$numberMonth[$v['COUNTRY_ID']] = $i++;
	}
}
?>

<style>
	@media screen and (max-width: 600px) {
		.table-responsive {
			overflow-x: auto !important;
		}
	}

	.table-responsive {
		overflow-x: inherit;
	}

	.radiusTable1 {
		border-radius: 1em;
		overflow: hidden;

	}



	.radiusTable1 tbody tr:nth-of-type(odd) {
		background-color: #D6EFF2;

	}

	.radiusTable1 tbody tr:nth-of-type(even) {
		background-color: white;

	}

	.radiusTable2 tbody tr:nth-of-type(even) {
		background-color: white;

	}

	.radiusTable1 thead th {
		background: #70D3DE;

	}

	.radiusTable2 {
		border-radius: 1em;
		overflow: hidden;

	}

	.radiusTable2 tbody tr:nth-of-type(odd) {
		background-color: #FFE4C8;

	}

	.radiusTable2 thead th {
		background: #FACE74;
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

<div class="row m-0">
	<div class="col-md-6 col-12" >
		
	</div>
	<div class="col-md-6 col-12 py-2 py-md-0" style="text-align: right;">
		<a target="_blank" href="<?php echo base_url('report/nation/?export_type=excel&d=' . $to_date); ?>" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" href="<?php echo base_url('report/nation/?export_type=pdf&d=' . $to_date); ?>" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	<div class="col-md-12 col-12 text-center py-2" style="font-size: 1.4em;">
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายสัญชาติ วันที่ :
		<input type="text" name="report_data" id="report_data" class="form-control date_picker" style="width: 200px;display: inline;" value="<?php echo $Mydate->date_thai2eng($to_date_label, 543, '/') ?> ">
	</div>
</div>

<div class="row m-0">
	<div class="col-md-6 pb-3 col-12">
		<div class="pt-4 py-2" style="text-align:center; font-size:15px">
			ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543); ?>
		</div>
		<div class="table-responsive shadow-lg">
			<table class="table table-striped  radiusTable1 " id="table1" style="">
				<thead style="font-weight:bold;">
					<tr>
						<th width="5%">ลำดับ<br><?php echo $year + 543; ?></th>
						<th width="5%">ลำดับ<br><?php echo $year + 542; ?></th>
						<th>สัญชาติ</th>
						<th width="20%">จำนวนนักท่องเที่ยว (คน)</th>
						<th width="10%">สัดส่วน (%)</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (!empty($data_day)) {
						$sum_other = 0;
						$i = 1;
						foreach ($data_day as $k => $v) {
							$icon = '';
							if ($i <= 50) {
								if (!empty($numberDay[$v['COUNTRY_ID']])) {
									if ($i == $numberDay[$v['COUNTRY_ID']]) {
										$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">(' . $numberDay[$v['COUNTRY_ID']] . ')</span>';
									} else if ($i < $numberDay[$v['COUNTRY_ID']]) {
										$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">(' . $numberDay[$v['COUNTRY_ID']] . ')</span>';
									} else if ($i > $numberDay[$v['COUNTRY_ID']]) {
										$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">(' . $numberDay[$v['COUNTRY_ID']] . ')</span>';
									}
								}

					?>
								<tr>
									<td align="center"> <b><?php echo $i++ ?></b> </td>
									<td align="center"> <?php echo @$numberDay[$v['COUNTRY_ID']] ?> </td>
									<td> <?php echo $v['COUNTRY_NAME_EN'] ?> </td>
									<td align="right"> <?php echo number_format($v['NUM']); ?> </td>
									<td align="right"> <?php echo number_format($v['NUM'] / $sumDay * 100, 2); ?></td>
								</tr>
						<?php } else {
								$sum_other += $v['NUM'];
							}
						} ?>
				</tbody>
				<tfoot>
					<tr>
						<td align="center"></td>
						<td align="center"></td>
						<td> Other </td>
						<td style="text-align:right;"> <?php echo number_format($sum_other); ?> </td>
						<td style="text-align:right;"> <?php echo number_format($sum_other / $sumMonth * 100, 2); ?></td>
					</tr>
				</tfoot>
			<?php } ?>
			</table>
		</div>
		<span style="font-size:0.8em">* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)</span>
	</div>
	<div class="col-md-6 pb-3 col-12">
		<div class="pt-4 py-2" style="text-align:center; font-size:15px">
			สะสม วันที่ 1 ม.ค. - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?>
		</div>
		<div class="table-responsive shadow-lg">
			<table class="table table-striped shadow-lg  radiusTable2" id="table2">
				<thead>
					<tr>
						<th width="5%">ลำดับ<br><?php echo $year + 543; ?></th>
						<th width="5%">ลำดับ<br><?php echo $year + 542; ?></th>
						<th>สัญชาติ</th>
						<th width="20%">จำนวนนักท่องเที่ยว (คน)</th>
						<th width="10%">สัดส่วน (%)</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($data_month)) {
						$sum_other = 0;
						$i = 1;
						foreach ($data_month as $k => $v) {
							$icon = '';
							if ($i <= 50) {
								if (!empty($numberMonth[$v['COUNTRY_ID']])) {
									if ($i == $numberMonth[$v['COUNTRY_ID']]) {
										$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['COUNTRY_ID']] . ')</span>';
									} else if ($i < $numberMonth[$v['COUNTRY_ID']]) {
										$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['COUNTRY_ID']] . ')</span>';
									} else if ($i > $numberMonth[$v['COUNTRY_ID']]) {
										$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['COUNTRY_ID']] . ')</span>';
									}
								}
					?>
								<tr>
									<td align="center"> <b><?php echo $i++ ?></b> </td>
									<td align="center"> <?php echo @$numberMonth[$v['COUNTRY_ID']] ?> </td>
									<td> <?php echo $v['COUNTRY_NAME_EN'] ?> </td>
									<td align="right"> <?php echo number_format($v['NUM']); ?> </td>
									<td align="right"> <?php echo number_format($v['NUM'] / $sumMonth * 100, 2); ?></td>
								</tr>
						<?php  } else {
								$sum_other += $v['NUM'];
							}
						} ?>
				</tbody>
				<tfoot>
					<tr>
						<td align="center"></td>
						<td align="center"></td>
						<td> Other </td>
						<td style="text-align:right;"> <?php echo number_format($sum_other); ?> </td>
						<td style="text-align:right;"> <?php echo number_format($sum_other / $sumMonth * 100, 2); ?></td>
					</tr>
				</tfoot>
			<?php } ?>
			</table>
		</div>
	</div>
	<!-- <span style="font-size:0.8em">* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)</span> -->
</div>

<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript" src="https://cdn.sheetjs.com/xlsx-0.18.9/package/dist/xlsx.full.min.js"></script>
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
			window.location.href = base_url + '/report/nation?d=' + report_date;
		});
		$('#table1').DataTable({
			responsive: true,
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

	function js_excel(){
		var elt = document.getElementById('table2');
		var wb = XLSX.utils.table_to_book(elt, { sheet: "DRE" }); 
		XLSX.writeFile(wb, "issue2535.xlsx")
	}
</script>
<?= $this->endSection() ?>