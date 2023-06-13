<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
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
			width: 255px !important;
		}
	}
</style>
<style>
	@media screen and (max-width: 600px) {
		.table-responsive {
			overflow-x: auto !important;
		}
	}

	.table-responsive {
		overflow-x: inherit;
	}

	.table thead th {
		background: #379FA6;
		border-bottom: 0;
		padding: 5px
	}

	.ColorTableBody {
		border-radius: 1em;
		overflow: hidden;
	}

	.table-responsive {
		overflow-x: initial
	}

	.ColorTableBody thead tr {
		margin: 20px;
	}

	table {
		border-radius: 12px;
		background-color: #F6F6F6;
	}

	table.dataTable thead th,
	table.dataTable thead td {
		border-bottom: 0px
	}

	.table-responsive {
		border-radius: 12px;
	}

	table.dataTable {
		margin-top: 0px !important;
	}
</style>
<div class="row">
	<div class="col-md-2 col-12 my-auto text-center py-2">
		เลือกเดือน/ปี
	</div>
	<div class="col-md-1 col-12 headerColumn my-auto" style="text-align: right;">
		เริ่มต้น
	</div>
	<div class="col-md-6 col-12 my-auto ">
		<div class="row" style="margin-top: 0px;">
			<div class="col-md-4 col-4 SetAlignInputleft1">
				<select class="form-control" id="month">
					<?php
					foreach ($month_label as $m_id => $name) {
						$sel = '';
						if ($month == $m_id) {
							$sel = 'selected="selected"';
						}
					?>
						<option value="<?php echo $m_id ?>" <?php echo $sel; ?>><?php echo $name ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-2 col-4 headerColumn my-auto" style="text-align: right;">
				สิ้นสุด
			</div>
			<div class="col-md-4 col-4 SetAlignInputleft1">
				<select class="form-control" id="month2">
					<?php
					foreach ($month_label as $m_id => $name) {
						$sel = '';
						if ($month2 == $m_id) {
							$sel = 'selected="selected"';
						}
					?>
						<option value="<?php echo $m_id ?>" <?php echo $sel; ?>><?php echo $name ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-2 col-4 SetAlignInputleft1">
				<select class="form-control" id="year" style="padding-right: 0;">
					<?php for ($i = date('Y'); $i >= date('Y') - 5; $i--) {
						$sel = '';
						if ($year == $i) {
							$sel = 'selected="selected"';
						}
					?>
						<option value="<?php echo $i ?>" <?php echo $sel; ?>><?php echo $i + 543 ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-2 my-auto SetSpaceBtn">
		<div class="row" style="margin-top: 0px;">
			<div class="col-md-6 col-6 SetAlingBtn1">
				<div class="btn btn_Color" onclick="ChangeFilter()">ตกลง</div>
			</div>
			<div class="col-md-6 col-6 SetAlingBtn2">
				<div class="btn btn_Color" onclick="ClearFilter()">ล้างค่า</div>
			</div>
		</div>
	</div>
	<div class="col-md-1 col-12 my-auto text-center">
		<button type="button" onclick="btnExport()" class="btn btn-danger SetWidthbtnExport" style="width: 100%; border-radius: 1em;">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</button>
	</div>
</div>
<div class="row">
	<div class="col-12" id="htmltoimage_chart_monthly">
		<canvas id="chart_main" height="220" style="height:220px !important"></canvas>
	</div>
	<div class="col-12">
		<div style="overflow: auto;">
			<table class="table table-striped table-bordered ">
				<tr>
					<td align="center">ปี</td>
					<?php $chart_label = $chart_current = $chart_pre = array();
					foreach ($month_label as $m_id=>$name) { $chart_label[] = $name; ?>
						<td align="center"><?php echo $name;?></td>
					<?php } ?>
				</tr>
				<tr>
					<td style="background-color: #3cacae;"><?php echo $year+543  ?></td>
					<?php
					foreach ($month_label as $d=>$name) { ?>
						<td style="background:#3cacae" align="center"><?php echo number_format(@$SumMonth[$d]);
																		$chart_current[] = @$SumMonth[$d] ? @$SumMonth[$d] : null; ?></td>
					<?php } ?>
				</tr>
				<tr>
					<td ><?php echo $year +542 ?></td>
					<?php
					foreach ($month_label as $d=>$name) {?>
						<td  align="center"><?php echo number_format(@$SumMonth_past[$d]);
																		$chart_pre[] = @$SumMonth_past[$d] ? @$SumMonth_past[$d] : null; ?></td>
					<?php } ?>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-6">
		<table class="table ColorTableBody shadow-lg">
			<thead>
				<tr>
					<th colspan="3">รายภูมิภาค</th>
				</tr>
				<tr>
					<th>ภูมิภาค</th>
					<th width="20%">จำนวน (คน)</th>
					<th width="20%">อัตราการการเปลี่ยนแปลง</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$asia = @$SumRegionDateData[13] + @$SumRegionDateData[15] + @$SumRegionDateData[38] + @$SumRegionDateData[23];
				$asia_past = @$SumRegionDateData_past[13] + @$SumRegionDateData_past[15] + @$SumRegionDateData_past[38] + @$SumRegionDateData_past[23];
				$diff_asia = $asia >0 ? number_format( ($asia - $asia_past) / $asia * 100, 2).'%': '-';

				$asean = @$SumRegionDateData[13];
				$asean_past = @$SumRegionDateData_past[13];
				$diff_asean = $asean >0 ? number_format( ($asean - $asean_past) / $asean * 100, 2).'%': '-';

				$north_east_asia = @$SumRegionDateData[15] + @$SumRegionDateData[38];
				$north_east_asia_past = @$SumRegionDateData_past[15] + @$SumRegionDateData_past[38];
				$diff_north_east_asia = $north_east_asia >0 ? number_format( ($north_east_asia - $north_east_asia_past) / $north_east_asia * 100, 2).'%': '-';

				$south_asia = @$SumRegionDateData[23];
				$south_asia_past = @$SumRegionDateData_past[23];
				$diff_south_asia = $south_asia >0 ? number_format( ($south_asia - $south_asia_past) / $south_asia * 100, 2).'%': '-';

				$eu = @$SumRegionDateData[2] + @$SumRegionDateData[44];
				$eu_past = @$SumRegionDateData_past[2] + @$SumRegionDateData_past[44];
				$diff_eu = $eu >0 ? number_format( ($eu - $eu_past) / $eu * 100, 2).'%': '-';

				$east_eu = @$SumRegionDateData[37] + @$SumRegionDateData[36];
				$east_eu_past = @$SumRegionDateData_past[37] + @$SumRegionDateData_past[36];
				$diff_east_eu = $east_eu >0 ? number_format( ($east_eu - $east_eu_past) / $east_eu * 100, 2).'%': '-';

				$america = @$SumRegionDateData[7] + @$SumRegionDateData[45];
				$america_past = @$SumRegionDateData_past[7] + @$SumRegionDateData_past[45];
				$diff_america = $america >0 ? number_format( ($america - $america_past) / $america * 100, 2).'%': '-';

				$oceania = @$SumRegionDateData[5] + @$SumRegionDateData[46];
				$oceania_past = @$SumRegionDateData_past[5] + @$SumRegionDateData_past[46];
				$diff_oceania = $oceania >0 ? number_format( ($oceania - $oceania_past) / $oceania * 100, 2).'%': '-';

				$middle_east = @$SumRegionDateData[20];
				$middle_east_past = @$SumRegionDateData_past[20];
				$diff_middle_east = $middle_east >0 ? number_format( ($middle_east - $middle_east_past) / $middle_east * 100, 2).'%': '-';

				$africa = @$SumRegionDateData[6] + @$SumRegionDateData[40];
				$africa_past = @$SumRegionDateData_past[6] + @$SumRegionDateData_past[40];
				$diff_africa = $africa >0 ? number_format( ($africa - $africa_past) / $africa * 100, 2).'%': '-';

				$stateless = @$SumRegionDateData[29];
				$stateless_past = @$SumRegionDateData_past[29];
				$diff_stateless = $stateless >0 ? number_format( ($stateless - $stateless_past) / $stateless * 100, 2).'%': '-';
				?>
				<tr >
					<td style="padding-left: 15px;">ASIA</td>
					<td align="right"><?php echo number_format( $asia) ?></td>
					<td align="right"><?php echo $diff_asia; ?></td>
				</tr>
				<tr >
					<td style="padding-left: 40px;">ASEAN</td>
					<td align="right"><?php echo number_format($asean) ?></td>
					<td align="right"><?php echo $diff_asean; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 40px;">NORTH-EAST ASIA</td>
					<td align="right"><?php echo number_format($north_east_asia) ?></td>
					<td align="right"><?php echo $diff_north_east_asia;?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 40px;">SOUTH ASIA</td>
					<td align="right"><?php echo number_format($south_asia) ?></td>
					<td align="right"><?php echo $diff_south_asia;?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">EUROPE</td>
					<td align="right"><?php echo number_format($eu) ?></td>
					<td align="right"><?php echo $diff_eu; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 40px;">EAST EUROPE</td>
					<td align="right"><?php echo number_format($east_eu) ?></td>
					<td align="right"><?php echo $diff_east_eu; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">THE AMERICAS</td>
					<td align="right"><?php echo number_format($america) ?></td>
					<td align="right"><?php echo $diff_america; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">OCEANIA</td>
					<td align="right"><?php echo number_format($oceania) ?></td>
					<td align="right"><?php echo $diff_oceania; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">MIDDLE EAST</td>
					<td align="right"><?php echo number_format($middle_east) ?></td>
					<td align="right"><?php echo $diff_middle_east; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">AFRICA</td>
					<td align="right"><?php echo number_format($africa) ?></td>
					<td align="right"><?php echo $diff_africa;?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">STATELESS</td>
					<td align="right"><?php echo number_format($stateless) ?></td>
					<td align="right"><?php echo $diff_stateless; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-6">
		<table class="table ColorTableBody shadow-lg">
			<thead>
				<tr>
					<th colspan="3">รายสัญชาติ <select onchange="ChangeFilter()" id="limit">
							<option value="5" <?php if ($limit == 5) {
													echo 'selected="selected"';
												} ?>>5</option>
							<option value="15" <?php if ($limit == 10) {
													echo 'selected="selected"';
												} ?>>15</option>
							<option value="20" <?php if ($limit == 20) {
													echo 'selected="selected"';
												} ?>>20</option>
						</select> อันดับแรก</th>
				</tr>
				<tr>
					<th>ภูมิภาค</th>
					<th width="20%">จำนวน (คน)</th>
					<th width="20%">อัตราการการเปลี่ยนแปลง</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($SumCountry as $key => $value) { ?>
					<tr>
						<td><?php echo ($i++) . '.' . $value['COUNTRY_NAME_EN'] ?></td>
						<td align="right"><?php echo is_numeric(@$value['NUM']) ? number_format(@$value['NUM']) : @$value['NUM']; ?> </td>
						<td align="right"><?php echo $value['CHANGE']; ?> </td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php $this->endSection() ?>
<?= $this->section("scripts") ?>
<script src="<?php echo base_url('public/vendor/html2canvas/html2canvas.js'); ?>"></script>
<script src="<?php echo base_url('public/vendor/chart.js/Chart.min.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
var chart_label = <?php echo json_encode($chart_label); ?>;
var chart_current = <?php echo json_encode($chart_current); ?>;
var chart_pre = <?php echo json_encode($chart_pre); ?>;
	$(function() {
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

	function ChangeFilter() {
		var month = $('#month').val();
		var month2 = $('#month2').val();
		var year = $('#year').val();
		var limit = $('#limit').val();
		window.location.href = base_url + '/main/monthly_period?month=' + month + '&month2=' + month2 + '&year=' + year + '&limit=' + limit;
	}

	function ClearFilter() {
		window.location.href = base_url + '/main/monthly_period';
	}

	function btnExport() {
		var month = $('#month').val();
		var month2 = $('#month2').val();
		var year = $('#year').val();
		var limit = 20; //$('#limit').val();
		window.open(base_url + '/main/monthly_period?month=' + month + '&month2=' + month2 + '&year=' + year + '&limit=' + limit + "&export_type=pdf");
	}

	function SaveImg2ExportPdf(url2SaveImg, url2DowloadReport) {
		$('.btn-download').hide();
		const chart_array = ["chart_monthly"];
		var count_canvas = 0;
		$.each(chart_array, function(key, value) {
			var container = document.getElementById("htmltoimage_" + value);
			html2canvas(container, {
				allowTaint: true
			}).then(function(canvas) {

				var link = document.createElement("a");
				document.body.appendChild(link);
				link.download =  "<?php echo $to_date; ?>"+value + ".jpg";
				link.href = canvas.toDataURL();
				link.target = '_blank';


				var dataURL = link.href;
				$.post(url2SaveImg, {
					imgBase64: dataURL,
					imgName: "<?php echo $to_date; ?>" + value
				}, function(data, status) {
					count_canvas++;
					// console.log(count_canvas+' == '+chart_array.length );
					if (count_canvas == chart_array.length) {
						window.open(url2DowloadReport);
					}

				});
			});

		});
	}
</script>
<?= $this->endSection() ?>