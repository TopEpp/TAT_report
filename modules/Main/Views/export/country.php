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
    padding: 5px;
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
    width: 80%;
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
</style>
<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>


<div class="row">
    <div class="col-md-12">
        <div class="">
            <!-- <div class="card-header">  </div> -->
            <div class="card-body">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 20%;text-align: center;">
                            <img class="height-img-left" style="height: 50px;"
                                src="<?php echo base_url('public/img/TATIC-Logo.png') ?>" alt="">
                        </td>
                        <td style="width: 60%; text-align: center;">
                            <b style="font-size: 30px;">สถิติการท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย</b><br>
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
                            <img class="height-img-left" style="height: 50px;"
                                src="<?php echo base_url('public/img/amazingTH-Logo-04.png') ?>" alt="">
                        </td>
                    </tr>
                </table>
                <div class="col4" style="margin-top: 10px;">
                    <div>
                        <div class="card_info"
                            style="padding: 15px; border:none; border-radius:none; box-shadow: 0px 0px 4px 0px hsl(0, 7%, 70%)  0px 4px 0px 0px hsl(0, 7%, 70%);overflow: hidden;">
                            <div>
                                <b style="margin: 0px; font-size:20px">สะสม
                                    <?php echo $Mydate->date_eng2thai($start_date_label_past, 543, 'S', 'S') ?>
                                    -
                                    <?php echo $Mydate->date_eng2thai($end_date_label_past, 543, 'S', 'S') ?></b>
                            </div>
                            <div style="background-color: blue;font-size:20px;color: white; text-align: right;">
                                <b><?php echo number_format($SumMonthData_past)?> คน</b>
                            </div>
                        </div>
                    </div>
                </div>
                <table style="width: 100%;">
                    <tr>
                        <td>

                        </td>
                    </tr>
                </table>
                <div class="row m-0">
                    <div class="col-lg-2 text-center my-auto">

                    </div>
                    <div class="col-lg-8 my-auto">
                        <div class="text-center my-auto">
                            <span data-content="สถิติการท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย"
                                class="thickOutlined">

                            </span>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">

                            </div>
                            <div class="col-lg-6">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 text-center my-auto">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card_info">
                            สะสม <?php echo $Mydate->date_eng2thai($start_date_label_past, 543, 'S', 'S') ?> -
                            <?php echo $Mydate->date_eng2thai($end_date_label_past, 543, 'S', 'S') ?><br>
                            <?php echo number_format($SumMonthData_past)?> คน
                        </div>
                        <div class="card_info">
                            สะสม <?php echo $Mydate->date_eng2thai($start_date_label, 543, 'S', 'S') ?> -
                            <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?><br>
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
                            <?php echo $Mydate->date_eng2thai($prev_date, 543, 'S', 'S') ?> -
                            <?php echo $Mydate->date_eng2thai($end_date_label, 543, 'S', 'S') ?><br>
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
                                <div class="col-md-9">ด่านอากาศ :
                                    <?php echo number_format($SumPortType[1]['NUM']);?> คน
                                </div>
                                <div class="col-md-3" style="text-align:right; padding-left:0">
                                    <?php echo number_format($SumPortType[1]['NUM']/($SumPortType[1]['NUM']+$SumPortType[0]['NUM'])*100,2); ?>%
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">ด่านบก : <?php echo number_format($SumPortType[0]['NUM']);?>
                                    คน
                                </div>
                                <div class="col-md-3" style="text-align:right; padding-left:0">
                                    <?php echo number_format($SumPortType[0]['NUM']/($SumPortType[1]['NUM']+$SumPortType[0]['NUM'])*100,2); ?>%
                                </div>
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
                        <div style="text-align:right;width: 100%;"><img class="img-profile rounded-circle"
                                src="<?php echo $flag ?>" style="width: 40px;"></div>
                        <div class="text-center" id="htmltoimage_chart_country" style="padding:5px;">

                            <div id="chart_country" style="height:300px !important">
                                <img
                                    src="<?php echo base_url('public/uploads/main/' . $to_date . 'chart_country'.$country_id.'.png') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        หมายเหตุ : ข้อมูลสัญชาติ (Nationality) ที่ไม่นับรวมข้อมูลผู้อพยพ , หน่วยงานพิเศษ UN ,
                        ไม่มีสัญชาติ <br>
                        WoW (Week on Week) หมายถึง อัตราการเปลี่ยนแปลงเทียบกับสัปดาห์ก่อนหน้า
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>