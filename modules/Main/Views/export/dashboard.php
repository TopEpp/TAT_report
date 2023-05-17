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
		width: 25%;
		float: left;
		padding-top: 1%;
	}

	.col12 {
		width: 100%;
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
		height: 315px;
		width: 210px;
		background: #a7ffff;
		overflow: hidden;
		border-radius: 25px !important;
		margin: auto auto;
	}

	#resultsTable3 {
		height: 37px;
		width: 210px;
		background: white;
		overflow: hidden;
		border-radius: 25px !important;
		margin: auto auto;
		box-shadow: 0px 3px 10px 0px hsl(0, 7%, 50%)
	}

	#resultsTable2 {
		width: 210px;
		height: 315px;
		background: #fff1cc;
		overflow: hidden;
		border-radius: 25px !important;
		margin: auto auto;
	}

	#resultsTable4 {
		height: 40px;
		width: 180px;
		background: white;
		overflow: hidden;
		border-radius: 30px !important;
		margin: auto auto;
		box-shadow: 0px 5px 5px 0px hsl(0, 7%, 50%)
			/* box-shadow:  1px 0px 3px 0px; */
	}
</style>
<!-- <div class="row">
	<div class="col-md-6" style="font-size: 1.4em;">
		<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
	</div>
	<div class="col-md-6"></div>
</div>

<div class="row">
	<div class="col-6">
		<div class="card" style="background-image: url('<?php echo base_url('public/img/bg_info.png') ?>'); background-repeat: no-repeat; background-position:left bottom;margin: 10px 10px ">
			<div class="card-body" style="height: auto;">
				<div class="row">
					<div class="col-md-4" style="text-align:start; padding:0px 60px">
						<img src=" <?php echo base_url('public/img/icon_info1.png') ?>">
					</div>
					<div class="col-md-8" style="text-align:right; font-weight: bold; line-height:1.5em; font-size: 1.1em; ">
						จำนวนนักท่องเที่ยว<br>
						วันที่ <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?><br>
						<div style="padding:5px; background:#ededed; border-radius: 5px; width: 50%; font-size: 1.8em; font-weight: bold;margin-left:auto">
							<?php echo number_format($SumDateData); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-6">
		<div class="card" style="background-image: url('<?php echo base_url('public/img/bg_info.png') ?>'); background-repeat: no-repeat; background-position:left bottom;margin: 10px 10px ">
			<div class="card-body" style="height: auto;">
				<div class="row">
					<div class="col-md-4 col-4" style="text-align:start;padding:0px 60px"><img src="<?php echo base_url('public/img/icon_info2.png') ?>"></div>
					<div class="col-md-8 col-8" style="text-align:right; font-weight: bold; line-height: 1.5em; font-size: 1.1em;">
						จำนวนนักท่องเที่ยวสะสม<br>
						วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?> <br>
						<div style="padding:5px; background:#ededed; border-radius: 5px; width: 50%; font-size: 1.8em; font-weight: bold;margin-left:auto">
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
			<div class="card-body" style="width: 100%;">
				<div class="text-center" id="htmltoimage_chart_daily" style="height:280px;">
					<img src="<?php echo base_url('public/uploads/main/' . $to_date . 'chart_daily.png') ?>" style="width:100%; height:250px">
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
</div> -->
<!-- <pagebreak> -->
<!-- <div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">จำนวนนักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3" style="padding: 0px 15px 20px 15px;">
						<div class="card">
							<div class="card-body" style="background: #eaf3f4; padding: 15px 0px; border-radius: 0.35rem;">
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
										<span style="font-size:18px">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543) ?></span>
									</div>
									<hr>
									<table style="width: 100%;">
										<tbody>
											<?php $c = 0;
											foreach ($SumNatDateData as $v) {
												$c++;
												$flag = base_url('public/img/logotat.png');

												if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
													$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
												}
											?>
												<tr>
													<td style="padding: 6px 50px">
														<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 52px; ">
													</td>
													<td style="padding: 6px 50px">
														<span id="" style="font-weight:bold; font-size: 0.9em;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
													</td>
													<td style="padding: 6px 50px">
														<?php echo number_format($v['NUM']); ?>
													</td>
												</tr>
											<?php if ($c == 5) break;
											} ?>
										</tbody>
									</table>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-3" style="padding: 0px 15px 25px 15px;">
						<div class="card">
							<div class="card-body" style="background: #eaf3f4; padding: 15px 0px; border-radius: 0.35rem;">
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
										<span style="font-size:18px">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></span>
									</div>
									<hr>
									<table style="width: 100%;">
										<tbody>
											<?php $c = 0;
											foreach ($SumNatMonthData as $v) {
												$c++;
												$flag = base_url('public/img/logotat.png');

												if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
													$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
												}
											?>
												<tr>
													<td style="padding: 6px 50px">
														<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 52px;">
													</td>
													<td style="padding: 6px 50px">
														<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
													</td>
													<td style="padding: 6px 50px">
														<?php echo number_format($v['NUM']); ?>
													</td>
												</tr>
											<?php if ($c == 5) break;
											} ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3" style="padding: 0px 15px 25px 15px;">
						<div class="card">
							<div class="card-body" style="background: #a2e4d8; padding: 0; border-radius: 0.35rem;">
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายด่าน</span><br>
										<span style="font-size:18px">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543) ?></span>
									</div>
									<hr>
									<table style="width: 100%;">
										<tbody>
											<?php $c = 0;
											foreach ($SumPortDateData as $v) {
												$c++;  ?>
												<tr>
													<td style="text-align: center;padding: 10px 70px">
														<?php if ($v['PORT_TYPE'] == 'ด่านอากาศ') {
														?>
															<img src='<?php echo base_url('public/img/airplan.png') ?>' alt='' style="height: 35px;">
														<?php
														} else {
														?>
															<img src=<?php echo base_url('public/img/building.png') ?> alt="" style="height: 35px;">
														<?php
														} ?>
													</td>
													<td style="text-align: start;padding: 10px 50px">
														<span style="font-weight:bold; font-size: 0.85em;"><?php echo $v['PORT_NAME'] ?></span>
													</td>
													<td style="text-align: start;padding: 10px 50px">
														<?php echo number_format($v['NUM']); ?>
													</td>
												</tr>
											<?php if ($c == 5) break;
											} ?>
										</tbody>
									</table>
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
										<span style="font-size:18px">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></span>
									</div>
									<hr>
									<table style="width: 100%;">
										<tbody>
											<?php $c = 0;
											foreach ($SumPortMonthData as $v) {
												$c++;  ?>
												<tr>
													<td style="text-align: center;padding: 10px 70px">
														<?php if ($v['PORT_TYPE'] == 'ด่านอากาศ') {
														?>
															<img src='<?php echo base_url('public/img/airplan.png') ?>' alt='' style="height: 35px;">
														<?php
														} else {
														?>
															<img src=<?php echo base_url('public/img/building.png') ?> alt="" style="height: 35px;">
														<?php
														} ?>
													</td>
													<td style="text-align: start;padding: 10px 50px">
														<span style="font-weight:bold; font-size: 0.85em;"><?php echo $v['PORT_NAME'] ?></span>
													</td>
													<td style="text-align: start;padding: 10px 50px">
														<?php echo number_format($v['NUM']); ?>
													</td>
												</tr>
											<?php if ($c == 5) break;
											} ?>
										</tbody>
									</table>
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
</div> -->

