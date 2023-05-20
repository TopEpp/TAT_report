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

	@media (max-width: 576px) {}
</style>

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