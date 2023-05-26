<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
<style>
	@media screen and (max-width: 600px) {
		.radiusTable1 {
			width: 100%;
			border-radius: 0px !important;
			overflow: hidden;
		}

		.radiusTable2 {
			border-radius: 0px !important;
			overflow: hidden;
		}


	}

	.radiusTable1 {
		/* border-radius: 1em; */
		overflow: hidden;

	}

	.radiusTable1 tbody tr:nth-of-type(odd) {
		background: rgba(255, 224, 226, 1);
	}

	.radiusTable1 tbody tr:nth-of-type(even) {
		background: white;
	}

	.table thead th {
		border-bottom: none;
	}

	.radiusTable1 thead th {
		background: rgba(253, 163, 169, 1);
		padding: 16px
			/* font-weight:bold; */
	}



	.radiusTable2 {
		/* border-radius: 1em; */
		overflow: hidden;
		/* background-color: red; */
	}

	.radiusTable2 tbody tr:nth-of-type(odd) {
		background: rgba(209, 200, 255, 1);
	}

	.radiusTable2 tbody tr:nth-of-type(even) {
		background: white
	}

	.table thead th {
		border-bottom: none;
	}

	.radiusTable2 thead th {
		background: rgba(147, 125, 255, 1);
		padding: 16px
			/* font-weight:bold; */
	}

	.table.dataTable tbody th,
	table.dataTable tbody td {
		padding: 0.26rem;
	}

	::-webkit-scrollbar {
		display: none;
	}

	table.dataTable thead>tr>th.sorting,
	table.dataTable thead>tr>th.sorting_asc,
	table.dataTable thead>tr>th.sorting_desc,
	table.dataTable thead>tr>th.sorting_asc_disabled,
	table.dataTable thead>tr>th.sorting_desc_disabled,
	table.dataTable thead>tr>td.sorting,
	table.dataTable thead>tr>td.sorting_asc,
	table.dataTable thead>tr>td.sorting_desc,
	table.dataTable thead>tr>td.sorting_asc_disabled,
	table.dataTable thead>tr>td.sorting_desc_disabled {
		padding: 15.8px 26px;
	}

	table.dataTable thead th,
	table.dataTable thead td {
		border-bottom: 0px;
	}

	table.dataTable {
		margin-top: 0px !important;
	}

	.dataTables_wrapper.no-footer .dataTables_scrollBody {
		border-bottom: 0px
	}

	.dataTables_scrollHead {
		overflow-x: auto !important;
	}
</style>
<div class="row m-0">
	<div class="col-md-6 text-center text-md-left" style="font-size: 1.4em;">
		<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
	</div>
	<div class="col-md-6 col-12 py-2 py-md-0" style="text-align: right;">
		<a target="_blank" onclick="export_report('excel')" class="btn btn-success " style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" onclick="export_report('pdf')" class="btn btn-danger " style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	<div class="col-md-12 text-center py-3">
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย จำแนกรายตลาด (ตลาดระยะใกล้ - ตลาดระยะไกล)
	</div>
</div>
<div class="row">
	<div class="col-md-2">

	</div>
	<div class="col-md-4 col-12 py-2 py-md-0">
		วันที่เริ่มต้น <input type="text" name="date_start" id="date_start" class="form-control date_picker" style="display: inline;" value="<?php echo $Mydate->date_thai2eng($date_start, 543, '/') ?>">
	</div>
	<div class="col-md-4 col-12 py-2 py-md-0">
		วันที่สิ้นสุด <input type="text" name="date_end" id="date_end" class="form-control date_picker" style="display: inline;" value="<?php echo $Mydate->date_thai2eng($date_end, 543, '/') ?>">
	</div>
	<div class="col-md-2 col-12 text-center text-md-left mt-auto py-2 py-md-0">
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>
</div>
<!-- <div class="d-flex justify-content-center py-2 pb-3 flex-column flex-md-row">
	<div class="d-flex align-items-center mx-md-2 mx-auto">
	วันที่เริ่มต้น <input type="text" name="date_start" id="date_start" class="form-control date_picker ml-2" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($date_start, 543, '/') ?>">
	</div>
	<div class="d-flex align-items-center mx-md-2 mx-auto my-2 my-md-none">
	วันที่สิ้นสุด <input type="text" name="date_end" id="date_end" class="form-control date_picker ml-2" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($date_end, 543, '/') ?>">
	</div>
	<div class="align-items-center mx-md-2 mx-auto my-auto ">
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>
</div> -->

