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

.highcharts-background {
    fill: transparent;
}

.card_info {
    border-radius: 10px;
    margin-bottom: 10px;
    border: 1px solid #fff;
    padding: 15px 5px 15px 5px
}

.font-19 {
    font-size: 18px;
}

.font-21 {
    font-size: 21px;
}

.font-17 {
    font-size: 17px
}

</style>
<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>
<div class="py-2" style="">
    <div class="row">
        <div class="col-md-2 col-12 my-auto text-center py-2">
            เลือกช่วงวันที่
        </div>
        <div class="col-md-2 col-12 my-auto ">
            <input type="text" name="start_date" id="start_date" class="SetwidthInput2 form-control date_picker"
                style="display: inline;" value="" placeholder="From" />
        </div>
        <div class="col-md-2 col-12 my-auto ">
            <input type="text" name="end_date" id="end_date" class="SetwidthInput2 form-control date_picker"
                style="display: inline;" value="" placeholder="To" />
        </div>
        <div class="col-md-1 col-12 my-auto text-center py-2">
            สัญชาติ
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
        <div class="col-md-2 col-12 my-auto text-right" >
            <!-- <button type="button"
                onclick="SaveImg2ExportPdf('<?php echo base_url('main/saveImg2Report'); ?>','<?php echo base_url('main/export_country?export=pdf&start_date=' . $start_date . '&end_date=' . $end_date.'&country_id='.$country_id); ?>')"
                class="btn btn-danger SetWidthbtnExport" style="width: 40%; border-radius: 1em;">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </button> -->
            <!-- <button type="button" class="btn btn-primary SetWidthbtnExport"
                onclick="SaveImg2ExportPdf('<?php echo base_url('main/saveImg2Report'); ?>','<?php echo base_url('main/export_country?&start_date=' . $start_date . '&end_date=' . $end_date.'&country_id='.$country_id); ?>')"
                style="width:50%; border-radius: 1em;">
                <i class="fa-solid fa-file-image"></i> Images
            </button> -->
            <button type="button" class="btn btn-danger SetWidthbtnExport"
                onclick="SaveImg2ExportPdf('<?php echo base_url('main/saveImg2Report'); ?>','<?php echo base_url('main/export_country?&start_date=' . $start_date . '&end_date=' . $end_date.'&country_id='.$country_id); ?>')"
                style="width:50%; border-radius: 1em;">
                <i class="fa-solid fa-download"></i> Export
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card" style="background-position: center;background-size: cover;background-image: url(<?php echo base_url('public/img/bg_report_country_2.png') ?>);background-repeat: no-repeat;">
            <!-- <div class="card-header">  </div> -->
            <div class="card-body" >
                <div class="row">
                    <div class="col-md-3">
                        <div class="card_info" style="background:#FFF">
                            <div class="col-lg-12">
                                <div class="font-19" style="color: #1a329a;">
                                    <b>สะสม
                                        <?php echo $Mydate->date_eng2thai($start_date_label_past, 543, 'S', 'S') ?>
                                        -
                                        <?php echo $Mydate->date_eng2thai($end_date_label_past, 543, 'S', 'S') ?></b>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="px-3" style="background-color: #1a329a;">
                                    <div class="text-white text-right font-19">
                                        <?php echo number_format($SumMonthData_past) ?> คน
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card_info" style="background:#FFF">
                            <div class="col-lg-12">
                                <div class="font-19" style="color: #b49f5f;">
                                    <b>สะสม
                                        <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?>
                                        -
                                        <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?></b></b>
                                </div>
                            </div>
                            <div class="col-lg-12" style="padding:5px">
                                <div class="px-3" style="background-color: #f4d770;">
                                    <div class="text-white text-right font-19"
                                        style="color: black;">
                                        <b style="color: black;"><?php echo number_format($SumMonthData)?>

                                            คน</b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="px-3">
                                    <div class="text-white text-right font-21"
                                        style="color: #f4d770;">
                                        <b class="font-19" style="color: #344996;">Change</b> <?php
                    if ($SumMonthData_past > 0) {
                        $percent = number_format(($SumMonthData - $SumMonthData_past)  / $SumMonthData_past  * 100, 2);
                        if ($SumMonthData > $SumMonthData_past) {
                            echo '<span style="color:green">+' . $percent . '%</span>';
                        } else {
                            echo '<span style="color:red">-' . $percent * (-1) . '%</span>';
                        }
                    } else {
                        echo '-';
                    } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card_info"  style="background:#FFF; margin-top:20px ;">
                            <div class="col-lg-12">
                                <div class="font-19" style="color: #a98f44;">
                                    <b> สะสมรายสัปดาห์ <br><?php echo $Mydate->date_eng2thai($prev_date, 543, 'S', 'S') ?>
                                        -
                                        <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?></b>
                                </div>
                            </div>
                            <div class="col-lg-12" style="padding:5px">
                                <div class="px-3" style="background-color: #f4d770;">
                                    <div class="text-right font-19" style="color: black;">
                                        <b><?php echo number_format($SumWeekData) ?> คน</b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="px-3">
                                    <div class="text-white text-right font-19">
                                        <b class="font-19" style="color: #344996;">WoW</b> <?php
                if ($SumWeekData_past > 0) {
                    $percent = number_format(($SumWeekData - $SumWeekData_past)  / $SumWeekData_past  * 100, 2);
                    if ($SumWeekData > $SumWeekData_past) {
                        echo '<b style="color:green">+' . $percent . '%</b>';
                    } else {
                        echo '<b style="color:red">-' . $percent * (-1) . '%</b>';
                    }
                } else {
                    echo '-';
                } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-9">
                        <div class="row" style="margin-top:0">
                                <div class="col-lg-6">
                                    <div class="card_info"  style="background:#FFF">
                                        <div class="box-shadow" style=" border-radius: 15px;">
                                            <div class="row">
                                                <div class="col-lg-12  my-auto" style=" overflow: hidden;">
                                                    <div class="row m-0 my-auto" style="">
                                                        <div class="col-lg-8 my-auto">
                                                            <div class="font-17">
                                                                <b style="color:#36BA98">ด่านอากาศ :
                                                                    <?php echo number_format($SumPortType[1]['NUM']); ?>
                                                                    คน</b>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 text-center">
                                                            <div class="font-17">
                                                                <b style="color:#36BA98"><?php echo
                                                                    number_format($SumPortType[1]['NUM']/($SumPortType[1]['NUM']+$SumPortType[0]['NUM'])*100,2);
                                                                    ?>%</b>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-8">
                                                            <div class="font-17">
                                                                <b style="color:#1679AB">ไม่ใช่ด่านอากาศ :
                                                                    <?php echo number_format($SumPortType[0]['NUM']); ?>
                                                                    คน</b>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 text-center">
                                                            <div class="font-17">
                                                                <b
                                                                    style="color:#1679AB"><?php echo number_format($SumPortType[0]['NUM']/($SumPortType[1]['NUM']+$SumPortType[0]['NUM'])*100,2); ?>%</b>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6" >
                                    <div class="text-right" style="padding-top:20px;">
                                    <?php
                                        $flag = base_url('public/img/logotat.png');

                                        if (!file_exists(base_url('public/img/flag/' . $country_id . '.png'))) {
                                            $flag = base_url('public/img/flag/' . $country_id . '.png');
                                        }
                                        ?>
                                                <b style="font-size: 22px;color: #1a329a;"> สัญชาติ <?php echo $country[$country_id] ?></b>
                                                <img class="img-profile rounded-circle" src="<?php echo $flag ?>"
                                                    style="width: 80px;">
                                    </div>
                                </div>
                            </div>
                        <div class="text-center" id="htmltoimage_chart_country" style="padding:5px; background: #FFF; border-radius: 15px; font-family: 'TATSana-Chon', sans-serif;">

                            <div id="chart_country" style="height:285px !important"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="background-color: #0a1b54;color: white; font-size: 11px;">
                        หมายเหตุ : <br>1. ข้อมูลจำแนกรายสัญชาติ (Nationality) ที่มีการกำหนดหลักเกณฑ์การคำนวณนักท่องเที่ยวระหว่างประเทศ
