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
<div class="row">
	<div class="col-md-3 col-12 headerColumn my-auto">
		<div class="my-auto" style="font-size: 15px;">
			ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
		</div>
	</div>
	<div class="col-md-2 col-12 my-auto text-center py-2">
		เลือกเดือน/ปี
	</div>
	<div class="col-md-3 col-12 my-auto ">
		<div class="row" style="margin-top: 0px;">
			<div class="col-md-6 col-6 SetAlignInputleft1">
				<select class="form-control" id="month">
				<?php 
				foreach($month_label as $m_id=>$name){
					$sel = '';
					if($month==$m_id){
						$sel = 'selected="selected"';
					}
				?>
					<option value="<?php echo $m_id?>" <?php echo $sel;?> ><?php echo $name?></option>
				<?php } ?>
				</select>
			</div>
			<div class="col-md-6 col-6 SetAlignInputleft1">
				<select class="form-control" id="year">
				 	<option value="2022" <?php if($year==2022){ echo 'selected="selected"'; }?>>2022</option>
				 	<option value="2023" <?php if($year==2023){ echo 'selected="selected"'; }?>>2023</option>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-3 my-auto SetSpaceBtn">
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
		<button type="button" onclick="SaveImg2ExportPdf('<?php echo base_url('main/saveImg2Report'); ?>','<?php echo base_url('main/monthly?export_type=pdf'); ?>')" class="btn btn-danger SetWidthbtnExport" style="width: 100%; border-radius: 1em;">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</button>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<canvas id="chart_main" height="220" style="height:220px !important"></canvas>
	</div>
	<div class="col-12">
		<div style="overflow: auto;">
			<table class="table table-striped table-bordered">
				<tr>
					<td align="center">ปี</td>
					<?php $chart_label = $chart_current = $chart_pre = array();
					foreach ($month_label as $m_id=>$name) { $chart_label[] = $name; ?>
						<td align="center"><?php echo $name;?></td>
					<?php } ?>
				</tr>
				<tr>
					<td style="background-color: #3cacae;"><?php echo $year  ?></td>
					<?php
					foreach ($month_label as $d=>$name) { ?>
						<td style="background:#3cacae" align="center"><?php echo number_format(@$SumMonth[$d]);
																		$chart_current[] = @$SumMonth[$d] ? @$SumMonth[$d] : 0; ?></td>
					<?php } ?>
				</tr>
				<tr>
					<td style="background-color: #e95d61;"><?php echo $year -1 ?></td>
					<?php
					foreach ($month_label as $d=>$name) {?>
						<td style="background:#e95d61" align="center"><?php echo number_format(@$SumMonth_past[$d]);
																		$chart_pre[] = @$SumMonth_past[$d] ? @$SumMonth_past[$d] : 0; ?></td>
					<?php } ?>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-6">
		<table class="table">
			<thead>
				<tr>
					<th colspan="3">รายภูมิภาค</th>
				</tr>
			</thead>
			<tbody>
			
			</tbody>
		</table>
	</div>
	<div class="col-6">
		<table class="table">
			<thead>
				<tr>
					<th colspan="3">รายสัญชาติ <select onchange="ChangeFilter()" id="limit"><option value="5" <?php if($limit==5){ echo 'selected="selected"'; }?>>5</option><option value="10" <?php if($limit==10){ echo 'selected="selected"'; }?>>10</option><option value="20" <?php if($limit==20){ echo 'selected="selected"'; }?>>20</option></select> อันดับแรก</th>
				</tr>
			</thead>
			<tbody>
			<?php $i=1; foreach ($SumCountry as $key => $value) { ?>
				<tr>
					<td><?php echo ($i++).'.'.$value['COUNTRY_NAME_EN']?></td>
					<td align="right"><?php echo is_numeric(@$value['NUM'])? number_format(@$value['NUM']) : @$value['NUM'] ; ?> </td>
					<td align="right"><?php echo $value['CHANGE']; ?> </td>
				</tr>
			<?php }?>
			</tbody>
		</table>
	</div>
</div>
<?php $this->endSection() ?>
<?= $this->section("scripts") ?>
<script src="<?= base_url('public/js/script.js') ?>"></script>
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
	var year = $('#year').val();
	var limit= $('#limit').val();
	window.location.href = base_url + '/main/monthly?month=' + month+'&year='+year+'&limit='+limit;
}

function ClearFilter() {
		window.location.href = base_url + '/main/monthly';
	}
</script>
<?= $this->endSection() ?>