<div class="row">
	<div class="col-md-6 col-12" style="text-align:center;">
		<label class="py-2 font-weight-bold">ตลาดระยะใกล้ (Short Haul)</label>
		<div class="table-responsive">
			<table class="table table-striped radiusTable1 shadow-lg" id="table1">
				<thead>
					<tr>
						<th style="width: 10%; border-top-left-radius: 6px;">ลำดับ</th>
						<th style="width: 40%;">สัญชาติ</th>
						<th style="width: 30%;">จำนวนนักท่องเที่ยว (คน)</th>
						<th style="width: 20%; border-top-right-radius: 6px ;">สัดส่วน (%)</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0;
					foreach ($country['Short'] as $c) {
						$i++;
						$ratio = 0;
						if (@$data[$c['COUNTRYID']]['NUM'] > 0) {
							$ratio = @$data[$c['COUNTRYID']]['NUM'] / $data['SUM'] * 100;
						}
					?>
						<tr>
							<td data-label="ลำดับ"><?php echo $i ?></td>
							<td data-label="สัญชาติ" align="left"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
							<td data-label="จำนวนนักท่องเที่ยว" align="right"><?php echo @number_format(@$data[$c['COUNTRYID']]['NUM']) ?></td>
							<td data-label="สัดส่วน" align="center"><?php echo number_format($ratio, 2); ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-6 col-12" style="text-align:center;">
		<label class="py-2 font-weight-bold">ตลาดระยะไกล (Long Haul)</label>
		<div class="table-responsive">
			<table class="table radiusTable2 table-striped shadow-lg" id="table2">
				<thead>
					<tr>
						<th style="width: 10%; border-top-left-radius: 6px;">ลำดับ</th>
						<th style="width: 40%;">สัญชาติ</th>
						<th style="width: 30%;">จำนวนนักท่องเที่ยว (คน)</th>
						<th style="width: 20%; border-top-right-radius: 6px ;">สัดส่วน (%)</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0;
					foreach ($country['Long'] as $c) {
						$i++;
						$ratio = 0;
						if (@$data[$c['COUNTRYID']]['NUM'] > 0) {
							$ratio = @$data[$c['COUNTRYID']]['NUM'] / $data['SUM'] * 100;
						}
					?>
						<tr>
							<td data-label="ลำดับ"><?php echo $i ?></td>
							<td data-label="สัญชาติ" align="left"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
							<td data-label="จำนวนนักท่องเที่ยว" align="right"><?php echo @number_format(@$data[$c['COUNTRYID']]['NUM']) ?></td>
							<td data-label="สัดส่วน" align="center"><?php echo number_format($ratio, 2); ?></td>
						</tr>
					<?php } ?>
				</tbody>
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
			language: 'en-en',
		});
	});
	$('#table2').DataTable({
		paging: false,
		searching: false,
		info: false,
		scrollY: '970px',
		scrollCollapse: true,
		paging: false,
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
	}).columns.adjust();
	$('#table1').DataTable({
		paging: false,
		searching: false,
		info: false,
		scrollY: '970px',
		scrollCollapse: true,
		paging: false,
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
	}).columns.adjust();

	function ChangeFilter() {
		var date = $('#date_start').val();
		date = date.split('/');
		// start_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
		date_start = date[0] + '-' + date[1] + '-' + (date[2] - 543);

		var date = $('#date_end').val();
		date = date.split('/');
		// end_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
		date_end = date[0] + '-' + date[1] + '-' + (date[2] - 543);


		window.location.href = base_url + '/report/market?d1=' + date_start + '&d2=' + date_end;
	}

	function export_report(type) {
		var date = $('#date_start').val();
		date = date.split('/');
		// start_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
		date_start = date[0] + '-' + date[1] + '-' + (date[2] - 543);

		var date = $('#date_end').val();
		date = date.split('/');
		// end_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
		date_end = date[0] + '-' + date[1] + '-' + (date[2] - 543);

		window.open(base_url + '/report/market/?export_type=' + type + '&d1=' + date_start + '&d2=' + date_end);
	}
</script>
<?= $this->endSection() ?>