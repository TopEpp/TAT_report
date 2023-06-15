<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>

<style>
	@media screen and (max-width: 600px) {
		.table-responsive {
			overflow-x: auto !important;
		}
	}

	.table-responsive {
		overflow-x: inherit;
	}

	.table thead th {
		background: #379FA6;
		border-bottom: 0;
		padding: 16px
	}

	.ColorTableBody {
		border-radius: 1em;
		overflow: hidden;
	}

	.table-responsive {
		overflow-x: initial
	}

	.ColorTableBody thead tr {
		margin: 20px;
	}

	table {
		border-radius: 12px;
		background-color: #F6F6F6;
	}

	table.dataTable thead th,
	table.dataTable thead td {
		border-bottom: 0px
	}

	.table-responsive {
		border-radius: 12px;
	}

	table.dataTable {
		margin-top: 0px !important;
	}
</style>
<div class="row">
	<div class="col-md-6 col-12" style="font-size: 1.4em;">
		
	</div>
	<div class="col-md-6 col-12 py-2 py-md-0" style="text-align: right;">
		<a target="_blank" href="<?php echo base_url('report/nation_compare/?export_type=excel&start1=' . $start_date1 . '&end1=' . $end_date1 . '&start2=' . $start_date2 . '&end2=' . $end_date2 . '&country_type=' . $country_type); ?>" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" href="<?php echo base_url('report/nation_compare/?export_type=pdf&start1=' . $start_date1 . '&end1=' . $end_date1 . '&start2=' . $start_date2 . '&end2=' . $end_date2 . '&country_type=' . $country_type); ?>" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	<div class="col-md-12 text-center py-2" style="font-size: 1.4em;">
		รายงานเปรียบเทียบจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายสัญชาติ
	</div>
</div>
<div class="row py-2 m-0">
	<div class="col-md-4 col-12 text-left py-2 py-md-0">
		ช่วงเวลาที่ 1 วันที่เริ่มต้น <input type="text" name="start_date1" id="start_date1" class="form-control date_picker" style="display: inline;" value="<?php echo $Mydate->date_thai2eng($start_date1, 543, '/') ?>">
	</div>
	<div class="col-md-4 col-12 text-left py-2 py-md-0">
		วันที่สิ้นสุด <input type="text" name="end_date1" id="end_date1" class="form-control date_picker" style="display: inline;" value="<?php echo $Mydate->date_thai2eng($end_date1, 543, '/') ?>">
	</div>
	<div class="col-md-2 col-2">

	</div>

	<div class="col-md-1 col-1">

	</div>
</div>
<div class="row m-0 py-2">
	<div class="col-md-4 col-12 text-left py-2 py-md-0">
		ช่วงเวลาที่ 2 วันที่เริ่มต้น <input type="text" name="start_date2" id="start_date2" class="form-control date_picker" style="display: inline;" value="<?php echo $Mydate->date_thai2eng($start_date2, 543, '/') ?>">
	</div>
	<div class="col-md-4 col-12 text-left py-2 py-md-0">
		วันที่สิ้นสุด <input type="text" name="end_date2" id="end_date2" class="form-control date_picker" style="display: inline;" value="<?php echo $Mydate->date_thai2eng($end_date2, 543, '/') ?>">
	</div>
	<!-- <div class="col-md-2 col-12 text-md-right text-left" style=" padding-top: 5px;">
		
	</div> -->
	<div class="col-md-3 col-12">
		Country List
		<select class="form-control" id="country_type">
			<option value="standard" <?php if (@$country_type == 'standard') {
											echo "selected='selected'";
										} ?>>Standard</option>
			<option value="all" <?php if (@$country_type == 'all') {
									echo "selected='selected'";
								} ?>>All Country</option>
		</select>
	</div>
	<div class="col-md-1 col-12 text-center py-2 py-md-0 mt-auto">
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>
</div>

<div class="row m-0 py-2">
	<div class="col-md-12 col-12">
		<div class="table-responsive">
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
			<div class="table-responsive shadow-lg">
				<table class="table table-striped ColorTableBody shadow-lg">
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
							$sum_compare = '-';
							$dataSum = getSumData($data1, $data2, $region, 0, $country);
							$sum1 = $dataSum['sum1'];
							$sum2 = $dataSum['sum2'];
							if ($sum2 > 0) {
								$sum_diff = $sum2 - $sum1;
								if ($sum1 > 0) {
									$sum_compare = number_format($sum_diff / $sum1 * 100, 2) . '';
								}
								if ($sum_diff < 0) {
									$sum_compare = "<span style='color:red'>{$sum_compare} </span>";
								}
							}

							?>
							<td align="right"><?php echo number_format($sum1); ?></td>
							<td align="right"><?php echo number_format($sum2); ?></td>
							<td align="right"><?php echo $sum_compare; ?></td>
						</tr>
						<?php genTableData($data1, $data2, $region, 0, $country) ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php

