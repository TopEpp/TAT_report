<?php include_once("export_css.php"); ?>
<?php $shortmonth = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."); ?>
<style type="text/css">
#CartItem {
    display: flex !important;
    flex-direction: row !important;
}

.col3 {
    width: 30%;
}

.col9 {
    width: 70%;
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

.bg-blue {
    background-color: #163868;
}

.header-table {
    background-color: #dae0f2;
}

.table-bordered-black {
    border: 1px black solid !important;
}

@media (max-width: 576px) {}
</style>
<?php 
$arraycolor=['#1d3860','#dd6910' , '#2e74b4']
?>
<div class="bg-blue">
    <div style="padding: 10px;">
        <div class="p-3"
            style="background-color: orange; padding:0px;font-size: 20px; text-align: center;color: white; margin-top:10px;margin-bottom: 10px;">
            <b>
                สถิติคนไทยเดินทางออกนอกราชอาณาจักรในภาพรวม
            </b>
        </div>
        <div>
            <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure1.png') ?>"
                style="width:100%;height:250px;">
        </div>
        <div style="margin-top: 10px; margin-bottom:10px">
            <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure2.png') ?>"
                style="width:100%;height:250px;">
        </div>
        <div style="margin-top: 20px;  background-color:white">
            <table class="table table-striped " border="1">
                <tr>
                    <th style="text-align: center;" class="header-table">ปี</th>
                    <?php for ($i = 1; $i <= 12; $i++) {  ?>
                    <th style="text-align: center;" class="header-table">
                        <?php echo $shortmonth[$i];
							if ($check_noti_month == $i) {
								echo ' *';
							} ?></th>
                    <?php } ?>
                    <th class="header-table" style="text-align: center;">รวม</th>
                </tr>
                <tr>
                    <td align="center" style="background-color: #1e3660; color:white"><?php echo $year - 1 ?></td>
                    <?php for ($i = 0; $i <= 11; $i++) {
						@$sum_past += $SumChartDataYear['past'][$i]; ?>
                    <td align="center" style="color:#1e3660">
                        <b>
                            <?php echo @number_format($SumChartDataYear['past'][$i]) ?>
                        </b>
                    </td>
                    <?php } ?>
                    <td align="center" style="color:#1e3660">
                        <b>
                            <?php echo number_format($sum_past) ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="background-color: #de6713;"><b><?php echo $year ?></b></td>
                    <?php for ($i = 0; $i <= 11; $i++) {
						@$sum_current += $SumChartDataYear['current'][$i]; ?>
                    <td align="center" style="color: #de6713;">
                        <b>
                            <?php echo !empty(number_format(@$SumChartDataYear['current'][$i])) ? @number_format($SumChartDataYear['current'][$i]) : ''; ?>
                        </b>
                    </td>
                    <?php } ?>
                    <td align="center" style="color: #de6713;"><b><?php echo number_format($sum_current) ?></b></td>
                </tr>
                <tr>
                    <td align="center"><b>+/- (%)</b></td>
                    <?php for ($i = 0; $i <= 11; $i++) {
						$percent = '';
						if (!empty($SumChartDataYear['current'][$i])) {
							$percent = number_format(($SumChartDataYear['current'][$i] - $SumChartDataYear['past'][$i])  / $SumChartDataYear['past'][$i]  * 100, 2);
						}

					?>
                    <td align="center"><b><?php echo $percent != '' ? number_format($percent, 2) : $percent; ?></b></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td colspan="14" class="header-table">จำนวนคนไทยเดินทางออกเฉลี่ยต่อวัน</td>
                </tr>
                <tr>
                    <td align="center" style="background-color: #1e3660;color: white;"><?php echo $year - 1 ?></td>
                    <?php $sum_days_past = 0;
					for ($i = 0; $i <= 11; $i++) {
						$days = cal_days_in_month(CAL_GREGORIAN, $i + 1, $year - 1);
						$sum_days_past += $days;
						@$sum_past_day += $SumChartDataYear['past'][$i];
					?>
                    <td align="center" style="color: #1e3660;">
                        <b> <?php echo @number_format($SumChartDataYear['past'][$i] / $days) ?></b>
                    </td>
                    <?php } ?>
                    <td align="center" style="color: #1e3660;">
                        <b><?php echo number_format($sum_past_day / $sum_days_past) ?></b>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="background-color:#de6713;color: white;"><?php echo $year ?></td>
                    <?php $sum_days = 0;
					for ($i = 0; $i <= 11; $i++) {
						$days = cal_days_in_month(CAL_GREGORIAN, $i + 1, $year);
						if (!empty($SumChartDataYear['current'][$i])) {
							$sum_days += $days;
						}
						@$sum_current_day += $SumChartDataYear['current'][$i] ?>
                    <td align="center" style="color: #de6713;">
                        <?php echo !empty($SumChartDataYear['current'][$i]) ? @number_format($SumChartDataYear['current'][$i] / $days) : ''; ?>
                    </td>
                    <?php } ?>
                    <td align="center" style="color: #de6713;"><?php echo number_format($sum_current_day / $sum_days) ?>
                    </td>
                </tr>
            </table>
        </div>
        <pageBreak />
        <div style="">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 30%;">
                        <div style="margin:10px">
                            <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure3.png') ?>"
                                style="height:330px;">
                        </div>
                    </td>
                    <td style="width: 70%;">
                        <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure4.png') ?>"
                            style="width:100%;height:330px">
                    </td>
                </tr>
            </table>
        </div>
        <div class="p-3"
            style="background-color: orange; padding:0px;font-size: 16px; text-align: center;color: white; margin-top:10px;margin-bottom: 10px;">
            <b>
                สถิติคนไทยเดินทางออกนอกราชอาณาจักรทาง<u>ท่าอากาศยาน</u>
            </b>
        </div>
        <div>
            <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure5.png') ?>"
                style="width:100%;height:200px;">
        </div>
        <div style="background-color: white; margin-top: 9px;">
            <table class="table table-striped " border="1">
                <tr>
                    <th style="text-align: center;" class="header-table">ปี</th>
                    <?php

							for ($i = 1; $i <= 12; $i++) {
							?>
                    <th style="text-align: center;" class="header-table">
                        <?php echo $shortmonth[$i];
									if ($check_noti_month == $i) {
										echo ' *';
									} ?></th>
                    <?php } ?>
                    <th style="text-align: center;" class="header-table">รวม</th>
                </tr>
                <tr>
                    <td align="center" style="background-color: #1e3660;color: white;"><b><?php echo $year - 1 ?></b>
                    </td>
                    <?php for ($i = 0; $i <= 11; $i++) {
								@$sum_past += $SumChartDataYear_Air['past'][$i]; ?>
                    <td align="center" style="color: #1e3660;">
                        <b> <?php echo @number_format($SumChartDataYear_Air['past'][$i]) ?>
                    </td></b>
                    <?php } ?>
                    <td align="center" style="color: #1e3660;">
                        <b><?php echo number_format($sum_past) ?></b>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="background-color: #de6713;color: white;"><b><?php echo $year ?></b></td>
                    <?php for ($i = 0; $i <= 11; $i++) {
								@$sum_current += $SumChartDataYear_Air['current'][$i]; ?>
                    <td align="center" style="color: #de6713;">
                        <b><?php echo !empty($SumChartDataYear_Air['current'][$i]) ? @number_format($SumChartDataYear_Air['current'][$i]) : ''; ?></b>
                    </td>
                    <?php } ?>
                    <td align="center" style="color: #de6713;"><b><?php echo number_format($sum_current) ?></b></td>
                </tr>
                <tr>
                    <td align="center"><b>+/- (%)</b></td>
                    <?php for ($i = 0; $i <= 11; $i++) {
								$percent = '';
								if (!empty($SumChartDataYear_Air['current'][$i])) {
									$percent = number_format(($SumChartDataYear_Air['current'][$i] - $SumChartDataYear_Air['past'][$i])  / $SumChartDataYear_Air['past'][$i]  * 100, 2);
								}
							?>
                    <td align="center"><b><?php echo $percent != '' ? number_format($percent, 2) : $percent; ?></b></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td colspan="14" class="header-table"><b>จำนวนคนไทยเดินทางออกเฉลี่ยต่อวัน</b></td>
                </tr>
                <tr>
                    <td align="center" style="background-color: #1e3660;color: white;"><b><?php echo $year - 1 ?></b>
                    </td>
                    <?php $sum_past_day = $sum_days_past = 0;
							for ($i = 0; $i <= 11; $i++) {
								$days = cal_days_in_month(CAL_GREGORIAN, $i + 1, $year - 1);
								$sum_days_past += $days;
								@$sum_past_day += $SumChartDataYear_Air['past'][$i];
							?>
                    <td align="center" style="color: #1e3660;">
                        <b> <?php echo @number_format($SumChartDataYear_Air['past'][$i] / $days) ?></b>
                    </td>
                    <?php } ?>
                    <td align="center" style="color: #1e3660;">
                        <b><?php echo number_format($sum_past_day / $sum_days_past) ?></b>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="background-color: #de6713;color: white;"><b><?php echo $year ?></b></td>
                    <?php $sum_current_day = $sum_days = 0;
							for ($i = 0; $i <= 11; $i++) {
								$days = cal_days_in_month(CAL_GREGORIAN, $i + 1, $year);
								if (!empty($SumChartDataYear_Air['current'][$i])) {
									$sum_days += $days;
								}
								@$sum_current_day += $SumChartDataYear_Air['current'][$i] ?>
                    <td align="center" style="color: #de6713;">
                        <b><?php echo !empty($SumChartDataYear_Air['current'][$i]) ? @number_format($SumChartDataYear_Air['current'][$i] / $days) : ''; ?></b>
                    </td>
                    <?php } ?>
                    <td align="center" style="color: #de6713;">
                        <b><?php echo number_format($sum_current_day / $sum_days) ?></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="14" class="header-table">สัดส่วนคนไทยเดินทางออกทางท่าอากาศยานต่อภาพรวม (%)</td>
                </tr>
                <tr>
                    <td align="center" style="background-color: #1e3660;color: white;"><b><?php echo $year - 1 ?></b>
                    </td>
                    <?php $sum_past = $sum_past_air = 0;
							for ($i = 0; $i <= 11; $i++) {
								$percent = '';
								$sum_past += @$SumChartDataYear['past'][$i];
								$sum_past_air += @$SumChartDataYear_Air['past'][$i];
								if (!empty($SumChartDataYear_Air['past'][$i])) {
									$percent = number_format($SumChartDataYear_Air['past'][$i] / $SumChartDataYear['past'][$i]  * 100, 2);
								}
							?>
                    <td align="center" style="color: #1e3660;">
                        <b><?php echo $percent != '' ? number_format($percent, 2) : ''; ?></b>
                    </td>
                    <?php } ?>
                    <td align="center" style="color: #1e3660;">
                        <b><?php echo number_format($sum_past_air / $sum_past * 100, 2) ?></b>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="background-color: #de6713;color: white;"><b><?php echo $year ?></b></td>
                    <?php $sum = $sum_air = 0;
							for ($i = 0; $i <= 11; $i++) {
								$percent = '';
								$sum += @$SumChartDataYear['current'][$i];
								$sum_air += @$SumChartDataYear_Air['current'][$i];
								if (!empty($SumChartDataYear_Air['current'][$i])) {
									$percent = number_format($SumChartDataYear_Air['current'][$i] / $SumChartDataYear['current'][$i]  * 100, 2);
								}
							?>
                    <td align="center" style="color: #de6713;">
                        <b><?php echo $percent != '' ? number_format($percent, 2) : ''; ?></b>
                    </td>
                    <?php } ?>
                    <td align="center" style="color: #de6713;">
                        <b><?php echo number_format($sum_air / $sum * 100, 2) ?></b>
                    </td>
                </tr>
            </table>
            <div> <?php echo $check_noti_month_label; ?></div>
        </div>
    </div>
</div>
<!-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-1 col-12 my-auto text-center"></div>
                    <div class="col-md-10 col-12 my-auto text-center">สถิติคนไทยเดินทางออกนอกราชอาณาจักรในภาพรวม</div>
                    <div class="col-md-1 col-12 my-auto text-center" style="font-size:0.6em !important; ">

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center" id="htmltoimage_chart_departure1" style="height:320px; padding:15px;">

                </div>
                <hr>
                <div style="overflow: auto;">
                     <div style="text-align:center;">
						ภาพรวมคนไทยเดินทางออกนอกราชอาณาจักรไทย : รายเดือน
					</div> 
<div class="text-center" id="htmltoimage_chart_departure2">
    <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure2.png') ?>"
        style="width:100%;height:220px;">
</div>
<table class="table table-striped table-bordered">
    <tr>
        <th style="text-align: center;">ปี</th>
        <?php for ($i = 1; $i <= 12; $i++) {  ?>
        <th style="text-align: center;">
            <?php echo $shortmonth[$i];
									if ($check_noti_month == $i) {
										echo ' *';
									} ?></th>
        <?php } ?>
        <th style="text-align: center;">รวม</th>
    </tr>
    <tr>
        <td align="center" style="background-color: #3cacae;"><?php echo $year - 1 ?></td>
        <?php for ($i = 0; $i <= 11; $i++) {
								@$sum_past += $SumChartDataYear['past'][$i]; ?>
        <td align="right" style="background-color: #3cacae;">
            <?php echo @number_format($SumChartDataYear['past'][$i]) ?></td>
        <?php } ?>
        <td align="right" style="background-color: #3cacae;"><?php echo number_format($sum_past) ?>
        </td>
    </tr>
    <tr>
        <td align="center"><?php echo $year ?></td>
        <?php for ($i = 0; $i <= 11; $i++) {
								@$sum_current += $SumChartDataYear['current'][$i]; ?>
        <td align="right">
            <?php echo !empty(number_format(@$SumChartDataYear['current'][$i])) ? @number_format($SumChartDataYear['current'][$i]) : ''; ?>
        </td>
        <?php } ?>
        <td align="right"><?php echo number_format($sum_current) ?></td>
    </tr>
    <tr>
        <td align="center">+/- (%)</td>
        <?php for ($i = 0; $i <= 11; $i++) {
								$percent = '';
								if (!empty($SumChartDataYear['current'][$i])) {
									$percent = number_format(($SumChartDataYear['current'][$i] - $SumChartDataYear['past'][$i])  / $SumChartDataYear['past'][$i]  * 100, 2);
								}

							?>
        <td align="right"><?php echo $percent != '' ? number_format($percent, 2) : $percent; ?></td>
        <?php } ?>
    </tr>
    <tr>
        <td colspan="14">จำนวนคนไทยเดินทางออกเฉลี่ยต่อวัน</td>
    </tr>
    <tr>
        <td align="center" style="background-color: #3cacae;"><?php echo $year - 1 ?></td>
        <?php $sum_days_past = 0;
							for ($i = 0; $i <= 11; $i++) {
								$days = cal_days_in_month(CAL_GREGORIAN, $i + 1, $year - 1);
								$sum_days_past += $days;
								@$sum_past_day += $SumChartDataYear['past'][$i];
							?>
        <td align="right" style="background-color: #3cacae;">
            <?php echo @number_format($SumChartDataYear['past'][$i] / $days) ?></td>
        <?php } ?>
        <td align="right" style="background-color: #3cacae;">
            <?php echo number_format($sum_past_day / $sum_days_past) ?></td>
    </tr>
    <tr>
        <td align="center"><?php echo $year ?></td>
        <?php $sum_days = 0;
							for ($i = 0; $i <= 11; $i++) {
								$days = cal_days_in_month(CAL_GREGORIAN, $i + 1, $year);
								if (!empty($SumChartDataYear['current'][$i])) {
									$sum_days += $days;
								}
								@$sum_current_day += $SumChartDataYear['current'][$i] ?>
        <td align="right">
            <?php echo !empty($SumChartDataYear['current'][$i]) ? @number_format($SumChartDataYear['current'][$i] / $days) : ''; ?>
        </td>
        <?php } ?>
        <td align="right"><?php echo number_format($sum_current_day / $sum_days) ?></td>
    </tr>
</table>
<?php echo $check_noti_month_label; ?>
</div>
</div>
</div>
</div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="text-center" id="htmltoimage_chart_departure3">
                    <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure3.png') ?>"
                        style="width:100%;height:320px;">
                </div>
                <?php
				$num_port1 = $SumPort['SUM_TYPE']['ด่านอากาศ'];
				$num_port2 = $SumPort['SUM_TYPE']['ด่านบก'];

				$sum_port1 = number_format($SumPort['SUM_TYPE']['ด่านอากาศ'] / ($SumPort['SUM_TYPE']['ด่านอากาศ'] + $SumPort['SUM_TYPE']['ด่านบก']) * 100, 2);
				$sum_port2 = number_format($SumPort['SUM_TYPE']['ด่านบก'] / ($SumPort['SUM_TYPE']['ด่านอากาศ'] + $SumPort['SUM_TYPE']['ด่านบก']) * 100, 2);
				?>
                 ด่านอากาศ : <?php echo number_format($SumPort['SUM_TYPE']['ด่านอากาศ']) ?> คน , <?php echo number_format($SumPort['SUM_TYPE']['ด่านอากาศ'] / ($SumPort['SUM_TYPE']['ด่านอากาศ'] + $SumPort['SUM_TYPE']['ด่านบก']) * 100, 2) ?> % <br>
						ด่านบก : <?php echo number_format($SumPort['SUM_TYPE']['ด่านบก']) ?> คน , <?php echo number_format($SumPort['SUM_TYPE']['ด่านบก'] / ($SumPort['SUM_TYPE']['ด่านอากาศ'] + $SumPort['SUM_TYPE']['ด่านบก']) * 100, 2) ?> % 
</div>
</div>
</div>
<div class="col-md-8">
    <div class="card">
        <div class="card-body">

            <div class="text-center" id="htmltoimage_chart_departure4">
                <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure4.png') ?>"
                    style="width:100%;height:320px;">
            </div>
             TOP 10 ด่านที่คนไทยเดินทางออกนอกราชอาณาจักรไทย (คน) <br> 
ท่าอากาศยานสุวรรณภูมิและดอนเมือง :
<?php echo number_format($SumPort['SUM_PORT'][49]['NUM'] + $SumPort['SUM_PORT'][41]['NUM']) ?><br> 

<?php $data_chart_port[] =  $SumPort['SUM_PORT'][49]['NUM'] + $SumPort['SUM_PORT'][41]['NUM'];
				$cate_chart_port[] = 'ท่าอากาศยานสุวรรณภูมิและดอนเมือง';
				$i = 0;
				$minValueHeat = PHP_INT_MAX;
				$maxValueHeat = PHP_INT_MIN;
				foreach ($SumPort['SUM_PORT'] as $port) {
					if ($port['PORT_ID'] != 49 && $port['PORT_ID'] != 41) {
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
                <div class="text-center" id="htmltoimage_chart_departure5" style="height:240px; padding:15px;">
                    <img src="<?php echo base_url('public/uploads/main/' . $to_date . 'departure5.png') ?>"
                        style="width:100%;height:220px;">
                </div>
                <div>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th style="text-align: center;">ปี</th>
                            <?php

							for ($i = 1; $i <= 12; $i++) {
							?>
                            <th style="text-align: center;">
                                <?php echo $shortmonth[$i];
									if ($check_noti_month == $i) {
										echo ' *';
									} ?></th>
                            <?php } ?>
                            <th style="text-align: center;">รวม</th>
                        </tr>
                        <tr>
                            <td align="center" style="background-color: #3cacae;"><?php echo $year - 1 ?></td>
                            <?php for ($i = 0; $i <= 11; $i++) {
								@$sum_past += $SumChartDataYear_Air['past'][$i]; ?>
                            <td align="right" style="background-color: #3cacae;">
                                <?php echo @number_format($SumChartDataYear_Air['past'][$i]) ?></td>
                            <?php } ?>
                            <td align="right" style="background-color: #3cacae;"><?php echo number_format($sum_past) ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="center"><?php echo $year ?></td>
                            <?php for ($i = 0; $i <= 11; $i++) {
								@$sum_current += $SumChartDataYear_Air['current'][$i]; ?>
                            <td align="right">
                                <?php echo !empty($SumChartDataYear_Air['current'][$i]) ? @number_format($SumChartDataYear_Air['current'][$i]) : ''; ?>
                            </td>
                            <?php } ?>
                            <td align="right"><?php echo number_format($sum_current) ?></td>
                        </tr>
                        <tr>
                            <td align="center">+/- (%)</td>
                            <?php for ($i = 0; $i <= 11; $i++) {
								$percent = '';
								if (!empty($SumChartDataYear_Air['current'][$i])) {
									$percent = number_format(($SumChartDataYear_Air['current'][$i] - $SumChartDataYear_Air['past'][$i])  / $SumChartDataYear_Air['past'][$i]  * 100, 2);
								}

							?>
                            <td align="right"><?php echo $percent != '' ? number_format($percent, 2) : $percent; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td colspan="14">จำนวนคนไทยเดินทางออกเฉลี่ยต่อวัน</td>
                        </tr>
                        <tr>
                            <td align="center" style="background-color: #3cacae;"><?php echo $year - 1 ?></td>
                            <?php $sum_past_day = $sum_days_past = 0;
							for ($i = 0; $i <= 11; $i++) {
								$days = cal_days_in_month(CAL_GREGORIAN, $i + 1, $year - 1);
								$sum_days_past += $days;
								@$sum_past_day += $SumChartDataYear_Air['past'][$i];
							?>
                            <td align="right" style="background-color: #3cacae;">
                                <?php echo @number_format($SumChartDataYear_Air['past'][$i] / $days) ?></td>
                            <?php } ?>
                            <td align="right" style="background-color: #3cacae;">
                                <?php echo number_format($sum_past_day / $sum_days_past) ?></td>
                        </tr>
                        <tr>
                            <td align="center"><?php echo $year ?></td>
                            <?php $sum_current_day = $sum_days = 0;
							for ($i = 0; $i <= 11; $i++) {
								$days = cal_days_in_month(CAL_GREGORIAN, $i + 1, $year);
								if (!empty($SumChartDataYear_Air['current'][$i])) {
									$sum_days += $days;
								}
								@$sum_current_day += $SumChartDataYear_Air['current'][$i] ?>
                            <td align="right">
                                <?php echo !empty($SumChartDataYear_Air['current'][$i]) ? @number_format($SumChartDataYear_Air['current'][$i] / $days) : ''; ?>
                            </td>
                            <?php } ?>
                            <td align="right"><?php echo number_format($sum_current_day / $sum_days) ?></td>
                        </tr>
                        <tr>
                            <td colspan="14">สัดส่วนคนไทยเดินทางออกทางท่าอากาศยานต่อภาพรวม (%)</td>
                        </tr>
                        <tr>
                            <td align="center" style="background-color: #3cacae;"><?php echo $year - 1 ?></td>
                            <?php $sum_past = $sum_past_air = 0;
							for ($i = 0; $i <= 11; $i++) {
								$percent = '';
								$sum_past += @$SumChartDataYear['past'][$i];
								$sum_past_air += @$SumChartDataYear_Air['past'][$i];
								if (!empty($SumChartDataYear_Air['past'][$i])) {
									$percent = number_format($SumChartDataYear_Air['past'][$i] / $SumChartDataYear['past'][$i]  * 100, 2);
								}
							?>
                            <td align="right" style="background-color: #3cacae;">
                                <?php echo $percent != '' ? number_format($percent, 2) : ''; ?></td>
                            <?php } ?>
                            <td align="right" style="background-color: #3cacae;">
                                <?php echo number_format($sum_past_air / $sum_past * 100, 2) ?></td>
                        </tr>
                        <tr>
                            <td align="center"><?php echo $year ?></td>
                            <?php $sum = $sum_air = 0;
							for ($i = 0; $i <= 11; $i++) {
								$percent = '';
								$sum += @$SumChartDataYear['current'][$i];
								$sum_air += @$SumChartDataYear_Air['current'][$i];
								if (!empty($SumChartDataYear_Air['current'][$i])) {
									$percent = number_format($SumChartDataYear_Air['current'][$i] / $SumChartDataYear['current'][$i]  * 100, 2);
								}
							?>
                            <td align="right"><?php echo $percent != '' ? number_format($percent, 2) : ''; ?></td>
                            <?php } ?>
                            <td align="right"><?php echo number_format($sum_air / $sum * 100, 2) ?></td>
                        </tr>
                    </table>
                    <?php echo $check_noti_month_label; ?>
                </div>
            </div>
        </div>
    </div>
</div> -->