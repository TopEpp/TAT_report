<?php $this->extend('templates/main') ?>

<!-- content -->
<?php $this->section('content') ?>
<?php $user_menu = $session->get('user_menu');?>
<div class="row">
	<div class="col-md-6" style="font-size: 1.4em;">
		<i class="fa fa-clock"></i> ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543)?>
	</div>
	<div class="col-md-6 col-6" style="text-align: right;">
		<a target="_blank" onclick="export_report('excel')" class="btn btn-success" style="width : 70px">
          <i class="fa-solid fa-file-excel"></i> Excel
        </a>
        <a target="_blank" onclick="export_report('pdf')" class="btn btn-danger" style="width : 70px">
          <i class="fa-solid fa-file-pdf"></i> PDF
        </a>
	</div>
	<div class="col-md-12" >
		รายงานเปรียบเทียบจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทย รายด่าน
	</div>
</div>
<div class="row">
	<div class="col-md-4 col-4" >
		วันที่เริ่มต้น <input type="text" name="start_date1" id="start_date1" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($start_date1,543,'/')?>">
	</div>
	<div class="col-md-3 col-3" >
		วันที่สิ้นสุด <input type="text" name="end_date1" id="end_date1" class="form-control date_picker" style="width: 150px;display: inline;" value="<?php echo $Mydate->date_thai2eng($end_date1,543,'/')?>">
	</div>
	<div class="col-md-2 col-2" style="text-align:right; padding-top: 5px;">
		Country List
	</div>
	<div class="col-md-2 col-2" >
		<select class="form-control" id="country_type" >
			<option value="standard" <?php if(@$country_type=='standard'){ echo "selected='selected'";} ?> >Standard</option>
			<option value="all" <?php if(@$country_type=='all'){ echo "selected='selected'";} ?> >All Country</option>
		</select>
	</div>
	<div class="col-md-1 col-1" >
		<div class="btn btn-primary" onclick="ChangeFilter()">ตกลง</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-12">
		<label><input type="checkbox" name="port_all" id="port_all" > <b> ด่านทั้งหมด</b></label>
	</div>
	<div class="col-md-12 col-12">
		<label><input type="checkbox" name="port_type_1" id="port_type_1" class="port_checkbox"> <b> ด่านบก</b></label>
	</div>
	<?php foreach($port[1] as $p){ ?>
		<div class="col-md-3 col-3">
			<label style="font-weight:normal;"><input type="checkbox" name="port_type[]" id="port_type" class="port_1 port_checkbox" value="<?php echo $p['PORT_ID']?>" <?php if(in_array($p['PORT_ID'],$port_type)){ echo "checked='checked'"; } ?>  > <?php echo $p['PORT_NAME']?></label>
		</div>
	<?php } ?>
	<br>
	<div class="col-md-12 col-12">
		<label><input type="checkbox" name="port_type_2" id="port_type_2" class="port_checkbox" > <b> ด่านอากาศ</b></label>
	</div>
	<?php foreach($port[2] as $p){ ?>
		<div class="col-md-3 col-3">
			<label style="font-weight:normal;"><input type="checkbox" name="port_type[]" id="port_type" class="port_2 port_checkbox" value="<?php echo $p['PORT_ID']?>" <?php if(in_array($p['PORT_ID'],$port_type)){ echo "checked='checked'"; } ?> > <?php echo $p['PORT_NAME']?></label>
		</div>
	<?php } ?>
</div>

<div class="row">
	<div class="col-md-12 col-12">
		<div class="table-responsive">
			<?php if(!empty($country_row) && !empty($port_colunm)){ ?>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th rowspan="2">Nation</th>
						<?php if(!empty($port_colunm)){ foreach($port_colunm as $p){ ?>
						<th colspan="<?php  echo count($period)?>"><?php echo $p['PORT_NAME']?></th>
						<?php }}?>
					</tr>
					<tr>
					<?php if(!empty($port_colunm)){ foreach($port_colunm as $p){ ?>
						<?php foreach($period as $d){ echo "<th>{$Mydate->date_eng2thai($d, 543,'S','S')}</th>"; } ?>
					<?php }}?>
					</tr>
				</thead>
				<tbody>
					<tr style="background-color:#B6E2E9">
						<td style="font-weight: bolder;">GRAND TOTAL</td>
						<?php 	
							if(!empty($port_colunm)){ foreach($port_colunm as $p){ 
								foreach($period as $d){ 
									$sum = getSumData($data,$region,0,$country,$p['PORT_ID'],$d);
									echo '<td align="right">'.number_format($sum).'</td>';
								}
							}}
						?>
						
					</tr>
				<?php genTableData($data,$region,0,$country,$port_colunm,$period);?>
				</tbody>
			</table>
			<?php } ?>
		</div>
	</div>
</div>

<?php 

