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
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายเดือน
	</div>
</div>

<div class="d-flex justify-content-center py-2 pb-3 flex-column flex-md-row">
	<div class="d-flex align-items-center mx-md-2 mx-auto">
		เดือน 
		<select class="form-control" id="m" name="m" >
		<?php foreach($month_label as $m_id=>$name){ $sel = ''; if($month==$m_id){  $sel='selected="selected"';  }?>
			<option value="<?php echo $m_id?>" <?php echo $sel;?> ><?php echo $name?></option>
		<?php } ?>
		</select>
	</div>
	<div class="d-flex align-items-center mx-md-2 mx-auto my-2 my-md-none">
		ปี 
		<select class="form-control" id="y" name="y"  >
		<?php for($i=date('Y');$i >= date('Y')-5;$i--){ $sel = ''; if($year==$i){  $sel='selected="selected"';  }?>
			<option value="<?php echo $i?>" <?php echo $sel;?> ><?php echo $i?></option>
		<?php }?>
		</select>
	</div>
	<div class="align-items-center mx-md-2 mx-auto my-auto ">
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12 col-12">
		<div class="table-responsive">
			<table class="table table-striped table-tableborder radiusTableNation shadow-lg">
				<thead>
					<tr>
						<th rowspan="2" >ประเทศ</th>
						<?php foreach($port as $p){ $colspan= 1; if(!empty($point[$p['PORT_ID']])){ $colspan = count($point[$p['PORT_ID']]); }  echo '<th colspan="'.$colspan.'">'.$p['PORT_NAME_FULL'].'</th>'; } ?>
					</tr>
					<tr>
						<?php foreach($port as $p){
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
				<?php
				foreach($data as $d){ ?>
					<tr>
						<td><?php echo $d['COUNTRY_NAME_EN']?></td>
						<?php foreach($port as $p){
							if(!empty($point[$p['PORT_ID']])){ 
								foreach($point[$p['PORT_ID']] as $po){
									echo '<td>'.@$d['NUM'][$p['PORT_ID']][$po['POINT_ID']].'</td>';
								} 
							}else{
								echo '<td>'.@$d['NUM'][$p['PORT_ID']][0].'</td>';
							}
						 }?>
					</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
	function ChangeFilter(){
		var year = $('#y').val();
		var month = $('#m').val();

		window.location.href = base_url + '/report/monthly?m=' + month+'&y='+year;
	}

	function export_report(type){
		var year = $('#y').val();
		var month = $('#m').val();

		window.location.href = base_url + '/report/monthly?m=' + month+'&y='+year+'&export_type='+type;
	}
</script>
<?= $this->endSection() ?>