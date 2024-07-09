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
	<div class="col-md-5 text-center text-md-left" style="font-size: 1.4em;">
		สถิติคนไทยเดินทางออกรายวัน
	</div>
	<div class="col-md-1 text-center text-md-right" style="font-size: 1.4em;">
		ปี
	</div>
	<div class="col-md-2 text-center">
		<select class="form-control" id="select_year" onchange="ChangeDate()">
			<?php foreach($select_year as $y){ $sel=''; if($y==$year){ $sel='selected="selected"';} ?>
			<option value="<?php echo $y?>" <?php echo $sel;?> ><?php echo $y?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-4 col-12 py-2" style="text-align: right;">
		<a target="_blank" onclick="export_report('excel')" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" onclick="export_report('pdf')" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	<div class="col-md-12 text-center py-2" >
		
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
	
	function ChangeDate() {
		var year = $('#select_year').val();
		window.location.href = base_url + '/report/departure?year=' + year ;
	}

	function export_report(type) {
		var year = $('#select_year').val();
		window.open(base_url + '/report/departure/?export_type=' + type + '&year=' + year );
	}
</script>
<?= $this->endSection() ?>