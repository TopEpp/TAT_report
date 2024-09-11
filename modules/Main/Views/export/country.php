<?php include_once("export_css.php"); ?>
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

.card_info {
    border-radius: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    background-color: white;
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

.col4 {
    width: 34%;
    float: left;
    padding-top: 1%;
}

.col8 {
    width: 66%;
    float: left;
    padding-top: 1%;
}

.col6 {
    width: 50%;
    float: left;
    /* padding-top: 1%; */
}

.col12 {
    width: 100%;
    float: left;
}

.thickOutlined {
    font-size: 30px;
    color: #0a1b54;
    text-shadow: 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px#e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed, 0 0 4px #e9e8ed;
}
</style>
<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>


<div class="row" style="padding-top: 80px;">
    <div class="col-md-12">
        <div class=""
            style="background-position: center;background-size: cover;background-image: url(<?php echo base_url('public/img/bg_report_country_2.png') ?>);background-repeat: no-repeat;">
            <!-- <div class="card-header">  </div> -->
            <div class="card-body" style="">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 20%;text-align: center;">
                            <img class="height-img-left" style="height: 70px;"
                                src="<?php echo base_url('public/img/TATIC-Logo.png') ?>" alt="">
                        </td>
                        <td style="width: 60%; text-align: center;">
                            <b data-content="สถิติการท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย"
                                class="thickOutlined">
                                สถิติการท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย
                            </b><br>
                            <table style="width: 100%;">
                                <tr>
                                    <td>
                                        <div class="text-center" style="color: #4f70b4;">
                                            <b>ที่มา : สำนักงานตรวจคนเข้าเมือง</b>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center" style="color:#4f70b4">
                                            <b>จัดทำโดย ด้านดิจิทัล วิจัยและพัฒนา</b>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 20%;text-align: center;">
                            <img class="height-img-left" style="height: 70px;"
                                src="<?php echo base_url('public/img/amazingTH-Logo-04.png') ?>" alt="">
                        </td>
                    </tr>
                </table>
                <div class="col4">
                    <div style="margin: 20px; margin-left:7px; margin-top:5px; margin-bottom: 0px;">
                        <div class="card_info"
                            style="padding: 8px;  border:none; border-radius:14px; box-shadow: 0px 1px 1px 2px hsl(0, 15%, 70%); overflow: hidden;">
                            <div style="margin-left: 10px; margin-right: 10px;">
                                <b style="margin: 0px; font-size:20px;color: #1a329a;">สะสม
                                    <?php echo $Mydate->date_eng2thai($start_date_label_past, 543, 'S', 'S') ?>
                                    -
                                    <?php echo $Mydate->date_eng2thai($end_date_label_past, 543, 'S', 'S') ?></b>
                            </div>
                            <div
                                style="background-color: #1a329a;font-size:20px;color: white; text-align: right;margin-left: 10px; margin-right: 10px;">
                                <div style="margin-right: 5px;">
                                    <b><?php echo number_format($SumMonthData_past)?> คน</b>
                                </div>
                            </div>
                        </div>
                        <div class=" card_info"
                            style="padding: 0px; border:none; border-radius:14px; box-shadow: 0px 1px 1px 2px hsl(0, 15%, 70%);overflow: hidden;">
                            <div style="margin-left: 10px; margin-right: 10px;">
                                <b style="margin: 0px; font-size:21px;color: #b49f5f;">
                                    สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?>
                                    -
                                    <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?></b>
                            </div>
                            <div
                                style=" background-color: #f4d770;font-size:22px;color: black; text-align: right;margin-left: 10px; margin-right: 10px;">
                                <div style="margin-right: 5px;">
                                    <b style="line-height: normal;"><?php echo number_format($SumMonthData)?> คน</b>
                                </div>

                            </div>
                            <div style="font-size:22px;text-align: right;margin-left: 10px; margin-right: 10px;">
                                <b style="color: #344996;">
                                    Change
                                </b> <?php
							if ($SumMonthData_past > 0) {
								$percent = number_format(($SumMonthData-$SumMonthData_past)  / $SumMonthData_past  * 100, 2);
								if ($SumMonthData > $SumMonthData_past) {
									echo '<b style="color:green;font-size:20px">+' . $percent . '%</b>';
								} else {
									echo '<b style="color:red;font-size:20px">-' . $percent*(-1) . '%</b>';
								}
							} else {
								echo '-';
							} ?>
                            </div>
                        </div>
                        <div class=" card_info"
                            style="padding: 0px; border:none; border-radius:14px; box-shadow: 0px 1px 1px 2px hsl(0, 15%, 70%);overflow: hidden;">
                            <div style="margin-left: 10px; margin-right: 10px;">
                                <b style="margin: 0px; line-height:none; font-size:21px;color:#a98f44 ;">
                                    <?php echo $Mydate->date_eng2thai($prev_date, 543, 'S', 'S') ?> -
                                    <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?></b>
                            </div>
                            <div
                                style="background-color: #f4d770;font-size:22px;color: white; text-align: right;margin-left: 10px; margin-right: 10px;">
                                <div style="margin-right: 5px; color:black">
                                    <b><?php echo number_format($SumWeekData)?> คน</b>
                                </div>

                            </div>
                            <div style="font-size:22px;text-align: right;margin-left: 10px; margin-right: 10px;">

                                <b style="color: #344996;">WoW</b><?php
							if ($SumWeekData_past > 0) {
								$percent = number_format(($SumWeekData-$SumWeekData_past)  / $SumWeekData_past  * 100, 2);
								if ($SumWeekData > $SumWeekData_past) {
									echo '<b style="color:green">+' . $percent . '%</b>';
								} else {
									echo '<b style="color:red">-' . $percent*(-1) . '%</b>';
								}
							} else {
								echo '-';
							} ?>
                            </div>
                        </div>
                        

                    </div>
                </div>
                <div class="col8">
                    <div class="row">
                        <div class="col6">
                            <div class="card"
                            style="margin-left: 15px;height: 63px; padding: 8px; border:none; border-radius:14px; box-shadow: 0px 1px 1px 2px hsl(0, 15%, 70%);overflow: hidden;width: 400px;">
                                    <table style="width: 100%;margin-top: 5px;">
                                        <tr>
                                            <td>
                                                <b style="margin: 0px; font-size:18px;color:#36BA98">
                                                    ด่านอากาศ :
                                                    <?php echo number_format($SumPortType[1]['NUM']);?> คน</b>
                                            </td>
                                            <td style="text-align: right;font-size:18px;color:#36BA98">
                                                <b><?php echo number_format($SumPortType[1]['NUM']/($SumPortType[1]['NUM']+$SumPortType[0]['NUM'])*100,2); ?>%</b>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <table style="width: 100%;">
                                        <tr>
                                            <td>
                                                <b style=" margin: 0px; font-size:18px;color:#1679AB">
                                                    ไม่ใช่ด่านอากาศ : <?php echo number_format($SumPortType[0]['NUM']);?>
                                                    คน
                                                </b>
                                            </td>
                                            <td style="text-align: right;font-size:18px;color:#1679AB">
                                                <b>
                                                    <?php echo number_format($SumPortType[0]['NUM']/($SumPortType[1]['NUM']+$SumPortType[0]['NUM'])*100,2); ?>%
                                                </b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                        </div>
                        <div class="col6">
                                <?php 
                                    $flag = base_url('public/img/logotat.png');

                                    if (!file_exists(base_url('public/img/flag/' . $country_id . '.png'))) {
                                        $flag = base_url('public/img/flag/' . $country_id . '.png');
                                    }
                                 ?>
                                 <div style="text-align:right;width: 100%;margin-top: 17px; margin-right: 17px;">
                                    <b style="font-size: 22px;color: #1a329a;">สัญชาติ
                                        <?php echo $country[$_GET['country_id']] ?>
                                    </b> 
                                    <img class=" img-profile rounded-circle" src="<?php echo $flag ?>" style="width: 80px;">
                                </div>
                        </div>
                    </div>
                   
                    <div>
                        <div>
                            <div class="text-center" id="htmltoimage_chart_country" style="padding:5px;margin-top: 5px;">
                                <div style="border-radius:14px; overflow: hidden; background-color: white;">
                                    <div style="padding:5px">
                                        <img style="height:250px;width:100%;"
                                    src="<?php echo base_url('public/uploads/main/' . $to_date . 'chart_country'.$country_id.'.png') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col12">
            <div style="background-color: #0a1b54;padding: 10px; color: white; font-size: 17px;">
                หมายเหตุ : ข้อมูลสัญชาติ (Nationality) ที่ไม่นับรวมข้อมูลผู้อพยพ , หน่วยงานพิเศษ UN ,
                ไม่มีสัญชาติ <br>
                WoW (Week on Week) หมายถึง อัตราการเปลี่ยนแปลงเทียบกับสัปดาห์ก่อนหน้า
            </div>
        </div>
    </div>
</div>
</div>