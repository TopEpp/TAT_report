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

	@media screen and (max-width: 600px) {
		.table-responsive {
			overflow-x: auto !important;
		}
	}

	.table-responsive {
		overflow-x: inherit;
	}

	.table thead th {
		background: #007570;
		border-bottom: 0;
		padding: 16px;
		border: 1px solid #e3e193
	}

	.ColorTableBody {
		border-collapse: collapse;
		border: 1px solid #3a4a4a !important;
	}

	.table-responsive {
		overflow-x: initial
	}

	.ColorTableBody thead tr {
		/* margin: 10px; */
	}

	table {
		border-radius: 12px;
		/* background-color: #F6F6F6; */
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

	body {
		background-color: #b3e4e8 !important;
	}

	.col6 {
		width: 50% !important;
		float: left;
		padding-top: 1%;
	}

	.col12 {
		width: 100% !important;
	}

	#resultsTableForCard {
		width: 350px;
		height: 150px;
		background: #fff1cc;
		border-radius: 12px !important;
		margin: auto auto;
		box-shadow: 0px 7px 0px 0px hsl(0, 7%, 50%);
	}

	#resultsTable4 {
		height: 90px;
		width: 300px;
		background: white;
		overflow: hidden;
		border-radius: 12px !important;
		margin: auto auto;
		box-shadow: 0px 5px 4px 0px hsl(0, 7%, 50%)
			/* box-shadow:  1px 0px 3px 0px; */
	}
</style>

