<?php include_once("export_css.php"); ?>
<style type="text/css">
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
	<div class="col-6">
		<div class="card" style="background-image: url('<?php echo base_url('public/img/bg_info.png') ?>'); background-repeat: no-repeat; background-position: bottom;background-position-x:0;">
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
				<div class="text-center" id="htmltoimage_chart_daily" style="height:220px; padding:15px;">
					<img src="<?php echo base_url('public/uploads/main/' . $to_date . 'chart_daily.png') ?>" style="width: 100%;">
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
					<div class="col-12">

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
											<td align="right"><?php echo number_format(@$SumRegionDateData[13] + @$SumRegionDateData[15] + @$SumRegionDateData[38] + @$SumRegionDateData[23]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[13] + @$SumRegionMonthData[15] + @$SumRegionMonthData[38] + @$SumRegionDateData[23]) ?></td>
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
											<td align="right"><?php echo number_format(@$SumRegionDateData[15] + @$SumRegionDateData[38]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[15] + @$SumRegionDateData[38]) ?></td>
										</tr>
										<?php foreach ($country_region[15] as $c) { ?>
											<tr class="region_15 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<?php foreach ($country_region[38] as $c) { ?>
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
											<td align="right"><?php echo number_format(@$SumRegionDateData[2] + @$SumRegionDateData[44]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[2] + @$SumRegionDateData[44]) ?></td>
										</tr>
										<?php foreach ($country_region[2] as $c) { ?>
											<tr class="region_2 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<?php foreach ($country_region[44] as $c) { ?>
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
											<td align="right"><?php echo number_format(@$SumRegionDateData[7] + @$SumRegionDateData[45]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[7] + @$SumRegionDateData[45]) ?></td>
										</tr>
										<?php foreach ($country_region[7] as $c) { ?>
											<tr class="region_7 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<?php foreach ($country_region[45] as $c) { ?>
											<tr class="region_7 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<tr style="background: rgb(235, 125, 64, 0.7);">
											<td style="padding-left: 5px;">OCEANIA</td>
											<td align="right"><?php echo number_format(@$SumRegionDateData[5] + @$SumRegionDateData[46]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[5] + @$SumRegionDateData[46]) ?></td>
										</tr>
										<?php foreach ($country_region[5] as $c) { ?>
											<tr class="region_5 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<?php foreach ($country_region[46] as $c) { ?>
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
											<td align="right"><?php echo number_format(@$SumRegionDateData[6] + @$SumRegionDateData[40]) ?></td>
											<td align="right"><?php echo number_format(@$SumRegionMonthData[6] + @$SumRegionDateData[40]) ?></td>
										</tr>
										<?php foreach ($country_region[6] as $c) { ?>
											<tr class="region_6 tr_country" style="display:none">
												<td style="padding-left: 15px;"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
												<td align="right"><?php echo number_format(@$SumCountryDateData[$c['COUNTRYID']]) ?></td>
												<td align="right"><?php echo number_format(@$SumCountryMonthData[$c['COUNTRYID']]) ?></td>
											</tr>
										<?php } ?>
										<?php foreach ($country_region[40] as $c) { ?>
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