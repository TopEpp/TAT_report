<?php include_once("export_css.php"); ?>

<style type="text/css">
	#CartItem {
		display: flex !important;
		flex-direction: row !important;
	}

	.col3 {
		width: 30%;
	}

	.vl {
		border-left: 3px solid white;
		border-left-style: dashed;
		top: 425px;
		height: 270px;
		position: absolute;
		left: 557px;
	}

	.col4 {
		width: 20%;
		float: left;
		padding-top: 1%;
	}

	.col8 {
		width: 80%;
		float: left;
		padding-top: 1%;
	}

	.col6 {
		width: 50%;
		float: left;
		/* padding-top: 1%; */
	}

	.col12 {
		width: 100%;
		float: left;
	}

	#resultsTableForCard2 {
		width: 200px;
		height: 100px;
		background: #fff1cc;
		border-radius: 12px !important;
		margin: auto auto;
	}

	#resultsTableForCard {
		width: 200px;
		height: 100px;
		background: #a7ffff;
		overflow: hidden !important;
		border-radius: 12px !important;
		margin: auto auto;
	}

	#resultsTable {
		height: 470px;
		width: 230px;
		background: #73A0E0;
		overflow: hidden;
		border-radius: 25px !important;
		/* margin: 0px 0px 0px 0px */
		/* position: absolute; */
	}

	#resultsTable2 {
		height: 470px;
		width: 230px;
		background: #DDC354;
		overflow: hidden;
		border-radius: 25px !important;
		/* margin: 0px 0px 0px auto; */
	}

	#resultsTableMarket {
		height: 210px;
		width: 210px;
		background: #a7ffff;
		overflow: hidden;
		border-radius: 25px !important;
		margin: 0px auto;
		/* position: absolute; */
	}

	#resultsTableMarket1 {
		height: 180px;
		width: 210px;
		background: #73A0E0;
		overflow: hidden;
		border-radius: 25px !important;
		margin: 0px auto;
	}

	#resultsTableMarket2 {
		height: 180px;
		width: 210px;
		background: #DDC354;
		overflow: hidden;
		border-radius: 25px !important;
		margin: 0px auto;
	}

	#resultsTable3 {
		height: 20px;
		width: 300px;
		background: white;
		overflow: hidden;
		border-radius: 6px !important;
		margin: auto auto;
		box-shadow: 0px 5px 8px 0px hsl(0, 7%, 50%);
	}



	#resultsTable4 {
		height: 35px;
		width: 230px;
		background: #73A0E0;
		overflow: hidden;
		border-radius: 28px !important;
		/* margin: 0px auto; */

	}

	#resultsTable5 {
		height: 35px;
		width: 230px;
		background: #DDC354;
		overflow: hidden;
		border-radius: 28px !important;
		/* margin: auto auto; */
	}

	.backgroundColorBox1 {
		background-color: #73A0E0;
		border-bottom-left-radius: 18px;
		border-bottom-right-radius: 18px;
	}

	.colorText {
		color: #163868;
	}

	.colorTextLeft {
		color: #049B97;
	}

	@media (max-width: 576px) {}
</style>

<?php

$numberSumNatDay = $numberMarketDay = array();
$i = 1;
foreach ($SumNatDateData_past as $v) {

	if ($v['NUM'] == 0) {
		$numberSumNatDay[$v['COUNTRY_ID']] = '';
	} else {
		$numberSumNatDay[$v['COUNTRY_ID']] = $i++;
	}
}

$i = 1;
if (!empty($SumMarketDate_past['Short'])) {
	foreach ($SumMarketDate_past['Short'] as $v) {

		if ($v['NUM'] == 0) {
			$numberMarketDay['Short'][$v['COUNTRY_ID']] = '';
		} else {
			$numberMarketDay['Short'][$v['COUNTRY_ID']] = $i++;
		}
	}
}

$i = 1;
if (!empty($SumMarketDate_past['Long'])) {
	foreach ($SumMarketDate_past['Long'] as $v) {

		if ($v['NUM'] == 0) {
			$numberMarketDay['Long'][$v['COUNTRY_ID']] = '';
		} else {
			$numberMarketDay['Long'][$v['COUNTRY_ID']] = $i++;
		}
	}
}


// echo '<pre>';
// print_r($SumMarketDate_past);
// print_r($numberMarketDay);
// print_r($numberSumNatDay);
?>

