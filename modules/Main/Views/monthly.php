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
		เลือกเดือน
	</div>
	<div class="col-md-3 col-12 my-auto ">
		<div class="row" style="margin-top: 0px;">
			<div class="col-md-12 col-12 SetAlignInputleft1">
				<select class="form-control">
					<option></option>
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
		<button type="button" onclick="SaveImg2ExportPdf('<?php echo base_url('main/saveImg2Report'); ?>','<?php echo base_url('main/export_dashboard'); ?>')" class="btn btn-danger SetWidthbtnExport" style="width: 100%; border-radius: 1em;">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</button>
	</div>
</div>
<?php $this->endSection() ?>
<?= $this->section("scripts") ?>

<?= $this->endSection() ?>