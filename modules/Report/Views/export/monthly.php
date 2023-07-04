<?php include_once("export_css.php"); ?>
<style>
	.radiusTableNation {
		border-radius: 1em;
		overflow: hidden;
		/* background-color: red; */
	}

	.radiusTableNation tbody tr:nth-of-type(odd) {
		background: rgba(214, 239, 242, 1);
	}

	.table thead th {
		border-bottom: none;
	}

	.radiusTableNation thead th {
		background: rgba(55, 159, 166, 1);
		padding: 16px
			/* font-weight:bold; */
	}

	.table-responsive {
		overflow: auto;
	}
</style>
<table style="width:100%">
	<tr>
		<td class="headderTable">
			<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายเดือน</b>
		</td>
	</tr>
	<tr>
		<td>เดือน  <?php foreach($month_label as $m_id=>$name){ $sel = ''; if($month==$m_id){  echo $name;  } } ?></td>
	</tr>
	<tr>
		<td>ปี  <?php for($i=date('Y');$i >= date('Y')-5;$i--){ $sel = ''; if($year==$i){ echo $i+543; } }?></td>
	</tr>
</table>


<div class="row">
	<div class="col-md-12 col-12">
		<div class="table-responsive">
			<table class="table table-striped table-tableborder radiusTableNation ">
				<thead>
					<tr>
						<th rowspan="2" >สัญชาติ</th>
						<?php foreach($port_colunm as $p){ 
							$colspan= 1;
							if(!empty($point[$p['PORT_ID']])){ $colspan = count($point[$p['PORT_ID']]); } 
								 echo '<th colspan="'.$colspan.'">'.$p['PORT_NAME_FULL'].'</th>'; 
							} ?>
					</tr>
					<tr>
						<?php foreach($port_colunm as $p){
							if(!empty($point[$p['PORT_ID']])){ 
								foreach($point[$p['PORT_ID']] as $po){
									echo '<th>'.@$po['POINT_NAME'].'</th>';
								} 
							}else{
								echo '<th></th>';
							}
						 }?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="font-weight: bolder;">GRAND TOTAL</td>
						<?php foreach($port_colunm as $p){
							if(!empty($point[$p['PORT_ID']])){ 
								foreach($point[$p['PORT_ID']] as $po){
									// echo '<td>'.@$d['NUM'][$p['PORT_ID']][$po['POINT_ID']].'</td>';
									$sum = getSumData($data, $region, 0, $country, $p['PORT_ID'], $po['POINT_ID']);
									echo '<td align="right">' . ($sum) . '</td>';
								} 
							}else{
								// echo '<td>'.@$d['NUM'][$p['PORT_ID']][0].'</td>';
								$sum = getSumData($data, $region, 0, $country, $p['PORT_ID'], 0);
								echo '<td align="right">' . ($sum) . '</td>';
							}
						 }?>

					</tr>
					<?php genTableData($data, $region, 0, $country, $port_colunm, $point); ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>

<?php 
function genTableData($data, $region, $region_id, $country, $port_colunm, $point, $level = 1)
{
	$level++;



	if (!empty($region[$region_id])) {
		foreach ($region[$region_id] as $re) {

			$padding_region = $level * 10;
			$alink = '';
			if (!empty($country[$re['MD_STD_REG_ID']])  && $re['IS_OTHERS'] != 'Y') {
				$alink = '<a onclick="ShowHide(' . $re['MD_STD_REG_ID'] . ')"> <i class="fa-solid fa-caret-down"></i> </a>';
			}

			echo '<tr style="background: #ADE0E5;" id="TR-' . $re['MD_STD_REG_ID'] . '" >';
			echo '<td style="padding-left:' . $padding_region . 'px; font-weight: bolder;"> ' . $alink . ' ' . $re['MD_STD_REG_NAMEEN'] . '</td>';
			if (!empty($port_colunm)) {
				foreach ($port_colunm as $p) {
					if(!empty($point[$p['PORT_ID']])){ 
						foreach($point[$p['PORT_ID']] as $po){
							$sum = getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $p['PORT_ID'], $po['POINT_ID']);
							echo '<td align="right">' . ($sum) . '</td>';
						} 
					}else{
						$sum = getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $p['PORT_ID'], 0);
							echo '<td align="right">' . ($sum) . '</td>';
					}
				}
			}
			echo '</tr>';


			if (!empty($country[$re['MD_STD_REG_ID']])  && $re['IS_OTHERS'] != 'Y') {
				foreach ($country[$re['MD_STD_REG_ID']] as $co) {

					$padding_country = $level * 15;
					echo '<tr class="TR-Parent-' . $re['MD_STD_REG_ID'] . '">';
					echo '<td style="padding-left:' . $padding_country . 'px;">' . $co['COUNTRY_NAME_EN'] . '</td>';
					if (!empty($port_colunm)) {
						foreach ($port_colunm as $p) {
							if(!empty($point[$p['PORT_ID']])){ 
								foreach($point[$p['PORT_ID']] as $po){
									echo "<td align='right'>" . (@$data[$co['COUNTRYID']]['NUM'][$p['PORT_ID']][$po['POINT_ID']]) . "</td>";
								} 
							}else{
								echo "<td align='right'>" . (@$data[$co['COUNTRYID']]['NUM'][$p['PORT_ID']][0]) . "</td>";
							}
						}
					}
					echo '</tr>';
				}
			}

			genTableData($data, $region, $re['MD_STD_REG_ID'], $country, $port_colunm, $point, $level);
		}
	}

	++$level;
}

function getSumData($data, $region, $region_id, $country, $port_id, $point_id, &$sum = 0)
{
	if (!empty($country[$region_id])) {
		foreach ($country[$region_id] as $co) {
			$sum += @$data[$co['COUNTRYID']]['NUM'][$port_id][$point_id];
		}
	}



	if (!empty($region[$region_id])) {
		foreach ($region[$region_id] as $re) {
			getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $port_id, $point_id, $sum);
		}
	}

	return $sum;
}
?>