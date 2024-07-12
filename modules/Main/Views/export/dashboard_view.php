<link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.css') ?>">

<style>
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

	.col1 {
		width: 10%;
		float: left;
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

	.col11 {
		width: 90%;
		float: left;
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

	.btn {
		cursor: pointer;
	}

	.btn_Color {
		background-color: #3eabae;
		color: white;
		width: 100%;
	}

	.btn-danger {
		color: #fff;
		background-color: #e74a3b;
		border-color: #e74a3b;
	}

	#rotate-text {
		-webkit-transform: rotate(90deg);
		-moz-transform: rotate(90deg);
		-o-transform: rotate(90deg);
		-ms-transform: rotate(90deg);
		transform: rotate(90deg);
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
	<div class="row" style="margin: 0px;">
		<div class="col-lg-1 col-12 text-center text-md-right">
			<img class="img-profile rounded-circle" src="<?php echo base_url('public/img/logotat.png') ?>">
		</div>
		<div class="col-lg-11 col-12  my-md-auto text-center text-md-right my-3">
			<div>
				<button type="button" onclick="SaveImg2ExportImg('<?php echo base_url('main/saveImg2Report'); ?>')" class="btn btn-success">
					<i class="fa-solid fa-file-pdf"></i> JPG
				</button>
				<button type="button" onclick="window.open('<?php echo base_url('main/export_dashboard_v2?start_date=' . $start_date . '&end_date=' . $end_date); ?>')" class="btn btn-danger SetWidthbtnExport shadow-1">
					<i class="fa-solid fa-file-pdf"></i> PDF
				</button>
			</div>
		</div>
	</div>
	<div class="row" id="htmltoimage_info_dashboard">
		<div class="col-lg-12" style="border: 1px #ccc solid;">
			<div class="row">
				<div class="col-lg-6 ">
					<div class="row">
						<div class="col-lg-11 pr-0">
							<div class="mx-3 backgroundColorBox1">
								<div style="padding-left: 40px; padding-right: 40px;">
									<p style="margin: 0px; font-weight:bold; line-height: normal; font-size: 30px;">
										สถิตินักท่องเที่ยวระหว่างประเทศ
										<br>
										ที่เดินทางเข้าประเทศไทย
									</p>
									<h3 style="margin: 0px; line-height: normal; font-size: 30px; font-weight:bold; color: #E8D023;">
										วันที่ <?php echo $Mydate->date_eng2thai($to_date, 543) ?>
									</h3>
									<div style="font-size: 13px; color: white; margin: 0px; padding-top: 6px; padding-bottom: 6px;">
										ที่มา สำนักงานตรวจคนเข้าเมือง | จัดทำโดย ด้านดิจิทัล วิจัย เเละพัฒนา
									</div>
								</div>
							</div>
							<div class="row" style="margin: 0px;">
								<div class="col-lg-6 text-center">
									<div class="row" style="margin: 0px;">
										<div class="col-lg-12">
											<div style="padding: 10px 0px 0px 0px; font-size: 17px; text-align: center; font-weight: bold;" class="colorText">
												จำนวนนักท่องเที่ยว
											</div>
										</div>
										<div class="col-lg-12 " style="background-color: #73A0E0; border-radius: 30px;">
											<div style="color: white;text-align: center;padding: 5px 10px ; font-size: 25px;font-weight: bold;">
												<?php echo number_format($SumDateData); ?> คน
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6 text-center">
									<div class="row" style="margin: 0px;">
										<div class="col-lg-12 colorText" style="padding: 10px 0px 0px 0px; font-size: 17px; text-align: center; font-weight: bold;">
											สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
										</div>
										<div class="col-lg-12" style="background-color: #DDC354; border-radius: 30px;">
											<div style="color: white;text-align: center;padding: 5px 10px ; font-size: 25px;font-weight: bold; color:#163868">
												<?php echo number_format($SumMonthData); ?> คน
											</div>

										</div>
									</div>
								</div>
								<div class="col-lg-12 text-center mt-1" style="text-align: center;font-size: 17px;width: 100%;font-weight: bold; color: #163868;">
									จำนวนนักท่องเที่ยว จำแนกรายสัญชาติ 10 อันดับแรก
								</div>
								<div class="col-lg-6 text-center">
									<div class="row">
										<div class="col-lg-12" style="color: #193666;font-weight: bold;font-size: 17px;">
											<?php echo $Mydate->date_eng2thai($to_date, 543) ?>
										</div>
										<div class="col-lg-12">
											<div style="background-color: #73A0E0; border-radius: 20px;">
												<?php $c = 0;
												$i = 1;
												foreach ($SumNatDateData as $v) {
													$c++;
													$flag = base_url('public/img/logotat.png');

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

													<div class="d-flex align-items-center" style="border-bottom:<?php echo $c == 10 ? '' : '1px solid #FFFFFF' ?>;">
														<div class="text-center" style="padding: 6px 16.5px;">
															<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 40px; ">
														</div>
														<div style="text-align: left; padding: 6.4px 16.5px;color: white; font-size: 16.5px;font-weight: bold; width: 90%;">
															<?php echo $v['COUNTRY_NAME_EN'] ?>
															<br>
															<?php echo number_format($v['NUM']); ?> คน
														</div>
													</div>
												<?php if ($c == 10) break;
												} ?>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6 text-center">
									<div class="row">
										<div class="col-lg-12" style="color: #193666;font-weight: bold;font-size: 17px;">
											สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
										</div>
										<div class="col-lg-12">
											<div style="background-color: #DDC354; border-radius: 20px;">
												<?php $c = 0;
												$i = 1;
												foreach ($SumNatMonthData as $v) {
													$c++;
													$flag = base_url('public/img/logotat.png');

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

													<div class="d-flex align-items-center" style="border-bottom:<?php echo $c == 10 ? '' : '1px solid #FFFFFF' ?>;">
														<div class="text-center" style="padding: 6px 16.5px;">
															<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 40px; ">
														</div>
														<div style="text-align: left; padding: 6.4px 16.5px;color: #163868; font-size: 16.5px;font-weight: bold; width: 90%;">
															<?php echo $v['COUNTRY_NAME_EN'] ?>
															<br>
															<?php echo number_format($v['NUM']); ?> คน
														</div>
													</div>
												<?php if ($c == 10) break;
												} ?>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-12 text-center mt-3">
									<p class="m-0" style="opacity: 0.3;font-size:10px;color: #a1afc2;"><?php echo date('d/m/Y H:i:s:') . $session->get('org_id');; ?></p>
								</div>
							</div>
						</div>
						<div class="col-lg-1 my-auto text-center p-0">
							<div class="mt-1" style="position: absolute;left: -160px;top: 0px;width: max-content;height: 20px;font-size:12px;color:#333;transform: rotate(270deg);color: red;font-size: 19px;">
								ใช้เฉพาะภายใน ททท. เท่านั้น ¦ Internal Use Only
							</div>
						</div>

					</div>
				</div>

				<div class="col-lg-6 px-3">
					<div class="row">
						<div class="col-lg-12 text-center mt-2">
							<img src="<?php echo base_url('public/img/amezingThai.png') ?>" alt="" style=" margin-right: 10px;height: 50px;">
							<img src="<?php echo base_url('public/img/TATIC-Logo.png') ?>" alt="" style="height:50px ;margin-left: 10px;">
						</div>
						<div class="col-lg-12">
							<img src="<?php echo base_url('public/uploads/main/' . $to_date . 'chart_daily_year.png') ?>" style="width:100%;height:160px;">
						</div>
						<div class="col-lg-12 text-center colorTextLeft" style="font-weight:bold; font-size: 16px; ">
							จำนวนนักท่องเที่ยว ตลาดระยะใกล้ 5 อันดับแรก
						</div>
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-6">
									<div class="text-center" style="color: #049b97; font-weight:bold; font-size: 16px; ">
										<?php echo $Mydate->date_eng2thai($to_date, 543) ?>
									</div>
									<div class="ms-3" style="background-color: #73A0E0; border-radius: 20px;">
										<?php $c = 0;
										$i = 1;
										if (!empty($SumMarketDate['Short'])) {
											foreach ($SumMarketDate['Short'] as $v) {
												$c++;
												$flag = base_url('public/img/logotat.png');

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
												<div class="d-flex align-items-center" style="border-bottom:<?php echo $c == 10 ? '' : '1px solid #FFFFFF' ?>;">
													<div class="text-center" style="padding: 6px 16.5px;">
														<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 40px; ">
													</div>
													<div style="text-align: left; padding: 6.4px 16.5px;color: white; font-size: 15.5px;font-weight: bold; width: 90%;">
														<?php echo $v['COUNTRY_NAME_EN'] ?>
														<br>
														<?php echo number_format($v['NUM']); ?> คน
													</div>
												</div>
										<?php if ($c == 5) break;
											}
										} ?>
									</div>

								</div>
								<div class="col-lg-6">
									<div class="text-center" style="color: #049b97; font-weight:bold; font-size: 16px; ">
										สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
									</div>
									<div style="background-color: #DDC354; border-radius: 20px;">
										<?php $c = 0;
										if (!empty($SumMarketMonth['Short'])) {
											foreach ($SumMarketMonth['Short'] as $v) {
												$c++;
												$flag = base_url('public/img/logotat.png');

												if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
													$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
												}
										?>
												<div class="d-flex align-items-center" style="border-bottom:<?php echo $c == 10 ? '' : '1px solid #FFFFFF' ?>;">
													<div class="text-center" style="padding: 6px 16.5px;">
														<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 40px; ">
													</div>
													<div style="text-align: left; padding: 6.4px 16.5px;color: #163868; font-size: 15.5px;font-weight: bold; width: 90%;">
														<?php echo $v['COUNTRY_NAME_EN'] ?>
														<br>
														<?php echo number_format($v['NUM']); ?> คน
													</div>
												</div>
										<?php if ($c == 5) break;
											}
										} ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 text-center" style="font-weight:bold; font-size: 16px; color: #d145a2;">
							จำนวนนักท่องเที่ยว ตลาดระยะไกล 5 อันดับแรก
						</div>
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-6">
									<div class="text-center " style="font-weight:bold; font-size: 16px; color: #d145a2;">
										<?php echo $Mydate->date_eng2thai($to_date, 543) ?>
									</div>
									<div class="ms-3" style="background-color: #73A0E0; border-radius: 20px;">
										<?php $c = 0;
										$i = 1;
										if (!empty($SumMarketDate['Long'])) {
											foreach ($SumMarketDate['Long'] as $v) {
												$c++;
												$flag = base_url('public/img/logotat.png');

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
												<div class="d-flex align-items-center" style="border-bottom:<?php echo $c == 10 ? '' : '1px solid #FFFFFF' ?>;">
													<div class="text-center" style="padding: 6px 16.5px;">
														<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 40px; ">
													</div>
													<div style="text-align: left; padding: 6.4px 16.5px;color: white; font-size: 15.5px;font-weight: bold; width: 90%;">
														<?php echo $v['COUNTRY_NAME_EN'] ?>
														<br>
														<?php echo number_format($v['NUM']); ?> คน
													</div>
												</div>
										<?php if ($c == 5) break;
											}
										} ?>
									</div>

								</div>
								<div class="col-lg-6">
									<div class="text-center " style="font-weight:bold; font-size: 16px; color: #d145a2;">
										สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?>
									</div>
									<div style="background-color: #DDC354; border-radius: 20px;">
										<?php $c = 0;
										if (!empty($SumMarketMonth['Long'])) {
											foreach ($SumMarketMonth['Long'] as $v) {
												$c++;
												$flag = base_url('public/img/logotat.png');

												if (!file_exists(base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png'))) {
													$flag = base_url('public/img/flag/' . $v['COUNTRY_ID'] . '.png');
												}
										?>
												<div class="d-flex align-items-center" style="border-bottom:<?php echo $c == 10 ? '' : '1px solid #FFFFFF' ?>;">
													<div class="text-center" style="padding: 6px 16.5px;">
														<img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="height: 40px; ">
													</div>
													<div style="text-align: left; padding: 6.4px 16.5px;color: #163868; font-size: 15.5px;font-weight: bold; width: 90%;">
														<?php echo $v['COUNTRY_NAME_EN'] ?>
														<br>
														<?php echo number_format($v['NUM']); ?> คน
													</div>
												</div>
										<?php if ($c == 5) break;
											}
										} ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 " style="font-weight: bold; color: #fff; font-size:10px; color: #163868;">
							หมายเหตุ : <br>
							1. ข้อมูลจำแนกรายสัญชาติ (Nationality) ที่มีการกำหนดหลักเกณฑ์การคำนวณนักท่องเที่ยวระหว่างประเทศ (สามารถอ่านเพิ่มเติมได้ที่นิยามในระบบฯ) <br>
							2. ข้อมูลรวมสะสมในระบบมีความแตกต่างจากข้อมูลรวมสะสมของกระทรวงการท่องเที่ยวและกีฬา ประมาณร้อยละ 1-3 เนื่องจากมีการ Cleansing ข้อมูลรายเดือน และยังไม่นับรวมนักท่องเที่ยวที่เดินทางเข้าประเทศไทยโดยใช้ Border Pass
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<!--  -->
	<div style="position: absolute;top: 60%; left: 36.5%;color: red; font-size: 20px;rotate:-90deg;">

	</div>
</body>
<script src="<?= base_url('public/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('public/js/common.js'); ?>"></script>

<script src="<?= base_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('public/vendor/bootstrap/datepicker/bootstrap-datepicker.js') ?>"></script>
<script src="<?= base_url('public/vendor/bootstrap/datepicker/locales/bootstrap-datepicker.th.js') ?>"></script>
<script src="<?= base_url('public/vendor/bootstrap/datepicker/bootstrap-datepicker-thai.js') ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('public/vendor/datatables/jquery.dataTables.js') ?>"></script>


<!-- Page level custom scripts -->
<script src="<?= base_url('public/js/sb-admin-2.min.js'); ?>"></script>
<script src="<?= base_url('public/js/jquery.toast.js'); ?>"></script>

<script src="<?= base_url('public/vendor/Sweetalert/js/sweetalert2.min.js'); ?>"></script>
<script src="<?= base_url('public/js/main.js'); ?>"></script>
<script src="<?= base_url('public/js/scripts.js'); ?>"></script>
<script src="<?php echo base_url('public/vendor/html2canvas/html2canvas.js'); ?>"></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';

	function SaveImg2ExportImg(url2SaveImg) {
		$('.btn-download').hide();
		$('#htmltoimage_chart_daily_year').show();
		setTimeout(function() {
			saveImg(url2SaveImg);
		}, 1000);

		// $.ajax({
		//     method: "POST",
		//     url: base_url + "/main/saveLog",
		//     data: {'type':'Daily'},
		//     success: function(res) {

		//     }
		// });

	}

	function saveImg(url2SaveImg) {
		const chart_array = ["info_dashboard"];
		var count_canvas = 0;
		$.each(chart_array, function(key, value) {
			var container = document.getElementById("htmltoimage_" + value);
			html2canvas(container, {
				allowTaint: true
			}).then(function(canvas) {

				var link = document.createElement("a");
				document.body.appendChild(link);
				link.download = "<?php echo $to_date; ?>" + value + ".png";
				link.href = canvas.toDataURL();
				link.target = '_blank';
				// console.log(link);
				var dataURL = link.href;
				var imgUrl = base_url + "/public/uploads/main/<?php echo $to_date; ?>" + value + ".jpg";
				$.post(url2SaveImg, {
					imgBase64: dataURL,
					imgName: "<?php echo $to_date; ?>" + value
				}, function(data, status) {
					count_canvas++;
					console.log(imgUrl);


					if (count_canvas == chart_array.length) {
						window.open(imgUrl);
					}

				});
			});

		});
	}
</script>