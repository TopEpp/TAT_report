<?php $user_menu = $session->get('user_menu'); ?>
<link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.css') ?>">
<link href="<?php echo base_url('public/vendor/fontawesome-free/css/all.css') ?>" rel="stylesheet" type="text/css">

<style>
	:root {
  --blue: #0E66AE;
  --indigo: #6610f2;
  --purple: #6f42c1;
  --pink: #e83e8c;
  --red: #e74a3b;
  --orange: #fd7e14;
  --yellow: #f6c23e;
  --green: #1cc88a;
  --teal: #20c9a6;
  --cyan: #36b9cc;
  --white: #fff;
  --gray: #858796;
  --gray-dark: #5a5c69;
  --primary: #0E66AE;
  --secondary: #858796;
  --success: #1cc88a;
  --info: #36b9cc;
  --warning: #f6c23e;
  --danger: #e74a3b;
  --light: #f8f9fc;
  --dark: #5a5c69;
  --breakpoint-xs: 0;
  --breakpoint-sm: 576px;
  --breakpoint-md: 768px;
  --breakpoint-lg: 992px;
  --breakpoint-xl: 1200px;
  --font-family-sans-serif: "TATSana-Chon", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
  --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}

@font-face {
  font-family: 'TATSana-Chon';
  src: url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.eot')?>');
  /* IE9 Compat Modes */
  src: url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.eot?#iefix')?>') format('embedded-opentype'),
    /* IE6-IE8 */
    url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.woff')?>') format('woff'),
    /* Modern Browsers */
    url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.ttf')?>') format('truetype'),
    /* Safari, Android, iOS */
    url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.svg#svgFontName')?>') format('svg');
  /* Legacy iOS */
}

body {
  margin: 0;
  font-family: "TATSana-Chon", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
  
}

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

	.d-flex {
		line-height: 1.2em;
	}

	@media (max-width: 576px) {}
</style>
<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>

<body style="width:1150px; margin: auto;">
<div class="row" style="margin: 0px;">
	<div class="col-lg-1 col-12 text-center text-md-right">
		<img class="img-profile " src="<?php echo base_url('public/img/tat.png') ?>" width="100px">
	</div>
	<div class="col-lg-11 col-12  my-md-auto text-center text-md-right my-3">
		<div>
			<button type="button" onclick="SaveImg2ExportImg('<?php echo base_url('main/saveImg2Report'); ?>','png')" class="btn btn-info">
				<i class="fa-solid fa-file-image"></i> PNG
			</button>
			<button type="button" onclick="SaveImg2ExportImg('<?php echo base_url('main/saveImg2ReportJPG'); ?>','jpg')" class="btn btn-info">
				<i class="fa-solid fa-file-image"></i> JPG
			</button>
			<button type="button" onclick="window.open('<?php echo base_url('main/export_country?export=pdf&start_date=' . $start_date . '&end_date=' . $end_date.'&country_id='.$country_id); ?>')" class="btn btn-danger SetWidthbtnExport shadow-1">
				<i class="fa-solid fa-file-pdf"></i> PDF
			</button>
		</div>
	</div>
</div>
<div class="row" id="htmltoimage_info_dashboard">
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
								<img src="<?php echo base_url('public/uploads/main/' . $to_date . 'chart_country'.$country_id.'.png') ?>" style="height: 300px;">
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

	function SaveImg2ExportImg(url2SaveImg,type) {
		$('.btn-download').hide();
		setTimeout(function() {
			saveImg(url2SaveImg,type);
		}, 1000);
	}

	function saveImg(url2SaveImg,type) {
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
				var imgUrl = base_url + "/public/uploads/main/<?php echo $to_date; ?>" + value + "."+type;
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