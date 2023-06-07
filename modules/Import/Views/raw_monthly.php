<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">Import Monthly Data</div>
			<div class="card-body">
				<form action="<?= base_url('import/import_file_raw_monthly'); ?>" method="post" id="form_import" class="needs-validation" enctype="multipart/form-data">

					<div class="row">
						<div class="col-md-2">
							Month
						</div>
						<div class="col-md-2">
							Year
						</div>
						<div class="col-md-7">
							File Raw Data
						</div>
						<div class="col-md-1">

						</div>
					</div>

					<div class="row">
						<div class="col-md-2">
							<select class="form-control" id="month" name="month" required>
							<?php foreach($month_label as $m_id=>$name){ ?>
								<option value="<?php echo $m_id?>"  ><?php echo $name?></option>
							<?php } ?>
							</select>
						</div>
						<div class="col-md-2">
							<select class="form-control" id="year" name="year" required>
							<?php for($i=date('Y');$i >= date('Y')-5;$i--){ ?>
								<option value="<?php echo $i?>"><?php echo $i?></option>
							<?php }?>
							</select>
						</div>
						<div class="col-md-7">
							<input type="file" name="import_file" id="import_file" class="form-control" accept=".xls,.xlsx" required>
						</div>
						<div class="col-md-1">
							<button type="submit" class="btn btn-primary">Upload</button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-4 col-4">Monthly Raw Data</div>
					<div class="col-md-2 col-2"></div>
					<div class="col-md-2" style="text-align: right;">
						ค้นหา
					</div>
					<div class="col-md-2">
						<select class="form-control" id="m" name="m" onchange="ChangeFilter()">
						<?php foreach($month_label as $m_id=>$name){ $sel = ''; if($month==$m_id){  $sel='selected="selected"';  }?>
							<option value="<?php echo $m_id?>" <?php echo $sel;?> ><?php echo $name?></option>
						<?php } ?>
						</select>
					</div>
					<div class="col-md-2">
						<select class="form-control" id="y" name="y" onchange="ChangeFilter()" >
						<?php for($i=date('Y');$i >= date('Y')-5;$i--){ $sel = ''; if($year==$i){  $sel='selected="selected"';  }?>
							<option value="<?php echo $i?>" <?php echo $sel;?> ><?php echo $i?></option>
						<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="card-body" style="width:99%; overflow:auto;">
				<div class="row" style="margin-bottom:5px;">

				</div>
				<table class="table table-striped table-bordered" id="myTable">
					<thead>
						<tr>
							<th rowspan="2" >NATION</th>
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
</div>
<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.date_picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: 'th-th',
		});

		// $('#myTable').DataTable({
		// 	language: {
		// 		"lengthMenu": "แสดง _MENU_ รายการ",
		// 		"search": "ค้นหา:",
		// 		"zeroRecords": "ไม่มีข้อมูล",
		// 		"info": "รายการที่ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
		// 		"infoEmpty": "ไม่มีข้อมูล",
		// 		"paginate": {
		// 			"first": "First",
		// 			"last": "Last",
		// 			"next": "ถัดไป",
		// 			"previous": "ก่อนหน้า"
		// 		},
		// 	}
		// });


	});

	function ChangeFilter(){
		var year = $('#y').val();
		var month = $('#m').val();

		window.location.href = base_url + '/import/raw_monthly?m=' + month+'&y='+year;
	}
</script>
<?= $this->endSection() ?>