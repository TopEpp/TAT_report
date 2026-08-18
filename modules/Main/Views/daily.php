<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
<?php
// ผู้ใช้ที่ได้รับสิทธิ์เห็นปุ่ม Export (บันทึกเป็นรายงาน PDF)
// user นอกลิสต์จะเห็นปุ่ม "บันทึกภาพหน้าจอ" (capture เป็นไฟล์รูป) แทน
$EXPORT_WHITELIST = [
	'watcharakrit.yaem',
	'kittipong.prap',
	'narumol.kong',
	'natthakan.tonb',
	'chompunuch.saen',
	'sriwan.choo',
	'kom.sata',
	'peerapol.ratt',
	'iyakan.keam',
	'natchapol.phro',
];
$currentUsername = strtolower(trim((string) $session->get('username')));
$canExport = in_array($currentUsername, array_map('strtolower', $EXPORT_WHITELIST), true);
?>
<style type="text/css">
	.gm-style .gm-style-iw-c {
		padding: 0 !important;
	}

	.gm-ui-hover-effect {
		display: none !important;
	}

	.gm-style-iw-d {
		width: 200px;
		overflow: unset !important;
	}

	.button_close {
		position: absolute;
		z-index: 1;
		right: 0;
	}

	.btn_Color {
		background-color: #3eabae;
		color: white;
		width: 100%;
		border-radius: 1em;
	}

	.btn_Color:hover {
		background-color: #007c84;
		color: white;
	}

	.close {
		opacity: 0.8;
	}

	#resultsTable {
		background: #B6E2E9;
		border-radius: 25px !important;
		border-width: 5px !important;
		border-style: solid !important;
		border-color: #B6E2E9 !important;
		/*  width: 90%;  */
		padding-top: 3%;
		margin: 0px auto;
		float: none;
	}

	.headerFlex {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-content: center;
		flex-wrap: wrap;
	}

	.headerColumn {
		text-align: left;
	}

	.rounded-circle {
		border-radius: 50% !important;
	}

	@media (max-width: 576px) {
		.headerColumn {
			text-align: center;
		}

		.SetAlignInputleft1 {
			text-align: end;
			padding: 0px 10px 0px;
		}

		.SetAlignInputleft2 {
			text-align: start;
			padding: 0px 10px 0px;
		}

		.SetwidthInput1 {
			width: 120px;
			border-radius: 12px;
		}

		.SetwidthInput2 {
			width: 120px;
			margin-right: auto;
			border-radius: 12px;
		}

		.btn_Color {
			width: 120px;
			margin-right: auto;
			border-radius: 12px;
		}

		.SetSpaceBtn {
			padding: 10px 0px;
		}

		.SetAlingBtn1 {
			text-align: end;
		}

		.SetAlingBtn2 {
			text-align: start;
		}

		.SetWidthbtnExport {
			width: 260px !important;
		}
	}
