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
		padding: 16px
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
	<div class="col-md-3 col-12 headerColumn my-auto">
		<div class="my-auto" style="font-size: 15px;">
			ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
		</div>
	</div>
	<div class="col-md-2 col-12 my-auto text-center py-2">
		เลือกเดือน/ปี
	</div>
	<div class="col-md-4 col-12 my-auto ">
		<div class="row" style="margin-top: 0px;">
			<div class="col-md-4 col-4 SetAlignInputleft1">
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
			<div class="col-md-4 col-4 SetAlignInputleft1">
				<select class="form-control" id="month2">
				<?php 
				foreach($month_label as $m_id=>$name){
					$sel = '';
					if($month2==$m_id){
						$sel = 'selected="selected"';
					}
				?>
					<option value="<?php echo $m_id?>" <?php echo $sel;?> ><?php echo $name?></option>
				<?php } ?>
				</select>
			</div>
			<div class="col-md-4 col-4 SetAlignInputleft1">
				<select class="form-control" id="year">
				 	<?php for($i=date('Y');$i >= date('Y')-5;$i--){ 
				 		$sel = '';
						if($year==$i){
							$sel = 'selected="selected"';
						}
					?>
						<option value="<?php echo $i?>" <?php echo $sel;?> ><?php echo $i?></option>
					<?php }?>
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
		<button type="button" onclick="SaveImg2ExportPdf('<?php echo base_url('main/saveImg2Report'); ?>','<?php echo base_url('main/monthly?export_type=pdf'); ?>')" class="btn btn-danger SetWidthbtnExport" style="width: 100%; border-radius: 1em;">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</button>
	</div>
</div>

<div class="row">
	<div class="col-6">
		<table class="table ColorTableBody shadow-lg">
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
		<table class="table ColorTableBody shadow-lg">
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
<script type="text/javascript">


function ChangeFilter() {
	var month = $('#month').val();
	var month2 = $('#month2').val();
	var year = $('#year').val();
	var limit= $('#limit').val();
	window.location.href = base_url + '/main/monthly_period?month=' + month+'&month2='+month2+'&year='+year+'&limit='+limit;
}

function ClearFilter() {
		window.location.href = base_url + '/main/monthly_period';
	}
</script>
<?= $this->endSection() ?>