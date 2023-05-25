<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
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
		overflow-x: visible
	}
</style>
<div class="row">
	<div class="col-md-6 text-center text-md-left" style="font-size: 1.4em;">
		<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
	</div>
	<div class="col-md-6 col-12 py-2 py-md-0" style="text-align: right;">
		<a target="_blank" onclick="export_report('excel')" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" onclick="export_report('pdf')" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	<div class="col-md-12 text-center py-2">
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายวัน จำแนกรายสัญชาติ
	</div>
	<!-- <div class="col-md-12" >
		วันที่เริ่มต้น <input type="text" name="report_data1" id="report_data1" class="form-control date_picker" style="width: 200px;display: inline;" value="<?php echo $Mydate->date_thai2eng($date_start, 543, '/') ?>"> 
		วันที่สิ้นสุด <input type="text" name="report_data2" id="report_data2" class="form-control date_picker" style="width: 200px;display: inline;" value="<?php echo $Mydate->date_thai2eng($date_end, 543, '/') ?>">
		<div class="btn btn-primary" onclick="ChangeDate()">ตกลง</div>
	</div> -->
</div>

<div class="d-flex justify-content-center py-2 pb-3 flex-column flex-md-row">
	<div class="d-flex align-items-center mx-md-2 mx-auto">
		วันที่เริ่มต้น <input type="text" name="report_data1" id="report_data1" class="form-control date_picker ml-2" style="width: 200px;display: inline;" value="<?php echo $Mydate->date_thai2eng($date_start, 543, '/') ?>">
	</div>
	<div class="d-flex align-items-center mx-md-2 mx-auto my-2 my-md-none">
		วันที่สิ้นสุด <input type="text" name="report_data2" id="report_data2" class="form-control date_picker ml-2" style="width: 200px;display: inline;" value="<?php echo $Mydate->date_thai2eng($date_end, 543, '/') ?>">
	</div>
	<div class="align-items-center mx-md-2 mx-auto my-auto ">
		<div class="btn btn-primary" onclick="ChangeDate()">ตกลง</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12 col-12">
		<div class="table-responsive">
			<table class="table table-striped table-tableborder radiusTableNation shadow-lg">
				<thead>
					<tr>
						<th>Nation</th>
						<?php foreach ($period as $d) {
							echo "<th>{$Mydate->date_eng2thai($d, 543, 'S', 'S')}</th>";
						} ?>
					</tr>
				</thead>
				<tbody>
					<tr style="background: rgba(97, 190, 201, 1);">
						<td style="font-weight: bolder;">GRAND TOTAL</td>
						<?php $dataSum = getSumData($data, $region, 0, $country, $period);
						foreach ($period as $d) {
							echo "<td align='right'>" . number_format(@$dataSum[$d]) . "</td>";
						}
						?>

					</tr>
					<?php genTableData($data, $region, 0, $country, $period) ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php

function genTableData($data, $region, $region_id, $country, $period, $level = 1)
{
	$level++;

	if (!empty($region[$region_id])) {
		foreach ($region[$region_id] as $re) {
			$dataSum = getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $period);

			$padding_region = $level * 10;
			$alink = '';
			if (!empty($country[$re['MD_STD_REG_ID']]) && $re['IS_OTHERS'] != 'Y') {
				$alink = '<a onclick="ShowHide(' . $re['MD_STD_REG_ID'] . ')"> <i class="fa-solid fa-caret-down"></i> </a>';
			}

			echo '<tr style="background: rgba(97, 190, 201, 1);" id="TR-' . $re['MD_STD_REG_ID'] . '" >';
			echo '<td style="padding-left: ' . $padding_region . 'px; font-weight: bolder;"> ' . $alink . ' ' . $re['MD_STD_REG_NAMEEN'] . '</td>';
			foreach ($period as $d) {
				echo "<td align='right'>" . number_format(@$dataSum[$d]) . "</td>";
			}
			echo '</tr>';


			if (!empty($country[$re['MD_STD_REG_ID']]) && $re['IS_OTHERS'] != 'Y') {
				foreach ($country[$re['MD_STD_REG_ID']] as $co) {


					$padding_country = $level * 15;
					echo '<tr class="TR-Parent-' . $re['MD_STD_REG_ID'] . '">';
					echo '<td style="padding-left:' . $padding_country . 'px;">' . $co['COUNTRY_NAME_EN'] . '</td>';
					foreach ($period as $d) {
						echo "<td align='right'>" . number_format(@$data[$co['COUNTRYID']][$d]) . "</td>";
					}
					echo '</tr>';
				}
			}

			genTableData($data, $region, $re['MD_STD_REG_ID'], $country, $period, $level);
		}
	}

	++$level;
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
<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.date_picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: 'en-en',
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

	function ShowHide(reg_id) {
		$('.TR-Parent-' + reg_id).toggle();
	}
</script>
<?= $this->endSection() ?>