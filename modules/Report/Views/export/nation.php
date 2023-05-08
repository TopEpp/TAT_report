<?php 
	$sumDay = 0;
	foreach ($data_day as $k=>$subArray) {
	  $sumDay += $subArray['NUM'];
	}
	$sumDay = ceil($sumDay);

	$sumMonth = 0;
	foreach ($data_month as $k=>$subArray) {
	  $sumMonth += $subArray['NUM'];
	}
	$sumMonth = ceil($sumMonth);

	$report_date = $Mydate->date_eng2thai($to_date,543);

	$numberDay = $numberMonth = array();
	$i = 1;
	foreach($data_day_lastyear as $v){
		$numberDay[$v['COUNTRY_ID']] = $i++;
	}

	$i = 1;
	foreach($data_month_lastyear as $v){
		$numberMonth[$v['COUNTRY_ID']] = $i++;
	}
	?>

<table>
	<tr>
		<td><b>ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543)?></b></td>
	</tr>
	<tr>
		<td>
			<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายสัญชาติ วันที่ : 
		<?php echo $Mydate->date_eng2thai($to_date, 543);?></b>
		</td>
	</tr>
</table>

	  
		<table class="table table-striped table-bordered" id="table1">
			<thead>
				<tr>
					<th colspan="5"><b>ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543);?></b></th>
				</tr>
				<tr>
					<th>ลำดับ<br><?php echo $year+543;?></th>
					<th>ลำดับ<br><?php echo $year+542;?></th>
					<th>สัญชาติ</th>
					<th>จำนวนนักท่องเที่ยว</th>
					<th>สัดส่วน</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			   	if(!empty($data_day)){
				$sum_other=0; $i=1; foreach ($data_day as $k=>$v) { 
				$icon = '';
				if($i <=50){
				if(!empty($numberDay[$v['COUNTRY_ID']])){
					if($i==$numberDay[$v['COUNTRY_ID']]){
						$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">('.$numberDay[$v['COUNTRY_ID']].')</span>';
					}else if($i < $numberDay[$v['COUNTRY_ID']]){
						$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">('.$numberDay[$v['COUNTRY_ID']].')</span>';
					}else if($i > $numberDay[$v['COUNTRY_ID']]){
						$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">('.$numberDay[$v['COUNTRY_ID']].')</span>';
					}
				}
				
				?>
				<tr>
					<td align="center"> <b><?php echo $i++?></b> </td>
					<td align="center"> <?php echo @$numberDay[$v['COUNTRY_ID']]?> </td>
					<td> <?php echo $v['COUNTRY_NAME_EN']?> </td>
					<td align="right"> <?php echo number_format($v['NUM']);?> </td>
					<td align="center"> <?php echo number_format($v['NUM']/$sumDay*100,2);?> %</td>
				</tr>
			<?php }else{ $sum_other+=$v['NUM']; }}?>
			</tbody>
			<tfoot>
				<tr>
					<td align="center"></td>
					<td align="center"></td>
					<td> Other </td>
					<td style="text-align:right;"> <?php echo number_format($sum_other);?> </td>
					<td style="text-align:center;"> <?php echo number_format($sum_other/$sumMonth*100,2);?> %</td>
				</tr>
				<tr>
					<td colspan="5">* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)</td>
				</tr>
			</tfoot>
			<?php } ?>
		</table>
	
		<?php if($export_type == 'pdf'){ ?><pagebreak> <?php } ?>
		<table class="table table-striped table-bordered" id="table2">
			<thead>
				<tr>
					<th colspan="5"><b>สะสม วันที่ 1 ม.ค. - <?php echo $Mydate->date_eng2thai($to_date, 543,'S')?></b></th>
				</tr>
				<tr>
					<th>ลำดับ<br><?php echo $year+543;?></th>
					<th>ลำดับ<br><?php echo $year+542;?></th>
					<th>สัญชาติ</th>
					<th>จำนวนนักท่องเที่ยว</th>
					<th>สัดส่วน</th>
				</tr>
			</thead>
			<tbody>
			<?php if(!empty($data_month)){
				$sum_other=0; $i=1; foreach ($data_month as $k=>$v) { 
				$icon = '';
				if($i <=50){
				if(!empty($numberMonth[$v['COUNTRY_ID']])){
					if($i==$numberMonth[$v['COUNTRY_ID']]){
						$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">('.$numberMonth[$v['COUNTRY_ID']].')</span>';
					}else if($i < $numberMonth[$v['COUNTRY_ID']]){
						$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">('.$numberMonth[$v['COUNTRY_ID']].')</span>';
					}else if($i > $numberMonth[$v['COUNTRY_ID']]){
						$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">('.$numberMonth[$v['COUNTRY_ID']].')</span>';
					}
				}
				?>
				<tr>
					<td align="center"> <b><?php echo $i++?></b> </td>
					<td align="center"> <?php echo @$numberMonth[$v['COUNTRY_ID']]?> </td>
					<td> <?php echo $v['COUNTRY_NAME_EN']?> </td>
					<td align="right"> <?php echo number_format($v['NUM']);?> </td>
					<td align="center"> <?php echo number_format($v['NUM']/$sumMonth*100,2);?> %</td>
				</tr>
			<?php  }else{ $sum_other+=$v['NUM']; }}?>
			</tbody>
		    <tfoot>
		    	<tr>
						<td align="center"></td>
						<td align="center"></td>
						<td> Other </td>
						<td style="text-align:right;"> <?php echo number_format($sum_other);?> </td>
						<td style="text-align:center;"> <?php echo number_format($sum_other/$sumMonth*100,2);?> %</td>
					</tr>
				<tr>
					<td colspan="5">* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)</td>
				</tr>
		    </tfoot>
		    <?php }?>
		</table>
	

