<b>ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543)?></b>
<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน จำแนกรายสัญชาติ</b>
			<table class="table table-striped table-bordered ">
				<thead>
					<tr>
						<th>Nation</th>
						<?php foreach($period as $d){ echo "<th>{$Mydate->date_eng2thai($d, 543,'S','S')}</th>";} ?>
					</tr>
				</thead>
				<tbody>
					<tr style="background-color:#B6E2E9">
						<td style="font-weight: bolder;">GRAND TOTAL</td>
						<?php $dataSum = getSumData($data,$region,0,$country,$period);		
						foreach($period as $d){
							echo "<td align='right'>".number_format(@$dataSum[$d])."</td>"; 
						}
						?>
						
					</tr>
				<?php genTableData($data,$region,0,$country,$period)?>
				</tbody>
			</table>
<?php 

function genTableData($data,$region,$region_id,$country,$period,$level=1){
	$level++;

	if(!empty($region[$region_id])){ 
		foreach($region[$region_id] as $re){ 
		$dataSum = getSumData($data,$region,$re['MD_STD_REG_ID'],$country,$period);		
		
		$padding_region = $level*10;
		$alink = '';
		if(!empty($country[$re['MD_STD_REG_ID']])){ 
			// $alink = '<a onclick="ShowHide('.$re['MD_STD_REG_ID'].')"> <i class="fa-solid fa-caret-down"></i> </a>';
		}
		 
		echo '<tr style="background-color:#B6E2E9" id="TR-'.$re['MD_STD_REG_ID'].'" >';
			echo '<td style="padding-left: '.$padding_region.'px; font-weight: bolder;"> '.$alink.' '.$re['MD_STD_REG_NAMEEN'].'</td>';
			foreach($period as $d){
				echo "<td align='right'>".number_format(@$dataSum[$d])."</td>"; 
			}
		echo '</tr>';


		if(!empty($country[$re['MD_STD_REG_ID']])){ 
			foreach($country[$re['MD_STD_REG_ID']] as $co){ 
				
				
				$padding_country = $level*15;
				echo '<tr class="TR-Parent-'.$re['MD_STD_REG_ID'].'">';
					echo '<td style="padding-left:'.$padding_country.'px;">'.$co['COUNTRY_NAME_EN'].'</td>';
					foreach($period as $d){
						echo "<td align='right'>".number_format(@$data[$co['COUNTRYID']][$d])."</td>"; 
					}
				echo '</tr>';
	    	}
		}

		genTableData($data,$region,$re['MD_STD_REG_ID'],$country,$period,$level);

		}
	}

	++$level;

}

function getSumData($data,$region,$region_id,$country,$period,&$sum=array()){
	if(!empty($country[$region_id])){ 
	foreach($country[$region_id] as $co){ 
		foreach($period as $d){
			@$sum[$d] += @$data[$co['COUNTRYID']][$d];
		}
	}}

	if(!empty($region[$region_id])){ 
		foreach($region[$region_id] as $re){ 
			getSumData($data,$region,$re['MD_STD_REG_ID'],$country,$period,$sum);
		}
	}

	
	return $sum;
}

?>