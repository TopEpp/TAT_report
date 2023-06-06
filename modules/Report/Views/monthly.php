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
		overflow: auto;
	}
</style>
<div class="row">
	<div class="col-md-6 text-center text-md-left" style="font-size: 1.4em;">
		
	</div>
	<div class="col-md-6 col-12 py-2 py-md-0" style="text-align: right;">
		<a target="_blank" onclick="export_report('excel')" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" onclick="export_report('pdf')" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	<div class="col-md-12 text-center py-2" style="font-size: 1.4em;">
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายเดือน
	</div>
</div>


<div class="row py-2">
	<div class="col-md-4 col-12 mx-auto py-2 py-md-0">
		เดือน 
		<select class="form-control" id="m" name="m" >
		<?php foreach($month_label as $m_id=>$name){ $sel = ''; if($month==$m_id){  $sel='selected="selected"';  }?>
			<option value="<?php echo $m_id?>" <?php echo $sel;?> ><?php echo $name?></option>
		<?php } ?>
		</select>
	</div>
	<div class="col-md-3 col-12 py-2 py-md-0">
		ปี 
		<select class="form-control" id="y" name="y"  >
		<?php for($i=date('Y');$i >= date('Y')-5;$i--){ $sel = ''; if($year==$i){  $sel='selected="selected"';  }?>
			<option value="<?php echo $i+543?>" <?php echo $sel;?> ><?php echo $i+543?></option>
		<?php }?>
		</select>
	</div>
	<div class="col-md-4 col-12 text-start py-2 py-md-0">
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
				<div class="col-md-12 col-12" style="padding-left: 30px;">
					<label style="font-weight:normal;"><input type="checkbox" name="port_type[]" id="port_type_<?php echo $p['PORT_ID'];?>" class="port_1 port_checkbox" value="<?php echo $p['PORT_ID']; ?>" <?php if (in_array($p['PORT_ID'], $port_type)) {
																																														echo "checked='checked'";
																																													} ?>> <?php echo $p['PORT_NAME_FULL'] ?></label>
				</div>
				<?php if(!empty($point_select[$p['PORT_ID']])){ 
						foreach($point_select[$p['PORT_ID']] as $po){ ?>
							<div class="col-md-12 col-12" style="padding-left: 60px;">
								<label style="font-weight:normal;"><input type="checkbox" name="point_type[]" id="point_type" class="port_1 point_<?php echo $p['PORT_ID']; ?> point_checkbox port_checkbox" value="<?php echo $po['POINT_ID'] ?>" <?php if (in_array($po['POINT_ID'], $point_type)) {
																																																	echo "checked='checked'";
																																																} ?>> <?php echo $po['POINT_NAME'] ?></label>
							</div>
				<?php	}
					}?>
			<?php } ?>

		</div>
	</div>
	<div class="col-md-6 col-12  py-2 py-md-0">
		<div class="row">
			<div class="col-md-12">
				<label><input type="checkbox" name="port_type_2" id="port_type_2" class="port_checkbox"> <b> ด่านอากาศ</b></label>
			</div>

			<?php foreach ($port[2] as $p) { ?>
				<div class="col-md-12 col-12" style="padding-left: 30px;">
					<label style="font-weight:normal;"><input type="checkbox" name="port_type[]" id="port_type" class="port_2 port_checkbox" value="<?php echo $p['PORT_ID'] ?>" <?php if (in_array($p['PORT_ID'], $port_type)) {
																																														echo "checked='checked'";
																																													} ?>> <?php echo $p['PORT_NAME_FULL'] ?></label>
				</div>
				<?php if(!empty($point_select[$p['PORT_ID']])){ 
						foreach($point_select[$p['PORT_ID']] as $po){ ?>
							<div class="col-md-12 col-12" style="padding-left: 60px;">
								<label style="font-weight:normal;"><input type="checkbox" name="point_type[]" id="point_type" class="port_2 point_<?php echo $p['PORT_ID']; ?> point_checkbox port_checkbox" value="<?php echo $po['POINT_ID'] ?>" <?php if (in_array($po['POINT_ID'], $point_type)) {
																																																	echo "checked='checked'";
																																																} ?>> <?php echo $po['POINT_NAME'] ?></label>
							</div>
				<?php	}
					}?>
			<?php } ?>

		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12 col-12">
		<div class="table-responsive">
			<table class="table table-striped table-tableborder radiusTableNation ">
				<thead>
					<tr>
						<th rowspan="2" >ประเทศ</th>
						<?php foreach($port_colunm as $p){ 
							$colspan= 1;
							if(!empty($point[$p['PORT_ID']])){ $colspan = count($point[$p['PORT_ID']]); } 
								 echo '<th colspan="'.$colspan.'">'.$p['PORT_NAME_FULL'].'</th>'; 
							} ?>
					</tr>
					<tr>
						<?php foreach($port_colunm as $p){
							if(!empty($point[$p['PORT_ID']])){ 
								foreach($point[$p['PORT_ID']] as $po){
									echo '<th>'.@$po['POINT_NAME'].'</th>';
								} 
							}else{
								echo '<th></th>';
							}
						 }?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="font-weight: bolder;">GRAND TOTAL</td>
						<?php foreach($port_colunm as $p){
							if(!empty($point[$p['PORT_ID']])){ 
								foreach($point[$p['PORT_ID']] as $po){
									// echo '<td>'.@$d['NUM'][$p['PORT_ID']][$po['POINT_ID']].'</td>';
									$sum = getSumData($data, $region, 0, $country, $p['PORT_ID'], $po['POINT_ID']);
									echo '<td align="right">' . number_format($sum) . '</td>';
								} 
							}else{
								// echo '<td>'.@$d['NUM'][$p['PORT_ID']][0].'</td>';
								$sum = getSumData($data, $region, 0, $country, $p['PORT_ID'], 0);
								echo '<td align="right">' . number_format($sum) . '</td>';
							}
						 }?>

					</tr>
					<?php genTableData($data, $region, 0, $country, $port_colunm, $point); ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?>

