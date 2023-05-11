<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
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
</style>
<div class="row">
	<div class="col-md-6" style="font-size: 1.4em;">
		<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
	</div>
	<div class="col-md-6"></div>
</div>
<div class="row">
	<div class="col-md-4 col-4">
		วันที่เริ่มต้น <input type="text" name="start_date" id="start_date" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($start_date, 543, '/') ?>">
	</div>
	<div class="col-md-4 col-4">
		วันที่สิ้นสุด <input type="text" name="end_date" id="end_date" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($end_date, 543, '/') ?>">
	</div>
	<div class="col-md-4 col-4" style="text-align: right;">
		<div class="btn btn-primary" onclick="ClearFilter()">ล้างค่า</div>
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>
</div>

<div class="row">
	<div class="col-6">
		<div class="card" style="background-image: url('<?php echo base_url('public/img/bg_info.png') ?>'); background-repeat: no-repeat; background-position: bottom;background-position-x:0 ">
			<div class="card-body">
				<div class="row">
					<div class="col-md-4 col-4" style="text-align:center;"><img src="<?php echo base_url('public/img/icon_info1.png') ?>"></div>
					<div class="col-md-8 col-8" style="text-align:right; font-weight: bold; line-height: 2.4em; font-size: 1.1em; ">
						จำนวนนักท่องเที่ยว<br>
						วันที่ <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?><br>
						<div style="padding:5px; background:#ededed; border-radius: 5px; width: 100%; font-size: 1.8em; font-weight: bold;">
							<?php echo number_format($SumDateData); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-6">
		<div class="card" style="background-image: url('<?php echo base_url('public/img/bg_info.png') ?>'); background-repeat: no-repeat; background-position: bottom;background-position-x:0 ">
			<div class="card-body">
				<div class="row">
					<div class="col-md-4 col-4" style="text-align:center;"><img src="<?php echo base_url('public/img/icon_info2.png') ?>"></div>
					<div class="col-md-8 col-8" style="text-align:right; font-weight: bold; line-height: 2.4em; font-size: 1.1em;">
						จำนวนนักท่องเที่ยวสะสม<br>
						<!-- วันที่ 1 ม.ค. - <?php echo $month_label; ?> <?php echo $year + 543 ?> <br> -->
						วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?> <br>
						<div style="padding:5px; background:#ededed; border-radius: 5px; width: 100%; font-size: 1.8em; font-weight: bold;">
							<?php echo number_format($SumMonthData); ?>
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
			<div class="card-header">จำนวนนักท่องเที่ยวรายวัน (คน)</div>
			<div class="card-body">
				<div class="text-center" id="htmltoimage_chart_main" style="height:220px; padding:15px;">
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
							<td><?php echo $year + 543 ?></td>
							<?php
							foreach ($period as $d) { ?>
								<td style="background:#57DACC" align="center"><?php echo number_format(@$SumChartData['current'][$d]);
																				$chart_current[] = @$SumChartData['current'][$d] ? @$SumChartData['current'][$d] : 0; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td><?php echo $year + 542 ?></td>
							<?php
							foreach ($period as $d) {
								$d_ex = explode('-', $d);
								$d_pre = ($d_ex[0] - 1) . '-' . $d_ex[1] . '-' . $d_ex[2];   ?>
								<td style="background:#FACE74" align="center"><?php echo number_format(@$SumChartData['past'][$d_pre]);
																				$chart_pre[] = @$SumChartData['past'][$d_pre] ? @$SumChartData['past'][$d_pre] : 0; ?></td>
							<?php } ?>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">จำนวนนักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<div class="card">
							<div class="card-body" style="background: #eaf3f4; padding: 0; border-radius: 0.35rem;">
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
										<span style="font-size:0.8em">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543) ?></span>
									</div>
									<hr>
									<?php $c = 0;
									foreach ($SumNatDateData as $v) {
										$c++;
										$flag = base_url('public/img/logotat.png');

										if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
											$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
										}
									?>
										<div class="row" style="margin-bottom:10px;">
											<div class="col-md-3 col-3">
												<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 52px;">
											</div>
											<div class="col-md-5 col-5" style="padding-top: 15px;font-weight:bold;">
												<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
											</div>
											<div class="col-md-4 col-4" style="padding-top: 15px;font-weight:bold;padding-left: 0;">
												<?php echo number_format($v['NUM']); ?>
											</div>
										</div>
									<?php if ($c == 5) break;
									} ?>
								</div>
								<div style="background:#70d3de; text-align:center; border-radius: 0 0 0.35rem 0.35rem; cursor: pointer; " onclick="openModalInfo(1)">
									<i class="fa-solid fa-caret-down"></i>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card">
							<div class="card-body" style="background: #eaf3f4; padding: 0; border-radius: 0.35rem;">
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
										<span style="font-size:0.8em">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></span>
									</div>
									<hr>
									<?php $c = 0;
									foreach ($SumNatMonthData as $v) {
										$c++;
										$flag = base_url('public/img/logotat.png');

										if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
											$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
										}
									?>
										<div class="row" style="margin-bottom:10px;">
											<div class="col-md-3 col-3">
												<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 52px;">
											</div>
											<div class="col-md-5 col-5" style="padding-top: 15px;font-weight:bold;">
												<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
											</div>
											<div class="col-md-4 col-4" style="padding-top: 15px;font-weight:bold;padding-left: 0;">
												<?php echo number_format($v['NUM']); ?>
											</div>
										</div>
									<?php if ($c == 5) break;
									} ?>
								</div>
								<div style="background:#70d3de; text-align:center; border-radius: 0 0 0.35rem 0.35rem; cursor: pointer; " onclick="openModalInfo(2)">
									<i class="fa-solid fa-caret-down"></i>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card">
							<div class="card-body" style="background: #a2e4d8; padding: 0; border-radius: 0.35rem;">
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายด่าน</span><br>
										<span style="font-size:0.8em">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543) ?></span>
									</div>
									<hr>
									<?php $c = 0;
									foreach ($SumPortDateData as $v) {
										$c++;  ?>
										<div class="row" style="margin-bottom:10px;">
											<div class="col-md-3 col-3" style="text-align:center; font-size: 2.4em;">
												<?php if ($v['PORT_TYPE'] == 'ด่านอากาศ') {
													echo '<i class="fa fa-plane-up"></i>';
												} else {
													echo '<i class="fa fa-building"></i>';
												} ?>
											</div>
											<div class="col-md-5 col-5" style="padding-left:0;padding-top: 15px;font-weight:bold;">
												<span style="font-weight:bold; font-size: 0.85em;"><?php echo $v['PORT_NAME'] ?></span>
											</div>
											<div class="col-md-4 col-4" style="padding-left:0;padding-top: 15px;font-weight:bold;">
												<?php echo number_format($v['NUM']); ?>
											</div>
										</div>
									<?php if ($c == 5) break;
									} ?>
								</div>
								<div style="background:#4598a1; text-align:center; border-radius: 0 0 0.35rem 0.35rem; cursor: pointer; " onclick="openModalInfo(3)">
									<i class="fa-solid fa-caret-down" style="color:#fff"></i>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card">
							<div class="card-body" style="background: #a2e4d8; padding: 0; border-radius: 0.35rem;">
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายด่าน</span><br>
										<span style="font-size:0.8em">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></span>
									</div>
									<hr>
									<?php $c = 0;
									foreach ($SumPortMonthData as $v) {
										$c++;  ?>
										<div class="row" style="margin-bottom:10px;">
											<div class="col-md-3 col-3" style="text-align:center; font-size: 2.4em;">
												<?php if ($v['PORT_TYPE'] == 'ด่านอากาศ') {
													echo '<i class="fa fa-plane-up"></i>';
												} else {
													echo '<i class="fa fa-building"></i>';
												} ?>
											</div>
											<div class="col-md-5 col-5" style="padding-left:0;padding-top: 15px;font-weight:bold;">
												<span style="font-weight:bold; font-size: 0.85em;"><?php echo $v['PORT_NAME'] ?></span>
											</div>
											<div class="col-md-4 col-4" style="padding-left:0;padding-top: 15px;font-weight:bold;">
												<?php echo number_format($v['NUM']); ?>
											</div>
										</div>
									<?php if ($c == 5) break;
									} ?>
								</div>
								<div style="background:#4598a1; text-align:center; border-radius: 0 0 0.35rem 0.35rem; cursor: pointer; " onclick="openModalInfo(4)">
									<i class="fa-solid fa-caret-down" style="color:#fff"></i>
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
			<div class="card-header">
				<span style="font-weight:bold;">จำนวนนักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย<br>จำแนกรายภูมิภาค</span>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-8">
						<div id="canvas_map" style="height: 470px; width:100%"></div>
					</div>
					<div class="col-4">
						<?php
						$dataRegionMap[1]['id'] = 13;
						$dataRegionMap[1]['name'] = 'ASEAN';
						$dataRegionMap[1]['valueDay'] = number_format(@$SumRegionDateData[13]);
						$dataRegionMap[1]['valueMonth'] = number_format(@$SumRegionMonthData[13]);
						$dataRegionMap[1]['latlong'] = '12.519780, 100.452300';
						$dataRegionMap[1]['color'] = '#F47780';
						$dataRegionMap[1]['marker'] = base_url('public/img/icon-map/Group-2.png');

						$dataRegionMap[2]['id'] = 15;
						$dataRegionMap[2]['name'] = 'NORTH-EAST ASIA';
						$dataRegionMap[2]['valueDay'] = number_format(@$SumRegionDateData[15]);
						$dataRegionMap[2]['valueMonth'] = number_format(@$SumRegionMonthData[15]);
						$dataRegionMap[2]['latlong'] = '31.022402, 130.159335';
						$dataRegionMap[2]['color'] = '#241C88';
						$dataRegionMap[2]['marker'] = base_url('public/img/icon-map/Group.png');

						$dataRegionMap[3]['id'] = 23;
						$dataRegionMap[3]['name'] = 'SOUTH ASIA';
						$dataRegionMap[3]['valueDay'] = number_format(@$SumRegionDateData[23]);
						$dataRegionMap[3]['valueMonth'] = number_format(@$SumRegionMonthData[23]);
						$dataRegionMap[3]['latlong'] = '8.893284, 78.128085';
						$dataRegionMap[3]['color'] = '#C80B0B';
						$dataRegionMap[3]['marker'] = base_url('public/img/icon-map/Group-8.png');

						$dataRegionMap[4]['id'] = 2;
						$dataRegionMap[4]['name'] = 'EUROPE';
						$dataRegionMap[4]['valueDay'] = number_format(@$SumRegionDateData[2]);
						$dataRegionMap[4]['valueMonth'] = number_format(@$SumRegionMonthData[2]);
						$dataRegionMap[4]['latlong'] = '47.135605, 7.464025';
						$dataRegionMap[4]['color'] = '#70D667';
						$dataRegionMap[4]['marker'] = base_url('public/img/icon-map/Group-4.png');

						$dataRegionMap[5]['id'] = 37;
						$dataRegionMap[5]['name'] = 'EAST EUROPE';
						$dataRegionMap[5]['valueDay'] = number_format(@$SumRegionDateData[37] + @$SumRegionDateData[36]);
						$dataRegionMap[5]['valueMonth'] = number_format(@$SumRegionMonthData[37] + @$SumRegionMonthData[36]);
						$dataRegionMap[5]['latlong'] = '52.781213, 33.479648';
						$dataRegionMap[5]['color'] = '#FFE600';
						$dataRegionMap[5]['marker'] = base_url('public/img/icon-map/Group-7.png');

						$dataRegionMap[6]['id'] = 7;
						$dataRegionMap[6]['name'] = 'THE AMERICAS';
						$dataRegionMap[6]['valueDay'] = number_format(@$SumRegionDateData[7]);
						$dataRegionMap[6]['valueMonth'] = number_format(@$SumRegionMonthData[7]);
						$dataRegionMap[6]['latlong'] = '20.434802, -100.114100';
						$dataRegionMap[6]['color'] = '#39A5ED';
						$dataRegionMap[6]['marker'] = base_url('public/img/icon-map/Group-5.png');

						$dataRegionMap[7]['id'] = 5;
						$dataRegionMap[7]['name'] = 'OCEANIA';
						$dataRegionMap[7]['valueDay'] = number_format(@$SumRegionDateData[5]);
						$dataRegionMap[7]['valueMonth'] = number_format(@$SumRegionMonthData[5]);
						$dataRegionMap[7]['latlong'] = '-30.781896, 144.749177';
						$dataRegionMap[7]['color'] = '#EB7D40';
						$dataRegionMap[7]['marker'] = base_url('public/img/icon-map/Group-1.png');

						$dataRegionMap[8]['id'] = 20;
						$dataRegionMap[8]['name'] = 'MIDDLE EAST';
						$dataRegionMap[8]['valueDay'] = number_format(@$SumRegionDateData[20]);
						$dataRegionMap[8]['valueMonth'] = number_format(@$SumRegionMonthData[20]);
						$dataRegionMap[8]['latlong'] = '27.807562, 49.827303';
						$dataRegionMap[8]['color'] = '#970EAD';
						$dataRegionMap[8]['marker'] = base_url('public/img/icon-map/Group-3.png');

						$dataRegionMap[9]['id'] = 6;
						$dataRegionMap[9]['name'] = 'AFRICA';
						$dataRegionMap[9]['valueDay'] = number_format(@$SumRegionDateData[6]);
						$dataRegionMap[9]['valueMonth'] = number_format(@$SumRegionMonthData[6]);
						$dataRegionMap[9]['latlong'] = '2.834002, 17.403791';
						$dataRegionMap[9]['color'] = '#BF9C56';
						$dataRegionMap[9]['marker'] = base_url('public/img/icon-map/Group-6.png');

						?>
						<div id="resultsTable">
							<div class="table-responsive" style="height:440px; overflow:auto; margin-bottom: 10px;">
								<table class="table table-striped ">
									<thead>
										<tr>
											<th>Region</th>
											<th><?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?></th>
											<th><?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="padding-left: 5px;">ASIA</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[13] + @$SumRegionDateData[15] + @$SumRegionDateData[33]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[13] + @$SumRegionMonthData[15] + @$SumRegionMonthData[33]) ?></td>
										</tr>
										<tr style="background: rgb(244, 119, 128 , 0.7);">
											<td style="padding-left: 5px;">ASEAN</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[13]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[13]) ?></td>
										</tr>
										<?php foreach ($country_region[13] as $c) { ?>
											<tr class="region_13 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<tr style="background: rgb(36, 28, 136, 0.7);">
											<td style="padding-left: 5px;">NORTH-EAST ASIA</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[15]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[15]) ?></td>
										</tr>
										<?php foreach ($country_region[15] as $c) { ?>
											<tr class="region_15 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<tr style="background: rgb(200, 11, 11, 0.7);">
											<td style="padding-left: 5px;">SOUTH ASIA</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[23]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[23]) ?></td>
										</tr>
										<?php foreach ($country_region[23] as $c) { ?>
											<tr class="region_23 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<tr style="background: rgb(112, 214, 103, 0.7);">
											<td style="padding-left: 5px;">EUROPE</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[2]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[2]) ?></td>
										</tr>
										<?php foreach ($country_region[2] as $c) { ?>
											<tr class="region_2 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<tr style="background: rgb(255, 230, 0, 0.7);">
											<td style="padding-left: 5px;">EAST EUROPE</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[37] + @$SumRegionDateData[36]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[37] + @$SumRegionMonthData[36]) ?></td>
										</tr>
										<?php foreach ($country_region[37] as $c) { ?>
											<tr class="region_37 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<?php foreach ($country_region[36] as $c) { ?>
											<tr class="region_37 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<tr style="background: rgb(57, 165, 237, 0.7);">
											<td style="padding-left: 5px;">THE AMERICAS</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[7]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[7]) ?></td>
										</tr>
										<?php foreach ($country_region[7] as $c) { ?>
											<tr class="region_7 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<tr style="background: rgb(235, 125, 64, 0.7);">
											<td style="padding-left: 5px;">OCEANIA</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[5]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[5]) ?></td>
										</tr>
										<?php foreach ($country_region[5] as $c) { ?>
											<tr class="region_5 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<tr style="background: rgb(151, 14, 173, 0.7);">
											<td style="padding-left: 5px;">MIDDLE EAST</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[20]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[20]) ?></td>
										</tr>
										<?php foreach ($country_region[20] as $c) { ?>
											<tr class="region_20 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<tr style="background: rgb(191, 156, 86, 0.7);">
											<td style="padding-left: 5px;">AFRICA</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[6]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[6]) ?></td>
										</tr>
										<?php foreach ($country_region[6] as $c) { ?>
											<tr class="region_6 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<tr>
											<td style="padding-left: 5px;">STATELESS</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[29]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[29]) ?></td>
										</tr>
									</tbody>
									<tfoot>
										<tr style="background: #70D3DE;font-weight: bolder;">
											<td style="padding-left: 5px;">Total</td>
											<td align="right">
												<?php $sumDate = 0;
												foreach ($SumRegionDateData as $v) {
													$sumDate += $v;
												}
												echo number_format($sumDate) ?>
											</td>
											<td align="right">
												<?php $sumMonth = 0;
												foreach ($SumRegionMonthData as $v) {
													$sumMonth += $v;
												}
												echo number_format($sumMonth) ?>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalInfo1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
					foreach ($SumNatDateData as $v) {
						$c++;
						$flag = base_url('public/img/logotat.png');

						if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
							$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
						}
					?>
						<div class="row" style="margin-bottom:10px;">
							<div class="col-md-3 col-3">
								<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 52px;">
							</div>
							<div class="col-md-5 col-5" style="padding-left:0;padding-top: 15px;font-weight:bold;">
								<span style="font-weight:bold; font-size: 0.85em;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
							</div>
							<div class="col-md-4 col-4" style="padding-left:0;padding-top: 15px;font-weight:bold;">
								<?php echo number_format($v['NUM']); ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalInfo2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
					<span style="font-size:0.8em">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></span>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="padding:10px;">
					<?php $json_nat_month = array();
					$c = 0;
					foreach ($SumNatMonthData as $v) {
						$c++;
						$flag = base_url('public/img/logotat.png');

						if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
							$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
						}
					?>
						<div class="row" style="margin-bottom:10px;">
							<div class="col-md-3 col-3">
								<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 52px;">
							</div>
							<div class="col-md-5 col-5" style="padding-left:0;padding-top: 15px;font-weight:bold;">
								<span style="font-weight:bold; font-size: 0.85em;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
							</div>
							<div class="col-md-4 col-4" style="padding-left:0;padding-top: 15px;font-weight:bold;">
								<?php echo number_format($v['NUM']); ?>
							</div>
						</div>
					<?php  } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalInfo3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
					foreach ($SumPortDateData as $v) {
						$c++;  ?>
						<div class="row" style="margin-bottom:10px;">
							<div class="col-md-3 col-3" style="text-align:center; font-size: 2.4em;">
								<?php if ($v['PORT_TYPE'] == 'ด่านอากาศ') {
									echo '<i class="fa fa-plane-up"></i>';
								} else {
									echo '<i class="fa fa-building"></i>';
								} ?>
							</div>
							<div class="col-md-5 col-5" style="padding-left:0;padding-top: 15px;font-weight:bold;">
								<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['PORT_NAME'] ?></span>
							</div>
							<div class="col-md-4 col-4" style="padding-left:0;padding-top: 15px;font-weight:bold;">
								<?php echo number_format($v['NUM']); ?>
							</div>
						</div>
					<?php  } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalInfo4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<span style="font-weight:bold;">จำแนกรายด่าน</span><br>
					<span style="font-size:0.8em">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></span>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="padding:10px;">
					<?php $c = 0;
					foreach ($SumPortMonthData as $v) {
						$c++;  ?>
						<div class="row" style="margin-bottom:10px;">
							<div class="col-md-3 col-3" style="text-align:center; font-size: 2.4em;">
								<?php if ($v['PORT_TYPE'] == 'ด่านอากาศ') {
									echo '<i class="fa fa-plane-up"></i>';
								} else {
									echo '<i class="fa fa-building"></i>';
								} ?>
							</div>
							<div class="col-md-5 col-5" style="padding-left:0;padding-top: 15px;font-weight:bold;">
								<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['PORT_NAME'] ?></span>
							</div>
							<div class="col-md-4 col-4" style="padding-left:0;padding-top: 15px;font-weight:bold;">
								<?php echo number_format($v['NUM']); ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>



<?php $this->endSection() ?>
<?= $this->section("scripts") ?>
<script src="<?= base_url('public/js/script.js') ?>"></script>
<script src="<?php echo base_url('public/vendor/chart.js/Chart.min.js'); ?>" type="text/javascript"></script>
<script src="https://maps.google.com/maps/api/js?key=<?php echo $api_code; ?>&sensor=false&libraries=marker"></script>
<!-- <script type="text/javascript" src="https://unpkg.com/chartjs-chart-geo@3.5.2/build/index.umd.min.js"></script> -->

<script type="text/javascript">
	var chart_label = <?php echo json_encode($chart_label); ?>;
	var chart_current = <?php echo json_encode($chart_current); ?>;
	var chart_pre = <?php echo json_encode($chart_pre); ?>;
	var dataRegionMap = <?php echo json_encode($dataRegionMap); ?>;

	console.log(dataRegionMap);
	// import zoomPlugin from 'chartjs-plugin-zoom';
	$(function() {
		initMap();
		addMarker(dataRegionMap);

		$('.date_picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: 'th-th',
			endDate: new Date('<?php list($day, $month, $year) = explode('-', $to_date);
								echo $year . '-' . $month . '-' . ($day); ?>')
		});




		const ctx = document.getElementById('chart_main');
		const data_chart = {
			labels: chart_label,
			datasets: [{
					label: '<?php echo date('Y') + 543 ?>',
					data: chart_current,
					borderColor: '#57DACC',
					backgroundColor: '#57DACC',
				},
				{
					label: '<?php echo date('Y') + 542 ?>',
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

	});

	function openModalInfo(id) {
		$('#modalInfo' + id).modal('show');
	}

	function ChangeFilter() {
		var date = $('#start_date').val();
		date = date.split('/');
		// start_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
		start_date = date[0] + '-' + date[1] + '-' + (date[2] - 543);

		var date = $('#end_date').val();
		date = date.split('/');
		// end_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
		end_date = date[0] + '-' + date[1] + '-' + (date[2] - 543);


		window.location.href = base_url + '/main?start_date=' + start_date + '&end_date=' + end_date;
	}

	function ClearFilter() {
		window.location.href = base_url + '/main';
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

		$.each(data, function(index, value) {

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
					"<tr><td style='text-align: left;border-right: 1px solid #aaa;border-bottom: 1px solid #aaa;'><?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?></td><td style='text-align: right;border-bottom: 1px solid #aaa;'>" + value.valueDay + "</td></tr>" +
					"<tr><td style='text-align: left;border-right: 1px solid #aaa;'><?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?></td><td style='text-align: right;'>" + value.valueMonth + "</td></tr>" +
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
</script>
<?= $this->endSection() ?>