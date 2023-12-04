<?php include_once("export_css.php"); ?>
<table style="width:100%">
	<tr>
		<td class="headderTable">
			<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายด่าน</b>
		</td>
	</tr>
</table>
<?php if (!empty($country_row) && !empty($port_colunm)) { ?>
	<table border="1" style="width:100%" class="table table-striped table-bordered tbl_nation">
		<thead>
			<tr>
				<th rowspan="2" style="background:#379FA6;border: 1px solid black ;">Nation</th>
				<?php if (!empty($port_colunm)) {
					foreach ($port_colunm as $p) { ?>
						<th style="background:#379FA6;border: 1px solid black ;" colspan="<?php echo count($period) ?>"><?php echo $p['PORT_NAME'] ?></th>
				<?php }
				} ?>
			</tr>
			<tr>
				<?php if (!empty($port_colunm)) {
					foreach ($port_colunm as $p) { ?>
						<?php foreach ($period as $d) {
							echo "<th style='background:#379FA6;border: 1px solid black ;'>{$Mydate->date_eng2thai($d, 543, 'S', 'S')}</th>";
						} ?>
				<?php }
				} ?>
			</tr>
		</thead>
		<tbody>
			<?php if($country_id){ 
					$country_name = $country_select[$country_id];
					getTableCountry($data, $country_name, $country_id, $port_colunm, $period); 
				}else{
					genTableData($data, $region, 0, $country, $port_colunm, $period); }
			?>
		</tbody>
		<?php if ($export_type == 'excel') { ?>
			<tr style="border:0px">
				<td colspan="5">
					ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
				</td>
			</tr>
		<?php
		}
		?>
	</table>
<?php } ?>
<?php

function getTableCountry($data, $country_name, $country_id,$port_colunm,$period){

	echo '<tr class="TR-Parent">';
	echo '<td style="">'.$country_name.'</td>';
	if (!empty($port_colunm)) {
		foreach ($port_colunm as $p) {
			foreach ($period as $d) {
				echo "<td align='right'>" . @number_format(@$data[$country_id][$p['PORT_ID']][$d]['NUM']) . "</td>";
			}
		}
	}
	echo '</tr>';
}

function genTableData($data, $region, $region_id, $country, $port_colunm, $period, $level = 1)
{
	$level++;



	if (!empty($region[$region_id])) {
		foreach ($region[$region_id] as $re) {

			$padding_region = $level * 10;
			$alink = '';
			if (!empty($country[$re['MD_STD_REG_ID']]) && $re['IS_OTHERS'] != 'Y') {
				$alink = '<a onclick="ShowHide(' . $re['MD_STD_REG_ID'] . ')"> <i class="fa-solid fa-caret-down"></i> </a>';
			}

			echo '<tr style="background-color:#4EB8CA;border: 1px solid #3a4a4a ;" id="TR-' . $re['MD_STD_REG_ID'] . '" >';
			echo '<td style="background-color:#4EB8CA; border: 1px solid #3a4a4a ; padding-left: ' . $padding_region . 'px; font-weight: bolder;"> ' . $alink . ' ' . $re['MD_STD_REG_NAMEEN'] . '</td>';
			if (!empty($port_colunm)) {
				foreach ($port_colunm as $p) {
					foreach ($period as $d) {
						$sum = getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $p['PORT_ID'], $d);
						echo '<td align="right" style="background-color:#4EB8CA;border: 1px solid #3a4a4a ;">' . ($sum) . '</td>';
					}
				}
			}
			echo '</tr>';


			if (!empty($country[$re['MD_STD_REG_ID']]) && $re['IS_OTHERS'] != 'Y') {
				foreach ($country[$re['MD_STD_REG_ID']] as $co) {

					$padding_country = $level * 15;
					echo '<tr style="background-color:#eaf3f4;border: 1px solid #3a4a4a ;" class="TR-Parent-' . $re['MD_STD_REG_ID'] . '">';
					echo '<td style="background-color:#eaf3f4;border: 1px solid #3a4a4a ;padding-left:' . $padding_country . 'px;">' . $co['COUNTRY_NAME_EN'] . '</td>';
					if (!empty($port_colunm)) {
						foreach ($port_colunm as $p) {
							foreach ($period as $d) {
								echo "<td align='right' style='background-color:#eaf3f4;border: 1px solid #3a4a4a ;'>" . (@$data[$co['COUNTRYID']][$p['PORT_ID']][$d]['NUM']) . "</td>";
							}
						}
					}
					echo '</tr>';
				}
			}

			genTableData($data, $region, $re['MD_STD_REG_ID'], $country, $port_colunm, $period, $level);
		}
	}

	++$level;
}


function getSumData($data, $region, $region_id, $country, $port_id, $day, &$sum = 0)
{
	if (!empty($country[$region_id])) {
		foreach ($country[$region_id] as $co) {
			$sum += @$data[$co['COUNTRYID']][$port_id][$day]['NUM'];
		}
	}



	if (!empty($region[$region_id])) {
		foreach ($region[$region_id] as $re) {
			getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $port_id, $day, $sum);
		}
	}

	return $sum;
}
?>