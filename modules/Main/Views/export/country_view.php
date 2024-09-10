<?php $user_menu = $session->get('user_menu'); ?>
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
    src: url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.eot') ?>');
    /* IE9 Compat Modes */
    src: url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.eot?#iefix') ?>') format('embedded-opentype'),
        /* IE6-IE8 */
        url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.woff') ?>') format('woff'),
        /* Modern Browsers */
        url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.ttf') ?>') format('truetype'),
        /* Safari, Android, iOS */
        url('<?php echo base_url('public/font/tatsana_chon-reg-webfont.svg#svgFontName') ?>') format('svg');
    /* Legacy iOS */
}

body {
    margin: 0;
    font-family: "TATSana-Chon", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";

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

.text-stroke-color {
    color: black;
    -webkit-text-fill-color: #38446f;
    /* Will override color (regardless of order) */
    -webkit-text-stroke-width: 5px;
    -webkit-text-stroke-color: #c0c0c2;
    font-size: 30px;
}

.stroke-text {
    /* -webkit-text-stroke: 5px #c0c0c2;
		-webkit-text-fill-color: #38446f; */
    /* -webkit-text-fill-color: transparent; */
    text-shadow: 1px 3px 5px #c2c3c6;
    font-size: 40px;
}

.thickOutlined {
    font-size: 25px;
    color: #0a1b54;
    text-shadow: 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px#e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed;
}

#htmltoimage_info_dashboard {
    width: 1168px;
}

.height-img-right {
    width: 125px;
}

.height-img-left {
    width: 140px;
}

.height-body {
    height: 500px
}

.box-shadow {
    box-shadow: rgba(100, 100, 111, 0.4) 0px 7px 29px 0px;
    width: 100%;

    background-color: white !important;
    /* border-radius: 12px; */

}

.box-shadow-2 {
    box-shadow: rgba(100, 100, 111, 0.4) 0px 7px 29px 0px;
    width: 100%;
    background-color: white !important;
    height: 105px;
}

.font-19 {
    font-size: 19px;
}

.text-white {
    color: white;
}

.box-1 {
    /* background-color: white; */
    border-radius: 12px !important;
}

.font-21 {
    font-size: 21px;
}

.font-17 {
    font-size: 17px
}

.bg-footer {
    background-color: #0a1b54;
    color: white
}

.col3 {
    width: 30%;
}



@media (max-width: 576px) {}
</style>
<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>

