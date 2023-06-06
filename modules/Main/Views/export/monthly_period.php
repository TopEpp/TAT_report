
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
						<option value="<?php echo $i?>" <?php echo $sel;?> ><?php echo $i+543?></option>
					<?php }?>
				</select>
			</div>
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
				<tr >
					<td style="padding-left: 15px;">ASIA</td>
					<td align="right"><?php echo number_format( $asia) ?></td>
					<td align="right"><?php echo $asia_past >0 ? number_format( $asia/$asia_past*100 ,2 ) : '-'; ?></td>
				</tr>
				<tr >
					<td style="padding-left: 40px;">ASEAN</td>
					<td align="right"><?php echo number_format($asean) ?></td>
					<td align="right"><?php echo $asean_past >0 ? number_format( $asean/$asean_past*100 ,2 ) : '-'; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 40px;">NORTH-EAST ASIA</td>
					<td align="right"><?php echo number_format($north_east_asia) ?></td>
					<td align="right"><?php echo $north_east_asia_past >0 ? number_format( $north_east_asia/$north_east_asia_past*100 ,2 ) : '-';?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 40px;">SOUTH ASIA</td>
					<td align="right"><?php echo number_format($south_asia) ?></td>
					<td align="right"><?php echo $south_asia_past >0 ? number_format( $south_asia/$south_asia_past*100 ,2 ) : '-';?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">EUROPE</td>
					<td align="right"><?php echo number_format($eu) ?></td>
					<td align="right"><?php echo $eu_past >0 ? number_format( $eu/$eu_past*100 ,2 ) : '-'; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 40px;">EAST EUROPE</td>
					<td align="right"><?php echo number_format($east_eu) ?></td>
					<td align="right"><?php echo $east_eu_past >0 ? number_format( $east_eu/$east_eu_past*100 ,2 ) : '-'; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">THE AMERICAS</td>
					<td align="right"><?php echo number_format($america) ?></td>
					<td align="right"><?php echo $america_past >0 ? number_format( $america/$america_past*100 ,2 ) : '-'; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">OCEANIA</td>
					<td align="right"><?php echo number_format($oceania) ?></td>
					<td align="right"><?php echo $oceania_past >0 ? number_format( $oceania/$oceania_past*100 ,2 ) : '-'; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">MIDDLE EAST</td>
					<td align="right"><?php echo number_format($middle_east) ?></td>
					<td align="right"><?php echo $middle_east_past >0 ? number_format( $middle_east/$middle_east_past*100 ,2 ) : '-'; ?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">AFRICA</td>
					<td align="right"><?php echo number_format($africa) ?></td>
					<td align="right"><?php echo $africa_past >0 ? number_format( $africa/$africa_past*100 ,2 ) : '-';?></td>
				</tr>
				
				<tr >
					<td style="padding-left: 15px;">STATELESS</td>
					<td align="right"><?php echo number_format($stateless) ?></td>
					<td align="right"><?php echo $stateless_past >0 ? number_format( $stateless/$stateless_past*100 ,2 ) : '-'; ?></td>
				</tr>
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
ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>