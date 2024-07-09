<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu'); ?>
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

	#resultsTable {
		background: #B6E2E9;
		border-radius: 25px !important;
		border-width: 5px !important;
		border-style: solid !important;
		border-color: #B6E2E9 !important;
		/*  width: 90%;  */
		padding-top: 3%;
		margin: 0px auto;
		float: none;
	}

	.headerFlex {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-content: center;
		flex-wrap: wrap;
	}

	.headerColumn {
		text-align: left;
	}

	@media (max-width: 576px) {
		.headerColumn {
			text-align: center;
		}

		.SetAlignInputleft1 {
			text-align: end;
			padding: 0px 10px 0px;
		}

		.SetAlignInputleft2 {
			text-align: start;
			padding: 0px 10px 0px;
		}

		.SetwidthInput1 {
			width: 120px;
			border-radius: 12px;
		}

		.SetwidthInput2 {
			width: 120px;
			margin-right: auto;
			border-radius: 12px;
		}

		.btn_Color {
			width: 120px;
			margin-right: auto;
			border-radius: 12px;
		}

		.SetSpaceBtn {
			padding: 10px 0px;
		}

		.SetAlingBtn1 {
			text-align: end;
		}

		.SetAlingBtn2 {
			text-align: start;
		}

		.SetWidthbtnExport {
			width: 260px !important;
		}
	}

	.card_info{
		border-radius: 10px;
		margin-bottom: 10px;
		border:1px solid #ccc;
		padding: 5px;
	}