<body class="bodyexportMonthly_period">
	<table style="width: 100%;padding-bottom: 1px;">
		<thead>
			<tr>
				<td style="width: 5%; text-align: center;">
					<img src="<?php echo base_url('public/img/TATIC-Logo.png') ?>" alt="" style="width: 200px;">
				</td>
				<td style="text-align: center; color: black;width: 90%; padding-top: 10px;">
					<p style="margin: 0px; line-height: normal; font-size: 45px;">
						สถิตินักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย
					</p>

				</td>
				<td style="width: 5%;text-align: center;">
					<img src="<?php echo base_url('public/img/amazing-th.png') ?>" alt="" style="width: 150px; padding-left: 35px;">
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center; color: black; width: 100%;">
					<h3 style="margin: 0px; line-height: normal; font-size: 40;margin-bottom: 30px;">
						เดือนมกราคม - มีนาคม 2566
					</h3>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center; color: black;padding-top: 15px; width: 100%;">
					<p style="font-size: 20px;margin-top: 50px;">
						จัดทำโดย ด้านดิจิทัล วิจัย เเละพัฒนาการท่องเที่ยวเเห่งประเทศไทย (ททท.)
					</p>
				</td>
			</tr>
		</thead>
	</table>
	<div class="col12" style="display: flex !important; flex-direction: row !important;">
		<div class="col6">
			<div style="padding: 0px 10px;">
				<table class="table ColorTableBody shadow-lg" style="width: 100%; ">
					<thead>
						<tr>
							<th colspan="3" style="font-size: 25px; color: white; padding: 10;">รายภูมิภาค</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$asia = @$SumRegionDateData[13] + @$SumRegionDateData[15] + @$SumRegionDateData[38] + @$SumRegionDateData[23];
						$asia_past = @$SumRegionDateData_past[13] + @$SumRegionDateData_past[15] + @$SumRegionDateData_past[38] + @$SumRegionDateData_past[23];

						$asean = @$SumRegionDateData[13];
						$asean_past = @$SumRegionDateData_past[13];

						$north_east_asia = @$SumRegionDateData[15] + @$SumRegionDateData[38];
						$north_east_asia_past = @$SumRegionDateData_past[15] + @$SumRegionDateData_past[38];

						$south_asia = @$SumRegionDateData[23];
						$south_asia_past = @$SumRegionDateData_past[23];

						$eu = @$SumRegionDateData[2] + @$SumRegionDateData[44];
						$eu_past = @$SumRegionDateData_past[2] + @$SumRegionDateData_past[44];

						$east_eu = @$SumRegionDateData[37] + @$SumRegionDateData[36];
						$east_eu_past = @$SumRegionDateData_past[37] + @$SumRegionDateData_past[36];

						$america = @$SumRegionDateData[7] + @$SumRegionDateData[45];
						$america_past = @$SumRegionDateData_past[7] + @$SumRegionDateData_past[45];

						$oceania = @$SumRegionDateData[5] + @$SumRegionDateData[46];
						$oceania_past = @$SumRegionDateData_past[5] + @$SumRegionDateData_past[46];

						$middle_east = @$SumRegionDateData[20];
						$middle_east_past = @$SumRegionDateData_past[20];

						$africa = @$SumRegionDateData[6] + @$SumRegionDateData[40];
						$africa_past = @$SumRegionDateData_past[6] + @$SumRegionDateData_past[40];

						$stateless = @$SumRegionDateData[29];
						$stateless_past = @$SumRegionDateData_past[29];
						?>
						<tr style="border: 1px solid #e3e193; background-color: #fff2e9; ">
							<td style="padding-left: 15px; font-size: 18px; width: 40%;color:#1e6760; font-weight: 500; ">ASIA</td>
							<td style="font-size:18px; width:35%;color:#1e6760;" align="right"><?php echo number_format($asia) ?></td>
							<td align="right" style="font-size:18px; width: 25%; padding-right: 10px; color:#1e6760;"><?php echo $asia_past > 0 ? number_format($asia / $asia_past * 100, 2) : '-'; ?></td>
						</tr>
						<tr style="border: 1px solid #e3e193; background-color: white;">
							<td style="padding-left: 40px; font-size: 18px;color:#1e6760; font-weight: 500;">ASEAN</td>
							<td align="right" style="font-size:18px;color:#1e6760"><?php echo number_format($asean) ?></td>
							<td align="right" style="font-size:18px;padding-right: 10px;color:#1e6760;"><?php echo $asean_past > 0 ? number_format($asean / $asean_past * 100, 2) : '-'; ?></td>
						</tr>

						<tr style="border: 1px solid #e3e193; background-color: #fff2e9; ">
							<td style="padding-left: 40px;font-size:18px;color:#1e6760; font-weight: 500;">NORTH-EAST ASIA</td>
							<td align="right" style="font-size:18px;color:#1e6760;"><?php echo number_format($north_east_asia) ?></td>
							<td align="right" style="font-size:18px;padding-right: 10px;color:#1e6760;"><?php echo $north_east_asia_past > 0 ? number_format($north_east_asia / $north_east_asia_past * 100, 2) : '-'; ?></td>
						</tr>

						<tr style="border: 1px solid #e3e193; background-color: white; ">
							<td style="padding-left: 40px;font-size:18px;color:#1e6760; font-weight: 500; ">SOUTH ASIA</td>
							<td align="right" style="font-size:18px;color:#1e6760;"><?php echo number_format($south_asia) ?></td>
							<td align="right" style="font-size:18px;padding-right: 10px;color:#1e6760;"><?php echo $south_asia_past > 0 ? number_format($south_asia / $south_asia_past * 100, 2) : '-'; ?></td>
						</tr>

						<tr style="border: 1px solid #e3e193; background-color: #fff2e9; ">
							<td style="padding-left: 15px;font-size:18px;color:#1e6760; font-weight: 500;">EUROPE</td>
							<td align="right" style="font-size:18px;color:#1e6760;"><?php echo number_format($eu) ?></td>
							<td align="right" style="font-size:18px;padding-right: 10px;color:#1e6760;"><?php echo $eu_past > 0 ? number_format($eu / $eu_past * 100, 2) : '-'; ?></td>
						</tr>

						<tr style="border: 1px solid #e3e193; background-color: white; ">
							<td style="padding-left: 40px;font-size:18px;color:#1e6760; font-weight: 500;">EAST EUROPE</td>
							<td align="right" style="font-size:18px;color:#1e6760;"><?php echo number_format($east_eu) ?></td>
							<td align="right" style="font-size:18px;padding-right: 10px;color:#1e6760;"><?php echo $east_eu_past > 0 ? number_format($east_eu / $east_eu_past * 100, 2) : '-'; ?></td>
						</tr>

						<tr style="border: 1px solid #e3e193; background-color: #fff2e9; ">
							<td style="padding-left: 15px;font-size:18px;color:#1e6760; font-weight: 500;">THE AMERICAS</td>
							<td align="right" style="font-size:18px;color:#1e6760;"><?php echo number_format($america) ?></td>
							<td align="right" style="font-size:18px;padding-right: 10px;color:#1e6760;"><?php echo $america_past > 0 ? number_format($america / $america_past * 100, 2) : '-'; ?></td>
						</tr>

						<tr style="border: 1px solid #e3e193; background-color: white; ">
							<td style="padding-left: 15px;font-size:18px;color:#1e6760; font-weight: 500;">OCEANIA</td>
							<td align="right" style="font-size:18px;color:#1e6760;"><?php echo number_format($oceania) ?></td>
							<td align="right" style="font-size:18px;padding-right: 10px;color:#1e6760;"><?php echo $oceania_past > 0 ? number_format($oceania / $oceania_past * 100, 2) : '-'; ?></td>
						</tr>

						<tr style="border: 1px solid #e3e193; background-color: #fff2e9; ">
							<td style="padding-left: 15px;font-size:18px;color:#1e6760; font-weight: 500;">MIDDLE EAST</td>
							<td align="right" style="font-size:18px;color:#1e6760;"><?php echo number_format($middle_east) ?></td>
							<td align="right" style="font-size:18px;padding-right: 10px;color:#1e6760;"><?php echo $middle_east_past > 0 ? number_format($middle_east / $middle_east_past * 100, 2) : '-'; ?></td>
						</tr>

						<tr style="border: 1px solid #e3e193; background-color: white; ">
							<td style="padding-left: 15px;font-size:18px;color:#1e6760; font-weight: 500;">AFRICA</td>
							<td align="right" style="font-size:18px;color:#1e6760;"><?php echo number_format($africa) ?></td>
							<td align="right" style="font-size:18px;padding-right: 10px;color:#1e6760;"><?php echo $africa_past > 0 ? number_format($africa / $africa_past * 100, 2) : '-'; ?></td>
						</tr>

						<tr style="border: 1px solid #e3e193; background-color: #fff2e9; ">
							<td style="padding-left: 15px;font-size:18px;color:#1e6760; font-weight: 500;">STATELESS</td>
							<td align="right" style="font-size:18px;color:#1e6760;"><?php echo number_format($stateless) ?></td>
							<td align="right" style="font-size:18px;padding-right: 10px;color:#1e6760;"><?php echo $stateless_past > 0 ? number_format($stateless / $stateless_past * 100, 2) : '-'; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="resultsTableForCard" style="margin-bottom: 10px; margin-top: 15px;">
				<table class="table" style="width: 100%;">
					<tbody style="line-height: 1.5em;">
						<tr style="text-align:center; border: 0;">
							<td style="padding: 10px 0px 0px 0px; font-size: 25px; text-align: center; font-weight: bold;">
								จำนวนทุกภูมิภาค
							</td>
						</tr>
					</tbody>
				</table>
				<div id="resultsTable4">
					<table style="width: 100%;">
						<tbody>
							<tr style="border: 0;padding: 0px 0px;">
								<td style="text-align: center;padding: 5px ; font-size: 37px;">
									6,477,538 คน
								</td>

							</tr>
							<tr>
								<td style="text-align: center;padding: 5px ; font-size: 20px;">
									(+1,202.43%)
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col6">
			<div style="padding: 0px 10px;">
				<table class="table ColorTableBody shadow-lg" style="width: 100%;">
					<thead>
						<tr>
							<th colspan="3" style="font-size: 25px; color: white; padding: 10;">รายสัญชาติ <select onchange="ChangeFilter()" id="limit">
									<option value="5" <?php if ($limit == 5) {
															echo 'selected="selected"';
														} ?>>5</option>
									<option value="10" <?php if ($limit == 10) {
															echo 'selected="selected"';
														} ?>>10</option>
									<option value="20" <?php if ($limit == 20) {
															echo 'selected="selected"';
														} ?>>20</option>
								</select> อันดับแรก</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1;
						foreach ($SumCountry as $key => $value) { ?>
							<tr style="border: 1px solid #e3e193;">
								<td style="font-size:18px; <?php ($i % 2 == 0) ? 'border: 1px solid #e3e193; background-color: #fff2e9;' : 'border: 1px solid #e3e193; background-color: white;' ?>"><?php echo ($i++) . '.' . $value['COUNTRY_NAME_EN'] ?></td>
								<td style="font-size:18px;" align="right"><?php echo is_numeric(@$value['NUM']) ? number_format(@$value['NUM']) : @$value['NUM']; ?> </td>
								<td style="font-size:18px;" align="right"><?php echo $value['CHANGE']; ?> </td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>