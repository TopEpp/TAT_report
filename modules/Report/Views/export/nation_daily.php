<?php include_once("export_css.php"); ?>

<table style="width:100%">
	<tr>
		<td class="headderTable">
			<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน จำแนกรายสัญชาติ</b>
		</td>
	</tr>
</table>
<table border="1" class="table table-striped table-bordered tbl_nation_compare" style="width:100%">
	<thead>
		<tr>
			<th style="background-color:#369fa7;border: 1px solid black ;">สัญชาติ</th>
			<?php foreach ($period as $d) {
				// excel: ฝัง ISO yyyy-mm-dd ให้ controller แปลงเป็น Excel date จริง · อื่นๆ (pdf/หน้าจอ) แสดงไทย
				$dateHead = (($export_type ?? '') == 'excel') ? $d : $Mydate->date_eng2thai($d, 543, 'S', 'S');
				echo "<th style='background-color:#369fa7;border: 1px solid black ;'>{$dateHead}</th>";
				echo "<th style='background-color:#369fa7;border: 1px solid black ;'>YoY(%)</th>";
			} ?>
		</tr>
	</thead>
	<tbody>
		<tr style="background-color: #61bec9">
			<td style="font-weight: bolder;background-color: #61bec9">GRAND TOTAL</td>
			<?php $dataSum = getSumData($data, $region, 0, $country, $period);
			$dataSumPast = getSumData($data_past ?? [], $region, 0, $country, array_values($period_past ?? []));
			foreach ($period as $d) {
				echo "<td align='right' style='background-color: #61bec9'>" . (@$dataSum[$d]) . "</td>";
					echo "<td align='right' style='background-color: #61bec9'>" . yoyDailyNum((int)@$dataSum[$d], (int)@$dataSumPast[($period_past[$d] ?? '')]) . "</td>";
			}
			?>

		</tr>
		<?php genTableData($data, $region, 0, $country, $period, 1, $country_group ?? '', $data_past ?? [], $period_past ?? []) ?>
		<?php if ($export_type == 'excel') { ?>
			<tr style="border:0px">
				<td colspan="5">
					ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
				</td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>
<?php

function genTableData($data, $region, $region_id, $country, $period, $level = 1, $country_group = '', $data_past = [], $period_past = [])
{
	$level++;

	if (!empty($region[$region_id])) {
		foreach ($region[$region_id] as $re) {
			$dataSum = getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $period);
			$dataSumPast = getSumData($data_past ?? [], $region, $re['MD_STD_REG_ID'], $country, array_values($period_past ?? []));
			// แสดงประเทศใต้ "OTHERS IN xxx" ให้ตรงกับ country list file (เดิมซ่อนเฉพาะกลุ่ม STD_)
			$hideChildren = ($re['IS_OTHERS'] === 'Y' && $country_group === 'STD_GOV');

			$padding_region = $level * 10;
			$alink = '';
			if (!$hideChildren && !empty($country[$re['MD_STD_REG_ID']])) {
				// $alink = '<a onclick="ShowHide('.$re['MD_STD_REG_ID'].')"> <i class="fa-solid fa-caret-down"></i> </a>';
			}

			echo '<tr style="background-color: #61bec9" id="TR-' . $re['MD_STD_REG_ID'] . '" >';
			echo '<td style="padding-left: ' . $padding_region . 'px; font-weight: bolder;background-color: #61bec9"> ' . $alink . ' ' . $re['MD_STD_REG_NAMEEN'] . '</td>';
			foreach ($period as $d) {
				echo "<td align='right' style='background-color: #61bec9'>" . (@$dataSum[$d]) . "</td>";
					echo "<td align='right' style='background-color: #61bec9'>" . yoyDailyNum((int)@$dataSum[$d], (int)@$dataSumPast[($period_past[$d] ?? '')]) . "</td>";
			}
			echo '</tr>';


			if (!$hideChildren && !empty($country[$re['MD_STD_REG_ID']])) {
				foreach ($country[$re['MD_STD_REG_ID']] as $co) {


					$padding_country = $level * 15;
					echo '<tr class="TR-Parent-' . $re['MD_STD_REG_ID'] . '">';
					echo '<td style="padding-left:' . $padding_country . 'px;">' . $co['COUNTRY_NAME_EN'] . '</td>';
					foreach ($period as $d) {
						$curC = (int)@$data[$co['COUNTRYID']][$d];
						$pastC = (int)@$data_past[$co['COUNTRYID']][($period_past[$d] ?? '')];
						echo "<td align='right'>" . $curC . "</td>";
						echo "<td align='right'>" . yoyDailyNum($curC, $pastC) . "</td>";
					}
					echo '</tr>';
				}
			}

			if (!$hideChildren) {
				genTableData($data, $region, $re['MD_STD_REG_ID'], $country, $period, $level, $country_group, $data_past, $period_past);
			}
		}
	}

	++$level;
}

// YoY(%) เทียบวันเดียวกันปีก่อน — คืนค่าตัวเลข (Excel เก็บเป็น number), '-' ถ้าไม่มีฐาน (spec หน้า 5)
function yoyDailyNum($cur, $past)
{
	if ($past <= 0) return '-';
	return number_format(($cur - $past) / $past * 100, 1) . '%';
}

function getSumData($data, $region, $region_id, $country, $period, &$sum = array())
{
	if (!empty($country[$region_id])) {
		foreach ($country[$region_id] as $co) {
			foreach ($period as $d) {
				@$sum[$d] += @$data[$co['COUNTRYID']][$d];
			}
		}
	}

	if (!empty($region[$region_id])) {
		foreach ($region[$region_id] as $re) {
			getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $period, $sum);
		}
	}


	return $sum;
}

?>