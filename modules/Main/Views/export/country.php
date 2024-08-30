<?php include_once("export_css.php"); ?>
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

	.card_info{
		border-radius: 10px;
		margin-bottom: 10px;
		border:1px solid #ccc;
		padding: 5px;
	}
</style>
<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>


<div class="row">
	<div class="col-md-12">
		<div class="card">
			<!-- <div class="card-header">  </div> -->
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<div class="card_info">
							สะสม <?php echo $Mydate->date_eng2thai($start_date_label_past, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($end_date_label_past, 543, 'S', 'S') ?><br>
							<?php echo number_format($SumMonthData_past)?> คน
						</div>
						<div class="card_info">
							สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?><br>
							<?php echo number_format($SumMonthData)?> คน<br>
							Change <?php
							if ($SumMonthData_past > 0) {
								$percent = number_format(($SumMonthData-$SumMonthData_past)  / $SumMonthData_past  * 100, 2);
								if ($SumMonthData > $SumMonthData_past) {
									echo '<span style="color:green">+' . $percent . '%</span>';
								} else {
									echo '<span style="color:red">-' . $percent*(-1) . '%</span>';
								}
							} else {
								echo '-';
							} ?>
						</div>
						<div class="card_info">
							<?php echo $Mydate->date_eng2thai($prev_date, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?><br>
							<?php echo number_format($SumWeekData)?> คน<br>
							WoW <?php
							if ($SumWeekData_past > 0) {
								$percent = number_format(($SumWeekData-$SumWeekData_past)  / $SumWeekData_past  * 100, 2);
								if ($SumWeekData > $SumWeekData_past) {
									echo '<span style="color:green">+' . $percent . '%</span>';
								} else {
									echo '<span style="color:red">-' . $percent*(-1) . '%</span>';
								}
							} else {
								echo '-';
							} ?>
						</div>
						<div class="card_info">
							<div class="row">
								<div class="col-md-9">ด่านอากาศ : <?php echo number_format($SumPortType[1]['NUM']);?> คน</div>
								<div class="col-md-3" style="text-align:right; padding-left:0"><?php echo number_format($SumPortType[1]['NUM']/($SumPortType[1]['NUM']+$SumPortType[0]['NUM'])*100,2); ?>%</div>
							</div>
							<div class="row">
								<div class="col-md-9">ด่านบก : <?php echo number_format($SumPortType[0]['NUM']);?> คน</div>
								<div class="col-md-3" style="text-align:right; padding-left:0"><?php echo number_format($SumPortType[0]['NUM']/($SumPortType[1]['NUM']+$SumPortType[0]['NUM'])*100,2); ?>%</div>
							</div>
							
						</div>
					</div>
					<div class="col-md-9">
						<?php 
						$flag = base_url('public/img/logotat.png');

						if (!file_exists(base_url('public/img/flag/' . $country_id . '.png'))) {
							$flag = base_url('public/img/flag/' . $country_id . '.png');
						}
						?>
						<div style="text-align:right;width: 100%;"><img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="width: 40px;"></div>
						<div class="text-center" id="htmltoimage_chart_country" style="padding:5px;">

							<div id="chart_country" style="height:300px !important">
								<img src="<?php echo base_url('public/uploads/main/' . $to_date . 'chart_country'.$country_id.'.png') ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						หมายเหตุ : ข้อมูลสัญชาติ (Nationality) ที่ไม่นับรวมข้อมูลผู้อพยพ , หน่วยงานพิเศษ UN , ไม่มีสัญชาติ <br>
						WoW (Week on Week) หมายถึง อัตราการเปลี่ยนแปลงเทียบกับสัปดาห์ก่อนหน้า
					</div>
				</div>
			</div>
		</div>
	</div>
</div>