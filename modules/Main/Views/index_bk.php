<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu');?>

<div class="row">
	<div class="col-md-6" style="font-size: 1.4em;">
		<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543)?>
	</div>
	<div class="col-md-6"></div>
</div>
<div class="row">
	<div class="col-md-4 col-4" >
		วันที่เริ่มต้น <input type="text" name="start_date" id="start_date" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($start_date,543,'/')?>">
	</div>
	<div class="col-md-4 col-4" >
		วันที่สิ้นสุด <input type="text" name="end_date" id="end_date" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($end_date,543,'/')?>">
	</div>
	<div class="col-md-4 col-4"  style="text-align: right;">
		<div class="btn btn-primary" onclick="ClearFilter()">ล้างค่า</div>
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>
</div>

<div class="row">
	<div class="col-6">
		<div class="card"  style="background-image: url('<?php echo base_url('public/img/bg_info.png')?>'); background-repeat: no-repeat; background-position: bottom;background-position-x:0 ">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 col-4" style="text-align:center;" ><img src="<?php echo base_url('public/img/icon_info1.png')?>"></div>
						<div class="col-md-8 col-8" style="text-align:right; font-weight: bold; line-height: 2.4em; font-size: 1.1em; ">
							จำนวนนักท่องเที่ยว<br>
							วันที่ <?php echo $Mydate->date_eng2thai($to_date, 543,'S')?><br>
							<div style="padding:5px; background:#ededed; border-radius: 5px; width: 100%; font-size: 1.2em; font-weight: bold;">
								<?php echo number_format($SumDateData);?>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	<div class="col-6">
		<div class="card" style="background-image: url('<?php echo base_url('public/img/bg_info.png')?>'); background-repeat: no-repeat; background-position: bottom;background-position-x:0 ">
			<div class="card-body">
				<div class="row">
					<div class="col-md-4 col-4" style="text-align:center;" ><img src="<?php echo base_url('public/img/icon_info2.png')?>"></div>
					<div class="col-md-8 col-8" style="text-align:right; font-weight: bold; line-height: 2.4em; font-size: 1.1em;">
						จำนวนนักท่องเที่ยวสะสม<br>
						<!-- วันที่ 1 ม.ค. - <?php echo cal_days_in_month(CAL_GREGORIAN,$month,$year);?> <?php echo $month_label;?> <?php echo $year+543?> <br> -->
						วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543,'S','S')?> - <?php echo $Mydate->date_eng2thai($to_date, 543,'S','S')?> <br>
						<div style="padding:5px; background:#ededed; border-radius: 5px; width: 100%; font-size: 1.2em; font-weight: bold;">
							<?php echo number_format($SumMonthData);?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header" >จำนวนนักท่องเที่ยวรายวัน (คน)</div>
			<div class="card-body">
				<div class="text-center" id="htmltoimage_chart_main" style="height:220px; padding:15px;">
	                <canvas id="chart_main" height="220" style="height:220px !important"></canvas>
	            </div>
	            <div style="overflow: auto;">
	            	<table class="table table-striped table-bordered">
	            		<tr>
	            			<td  align="center">ปี</td>
	            			<?php $chart_label = $chart_current = $chart_pre = array();
	            			foreach($period as $d){?>
	            				<td align="center"><?php echo $Mydate->date_eng2thai($d, 'X','S'); $chart_label[] = $Mydate->date_eng2thai($d, 'X','S'); ?></td>
	            			<?php }?>
	            		</tr>
	            		<tr>
	            			<td><?php echo $year+543?></td>
	            			<?php
	            			foreach($period as $d){?>
	            				<td style="background:#57DACC" align="center"><?php echo number_format(@$SumChartData['current'][$d]); $chart_current[] = @$SumChartData['current'][$d]?@$SumChartData['current'][$d]:0;?></td>
	            			<?php }?>
	            		</tr>
	            		<tr>
	            			<td><?php echo $year+542?></td>
	            			<?php
	            			foreach($period as $d){ $d_ex = explode('-', $d); $d_pre = ($d_ex[0]-1).'-'.$d_ex[1].'-'.$d_ex[2];   ?>
	            				<td style="background:#FACE74" align="center"><?php echo number_format(@$SumChartData['past'][$d_pre]); $chart_pre[] = @$SumChartData['past'][$d_pre]?@$SumChartData['past'][$d_pre]:0;?></td>
	            			<?php }?>
	            		</tr>
	            	</table>
	            </div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">จำนวนนักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<div class="card">
							<div class="card-body" style="background: #eaf3f4; padding: 0; border-radius: 0.35rem;" >
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
										<span style="font-size:0.8em">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543)?></span>
									</div>
									<hr>
									<?php $c=0; foreach($SumNatDateData as $v){ $c++;  ?>
									<div class="row" style="margin-bottom:10px;">
										<div class="col-md-3 col-3">
											<img class="img-profile rounded-circle" src="<?php echo base_url('public/img/logotat.png')?>">
										</div>
										<div class="col-md-5 col-5" style="padding-top: 15px;font-weight:bold;">
											<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['COUNTRY_NAME_EN']?></span>
										</div>
										<div class="col-md-4 col-4" style="padding-top: 15px;font-weight:bold;">
											<?php echo number_format($v['NUM']);?>
										</div>
									</div>
									<?php if($c==5) break; }?>
								</div>
								<div style="background:#70d3de; text-align:center; border-radius: 0 0 0.35rem 0.35rem; cursor: pointer; " onclick="openModalInfo(1)">
									<i class="fa-solid fa-caret-down"></i>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card">
							<div class="card-body" style="background: #eaf3f4; padding: 0; border-radius: 0.35rem;" >
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
										<span style="font-size:0.8em">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543,'S','S')?>  - <?php echo $Mydate->date_eng2thai($to_date, 543,'S')?></span>
									</div>
									<hr>
									<?php $c=0; foreach($SumNatMonthData as $v){ $c++;  ?>
									<div class="row" style="margin-bottom:10px;">
										<div class="col-md-3 col-3">
											<img class="img-profile rounded-circle" src="<?php echo base_url('public/img/logotat.png')?>">
										</div>
										<div class="col-md-5 col-5" style="padding-top: 15px;font-weight:bold;">
											<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['COUNTRY_NAME_EN']?></span>
										</div>
										<div class="col-md-4 col-4" style="padding-top: 15px;font-weight:bold;">
											<?php echo number_format($v['NUM']);?>
										</div>
									</div>
									<?php if($c==5) break; }?>
								</div>
								<div style="background:#70d3de; text-align:center; border-radius: 0 0 0.35rem 0.35rem; cursor: pointer; " onclick="openModalInfo(2)">
									<i class="fa-solid fa-caret-down"></i>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card">
							<div class="card-body" style="background: #a2e4d8; padding: 0; border-radius: 0.35rem;" >
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายด่าน</span><br>
										<span style="font-size:0.8em">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543)?></span>
									</div>
									<hr>
									<?php $c=0; foreach($SumPortDateData as $v){ $c++;  ?>
									<div class="row" style="margin-bottom:10px;">
										<div class="col-md-3 col-3" style="text-align:center; font-size: 2.4em;">
											<?php if($v['PORT_TYPE']=='ด่านอากาศ'){
												echo '<i class="fa fa-plane-up"></i>';
											}else{
												echo '<i class="fa fa-building"></i>';
											} ?>
										</div>
										<div class="col-md-5 col-5" style="padding-top: 15px;font-weight:bold;">
											<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['PORT_NAME']?></span>
										</div>
										<div class="col-md-4 col-4" style="padding-top: 15px;font-weight:bold;">
											<?php echo number_format($v['NUM']);?>
										</div>
									</div>
									<?php if($c==5) break; }?>
								</div>
								<div style="background:#4598a1; text-align:center; border-radius: 0 0 0.35rem 0.35rem; cursor: pointer; " onclick="openModalInfo(3)">
									<i class="fa-solid fa-caret-down"></i>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card">
							<div class="card-body" style="background: #a2e4d8; padding: 0; border-radius: 0.35rem;" >
								<div style="padding:10px;">
									<div style="text-align: center;">
										<span style="font-weight:bold;">จำแนกรายด่าน</span><br>
										<span style="font-size:0.8em">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543,'S','S')?>  -  <?php echo $Mydate->date_eng2thai($to_date, 543,'S')?></span>
									</div>
									<hr>
									<?php $c=0; foreach($SumPortMonthData as $v){ $c++;  ?>
									<div class="row" style="margin-bottom:10px;">
										<div class="col-md-3 col-3" style="text-align:center; font-size: 2.4em;">
											<?php if($v['PORT_TYPE']=='ด่านอากาศ'){
												echo '<i class="fa fa-plane-up"></i>';
											}else{
												echo '<i class="fa fa-building"></i>';
											} ?>
										</div>
										<div class="col-md-5 col-5" style="padding-top: 15px;font-weight:bold;">
											<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['PORT_NAME']?></span>
										</div>
										<div class="col-md-4 col-4" style="padding-top: 15px;font-weight:bold;">
											<?php echo number_format($v['NUM']);?>
										</div>
									</div>
									<?php if($c==5) break; }?>
								</div>
								<div style="background:#4598a1; text-align:center; border-radius: 0 0 0.35rem 0.35rem; cursor: pointer; " onclick="openModalInfo(4)">
									<i class="fa-solid fa-caret-down"></i>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<span style="font-weight:bold;">จำนวนนักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย</span><br>
				<span style="font-size:0.8em">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543,'S','S')?>  - <?php echo $Mydate->date_eng2thai($to_date, 543,'S')?></span>
			</div>
			<div class="card-body">
				<canvas id="world_map"></canvas>
			</div>
		</div>
	</div>