<body>
	<div class="col12">
		<div class="col6" style="padding-left: 0px; margin-right: 10px; ">
			<div class="row" style="margin-right: 25px; margin-left: 25px;">
				<div class="col12 backgroundColorBox1">
					<div style="padding-left: 40px; padding-right: 40px; padding-top: 10px; padding-bottom: 0px;">
						<table style="width: 100%;padding-bottom: 9px;">
							<thead>
								<tr>
									<td style="text-align: start; color: white;width: 90%;">
										<p style="margin: 0px; font-weight:bold; line-height: normal; font-size: 30px;">
											สถิตินักท่องเที่ยวระหว่างประเทศ
											<br>
											ที่เดินทางเข้าประเทศไทย
										</p>
										<h3 style="margin: 0px; line-height: normal; font-size: 30px; font-weight:bold; color: #E8D023;">
											วันที่ <?php echo $Mydate->date_eng2thai($to_date, 543) ?>
										</h3>

									</td>
								</tr>
							</thead>
						</table>
						<div style="font-size: 13px; color: white; margin: 0px; padding-top: 6px; padding-bottom: 6px;">
							ที่มา สำนักงานตรวจคนเข้าเมือง | จัดทำโดย ด้านดิจิทัล วิจัย เเละพัฒนา
						</div>
					</div>
				</div>
				<div class="col12" style="padding-right:0px; ">
					<div class="row" style="margin: 0px;">
						<div class="col6" style="">
							<div class="row" style="margin: 0px;">
								<div class="col12" style="padding-right: 15px;">
									<table class="table" style="width: 100%;">
										<tbody style="">
											<tr style="text-align:center; border: 0;">
												<td class="colorText" style="padding: 10px 0px 0px 0px; font-size: 15px; text-align: center; font-weight: bold;width: 50%;">
													จำนวนนักท่องเที่ยว
												</td>
												<!-- <td class="colorText" style="padding: 10px 0px 0px 0px; font-size: 15px; text-align: center; font-weight: bold;">
													สะสม
													<?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
												</td> -->
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col12" style="padding-right: 15px;">
									<div id="resultsTable4">
										<div>
											<table style="width: 100%;">
												<tbody>
													<tr style="border: 0;padding: 0px 0px;">
														<td class="" style="color: white;text-align: center;padding: 5px 10px ; font-size: 25px;font-weight: bold;width: 100%;">
															<?php echo number_format($SumDateData); ?> คน
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col6">
							<div class="row" style="margin: 0px;">
								<div class="col12" style="padding-left: 21px;">
									<table class="table" style="width: 100%;">
										<tbody style="">
											<tr style="text-align:center; border: 0;">
												<td class="colorText" style="padding: 10px 0px 0px 0px; font-size: 15px; text-align: center; font-weight: bold;">
													สะสม
													<?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col12" style="padding-left: 21px;">
									<div id="resultsTable5">
										<div>
											<table style="width: 100%;">
												<tbody>
													<tr style="border: 0;padding: 0px 0px;">
														<td class="colorText" style="text-align: center;padding: 5px 10px ; font-size: 25px;font-weight: bold;width: 100%;">
															<?php echo number_format($SumMonthData); ?> คน
														</td>
													</tr>

												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div style="margin-bottom: 10px;">
						<div class="col12" style="">
							<table style="width: 100%; margin-top: 8px; padding: 0px;">
								<tbody>
									<tr style="padding: 0px 0px;">
										<td class="colorText" style="text-align: center;font-size: 17px;width: 100%;font-weight: bold;">
											จำนวนนักท่องเที่ยว จำแนกรายสัญชาติ 10 อันดับแรก
										</td>
									</tr>
								</tbody>
							</table>
							<div class="col6" style="display: flex; justify-content: space-between;">
								<div style="padding-right: 15px;">
									<div class="row" style="margin: 0px;">
										<div class="col12" style="">
											<table style="width: 100%;">
												<tbody>
													<tr>
														<td style="padding-bottom: 6px; text-align: center;padding-top: 8px;color: #193666;font-weight: bold;font-size: 15px;width: 50%;">
															<?php echo $Mydate->date_eng2thai($to_date, 543) ?>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col12" style="">
											<div id="resultsTable" style=" flex-direction: row;">
												<?php $c = 0;
												$i = 1;
												foreach ($SumNatDateData as $v) {
													$c++;
													$flag = base_url('public/img/logotat.png');

													$number_icon  = base_url('public/img/Number_icon/number_' . $c . '.png');

													if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
														$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
													}
													$icon = '';
													if (!empty($numberSumNatDay[$v['COUNTRY_ID']])) {
														if ($i == $numberSumNatDay[$v['COUNTRY_ID']]) {
															$icon = '';
														} else if ($i < $numberSumNatDay[$v['COUNTRY_ID']]) {
															$icon = '<img src="' . base_url('public/img/arrowup1.png') . '" alt="">';
														} else if ($i > $numberSumNatDay[$v['COUNTRY_ID']]) {
															$icon = '<img src="' . base_url('public/img/arrowdown1.png') . '" alt="">';
														}
													}
													$i++;
												?>
													<div style="border: 0; padding-bottom: 0px; ">
														<div id="" style="padding-left: 10px; padding-right: 10px; ">
															<table style="width: 100%;">
																<tr style="">
																	<td style="width: 10%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;">
																		<img class="img-profile rounded-circle" src="<?php echo $number_icon ?>" style="height: 34px; ">
																	</td>
																	<td style="text-align: left; padding: 6.4px 16.5px;color: white; font-size: 16.5px;font-weight: bold; width: 90%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid #FFFFFF' ?>;">
																		<?php echo $v['COUNTRY_NAME_EN'] ?>
																		<br>
																		<?php echo number_format($v['NUM']); ?> คน
																	</td>
																	<!-- <td style="width:10%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;text-align: center;">
																<?php echo $icon; ?>
															</td> -->
																</tr>
															</table>
														</div>
													</div>
												<?php if ($c == 10) break;
												} ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col6">
								<div style="padding-left: 21px;">
									<div class="row" style="margin: 0px;">
										<div class="col12">
											<table style="width: 100%;">
												<tbody>
													<tr>
														<td style="padding-bottom: 6px; text-align: center;padding-top: 8px;color: #193666;font-weight: bold;font-size: 15px;">
															สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col12">
											<div id="resultsTable2" style=" flex-direction: row; ">
												<?php $c = 0;
												foreach ($SumNatMonthData as $v) {
													$c++;
													$flag = base_url('public/img/logotat.png');
													$number_icon2  = base_url('public/img/Number_icon/number2_' . $c . '.png');
													if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
														$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
													}
												?>
													<div style="border: 0; padding-bottom: 0px; ">
														<div id="" style="padding-left: 10px; padding-right: 10px; ">
															<table style="width: 100%;">
																<tr style="">
																	<td style="width: 10%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;">
																		<img class="img-profile rounded-circle" src="<?php echo $number_icon2 ?>" style="height: 34px; ">
																	</td>
																	<td class="colorText" style="text-align: left; padding: 6.4px 15px; font-size: 16.5px;font-weight: bold; width: 90%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid #FFFFFF' ?>;">
																		<?php echo $v['COUNTRY_NAME_EN'] ?>
																		<br>
																		<?php echo number_format($v['NUM']); ?> คน
																	</td>
																	<!-- <td style="border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;text-align: center; width: 10%;">
																<img src="<?php echo base_url('public/img/arrowup1.png') ?>" alt="">
															</td> -->
																</tr>
															</table>
														</div>
													</div>
												<?php if ($c == 10) break;
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
		</div>
		<div class="col6" style="margin-left: 20px;">
			<div class="row" style="margin: 0px;padding-top: 10px;padding-bottom: 10px;">
				<div class="col6" style="text-align: right;">
					<img src="<?php echo base_url('public/img/amezingThai.png') ?>" alt="" style=" margin-right: 10px;height: 50px;">
				</div>
				<div class="col6">
					<img src="<?php echo base_url('public/img/TATIC-Logo.png') ?>" alt="" style="height:50px ;margin-left: 10px;">
				</div>
			</div>
			<div style="">
				<img src="<?php echo base_url('public/uploads/main/' . $to_date . 'chart_daily_year.png') ?>" style="width:100%;height:100px;">
			</div>
			<div class="col12" style="padding-top:0px; ">
				<table style="width: 100%;">
					<tbody>
						<tr style="border: 0;">
							<td colspan="3" style="text-align: center;padding: 0px 0px; margin: auto 0px;">
								<div id="" class="colorTextLeft" style="padding-top: 0px;padding-bottom: 0px; margin: 0px;font-weight:bold; font-size: 16px; ">จำนวนนักท่องเที่ยว ตลาดระยะใกล้ 5 อันดับแรก</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<div class="col6">
					<p class="colorTextLeft" style="font-size: 13px;text-align: center;margin:0px; font-weight: bold;"><?php echo $Mydate->date_eng2thai($to_date, 543) ?></p>
					<div id="resultsTableMarket1" style=" flex-direction: row; padding: 0px 5px;">
						<?php $c = 0;
						$i = 1;
						if (!empty($SumMarketDate['Short'])) {
							foreach ($SumMarketDate['Short'] as $v) {
								$c++;
								$flag = base_url('public/img/logotat.png');
								$number_icon2_1  = base_url('public/img/Number_icon/number_' . $c . '.png');
								if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
									$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
								}

								$icon = '';
								if (!empty($numberMarketDay['Short'][$v['COUNTRY_ID']])) {
									if ($i == $numberMarketDay['Short'][$v['COUNTRY_ID']]) {
										$icon = '';
									} else if ($i < $numberMarketDay['Short'][$v['COUNTRY_ID']]) {
										$icon = '<img src="' . base_url('public/img/arrowup1.png') . '" alt="">';
									} else if ($i > $numberMarketDay['Short'][$v['COUNTRY_ID']]) {
										$icon = '<img src="' . base_url('public/img/arrowdown1.png') . '" alt="">';
									}
								}
								$i++;
						?>
								<div style="border: 0; ">
									<table style="width: 100%;">
										<tr>
											<td style="width: 10%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;">
												<img class="img-profile rounded-circle" src="<?php echo $number_icon2_1 ?>" style="height: 34px; ">
											</td>
											<td style="text-align: left; padding: 4.8px 15px;color: white; font-size: 16.5px;font-weight: bold; width: 90%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;">
												<?php echo $v['COUNTRY_NAME_EN'] ?>
												<br>
												<?php echo number_format($v['NUM']); ?> คน
											</td>
										</tr>
									</table>

								</div>
						<?php if ($c == 5) break;
							}
						} ?>
					</div>
				</div>
				<div class="col6">
					<p class="colorTextLeft" style="font-size: 13px;text-align: center;margin:0px; font-weight: bold;">สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?></p>

					<div id="resultsTableMarket2" style=" flex-direction: row; padding: 0px 5px;">

						<?php $c = 0;
						if (!empty($SumMarketMonth['Short'])) {
							foreach ($SumMarketMonth['Short'] as $v) {
								$c++;
								$flag = base_url('public/img/logotat.png');

								$number_icon2_2  = base_url('public/img/Number_icon/number2_' . $c . '.png');
								if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
									$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
								}
						?>
								<div style="border: 0; ">
									<table style="width: 100%;">
										<tr>
											<td style="width: 10%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;">
												<img class="img-profile rounded-circle" src="<?php echo $number_icon2_2 ?>" style="height: 34px; ">
											</td>
											<td style="text-align: left; padding: 4.8px 15px;color: #193666; font-size: 16.5px;font-weight: bold; width: 90%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;">
												<?php echo $v['COUNTRY_NAME_EN'] ?>
												<br>
												<?php echo number_format($v['NUM']); ?> คน
											</td>
											<!-- <td style="font-size: 14px; color: #193666; font-weight: bold; width: 10%; text-align: center;border-bottom:<?php echo $c == 10 ? '' : '1px solid white' ?>;">
											<img src="<?php echo base_url('public/img/arrowup1.png') ?>" alt="">
										</td> -->
										</tr>
									</table>

								</div>
						<?php if ($c == 5) break;
							}
						} ?>
					</div>
				</div>
			</div>
			<div class="col12" style="padding-top:3px; ">
				<table style="width: 100%;">
					<tbody>
						<tr style="border: 0;">
							<td colspan="3" style="text-align: center;padding: 0px 0px; margin: auto 0px;">
								<div id="" class="" style="padding-top: 0px;padding-bottom: 0px; margin: 0px;font-weight:bold; font-size: 16px; color: #CC409E;">จำนวนนักท่องเที่ยว ตลาดระยะไกล 5 อันดับแรก</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<div class="col6">
					<p class="" style="font-size: 13px;text-align: center;margin:0px; font-weight: bold; color: #CC409E;"><?php echo $Mydate->date_eng2thai($to_date, 543) ?></p>

					<div id="resultsTableMarket1" style=" flex-direction: row; padding: 0px 5px;">

						<?php $c = 0;
						$i = 1;
						if (!empty($SumMarketDate['Long'])) {
							foreach ($SumMarketDate['Long'] as $v) {
								$c++;
								$flag = base_url('public/img/logotat.png');
								$number_icon3_1  = base_url('public/img/Number_icon/number_' . $c . '.png');
								if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
									$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
								}
								$icon = '';
								if (!empty($numberMarketDay['Long'][$v['COUNTRY_ID']])) {
									if ($i == $numberMarketDay['Long'][$v['COUNTRY_ID']]) {
										$icon = '';
									} else if ($i < $numberMarketDay['Long'][$v['COUNTRY_ID']]) {
										$icon = '<img src="' . base_url('public/img/arrowup1.png') . '" alt="">';
									} else if ($i > $numberMarketDay['Long'][$v['COUNTRY_ID']]) {
										$icon = '<img src="' . base_url('public/img/arrowdown1.png') . '" alt="">';
									}
								}
								$i++;
						?>
								<div style="border: 0; ">
									<table style="width: 100%;">
										<tr>
											<td style="width: 10%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;">
												<img class="img-profile rounded-circle" src="<?php echo $number_icon3_1 ?>" style="height: 34px; ">
											</td>
											<td style="text-align: left; padding: 4.8px 15px;color: white; font-size: 16.5px;font-weight: bold; width: 90%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;">
												<?php echo $v['COUNTRY_NAME_EN'] ?>
												<br>
												<?php echo number_format($v['NUM']); ?> คน
											</td>
											<!-- <td style="font-size: 14px; color: #193666; font-weight: bold; width: 10%; text-align: center;border-bottom:<?php echo $c == 10 ? '' : '1px solid white' ?>;">
											<?php echo $icon ?>
										</td> -->
										</tr>
									</table>
								</div>
						<?php if ($c == 5) break;
							}
						} ?>
					</div>
				</div>
				<div class="col6">
					<p class="" style="font-size: 13px;text-align: center;margin:0px; font-weight: bold; color: #CC409E;">สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?></p>


					<div id="resultsTableMarket2" style=" flex-direction: row; padding: 0px 5px;">

						<?php $c = 0;
						if (!empty($SumMarketMonth['Long'])) {
							foreach ($SumMarketMonth['Long'] as $v) {
								$c++;
								$flag = base_url('public/img/logotat.png');
								$number_icon3_2  = base_url('public/img/Number_icon/number2_' . $c . '.png');
								if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
									$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
								}
						?>
								<div style="border: 0; ">

									<div id="">
										<table style="width: 100%;">
											<tr>
												<td style="width: 10%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;">
													<img class="img-profile rounded-circle" src="<?php echo $number_icon3_2 ?>" style="height: 34px; ">
												</td>
												<td style="text-align: left; padding: 4.8px 15px;color: #193666; font-size: 16.5px;font-weight: bold; width: 90%; border-bottom:  <?php echo $c == 10 ? '' : '1px solid white' ?>;">
													<?php echo $v['COUNTRY_NAME_EN'] ?>
													<br>
													<?php echo number_format($v['NUM']); ?> คน
												</td>
												<!-- <td style="font-size: 14px; color: #193666; font-weight: bold; width: 10%; text-align: center;border-bottom:<?php echo $c == 10 ? '' : '1px solid white' ?>;">
												<img src="<?php echo base_url('public/img/arrowup1.png') ?>" alt="">
											</td> -->
											</tr>
										</table>
									</div>
								</div>
						<?php if ($c == 5) break;
							}
						} ?>
					</div>
				</div>
			</div>

			<div style="position: absolute; top: 700px; right: 45px; width:100%;">
				<p style="line-height: 15px;font-weight: bold; padding-top:2px; color: #fff; font-size:10px; color: #163868;">
					หมายเหตุ : <br>
					1. ข้อมูลจำแนกรายสัญชาติ (Nationality) ที่มีการกำหนดหลักเกณฑ์การคำนวณนักท่องเที่ยวระหว่างประเทศ (สามารถอ่านเพิ่มเติมได้ที่นิยามในระบบฯ) <br>
					2. ข้อมูลรวมสะสมในระบบมีความแตกต่างจากข้อมูลรวมสะสมของกระทรวงการท่องเที่ยวและกีฬา ประมาณร้อยละ 1-3 เนื่องจากมีการ Cleansing ข้อมูลรายเดือน และยังไม่นับรวมนักท่องเที่ยวที่เดินทางเข้าประเทศไทยโดยใช้ Border Pass
				</p>
			</div>
		</div>
	</div>
	<div style="font-weight: bold;position: absolute;top: 20%; left: 49.2%;rotate:-90;color: red; font-size: 20px;">
		ใช้เฉพาะภายใน ททท. เท่านั้น ¦ Internal Use Only
	</div>
	<div style="position: absolute;top: 97%; left: 5%;color: red; font-size: 20px;">
		<p style="opacity: 0.3;font-size:10px;color: #a1afc2;"><?php echo date('d/m/Y H:i:s:') . $session->get('org_id');; ?></p>
	</div>
</body>