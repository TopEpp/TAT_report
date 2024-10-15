<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
<style>
	.radiusTableport_daily thead th {

		background: rgba(55, 159, 166, 1);
		padding: 12px;
	}

	.table thead th {
		border-bottom: none;
	}

	.radiusTableport_daily {
		border-radius: 1em;
		overflow: hidden;

	}

	.radiusTableport_daily tbody tr:nth-of-type(odd) {
		background: rgba(214, 239, 242, 1);
	}

	.table-bordered th,
	.table-bordered td {
		border-left: none
	}

	.radiusTableport_daily tfoot td {

		background: rgba(55, 159, 166, 1);
	}
</style>

<div class="row">
	<div class="col-md-3 col-12" style="text-align: right;"></div>
	<div class="col-md-4 text-right " style="font-size: 1.2em;">
		สถิติคนไทยเดินทางออกนอกประเทศ รายวัน
	</div>
	<div class="col-md-1 text-right " style="font-size: 1.2em;">
		ปี
	</div>
	<div class="col-md-1 text-center">
		<select class="form-control" id="select_year" onchange="ChangeFilter()">
			<?php foreach($select_year as $y){ $sel=''; if($y==$year){ $sel='selected="selected"';} ?>
			<option value="<?php echo $y?>" <?php echo $sel;?> ><?php echo $y?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-3 col-12" style="text-align: right;">
		<a target="_blank" onclick="export_report('excel')" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" onclick="export_report('pdf')" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	
</div>
<div class="row">
	<div class="col-md-12" style="text-align:center;">
	<?php 
	// echo count($port_type).' | '.count($select_port[1]).' | '.count($select_port[2]);
	if(count($port_type)==count($select_port[1])+count($select_port[2])){
		echo 'ด่านทั้งหมด';
	}else{
		if(!empty($port_type)){ echo 'ด่าน : ';}

		$port_label1 = $port_label2 = '';
		$count_port1=$count_sel_port1=$count_port2=$count_sel_port2=0;
		foreach ($select_port[1] as $p_id=>$port) { 
			$count_port1++;
			if (in_array($p_id, $port_type)) { $count_sel_port1++; $port_label1 .= $port.', ';}
		}
		foreach ($select_port[2] as $p_id=>$port) { 
			$count_port2++;
			if (in_array($p_id, $port_type)) { $count_sel_port2++; $port_label2 .= $port.', ';}
		}

		if($count_port2==$count_sel_port2){
			$port_label2 =  'ด่านอากาศทั้งหมด , ';
		}

		if($count_port1==$count_sel_port1){
			$port_label1 = 'ไม่ใช่ด่านอากาศทั้งหมด';
		}

		$label = $port_label2.$port_label1;
		echo substr($label, 0,-2);

		
	}
	
	?>
	</div>
</div>

<div class="row">
	<div class="col-md-8 py-2 py-md-0">
		<label>
			<input type="checkbox" name="port_all" id="port_all">
			<b> ด่านทั้งหมด</b>
		</label>
	</div>
	<div class="col-md-4  py-2 py-md-0" style="text-align:right;">
		<div class="btn btn-primary" onclick="showHidePort()">แสดง/ซ่อนด่าน</div>
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-12  py-2 py-md-0">
		<div class="row">
			<div class="col-md-12">
				<label><input type="checkbox" name="port_type_2" id="port_type_2" class="port_checkbox"> <b> ด่านอากาศ</b></label>
			</div>
			<?php foreach ($select_port[2] as $p_id=>$port) { ?>
				<div class="col-md-6 col-12 div_port_checkbox">
					<label style="font-weight:normal;"><input type="checkbox" name="port_type[]" id="port_type" class="port_2 port_checkbox" value="<?php echo $p_id ?>" <?php if (in_array($p_id, $port_type)) {
																																														echo "checked='checked'";
																																													} ?>> <?php echo $port ?></label>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="col-md-6 col-12 py-2 py-md-0 border-right  border-secondary">
		<div class="row">
			<div class="col-md-12">
				<label>
					<input type="checkbox" name="port_type_1" id="port_type_1" class="port_checkbox">
					<b> ไม่ใช่ด่านอากาศ</b>
				</label>
			</div>
			<?php foreach ($select_port[1] as $p_id=>$port) { ?>
				<div class="col-md-6 col-12 div_port_checkbox">
					<label style="font-weight:normal;"><input type="checkbox" name="port_type[]" id="port_type" class="port_1 port_checkbox" value="<?php echo $p_id ?>" <?php if (in_array($p_id, $port_type)) {
																																														echo "checked='checked'";
																																													} ?>> <?php echo $port ?></label>
				</div>
			<?php } ?>
		</div>
	</div>
	
	
</div>

<div class="row">
	<div class="col-md-12 col-12">
		<div class="table-responsive">
			<table class="table table-bordered radiusTableport_daily">
				<thead>
					<tr>
						<th>วันที่</th>
						<?php foreach ($month_label as $key => $value) { 
							echo '<th>'.$value.'</th>';
						} ?>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php for($i=1;$i<=31;$i++){ ?>
					<tr>
						<td style="background-color:#FFF; text-align: center;"><?php echo $i;?></td>
					<?php $first = true; 
					    foreach ($month_label as $month => $value) { 
						$dataKey = sprintf("%02s", $i).'-'.sprintf("%02s", $month).'-'.$year; 
						$bg = '#FFF';
						if(isWeekend($dataKey)){ $bg = '#d6eff2'; }
						if(@$max[$month]<=@$data[$dataKey]){
							@$max[$month] = $data[$dataKey];
						}

						if(empty($min[$month])){
							$min[$month] = @$data[$dataKey];
						}

						if(isset($data[$dataKey])){
							if (@$data[$dataKey] < @$min[$month]) {
			                    $min[$month] = @$data[$dataKey];
			                   
			                }
			                $count_day[$month] = $i;
						}

			            @$sum[$month] += $data[$dataKey];
			            @$sum_day[$i] += $data[$dataKey];
			            @$sumTotal += $data[$dataKey];
					?>
							<td style="background-color:<?php echo $bg;?>; text-align: right;"><?php if(!empty($data[$dataKey])){ echo number_format($data[$dataKey]); } ?></td>
					<?php }?>
						<td style="text-align:right; background: rgba(55, 159, 166, 1) !important;"><?php echo number_format($sum_day[$i]);?></td>
					</tr>
					<?php }?>
				</tbody>
				<tfoot>
					<tr>
						<td style="text-align:center;">รวม</td>
						<?php foreach ($month_label as $month => $value) { ?>
							<td style="text-align:right;"><?php if(isset($count_day[$month])){ echo number_format(@$sum[$month]);}else{ echo '-';}?></td>
						<?php } ?>
						<td style="text-align:right;"><?php echo number_format($sumTotal);?></td>
					</tr>
					<tr>
						<td style="text-align:center;">Average</td>
						<?php foreach ($month_label as $month => $value) { 
							$d=cal_days_in_month(CAL_GREGORIAN,$month,$year); ?>
							<td style="text-align:right;"><?php if(isset($count_day[$month])){ echo number_format(@$sum[$month]/$count_day[$month]);}else{ echo '-';}?></td>
						<?php } ?>
						<td></td>
					</tr>
					<tr>
						<td style="text-align:center;">Max</td>
						<?php foreach ($month_label as $month => $value) { ?>
							<td style="text-align:right;"><?php if(isset($count_day[$month])){ echo number_format(@$max[$month]);}else{ echo '-';}?></td>
						<?php } ?>
						<td></td>
					</tr>
					<tr>
						<td style="text-align:center;">Min</td>
						<?php foreach ($month_label as $month => $value) { ?>
							<td style="text-align:right;"><?php if(isset($count_day[$month])){ echo number_format(@$min[$month]);}else{ echo '-';}?></td>
						<?php } ?>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php
function isWeekend($date) {
	list($day, $month, $year) = explode('-', $date);
	if(checkdate($month,$day,$year)){ 
		$weekDay = date('w', strtotime($date));
		return ($weekDay == 0 || $weekDay == 6);
	}else{
		return false;
	}
	
}
?>
<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.div_port_checkbox').hide();

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
		var year = $('#select_year').val();
		var port_type = $("input[name='port_type[]']").map(function() {
			if ($(this).prop('checked') == true) {
				return $(this).val();
			}
		}).get();

		window.location.href = base_url + '/report/departure?year=' + year+'&port_type='+port_type ;
	}

	function export_report(type) {
		var year = $('#select_year').val();
		var port_type = $("input[name='port_type[]']").map(function() {
			if ($(this).prop('checked') == true) {
				return $(this).val();
			}
		}).get();

		window.open(base_url + '/report/departure/?export_type=' + type + '&year=' + year+'&port_type='+port_type );
	}

	function showHidePort(){
		$('.div_port_checkbox').toggle();
	}
</script>
<?= $this->endSection() ?>