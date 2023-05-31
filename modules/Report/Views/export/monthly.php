<?php include_once("export_css.php"); ?>
<style>
	.radiusTableNation {
		border-radius: 1em;
		overflow: hidden;
		/* background-color: red; */
	}

	.radiusTableNation tbody tr:nth-of-type(odd) {
		background: rgba(214, 239, 242, 1);
	}

	.table thead th {
		border-bottom: none;
	}

	.radiusTableNation thead th {
		background: rgba(55, 159, 166, 1);
		padding: 16px
			/* font-weight:bold; */
	}

	.table-responsive {
		overflow: auto;
	}
</style>

<table style="width:100%">
	<tr>
		<td class="headderTable">
			<b>รายงานจำนวนนักท่องเที่ยวที่เดินทางเข้าประเทศไทยรายเดือน</b>
		</td>
	</tr>
</table>

<table style="width:100%">
	<tr>
		<td class="headderTable">
			<b>เดือน  <?php foreach($month_label as $m_id=>$name){  if($month==$m_id){ echo $name;  } } ?> ปี <?php echo $year;?></b> 
		</td>
	</tr>
</table>

<table border="1" class="table table-bordered table-striped tbl_nation" style="width:100%">
	<thead>
		<tr>
			<th rowspan="2" >ประเทศ</th>
			<?php foreach($port as $p){ $colspan= 1; if(!empty($point[$p['PORT_ID']])){ $colspan = count($point[$p['PORT_ID']]); }  echo '<th colspan="'.$colspan.'">'.$p['PORT_NAME_FULL'].'</th>'; } ?>
		</tr>
		<tr>
			<?php foreach($port as $p){
				if(!empty($point[$p['PORT_ID']])){ 
					foreach($point[$p['PORT_ID']] as $po){
						echo '<th>'.@$po['POINT_NAME'].'</th>';
					} 
				}else{
					echo '<th></th>';
				}
			 }?>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($data as $d){ ?>
		<tr>
			<td><?php echo $d['COUNTRY_NAME_EN']?></td>
			<?php foreach($port as $p){
				if(!empty($point[$p['PORT_ID']])){ 
					foreach($point[$p['PORT_ID']] as $po){
						echo '<td>'.@$d['NUM'][$p['PORT_ID']][$po['POINT_ID']].'</td>';
					} 
				}else{
					echo '<td>'.@$d['NUM'][$p['PORT_ID']][0].'</td>';
				}
			 }?>
		</tr>
	<?php }?>
	</tbody>
</table>