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

	.card-header{
		font-size:1.5em; text-align:center;
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
</style>
<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-1 col-12 my-auto text-center"></div>
					<div class="col-md-10 col-12 my-auto text-center">สถิติคนไทยเดินทางออกนอกราชอาณาจักรในภาพรวม</div>
					<div class="col-md-1 col-12 my-auto text-center" style="font-size:0.6em !important; ">
						<button type="button" onclick="SaveImg2ExportPdf('<?php echo base_url('main/saveImg2Report'); ?>','<?php echo base_url('main/export_dashboard_view?start_date=' . $start_date . '&end_date=' . $end_date); ?>')" class="btn btn-danger SetWidthbtnExport" style="width: 100%; border-radius: 1em;">
							<i class="fa-solid fa-file-pdf"></i> PDF
						</button>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="text-center" id="htmltoimage_chart_daily" style="height:320px; padding:15px;">
					 <div id="container" style="height:300px"></div>
				</div>
				<hr>
				<div style="overflow: auto;">
					<!-- <div style="text-align:center;">
						ภาพรวมคนไทยเดินทางออกนอกราชอาณาจักรไทย : รายเดือน
					</div> -->
					<div id="container2" style="height:220px"></div>
					<table class="table table-striped table-bordered">
						<tr>
							<th style="text-align: center;">ปี</th>
						<?php   for ($i=1; $i <= 12; $i++) {  ?>
							<th style="text-align: center;"><?php echo $shortmonth[$i]; if($check_noti_month==$i){ echo ' *';} ?></th>
						<?php } ?>
							<th style="text-align: center;">รวม</th>
						</tr>
						<tr>
							<td align="center" style="background-color: #3cacae;"><?php echo $year-1?></td>
						<?php for ($i=0; $i <= 11; $i++) { @$sum_past +=$SumChartDataYear['past'][$i]; ?>
							<td align="right" style="background-color: #3cacae;"><?php echo @number_format($SumChartDataYear['past'][$i])?></td>
						<?php } ?>
							<td align="right" style="background-color: #3cacae;"><?php echo number_format($sum_past)?></td>
						</tr>
						<tr>
							<td align="center"><?php echo $year?></td>
						<?php for ($i=0; $i <= 11; $i++) { @$sum_current +=$SumChartDataYear['current'][$i]; ?>
							<td align="right" ><?php echo !empty(number_format(@$SumChartDataYear['current'][$i]))?@number_format($SumChartDataYear['current'][$i]):'';?></td>
						<?php } ?>
							<td align="right" ><?php echo number_format($sum_current)?></td>
						</tr>
						<tr>
							<td align="center">+/- (%)</td>
							<?php for ($i=0; $i <= 11; $i++) { $percent = '';
							if(!empty($SumChartDataYear['current'][$i])){
								$percent = number_format(($SumChartDataYear['current'][$i]-$SumChartDataYear['past'][$i])  / $SumChartDataYear['past'][$i]  * 100, 2);
							}

							 ?>
								<td align="right"><?php  echo $percent!=''?number_format($percent,2):$percent;?></td>
							<?php } ?>
						</tr>
						<tr>
							<td colspan="14">จำนวนคนไทยเดินทางออกเฉลี่ยต่อวัน</td>
						</tr>
						<tr>
							<td align="center" style="background-color: #3cacae;"><?php echo $year-1?></td>
						<?php $sum_days_past =0; for ($i=0; $i <= 11; $i++) { 
							$days = cal_days_in_month(CAL_GREGORIAN, $i+1, $year-1);
							$sum_days_past += $days;
							@$sum_past_day +=$SumChartDataYear['past'][$i]; 
							 ?>
							<td align="right" style="background-color: #3cacae;"><?php echo @number_format($SumChartDataYear['past'][$i]/$days)?></td>
						<?php } ?>
							<td align="right" style="background-color: #3cacae;"><?php echo number_format($sum_past_day/$sum_days_past)?></td>
						</tr>
						<tr>
							<td align="center"><?php echo $year?></td>
						<?php $sum_days=0; for ($i=0; $i <= 11; $i++) { 
							$days = cal_days_in_month(CAL_GREGORIAN, $i+1, $year);
							if(!empty($SumChartDataYear['current'][$i])){
								$sum_days += $days;
							}
							@$sum_current_day +=$SumChartDataYear['current'][$i] ?>
							<td align="right" ><?php echo !empty($SumChartDataYear['current'][$i])?@number_format($SumChartDataYear['current'][$i]/$days):'';?></td>
						<?php } ?>
							<td align="right" ><?php echo number_format($sum_current_day/$sum_days)?></td>
						</tr>
					</table>
					<?php echo $check_noti_month_label;?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				
						<div id="container3" style="height:320px"></div>
						<?php 
						$num_port1 = $SumPort['SUM_TYPE']['ด่านอากาศ'];
						$num_port2 = $SumPort['SUM_TYPE']['ด่านบก'];

						$sum_port1 = number_format($SumPort['SUM_TYPE']['ด่านอากาศ']/($SumPort['SUM_TYPE']['ด่านอากาศ']+$SumPort['SUM_TYPE']['ด่านบก'])*100,2);
						$sum_port2 = number_format($SumPort['SUM_TYPE']['ด่านบก']/($SumPort['SUM_TYPE']['ด่านอากาศ']+$SumPort['SUM_TYPE']['ด่านบก'])*100,2);
						?>
						<!-- ด่านอากาศ : <?php echo number_format($SumPort['SUM_TYPE']['ด่านอากาศ'])?> คน , <?php echo number_format($SumPort['SUM_TYPE']['ด่านอากาศ']/($SumPort['SUM_TYPE']['ด่านอากาศ']+$SumPort['SUM_TYPE']['ด่านบก'])*100,2)?> % <br>
						ด่านบก : <?php echo number_format($SumPort['SUM_TYPE']['ด่านบก'])?> คน , <?php echo number_format($SumPort['SUM_TYPE']['ด่านบก']/($SumPort['SUM_TYPE']['ด่านอากาศ']+$SumPort['SUM_TYPE']['ด่านบก'])*100,2)?> % -->
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				
				
						<div id="container4" style="height:320px"></div>
						<!-- TOP 10 ด่านที่คนไทยเดินทางออกนอกราชอาณาจักรไทย (คน) <br> -->
						<!-- ท่าอากาศยานสุวรรณภูมิและดอนเมือง : <?php echo number_format($SumPort['SUM_PORT'][49]['NUM']+$SumPort['SUM_PORT'][41]['NUM'])?><br> -->
						
						<?php $data_chart_port[] =  $SumPort['SUM_PORT'][49]['NUM']+$SumPort['SUM_PORT'][41]['NUM'];
							  $cate_chart_port[] = 'ท่าอากาศยานสุวรรณภูมิและดอนเมือง';
							$i=0; 
							$minValueHeat = PHP_INT_MAX;
							$maxValueHeat = PHP_INT_MIN;
							foreach($SumPort['SUM_PORT'] as $port ){
							if($port['PORT_ID']!= 49 && $port['PORT_ID']!=41){
								// echo $port['PORT_NAME'].':'.number_format($port['NUM']).'<br>';
								$data_chart_port[] = $port['NUM'];
								$cate_chart_port[] = $port['PORT_NAME'];
							}

							$i++;
							// if($i>10){
							// 	break;
							// }
							
							$data_chart_heat[] = array(
						        "name" => $port["PORT_NAME"],
						        "value" => (int)$port["NUM"],
						        "colorValue" => $i++
    						);

    						// if ($port["NUM"] < $minValueHeat) {
						    //     $minValueHeat = $port["NUM"];
						    // }

						    // if ($port["NUM"] > $maxValueHeat) {
						    //     $maxValueHeat = $port["NUM"];
						    // }

						    $maxValueHeat = $i;

							// print_r($data_chart_port);
						} ?>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">สถิติคนไทยเดินทางออกนอกราชอาณาจักรทาง<u>ท่าอากาศยาน</u> </div>
			<div class="card-body">
				<div class="text-center" id="htmltoimage_chart_daily" style="height:240px; padding:15px;">
					<div id="container5" style="height:220px"></div>
				</div>
				<div>
					<table class="table table-striped table-bordered">
						<tr>
							<th style="text-align: center;">ปี</th>
						<?php   
						
						for ($i=1; $i <= 12; $i++) { 
						?>
							<th style="text-align: center;"><?php echo $shortmonth[$i]; if($check_noti_month==$i){ echo ' *';}?></th>
						<?php } ?>
							<th style="text-align: center;">รวม</th>
						</tr>
						<tr>
							<td align="center" style="background-color: #3cacae;"><?php echo $year-1?></td>
						<?php for ($i=0; $i <= 11; $i++) { @$sum_past +=$SumChartDataYear_Air['past'][$i]; ?>
							<td align="right" style="background-color: #3cacae;"><?php echo @number_format($SumChartDataYear_Air['past'][$i])?></td>
						<?php } ?>
							<td align="right" style="background-color: #3cacae;"><?php echo number_format($sum_past)?></td>
						</tr>
						<tr>
							<td align="center"><?php echo $year?></td>
						<?php for ($i=0; $i <= 11; $i++) { @$sum_current +=$SumChartDataYear_Air['current'][$i]; ?>
							<td align="right" ><?php echo !empty($SumChartDataYear_Air['current'][$i])?@number_format($SumChartDataYear_Air['current'][$i]):'';?></td>
						<?php } ?>
							<td align="right" ><?php echo number_format($sum_current)?></td>
						</tr>
						<tr>
							<td align="center">+/- (%)</td>
							<?php for ($i=0; $i <= 11; $i++) { $percent = '';
							if(!empty($SumChartDataYear_Air['current'][$i])){
								$percent = number_format(($SumChartDataYear_Air['current'][$i]-$SumChartDataYear_Air['past'][$i])  / $SumChartDataYear_Air['past'][$i]  * 100, 2);
							}

							 ?>
								<td align="right"><?php  echo $percent!=''?number_format($percent,2):$percent;?></td>
							<?php } ?>
						</tr>
						<tr>
							<td colspan="14">จำนวนคนไทยเดินทางออกเฉลี่ยต่อวัน</td>
						</tr>
						<tr>
							<td align="center" style="background-color: #3cacae;"><?php echo $year-1?></td>
						<?php $sum_past_day = $sum_days_past =0; for ($i=0; $i <= 11; $i++) { 
							$days = cal_days_in_month(CAL_GREGORIAN, $i+1, $year-1);
							$sum_days_past += $days;
							@$sum_past_day +=$SumChartDataYear_Air['past'][$i]; 
							 ?>
							<td align="right" style="background-color: #3cacae;"><?php echo @number_format($SumChartDataYear_Air['past'][$i]/$days)?></td>
						<?php } ?>
							<td align="right" style="background-color: #3cacae;"><?php echo number_format($sum_past_day/$sum_days_past)?></td>
						</tr>
						<tr>
							<td align="center"><?php echo $year?></td>
						<?php $sum_current_day =$sum_days=0; for ($i=0; $i <= 11; $i++) { 
							$days = cal_days_in_month(CAL_GREGORIAN, $i+1, $year);
							if(!empty($SumChartDataYear_Air['current'][$i])){
								$sum_days += $days;
							}
							@$sum_current_day +=$SumChartDataYear_Air['current'][$i] ?>
							<td align="right" ><?php echo !empty($SumChartDataYear_Air['current'][$i])?@number_format($SumChartDataYear_Air['current'][$i]/$days):'';?></td>
						<?php } ?>
							<td align="right" ><?php echo number_format($sum_current_day/$sum_days)?></td>
						</tr>
						<tr>
							<td colspan="14">สัดส่วนคนไทยเดินทางออกทางท่าอากาศยานต่อภาพรวม (%)</td>
						</tr>
						<tr>
							<td align="center" style="background-color: #3cacae;"><?php echo $year-1?></td>
						<?php $sum_past = $sum_past_air = 0; for ($i=0; $i <= 11; $i++) { 
							$percent = '';
							$sum_past += @$SumChartDataYear['past'][$i];
							$sum_past_air += @$SumChartDataYear_Air['past'][$i];
							if(!empty($SumChartDataYear_Air['past'][$i])){
								$percent = number_format($SumChartDataYear_Air['past'][$i] / $SumChartDataYear['past'][$i]  * 100, 2);
							}
						?>
							<td align="right" style="background-color: #3cacae;"><?php echo $percent!=''?number_format($percent,2):'';?></td>
						<?php } ?>
							<td align="right" style="background-color: #3cacae;"><?php echo number_format( $sum_past_air/$sum_past*100,2 )?></td>
						</tr>
						<tr>
							<td align="center"><?php echo $year?></td>
						<?php $sum = $sum_air = 0; for ($i=0; $i <= 11; $i++) { 
							$percent = '';
							$sum += @$SumChartDataYear['current'][$i];
							$sum_air += @$SumChartDataYear_Air['current'][$i];
							if(!empty($SumChartDataYear_Air['current'][$i])){
								$percent = number_format($SumChartDataYear_Air['current'][$i] / $SumChartDataYear['current'][$i]  * 100, 2);
							}
						?>
							<td align="right" ><?php echo $percent!=''?number_format($percent,2):'';?></td>
						<?php } ?>
							<td align="right" ><?php echo number_format($sum_air/$sum*100,2)?></td>
						</tr>
					</table>
					<?php echo $check_noti_month_label;?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$result = array();
foreach ($DataChartDate['current'] as $timestamp => $value) {
    $result[] = [$timestamp, $value];
}
$jsonResult['current'] = json_encode($result, JSON_PRETTY_PRINT);

$result = array();
foreach ($DataChartDate['current_air'] as $timestamp => $value) {
    $result[] = [$timestamp, $value];
}
$jsonResult['current_air'] = json_encode($result, JSON_PRETTY_PRINT);

$result = array();
foreach ($DataChartDate['past'] as $timestamp => $value) {
    $result[] = [$timestamp, $value];
}
$jsonResult['past'] = json_encode($result, JSON_PRETTY_PRINT);




$currentData = json_encode(array_values($SumChartDataYear['current']));
$pastData = json_encode(array_values($SumChartDataYear['past']));
$portData = json_encode($data_chart_port);
$portCate = json_encode($cate_chart_port);

$currentData_air = json_encode(array_values($SumChartDataYear_Air['current']));
$pastData_air = json_encode(array_values($SumChartDataYear_Air['past']));

$dataHeat = json_encode($data_chart_heat, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
// echo '<pre>'; print_r($dataHeat); echo '</pre>';
?>

<?php $this->endSection() ?>
<?= $this->section("scripts") ?>
<script src="<?= base_url('public/js/script.js') ?>"></script>
<script src="<?php echo base_url('public/vendor/html2canvas/html2canvas.js'); ?>"></script>

<script src="<?php echo base_url('public/js/highcharts/highcharts.js')?>"></script>
<!-- <script src="https://code.highcharts.com/modules/data.js"></script> -->
<!-- <script src="https://code.highcharts.com/modules/series-label.js"></script> -->

<script src="<?php echo base_url('public/js/highcharts/modules/heatmap.js')?> "></script>
<script src="<?php echo base_url('public/js/highcharts/modules/treemap.js')?> "></script>

<script src="<?php echo base_url('public/js/highcharts/modules/exporting.js')?> "></script>
<script src="<?php echo base_url('public/js/highcharts/modules/export-data.js')?> "></script>
<script src="<?php echo base_url('public/js/highcharts/modules/accessibility.js')?> "></script>

<script type="text/javascript">
	
(async () => {

    // const data = await fetch(
    //     '<?php echo base_url('public/data_demo.json')?>'
    // ).then(response => response.json());

    Highcharts.chart('container', {
	    chart: {
	        zooming: {
	            type: 'x'
	        }
	    },
	    credits: {
	        enabled: false
	    },
	    title: {
	        text: 'ภาพรวมคนไทยเดินทางออกนอกราชอาณาจักรไทย : รายวัน',
	        align: 'center'
	    },
	    xAxis: {
	        type: 'datetime',
	        min: Date.UTC(<?php echo $year ?>, 0, 1), // January 1st of the current year
	        max: Date.UTC(<?php echo $year ?>, 11, 31), // December 31st of the current year
	        tickInterval: 30 * 24 * 3600 * 1000, // one month
	        dateTimeLabelFormats: {
	            month: '%b', // Display as "Jan 2023"
	            year: '%Y'
	        }
	    },
	    yAxis: {
	        title: {
	            text: ''
	        },
	        labels: {
	            formatter: function () {
	                return Highcharts.numberFormat(this.value, 0, '.', ',');
	            }
	        }
	    },
	    tooltip: {
	        pointFormatter: function() {
	            return '<span style="color:' + this.color + '">\u25CF</span> ' +
	                this.series.name + ': <b>' + Highcharts.numberFormat(this.y, 0, '.', ',') + '</b><br/>';
	        }
	    },
	    legend: {
	        enabled: true
	    },
	    plotOptions: {
	        area: {
	            marker: {
	                radius: 2
	            },
	            lineWidth: 1,
	            states: {
	                hover: {
	                    lineWidth: 1
	                }
	            },
	            threshold: null
	        }
	    },
	    series: [{
	        type: 'area',
	        name: 'ภาพรวม <?php echo $year ?>',
	        data: <?php echo str_replace('"', '', $jsonResult['current']); ?>,
	        color: Highcharts.getOptions().colors[0],
	        fillColor: {
	            linearGradient: {
	                x1: 0,
	                y1: 0,
	                x2: 0,
	                y2: 1
	            },
	            stops: [
	                [0, Highcharts.getOptions().colors[0]],
	                [1, Highcharts.color(Highcharts.getOptions().colors[0])
	                    .setOpacity(0).get('rgba')]
	            ]
	        }
	    }, {
	        type: 'area',
	        name: 'ด่านอากาศ <?php echo $year ?>',
	        data: <?php echo str_replace('"', '', $jsonResult['current_air']); ?>,
	        color: Highcharts.getOptions().colors[1],
	        fillColor: {
	            linearGradient: {
	                x1: 0,
	                y1: 0,
	                x2: 0,
	                y2: 1
	            },
	            stops: [
	                [0, Highcharts.getOptions().colors[1]],
	                [1, Highcharts.color(Highcharts.getOptions().colors[1])
	                    .setOpacity(0).get('rgba')]
	            ]
	        }
	    }, {
	        type: 'area',
	        name: 'ภาพรวม <?php echo $year - 1 ?>',
	        data: <?php echo str_replace('"', '', $jsonResult['past']); ?>,
	        color: Highcharts.getOptions().colors[2],
	        fillColor: {
	            linearGradient: {
	                x1: 0,
	                y1: 0,
	                x2: 0,
	                y2: 1
	            },
	            stops: [
	                [0, Highcharts.getOptions().colors[2]],
	                [1, Highcharts.color(Highcharts.getOptions().colors[2])
	                    .setOpacity(0).get('rgba')]
	            ]
	        }
	    }]
	});



    var currentData = <?php echo str_replace('"', '', $currentData); ?>;
    var pastData = <?php echo str_replace('"', '', $pastData); ?>;
    Highcharts.chart('container2', {
        title: {
            text: 'ภาพรวมคนไทยเดินทางออกนอกราชอาณาจักรไทย : รายเดือน',
            align: 'center'
        },
        credits: {
            enabled: false
        },
        yAxis: {
            title: {
                text: 'จำนวน (คน)'
            }
        },
        xAxis: {
            categories: ['','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            title: {
                text: 'Month'
            }
        },
        legend: {
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'top',
	        y: 25, // Adjusts the vertical position, increasing this value moves it down
	        x: 0   // Adjusts the horizontal position, increasing this value moves it to the left
	    },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 1 // Starting from January
            }
        },
        series: [{
            name: '<?php echo $year?>',
            data: currentData
        }, {
            name: '<?php echo $year-1?>',
            data: pastData
        }],
        tooltip: {
	        formatter: function() {
	            return '<b>' + this.series.name + '</b><br/>' +
	                this.x + ': ' + Highcharts.numberFormat(this.y, 0, '.', ',');
	        }
	    },
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });


	Highcharts.chart('container3', {
	    chart: {
	        type: 'pie'
	    },
	    credits: {
	        enabled: false
	    },
	    title: {
	        text: ''
	    },
	    tooltip: {
	        formatter: function() {
	            return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.y, 0, '.', ',') + ' คน';
	        }
	    },
	    plotOptions: {
	        pie: {
	            allowPointSelect: true,
	            cursor: 'pointer',
	            dataLabels: {
	                enabled: true,
	                format: '{point.name}: {point.percentage:.1f}%',
	                distance: -50, // Adjust distance to place the label inside the pie slices
	                style: {
	                    fontSize: '1em',
	                    textOutline: 'none'
	                }
	            }
	        }
	    },
	    series: [{
	        name: 'Percentage',
	        colorByPoint: true,
	        data: [{
	            name: 'ด่านอากาศ',
	            y: <?php echo $num_port1?>
	        }, {
	            name: 'ด่านบก',
	            y: <?php echo $num_port2?>
	        }]
	    }]
	});



	var chartData = <?php echo str_replace('"', '', $portData); ?>;
	var portCate = <?php echo $portCate;?>
        
    // Highcharts.chart('container4', {
	//     chart: {
	//         type: 'bar'
	//     },
	//     title: {
	//         text: 'TOP 10 ด่านที่คนไทยเดินทางออกนอกราชอาณาจักรไทย (คน)',
	//         align: 'center'
	//     },
	//     xAxis: {
	//         categories: portCate,
	//         title: {
	//             text: null
	//         },
	//         gridLineWidth: 1,
	//         lineWidth: 0
	//     },
	//     yAxis: {
	//         visible: false, // Hides the y-axis and its line
	//         title: {
	//             text: null // Hides the y-axis title
	//         },
	//         labels: {
	//             enabled: false // Hides the y-axis labels
	//         },
	//         gridLineWidth: 0 // Removes the grid lines on the y-axis
	//     },
	//     tooltip: {
	//         formatter: function() {
	//             return '<b>' + this.x + '</b><br/>' +
	//                 'จำนวน: ' + Highcharts.numberFormat(this.y, 0, '.', ',') + ' คน';
	//         }
	//     },
	//     plotOptions: {
	//         bar: {
	//             borderRadius: '50%',
	//             dataLabels: {
	//                 enabled: true,
	//                 formatter: function() {
	//                     return Highcharts.numberFormat(this.y, 0, '.', ',');
	//                 }
	//             },
	//             groupPadding: 0.1,
	//             borderWidth: 0 // Hides the line between bars
	//         }
	//     },
	//     credits: {
	//         enabled: false
	//     },
	//     legend: {
	//         enabled: false
	//     },
	//     series: [{
	//         name: '',
	//         data: chartData
	//     }]
	// });

	Highcharts.chart('container4', {
	    colorAxis: {
	        min: 1,
	        max: <?php echo $maxValueHeat;?>, 
	        stops: [
	            [0, Highcharts.getOptions().colors[0]],
	            [0.1, '#7abeff'], 
	            [0.4, '#d3eeff'], 
	            [1,'#FFFFFF' ] 
	        ]
	    },
	    credits: {
	        enabled: false
	    },
	    series: [{
	        type: 'treemap',
	        layoutAlgorithm: 'squarified',
	        clip: true,
	        dataLabels: {
	            enabled: true,
	            formatter: function() {
	                var total = this.series.data.reduce(function(sum, point) {
	                    return sum + point.value;
	                }, 0);
	                var percentage = (this.point.value / total * 100).toFixed(2) + '%';
	                return this.point.name + '<br/>' + percentage;
	            },
	            style: {
	                fontSize: '12px',
	                fontWeight: 'bold'
	            }
	        },
	        data: <?php echo $dataHeat;?>
	    }],
	    title: {
	        text: 'ด่านที่คนไทยเดินทางออกนอกราชอาณาจักรไทย (คน)'
	    },
	    legend: {
	        enabled: false // ซ่อน legend
	    },
	    tooltip: {
	        pointFormatter: function() {
	            return '<b>' + this.name + '</b>: ' + Highcharts.numberFormat(this.value, 0, '.', ',') + ' คน';
	        }
	    }
	});



    var currentData = <?php echo str_replace('"', '', $currentData_air); ?>;
    var pastData = <?php echo str_replace('"', '', $pastData_air); ?>;
    Highcharts.chart('container5', {
        title: {
            text: 'สถิติคนไทยเดินทางออกนอกราชอาณาจักรทางท่าอากาศยาน',
            align: 'center'
        },
        credits: {
            enabled: false
        },
        yAxis: {
            title: {
                text: 'จำนวน (คน)'
            }
        },
        xAxis: {
            categories: ['','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            title: {
                text: 'Month'
            }
        },
        legend: {
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'top',
	        y: 25, // Adjusts the vertical position, increasing this value moves it down
	        x: 0   // Adjusts the horizontal position, increasing this value moves it to the left
	    },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 1 // Starting from January
            }
        },
        series: [{
            name: '<?php echo $year?>',
            data: currentData
        }, {
            name: '<?php echo $year-1?>',
            data: pastData
        }],
        tooltip: {
	        formatter: function() {
	            return '<b>' + this.series.name + '</b><br/>' +
	                this.x + ': ' + Highcharts.numberFormat(this.y, 0, '.', ',');
	        }
	    },
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });

})();


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
				link.download = "<?php echo $to_date; ?>" + value + ".jpg";
				link.href = canvas.toDataURL();
				link.target = '_blank';


				var dataURL = link.href;
				$.post(url2SaveImg, {
					imgBase64: dataURL,
					imgName: "<?php echo $to_date; ?>" + value
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
</script>
<?= $this->endSection() ?>