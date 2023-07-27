<?php include_once("export_css.php"); ?>
<?php 
$Short_SUM = $Long_SUM = 0;
foreach ($data['Short'] as $key=> $c) {
	// @$data['Short']['SUM'] += $c['NUM'];
	$Short_SUM +=$c['NUM'];
}
foreach ($data['Long'] as $key=> $c) {
	// @$data['Long']['SUM'] += $c['NUM'];
	$Long_SUM +=$c['NUM'];
}
?>
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
			<th style="background:#fda3a9;border: 1px solid black ;">จำนวนนักท่องเที่ยว (คน)</th>
			<th style="background:#fda3a9;border: 1px solid black ;">สัดส่วน (%)</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0;
		foreach ($data['Short'] as $key=> $c) {
			

			$i++;
			$ratio = 0;
			if ($c['NUM'] > 0) {
				$ratio = $c['NUM'] / $Short_SUM * 100;
			}
		?>
			<tr>
				<td align="center"><?php echo $i ?></td>
				<td align="left"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
				<td align="right"><?php echo (@$c['NUM']) ?></td>
				<td align="right"><?php echo number_format($ratio, 2); ?></td>
			</tr>
		<?php } ?>
		<?php if ($export_type == 'excel') { ?>
			<tr style="border:0px">
				<td colspan="5">
					ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
				</td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>
<?php if ($export_type == 'pdf') { ?><pagebreak> <?php } ?>
	<table style="width:100%">
		<tr>
			<td class="headderTable">
				<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย จำแนกรายตลาด (ตลาดระยะใกล้ - ตลาดระยะไกล)
				</b>
			</td>
		</tr>
	</table>
	<table border="1" class="table table-bordered table-striped tbl_market2" style="width:100%">
		<thead>
			<tr>
				<th colspan="4" style="background-color: white; border: 0px;">ตลาดระยะไกล (Long Haul)</th>
			</tr>
			<tr>
				<th style="background:#937DFF;border: 1px solid black ;">ลำดับ</th>
				<th style="background:#937DFF;border: 1px solid black ;">สัญชาติ</th>
				<th style="background:#937DFF;border: 1px solid black ;">จำนวนนักท่องเที่ยว (คน)</th>
				<th style="background:#937DFF;border: 1px solid black ;">สัดส่วน (%)</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 0;
					foreach ($data['Long'] as $key=> $c) {
					
						$i++;
						$ratio = 0;
						if ($c['NUM'] > 0) {
							$ratio = @$c['NUM'] / $Long_SUM * 100;
						}
					?>

				<tr>
					<td align="center"><?php echo $i ?></td>
					<td align="left"><?php echo $c['COUNTRY_NAME_EN'] ?></td>
					<td align="right"><?php echo (@$c['NUM']) ?></td>
					<td align="right"><?php echo number_format($ratio, 2); ?></td>
				</tr>
			<?php } ?>
			<?php if ($export_type == 'excel') { ?>
				<tr style="border:0px">
					<td colspan="5">
						ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
					</td>
				</tr>
			<?php
			} 
			?>
		</tbody>
	</table>