(สามารถอ่านเพิ่มเติมได้ที่นิยามในระบบฯ) <br>
2. ข้อมูลรวมสะสมในระบบมีความแตกต่างจากข้อมูลรวมสะสมของกระทรวงการท่องเที่ยวและกีฬา ประมาณร้อยละ 1-3 เนื่องจากมีการ Cleansing ข้อมูลรายเดือน และยังไม่นับรวมนักท่องเที่ยวที่เดินทางเข้าประเทศไทยโดยใช้ Border Pass<br>
                        3. WoW (Week on Week) หมายถึง อัตราการเปลี่ยนแปลงเทียบกับสัปดาห์ก่อนหน้า
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


    Highcharts.chart('chart_country', {

        chart: {
            scrollablePlotArea: {
                minWidth: 700
            },
            backgroundColor: 'rgba(0,0,0,0)',
            style: {
                fontFamily: 'TATSana-Chon'
            }
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
            labels: {
            formatter: function() {
                    var date = new Date(this.value);
                    var day = Highcharts.dateFormat('%A', this.value); // get the day of the week
                    if (day === 'Monday') {
                        return Highcharts.dateFormat('%d/%m', this.value) + ' (Monday)';
                    }
                    return Highcharts.dateFormat('%d/%m', this.value); // default format
                }
            }
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
                        '<td style="text-align: right;color: ' + point.series.color + '"><b>' +
                        Highcharts.numberFormat(point.y, 0, '.', ',') + '</b></td></tr>'
                    )).join('') +
                    '</table>';
            }
        },
        <?php echo "series: " . str_replace('"', '', $highchartsData); ?>

    });


});



