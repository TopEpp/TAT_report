<?php include_once("export_css.php"); ?>
<table style="width:100%">
	<tr>
		<td class="headderTable">
			<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน รายด่าน </b>
		</td>
	</tr>
</table>
<table border="1" class="table table-striped table-bordered tbl_nation_compare" style="width:100%">
	<thead>
		<tr>
			<th style="background:#007c84;border: 1px solid black ;">ด่าน</th>
			<?php foreach ($period as $d) {
				echo "<th style='background:#007c84;border: 1px solid black ;'>{$Mydate->date_eng2thai($d, 543, 'S', 'S')}</th>";
			} ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style='background-color: #61bec9;'><b>รวมด่านบก</b></td>
			<?php foreach ($port[1] as $p) {
				@$sum[$d] += @$data[$p['PORT_ID']][$d];
				@$sum_type1[$d] += @$data[$p['PORT_ID']][$d];
			} ?>
			<?php foreach ($period as $d) {
				echo "<td style='background-color: #61bec9;'  align='right'> <b> " . number_format(@$sum_type1[$d]) . "</b> </td>";
			} ?>
		</tr>
		<?php foreach ($port[1] as $p) { ?>
			<tr>
				<td><?php echo $p['PORT_NAME'] ?></td>
				<?php foreach ($period as $d) {
					echo "<td align='right'>" . number_format(@$data[$p['PORT_ID']][$d]) . "</td>";
					@$sum[$d] += @$data[$p['PORT_ID']][$d];
					@$sum_type1[$d] += @$data[$p['PORT_ID']][$d];
				} ?>
			</tr>
		<?php } ?>
		<!-- <tr>
			<td style='background-color: #B6E2E9; border: 1px solid black ;'>รวมด่านบก</td>
			<?php foreach ($period as $d) {
				echo "<td style='background-color: #B6E2E9;border: 1px solid black ;'  align='right'>" . number_format(@$sum_type1[$d]) . "</td>";
			} ?>
		</tr> -->
		<tr>
			<td style="background-color: #61bec9;"><b>รวมด่านอากาศ</b></td>
			<?php foreach ($port[2] as $p) {
				@$sum[$d] += @$data[$p['PORT_ID']][$d];
				@$sum_type2[$d] += @$data[$p['PORT_ID']][$d];
			} ?>
			<?php foreach ($period as $d) {
				echo "<td  style='background-color: #61bec9;' align='right'> <b>" . number_format(@$sum_type2[$d]) . "</b> </td>";
			} ?>
		</tr>
		<?php foreach ($port[2] as $p) { ?>
			<tr>
				<td><?php echo $p['PORT_NAME'] ?></td>
				<?php foreach ($period as $d) {
					echo "<td align='right'>" . number_format(@$data[$p['PORT_ID']][$d]) . "</td>";
					@$sum[$d] += @$data[$p['PORT_ID']][$d];
					@$sum_type2[$d] += @$data[$p['PORT_ID']][$d];
				} ?>
			</tr>
		<?php } ?>
		<!-- <tr>
			<td style="background-color: #B6E2E9;border: 1px solid black ;">รวมด่านอากาศ</td>
			<?php foreach ($period as $d) {
				echo "<td style='background-color: #B6E2E9;border: 1px solid black ;' align='right'>" . number_format(@$sum_type2[$d]) . "</td>";
			} ?>
		</tr> -->
	</tbody>
	<tfoot>
		<tr>
			<td style='background-color:#61bec9;border: 1px solid black ;'>รวมทั้งหมด</td>
			<?php foreach ($period as $d) {
				echo "<td style='background-color: #61bec9;border: 1px solid black ;' align='right'>" . number_format(@$sum[$d]) . "</td>";
			} ?>
		</tr>
		<?php if ($export_type == 'excel') { ?>
			<tr style="border:0px">
				<td colspan="5">
					ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
				</td>
			</tr>
		<?php
		}
		?>
	</tfoot>
</table>