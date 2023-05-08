<b>ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543)?></b>
<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน รายด่าน </b>
		
		<table class="table table-striped table-bordered ">
			<thead>
				<tr>
					<th>ด่าน</th>
					<?php foreach($period as $d){ echo "<th>{$Mydate->date_eng2thai($d, 543,'S','S')}</th>";} ?>
				</tr>
			</thead>
			<tbody>
			<?php foreach($port[1] as $p){ ?>
				<tr>
					<td><?php echo $p['PORT_NAME']?></td>
					<?php foreach($period as $d){ echo "<td align='right'>".number_format(@$data[$p['PORT_ID']][$d])."</td>"; @$sum[$d] += @$data[$p['PORT_ID']][$d]; @$sum_type1[$d] += @$data[$p['PORT_ID']][$d];  }?>
				</tr>
			<?php }?>
				<tr>
					<td style='background-color: #B6E2E9;'>รวมด่านบก</td>
					<?php foreach($period as $d){ echo "<td style='background-color: #B6E2E9;'  align='right'>".number_format(@$sum_type1[$d])."</td>";  } ?>
				</tr>
			<?php foreach($port[2] as $p){ ?>
				<tr>
					<td><?php echo $p['PORT_NAME']?></td>
					<?php foreach($period as $d){ echo "<td align='right'>".number_format(@$data[$p['PORT_ID']][$d])."</td>"; @$sum[$d] += @$data[$p['PORT_ID']][$d]; @$sum_type2[$d] += @$data[$p['PORT_ID']][$d]; }?>
				</tr>
			<?php }?>
				<tr>
					<td style="background-color: #B6E2E9;">รวมด่านอากาศ</td>
					<?php foreach($period as $d){ echo "<td style='background-color: #B6E2E9;' align='right'>".number_format(@$sum_type2[$d])."</td>";  } ?>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td style='background-color: #007C84;'>รวมทั้งหมด</td>
					<?php foreach($period as $d){ echo "<td style='background-color: #007C84;' align='right'>".number_format(@$sum[$d])."</td>";  } ?>
				</tr>
			</tfoot>
		</table>