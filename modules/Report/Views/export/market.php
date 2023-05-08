
<b>ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543)?></b>
<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย จำแนกรายตลาด (ตลาดระยะใกล้ - ตลาดระยะไกล)</b>

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="4">ตลาดระยะใกล้ (Short Haul)</th>
					</tr>
					<tr>
						<th>ลำดับ</th>
						<th>สัญชาติ</th>
						<th>จำนวนนักท่องเที่ยว</th>
						<th>สัดส่วน</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach($country['Short'] as $c){ $i++; 
						$ratio = 0;
						if(@$data[$c['COUNTRYID']]['NUM']>0){
							$ratio = @$data[$c['COUNTRYID']]['NUM']/$data['SUM']*100;
						}
				?>
					<tr>
						<td><?php echo $i?></td>
						<td align="left"><?php echo $c['COUNTRY_NAME_EN']?></td>
						<td align="right"><?php echo @number_format(@$data[$c['COUNTRYID']]['NUM'])?></td>
						<td align="right"><?php echo number_format($ratio,2);?></td>
					</tr>
				<?php }?>
				</tbody>
			</table>
			<?php if($export_type == 'pdf'){ ?><pagebreak> <?php } ?>
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th colspan="4">ตลาดระยะไกล (Long Haul)</th>
					</tr>
					<tr>
						<th>ลำดับ</th>
						<th>สัญชาติ</th>
						<th>จำนวนนักท่องเที่ยว</th>
						<th>สัดส่วน</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach($country['Long'] as $c){ $i++;
					$ratio = 0;
						if(@$data[$c['COUNTRYID']]['NUM']>0){
							$ratio = @$data[$c['COUNTRYID']]['NUM']/$data['SUM']*100;
						}
				?>
					<tr>
						<td><?php echo $i?></td>
						<td align="left"><?php echo $c['COUNTRY_NAME_EN']?></td>
						<td align="right"><?php echo @number_format(@$data[$c['COUNTRYID']]['NUM'])?></td>
						<td align="right"><?php echo number_format($ratio,2);?></td>
					</tr>
				<?php }?>
				</tbody>
			</table>

