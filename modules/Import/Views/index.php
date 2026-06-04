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

<?php
	// ---------- ปฏิทินสถานะการนำเข้าข้อมูล ----------
	$month_th = array(1=>"มกราคม",2=>"กุมภาพันธ์",3=>"มีนาคม",4=>"เมษายน",5=>"พฤษภาคม",6=>"มิถุนายน",7=>"กรกฎาคม",8=>"สิงหาคม",9=>"กันยายน",10=>"ตุลาคม",11=>"พฤศจิกายน",12=>"ธันวาคม");
	$days_in_month = cal_days_in_month(CAL_GREGORIAN, $cal_month, $cal_year);
	$first_dow = (int)date('w', mktime(0, 0, 0, $cal_month, 1, $cal_year)); // 0=อาทิตย์
	$today = date('Y-m-d');
?>
<style>
	.import-cal { width: 100%; table-layout: fixed; border-collapse: separate; border-spacing: 4px; }
	.import-cal th { text-align: center; padding: 6px 0; color: #2a7a80; }
	.import-cal td { border-radius: .5em; padding: 6px 8px; vertical-align: top; height: 72px; }
	.import-cal td.cal-has { background: #d9f2e3; border: 1px solid #9fd9b4; }
	.import-cal td.cal-miss { background: #fbe3e4; border: 1px solid #f0b6b9; }
	.import-cal td.cal-future, .import-cal td.cal-empty { background: #f4f5f6; border: 1px solid #e8e9ea; }
	.import-cal td.cal-today { outline: 2px solid #379fa6; }
	.import-cal .cal-day { font-weight: bold; }
	.import-cal .cal-sum { font-size: .95em; text-align: right; color: #1d6f3f; }
	.import-cal td.cal-miss .cal-sum { color: #b52222; }
	.import-cal .cal-at { font-size: .72em; color: #777; text-align: right; line-height: 1.2; }
	.import-cal a.cal-link { display: block; color: inherit; text-decoration: none; }
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6 col-6">ปฏิทินสถานะการนำเข้าข้อมูล (นักท่องเที่ยวต่างชาติขาเข้า)</div>
					<div class="col-md-6 col-6" style="text-align:right;">
						<a class="btn btn-sm btn-outline-secondary" href="<?= base_url('import') ?>?cm=<?= $cal_prev ?>">&laquo; เดือนก่อน</a>
						<span style="padding: 0 10px; font-weight: bold;"><?= $month_th[$cal_month] ?> <?= $cal_year + 543 ?></span>
						<a class="btn btn-sm btn-outline-secondary" href="<?= base_url('import') ?>?cm=<?= $cal_next ?>">เดือนถัดไป &raquo;</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<table class="import-cal">
					<thead>
						<tr><th>อา</th><th>จ</th><th>อ</th><th>พ</th><th>พฤ</th><th>ศ</th><th>ส</th></tr>
					</thead>
					<tbody>
						<tr>
						<?php for ($i = 0; $i < $first_dow; $i++) echo '<td class="cal-empty"></td>'; ?>
						<?php
						$col = $first_dow;
						for ($d = 1; $d <= $days_in_month; $d++) {
							$date_str = sprintf('%04d-%02d-%02d', $cal_year, $cal_month, $d);
							$cell = $cal_data[$d] ?? null;
							$is_future = ($date_str > $cal_max_date);

							if ($cell && $cell['sum'] > 0) { $cls = 'cal-has'; }
							elseif ($is_future) { $cls = 'cal-future'; }
							else { $cls = 'cal-miss'; }
							if ($date_str === $today) { $cls .= ' cal-today'; }

							$title = '';
							if (!empty($cell['imported_at'])) {
								$title = 'นำเข้าล่าสุด ' . $cell['imported_at'];
								if (!empty($cell['imported_by'])) { $title .= ' โดย ' . $cell['imported_by']; }
								if ($cell['import_count'] > 1) { $title .= ' (นำเข้า ' . $cell['import_count'] . ' ครั้ง)'; }
							}

							echo '<td class="' . $cls . '" title="' . esc($title) . '">';
							echo '<a class="cal-link" href="' . base_url('import') . '?d=' . $date_str . '&cm=' . sprintf('%04d-%02d', $cal_year, $cal_month) . '">';
							echo '<div class="cal-day">' . $d . '</div>';
							if ($cell && $cell['sum'] > 0) {
								echo '<div class="cal-sum">' . number_format($cell['sum']) . '</div>';
							} elseif (!$is_future) {
								echo '<div class="cal-sum">ไม่มีข้อมูล</div>';
							}
							if (!empty($cell['imported_at'])) {
								echo '<div class="cal-at">นำเข้า ' . esc($cell['imported_at']) . '</div>';
							}
							echo '</a></td>';

							$col++;
							if ($col % 7 == 0 && $d < $days_in_month) { echo '</tr><tr>'; }
						}
						while ($col % 7 != 0) { echo '<td class="cal-empty"></td>'; $col++; }
						?>
						</tr>
					</tbody>
				</table>
				<div style="padding-top:8px; font-size:.85em; color:#666;">
					<span style="background:#d9f2e3; border:1px solid #9fd9b4; padding:1px 10px; border-radius:.4em;">&nbsp;</span> มีข้อมูลแล้ว (ตัวเลข = นักท่องเที่ยวต่างชาติขาเข้าจาก Raw Data)
					&nbsp; <span style="background:#fbe3e4; border:1px solid #f0b6b9; padding:1px 10px; border-radius:.4em;">&nbsp;</span> ยังไม่มีข้อมูล
					&nbsp; <span style="background:#f4f5f6; border:1px solid #e8e9ea; padding:1px 10px; border-radius:.4em;">&nbsp;</span> ยังไม่ถึงกำหนด
					&nbsp;&nbsp; คลิกวันเพื่อดู Raw Data ของวันนั้น
				</div>
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

		<?php if(!$check_ratio_port){ ?>
		Swal.fire({
		  title: "ท่านยังไม่ได้จัดการสัดส่วนด่าน",
		  text: "กรุณาจัดการสัดส่วนของด่าน",
		  icon: "warning"
		});
		<?php }?>

	});
</script>
<?= $this->endSection() ?>