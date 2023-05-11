<style>
	.radiusTable1 {
		border-collapse: collapse;
	}

	.radiusTable1 thead th {
		background: rgba(253, 163, 169, 1);
	}

	table,
	td,
	th {
		border: 1px solid black;
	}

	.radiusTable2 thead th {
		background: #937DFF;
	}

	.radiusTable2 {
		border-collapse: collapse;
	}
</style>
<div>
	<b>ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?></b>
</div>
<div style="text-align:center">
	<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย จำแนกรายตลาด (ตลาดระยะใกล้ - ตลาดระยะไกล)</b>
</div>
<div style="text-align:center">
	<b>
		ตลาดระยะใกล้ (Short Haul)
	</b>
</div>
<table class="table table-bordered table-striped radiusTable1" style="width:100%">
	<thead>
		<tr>
			<th>ลำดับ</th>
			<th>สัญชาติ</th>
			<th>จำนวนนักท่องเที่ยว</th>
			<th>สัดส่วน</th>
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
	<div style="text-align:center">
		<b>
			ตลาดระยะไกล (Long Haul)
		</b>
	</div>
	<table class="table table-bordered table-striped radiusTable2" style="width:100%">
		<thead>

			<tr>
				<th>ลำดับ</th>
				<th>สัญชาติ</th>
				<th>จำนวนนักท่องเที่ยว</th>
				<th>สัดส่วน</th>
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
		</tbody>
	</table>