<?php include_once("export_css.php"); ?>
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
	$numberDay[$v['PORT_ID']] = $i++;
}

$i = 1;
foreach ($data_month_lastyear as $v) {
	$numberMonth[$v['PORT_ID']] = $i++;
}
?>
<style>

</style>

<table style="width:100%">
	<tr>
		<td><b>ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?></b></td>
	</tr>
	<tr>
		<td class="headderTable">
			<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายด่าน วันที่ :
				<?php echo $Mydate->date_eng2thai($to_date, 543); ?></b>
		</td>
	</tr>
</table>
<table border="1" class="table table-striped table-bordered tbl_nation" id="table1" style="width:100%;border-collapse:collapse">
	<thead bgcolor='#70d3de'>
		<tr class="headderTable">
			<th colspan="5" style="background:#FFFFFF;border: 0px;">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543); ?></th>
		</tr>
		<tr>
			<th style="background:#70D3DE;border: 1px solid black ;">ลำดับ<br><?php echo $year + 543; ?></th>
			<th style="background:#70D3DE;border: 1px solid black ;">ลำดับ<br><?php echo $year + 542; ?></th>
			<th style="background:#70D3DE;border: 1px solid black ;">ด่าน</th>
			<th style="background:#70D3DE;border: 1px solid black ;">จำนวนนักท่องเที่ยว</th>
			<th style="background:#70D3DE;border: 1px solid black ;">สัดส่วน</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1;
		foreach ($data_day as $k => $v) {
			$icon = '';
			if (!empty($numberDay[$v['PORT_ID']])) {
				if ($i == $numberDay[$v['PORT_ID']]) {
					$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">(' . $numberDay[$v['PORT_ID']] . ')</span>';
				} else if ($i < $numberDay[$v['PORT_ID']]) {
					$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">(' . $numberDay[$v['PORT_ID']] . ')</span>';
				} else if ($i > $numberDay[$v['PORT_ID']]) {
					$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">(' . $numberDay[$v['PORT_ID']] . ')</span>';
				}
			}

		?>
			<tr>
				<td align="center"> <b><?php echo $i++ ?></b> </td>
				<td align="center"> <?php echo @$numberDay[$v['PORT_ID']] ?> </td>
				<td> <?php echo $v['PORT_NAME'] ?> </td>
				<td align="right"> <?php echo number_format($v['NUM']); ?> </td>
				<td align="center"> <?php if ($sumDay > 0) {
										echo number_format($v['NUM'] / $sumDay * 100, 2);
									} ?> %</td>
			</tr>

		<?php } ?>
		<tr style="border:0px">
			<td colspan="5">* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)</td>
		</tr>
	</tbody>
</table>

<?php if ($export_type == 'pdf') { ?><pagebreak> <?php } ?>

	<table border="1" class="table table-striped table-bordered tbl2_nation" id="table2" style="width:100%">
		<thead>
			<tr class="headderTable">
				<th colspan="5" style="background:#FFFFFF;border: 0px;">สะสม วันที่ 1 ม.ค. - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?>
				</th>
			</tr>
			<tr>
				<th style="background:#face74;border: 1px solid black ;">ลำดับ<br><?php echo $year + 543; ?></th>
				<th style="background:#face74;border: 1px solid black ;">ลำดับ<br><?php echo $year + 542; ?></th>
				<th style="background:#face74;border: 1px solid black ;">ด่าน</th>
				<th style="background:#face74;border: 1px solid black ;">จำนวนนักท่องเที่ยว</th>
				<th style="background:#face74;border: 1px solid black ;">สัดส่วน</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach ($data_month as $k => $v) {
				$icon = '';
				if (!empty($numberMonth[$v['PORT_ID']])) {
					if ($i == $numberMonth[$v['PORT_ID']]) {
						$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['PORT_ID']] . ')</span>';
					} else if ($i < $numberMonth[$v['PORT_ID']]) {
						$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['PORT_ID']] . ')</span>';
					} else if ($i > $numberMonth[$v['PORT_ID']]) {
						$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['PORT_ID']] . ')</span>';
					}
				}
			?>
				<tr>
					<td align="center"> <b><?php echo $i++ ?></b> </td>
					<td align="center"> <?php echo @$numberMonth[$v['PORT_ID']] ?> </td>
					<td> <?php echo $v['PORT_NAME'] ?> </td>
					<td align="right"> <?php echo number_format($v['NUM']); ?> </td>
					<td align="center"> <?php if ($sumMonth > 0) {
											echo number_format($v['NUM'] / $sumMonth * 100, 2);
										} ?> %</td>
				</tr>
			<?php } ?>
			<tr style="border:0px">
				<td colspan="5">* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)</td>
			</tr>
		</tbody>
	</table>