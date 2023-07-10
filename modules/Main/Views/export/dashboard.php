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
		/* padding-top: 1%; */
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
		height: 350px;
		width: 210px;
		background: #a7ffff;
		overflow: hidden;
		border-radius: 25px !important;
		margin: 0px auto;
		/* position: absolute; */
	}

	#resultsTable3 {
		height: 20px;
		width: 210px;
		background: white;
		overflow: hidden;
		border-radius: 6px !important;
		margin: auto auto;
		box-shadow: 0px 5px 8px 0px hsl(0, 7%, 50%);
	}

	#resultsTable2 {
		width: 210px;
		height: 359px;
		background: #fff1cc;
		overflow: hidden;
		border-radius: 25px !important;
		margin: 0px auto;
	}

	#resultsTable4 {
		height: 40px;
		width: 180px;
		background: white;
		overflow: hidden;
		border-radius: 6px !important;
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
					<p style="margin: 0px; font-weight:bold; line-height: normal; font-size: 31px;">
						สถิตินักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย
					</p>
					<h3 style="margin: 0px; line-height: normal; font-size: 31px; font-weight:bold;">
						วันที่ <?php echo $Mydate->date_eng2thai($to_date, 543) ?>
					</h3>
					<span style="font-size: 14px;">
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
								<td style="text-align: center;padding: 5px ; font-size: 25px;font-weight: bold;">
									<?php echo number_format($SumDateData); ?> คน
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div id="resultsTableForCard2">
				<table class="table">
					<tbody style="line-height: 0.5em;">
						<tr style="text-align: center; border: 0;">
							<td style="padding: 7px 0px 0px 0px; font-size: 15px; text-align: center; font-weight: bold;">
								สะสม <br>
								<?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
							</td>
						</tr>
					</tbody>
				</table>
				<div id="resultsTable4">
					<table style="width: 100%;">
						<tbody>
							<tr style="border: 0;padding: 0px 0px;">
								<td style="text-align: center;padding: 5px; font-size: 25px;font-weight: bold;">
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


	<div style="position: absolute; top: 295px; left: 40px;">
		<img src="<?php echo base_url('public/img/tourist.png') ?>" alt="" style="width: 65px;">
	</div>
	<div style="position: absolute; top: 330px; left: 110px;">
		<img src="<?php echo base_url('public/img/destination.png') ?>" alt="" style="width: 32px;">
	</div>
	<div style="position: absolute; top: 340px; right: 480px;">
		<img src="<?php echo base_url('public/img/airplaneICON.png') ?>" alt="" style="width: 100px;">
	</div>
	<div class="vl"></div>
	<table style="width: 100%; margin-top: 8px; padding: 0px;">
		<tbody>
			<tr style="padding: 0px 50px;">
				<td style="text-align: center;font-size: 18px; color: white; padding-left: 50px; width: 50%;font-weight: bold;">
					จำนวนนักท่องเที่ยว
					<br>
					จำเเนกรายสัญชาติ 5 อันดับเเรก
				</td>
				<td style="width: 50%; text-align: center; font-size: 18px; padding-left:50px; color: white;font-weight: bold;">
					จำนวนนักท่องเที่ยว <br>จำเเนกรายด่าน 5 อันดับเเรก
				</td>
			</tr>
		</tbody>
	</table>
	<div class="col12">
		<div class="col6">
			<div id="resultsTable" style="display: flex; flex-direction: row; padding: 0px 15px;">
				<table style="width: 100%;">
					<tbody>
						<tr>
							<td colspan="3" style="padding-bottom: 6px; text-align: center;padding-top: 8px;color: #193666;font-weight: bold;font-size: 15px;">
								จำแนกรายสัญชาติ<br>
								<?php echo $Mydate->date_eng2thai($to_date, 543) ?>
							</td>
						</tr>
					</tbody>
				</table>
				<?php $c = 0;
				foreach ($SumNatDateData as $v) {
					$c++;
					$flag = base_url('public/img/logotat.png');

					if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
						$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
					}
				?>
					<div style="border: 0; padding-bottom: 5px; ">
						<table style="width: 100%;">
							<tbody>
								<tr style="border: 0;">
									<td colspan="3" style="text-align: right;padding: 0px 10px; margin: auto 0px;">
										<span id="" style="font-weight:bold; font-size: 14px;color: #193666;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
									</td>
								</tr>
							</tbody>
						</table>
						<div id="resultsTable3">
							<table style="width: 100%;">
								<tr style="border: 0;">
									<td style="width: 15%;">
										<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 34px; ">
									</td>
									<td style="text-align: right; padding: 8.5px 14px;color: #193666; font-size: 20px;font-weight: bold; width: 55%;">
										<?php echo number_format($v['NUM']); ?>
									</td>
									<td style="font-size: 14px; color: #193666; font-weight: bold; width: 30%; text-align: left;">
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
			<div id="resultsTable2" style="display: flex; flex-direction: row; padding: 0px 15px; ">
				<table style="width: 100%;">
					<tbody>
						<tr>
							<td colspan="3" style="padding-bottom: 6px; text-align: center;padding-top: 8px;color: #193666;font-weight: bold;font-size: 15px;">
								จำแนกรายสัญชาติสะสม<br>
								<?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
							</td>
						</tr>
					</tbody>
				</table>
				<?php $c = 0;
				foreach ($SumNatMonthData as $v) {
					$c++;
					$flag = base_url('public/img/logotat.png');

					if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
						$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
					}
				?>
					<div style="border: 0;padding-bottom: 5px; ">
						<table style="width: 100%;">
							<tbody>
								<tr style="border: 0;">
									<td colspan="3" style="text-align: right;padding: 0px 13px; margin: auto 0px;">
										<span id="" style="font-weight:bold; font-size: 14px;color: #193666;"><?php echo $v['COUNTRY_NAME_EN'] ?></span>
									</td>
								</tr>
							</tbody>
						</table>
						<div id="resultsTable3">
							<table style="width: 100%;">
								<tr>
									<td style="width: 15%;">
										<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 34px;">
									</td>
									<td style="text-align: right; padding: 8.5px 14px;color: #193666; font-size: 20px;font-weight: bold; width: 55%;">
										<?php echo number_format($v['NUM']); ?>
									</td>
									<td style="font-size: 14px; color: #193666; font-weight: bold; width: 30%; text-align: left;">
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
				<table style="width: 100%;">
					<tbody>
						<tr>
							<td colspan="3" style="text-align: center;padding-top: 8px;padding-bottom: 5px;color: #193666;font-weight: bold;font-size: 15px;">
								จำแนกรายด่าน<br>
								<?php echo $Mydate->date_eng2thai($to_date, 543) ?>
							</td>
						</tr>
					</tbody>
				</table>
				<?php $c = 0;
				foreach ($SumPortDateData as $v) {
					$c++;  ?>
					<div style="padding-bottom: 5px;">
						<table style="width: 100%;">
							<tbody>
								<tr style="border: 0;">
									<td colspan="2" style="color: #193666; text-align: right; padding: 0px 13px; margin: auto 0px;">
										<span style="font-weight:bold; font-size: 14px;"><?php echo $v['PORT_NAME'] ?></span>
									</td>
								</tr>
							</tbody>
						</table>
						<div id="resultsTable3">
							<table style="width: 100%;">
								<tr>
									<td style="text-align: right; padding: 8.5px 14px;color: #193666; font-size: 20px;font-weight: bold;">
										<?php echo number_format($v['NUM']); ?>
									</td>
									<td style="font-size: 14px; color: #193666; font-weight: bold;">
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
				<table style="width: 100%; ">
					<tbody>
						<tr>
							<td colspan="3" style="text-align: center;padding-top: 8px;padding-bottom: 5px;  color: #193666;font-weight: bold;font-size: 15px;">
								จำแนกรายด่าน<br>
								<?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
							</td>
						</tr>
					</tbody>
				</table>
				<?php $c = 0;
				foreach ($SumPortMonthData as $v) {
					$c++;  ?>
					<div style="padding-bottom: 5px; ">
						<table style="width: 100%;">
							<tbody>
								<tr style="border: 0;">
									<td colspan="2" style="color: #193666; text-align: right; padding: 0px 13px; margin: auto 0px;">
										<span style="font-weight:bold; font-size: 14px;"><?php echo $v['PORT_NAME'] ?></span>
									</td>
								</tr>
							</tbody>
						</table>
						<div id="resultsTable3">
							<table style="width: 100%;">
								<tr>
									<td style="text-align: right; padding: 8.5px 12px;color: #193666; font-size: 20px;font-weight: bold;">
										<?php echo number_format($v['NUM']); ?>
									</td>
									<td style="font-size: 14px; color: #193666;font-weight: bold;">
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
	<br>
	<p style="margin-left:20px; padding-top:5px; color: #fff; font-size:0.8em">หมายเหตุ : ข้อมูลรายสัญชาติตัดข้อมูลผู้อพยพ, หน่วยงานพิเศษ UN , ไม่มีสัญชาติ ออก ทั้งนี้ ตั้งแต่ 1 ม.ค. 66 ได้กำหนดหลักเกณฑ์การคำนวณนักท่องเที่ยวระหว่างประเทศเพิ่มเติม (สามารถอ่านเพิ่มเติมได้ที่นิยามในระบบฯ)</p>
</body>