</div> -->

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<span style="font-weight:bold;">จำนวนนักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย<br>จำแนกรายภูมิภาค</span>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-8"></div>
					<div class="col-4">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Region</th>
									<th><?php echo $Mydate->date_eng2thai($to_date, 543,'S','S')?></th>
									<th><?php echo $Mydate->date_eng2thai($start_date_label, 543,'S','S')?>  -  <?php echo $Mydate->date_eng2thai($to_date, 543,'S','S')?></th>
								</tr>
							</thead>
							<tbody>
							

							<?php foreach($region[0] as $re){ ?>
							<tr>
								<td style="padding-left: 5px;">{<?php echo $re['MD_STD_REG_ID']?>}<?php echo $re['MD_STD_REG_NAMEEN']?></td>
								<td><?php echo number_format(@$SumRegionDateData[$re['MD_STD_REG_ID']])?></td>
								<td><?php echo number_format(@$SumRegionMonthData[$re['MD_STD_REG_ID']])?></td>
							</tr>
							<?php if(!empty($region[$re['MD_STD_REG_ID']])){ 
									foreach($region[$re['MD_STD_REG_ID']] as $re){ 
											if($re['IS_OTHERS'] == 'N'){
										?>
								<tr>
									<td style="padding-left: 20px;">{<?php echo $re['MD_STD_REG_ID']?>}<?php echo $re['MD_STD_REG_NAMEEN']?></td>
									<td><?php echo number_format(@$SumRegionDateData[$re['MD_STD_REG_ID']])?></td>
									<td><?php echo number_format(@$SumRegionMonthData[$re['MD_STD_REG_ID']])?></td>
								</tr>
							<?php if(!empty($region[$re['MD_STD_REG_ID']])){ 
									foreach($region[$re['MD_STD_REG_ID']] as $re){ ?>
								<tr>
									<td style="padding-left: 40px;">{<?php echo $re['MD_STD_REG_ID']?>} <?php echo $re['MD_STD_REG_NAMEEN']?></td>
									<td><?php echo number_format(@$SumRegionDateData[$re['MD_STD_REG_ID']])?></td>
									<td><?php echo number_format(@$SumRegionMonthData[$re['MD_STD_REG_ID']])?></td>
								</tr>

						<?php } } } } } }?> 

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalInfo1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<div>
        	<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
			<span style="font-size:0.8em">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543)?></span>
		</div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="padding:10px;">
			<?php $json_nat = array(); $c=0; foreach($SumNatDateData as $v){ $c++;  
				  $json_name = $v['COUNTRY_NAME_EN'];
					if($json_name=='U.S.A'){
						$json_name = 'United States of America';
					}else if($json_name== 'REP. Korea'){
						$json_name = 'South Korea';
					}else if($json_name== 'Saudi arabia'){
						$json_name = 'Saudi Arabia';
					}else if($json_name== 'Sri lanka'){
						$json_name = 'Sri Lanka';
					}else if($json_name== 'United kingdom'){
						$json_name = 'United Kingdom';
					}else if($json_name== 'New zealand'){
						$json_name = 'New Zealand';
					}else if($json_name== 'Papua new guinea'){
						$json_name = 'Papua New Guinea';
					}else if($json_name== 'U.A.E.'){
						$json_name = 'United Arab Emirates';
					}else if($json_name== 'Ivory cost'){
						$json_name = "Côte d'Ivoire";
					}



					$json_nat[$json_name]=$v['NUM'];  ?>
			<div class="row" style="margin-bottom:10px;">
				<div class="col-md-3 col-3">
					<img class="img-profile rounded-circle" src="<?php echo base_url('public/img/logotat.png')?>">
				</div>
				<div class="col-md-5 col-5" style="padding-top: 15px;font-weight:bold;">
					<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['COUNTRY_NAME_EN']?></span>
				</div>
				<div class="col-md-4 col-4" style="padding-top: 15px;font-weight:bold;">
					<?php echo number_format($v['NUM']);?>
				</div>
			</div>
			<?php }?>
		</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalInfo2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
  		<div>
        	<span style="font-weight:bold;">จำแนกรายสัญชาติ</span><br>
			<span style="font-size:0.8em">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543,'S','S')?>  - <?php echo $Mydate->date_eng2thai($to_date, 543,'S')?></span>
		</div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="padding:10px;">
			<?php $json_nat_month = array(); $c=0; foreach($SumNatMonthData as $v){ $c++; 

					$json_name = $v['COUNTRY_NAME_EN'];
					if($json_name=='U.S.A'){
						$json_name = 'United States of America';
					}else if($json_name== 'REP. Korea'){
						$json_name = 'South Korea';
					}else if($json_name== 'Saudi arabia'){
						$json_name = 'Saudi Arabia';
					}else if($json_name== 'Sri lanka'){
						$json_name = 'Sri Lanka';
					}else if($json_name== 'United kingdom'){
						$json_name = 'United Kingdom';
					}else if($json_name== 'New zealand'){
						$json_name = 'New Zealand';
					}else if($json_name== 'Papua new guinea'){
						$json_name = 'Papua New Guinea';
					}else if($json_name== 'U.A.E.'){
						$json_name = 'United Arab Emirates';
					}else if($json_name== 'Ivory cost'){
						$json_name = "Côte d'Ivoire";
					}



					$json_nat_month[$json_name]=$v['NUM'];
					 ?>
			<div class="row" style="margin-bottom:10px;">
				<div class="col-md-3 col-3">
					<img class="img-profile rounded-circle" src="<?php echo base_url('public/img/logotat.png')?>">
				</div>
				<div class="col-md-5 col-5" style="padding-top: 15px;font-weight:bold;">
					<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['COUNTRY_NAME_EN']?></span>
				</div>
				<div class="col-md-4 col-4" style="padding-top: 15px;font-weight:bold;">
					<?php echo number_format($v['NUM']);?>
				</div>
			</div>
			<?php  }?>
		</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalInfo3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
  		<div>
        	<span style="font-weight:bold;">จำแนกรายด่าน</span><br>
			<span style="font-size:0.8em">ประจำวันที่ <?php echo $Mydate->date_eng2thai($to_date, 543)?></span>
		</div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="padding:10px;">
			<?php $c=0; foreach($SumPortDateData as $v){ $c++;  ?>
			<div class="row" style="margin-bottom:10px;">
				<div class="col-md-3 col-3" style="text-align:center; font-size: 2.4em;">
					<?php if($v['PORT_TYPE']=='ด่านอากาศ'){
						echo '<i class="fa fa-plane-up"></i>';
					}else{
						echo '<i class="fa fa-building"></i>';
					} ?>
				</div>
				<div class="col-md-5 col-5" style="padding-top: 15px;font-weight:bold;">
					<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['PORT_NAME']?></span>
				</div>
				<div class="col-md-4 col-4" style="padding-top: 15px;font-weight:bold;">
					<?php echo number_format($v['NUM']);?>
				</div>
			</div>
			<?php  }?>
		</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalInfo4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
  		<div>
        	<span style="font-weight:bold;">จำแนกรายด่าน</span><br>
					<span style="font-size:0.8em">สะสม วันที่ <?php echo $Mydate->date_eng2thai($start_date_label, 543,'S','S')?>  -  <?php echo $Mydate->date_eng2thai($to_date, 543,'S')?></span>
		</div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="padding:10px;">
			<?php $c=0; foreach($SumPortMonthData as $v){ $c++;  ?>
			<div class="row" style="margin-bottom:10px;">
				<div class="col-md-3 col-3" style="text-align:center; font-size: 2.4em;">
					<?php if($v['PORT_TYPE']=='ด่านอากาศ'){
						echo '<i class="fa fa-plane-up"></i>';
					}else{
						echo '<i class="fa fa-building"></i>';
					} ?>
				</div>
				<div class="col-md-5 col-5" style="padding-top: 15px;font-weight:bold;">
					<span style="font-weight:bold; font-size: 0.9em;"><?php echo $v['PORT_NAME']?></span>
				</div>
				<div class="col-md-4 col-4" style="padding-top: 15px;font-weight:bold;">
					<?php echo number_format($v['NUM']);?>
				</div>
			</div>
			<?php }?>
		</div>
      </div>
    </div>
  </div>
