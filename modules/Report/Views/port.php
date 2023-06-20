<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
<?php
$dataMap = array();
$sumDay = 0;
foreach ($data_day as $k => $subArray) {
	$sumDay += $subArray['NUM'];

	$dataMap[$subArray['PORT_ID']]['latlong'] = $subArray['PORT_LATLONG'];
	$dataMap[$subArray['PORT_ID']]['name'] = $subArray['PORT_NAME'];
	$dataMap[$subArray['PORT_ID']]['valueDay'] = $subArray['NUM'];
	$dataMap[$subArray['PORT_ID']]['id'] = $subArray['PORT_ID'];
}
$sumDay = ceil($sumDay);

$sumMonth = 0;
foreach ($data_month as $k => $subArray) {
	$sumMonth += $subArray['NUM'];

	$dataMap[$subArray['PORT_ID']]['valueMonth'] = $subArray['NUM'];
}
$sumMonth = ceil($sumMonth);

$report_date = $Mydate->date_eng2thai($to_date, 543);

$numberDay = $numberMonth = array();
$i = 1;


foreach ($data_day_lastyear as $v) {

	if ($v['NUM'] == 0) {
		$numberDay[$v['PORT_ID']] = '';
	} else {
		$numberDay[$v['PORT_ID']] = $i++;
	}
}

$i = 1;
foreach ($data_month_lastyear as $v) {

	if ($v['NUM'] == 0) {
		$numberMonth[$v['PORT_ID']] = '';
	} else {
		$numberMonth[$v['PORT_ID']] = $i++;
	}
}