function SaveImg2ExportPdf(url2SaveImg, url2DowloadReport) {
    $('.btn-download').hide();
    setTimeout(function() {
        saveImg(url2SaveImg, url2DowloadReport);
    }, 1000);
    $.ajax({
        method: "POST",
        url: base_url + "/main/saveLog",
        data: {
            'type': 'country'
        },
        success: function(res) {

        }
    });
}

function saveImg(url2SaveImg, url2DowloadReport) {
    

    $('.btn-download').hide();
    const chart_array = ["chart_country"];
    var count_canvas = 0;
    var country_select = $('#country_select').val();
    $.each(chart_array, function(key, value) {
        var container = document.getElementById("htmltoimage_" + value);
        document.getElementById("htmltoimage_"+value).style.fontFamily = 'TATSana-Chon, sans-serif';
        html2canvas(container, {
            allowTaint: true,
            useCORS: true 
        }).then(function(canvas) {

            var link = document.createElement("a");
            document.body.appendChild(link);
            link.download = "<?php echo $end_date_label; ?>" + value + country_select + ".jpg";
            link.href = canvas.toDataURL();
            link.target = '_blank';


            var dataURL = link.href;
            $.post(url2SaveImg, {
                imgBase64: dataURL,
                imgName: "<?php echo $end_date_label; ?>" + value + country_select
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
        if (date == '') {
            $('#start_date').focus();
            $('#start_date').css("border-color", "#e74a3b");
            return false;
        }
        date = date.split('/');
        start_date = date[0] + '-' + date[1] + '-' + (date[2] - 543);

        var date = $('#end_date').val();
        if (date == '') {
            $('#end_date').focus();
            $('#end_date').css("border-color", "#e74a3b");
            return false;
        }
        date = date.split('/');
        end_date = date[0] + '-' + date[1] + '-' + (date[2] - 543);
        window.location.href = base_url + '/main/country?start_date=' + start_date + '&end_date=' + end_date +
            '&country_id=' + country_id;
    } else {
        window.location.href = base_url + '/main/country?country_id=' + country_id;
    }

}

function ClearFilter() {
    window.location.href = base_url + '/main/daily';
}
</script>
<?= $this->endSection() ?>