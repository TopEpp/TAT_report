<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
<div class="row">
	<div class="col-md-6" style="font-size: 1.4em;">
		<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
	</div>
	<div class="col-md-6 col-6" style="text-align: right;">
		<a target="_blank" onclick="export_report('excel')" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" onclick="export_report('pdf')" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	<div class="col-md-12">
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน จำแนกรายสัญชาติ
	</div>
	<div class="col-md-12">
		วันที่เริ่มต้น <input type="text" name="report_data1" id="report_data1" class="form-control date_picker" style="width: 200px;display: inline;" value="<?php echo $Mydate->date_thai2eng($date_start, 543, '/') ?>">
		วันที่สิ้นสุด <input type="text" name="report_data2" id="report_data2" class="form-control date_picker" style="width: 200px;display: inline;" value="<?php echo $Mydate->date_thai2eng($date_end, 543, '/') ?>">
		<div class="btn btn-primary" onclick="ChangeDate()">ตกลง</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 col-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered ">
				<thead>
					<tr>
						<th>Nation</th>
						<?php foreach ($period as $d) {
							echo "<th>{$Mydate->date_eng2thai($d, 543, 'S', 'S')}</th>";
						} ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($country as $p) { ?>
						<tr>
							<td><?php echo $p['COUNTRY_NAME_EN'] ?></td>
							<?php foreach ($period as $d) {
								echo "<td align='right'>" . number_format(@$data[$p['COUNTRY_ID']][$d]) . "</td>";
								@$sum[$d] += @$data[$p['COUNTRY_ID']][$d];
							} ?>
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td style='background-color: #007C84;'>รวมทั้งหมด</td>
						<?php foreach ($period as $d) {
							echo "<td style='background-color: #007C84;' align='right'>" . number_format(@$sum[$d]) . "</td>";
						} ?>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php

function genTableData($data, $region, $region_id, $country, $level = 1)
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

function getSumData($data, $region, $region_id, $country, &$sum1 = 0, &$sum2 = 0)
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
<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.date_picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: 'th-th',
		});
	});

	function ChangeDate() {
		var date = $('#report_data1').val();
		date = date.split('/');
		report_date1 = (date[2] - 543) + '-' + date[1] + '-' + date[0];

		var date = $('#report_data2').val();
		date = date.split('/');
		report_date2 = (date[2] - 543) + '-' + date[1] + '-' + date[0];

		window.location.href = base_url + '/report/nation_daily?d1=' + report_date1 + '&d2=' + report_date2;
	}

	function export_report(type) {
		var date = $('#report_data1').val();
		date = date.split('/');
		report_date1 = (date[2] - 543) + '-' + date[1] + '-' + date[0];

		var date = $('#report_data2').val();
		date = date.split('/');
		report_date2 = (date[2] - 543) + '-' + date[1] + '-' + date[0];

		window.open(base_url + '/report/nation_daily/?export_type=' + type + '&d1=' + report_date1 + '&d2=' + report_date2);
	}
</script>
<?= $this->endSection() ?>