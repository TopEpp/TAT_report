<?php include_once("export_css.php"); ?>
<table style="width:100%">
	<tr>
		<td class="headderTable">
			<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย จำแนกรายตลาด (ตลาดระยะใกล้ - ตลาดระยะไกล)
			</b>
		</td>
	</tr>
</table>

<table border="1" class="table table-bordered table-striped tbl_market1" style="width:100%">
	<thead>
		<tr>
			<th colspan="4" style="background-color: white; border: 0px;">ตลาดระยะใกล้ (Short Haul)</th>
		</tr>
		<tr>
			<th style="background:#fda3a9;border: 1px solid black ;">ลำดับ</th>
			<th style="background:#fda3a9;border: 1px solid black ;">สัญชาติ</th>
			<th style="background:#fda3a9;border: 1px solid black ;">จำนวนนักท่องเที่ยว</th>
			<th style="background:#fda3a9;border: 1px solid black ;">สัดส่วน</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0;
		foreach ($country['Short'] as $c) {
			$i++;
			$ratio = 0;
			if (@$data[$c['COUNTRYID']]['NUM'] > 0) {
				$ratio = @$data[$c['COUNTRYID']]['NUM'] / $data['SUM'] * 100;
			}
		?>
			<tr>
				<td align="center"><?php echo $i ?></td>
				<td align="left"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
				<td align="right"><?php echo @number_format(@$data[$c['COUNTRYID']]['NUM']) ?></td>
				<td align="right"><?php echo number_format($ratio, 2); ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?php if ($export_type == 'pdf') { ?><pagebreak> <?php } ?>
	<table border="1" class="table table-bordered table-striped tbl_market2" style="width:100%">
		<thead>
			<tr>
				<th colspan="4" style="background-color: white; border: 0px;">ตลาดระยะไกล (Long Haul)</th>
			</tr>
			<tr>
				<th style="background:#937DFF;border: 1px solid black ;">ลำดับ</th>
				<th style="background:#937DFF;border: 1px solid black ;">สัญชาติ</th>
				<th style="background:#937DFF;border: 1px solid black ;">จำนวนนักท่องเที่ยว</th>
				<th style="background:#937DFF;border: 1px solid black ;">สัดส่วน</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 0;
			foreach ($country['Long'] as $c) {
				$i++;
				$ratio = 0;
				if (@$data[$c['COUNTRYID']]['NUM'] > 0) {
					$ratio = @$data[$c['COUNTRYID']]['NUM'] / $data['SUM'] * 100;
				}
			?>

				<tr>
					<td align="center"><?php echo $i ?></td>
					<td align="left"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
					<td align="right"><?php echo @number_format(@$data[$c['COUNTRYID']]['NUM']) ?></td>
					<td align="right"><?php echo number_format($ratio, 2); ?></td>
				</tr>
			<?php } ?>
			<tr style="border:0px">
				<td colspan="5">
					<b>ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?></b>
				</td>
			</tr>
		</tbody>
	</table>