</div>



<?php $this->endSection() ?>
<?=$this->section("scripts")?>
<script src="<?= base_url('public/js/script.js') ?>"></script>
<script src="<?php echo base_url('public/vendor/chart.js/Chart.min.js'); ?>" type="text/javascript"></script>
<!-- <script type="text/javascript" src="https://unpkg.com/chartjs-chart-geo@3.5.2/build/index.umd.min.js"></script> -->

<script type="text/javascript">
var chart_label = <?php echo json_encode($chart_label); ?>;
var chart_current = <?php echo json_encode($chart_current); ?>;
var chart_pre = <?php echo json_encode($chart_pre); ?>;
var json_nat = <?php echo json_encode($json_nat);?>;
var json_nat_month = <?php echo json_encode($json_nat_month);?>;
// import zoomPlugin from 'chartjs-plugin-zoom';
$(function(){
	$('.date_picker').datepicker({
    format: "dd/mm/yyyy",
    autoclose: true,
    language: 'th-th',
  });


	const ctx = document.getElementById('chart_main');
	const data_chart = {
	  labels: chart_label,
	  datasets: [
	    {
	      label: '<?php echo date('Y')+543?>',
	      data: chart_current,
	      borderColor: '#57DACC',
	      backgroundColor: '#57DACC',
	    },
	    {
	      label: '<?php echo date('Y')+542?>',
	      data: chart_pre,
	      borderColor: '#FACE74',
	      backgroundColor: '#FACE74',
	    }
	  ]
	};
    const chart_main = new Chart(ctx, {
        type: 'line',
		data: data_chart,
		  options: {
		    responsive: true,
		    interaction: {
		      mode: 'index',
		      intersect: false,
		    },
		    stacked: false,
		  },
    	options: {
	        maintainAspectRatio: false,
	    }
    });


 
	// fetch('https://unpkg.com/world-atlas/countries-50m.json').then((r) => r.json()).then((data) => {
  //   const countries = ChartGeo.topojson.feature(data, data.objects.countries).features;
  //   var data_map = countries.map((d) => ({feature: d, value: parseInt(json_nat_month[d.properties.name])  }));
  //   // console.log(json_nat);
  //   // console.log(data_map);
	//   const chart = new Chart(document.getElementById("world_map").getContext("2d"), {
	//     type: 'choropleth',
	//     data: {
	//       labels: countries.map((d) => d.properties.name),
	//       datasets: [{
	//         label: 'Countries',
	//         data: data_map,
	//       }]
	//     },
	//     options: {
	//       showOutline: true,
	//       showGraticule: true,
	//       plugins: {
	//         legend: {
	//           display: false
	//         },
	//       },
	//       scales: {
	//       	xy:{
	//       		projection: 'equalEarth'
	//       	},
	//       }
	//     }
	//   });
	// });
    
});

function openModalInfo(id){
	$('#modalInfo'+id).modal('show');
}

function ChangeFilter(){
	var date = $('#start_date').val();
	date = date.split('/');
	// start_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
	start_date = date[0]+'-'+date[1]+'-'+(date[2]-543);

	var date = $('#end_date').val();
	date = date.split('/');
	// end_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
	end_date = date[0]+'-'+date[1]+'-'+(date[2]-543);


	window.location.href = base_url+'/main?start_date='+start_date+'&end_date='+end_date;
}

function ClearFilter() {
	window.location.href = base_url+'/main';
}
</script>
<?=$this->endSection()?>