<body style="width:1100px; margin: auto;">
    <div class="row" style="margin: 0px;">
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
                    onclick="window.open('<?php echo base_url('main/export_country?export=pdf&start_date=' . $start_date . '&end_date=' . $end_date . '&country_id=' . $country_id); ?>')"
                    class="btn btn-danger SetWidthbtnExport shadow-1">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                </button>
            </div>
        </div>
    </div>
    <div class="row" id="htmltoimage_info_dashboard">
        <div class="col-md-12 p-0">
            <div class="card"
                style="background-position: center;background-size: cover;background-image: url(<?php echo base_url('public/img/bg_report_country_2.png') ?>);background-repeat: no-repeat;">
                <!-- <div class="card-header">  </div> -->
                <div class="row m-0" style="opacity:1">
                    <div class="col-lg-2 text-center my-auto">
                        <img class="height-img-left" src="<?php echo base_url('public/img/TATIC-Logo.png') ?>" alt="">
                    </div>
                    <div class="col-lg-8 my-auto">
                        <div class="text-center my-auto">
                            <b data-content="สถิติการท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย"
                                class="thickOutlined">
                                สถิติการท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย
                            </b>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-center" style="color: #4f70b4;">
                                    <b>ที่มา : สำนักงานตรวจคนเข้าเมือง</b>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-center" style="color:#4f70b4">
                                    <b>จัดทำโดย ด้านดิจิทัล วิจัยและพัฒนา</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 text-center my-auto">
                        <img class="height-img-right" src="<?php echo base_url('public/img/amazingTH-Logo-04.png') ?>"
                            alt="">
                    </div>
                </div>

                <div class="height-body">
                    <div class="row m-0">
                        <div class="col-lg-4">
                            <div class="box-1 my-2" style="">
                                <div class="box-shadow" style="border-radius:15px;">
                                    <div class="row">
                                        <div class="col-lg-12 " style=" overflow: hidden;">
                                            <div class="row m-0" style="padding-top: 20px;padding-bottom: 20px;">
                                                <div class="col-lg-12">
                                                    <div class="font-21" style="color: #1a329a;">
                                                        <b>สะสม
                                                            <?php echo $Mydate->date_eng2thai($start_date_label_past, 543, 'S', 'S') ?>
                                                            -
                                                            <?php echo $Mydate->date_eng2thai($end_date_label_past, 543, 'S', 'S') ?></b>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="px-3" style="background-color: #1a329a;">
                                                        <div class="text-white text-right font-21">
                                                            <?php echo number_format($SumMonthData_past) ?> คน
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-1 my-2" style="">
                                <div class="box-shadow-2"  style="border-radius:15px;">
                                    <div class="row">
                                        <div class="col-lg-12 " style=" overflow: hidden;">
                                            <div class="row m-0" style="padding-top: 10px;">
                                                <div class="col-lg-12">
                                                    <div class="font-21" style="color: #b49f5f;">
                                                        <b>สะสม
                                                            <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?>
                                                            -
                                                            <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?></b></b>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="px-3" style="background-color: #f4d770;">
                                                        <div class="text-white text-right font-21"
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
                                                            <b class="font-21" style="color: #344996;">Change</b> <?php
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-1 my-2" style="">
                                <div class="box-shadow-2"  style="border-radius:15px;">
                                    <div class="row">
                                        <div class="col-lg-12 " style=" overflow: hidden;">
                                            <div class="row m-0" style="padding-top: 10px;">
                                                <div class="col-lg-12">
                                                    <div class="font-21" style="color: #a98f44;">
                                                        <b> <?php echo $Mydate->date_eng2thai($prev_date, 543, 'S', 'S') ?>
                                                            -
                                                            <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?></b>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="px-3" style="background-color: #f4d770;">
                                                        <div class="text-right font-21" style="color: black;">
                                                            <b><?php echo number_format($SumWeekData) ?> คน</b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="px-3">
                                                        <div class="text-white text-right font-21">
                                                            <b class="font-21" style="color: #344996;">WoW</b> <?php
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
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-8 my-auto">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="box-1 my-2" style="">
                                        <div class="box-shadow" style="height: 73px; border-radius: 15px;">
                                            <div class="row">
                                                <div class="col-lg-12  my-auto" style=" overflow: hidden;">
                                                    <div class="row m-0 my-auto" style="padding-top: 12px;">
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
                                                                <b style="color:#1679AB">ด่านบก :
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
                                                <b style="font-size: 22px;color: #1a329a;"> สัญชาติ <?php echo $country[$_GET['country_id']] ?></b>
                                                <img class="img-profile rounded-circle" src="<?php echo $flag ?>"
                                                    style="width: 80px;">
                                    </div>
                                </div>
                            </div>
                            

                            <div>
                                <div id="chart_country" style="height:300px !important">
                                    <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'chart_country' . $country_id . '.png') ?>"
                                        style="height: 250px; width: 750px; border-radius: 15px;">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 p-0 bg-footer">
                        <div class="p-3">
                            หมายเหตุ : ข้อมูลสัญชาติ (Nationality) ที่ไม่นับรวมข้อมูลผู้อพยพ , หน่วยงานพิเศษ UN ,
                            ไม่มีสัญชาติ <br>
                            WoW (Week on Week) หมายถึง อัตราการเปลี่ยนแปลงเทียบกับสัปดาห์ก่อนหน้า
                        </div>
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