</style>
<div class="py-2" style="" id="daily_filter_bar">
	<div class="d-flex flex-wrap align-items-center" style="gap: 10px;">
		<div style="font-size: 15px; white-space: nowrap;">เลือกช่วงเวลา</div>
		<input type="text" name="start_date" id="start_date" class="form-control date_picker"
			style="width: 130px; border-radius: 12px;" value="" placeholder="from">
		<input type="text" name="end_date" id="end_date" class="form-control date_picker"
			style="width: 130px; border-radius: 12px;" value="" placeholder="to" />
		<div class="btn btn_Color" onclick="ChangeFilter()"
			style="width: auto; padding-left: 24px; padding-right: 24px;">ตกลง</div>
		<div class="btn btn_Color" onclick="ClearFilter()"
			style="width: auto; padding-left: 24px; padding-right: 24px;">ล้างค่า</div>

		<div class="d-flex ml-auto" style="gap: 8px;">
			<?php if ($canExport) { ?>
				<button type="button"
					onclick="SaveImg2ExportPdf('<?php echo base_url('main/saveImg2Report'); ?>','<?php echo base_url('main/export_dashboard_view?start_date=' . $start_date . '&end_date=' . $end_date); ?>')"
					class="btn btn-danger"
					style="width: auto; border-radius: 1em; white-space: nowrap;">
					<i class="fa-solid fa-download"></i> Export Info
				</button>
			<?php } ?>
			<button type="button" id="btn_capture_screen" onclick="CaptureScreen()"
				class="btn btn-danger"
				style="width: auto; border-radius: 1em; white-space: nowrap;">
				<i class="fa-solid fa-camera"></i> Export Dashboard
			</button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 my-1">
		<div class="card" style="background-color: #3cacae; border-radius: 12px; height: 166.7px;">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="row" style="margin: 0px;">
							<div class="col-md-9 col-9">
								<div>
									<p style="font-size: 16px; margin: 0px; color: white;">
										จำนวนนักท่องเที่ยว (คน)
									</p>
								</div>
								<div style="font-size: 13px;  color: white;">
									วันที่ <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?>
								</div>
							</div>
							<div class="col-md-3 col-3 text-right">
								<img src="<?php echo base_url('public/img/carlender.png') ?>" alt=""
									style="width: 30px;" class="">
							</div>
							<div class="col-md-12 text-center">
								<h1 style="font-size: 47px; color: white;" class="my-3">
									<?php echo number_format($SumDateData); ?>
								</h1>
							</div>
							<div class="col-md-12">
								<div class="d-flex justify-content-center">
									<p class="mx-1 my-auto" style="margin: 0; color: white;">
										<?php
										if ($SumDateData_past > 0) {
											$percent = number_format(($SumDateData - $SumDateData_past) / $SumDateData_past * 100, 2);
											if ($SumDateData > $SumDateData_past) {
												echo '<img src="' . base_url('public/img/arrow.png') . '" alt="" style="width: 15px;"> เพิ่มขึ้น ' . $percent . ' % จากปีที่ผ่านมา';
											} else {
												echo '<img src="' . base_url('public/img/arrowDown.png') . '" alt="" style="width: 15px;"> ลดลง ' . $percent * (-1) . ' % จากปีที่ผ่านมา';
											}
										} else {
											echo '-';
										} ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="col-12 col-md-6 my-1">
		<div class="card" style="background-color: #d4e9ec; border-radius: 12px;">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="row" style="margin: 0px;">
							<div class="col-md-9 col-9">
								<div>
									<p style="font-size: 16px; margin: 0px; color: #4a899a;">
										จำนวนนักท่องเที่ยวสะสม (คน)
									</p>
								</div>
								<div style="font-size: 13px;  color: #4a899a;">
									วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> -
									<?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
								</div>
							</div>
							<div class="col-md-3 col-3 text-right">
								<img src="<?php echo base_url('public/img/donut.png') ?>" alt="" style="width: 30px;"
									class="">
							</div>
							<div class="col-md-12 text-center">
								<h1 style="font-size: 47px; color: #4a899a;" class="my-3">
									<?php echo number_format($SumMonthData); ?>
								</h1>
							</div>
							<div class="col-md-12">
								<div class="d-flex justify-content-center">
									<?php
									if ($SumMonthData_past > 0) {
										$percent = number_format(($SumMonthData - $SumMonthData_past) / $SumMonthData_past * 100, 2);
										if ($SumMonthData > $SumMonthData_past) {
											echo '<img src="' . base_url('public/img/arrow.png') . '" alt="" style="margin-right:5px;width: 15px;">  เพิ่มขึ้น ' . $percent . ' % จากปีที่ผ่านมา';
										} else {
											echo '<img src="' . base_url('public/img/arrowDown.png') . '" alt="" style="width: 15px;">  ลดลง ' . $percent * (-1) . ' % จากปีที่ผ่านมา';
										}
									} else {
										echo '-';
									} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<!-- <div class="card-header">จำนวนนักท่องเที่ยวรายวัน (คน)</div> -->
			<div class="card-body">
				<div class="text-center" id="htmltoimage_chart_daily" style="height:220px; padding:15px;">
					<canvas id="chart_main" height="220" style="height:220px !important"></canvas>
				</div>
				<div style="overflow: auto;">
					<table class="table table-striped table-bordered">
						<tr>
							<td align="center">ปี</td>
							<?php $chart_label = $chart_current = $chart_pre = array();
							foreach ($period as $d) { ?>
								<td align="center"><?php echo $Mydate->date_eng2thai($d, 'X', 'S');
								$chart_label[] = $Mydate->date_eng2thai($d, 'X', 'S'); ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td style="background-color: #3cacae;"><?php echo $year + 543 ?></td>
							<?php
							foreach ($period as $d) { ?>
								<td style="background:#3cacae" align="center"><?php echo number_format(@$SumChartData['current'][$d]);
								$chart_current[] = @$SumChartData['current'][$d] ? @$SumChartData['current'][$d] : null; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td><?php echo $year + 542 ?></td>
							<?php
							foreach ($period as $d) {
								$d_ex = explode('-', $d);
								$d_pre = ($d_ex[0] - 1) . '-' . $d_ex[1] . '-' . $d_ex[2]; ?>
								<td align="center"><?php echo number_format(@$SumChartData['past'][$d_pre]);
								$chart_pre[] = @$SumChartData['past'][$d_pre] ? @$SumChartData['past'][$d_pre] : null; ?></td>
							<?php } ?>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
// YoY สำหรับการ์ด ranking (spec หน้า 2): map ปีก่อน keyed by id + badge %
$buildPastMap = function ($rows, $key) {
	$m = [];
	foreach (($rows ?? []) as $r) $m[(int)$r[$key]] = (int)$r['NUM'];
	return $m;
};
$natDatePastMap   = $buildPastMap($SumNatDateData_past ?? [], 'COUNTRY_ID');
$natMonthPastMap  = $buildPastMap($SumNatMonthData_past ?? [], 'COUNTRY_ID');
$portDatePastMap  = $buildPastMap($SumPortDateData_past ?? [], 'OFFICE_ID');
$portMonthPastMap = $buildPastMap($SumPortMonthData_past ?? [], 'OFFICE_ID');
$yoyBadge = function ($cur, $past) {
	if ($past > 0) {
		$pct   = ($cur - $past) / $past * 100;
		$color = $pct >= 0 ? '#1a7d33' : '#c0392b';
		$sign  = $pct >= 0 ? '+' : '';
		return '<span style="float:right;font-size:0.85em;color:' . $color . ';font-weight:600;">(' . $sign . number_format($pct, 1) . '%)</span>';
	}
	return '<span style="float:right;font-size:0.85em;color:#999;">(-)</span>';
};
?>
<div class="row py-1">
	<div class="col-md-3 py-2 col-12">
		<div class="card" style="border-radius: 20px; overflow: hidden;">
			<div class="card-header pt-3 px-4" style="background-color: #3cacae; ">
				<span style="font-weight:bold; font-size: 16px; color: white;">จำแนกรายสัญชาติ (คน)</span><br>
				<span style="font-size:13px;  color: white;"><?php echo $Mydate->date_eng2thai($to_date, 543) ?></span>
			</div>
			<div class="card-body px-4" style="background: white; padding: 0; border-radius: 0.35rem;">
				<div style="padding:7px;">
					<?php $c = 0;
					$__pmap = $natDatePastMap; $__ik = 'COUNTRY_ID'; foreach ($SumNatDateData as $v) {
						$c++;
						$flag = base_url('public/img/logotat.png');

						if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
							$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
						}
						?>
						<div class="row" style="margin-bottom:4px;">
							<div class="col-md-3 col-3 my-auto" style="padding:0px">
								<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="width: 50px;">
							</div>
							<div class="col-md-9 col-9" style="padding-top: 15px;font-weight:bold;">
								<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
								<p>
									<?php echo number_format($v['NUM']); echo $yoyBadge((int)$v['NUM'], (int)(@$__pmap[(int)$v[$__ik]] ?? 0)); ?>
								</p>
								<div style="border-bottom: 2px solid gray;">

								</div>
							</div>
						</div>
						<?php if ($c == 5)
							break;
					} ?>
				</div>
			</div>
			<div class="card-footer" style="background-color: #3cacae;">
				<div class="text-center py-2" style="cursor: pointer; color: white;" onclick="openModalInfo(1)">
					Show All<i class="fa-solid fa-caret-down mx-2"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 py-2 col-12">
		<div class="card" style="border-radius: 20px; overflow: hidden;">
			<div class="card-header pt-3 px-4" style="background-color: #3cacae; ">
				<span style="font-weight:bold; font-size: 15px; color: white;">จำแนกรายสัญชาติสะสม (คน)</span><br>
				<span
					style="font-size:13px;  color: white;"><?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?>
					- <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></span>
			</div>
			<div class="card-body px-4" style="background: white; padding: 0; border-radius: 0.35rem;">
				<div style="padding:7px;">
					<?php $c = 0;
					$__pmap = $natMonthPastMap; $__ik = 'COUNTRY_ID'; foreach ($SumNatMonthData as $v) {
						$c++;
						$flag = base_url('public/img/logotat.png');

						if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
							$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
						}
						?>
						<div class="row" style="margin-bottom:4px;">
							<div class="col-md-3 col-3 my-auto" style="padding:0px">
								<!-- <img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="width: 100%;"> -->
								<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="width: 50px;">
							</div>
							<div class="col-md-9 col-9" style="padding-top: 15px;font-weight:bold;">
								<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
								<p>
									<?php echo number_format($v['NUM']); echo $yoyBadge((int)$v['NUM'], (int)(@$__pmap[(int)$v[$__ik]] ?? 0)); ?>
								</p>
								<div style="border-bottom: 2px solid gray;">

								</div>
							</div>
						</div>
						<?php if ($c == 5)
							break;
					} ?>
				</div>
			</div>
			<div class="card-footer" style="background-color: #3cacae;">
				<!-- <div class="text-center py-3" style="cursor: pointer; color: white;" onclick="openModalInfo(1)">
					Show All<i class="fa-solid fa-caret-down mx-2"></i>
				</div> -->
				<div class="py-2 text-center" style="cursor: pointer; color: white;" onclick="openModalInfo(2)">
					Show All<i class="fa-solid fa-caret-down mx-2"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 py-2 col-12">
		<div class="card" style="border-radius: 20px; overflow: hidden;">
			<div class="card-header pt-3 px-4" style="background-color: #d4e9ec; ">
				<span style="font-weight:bold; font-size: 16px; color: #3a4a4a;">จำแนกรายด่าน (คน)</span><br>
				<span
					style="font-size:13px;  color: #3a4a4a;"><?php echo $Mydate->date_eng2thai($to_date, 543) ?></span>
			</div>
			<div class="card-body px-4" style="background: white; padding: 0;">
				<div style="padding:7px;">
					<?php $c = 0;
					$__pmap = $portDatePastMap; $__ik = 'OFFICE_ID'; foreach ($SumPortDateData as $v) {
						$c++; ?>
						<div class="row" style="margin-bottom:4px;">
							<div class="col-md-3 col-3 my-auto" style="padding:0px">
								<?php if ($v['PORT_TYPE'] == 'ด่านอากาศ') {
									?>
									<img class="img-profile rounded-circle"
										src="<?php echo base_url('public/img/plan-02.png') ?>" style="width: 50px;">
									<?php
								} else {
									?>
									<img class="img-profile rounded-circle"
										src="<?php echo base_url('public/img/checkpoint-03.png') ?>" style="width: 50px;">
									<?php
								}
								?>
							</div>
							<div class="col-md-9 col-9" style="padding-top: 15px;font-weight:bold;">
								<span style="font-weight:bold; font-size: 0.9em;">
									<?php echo $v['PORT_NAME'] ?>
								</span>
								<p>
									<?php echo number_format($v['NUM']); echo $yoyBadge((int)$v['NUM'], (int)(@$__pmap[(int)$v[$__ik]] ?? 0)); ?>
								</p>
								<div style="border-bottom: 2px solid gray;">
								</div>
							</div>
						</div>
						<?php if ($c == 5)
							break;
					} ?>
				</div>
			</div>
			<div class="card-footer" style="background-color: #3cacae;">
				<div class="py-2 text-center" style="cursor: pointer; color: white;" onclick="openModalInfo(3)">
					Show All<i class="fa-solid fa-caret-down mx-2"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 py-2 col-12">
		<div class="card" style="border-radius: 20px; overflow: hidden;">
			<div class="card-header pt-3 px-4" style="background-color: #d4e9ec; ">
				<span style="font-weight:bold; font-size: 16px; color: #3a4a4a;">จำแนกรายด่านสะสม (คน)</span><br>
				<span
					style="font-size:13px;  color: #3a4a4a;"><?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?>
					- <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></span>
			</div>
			<div class="card-body px-4" style="background: white; padding: 0; border-radius: 0.35rem;">
				<div style="padding:7px;">
					<?php $c = 0;
					$__pmap = $portMonthPastMap; $__ik = 'OFFICE_ID'; foreach ($SumPortMonthData as $v) {
						$c++; ?>
						<div class="row" style="margin-bottom:4px;">
							<div class="col-md-3 col-3 my-auto" style="padding:0px">
								<?php if ($v['PORT_TYPE'] == 'ด่านอากาศ') {
									?>
									<img class="img-profile rounded-circle"
										src="<?php echo base_url('public/img/plan-02.png') ?>" style="width: 50px;">
									<?php
								} else {
									?>
									<img class="img-profile rounded-circle"
										src="<?php echo base_url('public/img/checkpoint-03.png') ?>" style="width: 50px;">
									<?php
								}
								?>
							</div>
							<div class="col-md-9 col-9" style="padding-top: 15px;font-weight:bold;">
								<span style="font-weight:bold; font-size: 0.9em;">
									<?php echo $v['PORT_NAME'] ?>
								</span>
								<p>
									<?php echo number_format($v['NUM']); echo $yoyBadge((int)$v['NUM'], (int)(@$__pmap[(int)$v[$__ik]] ?? 0)); ?>
								</p>
								<div style="border-bottom: 2px solid gray;">
								</div>
							</div>
						</div>
						<?php if ($c == 5)
							break;
					} ?>
				</div>
			</div>
			<div class="card-footer" style="background-color: #3cacae;">
				<div class="py-2 text-center" style="cursor: pointer; color: white;" onclick="openModalInfo(4)">
					Show All<i class="fa-solid fa-caret-down mx-2"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12 col-12 py-2">
				<div id="canvas_map" style="height: 470px; width:100%"></div>
			</div>
			<div class="col-md-12 col-12 py-2 ">
				<?php
				$dataRegionMap[1]['id'] = 13;
				$dataRegionMap[1]['name'] = 'ASEAN';
				$dataRegionMap[1]['valueDay'] = number_format(@$SumRegionDateData[13]);
				$dataRegionMap[1]['valueMonth'] = number_format(@$SumRegionMonthData[13]);
				$dataRegionMap[1]['latlong'] = '12.519780, 100.452300';
				$dataRegionMap[1]['color'] = '#ebabc0';
				$dataRegionMap[1]['marker'] = base_url('public/img/icon-map/asia.png');

				$dataRegionMap[2]['id'] = 15;
				$dataRegionMap[2]['name'] = 'NORTH-EAST ASIA';
				$dataRegionMap[2]['valueDay'] = number_format(@$SumRegionDateData[15] + @$SumRegionDateData[38]);
				$dataRegionMap[2]['valueMonth'] = number_format(@$SumRegionMonthData[15] + @$SumRegionMonthData[38]);
				$dataRegionMap[2]['latlong'] = '31.022402, 130.159335';
				$dataRegionMap[2]['color'] = '#f9c9b2';
				$dataRegionMap[2]['marker'] = base_url('public/img/icon-map/north_east_asia.png');

				$dataRegionMap[3]['id'] = 23;
				$dataRegionMap[3]['name'] = 'SOUTH ASIA';
				$dataRegionMap[3]['valueDay'] = number_format(@$SumRegionDateData[23] + @$SumRegionDateData[39]);
				$dataRegionMap[3]['valueMonth'] = number_format(@$SumRegionMonthData[23] + @$SumRegionMonthData[39]);
				$dataRegionMap[3]['latlong'] = '8.893284, 78.128085';
				$dataRegionMap[3]['color'] = '#ffffae';
				$dataRegionMap[3]['marker'] = base_url('public/img/icon-map/south_asia.png');

				$dataRegionMap[4]['id'] = 2;
				$dataRegionMap[4]['name'] = 'EUROPE';
				$dataRegionMap[4]['valueDay'] = number_format(@$SumRegionDateData[2] + @$SumRegionDateData[44] + @$SumRegionDateData[36] + @$SumRegionDateData[37]);
				$dataRegionMap[4]['valueMonth'] = number_format(@$SumRegionMonthData[2] + @$SumRegionMonthData[44] + @$SumRegionMonthData[36] + @$SumRegionMonthData[37]);
				$dataRegionMap[4]['latlong'] = '47.135605, 7.464025';
				$dataRegionMap[4]['color'] = '#c6a7cb';
				$dataRegionMap[4]['marker'] = base_url('public/img/icon-map/europe.png');

				$dataRegionMap[5]['id'] = 37;
				$dataRegionMap[5]['name'] = 'EAST EUROPE';
				$dataRegionMap[5]['valueDay'] = number_format(@$SumRegionDateData[37] + @$SumRegionDateData[36]);
				$dataRegionMap[5]['valueMonth'] = number_format(@$SumRegionMonthData[37] + @$SumRegionMonthData[36]);
				$dataRegionMap[5]['latlong'] = '52.781213, 33.479648';
				$dataRegionMap[5]['color'] = '#e8d4e2';
				$dataRegionMap[5]['marker'] = base_url('public/img/icon-map/east_europe.png');

				$dataRegionMap[6]['id'] = 7;
				$dataRegionMap[6]['name'] = 'THE AMERICAS';
				$dataRegionMap[6]['valueDay'] = number_format(@$SumRegionDateData[7] + @$SumRegionDateData[45]);
				$dataRegionMap[6]['valueMonth'] = number_format(@$SumRegionMonthData[7] + @$SumRegionMonthData[45]);
				$dataRegionMap[6]['latlong'] = '20.434802, -100.114100';
				$dataRegionMap[6]['color'] = '#64b5da';
				$dataRegionMap[6]['marker'] = base_url('public/img/icon-map/the_americas.png');

				$dataRegionMap[7]['id'] = 5;
				$dataRegionMap[7]['name'] = 'OCEANIA';
				$dataRegionMap[7]['valueDay'] = number_format(@$SumRegionDateData[5] + @$SumRegionDateData[46]);
				$dataRegionMap[7]['valueMonth'] = number_format(@$SumRegionMonthData[5] + @$SumRegionMonthData[46]);
				$dataRegionMap[7]['latlong'] = '-30.781896, 144.749177';
				$dataRegionMap[7]['color'] = '#b2dfe8';
				$dataRegionMap[7]['marker'] = base_url('public/img/icon-map/oceania.png');

				$dataRegionMap[8]['id'] = 20;
				$dataRegionMap[8]['name'] = 'MIDDLE EAST';
				$dataRegionMap[8]['valueDay'] = number_format(@$SumRegionDateData[20] + @$SumRegionDateData[47]);
				$dataRegionMap[8]['valueMonth'] = number_format(@$SumRegionMonthData[20] + @$SumRegionMonthData[47]);
				$dataRegionMap[8]['latlong'] = '27.807562, 49.827303';
				$dataRegionMap[8]['color'] = '#9bc1a7';
				$dataRegionMap[8]['marker'] = base_url('public/img/icon-map/middle_east.png');

				$dataRegionMap[9]['id'] = 6;
				$dataRegionMap[9]['name'] = 'AFRICA';
				$dataRegionMap[9]['valueDay'] = number_format(@$SumRegionDateData[6] + @$SumRegionDateData[40]);
				$dataRegionMap[9]['valueMonth'] = number_format(@$SumRegionMonthData[6] + @$SumRegionMonthData[40]);
				$dataRegionMap[9]['latlong'] = '2.834002, 17.403791';
				$dataRegionMap[9]['color'] = '#b6c8c7';
				$dataRegionMap[9]['marker'] = base_url('public/img/icon-map/africa.png');

				?>
				<!-- <div id="resultsTable"> -->
				<div class="table-responsive" style="height:auto; overflow:auto; margin-bottom: 10px;">
					<table class="table table-striped "
						style="width: 100%; border-collapse: collapse !important; border: white;" border="1">
						<thead style=" background-color: #488a9a !important;">
							<tr>
								<th class="py-4" style="background-color: #488a9a;color:white;border-bottom: 0px;">
									Region</th>
								<th class="py-4" style="background-color: #488a9a;color:white;border-bottom: 0px;">
									<?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> -
									<?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
								</th>
								<th class="py-4" style="background-color: #488a9a;color:white;border-bottom: 0px;">%Change</th>
								<th class="py-4" style="background-color: #488a9a;color:white;border-bottom: 0px;">%Share</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Render Region table using Standard (ททท) hierarchy
							$stdTatColors = [
								'ASIA AND OCEANIA'                                    => '#BD98A1',
								'EAST ASIA'                                           => '#F9C9B2',
								'OTHERS IN EAST ASIA'                                 => '#FBE0C7',
								'SOUTH EAST ASIA'                                     => '#EBABC0',
								'OTHERS IN SOUTH EAST ASIA'                           => '#F6D3DE',
								'SOUTH ASIA'                                          => '#E6D77A',
								'OTHERS IN SOUTH ASIA'                                => '#FFFFAE',
								'OCEANIA'                                             => '#9BC1A7',
								'OTHERS IN OCEANIA'                                   => '#CFE3D6',
								'EUROPE, THE AMERICAS, MIDDLE EAST AND AFRICA'        => '#9E88B5',
								'EUROPE'                                              => '#C6A7CB',
								'OTHERS IN EUROPE'                                    => '#E9D4E2',
								'THE AMERICAS, MIDDLE EAST AND AFRICA'                => '#65B5DA',
								'OTHERS IN THE AMERICAS, MIDDLE EAST AND AFRICA'      => '#B2DFE8',
							];

							$lightenHex = function($hex, $amount = 0.45) {
								$hex = ltrim($hex, '#');
								if (strlen($hex) !== 6) return '#' . $hex;
								$r = hexdec(substr($hex, 0, 2));
								$g = hexdec(substr($hex, 2, 2));
								$b = hexdec(substr($hex, 4, 2));
								$r = (int)min(255, $r + (255 - $r) * $amount);
								$g = (int)min(255, $g + (255 - $g) * $amount);
								$b = (int)min(255, $b + (255 - $b) * $amount);
								return sprintf('#%02X%02X%02X', $r, $g, $b);
							};

							$walkSum = function($node, $map) use (&$walkSum) {
								$total = 0;
								if ($node['NODE_TYPE'] === 'COUNTRY' && !empty($node['COUNTRY_ID'])) {
									$total += (int)(@$map[(int)$node['COUNTRY_ID']] ?? 0);
								}
								foreach ($node['children'] ?? [] as $c) $total += $walkSum($c, $map);
								return $total;
							};

							// ยอดรวมทั้งหมด (ฐานของ %Share) คำนวณจาก tree เดียวกับแถว เพื่อให้ Total = 100%
							$grandTotalM = 0;
							$grandTotalM_past = 0;
							foreach (($dashboard_tree ?? []) as $top) {
								$grandTotalM      += $walkSum($top, $SumCountryMonthData);
								$grandTotalM_past += $walkSum($top, $SumCountryMonthData_past);
							}

							// สร้าง 2 <td>: %Change (YoY เทียบช่วงเดียวกันปีก่อน) + %Share (สัดส่วนต่อยอดรวม)
							$yoyShareCells = function($cur, $past, $total) {
								if ($past > 0) {
									$pct = ($cur - $past) / $past * 100;
									$color = $pct >= 0 ? '#1a7d33' : '#c0392b';
									$sign  = $pct >= 0 ? '+' : '';
									$change = '<span style="color:' . $color . ';font-weight:600;">' . $sign . number_format($pct, 1) . '%</span>';
								} else {
									$change = '<span style="color:#999;">-</span>';
								}
								$share = $total > 0 ? number_format($cur / $total * 100, 1) . '%' : '-';
								return '<td align="right">' . $change . '</td><td align="right">' . $share . '</td>';
							};

							$renderNode = function($node, $level, $bg) use (&$renderNode, &$walkSum, $lightenHex, $SumCountryDateData, $SumCountryMonthData, $SumCountryMonthData_past, $stdTatColors, $yoyShareCells, $grandTotalM) {
								// แสดงแถว "OTHERS IN xxx" ด้วย เพื่อให้ผลรวม parent = sub-region + others (spec หน้า 1)
								$id  = (int)$node['NODE_ID'];
								$pid = (int)($node['PARENT_NODE_ID'] ?? 0);
								$isOthers = ($node['IS_OTHERS'] ?? 'N') === 'Y';
								$sumM = $walkSum($node, $SumCountryMonthData);
								$sumM_past = $walkSum($node, $SumCountryMonthData_past);
								$extraCells = $yoyShareCells($sumM, $sumM_past, $grandTotalM);
								$padding = 15 + $level * 25;
								// โชว์แถว "OTHERS IN xxx" เสมอ (ไม่ยุบ) เพื่อให้ region = sub + others เห็นชัด · TAT office/ประเทศ ยังยุบคลิกขยาย
								$hideStyle = ($level >= 2 && !$isOthers) ? 'display:none;' : '';
								// OTHERS ไม่ผูก class parent_<subId> จะได้ไม่ถูกยุบตอน collapse sub-region
								$rowClass = 'tr_row ' . ($isOthers ? 'others_shown' : 'parent_' . $pid);
								// level 3 (ประเทศใต้ TAT office) ใช้สีจางกว่า level 2
								$rowBg = $level >= 3 ? $lightenHex($bg, 0.45) : $bg;

								if ($node['NODE_TYPE'] === 'COUNTRY') {
									echo '<tr class="' . $rowClass . '" data-node-id="' . $id . '" style="' . $hideStyle . 'background:' . $rowBg . ';">';
									echo '<td style="padding-left:' . $padding . 'px;">' . htmlspecialchars($node['NAME_EN']) . '</td>';
									echo '<td align="right">' . number_format($sumM) . '</td>';
									echo $extraCells;
									echo '</tr>';
								} else {
									$hasChildren = !empty($node['children']);
									$weight = $level === 0 ? 'bold' : ($node['NODE_TYPE'] === 'TAT_OFFICE' ? 'normal' : '600');
									$onclick = $hasChildren ? ' onclick="toggleChildren(' . $id . ')"' : '';
									$cursor  = $hasChildren ? 'cursor:pointer;' : '';
									echo '<tr class="' . $rowClass . '" data-node-id="' . $id . '"' . $onclick . ' style="' . $hideStyle . 'background:' . $rowBg . ';' . $cursor . '">';
									echo '<td style="padding-left:' . $padding . 'px;font-weight:' . $weight . ';">' . htmlspecialchars($node['NAME_EN']) . '</td>';
									echo '<td align="right">' . number_format($sumM) . '</td>';
									echo $extraCells;
									echo '</tr>';
									foreach ($node['children'] ?? [] as $c) {
										$childBg = $stdTatColors[$c['NAME_EN']] ?? $bg;
										$renderNode($c, $level + 1, $childBg);
									}
								}
							};

							foreach (($dashboard_tree ?? []) as $top) {
								$topBg = $stdTatColors[$top['NAME_EN']] ?? '#cccccc';
								$renderNode($top, 0, $topBg);
							}
							?>
							<?php /* OLD_REMOVED_START - สำรอง block เก่าออก
							<tr style="background:#EBABC0;">
								<td style="padding-left: 40px;">ASEAN</td>
								<td align="right"><?php echo number_format(@$SumRegionDateData[13]) ?></td>
								<td align="right"><?php echo number_format(@$SumRegionMonthData[13]) ?></td>
							</tr>
							<?php foreach ($country_region[13] as $c) { ?>
								<tr class="region_13 tr_country" style="display:none;background-color:#EBABC0;">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<tr style="background-color: #F9C9B2">
								<td style="padding-left: 40px;">NORTH-EAST ASIA</td>
								<td align="right">
									<?php echo number_format(@$SumRegionDateData[15] + @$SumRegionDateData[38]) ?>
								</td>
								<td align="right">
									<?php echo number_format(@$SumRegionMonthData[15] + @$SumRegionMonthData[38]) ?>
								</td>
							</tr>
							<?php foreach ($country_region[15] as $c) { ?>
								<tr class="region_15 tr_country" style="display:none;background-color: #F9C9B2">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<?php foreach ($country_region[38] as $c) { ?>
								<tr class="region_15 tr_country" style="display:none;background-color: #F9C9B2">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<tr style="background: #FFFFAE">
								<td style="padding-left: 40px;">SOUTH ASIA</td>
								<td align="right">
									<?php echo number_format(@$SumRegionDateData[23] + @$SumRegionDateData[39]) ?>
								</td>
								<td align="right">
									<?php echo number_format(@$SumRegionMonthData[23] + @$SumRegionMonthData[39]) ?>
								</td>
							</tr>
							<?php foreach ($country_region[23] as $c) { ?>
								<tr class="region_23 tr_country" style="display:none;background: #FFFFAE">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<?php foreach ($country_region[39] as $c) { ?>
								<tr class="region_23 tr_country" style="display:none;background: #FFFFAE">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<tr style="background: #C6A7CB">
								<td style="padding-left: 15px;">EUROPE</td>
								<td align="right">
									<?php echo number_format(@$SumRegionDateData[2] + @$SumRegionDateData[44] + @$SumRegionDateData[36] + @$SumRegionDateData[37]) ?>
								</td>
								<td align="right">
									<?php echo number_format(@$SumRegionMonthData[2] + @$SumRegionMonthData[44] + @$SumRegionMonthData[36] + @$SumRegionMonthData[37]) ?>
								</td>
							</tr>
							<?php foreach ($country_region[2] as $c) { ?>
								<tr class="region_2 tr_country" style="display:none;background: #C6A7CB">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<?php foreach ($country_region[44] as $c) { ?>
								<tr class="region_2 tr_country" style="display:none;background: #C6A7CB">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<?php foreach ($country_region[36] as $c) { ?>
								<tr class="region_2 tr_country" style="display:none;background: #C6A7CB">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<tr style="background: #E9D4E2">
								<td style="padding-left: 40px;">EAST EUROPE</td>
								<td align="right">
									<?php echo number_format(@$SumRegionDateData[37] + @$SumRegionDateData[36]) ?>
								</td>
								<td align="right">
									<?php echo number_format(@$SumRegionMonthData[37] + @$SumRegionMonthData[36]) ?>
								</td>
							</tr>
							<?php foreach ($country_region[37] as $c) { ?>
								<tr class="region_37 tr_country" style="display:none;background: #E9D4E2">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<?php foreach ($country_region[36] as $c) { ?>
								<tr class="region_37 tr_country" style="display:none;background: #E9D4E2">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<tr style="background: #65B5DA">
								<td style="padding-left: 15px;">THE AMERICAS</td>
								<td align="right">
									<?php echo number_format(@$SumRegionDateData[7] + @$SumRegionDateData[45]) ?>
								</td>
								<td align="right">
									<?php echo number_format(@$SumRegionMonthData[7] + @$SumRegionMonthData[45]) ?>
								</td>
							</tr>
							<?php foreach ($country_region[7] as $c) { ?>
								<tr class="region_7 tr_country" style="display:none;background: #65B5DA">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<?php foreach ($country_region[45] as $c) { ?>
								<tr class="region_7 tr_country" style="display:none;background: #65B5DA">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<tr style="background: #B2DFE8">
								<td style="padding-left: 15px;">OCEANIA</td>
								<td align="right">
									<?php echo number_format(@$SumRegionDateData[5] + @$SumRegionDateData[46]) ?>
								</td>
								<td align="right">
									<?php echo number_format(@$SumRegionMonthData[5] + @$SumRegionMonthData[46]) ?>
								</td>
							</tr>
							<?php foreach ($country_region[5] as $c) { ?>
								<tr class="region_5 tr_country" style="display:none;background: #B2DFE8">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<?php foreach ($country_region[46] as $c) { ?>
								<tr class="region_5 tr_country" style="display:none;background: #B2DFE8">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<tr style="background: #9CC1A7">
								<td style="padding-left: 15px;">MIDDLE EAST</td>
								<td align="right">
									<?php echo number_format(@$SumRegionDateData[20] + @$SumRegionDateData[47]) ?>
								</td>
								<td align="right">
									<?php echo number_format(@$SumRegionMonthData[20] + @$SumRegionMonthData[47]) ?>
								</td>
							</tr>
							<?php foreach ($country_region[20] as $c) { ?>
								<tr class="region_20 tr_country" style="display:none;background: #9CC1A7">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<?php foreach ($country_region[47] as $c) { ?>
								<tr class="region_20 tr_country" style="display:none;background: #9CC1A7">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<tr style="background: #B6C8C7">
								<td style="padding-left: 15px;">AFRICA</td>
								<td align="right">
									<?php echo number_format(@$SumRegionDateData[6] + @$SumRegionDateData[40]) ?>
								</td>
								<td align="right">
									<?php echo number_format(@$SumRegionMonthData[6] + @$SumRegionMonthData[40]) ?>
								</td>
							</tr>
							<?php foreach ($country_region[6] as $c) { ?>
								<tr class="region_6 tr_country" style="display:none;background: #B6C8C7">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<?php foreach ($country_region[40] as $c) { ?>
								<tr class="region_6 tr_country" style="display:none;background: #B6C8C7">
									<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?>
									</td>
									<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?>
									</td>
								</tr>
							<?php } ?>
							<tr style="background:#ECE9E4">
								<td style="padding-left: 15px;">STATELESS</td>
								<td align="right"><?php echo number_format(@$SumRegionDateData[29]) ?></td>
								<td align="right"><?php echo number_format(@$SumRegionMonthData[29]) ?></td>
							</tr>
							OLD_REMOVED_END */ ?>
						</tbody>
						<tfoot>
							<tr style="background: #488a9a;font-weight: bolder;">
								<td style="padding-left: 15px;">Total</td>
								<td align="right">
									<?php $sumMonth = 0;
									foreach ($SumRegionMonthData as $v) {
										$sumMonth += $v;
									}
									echo number_format($sumMonth) ?>
								</td>
								<?php
								// %Change (YoY) ของยอดรวม + %Share = 100%
								if ($grandTotalM_past > 0) {
									$pctTotal = ($grandTotalM - $grandTotalM_past) / $grandTotalM_past * 100;
									$colorTotal = $pctTotal >= 0 ? '#8ef0a5' : '#ffb3ab';
									$signTotal  = $pctTotal >= 0 ? '+' : '';
									echo '<td align="right" style="color:' . $colorTotal . ';">' . $signTotal . number_format($pctTotal, 1) . '%</td>';
								} else {
									echo '<td align="right">-</td>';
								}
								echo '<td align="right">100.0%</td>';
								?>
							</tr>
						</tfoot>
					</table>
					<div class="text-muted" style="font-size: 0.85em; padding: 6px 4px 0 4px; font-style: italic;">
						หมายเหตุ: จัดกลุ่มตามรูปแบบตารางมาตรฐาน (Standard Table) ของ ททท.
					</div>
					<!-- </div> -->
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalInfo1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
					<span style="font-size:0.8em">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543) ?></span>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="padding:10px;">
					<?php $json_nat = array();
					$c = 0;
					$__pmap = $natDatePastMap; $__ik = 'COUNTRY_ID'; foreach ($SumNatDateData as $v) {
						if ($v['NUM'] > 0) {
							$c++;
							$flag = base_url('public/img/logotat.png');

							if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
								$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
							}
							?>
							<div class="row" style="margin-bottom:10px;">
								<div class="col-md-2 col-2 text-center" style="padding:0px;font-size: 2.4em;">
									<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 54px;">
								</div>
								<div class="col-md-5 col-5 my-auto" style="padding-left:0;font-weight:bold;">
									<span
										style="font-weight:bold; font-size: 0.85em;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
								</div>
								<div class="col-md-5 col-5 my-auto" style="padding-left:0;font-weight:bold;">
									<?php echo number_format($v['NUM']); echo $yoyBadge((int)$v['NUM'], (int)(@$__pmap[(int)$v[$__ik]] ?? 0)); ?>
								</div>
							</div>
						<?php }
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalInfo2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
					<span style="font-size:0.8em">สะสม วันที่
						<?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> -
						<?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></span>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="padding:10px;">
					<?php $json_nat_month = array();
					$c = 0;
					$__pmap = $natMonthPastMap; $__ik = 'COUNTRY_ID'; foreach ($SumNatMonthData as $v) {
						if ($v['NUM'] > 0) {
							$c++;
							$flag = base_url('public/img/logotat.png');

							if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
								$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
							}
							?>
							<div class="row" style="margin-bottom:10px;">
								<div class="col-md-2 col-2 text-center" style="padding:0px;font-size: 2.4em;">
									<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 54px;">
								</div>
								<div class="col-md-5 col-5 my-auto" style="padding-left:0;font-weight:bold;">
									<span
										style="font-weight:bold; font-size: 0.85em;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
								</div>
								<div class="col-md-5 col-5 my-auto" style="padding-left:0;font-weight:bold;">
									<?php echo number_format($v['NUM']); echo $yoyBadge((int)$v['NUM'], (int)(@$__pmap[(int)$v[$__ik]] ?? 0)); ?>
								</div>
							</div>
						<?php }
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modalInfo3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<span style="font-weight:bold;">จำแนกรายด่าน</span><br>
					<span style="font-size:0.8em">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543) ?></span>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="padding:10px;">
					<?php $c = 0;
					$__pmap = $portDatePastMap; $__ik = 'OFFICE_ID'; foreach ($SumPortDateData as $v) {
						$c++; ?>
						<div class="row" style="margin-bottom:10px;">
							<div class="col-md-2 col-2 text-center" style="font-size: 2.4em; padding:0px">
								<?php if ($v['PORT_TYPE'] == 'ด่านอากาศ') {
									?>
									<img class="img-profile rounded-circle"
										src="<?php echo base_url('public/img/plan-02.png') ?>" style="height: 54px;">
									<?php
								} else {
									?>
									<img class="img-profile rounded-circle"
										src="<?php echo base_url('public/img/checkpoint-03.png') ?>" style="height: 54px;">
									<?php
								}
								?>
							</div>
							<div class="col-md-5 col-5 my-auto" style="font-weight:bold;">
								<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['PORT_NAME'] ?></span>
							</div>
							<div class="col-md-5 col-5 my-auto" style="font-weight:bold;">
								<?php echo number_format($v['NUM']); echo $yoyBadge((int)$v['NUM'], (int)(@$__pmap[(int)$v[$__ik]] ?? 0)); ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalInfo4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<span style="font-weight:bold;">จำแนกรายด่าน</span><br>
					<span style="font-size:0.8em">สะสม วันที่
						<?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> -
						<?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></span>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="padding:10px;">
					<?php $c = 0;
					$__pmap = $portMonthPastMap; $__ik = 'OFFICE_ID'; foreach ($SumPortMonthData as $v) {
						$c++; ?>
						<div class="row" style="margin-bottom:10px;">
							<div class="col-md-2 col-2" style="text-align:center; font-size: 2.4em; padding:0px">
								<?php if ($v['PORT_TYPE'] == 'ด่านอากาศ') {
									?>
									<img class="img-profile rounded-circle"
										src="<?php echo base_url('public/img/plan-02.png') ?>" style="height: 54px;">
									<?php
								} else {
									?>
									<img class="img-profile rounded-circle"
										src="<?php echo base_url('public/img/checkpoint-03.png') ?>" style="height: 54px;">
									<?php
								}
								?>
							</div>
							<div class="col-md-5 col-5 my-auto" style="font-weight:bold;">
								<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['PORT_NAME'] ?></span>
							</div>
							<div class="col-md-5 col-5 my-auto" style="font-weight:bold;">
								<?php echo number_format($v['NUM']); echo $yoyBadge((int)$v['NUM'], (int)(@$__pmap[(int)$v[$__ik]] ?? 0)); ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal_noti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<span style="font-weight:bold; font-size:1.2em">เรียน ผู้ใช้ข้อมูลทุกท่าน</span><br>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				บัดนี้ สตม ได้นำส่งข้อมูลของตั้งแต่วันที่ 26 มิถุนายน 2569 เป็นต้นมา ให้หน่วยงานต่างๆ เรียบร้อยแล้ว อย่างไรก็ตาม ยังขาดข้อมูลช่วงวันที่ 22–25 มิถุนายน 2569
				<br><br>
				ทั้งนี้ กวจ. ได้นำเข้าข้อมูลและ หากได้รับข้อมูลส่วนที่ขาดแล้ว กวจ. จะนำเข้าข้อมูลในระบบต่อไป
				<br><br>
				จึงเรียนมาเพื่อโปรดทราบ
			</div>
		</div>
	</div>
</div>



<div class="text-center" id="htmltoimage_chart_daily_year"
	style="height:220px; width: 1100px; padding:15px; display: none;">
	<canvas id="chart_main_year" height="220" style="height:220px !important"></canvas>
</div>
<?php $chart_label_year = $chart_current_year = $chart_pre_year = array();
$shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
for ($i = 1; $i <= 12; $i++) {
	$chart_label_year[] = $shortmonth[$i];
	$chart_current_year[] = @$SumChartDataYear['current'][$i] ? @$SumChartDataYear['current'][$i] : null;
	$chart_pre_year[] = @$SumChartDataYear['past'][$i] ? @$SumChartDataYear['past'][$i] : null;
}
?>

<?php $this->endSection() ?>
<?= $this->section("scripts") ?>
<script src="<?= base_url('public/js/script.js') ?>"></script>
<script src="<?php echo base_url('public/vendor/html2canvas/html2canvas.js'); ?>"></script>
<script src="<?php echo base_url('public/vendor/chart.js/Chart.min.js'); ?>" type="text/javascript"></script>
<script src="https://maps.google.com/maps/api/js?key=<?php echo $api_code; ?>&sensor=false&libraries=marker"></script>
<!-- <script type="text/javascript" src="https://unpkg.com/chartjs-chart-geo@3.5.2/build/index.umd.min.js"></script> -->

<script type="text/javascript">
	var chart_label = <?php echo json_encode($chart_label); ?>;
	var chart_current = <?php echo json_encode($chart_current); ?>;
	var chart_pre = <?php echo json_encode($chart_pre); ?>;

	var chart_label_year = <?php echo json_encode($chart_label_year); ?>;
	var chart_current_year = <?php echo json_encode($chart_current_year); ?>;
	var chart_pre_year = <?php echo json_encode($chart_pre_year); ?>;

	var dataRegionMap = <?php echo json_encode($dataRegionMap); ?>;

	// console.log(dataRegionMap);
	// import zoomPlugin from 'chartjs-plugin-zoom';
	$(function () {
		$('#modal_noti').modal('show');

		initMap();
		addMarker(dataRegionMap);

		$('.date_picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: 'th-th',
			endDate: new Date('<?php list($year_picker, $month, $day) = explode('-', $to_date);
			echo $year_picker . '-' . $month . '-' . ($day); ?>')
		});


		const ctx = document.getElementById('chart_main');
		const data_chart = {
			labels: chart_label,
			datasets: [{
				label: '<?php echo $year + 543 ?>',
				data: chart_current,
				borderColor: '#57DACC',
				backgroundColor: '#57DACC',
			}
				,
			{
				label: '<?php echo $year + 542 ?>',
				data: chart_pre,
				borderColor: '#FACE74',
				backgroundColor: '#FACE74',
			}
			]
		};
		const chart_main = new Chart(ctx, {
			type: 'line',
			data: data_chart,
			options: {
				responsive: true,
				interaction: {
					mode: 'index',
					intersect: false,
				},
				stacked: false,
			},
			options: {
				maintainAspectRatio: false,
			}
		});


		const ctx2 = document.getElementById('chart_main_year');
		const data_chart_year = {
			labels: chart_label_year,
			datasets: [{
				label: '<?php echo $year + 543 ?>',
				data: chart_current_year,
				borderColor: '#57DACC',
				backgroundColor: '#57DACC',
			}
				,
			{
				label: '<?php echo $year + 542 ?>',
				data: chart_pre_year,
				borderColor: '#FACE74',
				backgroundColor: '#FACE74',
			}
			]
		};
		const chart_main_year = new Chart(ctx2, {
			type: 'line',
			data: data_chart_year,
			options: {
				responsive: true,
				interaction: {
					mode: 'index',
					intersect: false,
				},
				stacked: false,
			},
			options: {
				maintainAspectRatio: false,
			}
		});

	});

	function openModalInfo(id) {
		$('#modalInfo' + id).modal('show');
	}

	function ChangeFilter() {
		if ($('#start_date').val() != '' && $('#start_date').val() != '') {
			var date = $('#start_date').val();
			if (date == '') {
				$('#start_date').focus();
				$('#start_date').css("border-color", "#e74a3b");
				return false;
			}
			date = date.split('/');
			start_date = date[0] + '-' + date[1] + '-' + (date[2] - 543);

			var date = $('#end_date').val();
			if (date == '') {
				$('#end_date').focus();
				$('#end_date').css("border-color", "#e74a3b");
				return false;
			}
			date = date.split('/');
			end_date = date[0] + '-' + date[1] + '-' + (date[2] - 543);
			window.location.href = base_url + '/main/daily?start_date=' + start_date + '&end_date=' + end_date;
		} else {
			window.location.href = base_url + '/main/daily';
		}

	}

	function ClearFilter() {
		window.location.href = base_url + '/main/daily';
	}

	var rendererOptions = {
		suppressMarkers: true,
	};
	var Marker = [];
	var ArrayMarker = [];
	var map;
	var directionsService = new google.maps.DirectionsService();
	var directionsRenderer = new google.maps.DirectionsRenderer(rendererOptions);
	var infowindow = [];

	function initMap() {
		var center = new google.maps.LatLng(14.1446356, 2.0148033);
		var mapOptions = {
			zoom: 1,
			center: center,
			disableDefaultUI: false,
			mapTypeControl: false,
			scaleControl: false,
			zoomControl: true,
			streetViewControl: false,
			fullscreenControl: false,
		}
		map = new google.maps.Map(document.getElementById('canvas_map'), mapOptions);
		// directionsRenderer.setMap(map);

		// console.log(map);
	}

	function addMarker(data) {

		$.each(data, function (index, value) {

			index = value.id;
			var latlong = value.latlong.split(',');
			value.LATITUDE = latlong[0];
			value.LONGITUDE = latlong[1];
			var LatLon = value.LATITUDE + ',' + value.LONGITUDE;
			if (jQuery.inArray(LatLon, ArrayMarker) !== -1) {

			} else {
				var id_marker = value.ID;
				ArrayMarker.push(LatLon);
				Marker[id_marker] = new google.maps.Marker({
					icon: value.marker,
					position: new google.maps.LatLng(value.LATITUDE, value.LONGITUDE),
					map: map,
				});

				var index = parseInt(index);
				infowindow[index] = new google.maps.InfoWindow();
				var content = "<div style='text-align:center'>" +
					"<button type='button' class='close button_close' onclick='close_info(" + index + ")'>" +
					"<span>&times;</span>" +
					"</button>" +
					"<div style='padding:5px;color:#000;background:" + value.color + "'>" + value.name + "</div>" +
					"<div style='margin:8px;'><table style='width: 100%;'>" +
					"<tr><td style='text-align: left;border-right: 1px solid #aaa;border-bottom: 1px solid #aaa;'><?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?></td><td style='text-align: right;border-bottom: 1px solid #aaa;'>" + numberWithCommas(value.valueDay) + "</td></tr>" +
					"<tr><td style='text-align: left;border-right: 1px solid #aaa;'><?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?></td><td style='text-align: right;'>" + numberWithCommas(value.valueMonth) + "</td></tr>" +
					"</table></div>" +
					"</div>";



				infowindow[index].setContent(content);
				infowindow[index].setPosition(new google.maps.LatLng(value.LATITUDE, value.LONGITUDE));



				Marker[id_marker].addListener("click", () => {
					showCountry(index);
					infowindow[index].open({
						map,
					});
				});


			}
		});


	}

	function close_info(index) {
		infowindow[index].close();
		$('.region_' + index).hide();
	}

	function showCountry(id) {
		// $('.tr_country').hide();
		$('.region_' + id).show();
	}

	function toggleChildren(nodeId) {
		var $children = $('.parent_' + nodeId);
		if (!$children.length) return;
		var isHidden = $children.first().css('display') === 'none';
		if (isHidden) {
			$children.show();
		} else {
			hideDescendants(nodeId);
		}
	}

	function hideDescendants(parentId) {
		$('.parent_' + parentId).each(function () {
			$(this).hide();
			var cid = $(this).data('node-id');
			if (cid) hideDescendants(cid);
		});
	}

	function SaveImg2ExportPdf(url2SaveImg, url2DowloadReport) {
		$('.btn-download').hide();
		$('#htmltoimage_chart_daily_year').show();
		setTimeout(function () { saveImg(url2SaveImg, url2DowloadReport); }, 1000);
		setTimeout(function () { $('#htmltoimage_chart_daily_year').hide(); }, 6000);

		$.ajax({
			method: "POST",
			url: base_url + "/main/saveLog",
			data: { 'type': 'Daily' },
			success: function (res) {

			}
		});

	}

	function saveImg(url2SaveImg, url2DowloadReport) {
		$('.btn-download').hide();
		const chart_array = ["chart_daily", "chart_daily_year"];
		var count_canvas = 0;

		// กำหนดขนาดคงที่สำหรับรูปภาพ export
		const TARGET_WIDTH = 1100;
		const TARGET_HEIGHT = 220;

		$.each(chart_array, function (key, value) {
			var container = document.getElementById("htmltoimage_" + value);

			// ตรวจสอบและกำหนดขนาด container ก่อน capture
			var originalDisplay = container.style.display;
			var originalWidth = container.style.width;
			var originalPosition = container.style.position;
			var originalLeft = container.style.left;

			// กำหนดขนาดคงที่และแสดง container (ใช้ position absolute เพื่อไม่ให้กระทบ layout)
			container.style.display = 'block';
			container.style.width = TARGET_WIDTH + 'px';
			container.style.position = 'absolute';
			container.style.left = '-9999px';

			// รอให้ browser render ก่อน capture
			setTimeout(function () {
				html2canvas(container, {
					allowTaint: true,
					useCORS: true,
					scale: 1,
					width: TARGET_WIDTH,
					height: TARGET_HEIGHT
				}).then(function (canvas) {
					// คืนค่า style เดิม
					container.style.display = originalDisplay;
					container.style.width = originalWidth;
					container.style.position = originalPosition;
					container.style.left = originalLeft;

					var link = document.createElement("a");
					document.body.appendChild(link);
					link.download = "<?php echo $to_date; ?>" + value + ".png";
					link.href = canvas.toDataURL('image/png');
					link.target = '_blank';

					var dataURL = link.href;
					$.post(url2SaveImg, {
						imgBase64: dataURL,
						imgName: "<?php echo $to_date; ?>" + value
					}, function (data, status) {
						count_canvas++;
						if (count_canvas == chart_array.length) {
							window.open(url2DowloadReport);
						}
					});
				}).catch(function (error) {
					console.error('html2canvas error:', error);
					// คืนค่า style เดิมเมื่อเกิด error
					container.style.display = originalDisplay;
					container.style.width = originalWidth;
					container.style.position = originalPosition;
					container.style.left = originalLeft;
				});
			}, 100);
		});
	}

	// capture หน้า dashboard ทั้งหน้าเป็นไฟล์รูป (สำหรับ user นอก whitelist)
	function CaptureScreen() {
		var target = document.querySelector('.container-fluid');
		if (!target) {
			console.error('CaptureScreen: ไม่พบพื้นที่ .container-fluid');
			return;
		}

		var btn = document.getElementById('btn_capture_screen');
		var originalLabel = btn ? btn.innerHTML : '';
		if (btn) {
			btn.disabled = true;
			btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> กำลังบันทึก...';
		}

		function restoreBtn() {
			if (btn) {
				btn.disabled = false;
				btn.innerHTML = originalLabel;
			}
		}

		html2canvas(target, {
			allowTaint: true,
			useCORS: true,
			scale: 1.5,
			scrollX: 0,
			scrollY: -window.scrollY,
			windowWidth: document.documentElement.scrollWidth,
			ignoreElements: function (el) {
				// ไม่ต้อง capture แถบเลือกช่วงเวลา/from/to/ปุ่ม ด้านบน
				return el.id === 'daily_filter_bar' || el.id === 'btn_capture_screen';
			}
		}).then(function (canvas) {
			restoreBtn();
			var link = document.createElement('a');
			document.body.appendChild(link);
			link.download = 'dashboard_daily_<?php echo $to_date; ?>.png';
			link.href = canvas.toDataURL('image/png');
			link.click();
			document.body.removeChild(link);
		}).catch(function (error) {
			restoreBtn();
			console.error('CaptureScreen error:', error);
		});

		$.ajax({
			method: "POST",
			url: base_url + "/main/saveLog",
			data: { 'type': 'Daily_Capture' }
		});
	}

	function numberWithCommas(x) {
		if (x) {
			return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		} else {
			return 0;
		}

	}
</script>
<?= $this->endSection() ?>