?>
<style>
	.radiusTable1 {
		border-radius: 1em;
		overflow: hidden;

	}

	.radiusTable1 tbody tr:nth-of-type(odd) {
		background-color: #D6EFF2;

	}

	.radiusTable1 thead th {
		background: #70D3DE;

	}

	.radiusTable2 {
		border-radius: 1em;
		overflow: hidden;

	}

	.radiusTable2 tbody tr:nth-of-type(odd) {
		background-color: #FFE4C8;
	}

	.radiusTable2 thead th {
		background: #FACE74;
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
<style type="text/css">
	.gm-style .gm-style-iw-c {
		padding: 0 !important;
	}

	.gm-ui-hover-effect {
		display: none !important;
	}

	.gm-style-iw-d {
		width: 200px;
		overflow: unset !important;
	}

	.button_close {
		position: absolute;
		z-index: 1;
		right: 0;
	}

	.btn_Color {
		background-color: #3eabae;
		color: white;
		width: 100%;
		border-radius: 1em;
	}

	.btn_Color:hover {
		background-color: #007c84;
		color: white;
	}

	.close {
		opacity: 0.8;
	}

</style>
<div class="row">
	<div class="col-md-6 col-12 text-center text-md-left" >
		
	</div>
	<div class="col-md-6 col-12 py-2 py-md-0" style="text-align: right;">
		<a target="_blank" href="<?php echo base_url('report/port/?export_type=excel&d=' . $to_date); ?>" class="btn btn-success" style="width : 70px">
			<i class="fa-solid fa-file-excel"></i> Excel
		</a>
		<a target="_blank" href="<?php echo base_url('report/port/?export_type=pdf&d=' . $to_date); ?>" class="btn btn-danger" style="width : 70px">
			<i class="fa-solid fa-file-pdf"></i> PDF
		</a>
	</div>
	<div class="col-md-12 text-center py-2" style="font-size: 1.4em;">
		รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายด่าน วันที่ :
		<input type="text" name="report_data" id="report_data" class="form-control date_picker" style="width: 200px;display: inline;" value="<?php echo $Mydate->date_thai2eng($to_date_label, 543, '/') ?> ">
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div id="canvas_map" style="height: 450px; width:100%"></div>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-12 py-2">
		<div style="text-align:center;" class="py-2 pt-4">
			ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543); ?>
		</div>
		<div class="table-responsive shadow-lg">
			<table class="table table-striped radiusTable1 " id="table1" style="border-bottom:none">
				<thead>
					<tr>
						<th width="5%">ลำดับ<br><?php echo $year + 543; ?></th>
						<th width="5%">ลำดับ<br><?php echo $year + 542; ?></th>
						<th>ด่าน</th>
						<th width="20%">จำนวนนักท่องเที่ยว (คน)</th>
						<th width="10%">สัดส่วน (%)</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1;
					foreach ($data_day as $k => $v) {
						$icon = '';
						if (!empty($numberDay[$v['PORT_ID']])) {
							if ($i == $numberDay[$v['PORT_ID']]) {
								$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">(' . $numberDay[$v['PORT_ID']] . ')</span>';
							} else if ($i < $numberDay[$v['PORT_ID']]) {
								$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">(' . $numberDay[$v['PORT_ID']] . ')</span>';
							} else if ($i > $numberDay[$v['PORT_ID']]) {
								$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">(' . $numberDay[$v['PORT_ID']] . ')</span>';
							}
						}

					?>
						<tr>
							<td align="center"> <b><?php echo $i++ ?></b> </td>
							<td align="center"> <?php echo @$numberDay[$v['PORT_ID']] ?> </td>
							<td> <?php echo $v['PORT_NAME'] ?> </td>
							<td align="right"> <?php echo number_format($v['NUM']); ?> </td>
							<td align="right"> <?php if ($sumDay > 0) {
													echo number_format($v['NUM'] / $sumDay * 100, 2);
												} ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<span style="font-size:0.8em">* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)</span>
	</div>
	<div class="col-md-6 col-12 py-2">
		<div style="text-align:center;" class="py-2 pt-4">
			สะสม วันที่ 1 ม.ค. - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S') ?>
		</div>
		<div class="table-responsive shadow-lg">
			<table class="table table-striped radiusTable2 shadow-lg" id="table2" style="border-bottom:none">
				<thead>
					<tr>
						<th width="5%">ลำดับ<br><?php echo $year + 543; ?></th>
						<th width="5%">ลำดับ<br><?php echo $year + 542; ?></th>
						<th>ด่าน</th>
						<th width="20%">จำนวนนักท่องเที่ยว (คน)</th>
						<th width="10%">สัดส่วน (%)</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					foreach ($data_month as $k => $v) {
						$icon = '';
						if (!empty($numberMonth[$v['PORT_ID']])) {
							if ($i == $numberMonth[$v['PORT_ID']]) {
								$icon = '<i class="fa fa-equals fa-fw"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['PORT_ID']] . ')</span>';
							} else if ($i < $numberMonth[$v['PORT_ID']]) {
								$icon = '<i class="fa fa-caret-up fa-fw" style="color:green"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['PORT_ID']] . ')</span>';
							} else if ($i > $numberMonth[$v['PORT_ID']]) {
								$icon = '<i class="fa fa-caret-down fa-fw"  style="color:red"></i> <span style="font-size:0.6em">(' . $numberMonth[$v['PORT_ID']] . ')</span>';
							}
						}
					?>
						<tr>
							<td align="center"> <b><?php echo $i++ ?></b> </td>
							<td align="center"> <?php echo @$numberMonth[$v['PORT_ID']] ?> </td>
							<td> <?php echo $v['PORT_NAME'] ?> </td>
							<td align="right"> <?php echo number_format($v['NUM']); ?> </td>
							<td align="right"> <?php if ($sumMonth > 0) {
													echo number_format($v['NUM'] / $sumMonth * 100, 2);
												} ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<span style="font-size:0.8em">* เปรียบเทียบกับช่วงเดียวกันของปีที่ผ่านมา (Year-On-Year)</span>
	</div>
</div>
<?php $this->endSection() ?>

