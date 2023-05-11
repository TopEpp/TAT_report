<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>

<div class="row">
	<div class="col-md-12" style="font-size: 1.4em;">
		<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>
	</div>
	<div class="col-md-12">
		รายงานเปรียบเทียบจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายสัญชาติ
	</div>
</div>
<div class="row">
	<div class="col-md-4 col-4">
		ช่วงเวลาที่ 1 วันที่เริ่มต้น <input type="text" name="start_date1" id="start_date1" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($start_date1, 543, '/') ?>">
	</div>
	<div class="col-md-3 col-3">
		วันที่สิ้นสุด <input type="text" name="end_date1" id="end_date1" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($end_date1, 543, '/') ?>">
	</div>
	<div class="col-md-2 col-2">

	</div>
	<div class="col-md-2 col-2">
		<select class="form-control" id="show_type">
			<option value="region" <?php if (@$show_type == 'region') {
										echo "selected='selected'";
									} ?>>Region</option>
			<option value="country" <?php if (@$show_type == 'country') {
										echo "selected='selected'";
									} ?>>Country</option>
		</select>
	</div>
	<div class="col-md-1 col-1">

	</div>
</div>
<div class="row">
	<div class="col-md-4 col-4">
		ช่วงเวลาที่ 2 วันที่เริ่มต้น <input type="text" name="start_date2" id="start_date2" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($start_date2, 543, '/') ?>">
	</div>
	<div class="col-md-3 col-3">
		วันที่สิ้นสุด <input type="text" name="end_date2" id="end_date2" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($end_date2, 543, '/') ?>">
	</div>
	<div class="col-md-2 col-2" style="text-align:right; padding-top: 5px;">
		Country List
	</div>
	<div class="col-md-2 col-2">
		<select class="form-control" id="country_type">
			<option value="standard" <?php if (@$country_type == 'standard') {
											echo "selected='selected'";
										} ?>>Standard</option>
			<option value="all" <?php if (@$country_type == 'all') {
									echo "selected='selected'";
								} ?>>All Country</option>
		</select>
	</div>
	<div class="col-md-1 col-1">
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>
</div>

<div class="row">
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
			<table class="table table-striped table-bordered">
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
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php foreach ($region[0] as $re) { ?>
						<tr style="background-color:#B6E2E9">
							<td style="padding-left: 5px; font-weight: bolder;"> <?php echo $re['MD_STD_REG_NAMEEN'] ?></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php if (!empty($country[$re['MD_STD_REG_ID']])) {
							foreach ($country[$re['MD_STD_REG_ID']] as $co) {
								$compare = '';
								$num1 = @$data1[$co['COUNTRYID']]['NUM'];
								$num2 = @$data2[$co['COUNTRYID']]['NUM'];
								if ($num2 > 0) {
									$diff = $num2 - $num1;
									if ($sum1 > 0) {
										$compare = number_format($diff / $sum1 * 100, 2) . ' %';
									}

									if ($diff < 0) {
										$compare = "<span style='color:red'>{$compare} </span>";
									}
								}
						?>
								<tr>
									<td style="padding-left: 10px;"><?php echo $co['COUNTRY_NAME_EN'] ?></td>
									<td align="right"><?php echo number_format(@$num1) ?></td>
									<td align="right"><?php echo number_format(@$num2) ?></td>
									<td align="center"><?php echo $compare ?></td>
								</tr>
						<?php }
						} ?>
						<?php if (!empty($region[$re['MD_STD_REG_ID']])) {
							foreach ($region[$re['MD_STD_REG_ID']] as $re) { ?>

								<?php $sum1 = $sum2 = $sum_diff = 0;
								$sum_compare = '';
								if (!empty($country[$re['MD_STD_REG_ID']])) {
									foreach ($country[$re['MD_STD_REG_ID']] as $co) {
										$num1 = @$data1[$co['COUNTRYID']]['NUM'];
										$num2 = @$data2[$co['COUNTRYID']]['NUM'];

										$sum1 += $num1;
										$sum2 += $num2;
									}
								}
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
								<tr style="background-color:#B6E2E9">
									<td style="padding-left: 20px; font-weight: bolder;"> <?php echo $re['MD_STD_REG_NAMEEN'] ?></td>
									<td align="right"><?php echo number_format($sum1) ?></td>
									<td align="right"><?php echo number_format($sum2) ?></td>
									<td align="center"><?php echo $sum_compare ?></td>
								</tr>
								<?php if (!empty($country[$re['MD_STD_REG_ID']])) {
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
								?>
										<tr>
											<td style="padding-left: 30px;"><?php echo $co['COUNTRY_NAME_EN'] ?></td>
											<td align="right"><?php echo number_format(@$num1) ?></td>
											<td align="right"><?php echo number_format(@$num2) ?></td>
											<td align="center"><?php echo $compare ?></td>
										</tr>
								<?php }
								} ?>
								<?php if (!empty($region[$re['MD_STD_REG_ID']])) {
									foreach ($region[$re['MD_STD_REG_ID']] as $re) { ?>

										<?php $sum1 = $sum2 = $sum_diff = 0;
										$sum_compare = '';
										if (!empty($country[$re['MD_STD_REG_ID']])) {
											foreach ($country[$re['MD_STD_REG_ID']] as $co) {
												$num1 = @$data1[$co['COUNTRYID']]['NUM'];
												$num2 = @$data2[$co['COUNTRYID']]['NUM'];

												$sum1 += $num1;
												$sum2 += $num2;
											}
										}
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
										<tr style="background-color:#B6E2E9">
											<td style="padding-left: 40px; font-weight: bolder;"> <?php echo $re['MD_STD_REG_NAMEEN'] ?></td>
											<td align="right"><?php echo number_format($sum1) ?></td>
											<td align="right"><?php echo number_format($sum2) ?></td>
											<td align="center"><?php echo $sum_compare ?></td>
										</tr>
										<?php if (!empty($country[$re['MD_STD_REG_ID']])) {
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
										?>
												<tr>
													<td style="padding-left: 50px;"><?php echo $co['COUNTRY_NAME_EN'] ?></td>
													<td align="right"><?php echo number_format(@$num1) ?></td>
													<td align="right"><?php echo number_format(@$num2) ?></td>
													<td align="center"><?php echo $compare ?></td>
												</tr>
										<?php }
										} ?>

					<?php }
								}
							}
						}
					} ?>


				</tbody>
			</table>
		</div>
	</div>
</div>
<?php

function genTableData($region, $country)
{
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
</script>
<?= $this->endSection() ?>