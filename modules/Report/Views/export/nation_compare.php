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
		<?php
		list($year, $month, $day) = explode('-', $start_date1);
		$start_date1 = $day . '-' . $month . '-' . $year;
		list($year, $month, $day) = explode('-', $start_date2);
		$start_date2 = $day . '-' . $month . '-' . $year;
		list($year, $month, $day) = explode('-', $end_date1);
		$end_date1 = $day . '-' . $month . '-' . $year;
		list($year, $month, $day) = explode('-', $end_date2);
		$end_date2 = $day . '-' . $month . '-' . $year;

		?>
		<div style="text-align:center;">
			<b>รายงานเปรียบเทียบจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายสัญชาติ</b>
		</div>
		<table class="table table-striped table-bordered radiusTable1" style="width:100%">
			<thead>

				<tr>
					<th></th>
					<th>สะสมวันที่ <?php echo $Mydate->date_eng2thai($start_date1, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($end_date1, 543, 'S', 'S') ?></th>
					<th>สะสมวันที่ <?php echo $Mydate->date_eng2thai($start_date2, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($end_date2, 543, 'S', 'S') ?></th>
					<th>อัตราการเปลี่ยนแปลง (%)</th>
				</tr>
			</thead>
			<tbody>
				<tr style="background-color:#B6E2E9">
					<td style="font-weight: bolder;">GRAND TOTAL</td>
					<?php
					$sum1 = $sum2 = $sum_diff = 0;
					$sum_compare = '';
					$dataSum = getSumData($data1, $data2, $region, 0, $country);
					$sum1 = $dataSum['sum1'];
					$sum2 = $dataSum['sum2'];
					if ($sum2 > 0) {
						$sum_diff = $sum2 - $sum1;
						if ($sum1 > 0) {
							$sum_compare = number_format($sum_diff / $sum1 * 100, 2) . ' %';
						}
						if ($sum_diff < 0) {
							$sum_compare = "<span style='color:red'>{$sum_compare} </span>";
						}
					}

					?>
					<td align="right"><?php echo number_format($sum1); ?></td>
					<td align="right"><?php echo number_format($sum2); ?></td>
					<td align="center"><?php echo $sum_compare; ?></td>
				</tr>
				<?php genTableData($data1, $data2, $region, 0, $country) ?>
			</tbody>
		</table>

		<?php

		function genTableData($data1, $data2, $region, $region_id, $country, $level = 1)
		{
			$level++;



			if (!empty($region[$region_id])) {
				foreach ($region[$region_id] as $re) {

					$sum1 = $sum2 = $sum_diff = 0;
					$sum_compare = '';
					$dataSum = getSumData($data1, $data2, $region, $re['MD_STD_REG_ID'], $country);
					$sum1 = $dataSum['sum1'];
					$sum2 = $dataSum['sum2'];

					if ($sum2 > 0) {
						$sum_diff = $sum2 - $sum1;
						if ($sum1 > 0) {
							$sum_compare = number_format($sum_diff / $sum1 * 100, 2) . ' %';
						}
						if ($sum_diff < 0) {
							$sum_compare = "<span style='color:red'>{$sum_compare} </span>";
						}
					}

					$padding_region = $level * 10;
					$alink = '';
					if (!empty($country[$re['MD_STD_REG_ID']])) {
						$alink = '<a onclick="ShowHide(' . $re['MD_STD_REG_ID'] . ')"> <i class="fa-solid fa-caret-down"></i> </a>';
					}

					echo '<tr style="background-color:#B6E2E9" id="TR-' . $re['MD_STD_REG_ID'] . '" >';
					echo '<td style="padding-left: ' . $padding_region . 'px; font-weight: bolder;"> ' . $alink . ' ' . $re['MD_STD_REG_NAMEEN'] . '</td>';
					echo '<td align="right">' . number_format($sum1) . '</td>';
					echo '<td align="right">' . number_format($sum2) . '</td>';
					echo '<td  align="center">' . $sum_compare . '</td>';
					echo '</tr>';


					if (!empty($country[$re['MD_STD_REG_ID']])) {
						foreach ($country[$re['MD_STD_REG_ID']] as $co) {
							$compare = '';
							$num1 = @$data1[$co['COUNTRYID']]['NUM'];
							$num2 = @$data2[$co['COUNTRYID']]['NUM'];
							if ($num2 > 0) {
								$diff = $num2 - $num1;
								if ($num1 > 0) {
									$compare = number_format($diff / $num1 * 100, 2) . ' %';
								}
								if ($diff < 0) {
									$compare = "<span style='color:red'>{$compare} </span>";
								}
							}

							$padding_country = $level * 15;
							echo '<tr class="TR-Parent-' . $re['MD_STD_REG_ID'] . '">';
							echo '<td style="padding-left:' . $padding_country . 'px;">' . $co['COUNTRY_NAME_EN'] . '</td>';
							echo '<td align="right">' . number_format(@$num1) . '</td>';
							echo '<td align="right">' . number_format(@$num2) . '</td>';
							echo '<td align="center">' . $compare . '</td>';
							echo '</tr>';
						}
					}

					genTableData($data1, $data2, $region, $re['MD_STD_REG_ID'], $country, $level);
				}
			}

			++$level;
		}

		function getSumData($data1, $data2, $region, $region_id, $country, &$sum1 = 0, &$sum2 = 0)
		{
			if (!empty($country[$region_id])) {
				foreach ($country[$region_id] as $co) {
					$num1 = @$data1[$co['COUNTRYID']]['NUM'];
					$num2 = @$data2[$co['COUNTRYID']]['NUM'];

					$sum1 += $num1;
					$sum2 += $num2;
				}
			}

			if (!empty($region[$region_id])) {
				foreach ($region[$region_id] as $re) {
					getSumData($data1, $data2, $region, $re['MD_STD_REG_ID'], $country, $sum1, $sum2);
				}
			}

			$data['sum1'] = $sum1;
			$data['sum2'] = $sum2;
			return $data;
		}

		?>