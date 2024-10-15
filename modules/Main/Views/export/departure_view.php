<link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.css') ?>">
<link href="<?php echo base_url('public/vendor/fontawesome-free/css/all.css') ?>" rel="stylesheet" type="text/css">

<style>
:root {
    --blue: #0E66AE;
    --indigo: #6610f2;
    --purple: #6f42c1;
    --pink: #e83e8c;
    --red: #e74a3b;
    --orange: #fd7e14;
    --yellow: #f6c23e;
    --green: #1cc88a;
    --teal: #20c9a6;
    --cyan: #36b9cc;
    --white: #fff;
    --gray: #858796;
    --gray-dark: #5a5c69;
    --primary: #0E66AE;
    --secondary: #858796;
    --success: #1cc88a;
    --info: #36b9cc;
    --warning: #f6c23e;
    --danger: #e74a3b;
    --light: #f8f9fc;
    --dark: #5a5c69;
    --breakpoint-xs: 0;
    --breakpoint-sm: 576px;
    --breakpoint-md: 768px;
    --breakpoint-lg: 992px;
    --breakpoint-xl: 1200px;
    --font-family-sans-serif: "TATSana-Chon", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}

@font-face {
    font-family: 'TATSana-Chon';
    src: url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.eot')?>');
    /* IE9 Compat Modes */
    src: url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.eot?#iefix')?>') format('embedded-opentype'),
        /* IE6-IE8 */
        url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.woff')?>') format('woff'),
        /* Modern Browsers */
        url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.ttf')?>') format('truetype'),
        /* Safari, Android, iOS */
        url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.svg#svgFontName')?>') format('svg');
    /* Legacy iOS */
}

body {
    margin: 0;
    font-family: "TATSana-Chon", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";

}

#CartItem {
    display: flex !important;
    flex-direction: row !important;
}

.col3 {
    width: 30%;
}

.vl {
    border-left: 3px solid white;
    border-left-style: dashed;
    top: 425px;
    height: 270px;
    position: absolute;
    left: 557px;
}

.col1 {
    width: 10%;
    float: left;
}

.col4 {
    width: 20%;
    float: left;
    padding-top: 1%;
}

.col8 {
    width: 80%;
    float: left;
    padding-top: 1%;
}

.col6 {
    width: 50%;
    float: left;
    /* padding-top: 1%; */
}

.col11 {
    width: 90%;
    float: left;
}

.col12 {
    width: 100%;
    float: left;
}

#resultsTableForCard2 {
    width: 200px;
    height: 100px;
    background: #fff1cc;
    border-radius: 12px !important;
    margin: auto auto;
}

#resultsTableForCard {
    width: 200px;
    height: 100px;
    background: #a7ffff;
    overflow: hidden !important;
    border-radius: 12px !important;
    margin: auto auto;
}

#resultsTable {
    height: 470px;
    width: 230px;
    background: #73A0E0;
    overflow: hidden;
    border-radius: 25px !important;
    /* margin: 0px 0px 0px 0px */
    /* position: absolute; */
}

#resultsTable2 {
    height: 470px;
    width: 230px;
    background: #DDC354;
    overflow: hidden;
    border-radius: 25px !important;
    /* margin: 0px 0px 0px auto; */
}

#resultsTableMarket {
    height: 210px;
    width: 210px;
    background: #a7ffff;
    overflow: hidden;
    border-radius: 25px !important;
    margin: 0px auto;
    /* position: absolute; */
}

#resultsTableMarket1 {
    height: 180px;
    width: 210px;
    background: #73A0E0;
    overflow: hidden;
    border-radius: 25px !important;
    margin: 0px auto;
}

#resultsTableMarket2 {
    height: 180px;
    width: 210px;
    background: #DDC354;
    overflow: hidden;
    border-radius: 25px !important;
    margin: 0px auto;
}

#resultsTable3 {
    height: 20px;
    width: 300px;
    background: white;
    overflow: hidden;
    border-radius: 6px !important;
    margin: auto auto;
    box-shadow: 0px 5px 8px 0px hsl(0, 7%, 50%);
}



#resultsTable4 {
    height: 35px;
    width: 230px;
    background: #73A0E0;
    overflow: hidden;
    border-radius: 28px !important;
    /* margin: 0px auto; */

}

