<?php include_once("export_css.php"); ?>
<style>
	.radiusTableport_departure thead th {

		background: rgba(55, 159, 166, 1);
		padding: 10px;
	}

	.table thead th {
		border-bottom: none;
	}

	.radiusTableport_departure {
		border-radius: 1em;
		overflow: hidden;

	}

	.radiusTableport_departure tbody tr:nth-of-type(odd) {
		background: rgba(214, 239, 242, 1);
	}

	.table-bordered th,
	.table-bordered td {
		border-left: none
	}

	.radiusTableport_departure tfoot td {

		background: rgba(55, 159, 166, 1);
	}
</style>
<?php
function isWeekend($date) {
	list($day, $month, $year) = explode('-', $date);
	if(checkdate($month,$day,$year)){ 
		$weekDay = date('w', strtotime($date));
		return ($weekDay == 0 || $weekDay == 6);
	}else{
		return false;
	}
	
}
?>
<table style="width:100%">
	<tr>
		<td colspan="13" class="headderTable" style="text-align: center;">
			<b>สถิติคนไทยเดินทางออกนอกประเทศ รายวัน</b> <b>ปี <?php echo $year?></b>
		</td>
	</tr>
	<tr>
		<td colspan="13">
			<?php 
			if(count($port_type)==count($select_port[1])+count($select_port[2])){
				echo 'ด่านทั้งหมด';
			}else{
				if(!empty($port_type)){ echo 'ด่าน : ';}

				$port_label1 = $port_label2 = '';
				$count_port1=$count_sel_port1=$count_port2=$count_sel_port2=0;
				foreach ($select_port[1] as $p_id=>$port) { 
					$count_port1++;
					if (in_array($p_id, $port_type)) { $count_sel_port1++; $port_label1 .= $port.', ';}
				}
				foreach ($select_port[2] as $p_id=>$port) { 
					$count_port2++;
					if (in_array($p_id, $port_type)) { $count_sel_port2++; $port_label2 .= $port.', ';}
				}

				if($count_port2==$count_sel_port2){
					$port_label2 =  'ด่านอากาศทั้งหมด , ';
				}

				if($count_port1==$count_sel_port1){
					$port_label1 = 'ไม่ใช่ด่านอากาศทั้งหมด';
				}

				$label = $port_label2.$port_label1;
				echo substr($label, 0,-2);

				
			}
			?>
		</td>
	</tr>
</table>


			<table class="table table-bordered radiusTableport_departure" style="width:100%">
				<thead>
					<tr>
						<th>วันที่</th>
						<?php foreach ($month_label as $key => $value) { 
							echo '<th>'.$value.'</th>';
						} ?>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php for($i=1;$i<=31;$i++){ ?>
					<tr>
						<td style="background-color:#FFF; text-align: center;"><?php echo $i;?></td>
					<?php $first = true; 
					    foreach ($month_label as $month => $value) { 
						$dataKey = sprintf("%02s", $i).'-'.sprintf("%02s", $month).'-'.$year; 
						$bg = '#FFF';
						if(isWeekend($dataKey)){ $bg = '#d6eff2'; }
						if(@$max[$month]<=@$data[$dataKey]){
							@$max[$month] = $data[$dataKey];
						}

						if(empty($min[$month])){
							$min[$month] = @$data[$dataKey];
						}

						if(isset($data[$dataKey])){
							if (@$data[$dataKey] < @$min[$month]) {
			                    $min[$month] = @$data[$dataKey];
			                   
			                }
			                $count_day[$month] = $i;
						}

			            @$sum[$month] += $data[$dataKey];
			            @$sum_day[$i] += $data[$dataKey];
			            @$sumTotal += $data[$dataKey];
					?>
							<td style="background-color:<?php echo $bg;?>; text-align: right;"><?php if(!empty($data[$dataKey])){ echo number_format($data[$dataKey]); } ?></td>
					<?php }?>
						<td style="text-align:right; background: rgba(55, 159, 166, 1) !important;"><?php echo number_format($sum_day[$i]);?></td>
					</tr>
					<?php }?>
				</tbody>
				<tfoot>
					<tr>
						<td style="text-align:center;">รวม</td>
						<?php foreach ($month_label as $month => $value) { ?>
							<td style="text-align:right;"><?php if(isset($count_day[$month])){ echo number_format(@$sum[$month]);}else{ echo '-';}?></td>
						<?php } ?>
						<td style="text-align:right;"><?php echo number_format($sumTotal);?></td>
					</tr>
					<tr>
						<td style="text-align:center;">Average</td>
						<?php foreach ($month_label as $month => $value) { 
							$d=cal_days_in_month(CAL_GREGORIAN,$month,$year); ?>
							<td style="text-align:right;"><?php if(isset($count_day[$month])){ echo number_format(@$sum[$month]/$count_day[$month]);}else{ echo '-';}?></td>
						<?php } ?>
						<td></td>
					</tr>
					<tr>
						<td style="text-align:center;">Max</td>
						<?php foreach ($month_label as $month => $value) { ?>
							<td style="text-align:right;"><?php if(isset($count_day[$month])){ echo number_format(@$max[$month]);}else{ echo '-';}?></td>
						<?php } ?>
						<td></td>
					</tr>
					<tr>
						<td style="text-align:center;">Min</td>
						<?php foreach ($month_label as $month => $value) { ?>
							<td style="text-align:right;"><?php if(isset($count_day[$month])){ echo number_format(@$min[$month]);}else{ echo '-';}?></td>
						<?php } ?>
						<td></td>
					</tr>
				</tfoot>
			</table>