</style>
<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>
<div class="py-2" style="">
	<div class="row">
		<div class="col-md-2 col-12 my-auto text-center py-2">
			เลือกช่วงวันที่
		</div>
		<div class="col-md-2 col-12 my-auto ">
			<input type="text" name="start_date" id="start_date" class="SetwidthInput2 form-control date_picker" style="display: inline;" value="" placeholder="From" />
		</div>
		<div class="col-md-2 col-12 my-auto ">
			<input type="text" name="end_date" id="end_date" class="SetwidthInput2 form-control date_picker" style="display: inline;" value="" placeholder="To" />
		</div>
		<div class="col-md-1 col-12 my-auto text-center py-2">
			ประเทศ
		</div>
		<div class="col-md-2 col-12 my-auto ">
			<select id="country_select" class="form-control">
			<?php foreach($country as $id=>$name){ $sel = ''; if($country_id==$id){ $sel = 'selected="selected"';}?>
				<option <?php echo $sel;?> value="<?php echo $id?>"><?php echo $name?></option>
			<?php } ?>
			</select>
		</div>
		<div class="col-md-1 my-auto SetSpaceBtn">
			<div class="btn btn_Color" onclick="ChangeFilter()">ตกลง</div>
				
		</div>
		<div class="col-md-1 col-12 my-auto text-center">
			<button type="button" onclick="SaveImg2ExportPdf('<?php echo base_url('main/saveImg2Report'); ?>','<?php echo base_url('main/export_country?start_date=' . $start_date . '&end_date=' . $end_date); ?>')" class="btn btn-danger SetWidthbtnExport" style="width: 100%; border-radius: 1em;">
				<i class="fa-solid fa-file-pdf"></i> PDF
			</button>
		</div>
		<div class="col-md-1 col-12 my-auto text-center">
		
			<button type="button" class="btn btn-primary SetWidthbtnExport" style="width: 100%; border-radius: 1em;">
				<i class="fa-solid fa-file-image"></i> JPG
			</button>
			
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<!-- <div class="card-header">  </div> -->
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<div class="card_info">
							สะสม <?php echo $Mydate->date_eng2thai($start_date_label_past, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($end_date_label_past, 543, 'S', 'S') ?><br>
							<?php echo number_format($SumMonthData_past)?> คน
						</div>
						<div class="card_info">
							สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?><br>
							<?php echo number_format($SumMonthData)?> คน<br>
							Change <?php
							if ($SumMonthData_past > 0) {
								$percent = number_format(($SumMonthData-$SumMonthData_past)  / $SumMonthData_past  * 100, 2);
								if ($SumMonthData > $SumMonthData_past) {
									echo '<span style="color:green">+' . $percent . '%</span>';
								} else {
									echo '<span style="color:red">-' . $percent*(-1) . '%</span>';
								}
							} else {
								echo '-';
							} ?>
						</div>
						<div class="card_info">
							<?php echo $Mydate->date_eng2thai($prev_date, 543, 'S', 'S') ?> - <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?><br>
							<?php echo number_format($SumWeekData)?> คน<br>
							WoW <?php
							if ($SumWeekData_past > 0) {
								$percent = number_format(($SumWeekData-$SumWeekData_past)  / $SumWeekData_past  * 100, 2);
								if ($SumWeekData > $SumWeekData_past) {
									echo '<span style="color:green">+' . $percent . '%</span>';
								} else {
									echo '<span style="color:red">-' . $percent*(-1) . '%</span>';
								}
							} else {
								echo '-';
							} ?>
						</div>
						<div class="card_info">
							<div class="row">
								<div class="col-md-8">ด่านอากาศ : <?php echo number_format($SumPortType[1]['NUM']);?> คน</div>
								<div class="col-md-4" style="text-align:right;"><?php echo number_format($SumPortType[1]['NUM']/($SumPortType[1]['NUM']+$SumPortType[0]['NUM'])*100,2); ?>%</div>
							</div>
							<div class="row">
								<div class="col-md-8">ด่านบก : <?php echo number_format($SumPortType[0]['NUM']);?> คน</div>
								<div class="col-md-4" style="text-align:right;"><?php echo number_format($SumPortType[0]['NUM']/($SumPortType[1]['NUM']+$SumPortType[0]['NUM'])*100,2); ?>%</div>
							</div>
							
						</div>
					</div>
					<div class="col-md-9">
						<?php 
						$flag = base_url('public/img/logotat.png');

						if (!file_exists(base_url('public/img/flag/' . $country_id . '.png'))) {
							$flag = base_url('public/img/flag/' . $country_id . '.png');
						}
						?>
						<div style="text-align:right;width: 100%;"><img class="img-profile rounded-circle" src="<?php echo $flag ?>" style="width: 40px;"></div>
						<div class="text-center" id="htmltoimage_chart" style="padding:5px;">

							<div id="chart_main" style="height:280px !important"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 

function convertArrayToHighchartsFormat($array,$end_date_label) {
    $series = [];
    list($year, $month, $day) = explode('-', $end_date_label);

    foreach ($array as $name => $data) {
    	if($name=='current'){
    		$name_chart = $year;
    	}else{
    		$name_chart = $year-1;
    	}
        $seriesObject = [
            "name" => $name_chart,
            "lineWidth" => 4,
            "marker" => [
                "radius" => 4
            ],
            "data" => []
        ];

        foreach ($data as $date => $value) {
            $dateParts = explode("-", $date);
            if($name=='current'){
	            $year = (int)$dateParts[0];
	        }else{
	        	$year = (int)$dateParts[0]+1;
	        }
            $month = (int)$dateParts[1] - 1; // JavaScript months are 0-based
            $day = (int)$dateParts[2];
            $seriesObject["data"][] = "[Date.UTC($year, $month, $day), $value]";
        }

        $series[] = $seriesObject;
    }

    return json_encode($series);
}

$highchartsData = convertArrayToHighchartsFormat($DataChart,$end_date_label);

?>

<?php $this->endSection() ?>
<?= $this->section("scripts") ?>
<script src="<?= base_url('public/js/script.js') ?>"></script>
<script src="<?php echo base_url('public/vendor/html2canvas/html2canvas.js'); ?>"></script>
<script src="<?php echo base_url('public/vendor/chart.js/Chart.min.js'); ?>" type="text/javascript"></script>

<script src="<?php echo base_url('public/js/highcharts/highcharts.js')?>"></script>
<!-- <script src="https://code.highcharts.com/modules/data.js"></script> -->
<!-- <script src="https://code.highcharts.com/modules/series-label.js"></script> -->
<script src="<?php echo base_url('public/js/highcharts/modules/exporting.js')?> "></script>
<script src="<?php echo base_url('public/js/highcharts/modules/export-data.js')?> "></script>
<script src="<?php echo base_url('public/js/highcharts/modules/accessibility.js')?> "></script>

<script type="text/javascript">

$(function() {
	$('.date_picker').datepicker({
		format: "dd/mm/yyyy",
		autoclose: true,
		language: 'th-th',
		endDate: new Date('<?php list($year, $month, $day) = explode('-', $end_date_label);
							echo $year . '-' . $month . '-' . ($day); ?>')
	});


	Highcharts.chart('chart_main', {

	    chart: {
	        scrollablePlotArea: {
	            minWidth: 700
	        },
	        backgroundColor: 'rgba(0,0,0,0)',
	    },
	    credits: {
	        enabled: false
	    },
	    title: {
	        text: 'จำนวนนักท่องเที่ยวรายวัน',
	        align: 'center'
	    },

	    xAxis: {
	    	type: 'datetime',
	        tickInterval: 7 * 24 * 3600 * 1000, // one week
	        tickWidth: 0,
	        gridLineWidth: 1,
	        gridLineDashStyle: 'Dash',
	    },

	    yAxis: [{ // left y axis
	        title: {
	            text: null
	        },
	        
	        showFirstLabel: false,

	    }],

	    legend: {
            enabled: true
        },

	    tooltip: {
	        shared: true,
	        crosshairs: true,
	        dateTimeLabelFormats: {
	            day: '%d-%m-%Y'
	        },
	        headerFormat: '<small>{point.key}</small><table>',
		    pointFormat: '<tr><td style="color: {series.color}">{series.name} : </td>' +
		        '<td style="text-align: right"><b>{point.y:,.0f}</b></td></tr>',
		    footerFormat: '</table>',
		    formatter: function() {
		        return '<small>' + Highcharts.dateFormat('%d-%m-%Y', this.x) + '</small><table>' +
		            this.points.map(point => (
		                '<tr><td style="color:' + point.series.color + '"> : </td>' +
		                '<td style="text-align: right;color: ' + point.series.color + '"><b>' + Highcharts.numberFormat(point.y, 0, '.', ',') + '</b></td></tr>'
		            )).join('') +
		            '</table>';
		    }
	    },
	    <?php echo "series: " . str_replace('"', '', $highchartsData); ?>
	    
	});


});
	


	function SaveImg2ExportPdf(url2SaveImg, url2DowloadReport) {
		$('.btn-download').hide();
		$('#htmltoimage_chart_daily_year').show();
		setTimeout(function(){ saveImg(url2SaveImg, url2DowloadReport); }, 1000);
		setTimeout(function(){ $('#htmltoimage_chart_daily_year').hide(); }, 6000);

		$.ajax({
	        method: "POST",
	        url: base_url + "/main/saveLog",
	        data: {'type':'Daily'},
	        success: function(res) {
	          
	        }
	    });
		
	}

	function saveImg(url2SaveImg, url2DowloadReport){
		$('.btn-download').hide();
		const chart_array = ["chart_daily","chart_daily_year"];
		var count_canvas = 0;
		$.each(chart_array, function(key, value) {
			var container = document.getElementById("htmltoimage_" + value);
			html2canvas(container, {
				allowTaint: true
			}).then(function(canvas) {

				var link = document.createElement("a");
				document.body.appendChild(link);
				link.download = "<?php echo $end_date_label; ?>" + value + ".jpg";
				link.href = canvas.toDataURL();
				link.target = '_blank';


				var dataURL = link.href;
				$.post(url2SaveImg, {
					imgBase64: dataURL,
					imgName: "<?php echo $end_date_label; ?>" + value
				}, function(data, status) {
					count_canvas++;
					// console.log(count_canvas+' == '+chart_array.length );
					if (count_canvas == chart_array.length) {
						window.open(url2DowloadReport);
					}

				});
			});

		});
	}

	function numberWithCommas(x) {
		if (x) {
			return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		} else {
			return 0;
		}

	}

	function ChangeFilter() {
		var country_id = $('#country_select').val();
		if ($('#start_date').val() != '' && $('#start_date').val() != '') {
			var date = $('#start_date').val();
			if(date==''){
				$('#start_date').focus();
				$('#start_date').css("border-color", "#e74a3b");
				return false;
			}
			date = date.split('/');
			start_date = date[0] + '-' + date[1] + '-' + (date[2] - 543);

			var date = $('#end_date').val();
			if(date==''){
				$('#end_date').focus();
				$('#end_date').css("border-color", "#e74a3b");
				return false;
			}
			date = date.split('/');
			end_date = date[0] + '-' + date[1] + '-' + (date[2] - 543);
			window.location.href = base_url + '/main/country?start_date=' + start_date + '&end_date=' + end_date+'&country_id='+country_id;
		} else {
			window.location.href = base_url + '/main/country?country_id='+country_id;
		}

	}

	function ClearFilter() {
		window.location.href = base_url + '/main/daily';
	}
</script>
<?= $this->endSection() ?>