#resultsTable5 {
    height: 35px;
    width: 230px;
    background: #DDC354;
    overflow: hidden;
    border-radius: 28px !important;
    /* margin: auto auto; */
}

.backgroundColorBox1 {
    background-color: #73A0E0;
    border-bottom-left-radius: 18px;
    border-bottom-right-radius: 18px;
}

.colorText {
    color: #163868;
}

.colorTextLeft {
    color: #049B97;
}

.btn {
    cursor: pointer;
}

.btn_Color {
    background-color: #3eabae;
    color: white;
    width: 100%;
}

.btn-danger {
    color: #fff;
    background-color: #e74a3b;
    border-color: #e74a3b;
}

#rotate-text {
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    transform: rotate(90deg);
}

.d-flex {
    line-height: 1.2em;
}


.header-table {
    background-color: #dae0f2;
    padding: 0px !important;
}

#htmltoimage_info_dashboard {
    width: 1230px;
}

table,
th,
td {
    border: 2px solid black;
}

@media (max-width: 576px) {}
</style>
<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>

<body style="width:1150px; height: 680px;margin: auto;">
    <div class=" row" style="margin: 0px;">
        <div class="col-lg-1 col-12 text-center text-md-right">
            <img class="img-profile " src="<?php echo base_url('public/img/tat.png') ?>" width="100px">
        </div>
        <div class="col-lg-11 col-12  my-md-auto text-center text-md-right my-3">
            <div>
                <button type="button"
                    onclick="SaveImg2ExportImg('<?php echo base_url('main/saveImg2Report'); ?>','png')"
                    class="btn btn-info">
                    <i class="fa-solid fa-file-image"></i> PNG
                </button>
                <button type="button"
                    onclick="SaveImg2ExportImg('<?php echo base_url('main/saveImg2ReportJPG'); ?>','jpg')"
                    class="btn btn-info">
                    <i class="fa-solid fa-file-image"></i> JPG
                </button>
                <button type="button"
                    onclick="window.open('<?php echo base_url('main/export_departure?export=pdf&start_date=' . $start_date . '&end_date=' . $end_date); ?>')"
                    class="btn btn-danger SetWidthbtnExport shadow-1">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                </button>
            </div>
        </div>
    </div>
    <div id="htmltoimage_info_dashboard">
        <div class="row">
            <div class=" col-md-12">
                <div class="card pb-3" style=" background-color: #214c78;">
                    <div class="p-2 mx-2"
                        style="background-color: orange; font-size: 20px; text-align: center;color: white; margin-top:10px;margin-bottom: 10px;">
                        <b>
                            สถิติคนไทยเดินทางออกนอกราชอาณาจักรในภาพรวม
                        </b>
                    </div>
                    <div class="mx-2">
                        <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure1.png') ?>"
                            style="width:100%;height:320px;">
                    </div>
                    <div class="mx-2 my-2">
                        <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure2.png') ?>"
                            style="width:100%;height:240px;">
                    </div>
                    <div class="my-2 mx-2" style="background-color: white;">
                        <table class="table  mb-0 " border="1">
                            <tr>
                                <th style="text-align: center;" class="header-table">ปี</th>
                                <?php   for ($i=1; $i <= 12; $i++) {  ?>
                                <th style="text-align: center;" class="header-table">
                                    <?php echo $shortmonth[$i]; if($check_noti_month==$i){ echo ' *';} ?></th>
                                <?php } ?>
                                <th style="text-align: center;" class="header-table">รวม</th>
                            </tr>
                            <tr>
                                <td class="p-1" align="center" style="background-color: #1e3660;color:white;">
                                    <b> <?php echo $year-1?></b>
                                </td>
                                <?php for ($i=0; $i <= 11; $i++) { @$sum_past +=$SumChartDataYear['past'][$i]; ?>
                                <td class="p-1" align="center" style="color: #1e3660;">
                                    <b><?php echo @number_format($SumChartDataYear['past'][$i])?></b>
                                </td>
                                <?php } ?>
                                <td class="p-1" align="center" style="color: #1e3660;">
                                    <b><?php echo number_format($sum_past)?></b>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-1" align="center" style="background-color: #de6713;color: white;">
                                    <b><?php echo $year?></b>
                                </td>
                                <?php for ($i=0; $i <= 11; $i++) { @$sum_current +=$SumChartDataYear['current'][$i]; ?>
                                <td class="p-1" align="center" style="color: #de6713;">
                                    <b>
                                        <?php echo !empty(number_format(@$SumChartDataYear['current'][$i]))?@number_format($SumChartDataYear['current'][$i]):'';?></b>
                                </td>
                                <?php } ?>
                                <td class="p-1" align="center" style="color: #de6713;">
                                    <b><?php echo number_format($sum_current)?></b>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-1" align="center"><b>+/- (%)</b></td>
                                <?php for ($i=0; $i <= 11; $i++) { $percent = '';
							if(!empty($SumChartDataYear['current'][$i])){
								$percent = number_format(($SumChartDataYear['current'][$i]-$SumChartDataYear['past'][$i])  / $SumChartDataYear['past'][$i]  * 100, 2);
							}

							 ?>
                                <td class="p-1" align="center">
                                    <b><?php  echo $percent!=''?number_format($percent,2):$percent;?></b>
                                </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td class="p-1" colspan="14" class="header-table">
                                    <b>จำนวนคนไทยเดินทางออกเฉลี่ยต่อวัน</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-1" align="center" style="background-color: #1e3660;color: white ;">
                                    <b> <?php echo $year-1?></b>
                                </td>
                                <?php $sum_days_past =0; for ($i=0; $i <= 11; $i++) { 
							$days = cal_days_in_month(CAL_GREGORIAN, $i+1, $year-1);
							$sum_days_past += $days;
							@$sum_past_day +=$SumChartDataYear['past'][$i]; 
							 ?>
                                <td class="p-1" align="center" style="color: #1e3660;">
                                    <b> <?php echo @number_format($SumChartDataYear['past'][$i]/$days)?></b>
                                </td>
                                <?php } ?>
                                <td class="p-1" align="center" style="color: #1e3660;">
                                    <b><?php echo number_format($sum_past_day/$sum_days_past)?></b>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-1" align="center" style="background-color: #de6713;color: white ;">
                                    <b> <?php echo $year?></b>
                                </td>
                                <?php $sum_days=0; for ($i=0; $i <= 11; $i++) { 
							$days = cal_days_in_month(CAL_GREGORIAN, $i+1, $year);
							if(!empty($SumChartDataYear['current'][$i])){
								$sum_days += $days;
							}
							@$sum_current_day +=$SumChartDataYear['current'][$i] ?>
                                <td class="p-1" align="center" style="color: #de6713;">
                                    <b><?php echo !empty($SumChartDataYear['current'][$i])?@number_format($SumChartDataYear['current'][$i]/$days):'';?></b>
                                </td>
                                <?php } ?>
                                <td class="p-1" align="center" style="color: #de6713;">
                                    <b><?php echo number_format($sum_current_day/$sum_days)?></b>
                                </td>
                            </tr>
                        </table>
                        <div>
                            <?php echo $check_noti_month_label;?>
                        </div>
                    </div>
                    <div class="mx-2">
                        <div class="row">
                            <div class="col-lg-3 pr-0">
                                <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure3.png') ?>"
                                    style="width:100%;height:300px;">
                            </div>
                            <div class="col-lg-9 pl-1 ">
                                <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure4.png') ?>"
                                    style="width:100%;height:300px;">
                            </div>
                        </div>
                    </div>
                    <div class="p-2 mx-2"
                        style="background-color: orange; font-size: 20px; text-align: center;color: white; margin-top:10px;margin-bottom: 10px;">
                        <b>
                            สถิติคนไทยเดินทางออกนอกราชอาณาจักรทาง<u>ท่าอากาศยาน</u>
                        </b>
                    </div>
                    <?php $sum_past=$sum_current=0;?>
                    <div class="text-center mx-2" id="htmltoimage_chart_departure5" style="height:230px; ">
                        <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure5.png') ?>"
                            style="width:100%;height:240px;">
                    </div>
                    <div class="mx-2" style="background-color: white;">
                        <table class="table mb-0 ">
                            <tr>
                                <th class="p-0 header-table" style="text-align: center;">ปี</th>
                                <?php   
						
						for ($i=1; $i <= 12; $i++) { 
						?>
                                <th class="p-0 header-table" style="text-align: center;">
                                    <b><?php echo $shortmonth[$i]; if($check_noti_month==$i){ echo ' *';}?></b>
                                </th>
                                <?php } ?>
                                <th class="p-0 header-table" style="text-align: center;">รวม</th>
                            </tr>
                            <tr>
                                <td class="p-0" align="center" style="background-color: #1e3660; color:white">
                                    <b> <?php echo $year-1?></b>
                                </td>
                                <?php for ($i=0; $i <= 11; $i++) { @$sum_past +=$SumChartDataYear_Air['past'][$i]; ?>
                                <td class="p-0" align=" center" style="color: #1e3660;">
                                    <b><?php echo @number_format($SumChartDataYear_Air['past'][$i])?></b>
                                </td>
                                <?php } ?>
                                <td class="p-0" align=" center" style="color: #1e3660;">
                                    <b><?php echo number_format($sum_past)?></b>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0" align="center" style="background-color: #de6713; color: white ;">
                                    <b> <?php echo $year?></b>
                                </td>
                                <?php for ($i=0; $i <= 11; $i++) { @$sum_current +=$SumChartDataYear_Air['current'][$i]; ?>
                                <td class="p-0" align="center" style="color: #de6713;">
                                    <b><?php echo !empty($SumChartDataYear_Air['current'][$i])?@number_format($SumChartDataYear_Air['current'][$i]):'';?></b>
                                </td>
                                <?php } ?>
                                <td class="p-0" style="color: #de6713;" align="center">
                                    <b><?php echo number_format($sum_current)?></b>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0" align="center"><b>+/- (%)</b></td>
                                <?php for ($i=0; $i <= 11; $i++) { $percent = '';
							if(!empty($SumChartDataYear_Air['current'][$i])){
								$percent = number_format(($SumChartDataYear_Air['current'][$i]-$SumChartDataYear_Air['past'][$i])  / $SumChartDataYear_Air['past'][$i]  * 100, 2);
							}

							 ?>
                                <td class="p-0" align="center">
                                    <b> <?php  echo $percent!=''?number_format($percent,2):$percent;?></b>
                                </td>
                                <?php } ?>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="p-1" colspan="14"><b>จำนวนคนไทยเดินทางออกเฉลี่ยต่อวัน</b></td>
                            </tr>
                            <tr>
                                <td class="p-1" align="center" style="background-color: #1e3660;color: white;">
                                    <b><?php echo $year-1?></b>
                                </td>
                                <?php $sum_past_day = $sum_days_past =0; for ($i=0; $i <= 11; $i++) { 
							$days = cal_days_in_month(CAL_GREGORIAN, $i+1, $year-1);
							$sum_days_past += $days;
							@$sum_past_day +=$SumChartDataYear_Air['past'][$i]; 
							 ?>
                                <td class="p-1" align="center" style="color: #1e3660;">
                                    <b><?php echo @number_format($SumChartDataYear_Air['past'][$i]/$days)?></b>
                                </td>
                                <?php } ?>
                                <td class="p-1" align="center" style="color: #1e3660;">
                                    <b><?php echo number_format($sum_past_day/$sum_days_past)?></b>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-1" align="center" style="background-color: #de6713;color: white;">
                                    <b><?php echo $year?></b>
                                </td>
                                <?php $sum_current_day =$sum_days=0; for ($i=0; $i <= 11; $i++) { 
							$days = cal_days_in_month(CAL_GREGORIAN, $i+1, $year);
							if(!empty($SumChartDataYear_Air['current'][$i])){
								$sum_days += $days;
							}
							@$sum_current_day +=$SumChartDataYear_Air['current'][$i] ?>
                                <td class="p-0" align="center" style="color: #de6713;">
                                    <b><?php echo !empty($SumChartDataYear_Air['current'][$i])?@number_format($SumChartDataYear_Air['current'][$i]/$days):'';?></b>
                                </td>
                                <?php } ?>
                                <td class="p-0" align="center" style="color: #de6713;">
                                    <b><?php echo number_format($sum_current_day/$sum_days)?></b>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0 px-1" colspan="14"><b>สัดส่วนคนไทยเดินทางออกทางท่าอากาศยานต่อภาพรวม
                                        (%)</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0" align="center" style="background-color: #1e3660;color: white;">
                                    <b><?php echo $year-1?></b>
                                </td>
                                <?php $sum_past = $sum_past_air = 0; for ($i=0; $i <= 11; $i++) { 
							$percent = '';
							$sum_past += @$SumChartDataYear['past'][$i];
							$sum_past_air += @$SumChartDataYear_Air['past'][$i];
							if(!empty($SumChartDataYear_Air['past'][$i])){
								$percent = number_format($SumChartDataYear_Air['past'][$i] / $SumChartDataYear['past'][$i]  * 100, 2);
							}
						?>
                                <td class="p-0" align="center" style="color: #1e3660;">
                                    <b><?php echo $percent!=''?number_format($percent,2):'';?></b>
                                </td>
                                <?php } ?>
                                <td class="p-0" align="center" style="color: #1e3660;">
                                    <b> <?php echo number_format( $sum_past_air/$sum_past*100,2 )?></b>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-0" align="center" style="background-color: #de6713;color: white;">
                                    <?php echo $year?></td>
                                <?php $sum = $sum_air = 0; for ($i=0; $i <= 11; $i++) { 
							$percent = '';
							$sum += @$SumChartDataYear['current'][$i];
							$sum_air += @$SumChartDataYear_Air['current'][$i];
							if(!empty($SumChartDataYear_Air['current'][$i])){
								$percent = number_format($SumChartDataYear_Air['current'][$i] / $SumChartDataYear['current'][$i]  * 100, 2);
							}
						?>
                                <td class="p-0" align="center" style="color: #de6713;">
                                    <?php echo $percent!=''?number_format($percent,2):'';?>
                                </td>
                                <?php } ?>
                                <td class="p-0" align="center" style="color: #de6713;">
                                    <?php echo number_format($sum_air/$sum*100,2)?></td>
                            </tr>
                        </table>
                        <?php echo $check_noti_month_label;?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

<script src="<?= base_url('public/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('public/js/common.js'); ?>"></script>

<script src="<?= base_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('public/vendor/bootstrap/datepicker/bootstrap-datepicker.js') ?>"></script>
<script src="<?= base_url('public/vendor/bootstrap/datepicker/locales/bootstrap-datepicker.th.js') ?>"></script>
<script src="<?= base_url('public/vendor/bootstrap/datepicker/bootstrap-datepicker-thai.js') ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('public/vendor/datatables/jquery.dataTables.js') ?>"></script>


<!-- Page level custom scripts -->
<script src="<?= base_url('public/js/sb-admin-2.min.js'); ?>"></script>
<script src="<?= base_url('public/js/jquery.toast.js'); ?>"></script>

<script src="<?= base_url('public/vendor/Sweetalert/js/sweetalert2.min.js'); ?>"></script>
<script src="<?= base_url('public/js/main.js'); ?>"></script>
<script src="<?= base_url('public/js/scripts.js'); ?>"></script>
<script src="<?php echo base_url('public/vendor/html2canvas/html2canvas.js'); ?>"></script>
<script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';

function SaveImg2ExportImg(url2SaveImg, type) {
    $('.btn-download').hide();
    $('#htmltoimage_chart_daily_year').show();
    setTimeout(function() {
        saveImg(url2SaveImg, type);
    }, 1000);
}

function saveImg(url2SaveImg, type) {
    const chart_array = ["info_dashboard"];
    var count_canvas = 0;
    $.each(chart_array, function(key, value) {
        var container = document.getElementById("htmltoimage_" + value);
        html2canvas(container, {
            allowTaint: true
        }).then(function(canvas) {

            var link = document.createElement("a");
            document.body.appendChild(link);
            link.download = "<?php echo $to_date; ?>" + value + ".png";
            link.href = canvas.toDataURL();
            link.target = '_blank';
            // console.log(link);
            var dataURL = link.href;
            var imgUrl = base_url + "/public/uploads/main/<?php echo $to_date; ?>" + value + "." + type;
            $.post(url2SaveImg, {
                imgBase64: dataURL,
                imgName: "<?php echo $to_date; ?>" + value
            }, function(data, status) {
                count_canvas++;
                console.log(imgUrl);


                if (count_canvas == chart_array.length) {
                    window.open(imgUrl);
                }

            });
        });

    });
}
</script>