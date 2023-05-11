<?php
$sumDay = 0;
foreach ($data_day as $k => $subArray) {
	$sumDay += $subArray['NUM'];
}
$sumDay = ceil($sumDay);

$sumMonth = 0;
foreach ($data_month as $k => $subArray) {
	$sumMonth += $subArray['NUM'];
}
$sumMonth = ceil($sumMonth);

$report_date = $Mydate->date_eng2thai($to_date, 543);

$numberDay = $numberMonth = array();
$i = 1;
foreach ($data_day_lastyear as $v) {
	
	if($v['NUM']==0){
		$numberDay[$v['COUNTRY_ID']] = '';
	}else{
		$numberDay[$v['COUNTRY_ID']] = $i++;
	}
	
}

$i = 1;
foreach ($data_month_lastyear as $v) {
	
	if($v['NUM']==0){
		$numberMonth[$v['COUNTRY_ID']] = '';
	}else{
		$numberMonth[$v['COUNTRY_ID']] = $i++;
	}
}
?>
<style>
	.radiusTable1 {
		border-collapse: collapse;
	}

	.radiusTable1 thead th {
		background: #70D3DE;
	}

	table,
	td,
	th {
		border: 1px solid black;
	}

	.radiusTable2 thead th {
		background: #FACE74;
	}

	.radiusTable2 {
		border-collapse: collapse;
	}
</style>

<!-- <table>
	<tr>
		<td><b>ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?></b></td>
	</tr>
	<tr>
		<td>
			<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายสัญชาติ วันที่ : 
		<?php echo $Mydate->date_eng2thai($to_date, 543); ?></b>
		</td>
	</tr>
</table> -->
<div>
	<b>ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?></b>
</div>
<div style="text-align:center">
	<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายสัญชาติ วันที่ :
		<?php echo $Mydate->date_eng2thai($to_date, 543); ?></b>
</div>
<div style="text-align:center;" class="py-2 pt-4">
	<b>ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543); ?></b>
</div>
<table class="table table-striped table-bordered radiusTable1" id="table1" style="width:100%;">
	<thead>
		<tr>
			<th>ลำดับ<br><?php echo $year + 543; ?></th>
			<th>ลำดับ<br><?php echo $year + 542; ?></th>
			<th>สัญชาติ</th>
			<th>จำนวนนักท่องเที่ยว</th>
			<th>สัดส่วน</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (!empty($data_day)) {
			$sum_other = 0;
			$i = 1;
			foreach ($data_day as $k => $v) {
				$icon = '';
				if ($i <= 50) {
					if (!empty($numberDay[$v['COUNTRY_ID']])) {
						if ($i == $numberDay[$v['COUNTRY_ID']]) {
							$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">(' . $numberDay[$v['COUNTRY_ID']] . ')</span>';
						} else if ($i < $numberDay[$v['COUNTRY_ID']]) {
							$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">(' . $numberDay[$v['COUNTRY_ID']] . ')</span>';
						} else if ($i > $numberDay[$v['COUNTRY_ID']]) {
							$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">(' . $numberDay[$v['COUNTRY_ID']] . ')</span>';
						}
					}

		?>
					<tr style="background-color: <?= ($k % 2 == 0) ? 'white' : '#D6EFF2' ?>;">
						<td align="center"> <b><?php echo $i++ ?></b> </td>
						<td align="center"> <?php echo @$numberDay[$v['COUNTRY_ID']] ?> </td>
						<td> <?php echo $v['COUNTRY_NAME_EN'] ?> </td>
						<td align="right"> <?php echo number_format($v['NUM']); ?> </td>
						<td align="center"> <?php echo number_format($v['NUM'] / $sumDay * 100, 2); ?> %</td>
					</tr>
			<?php } else {
					$sum_other += $v['NUM'];
				}
			} ?>
	</tbody>
	<tfoot>
		<tr>
			<td align="center"></td>
			<td align="center"></td>
			<td> Other </td>
			<td style="text-align:right;"> <?php echo number_format($sum_other); ?> </td>
			<td style="text-align:center;"> <?php echo number_format($sum_other / $sumMonth * 100, 2); ?> %</td>
		</tr>

	</tfoot>
<?php } ?>
</table>
<span>
	* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)
</span>
<?php if ($export_type == 'pdf') { ?><pagebreak> <?php } ?>
	<div style="text-align:center;" class="py-2 pt-4">
		<b>สะสม วันที่ 1 ม.ค. - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?></b>
	</div>
	<table class="table table-striped table-bordered radiusTable2" id="table2" style="width:100%;">
		<thead>
			<tr>
				<th>ลำดับ<br><?php echo $year + 543; ?></th>
				<th>ลำดับ<br><?php echo $year + 542; ?></th>
				<th>สัญชาติ</th>
				<th>จำนวนนักท่องเที่ยว</th>
				<th>สัดส่วน</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($data_month)) {
				$sum_other = 0;
				$i = 1;
				foreach ($data_month as $k => $v) {
					$icon = '';
					if ($i <= 50) {
						if (!empty($numberMonth[$v['COUNTRY_ID']])) {
							if ($i == $numberMonth[$v['COUNTRY_ID']]) {
								$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['COUNTRY_ID']] . ')</span>';
							} else if ($i < $numberMonth[$v['COUNTRY_ID']]) {
								$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['COUNTRY_ID']] . ')</span>';
							} else if ($i > $numberMonth[$v['COUNTRY_ID']]) {
								$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['COUNTRY_ID']] . ')</span>';
							}
						}
			?>
						<tr style="background-color: <?= ($k % 2 == 0) ? 'white' : '#FFE4C8' ?>;">
							<td align="center"> <b><?php echo $i++ ?></b> </td>
							<td align="center"> <?php echo @$numberMonth[$v['COUNTRY_ID']] ?> </td>
							<td> <?php echo $v['COUNTRY_NAME_EN'] ?> </td>
							<td align="right"> <?php echo number_format($v['NUM']); ?> </td>
							<td align="center"> <?php echo number_format($v['NUM'] / $sumMonth * 100, 2); ?> %</td>
						</tr>
				<?php  } else {
						$sum_other += $v['NUM'];
					}
				} ?>
		</tbody>
		<tfoot>
			<tr>
				<td align="center"></td>
				<td align="center"></td>
				<td> Other </td>
				<td style="text-align:right;"> <?php echo number_format($sum_other); ?> </td>
				<td style="text-align:center;"> <?php echo number_format($sum_other / $sumMonth * 100, 2); ?> %</td>
			</tr>

		</tfoot>
	<?php } ?>
	</table>
	<span>
		* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)
	</span>