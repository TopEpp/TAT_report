<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu');?>
<div class="row">
	<div class="col-md-6" style="font-size: 1.4em;">
		<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543)?>
	</div>
	<div class="col-md-6 col-6" style="text-align: right;">
		<a target="_blank" onclick="export_report('excel')" class="btn btn-success" style="width : 70px">
          <i class="fa-solid fa-file-excel"></i> Excel
        </a>
        <a target="_blank" onclick="export_report('pdf')" class="btn btn-danger" style="width : 70px">
          <i class="fa-solid fa-file-pdf"></i> PDF
        </a>
	</div>
	<div class="col-md-12" >
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย จำแนกรายตลาด (ตลาดระยะใกล้ - ตลาดระยะไกล)
	</div>
</div>
<div class="row">
	<div class="col-md-4 col-4" >
		 วันที่เริ่มต้น <input type="text" name="date_start" id="date_start" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($date_start,543,'/')?>">
	</div>
	<div class="col-md-3 col-4" >
		วันที่สิ้นสุด <input type="text" name="date_end" id="date_end" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($date_end,543,'/')?>">
	</div>
	<div class="col-md-1 col-4" >
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-6" style="text-align:center;">
		<label>ตลาดระยะใกล้ (Short Haul)</label>
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>ลำดับ</th>
						<th>สัญชาติ</th>
						<th>จำนวนนักท่องเที่ยว</th>
						<th>สัดส่วน</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach($country['Short'] as $c){ $i++; 
						$ratio = 0;
						if(@$data[$c['COUNTRYID']]['NUM']>0){
							$ratio = @$data[$c['COUNTRYID']]['NUM']/$data['SUM']*100;
						}
				?>
					<tr>
						<td><?php echo $i?></td>
						<td align="left"><?php echo $c['COUNTRY_NAME_EN']?></td>
						<td align="right"><?php echo @number_format(@$data[$c['COUNTRYID']]['NUM'])?></td>
						<td align="right"><?php echo number_format($ratio,2);?></td>
					</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-6 col-6" style="text-align:center;">
		<label>ตลาดระยะไกล (Long Haul)</label>
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>ลำดับ</th>
						<th>สัญชาติ</th>
						<th>จำนวนนักท่องเที่ยว</th>
						<th>สัดส่วน</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=0; foreach($country['Long'] as $c){ $i++;
					$ratio = 0;
						if(@$data[$c['COUNTRYID']]['NUM']>0){
							$ratio = @$data[$c['COUNTRYID']]['NUM']/$data['SUM']*100;
						}
				?>
					<tr>
						<td><?php echo $i?></td>
						<td align="left"><?php echo $c['COUNTRY_NAME_EN']?></td>
						<td align="right"><?php echo @number_format(@$data[$c['COUNTRYID']]['NUM'])?></td>
						<td align="right"><?php echo number_format($ratio,2);?></td>
					</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php $this->endSection() ?>

<?=$this->section("scripts")?>
<script type="text/javascript">
$(document).ready(function() {
	$('.date_picker').datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
      language: 'th-th',
    });
});

function ChangeFilter(){
	var date = $('#date_start').val();
	date = date.split('/');
	// start_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
	date_start = date[0]+'-'+date[1]+'-'+(date[2]-543);

	var date = $('#date_end').val();
	date = date.split('/');
	// end_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
	date_end = date[0]+'-'+date[1]+'-'+(date[2]-543);


	window.location.href = base_url+'/report/market?d1='+date_start+'&d2='+date_end;
}

function export_report(type){
	var date = $('#date_start').val();
	date = date.split('/');
	// start_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
	date_start = date[0]+'-'+date[1]+'-'+(date[2]-543);

	var date = $('#date_end').val();
	date = date.split('/');
	// end_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
	date_end = date[0]+'-'+date[1]+'-'+(date[2]-543);

	window.open( base_url+'/report/market/?export_type='+type+'&d1='+date_start+'&d2='+date_end );
}
</script>
<?=$this->endSection()?>
