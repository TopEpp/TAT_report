<style>
	.radiusTable1 {
		border-collapse: collapse;
	}

	.radiusTable1 thead th {
		background: #379FA6;
	}

	table,
	td,
	th {
		border: 1px solid black;
	}
</style>
<div>
	<b>ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?></b>
</div>
<div style="text-align:center">
	<b>รายงานเปรียบเทียบจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายด่าน</b>
</div>
<?php if (!empty($country_row) && !empty($port_colunm)) { ?>
	<table class="table table-striped table-bordered radiusTable1" style="width:100%">
		<thead>
			<tr>
				<th rowspan="2">Nation</th>
				<?php if (!empty($port_colunm)) {
					foreach ($port_colunm as $p) { ?>
						<th colspan="<?php echo count($period) ?>"><?php echo $p['PORT_NAME'] ?></th>
				<?php }
				} ?>
			</tr>
			<tr>
				<?php if (!empty($port_colunm)) {
					foreach ($port_colunm as $p) { ?>
						<?php foreach ($period as $d) {
							echo "<th>{$Mydate->date_eng2thai($d, 543, 'S', 'S')}</th>";
						} ?>
				<?php }
				} ?>
			</tr>
		</thead>
		<tbody>
			<?php genTableData($data, $region, 0, $country, $port_colunm, $period); ?>
		</tbody>
	</table>
<?php } ?>

<?php

function genTableData($data, $region, $region_id, $country, $port_colunm, $period, $level = 1)
{
	$level++;



	if (!empty($region[$region_id])) {
		foreach ($region[$region_id] as $re) {

			$padding_region = $level * 10;
			$alink = '';
			if (!empty($country[$re['MD_STD_REG_ID']])) {
				$alink = '<a onclick="ShowHide(' . $re['MD_STD_REG_ID'] . ')"> <i class="fa-solid fa-caret-down"></i> </a>';
			}

			echo '<tr style="background-color:#B6E2E9" id="TR-' . $re['MD_STD_REG_ID'] . '" >';
			echo '<td style="padding-left: ' . $padding_region . 'px; font-weight: bolder;"> ' . $alink . ' ' . $re['MD_STD_REG_NAMEEN'] . '</td>';
			if (!empty($port_colunm)) {
				foreach ($port_colunm as $p) {
					foreach ($period as $d) {
						$sum = getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $p['PORT_ID'], $d);
						echo '<td align="right">' . number_format($sum) . '</td>';
					}
				}
			}
			echo '</tr>';


			if (!empty($country[$re['MD_STD_REG_ID']])) {
				foreach ($country[$re['MD_STD_REG_ID']] as $co) {

					$padding_country = $level * 15;
					echo '<tr class="TR-Parent-' . $re['MD_STD_REG_ID'] . '">';
					echo '<td style="padding-left:' . $padding_country . 'px;">' . $co['COUNTRY_NAME_EN'] . '</td>';
					if (!empty($port_colunm)) {
						foreach ($port_colunm as $p) {
							foreach ($period as $d) {
								echo "<td align='right'>" . @number_format(@$data[$co['COUNTRYID']][$p['PORT_ID']][$d]['NUM']) . "</td>";
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