<?= $this->section("scripts") ?>
<script src="https://maps.google.com/maps/api/js?key=<?php echo $api_code; ?>&sensor=false&libraries=marker"></script>
<script type="text/javascript">
	var dataMap = <?php echo json_encode($dataMap); ?>;
	$(document).ready(function() {

		$('.date_picker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			language: 'th-th',
			endDate: new Date('<?php echo $to_date; ?>')
		});

		$('.date_picker').change(function() {
			var date = this.value;
			date = date.split('/');
			report_date = (date[2] - 543) + '-' + date[1] + '-' + date[0];

			window.location.href = base_url + '/report/port?d=' + report_date;
		});

		$('#table1').DataTable({
			// scrollY: '300vh',
			// scrollCollapse: true,
			paging: false,
			searching: false,
			info: false,
			order: [
				[3, 'desc']
			],
			language: {
				"lengthMenu": "แสดง _MENU_ รายการ",
				"search": "ค้นหา:",
				"zeroRecords": "ไม่มีข้อมูล",
				"info": "รายการที่ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
				"infoEmpty": "ไม่มีข้อมูล",
				"paginate": {
					"first": "First",
					"last": "Last",
					"next": "ถัดไป",
					"previous": "ก่อนหน้า"
				},
			}
		});

		$('#table2').DataTable({
			paging: false,
			searching: false,
			info: false,
			order: [
				[3, 'desc']
			],
			language: {
				"lengthMenu": "แสดง _MENU_ รายการ",
				"search": "ค้นหา:",
				"zeroRecords": "ไม่มีข้อมูล",
				"info": "รายการที่ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
				"infoEmpty": "ไม่มีข้อมูล",
				"paginate": {
					"first": "First",
					"last": "Last",
					"next": "ถัดไป",
					"previous": "ก่อนหน้า"
				},
			}
		});

		initMap();
		addMarker(dataMap);
	});


	var rendererOptions = {
		suppressMarkers: true,
	};
	var Marker = [];
	var ArrayMarker = [];
	var map;
	var directionsService = new google.maps.DirectionsService();
	var directionsRenderer = new google.maps.DirectionsRenderer(rendererOptions);
	var infowindow = [];

	function initMap() {
		var center = new google.maps.LatLng(14.6410611,101.9513844);
		var mapOptions = {
			zoom: 5,
			center: center,
			disableDefaultUI: false,
			mapTypeControl: false,
			scaleControl: false,
			zoomControl: true,
			streetViewControl: false,
			fullscreenControl: false,
		}
		map = new google.maps.Map(document.getElementById('canvas_map'), mapOptions);
		// directionsRenderer.setMap(map);

		// console.log(map);
	}

	function addMarker(data) {

		$.each(data, function(index, value) {
			console.log(value);
			index = value.id;
			var latlong = value.latlong.split(',');
			value.LATITUDE = latlong[0];
			value.LONGITUDE = latlong[1];
			var LatLon = value.LATITUDE + ',' + value.LONGITUDE;
			if (jQuery.inArray(LatLon, ArrayMarker) !== -1) {

			} else {
				var id_marker = value.id;
				ArrayMarker.push(LatLon);
				Marker[id_marker] = new google.maps.Marker({
					icon: value.marker,
					position: new google.maps.LatLng(value.LATITUDE, value.LONGITUDE),
					map: map,
				});

				var index = parseInt(index);
				infowindow[index] = new google.maps.InfoWindow();
				var content = "<div style='text-align:center'>" +
					"<button type='button' class='close button_close' onclick='close_info(" + index + ")'>" +
					"<span>&times;</span>" +
					"</button>" +
					"<div style='padding:5px;color:#000;background:#D6EFF2'>" + value.name + "</div>" +
					"<div style='margin:8px;'><table style='width: 100%;'>" +
					"<tr><td style='text-align: left;border-right: 1px solid #aaa;border-bottom: 1px solid #aaa;'><?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?></td><td style='text-align: right;border-bottom: 1px solid #aaa;'>" + numberWithCommas(value.valueDay) + "</td></tr>" +
					"<tr><td style='text-align: left;border-right: 1px solid #aaa;'>1 ม.ค. - <?php echo $Mydate->date_eng2thai($to_date, 543, 'S', 'S') ?></td><td style='text-align: right;'>" + numberWithCommas(value.valueMonth) + "</td></tr>" +
					"</table></div>" +
					"</div>";

				infowindow[index].setContent(content);
				infowindow[index].setPosition(new google.maps.LatLng(value.LATITUDE, value.LONGITUDE));

				Marker[id_marker].addListener("click", () => {
					// showCountry(index);
					infowindow[index].open({
						map,
					});
				});
			}
		});


	}

	function close_info(index) {
		infowindow[index].close();
		$('.region_' + index).hide();
	}

	function numberWithCommas(x) {
	    if(x){
	        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	    }else{
	        return 0;
	    }
	    
	}


</script>
<?= $this->endSection() ?>