function genTableData($data,$region,$region_id,$country,$port_colunm,$period,$level=1){
	$level++;

	

	if(!empty($region[$region_id])){ 
		foreach($region[$region_id] as $re){ 

		$padding_region = $level*10;
		$alink = '';
		if(!empty($country[$re['MD_STD_REG_ID']])){ 
			$alink = '<a onclick="ShowHide('.$re['MD_STD_REG_ID'].')"> <i class="fa-solid fa-caret-down"></i> </a>';
		}
		 
		echo '<tr style="background-color:#B6E2E9" id="TR-'.$re['MD_STD_REG_ID'].'" >';
			echo '<td style="padding-left: '.$padding_region.'px; font-weight: bolder;"> '.$alink.' '.$re['MD_STD_REG_NAMEEN'].'</td>';
			if(!empty($port_colunm)){ foreach($port_colunm as $p){ 
				foreach($period as $d){ 
					$sum = getSumData($data,$region,$re['MD_STD_REG_ID'],$country,$p['PORT_ID'],$d);
					echo '<td align="right">'.number_format($sum).'</td>';
				}
			}}
		echo '</tr>';


		if(!empty($country[$re['MD_STD_REG_ID']])){ 
			foreach($country[$re['MD_STD_REG_ID']] as $co){ 
				
				$padding_country = $level*15;
				echo '<tr class="TR-Parent-'.$re['MD_STD_REG_ID'].'">';
					echo '<td style="padding-left:'.$padding_country.'px;">'.$co['COUNTRY_NAME_EN'].'</td>';
					 if(!empty($port_colunm)){ foreach($port_colunm as $p){ 
						foreach($period as $d){ 
						 	echo "<td align='right'>".@number_format(@$data[$co['COUNTRYID']][$p['PORT_ID']][$d]['NUM'])."</td>";
						} 
					 }}
				echo '</tr>';
	    	}
		}

		genTableData($data,$region,$re['MD_STD_REG_ID'],$country,$port_colunm,$period,$level);

		}
	}

	++$level;

}


function getSumData($data,$region,$region_id,$country,$port_id,$day,&$sum=0){
	if(!empty($country[$region_id])){ 
		foreach($country[$region_id] as $co){ 
			$sum += @$data[$co['COUNTRYID']][$port_id][$day]['NUM'];
		}
	}



	if(!empty($region[$region_id])){ 
		foreach($region[$region_id] as $re){ 
			getSumData($data,$region,$re['MD_STD_REG_ID'],$country,$port_id,$day,$sum);
		}
	}

	return $sum;
}
?>

<?php $this->endSection() ?>

<?=$this->section("scripts")?>
<script type="text/javascript">
$(document).ready(function() {
	$('.date_picker').datepicker({
      format: "dd/mm/yyyy",
      autoclose: true,
      language: 'th-th',
      endDate: new Date('<?php echo $to_date;?>')
    });

    $('#port_all').click(function(){
    	if ($(this).prop('checked')==true){ 
    		$('.port_checkbox').prop('checked', true);
    	}else{
    		$('.port_checkbox').prop('checked', false);
    	}
    });

    $('#port_type_1').click(function(){
    	if ($(this).prop('checked')==true){ 
    		$('.port_1').prop('checked', true);
    	}else{
    		$('.port_1').prop('checked', false);
    	}
    });

    $('#port_type_2').click(function(){
    	if ($(this).prop('checked')==true){ 
    		$('.port_2').prop('checked', true);
    	}else{
    		$('.port_2').prop('checked', false);
    	}
    });
});

function ChangeFilter(){
	var date = $('#start_date1').val();
	date = date.split('/');
	// start_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
	start_date1 = date[0]+'-'+date[1]+'-'+(date[2]-543);

	var date = $('#end_date1').val();
	date = date.split('/');
	// end_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
	end_date1 = date[0]+'-'+date[1]+'-'+(date[2]-543);

	var country_type = $('#country_type').val();
	var port_type = $("input[name='port_type[]']").map(function(){ if($(this).prop('checked')==true){ return $(this).val(); } }).get();
	// console.log(port_type);

	window.location.href = base_url+'/report/port_compare?start1='+start_date1+'&end1='+end_date1+'&country_type='+country_type+'&port_type='+port_type;
}

function ShowHide(reg_id){
	$('.TR-Parent-'+reg_id).toggle();
}

function export_report(type){
	var date = $('#start_date1').val();
	date = date.split('/');
	// start_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
	start_date1 = date[0]+'-'+date[1]+'-'+(date[2]-543);

	var date = $('#end_date1').val();
	date = date.split('/');
	// end_date1 = (date[2]-543)+'-'+date[1]+'-'+date[0];
	end_date1 = date[0]+'-'+date[1]+'-'+(date[2]-543);

	var country_type = $('#country_type').val();
	var port_type = $("input[name='port_type[]']").map(function(){ if($(this).prop('checked')==true){ return $(this).val(); } }).get();
	window.open( base_url+'/report/port_compare/?export_type='+type+'&start1='+start_date1+'&end1='+end_date1+'&country_type='+country_type+'&port_type='+port_type );
}
</script>
<?=$this->endSection()?>
