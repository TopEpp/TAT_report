<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
<style>
	.radiusTable1 {
		border-radius: 1em;
		overflow: hidden;
	}

	.radiusTable1 tbody tr:nth-of-type(odd) {
		background: #D6EFF2;
	}

	.radiusTable1 thead th {
		background: #379FA6;
		border-bottom: #e4e6f0;
	}

	.table-bordered thead th,
	.table-bordered thead td {
		/* border-bottom-width: */
	}
</style>
<div class="row">
	<div class="col-md-6 col-12 text-center text-md-left">
		
	</div>
	<div class="col-md-6 col-12 py-2 py-md-0" style="text-align: right;">
		<a target="_blank" onclick="export_excel()" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<!-- <a target="_blank" onclick="export_report('excel')" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a> -->
		<!-- <a target="_blank" onclick="export_report('pdf')" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a> -->
	</div>
	<div class="col-md-12 text-center py-2"  style="font-size: 1.4em;">
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายด่าน (สะสม)
	</div>
</div>
<div class="row py-2">
	<div class="col-md-2 col-12 text-start py-2 py-md-0">
		ปี
		<select class="form-control" id="year" name="year"  >
		<?php foreach($select_year as $y){ $sel=''; if($y==$year){ $sel='selected="selected"';} ?>
			<option value="<?php echo $y?>" <?php echo $sel;?> ><?php echo $y?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-2 col-12 text-start py-2 py-md-0">
		เดือนเริ่มต้น
		<select class="form-control" id="m_start" name="m_start">
		<?php foreach($month_label as $key=>$label){ $sel = ''; if($m_start==$key){ $sel='selected="selected"';}?>
			<?php $dis = ''; //if($key>$end_month){ $dis='disabled'; }?>
			<option <?php echo $dis;?> <?php echo $sel;?> value="<?php echo $key;?>"><?php echo $label;?></option>
		<?php } ?>
		</select>
	</div>
	<div class="col-md-2 col-12 text-start py-2 py-md-0">
		เดือนสิ้นสุด
		<select class="form-control" id="m_end" name="m_end">
		<?php foreach($month_label as $key=>$label){ $sel = ''; if($m_end==$key){ $sel='selected="selected"';}?>
			<?php $dis = ''; //if($key>$end_month){ $dis='disabled'; }?>
			<option <?php echo $dis;?> <?php echo $sel;?> value="<?php echo $key;?>"><?php echo $label;?></option>
		<?php } ?>
		</select>
	</div>
	<div class="col-md-2 col-12 text-start py-2 py-md-0">
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
	<div class="col-md-3 col-12 text-start py-2 py-md-0">
		Country Select
		<select class="form-control" id="country_id">
			<option value="">Select</option>
		<?php foreach ($country_select as $key => $value) { ?>
			<option <?php if($country_id==$key){ echo 'selected="selected"';}?> value="<?php echo $key?>"  ><?php echo $value?></option>
		<?php }?>
		</select>
	</div>
	<div class="col-md-1 py-2 py-md-0 text-center mt-auto">
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>

</div>
<div class="row">
	<div class="col-md-12 col-12 py-2 py-md-0">
		<label>
			<input type="checkbox" name="port_all" id="port_all">
			<b> ด่านทั้งหมด</b>
		</label>
	</div>
	<div class="col-md-6 col-12 py-2 py-md-0 border-right  border-secondary">
		<div class="row">
			<div class="col-md-12">
				<label>
					<input type="checkbox" name="port_type_1" id="port_type_1" class="port_checkbox">
					<b> ไม่ใช่ด่านอากาศ</b>
				</label>
			</div>
			<?php foreach ($port[1] as $p) { ?>
				<div class="col-md-6 col-12">
					<label style="font-weight:normal;"><input type="checkbox" name="port_type[]" id="port_type" class="port_1 port_checkbox" value="<?php echo $p['PORT_ID'] ?>" <?php if (in_array($p['PORT_ID'], $port_type)) {
																																														echo "checked='checked'";
																																													} ?>> <?php echo $p['PORT_NAME'] ?></label>
				</div>
			<?php } ?>

		</div>
	</div>
	<div class="col-md-6 col-12  py-2 py-md-0">
		<div class="row">
			<div class="col-md-12">
				<label><input type="checkbox" name="port_type_2" id="port_type_2" class="port_checkbox"> <b> ด่านอากาศ</b></label>
			</div>

			<?php foreach ($port[2] as $p) { ?>
				<div class="col-md-6 col-12">
					<label style="font-weight:normal;"><input type="checkbox" name="port_type[]" id="port_type" class="port_2 port_checkbox" value="<?php echo $p['PORT_ID'] ?>" <?php if (in_array($p['PORT_ID'], $port_type)) {
																																														echo "checked='checked'";
																																													} ?>> <?php echo $p['PORT_NAME'] ?></label>
				</div>
			<?php } ?>

		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 col-12">
		<div class="table-responsive">
			<?php if (!empty($country_row) && !empty($port_colunm)) { ?>
				<table class="table table-striped table-bordered radiusTable1 " id="table_port_compare">
					<thead>
						<tr>
							<th rowspan="2">Nation</th>
							<?php if (!empty($port_colunm)) {
								foreach ($port_colunm as $p) { ?>
									<th colspan="<?php echo count($period)+1 ?>"><?php echo $p['PORT_NAME'] ?></th>
							<?php }
							} ?>
						</tr>
						<tr>
							<?php if (!empty($port_colunm)) {
								foreach ($port_colunm as $p) { ?>
									<?php foreach ($period as $month_label) {
										echo "<th>{$month_label}</th>";
									} ?>
									<th>รวม</th>
							<?php }
							} ?>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						if($country_id){ 
							$country_name = $country_select[$country_id];
							getTableCountry($data, $country_name, $country_id, $port_colunm, $period); 
						}else{ ?>
						<tr style="background-color:#B6E2E9">
							<td style="font-weight: bolder;">GRAND TOTAL</td>
							<?php
							if (!empty($port_colunm)) {
								foreach ($port_colunm as $p) {
									$sum_port = 0;
									foreach ($period as $d=>$month_label) {
										$sum = getSumData($data, $region, 0, $country, $p['PORT_ID'], $d);
										$sum_port += $sum;
										echo '<td align="right">' . number_format($sum) . '</td>';
									}
									echo '<td align="right">' . number_format($sum_port) . '</td>';
								}
								
							}
							?>
							
						</tr>
						<?php 
							genTableData($data, $region, 0, $country, $port_colunm, $period);
						} ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>
</div>
<?php

function getTableCountry($data, $country_name, $country_id,$port_colunm,$period){

	echo '<tr class="TR-Parent">';
	echo '<td style="">'.$country_name.'</td>';
	if (!empty($port_colunm)) {
		foreach ($port_colunm as $p) {
			$sum_port = 0;
			foreach ($period as $d=>$month_label) {
				echo "<td align='right'>" . @number_format(@$data[$country_id][$p['PORT_ID']][$d]['NUM']) . "</td>";
				$sum_port += @$data[$country_id][$p['PORT_ID']][$d]['NUM'];
			}
			echo "<td align='right'>".number_format($sum_port)."</td>";
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
			if (!empty($country[$re['MD_STD_REG_ID']])  && $re['IS_OTHERS'] != 'Y') {
				$alink = '<a onclick="ShowHide(' . $re['MD_STD_REG_ID'] . ')"> <i class="fa-solid fa-caret-down"></i> </a>';
			}

			echo '<tr style="background: #ADE0E5;" id="TR-' . $re['MD_STD_REG_ID'] . '" >';
			echo '<td style="padding-left:' . $padding_region . 'px; font-weight: bolder;"> ' . $alink . ' ' . $re['MD_STD_REG_NAMEEN'] . '</td>';
			if (!empty($port_colunm)) {
				foreach ($port_colunm as $p) {
					$sum_port = 0;
					foreach ($period as $d=>$month_label) {
						$sum = getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $p['PORT_ID'], $d);
						$sum_port += $sum;
						echo '<td align="right">' . number_format($sum) . '</td>';
					}
					echo "<td align='right'>".number_format($sum_port)."</td>";
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
							$sum_port = 0;
							foreach ($period as $d=>$month_label) {
								echo "<td align='right'>" . @number_format(@$data[$co['COUNTRYID']][$p['PORT_ID']][$d]['NUM']) . "</td>";
								$sum_port +=@$data[$co['COUNTRYID']][$p['PORT_ID']][$d]['NUM'];
							}
							echo "<td align='right'>".number_format($sum_port)."</td>";
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

<?php $this->endSection() ?>

<?= $this->section("scripts") ?>


<script type="text/javascript" src="<?php echo base_url('public/js/xlsx.full.min.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.date_picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: 'th-th',
			endDate: new Date('<?php echo $to_date; ?>')
		});

		$('#port_all').click(function() {
			if ($(this).prop('checked') == true) {
				$('.port_checkbox').prop('checked', true);
			} else {
				$('.port_checkbox').prop('checked', false);
			}
		});

		$('#port_type_1').click(function() {
			if ($(this).prop('checked') == true) {
				$('.port_1').prop('checked', true);
			} else {
				$('.port_1').prop('checked', false);
			}
		});

		$('#port_type_2').click(function() {
			if ($(this).prop('checked') == true) {
				$('.port_2').prop('checked', true);
			} else {
				$('.port_2').prop('checked', false);
			}
		});
	});

	function ChangeFilter() {
		var m_start = $('#m_start').val();
		var m_end = $('#m_end').val();
		var year = $('#year').val();

		var country_type = $('#country_type').val();
		var country_id = $('#country_id').val();
		var port_type = $("input[name='port_type[]']").map(function() {
			if ($(this).prop('checked') == true) {
				return $(this).val();
			}
		}).get();
		// console.log(port_type);

		window.location.href = base_url + '/report/port_compare_monthly?year='+year+'&m_start=' + m_start + '&m_end=' + m_end + '&country_type=' + country_type + '&port_type=' + port_type+ '&country_id=' + country_id;
	}

	function ShowHide(reg_id) {
		$('.TR-Parent-' + reg_id).toggle();
	}

	function export_report(type) {
		var m_start = $('#m_start').val();
		var m_end = $('#m_end').val();
		var year = $('#year').val();

		var country_type = $('#country_type').val();
		var country_id = $('#country_id').val();
		var port_type = $("input[name='port_type[]']").map(function() {
			if ($(this).prop('checked') == true) {
				return $(this).val();
			}
		}).get();
		window.open(base_url + '/report/port_compare_monthly/?export_type=' + type + '&year='+year+'&m_start=' + m_start + '&m_end=' + m_end + '&country_type=' + country_type + '&port_type=' + port_type+ '&country_id=' + country_id);
	}

	function export_excel(){
		var elt = document.getElementById('table_port_compare');
		var wb = XLSX.utils.table_to_book(elt, { sheet: "1" }); 

		XLSX.writeFile(wb, "port_compare_monthly.xlsx")
	}
</script>
<script>
document.getElementById('year').addEventListener('change', function() {
    const selectedYear = parseInt(this.value);
    const currentYear = new Date().getFullYear();

    // ถ้าปีที่เลือกเก่ากว่าปีปัจจุบัน
    if (selectedYear < currentYear) {
        enableAllOptions('m_start');
        enableAllOptions('m_end');
    } else {
        disableOptionsBasedOnEndMonth('m_start');
        disableOptionsBasedOnEndMonth('m_end');
    }
});

// ฟังก์ชันเปิดใช้งานทุกตัวเลือกใน select
function enableAllOptions(selectId) {
    const selectElement = document.getElementById(selectId);
    for (let i = 0; i < selectElement.options.length; i++) {
        selectElement.options[i].disabled = false;
    }
}

// ฟังก์ชันปิดการใช้งานตัวเลือกที่มากกว่า end_month
function disableOptionsBasedOnEndMonth(selectId) {
    const selectElement = document.getElementById(selectId);
    const endMonth = parseInt(<?php echo $end_month; ?>); // จาก PHP
    for (let i = 0; i < selectElement.options.length; i++) {
        const optionValue = parseInt(selectElement.options[i].value);
        if (optionValue > endMonth) {
            selectElement.options[i].disabled = true;
        }
    }
}
</script>

<?= $this->endSection() ?>