<body>
	<table style="width: 100%;padding-bottom: 25px;">
		<thead>
			<tr>
				<td style="width: 5%; text-align: center;margin: auto 0px;">
					<img src="<?php echo base_url('public/img/TATIC-Logo.png') ?>" alt="" style="width: 200px;">
				</td>
				<td style="text-align: center; color: white;width: 90%;">
					<p style="margin: 0px; line-height: normal; font-size: 45px;">
						สถิตินักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย
					</p>
					<h3 style="margin: 0px; line-height: normal; font-size: 40;">
						วันที่ <?php echo $Mydate->date_eng2thai($to_date, 543) ?>
					</h3>
					<span style="font-size: 20px;">
						ที่มา สำนักงานตรวจคนเข้าเมือง | จัดทำโดย ด้านดิจิทัล วิจัย เเละพัฒนา
					</span>
				</td>
				<td style="width: 5%;text-align: center;">
					<img src="<?php echo base_url('public/img/amazing-th.png') ?>" alt="" style="width: 150px; padding-left: 35px;">
				</td>
			</tr>
		</thead>
	</table>
	<div class="col12">
		<div class="col4">
			<div id="resultsTableForCard" style="margin-bottom: 10px;">
				<table class="table">
					<tbody style="line-height: 1.5em;">
						<tr style="text-align:center; border: 0;">
							<td style="padding: 20px 0px 0px 0px; font-size: 15px; text-align: center; font-weight: bold;">
								จำนวนนักท่องเที่ยว
							</td>
						</tr>
					</tbody>
				</table>
				<div id="resultsTable4">
					<table style="width: 100%;">
						<tbody>
							<tr style="border: 0;padding: 0px 0px;">
								<td style="text-align: center;padding: 5px ; font-size: 25px;">
									<?php echo number_format($SumDateData); ?> คน
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div id="resultsTableForCard2">
				<table class="table">
					<tbody style="line-height: 1em;">
						<tr style="text-align: center; border: 0;">
							<td style="padding: 20px 0px 0px 0px; font-size: 15px; text-align: center; font-weight: bold;">
								สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
							</td>
						</tr>
					</tbody>
				</table>
				<div id="resultsTable4">
					<table style="width: 100%;">
						<tbody>
							<tr style="border: 0;padding: 0px 0px;">
								<td style="text-align: center;padding: 5px; font-size: 25px;">
									<?php echo number_format($SumMonthData); ?> คน
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col8">
			<img src="<?php echo base_url('public/uploads/main/' . $to_date . 'chart_daily.png') ?>" style="width:100%; height:210px">
		</div>
	</div>


	<div style="position: absolute; top: 308px; left: 20px;">
		<img src="<?php echo base_url('public/img/tourist.png') ?>" alt="" style="width: 90px;">
	</div>
	<div style="position: absolute; top: 355px; left: 100px;">
		<img src="<?php echo base_url('public/img/destination.png') ?>" alt="" style="width: 45px;">
	</div>
	<div style="position: absolute; top: 375px; right: 470px;">
		<img src="<?php echo base_url('public/img/airplaneICON.png') ?>" alt="" style="width: 100px;">
	</div>
	<div class="vl"></div>
	<table style="width: 100%; margin-top: 10px;">
		<tbody>
			<tr style="padding: 0px 50px;">
				<td style="text-align: center;font-size: 20px; color: white; padding-left: 50px; width: 50%;">
					จำนวนนักท่องเที่ยว
					<br>
					จำเเนกรายสัญชาติ 5 อันดับเเรก
				</td>
				<td style="width: 50%; text-align: center; font-size: 20px; padding-left:50px; color: white;">
					จำนวนนักท่องเที่ยว <br>จำเเนกรายด่าน 5 อันดับเเรก
				</td>
			</tr>
		</tbody>
	</table>
	<div class="col12">
		<div class="col6">
			<div id="resultsTable" style="display: flex; flex-direction: row; padding: 0px 15px;">
				<?php $c = 0;
				foreach ($SumNatDateData as $v) {
					$c++;
					$flag = base_url('public/img/logotat.png');

					if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
						$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
					}
				?>
					<div style="border: 0;">
						<table style="width: 100%;">
							<tbody>
								<tr style="border: 0;">
									<td colspan="3" style="text-align: right;padding: 3px 13px;">
										<span id="" style="font-weight:bold; font-size: 14px;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
									</td>
								</tr>
							</tbody>
						</table>
						<div id="resultsTable3">
							<table style="width: 100%;">
								<tr>
									<td style="">
										<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 35px; ">
									</td>
									<td>
										<?php echo number_format($v['NUM']); ?>
									</td>
									<td>
										คน
									</td>
								</tr>
							</table>
						</div>
					</div>
				<?php if ($c == 5) break;
				} ?>
			</div>
		</div>
		<div class="col6">
			<div id="resultsTable2" style="display: flex; flex-direction: row; padding: 0px 15px;">
				<?php $c = 0;
				foreach ($SumNatMonthData as $v) {
					$c++;
					$flag = base_url('public/img/logotat.png');

					if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
						$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
					}
				?>
					<div style="border: 0;">
						<table style="width: 100%;">
							<tbody>
								<tr style="border: 0;">
									<td colspan="3" style="text-align: right;padding: 3px 13px;">
										<span id="" style="font-weight:bold; font-size: 14px;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
									</td>
								</tr>
							</tbody>
						</table>
						<div id="resultsTable3">
							<table style="width: 100%;">
								<tr>
									<td style="">
										<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 35px; ">
									</td>
									<td>
										<?php echo number_format($v['NUM']); ?>
									</td>
									<td>
										คน
									</td>
								</tr>
							</table>
						</div>
					</div>
				<?php if ($c == 5) break;
				} ?>
			</div>
		</div>

		<div class="col6">
			<div id="resultsTable" style="display: flex; flex-direction: row; padding: 0px 15px;">
				<?php $c = 0;
				foreach ($SumPortDateData as $v) {
					$c++;  ?>
					<div>
						<table style="width: 100%;">
							<tbody>
								<tr style="border: 0;">
									<td colspan="2" style="color: #193666; text-align: right; padding: 3px 13px; margin: auto 0px;">
										<span style="font-weight:bold; font-size: 14px;"><?php echo $v['PORT_NAME'] ?></span>
									</td>
								</tr>
							</tbody>
						</table>
						<div id="resultsTable3">
							<table style="width: 100%;">
								<tr>
									<td style="text-align: center; padding: 10.5px 15px;color: #193666; font-size: 14px;">
										<?php echo number_format($v['NUM']); ?>
									</td>
									<td>
										คน
									</td>
								</tr>
							</table>
						</div>
					</div>
				<?php if ($c == 5) break;
				} ?>
			</div>
		</div>
		<div class="col6">
			<div id="resultsTable2" style="display: flex; flex-direction: row; padding: 0px 15px;">
				<?php $c = 0;
				foreach ($SumPortMonthData as $v) {
					$c++;  ?>
					<div>
						<table style="width: 100%;">
							<tbody>
								<tr style="border: 0;">
									<td colspan="2" style="color: #193666; text-align: right; padding: 3px 13px; margin: auto 0px;">
										<span style="font-weight:bold; font-size: 14px;"><?php echo $v['PORT_NAME'] ?></span>
									</td>
								</tr>
							</tbody>
						</table>
						<div id="resultsTable3">
							<table style="width: 100%;">
								<tr>
									<td style="text-align: center; padding: 10.5px 15px;color: #193666; font-size: 14px;">
										<?php echo number_format($v['NUM']); ?>
									</td>
									<td>
										คน
									</td>
								</tr>
							</table>
						</div>
					</div>
				<?php if ($c == 5) break;
				} ?>
			</div>
		</div>
	</div>
</body>