<?php 
function genTableData($data, $region, $region_id, $country, $port_colunm, $point, $level = 1)
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
					if(!empty($point[$p['PORT_ID']])){ 
						foreach($point[$p['PORT_ID']] as $po){
							$sum = getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $p['PORT_ID'], $po['POINT_ID']);
							echo '<td align="right">' . number_format($sum) . '</td>';
						} 
					}else{
						$sum = getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $p['PORT_ID'], 0);
							echo '<td align="right">' . number_format($sum) . '</td>';
					}
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
							if(!empty($point[$p['PORT_ID']])){ 
								foreach($point[$p['PORT_ID']] as $po){
									echo "<td align='right'>" . @number_format(@$data[$co['COUNTRYID']]['NUM'][$p['PORT_ID']][$po['POINT_ID']]) . "</td>";
								} 
							}else{
								echo "<td align='right'>" . @number_format(@$data[$co['COUNTRYID']]['NUM'][$p['PORT_ID']][0]) . "</td>";
							}
						}
					}
					echo '</tr>';
				}
			}

			genTableData($data, $region, $re['MD_STD_REG_ID'], $country, $port_colunm, $point, $level);
		}
	}

	++$level;
}

function getSumData($data, $region, $region_id, $country, $port_id, $point_id, &$sum = 0)
{
	if (!empty($country[$region_id])) {
		foreach ($country[$region_id] as $co) {
			$sum += @$data[$co['COUNTRYID']]['NUM'][$port_id][$point_id];
		}
	}



	if (!empty($region[$region_id])) {
		foreach ($region[$region_id] as $re) {
			getSumData($data, $region, $re['MD_STD_REG_ID'], $country, $port_id, $point_id, $sum);
		}
	}

	return $sum;
}
?>
<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
	$(document).ready(function() {	

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

		$('.port_checkbox').click(function() {
			var id = this.id;
			ele = id.split('_');
			if(ele[2]!=0){
				id = ele[2];
				if ($(this).prop('checked') == true) {
					$('.point_'+id).prop('checked', true);
				} else {
					$('.point_'+id).prop('checked', false);
				}
			}
			
		});
	});

	function ShowHide(reg_id) {
		$('.TR-Parent-' + reg_id).toggle();
	}

	function ChangeFilter(){
		var year = $('#y').val();
		var month = $('#m').val();
		var country_type = $('#country_type').val();
		var port_type = $("input[name='port_type[]']").map(function() {
			if ($(this).prop('checked') == true) {
				return $(this).val();
			}
		}).get();

		var point_type = $("input[name='point_type[]']").map(function() {
			if ($(this).prop('checked') == true) {
				return $(this).val();
			}
		}).get();

		window.location.href = base_url + '/report/monthly?m=' + month+'&y='+year+'&country_type='+country_type+'&port_type='+port_type+'&point_type='+point_type;
	}

	function export_report(type){
		var year = $('#y').val();
		var month = $('#m').val();
		var country_type = $('#country_type').val();
		var port_type = $("input[name='port_type[]']").map(function() {
			if ($(this).prop('checked') == true) {
				return $(this).val();
			}
		}).get();

		var point_type = $("input[name='point_type[]']").map(function() {
			if ($(this).prop('checked') == true) {
				return $(this).val();
			}
		}).get();

		window.open (base_url + '/report/monthly?m=' + month+'&y='+year+'&country_type='+country_type+'&port_type='+port_type+'&point_type='+point_type+'&export_type='+type);
	}

</script>
<?= $this->endSection() ?>