function genTableData($data1, $data2, $region, $region_id, $country, $level = 1)
{
	$level++;
	if (!empty($region[$region_id])) {
		foreach ($region[$region_id] as $re) {

			$sum1 = $sum2 = $sum_diff = 0;
			$sum_compare = '-';
			$dataSum = getSumData($data1, $data2, $region, $re['MD_STD_REG_ID'], $country);
			$sum1 = $dataSum['sum1'];
			$sum2 = $dataSum['sum2'];

			if ($sum2 > 0) {
				$sum_diff = $sum2 - $sum1;
				if ($sum1 > 0) {
					$sum_compare = number_format($sum_diff / $sum1 * 100, 2) . '';
				}
				if ($sum_diff < 0) {
					$sum_compare = "<span style='color:red'>{$sum_compare} </span>";
				}
			}

			$padding_region = $level * 10;
			$alink = '';
			if (!empty($country[$re['MD_STD_REG_ID']]) && $re['IS_OTHERS'] != 'Y') {
				$alink = '<a onclick="ShowHide(' . $re['MD_STD_REG_ID'] . ')"> <i class="fa-solid fa-caret-down"></i> </a>';
			}

			echo '<tr style="background-color:#B6E2E9" id="TR-' . $re['MD_STD_REG_ID'] . '" >';
			echo '<td style="padding-left: ' . $padding_region . 'px; font-weight: bolder;"> ' . $alink . ' ' . $re['MD_STD_REG_NAMEEN'] . '</td>';
			echo '<td align="right" >' . number_format($sum1) . '</td>';
			echo '<td align="right">' . number_format($sum2) . '</td>';
			echo '<td  align="right">' . $sum_compare . '</td>';
			echo '</tr>';
			$idx = 0;
			if (!empty($country[$re['MD_STD_REG_ID']]) && $re['IS_OTHERS'] != 'Y') {
				foreach ($country[$re['MD_STD_REG_ID']] as $key => $co) {

					$compare = '-';
					$num1 = @$data1[$co['COUNTRYID']]['NUM'];
					$num2 = @$data2[$co['COUNTRYID']]['NUM'];
					if ($num2 > 0) {
						$diff = $num2 - $num1;
						if ($num1 > 0) {
							$compare = number_format($diff / $num1 * 100, 2) . '';
						}
						if ($diff < 0) {
							$compare = "<span style='color:red'>{$compare} </span>";
						}
					}
					$padding_country = $level * 15;
					// echo '<pre>';
					// print_r($idx % 2); 

					echo '<tr class="TR-Parent-' . $re['MD_STD_REG_ID'] . '">';

					if ($idx % 2 == 0) {
						echo '<td style="background: #D6EFF2; padding-left:' . $padding_country . 'px;">' . $co['COUNTRY_NAME_EN'] . '</td>';
						echo '<td align="right" style="background: #D6EFF2;">' . number_format(@$num1) . '</td>';
						echo '<td align="right" style="background: #D6EFF2;">' . number_format(@$num2) . '</td>';
						echo '<td align="right" style="background: #D6EFF2;">' . $compare . '</td>';
					} else {
						echo '<td style="background:white; padding-left:' . $padding_country . 'px;">' . $co['COUNTRY_NAME_EN'] . '</td>';
						echo '<td align="right" style="background: white;">' . number_format(@$num1) . '</td>';
						echo '<td align="right" style="background: white;">' . number_format(@$num2) . '</td>';
						echo '<td align="right" style="background: white;">' . $compare . '</td>';
					}



					echo '</tr>';
					$idx++;
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
<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.date_picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: 'th-th',
			endDate: new Date('<?php echo $to_date; ?>')
		});
	});

	function ChangeFilter() {
		var date = $('#start_date1').val();
		date = date.split('/');
		// start_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
		start_date1 = date[0] + '-' + date[1] + '-' + (date[2] - 543);

		var date = $('#end_date1').val();
		date = date.split('/');
		// end_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
		end_date1 = date[0] + '-' + date[1] + '-' + (date[2] - 543);

		var date = $('#start_date2').val();
		date = date.split('/');
		// start_date2 = (date[2]-543)+'-'+date[1]+'-'+date[0];
		start_date2 = date[0] + '-' + date[1] + '-' + (date[2] - 543);

		var date = $('#end_date2').val();
		date = date.split('/');
		// end_date2 = (date[2]-543)+'-'+date[1]+'-'+date[0];
		end_date2 = date[0] + '-' + date[1] + '-' + (date[2] - 543);

		var show_type = $('#show_type').val();
		var country_type = $('#country_type').val();

		window.location.href = base_url + '/report/nation_compare?start1=' + start_date1 + '&end1=' + end_date1 + '&start2=' + start_date2 + '&end2=' + end_date2 + '&show_type=' + show_type + '&country_type=' + country_type;
	}

	function ShowHide(reg_id) {
		$('.TR-Parent-' + reg_id).toggle();
	}
</script>
<?= $this->endSection() ?>