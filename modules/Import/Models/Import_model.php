<?php
namespace Modules\Import\Models;
use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Mydate;
use App\Libraries\Hash;
class Import_model extends Model
{
	protected $table = 'REPORT_RAW_DATA';
	protected $table_month = 'CAL_MONTHLY_REPORT';
  	protected $primaryKey = 'REC_ID';
  	protected $allowedFields = [];

	function import_file($input,$xlsx){
		$session = session();
		$this->Mydate = new Mydate();
		$REPORT_DATE = $this->Mydate->date_thai2eng($input['REPORT_DATE'],-543);

		$builder_del = $this->db->table($this->table);
		$builder_del->where("to_char(REPORT_DATE,'YYYY-MM-DD')", $REPORT_DATE);
		$builder_del->delete();

		$temp_PORT = $temp_visa = $temp_country = array();

		list($year, $month, $day) = explode('-', $REPORT_DATE);
		$countData = 0; $text=' Report Date :: '.$day.'/'.$month.'/'.$year.'<br>';
		foreach($xlsx->rows() as $key => $row){
			$PORT['PORT_ID'] = $visa['VISA_ID'] = $country['COUNTRY_ID'] = null;
			if(is_numeric($row[6])){

				if(empty($temp_PORT[$row[4]])){
					$builder_PORT = $this->db->table('MD_PORT');
					$builder_PORT->select('PORT_ID');
					$builder_PORT->where('PORT_NAME',$row[4]);
					$builder_PORT->where('PORT_DAILY',1);
					$PORT = $builder_PORT->get()->getRowArray();
					if(!empty($PORT['PORT_ID'])){
						$temp_PORT[$row[4]] = $PORT['PORT_ID'];
					}
				}else{
					$PORT['PORT_ID'] = $temp_PORT[$row[4]];
				}
				
				if(empty($temp_visa[$row[3]])){
					$builder_visa = $this->db->table('MD_VISA');
					$builder_visa->select('VISA_ID');
					$builder_visa->where('VISA_NAME',$row[3]);
					$visa = $builder_visa->get()->getRowArray();
					if(!empty($visa['VISA_ID'])){
						$temp_visa[$row[3]] = $visa['VISA_ID'];
					}
				}else{
					$visa['VISA_ID'] = $temp_visa[$row[3]];
				}

				if(empty($temp_country[$row[2]])){
					$builder_country = $this->db->table('MD_COUNTRY');
					$builder_country->select('COUNTRYID AS COUNTRY_ID');
					$builder_country->where('COUNTRY_NAME_TH2',$row[2]);
					$country = $builder_country->get()->getRowArray();
					if(!empty($country['COUNTRY_ID'])){
						$temp_country[$row[2]] = $country['COUNTRY_ID'];
					}
				}else{
					$country['COUNTRY_ID'] = $temp_country[$row[2]];
				}


				if(empty($country['COUNTRY_ID'])){
					switch ( trim($row[2])) {
						case 'ไม่มีสัญชาติ':
							$country['COUNTRY_ID'] = 275;
							break;
						case 'บริติช (OVERSEAS)':
							$country['COUNTRY_ID'] = 274;
							break;
						case 'ดินามาร์คซ':
							$country['COUNTRY_ID'] = 102;
							break;
						case 'คอซอวอ':
							$country['COUNTRY_ID'] = 43;
							break;
						case 'กินี':
							$country['COUNTRY_ID'] = 192;
							break;
						case 'โคโลนีอังกฤษ':
							$country['COUNTRY_ID'] = 1;
							break;
						case 'รัฐเอกราชซามัว':
							$country['COUNTRY_ID'] = 258;
							break;
						case 'ซาอีร์':
							$country['COUNTRY_ID'] = 183;
							break;
						case 'สาธารณรัฐซิมบับเว (ZWE)':
							$country['COUNTRY_ID'] = 185;
							break;
						case 'ไดโต':
							$country['COUNTRY_ID'] = 122;
							break;
						case 'สาธารณรัฐติมอร์ตะวันออก':
							$country['COUNTRY_ID'] = 151;
							break;
						case 'ทรัสต์แปซิฟิค':
							$country['COUNTRY_ID'] = 242;
							break;
						case 'มาเรียนา':
							$country['COUNTRY_ID'] = 131;
							break;
						case 'สหพันธ์สาธารณรัฐยูโกสลาเวีย':
							$country['COUNTRY_ID'] = 43;
							break;
						case 'ยูโทเปีย':
							$country['COUNTRY_ID'] = 91;
							break;
						case 'ยูเอส ไมเนอร์ เอ๊าไลน์นิ่ง ไอร์แลนด์':
							$country['COUNTRY_ID'] = 261;
							break;
						case 'เยเมนเหนือ':
							$country['COUNTRY_ID'] = 39;
							break;
						case 'เยอรมันตะวันออก':
							$country['COUNTRY_ID'] = 48;
							break;
						case 'นครรัฐวาติกัน':
							$country['COUNTRY_ID'] = 88;
							break;
						case 'สก็อตแลนด์':
							$country['COUNTRY_ID'] = 274;
							break;
						case 'สฟาลบาร์และหมู่เกาะยานไมเอน':
							$country['COUNTRY_ID'] = 105;
							break;
						case 'อัลมาดินา':
							$country['COUNTRY_ID'] = 37;
							break;
						case 'อังกฤษ-ฮ่องกง':
							$country['COUNTRY_ID'] = 156;
							break;
						case 'สาธารณรัฐเซาท์ซูดาน':
							$country['COUNTRY_ID'] = 235;
							break;
						case 'เฟรนช์โปลินีเซีย':
							$country['COUNTRY_ID'] = 256;
							break;
						case 'ปรินซีเบิล':
							$country['COUNTRY_ID'] = 0;
							break;
						case 'ซินต์มาร์เติน':
							$country['COUNTRY_ID'] = 139;
							break;
						case 'กรีนแลนเดอร์':
							$country['COUNTRY_ID'] = 109;
							break;
						case 'กัวมาเนียน':
							$country['COUNTRY_ID'] = 248;
							break;
						case 'กาวเดอลูเปียน':
							$country['COUNTRY_ID'] = 6;
							break;
						case 'กิเนียน':
							$country['COUNTRY_ID'] = 192;
							break;
						case 'คูราเชาอัน':
							$country['COUNTRY_ID'] = 16;
							break;
						case 'หมู่เกาะโบเวท':
							$country['COUNTRY_ID'] = 174;
							break;
						case 'ไอล์ออฟแมน':
							$country['COUNTRY_ID'] = 80;
							break;
						case 'ยูเอส ไมเนอร์ เอ๊าไลน์นิ่ง ไอร์แลนด์':
							$country['COUNTRY_ID'] = 261;
							break;
						case 'เดอวอยต์':
							$country['COUNTRY_ID'] = 193;
							break;
						case 'ซาอีเรียน':
							$country['COUNTRY_ID'] = 184;
							break;
						case 'เจอร์ซีย์':
							$country['COUNTRY_ID'] = 77;
							break;
						case 'เกิร์นซีย์':
							$country['COUNTRY_ID'] = 76;
							break;
						case 'อัลมาดินา':
							$country['COUNTRY_ID'] = 37;
							break;
						case 'ซิมบับเว (ZWE)':
							$country['COUNTRY_ID'] = 185;
							break;
						case 'แซ็ง-บาร์เตเลมี':
							$country['COUNTRY_ID'] = 138;
							break;
						case 'ยูโกสลาฟ':
							$country['COUNTRY_ID'] = 43;
							break;
						case 'เซนต์ปิแอร์และมิคิวลอน':
							$country['COUNTRY_ID'] = 140;
							break;
						case 'ติมอร์ตะวันออก':
							$country['COUNTRY_ID'] = 151;
							break;
						case 'สฟาลบาร์และหมู่เกาะยานไมเอน':
							$country['COUNTRY_ID'] = 105;
							break;
						case 'นิวคาลิโตเนียน':
							$country['COUNTRY_ID'] = 247;
							break;
						case 'สก็อตติช':
							$country['COUNTRY_ID'] = 274;
							break;
						case 'แอนทาร์ติก้า':
							$country['COUNTRY_ID'] = 173;
							break;
						case 'โบแนเรอ':
							$country['COUNTRY_ID'] = 25;
							break;
						case 'เบอร์มูดาน':
							$country['COUNTRY_ID'] = 11;
							break;
						case 'สาธารณรัฐโบพูทัตสวา':
							$country['COUNTRY_ID'] = 229;
							break;
						case 'ฟรานส์ เมโทรโปริแทรน':
							$country['COUNTRY_ID'] = 78;
							break;
						case 'เฟรนช์เซาเทิร์นและแอนตาร์กติกแลนส์':
							$country['COUNTRY_ID'] = 92;
							break;
						case 'เฟรนช์โปลินีเซีย':
							$country['COUNTRY_ID'] = 256;
							break;
						case 'มาร์ตินิก':
							$country['COUNTRY_ID'] = 26;
							break;
						case 'เยเมนเหนือ':
							$country['COUNTRY_ID'] = 39;
							break;
						case 'เยอรมนีตะวันออก':
							$country['COUNTRY_ID'] = 70;
							break;
						case 'ซามัว':
							$country['COUNTRY_ID'] = 258;
							break;
						case 'เรอุนยอง':
							$country['COUNTRY_ID'] = 222;
							break;
						case 'สเปนิชซาฮารา':
							$country['COUNTRY_ID'] = 90;
							break;
						case 'แอฟริกันกลาง':
							$country['COUNTRY_ID'] = 186;
							break;
						case 'หมู่เกาะคะแนรี':
							$country['COUNTRY_ID'] = 230;
							break;
						case 'คาโรไลน์':
							$country['COUNTRY_ID'] = 162;
							break;
						case 'เคย์แมน':
							$country['COUNTRY_ID'] = 13;
							break;
						case 'หมู่เกาะโคโคส, หมู่เกาะคีลิง':
							$country['COUNTRY_ID'] = 153;
							break;
						case 'มาเรียนัน':
							$country['COUNTRY_ID'] = 260;
							break;
						case 'โคโลนีอังกฤษ':
							$country['COUNTRY_ID'] = 1;
							break;
						case 'พิตแคร์น':
							$country['COUNTRY_ID'] = 252;
							break;
						case 'หมู่เกาะฟอล์กแลนด์ (มัลบีนัส)':
							$country['COUNTRY_ID'] = 129;
							break;
						case 'แฟโรส์':
							$country['COUNTRY_ID'] = 107;
							break;
						case 'มาเดรา':
							$country['COUNTRY_ID'] = 75;
							break;
						case 'เวอร์จิน':
							$country['COUNTRY_ID'] = 14;
							break;
						case 'ไดโต':
							$country['COUNTRY_ID'] = 122;
							break;
						case 'แองกูล่า':
							$country['COUNTRY_ID'] = 20;
							break;
						case 'ฮ่องกง-อังกฤษ':
							$country['COUNTRY_ID'] = 156;
							break;
						case 'กรีนแลนด์':
							$country['COUNTRY_ID'] = 109;
							break;
						case 'เฟรนช์เกียนา':
							$country['COUNTRY_ID'] = 132;
							break;
						case 'ทรัสต์แปซิฟิก':
							$country['COUNTRY_ID'] = 242;
							break;
						case 'กะลาลลิตนูนาต':
							$country['COUNTRY_ID'] = 109;
							break;
						case 'ผู้อพยพ (1951 CONVENTION)':
							$country['COUNTRY_ID'] = 'other';
							break;
						case 'ผู้อพยพ (อื่นๆ)':
							$country['COUNTRY_ID'] = 'other';
							break;
						case 'หน่วยงานพิเศษ ยูเอ็น':
							$country['COUNTRY_ID'] = 'other';
							break;
						case 'หน่วยงานพิเศษยูเอ็น':
							$country['COUNTRY_ID'] = 'other';
							break;
						case 'ยูเอ็น':
							$country['COUNTRY_ID'] = 'other';
							break;
						case 'องค์การสหประชาชาติ':
							$country['COUNTRY_ID'] = 'other';
							break;
						case 'องค์การสหประชาชาติ  ':
							$country['COUNTRY_ID'] = 'other';
							break;
						case 'ไม่ทราบ':
							$country['COUNTRY_ID'] = 'other';
							break;
						
						default:
							$country['COUNTRY_ID'] = null;
							break;
					}
				}

				// $text .= ' NATION :: '.$country['COUNTRY_ID'].' -- '.$row[2].'<br>';
				if(!empty($PORT['PORT_ID']) && !empty($visa['VISA_ID']) && @$country['COUNTRY_ID'] != null  ) {
					// $builder = $this->db->table($this->table);
					// $builder->select('NUM');
					// $builder->where('COUNTRY_ID',$country['COUNTRY_ID']);
					// $builder->where('VISA_ID',$visa['VISA_ID']);
					// $builder->where('OFFICE_ID',$PORT['PORT_ID']);
					// $builder->where('REPORT_DATE', 'to_date(' . '\'' . $this->Mydate->date_thai2eng($input['REPORT_DATE'], -543) . '\'' . ',\'YYYY-MM-DD\')', false);
					// $builder->where('DIRECTION',$row[1]);
					// $data = $builder->get()->getRowArray();
					// if(!empty($data['NUM'])){
					// 	$NUM = $row[6]+$data['NUM'];
					// 	$builder = $this->db->table($this->table);
					// 	$builder->set('NUM',$NUM);
					// 	$builder->where('DIRECTION',$row[1]);
					// 	$builder->where('REPORT_DATE', 'to_date(' . '\'' . $this->Mydate->date_thai2eng($input['REPORT_DATE'], -543) . '\'' . ',\'YYYY-MM-DD\')', false);
					// 	$builder->where('COUNTRY_ID',$country['COUNTRY_ID']);
					// 	$builder->where('VISA_ID',$visa['VISA_ID']);
					// 	$builder->where('OFFICE_ID',$PORT['PORT_ID']);
					// 	$builder->update();
					// }else{
					// 	$NUM = $row[6];
					// 	$builder = $this->db->table($this->table);
					// 	$builder->set('REPORT_DATE', 'to_date(' . '\'' . $this->Mydate->date_thai2eng($input['REPORT_DATE'], -543) . '\'' . ',\'YYYY-MM-DD\')', false);
					// 	$builder->set('DIRECTION',$row[1]);
					// 	$builder->set('NATION',$row[2]);
					// 	$builder->set('VISA',$row[3]);
					// 	$builder->set('OFFICE',$row[4]);
					// 	$builder->set('HEAD_OFFICE',$row[5]);
					// 	$builder->set('NUM',$NUM);
					// 	$builder->set('COUNTRY_ID',$country['COUNTRY_ID']);
					// 	$builder->set('VISA_ID',$visa['VISA_ID']);
					// 	$builder->set('OFFICE_ID',$PORT['PORT_ID']);
					// 	$builder->insert();
					// }
					if($country['COUNTRY_ID'] =='other'){
						$country['COUNTRY_ID'] = 0;
					}

					$NUM = $row[6];
					$builder = $this->db->table($this->table);
					$builder->set('REPORT_DATE', 'to_date(' . '\'' . $this->Mydate->date_thai2eng($input['REPORT_DATE'], -543) . '\'' . ',\'YYYY-MM-DD\')', false);
					$builder->set('DIRECTION',$row[1]);
					$builder->set('NATION',$row[2]);
					$builder->set('VISA',$row[3]);
					$builder->set('OFFICE',$row[4]);
					$builder->set('HEAD_OFFICE',$row[5]);
					$builder->set('NUM',$NUM);
					$builder->set('COUNTRY_ID',$country['COUNTRY_ID']);
					$builder->set('VISA_ID',$visa['VISA_ID']);
					$builder->set('OFFICE_ID',$PORT['PORT_ID']);
					$builder->insert();

					$countData++;
				}else{
					$text .= 'Row '.$key.' Fail! ';
					if(empty($PORT['PORT_ID'])){
						$text .= ' OFFICE :: '.$row[4];
					}

					if(empty($visa['VISA_ID'])){
						$text .= ' VISA :: '.$row[3];
					}

					if(empty($country['COUNTRY_ID']) || @$country['COUNTRY_ID'] != 0){
						$text .= ' NATION :: '.$row[2];
					}
					$text .= '<br>';
				}				
			}
		}

		$text .= 'Insert Data Complete : '.$countData.' Row';

		list($year, $month, $day) = explode('-', $REPORT_DATE);
		$this->updateCalReportDaily($year,$month,$day);

		return $text;

	}

	function updateCalReportDaily($year,$month,$day=''){
		$builder_delete = $this->db->table('REPORT_CAL_DAILY');
		if($day){ $builder_delete->where("TO_CHAR( REPORT_DATE, 'DD') = ",$day); }
		$builder_delete->where("TO_CHAR( REPORT_DATE, 'MM') = ",intval($month));
	    $builder_delete->where("TO_CHAR( REPORT_DATE, 'YYYY') = ",$year);
		$builder_delete->delete();

		$builder = $this->db->table('CAL_DAILY_REPORT');
		if($day){ $builder->where("TO_CHAR( REPORT_DATE, 'DD') = ",$day); }
	    $builder->where("TO_CHAR( REPORT_DATE, 'MM') = ",intval($month));
	    $builder->where("TO_CHAR( REPORT_DATE, 'YYYY') = ",$year);
	    $data = $builder->get()->getResultArray();

		foreach ($data as $key => $value) {
			$builder_insert = $this->db->table('REPORT_CAL_DAILY');
			$builder_insert->set('COUNTRY_ID',$value['COUNTRY_ID']);
			$builder_insert->set('REPORT_DATE',$value['REPORT_DATE']);
			$builder_insert->set('OFFICE_ID',$value['OFFICE_ID']);
			$builder_insert->set('COUNTRY_NAME_TH',$value['COUNTRY_NAME_TH']);
			$builder_insert->set('COUNTRY_NAME_EN',$value['COUNTRY_NAME_EN']);
			$builder_insert->set('SUM',$value['SUM']);
			$builder_insert->insert();
		}
	}

	function clearDataDaily(){
		$builder = $this->db->table($this->table);
	    $builder->select(" COUNT(NUM) AS CC,
	    					SUM(NUM) AS SUM,
						    REPORT_RAW_DATA.OFFICE_ID, 
						    REPORT_RAW_DATA.VISA_ID,
						    REPORT_RAW_DATA.COUNTRY_ID,
						    TO_CHAR(REPORT_DATE, 'YYYY-MM-DD') AS REPORT_DATE_CHAR,
						    REPORT_RAW_DATA.REPORT_DATE");
	    $builder->where('DIRECTION','ขาเข้า');
	    $builder->where('COUNTRY_ID <>',0);
	    $builder->orderBy("REPORT_DATE");
	    $builder->groupBy("REPORT_RAW_DATA.OFFICE_ID , 
						    REPORT_RAW_DATA.VISA_ID,
						    REPORT_RAW_DATA.COUNTRY_ID,
						    REPORT_RAW_DATA.REPORT_DATE");
	    $builder->having("COUNT(NUM) > ",1);
	    $data = $builder->get()->getResultArray();
	   	foreach($data as $row){
	   		if($row['CC'] > 1){

	   			$builder = $this->db->table($this->table);
				$builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$row['REPORT_DATE_CHAR']);
				$builder->where('DIRECTION','ขาเข้า');
				$builder->where('COUNTRY_ID',$row['COUNTRY_ID']);
				$builder->where('VISA_ID',$row['VISA_ID']);
				$builder->where('OFFICE_ID',$row['OFFICE_ID']);
				$builder->delete();

	   			// echo $row['REPORT_DATE'].' '.$row['COUNTRY_ID'].' || '.$row['CC'].'<br>';

	   			$builder = $this->db->table($this->table);
				$builder->set('NUM',$row['SUM']);
				$builder->set('REPORT_DATE', 'to_date(' . '\'' . $row['REPORT_DATE_CHAR'] . '\'' . ',\'YYYY-MM-DD\')', false);
				$builder->set('DIRECTION','ขาเข้า');
				$builder->set('COUNTRY_ID',$row['COUNTRY_ID']);
				$builder->set('VISA_ID',$row['VISA_ID']);
				$builder->set('OFFICE_ID',$row['OFFICE_ID']);
				$builder->insert();
	   		}
			
	   	}
	}

	function getRawData($date){
		$builder = $this->db->table($this->table);
	    $builder->select("{$this->table}.*, TO_CHAR(REPORT_DATE, 'DD/MM/YYYY') AS REPORT_DATE_CHAR");
	    $builder->where("TO_CHAR( {$this->table}.REPORT_DATE, 'YYYY-MM-DD') = ",$date);
	    $builder->where('DIRECTION','ขาเข้า');
	    $builder->orderBy("REPORT_DATE");
	    // $builder->limit(500);
	    $data = $builder->get()->getResultArray();
	    return $data;
	}

	function import_file_monthly($input,$xlsx){
		$count = 1; $text = '';
	    foreach($xlsx->rows() as $row){
	      // echo '<pre>'; print_r($row); echo '</pre>';
	      $country_name = strtoupper($row['0']);

	      $builder = $this->db->table('MD_COUNTRY');
	      $builder->select('COUNTRYID');
	      $builder->like('COUNTRYSHORTNAMEEN', trim($country_name).'%');
	      $co = $builder->get()->getRowArray();

	      if(trim($country_name) == 'South Africa'){
	        $co['COUNTRYID'] = '225';
	      }else if(trim($country_name) == 'USA'){
	        $co['COUNTRYID'] = '131';
	      }else if( trim($country_name) == 'UNITED  KINGDOM' || trim($country_name) == 'UNITEDKINGDOM'){
	        $co['COUNTRYID'] = '274';
	      }else if( trim($country_name) == 'SRI  LANKA' || trim($country_name) == 'SRILANKA'){
	        $co['COUNTRYID'] = '170';
	      }else if( trim($country_name) == 'NEW  ZEALAND' || trim($country_name) == 'NEWZEALAND'){
	        $co['COUNTRYID'] = '240';
	      }else if( trim($country_name) == 'SAUDI  ARABIA' || trim($country_name) == 'SAUDIARABIA'){
	        $co['COUNTRYID'] = '37';
	      }else if( trim($country_name) == 'FRANCE' ){
	        $co['COUNTRYID'] = '69';
	      }else if( trim($country_name) == 'NETHERLANDS' ){
	        $co['COUNTRYID'] = '72';
	      }else if( trim($country_name) == 'HONG KONG (CHINA)' ){
	        $co['COUNTRYID'] = '156';
	      }else if( trim($country_name) == "DEMOCRATIC PEOPLE'S REPUBLIC OF KOREA" ){
	        $co['COUNTRYID'] = '159';
	      }else if( trim($country_name) == 'KOREA (REPUBLIC OF)' ){
	        $co['COUNTRYID'] = '158';
	      }else if( trim($country_name) == 'MACAO (CHINA)' ){
	        $co['COUNTRYID'] = '160';
	      }else if( trim($country_name) == 'BELGIUN' ){
	        $co['COUNTRYID'] = '68';
	      }else if( trim($country_name) == 'RUSSIAN FEDERATION' ){
	        $co['COUNTRYID'] = '62';
	      }else if( trim($country_name) == 'UNITED STATES OF AMERICA' ){
	        $co['COUNTRYID'] = '131';
	      }else if( trim($country_name) == 'SOUTH AFRICA' ){
	        $co['COUNTRYID'] = '225';
	      }


	      if(!empty($co['COUNTRYID'])){
	        
	        // echo $co['COUNTRYID'].' '.$country_name.'<br>';
	        $OUTBOUND_MOTS = str_replace(',','',$row['1']);
	        $OUTBOUND_GROWTH_RATE_MOTS = $row['3'];
	        $RECEIPTS = '';
	        $RECEIPTS_CHANGE = '';
	        if($row['4']!='-'){
	          $RECEIPTS = str_replace(',','',$row['4']);
	        }

	        if($row['6']!='-'){
	          $RECEIPTS_CHANGE = $row['6'];
	        }

	        $builder_dep = $this->db->table('MD_DEP_MARKET');
	        $builder_dep->select('*');
	        $builder_dep->where('MARKET_COUNTRY_ID',$co['COUNTRYID']);
	        $dep = $builder_dep->get()->getResultArray();
	        foreach($dep as $d){
	          $count++;
	          if(!empty($d['MARKET_COUNTRY_ID'])){
	            
	            $builder_import = $this->db->table('INTER_GENERAL_INFO');
	            $builder_import->set('OUTBOUND_MOTS',$OUTBOUND_MOTS);
	            $builder_import->set('OUTBOUND_GROWTH_RATE_MOTS',$OUTBOUND_GROWTH_RATE_MOTS);
	            $builder_import->set('INCOME_MOTS',$RECEIPTS);
	            $builder_import->set('INCOME_MOTS_CHANGE',$RECEIPTS_CHANGE);


	            $builder = $this->db->table('INTER_GENERAL_INFO');
	            $builder->select('INTER_ID');
	            $builder->where('REGION_ID',$d['REGION_ID']);
	            $builder->where('DEP_ID',$d['DEP_ID']);
	            $builder->where('YEAR',($input['year']));
	            $builder->where('MONTH',$input['month']);
	            $builder->where('MARKET_ID',$d['MARKET_ID']);
	            $inter = $builder->get()->getRowArray();
	            if(empty($inter['INTER_ID'])){

	              $builder_import->set('REGION_ID',$d['REGION_ID']);
	              $builder_import->set('DEP_ID',$d['DEP_ID']);
	              $builder_import->set('YEAR',($input['year']));
	              $builder_import->set('MONTH',$input['month']);
	              $builder_import->set('MARKET_ID',$d['MARKET_ID']);
	              $builder_import->insert();

	              // echo ' - INSERT '.$country_name.' ID : '.$d['MARKET_ID'].' - '.$d['MARKET_NAME'].' == '.$OUTBOUND_MOTS.'/'.$OUTBOUND_GROWTH_RATE_MOTS.'<br>';
	            }else{
	              $builder_import->where('INTER_ID',$inter['INTER_ID']);
	              $builder_import->update();

	              // echo ' - UPDATE '.$country_name.' ID : '.$d['MARKET_ID'].' - '.$d['MARKET_NAME'].' == '.$OUTBOUND_MOTS.'/'.$OUTBOUND_GROWTH_RATE_MOTS.'<br>';

	            }

	          } 
	        }
	      }else{
	      	if($row['1']!=''){
	      		// $text .= 'Fail!!! - '.trim($country_name).'<br>';
	      	}
	      }      
	    }

	    $text .= 'Insert Data Complete : '.$count.' Row';

	    return $text;
	}

	function getDataMonthly($year){
		$builder = $this->db->table($this->table_month);
	    $builder->select("MD_COUNTRY.COUNTRYID, MD_COUNTRY.COUNTRY_NAME_EN, {$this->table_month}.* ");
	    $builder->join('MD_COUNTRY',"MD_COUNTRY.COUNTRYID = {$this->table_month}.COUNTRY_ID");
	    $builder->where("{$this->table_month}.YEAR",$year);
	    $builder->orderBy("{$this->table_month}.MONTH, {$this->table_month}.COUNTRY_ID ");
		$res = $builder->get()->getResultArray();

		return $res;
	}

	function import_file_raw_monthly_TH($input,$xlsx){
		$count = 1; $text = '';
		$port_id = $point_id = array();

		$builder_import = $this->db->table('REPORT_RAW_MONTHLY');
		$builder_import->where('MONTH',$input['month']);
        $builder_import->where('YEAR',$input['year']);
        $builder_import->delete();

	    foreach($xlsx->rows() as $row_id=> $row){
	    	
	    	if($row_id == 6){
	    		foreach($row as $col_id=> $col){
	    			if($col_id >=7 && $col_id<=44){

	    				$builder = $this->db->table('MD_PORT');
			      		$builder->select('PORT_ID');
				      	$builder->where('PORT_NAME_FULL', trim($col));
				      	$port = $builder->get()->getRowArray();
				      	if(!empty($port['PORT_ID'])){
				      		$port_id[$col_id] = $port['PORT_ID'];
				      		echo $col_id.' == '.$port['PORT_ID'].' == ';
				      	}
				      	echo $col.'<br>';
	    			}
	    			
	    		}
	    	}

	    	if($row_id == 7){
	    		foreach($row as $col_id=> $col){
	    			if($col_id >=7 && $col_id<=44){
	    				
	    				$builder = $this->db->table('MD_PORT_POINT');
			      		$builder->select('*');
				      	$builder->where('POINT_NAME', trim($col));
				      	$port = $builder->get()->getRowArray();
				      	if(!empty($port['POINT_ID'])){
				      		$point_id[$col_id] = $port['POINT_ID'];
				      		// echo $port['PORT_ID'].' == '.$port['POINT_ID'].' == ';
				      	}
				      	// echo $col.'<br>';
	    			}
	    		}
	    	}

	    	if($row_id >= 8 ){
		    	// $country_name = strtoupper($row[4]);
		    	$country_name = $row[5];
		    	// echo $country_name;
		    	$builder = $this->db->table('MD_COUNTRY');
		      	$builder->select('COUNTRYID AS COUNTRY_ID');
				$builder->where('COUNTRY_NAME_TH2',$country_name);
		      	$country = $builder->get()->getRowArray();

		      	if(empty($country['COUNTRY_ID'])){
					if($country_name=='ไม่มีสัญชาติ'){
						$country['COUNTRY_ID'] = 275;
					}else if( $country_name=='บริติช (OVERSEAS)'){
						$country['COUNTRY_ID'] = 274;
					}else if( $country_name=='ดินามาร์คซ'){
						$country['COUNTRY_ID'] = 102;
					}else if( $country_name=='คอซอวอ'){
						$country['COUNTRY_ID'] = 43;
					}else if( $country_name=='กินี'){
						$country['COUNTRY_ID'] = 192;
					}else if( $country_name=='โคโลนีอังกฤษ'){
						$country['COUNTRY_ID'] = 1;
					}else if( $country_name=='รัฐเอกราชซามัว'){
						$country['COUNTRY_ID'] = 244;
					}else if( $country_name=='ซาอีร์'){
						$country['COUNTRY_ID'] = 183;
					}else if( $country_name=='สาธารณรัฐซิมบับเว (ZWE)'){
						$country['COUNTRY_ID'] = 185;
					}else if( $country_name=='ไดโต'){
						$country['COUNTRY_ID'] = 122;
					}else if( $country_name=='สาธารณรัฐติมอร์ตะวันออก'){
						$country['COUNTRY_ID'] = 151;
					}else if( $country_name=='ทรัสต์แปซิฟิค'){
						$country['COUNTRY_ID'] = 242;
					}else if( $country_name=='มาเรียนา'){
						$country['COUNTRY_ID'] = 131;
					}else if( $country_name=='สหพันธ์สาธารณรัฐยูโกสลาเวีย'){
						$country['COUNTRY_ID'] = 43;
					}else if( $country_name=='ยูโทเปีย'){
						$country['COUNTRY_ID'] = 91;
					}else if( $country_name=='ยูเอส ไมเนอร์ เอ๊าไลน์นิ่ง ไอร์แลนด์'){
						$country['COUNTRY_ID'] = 261;
					}else if( $country_name=='เยเมนเหนือ'){
						$country['COUNTRY_ID'] = 39;
					}else if( $country_name=='เยอรมันตะวันออก'){
						$country['COUNTRY_ID'] = 48;
					}else if( $country_name=='นครรัฐวาติกัน'){
						$country['COUNTRY_ID'] = 88;
					}else if( $country_name=='สก็อตแลนด์'){
						$country['COUNTRY_ID'] = 274;
					}else if( $country_name=='สฟาลบาร์และหมู่เกาะยานไมเอน'){
						$country['COUNTRY_ID'] = 105;
					}else if( $country_name=='อัลมาดินา'){
						$country['COUNTRY_ID'] = 37;
					}else if( $country_name=='อังกฤษ-ฮ่องกง'){
						$country['COUNTRY_ID'] = 156;
					}else if( $country_name=='สาธารณรัฐเซาท์ซูดาน'){
						$country['COUNTRY_ID'] = 235;
					}else if( $country_name=='เฟรนช์โปลินีเซีย'){
						$country['COUNTRY_ID'] = 256;
					}else if( $country_name=='ปรินซีเบิล'){
						$country['COUNTRY_ID'] = 0;
					}else if( $country_name=='ผู้อพยพ (1951 CONVENTION)'){
						$country['COUNTRY_ID'] = 0;
					}else if( $country_name=='ผู้อพยพ (อื่นๆ)'){
						$country['COUNTRY_ID'] = 0;
					}else if( $country_name=='หน่วยงานพิเศษ ยูเอ็น'){
						$country['COUNTRY_ID'] = 0;
					}else if( $country_name=='ยูเอ็น'){
						$country['COUNTRY_ID'] = 0;
					}else if( $country_name=='องค์การสหประชาชาติ'){
						$country['COUNTRY_ID'] = 0;
					}

				}

		      	if(!empty($country['COUNTRY_ID'])){
		      		$count++;
		      		// echo ':: '.$co['COUNTRYID'].' == ';
		      		foreach($row as $col_id=> $col){
		    			if($col_id >= 7){
			    			if($col_id >=7 && $col_id<=44){
		    					// echo @$port_id[$col_id].'='.@$point_id[$col_id].'='.$col.' || ';
			    				$builder_import = $this->db->table('REPORT_RAW_MONTHLY');
					            $builder_import->set('COUNTRY_ID',$country['COUNTRY_ID']);
					            $builder_import->set('PORT_ID',@$port_id[$col_id]);
					            $builder_import->set('POINT_ID',@$point_id[$col_id]);
					            $builder_import->set('NUM',$col);
					            $builder_import->set('MONTH',$input['month']);
					            $builder_import->set('YEAR',$input['year']);
					            $builder_import->insert();
		    				}
		    			}
		    		}
		      	}else{
		      		$text .= 'Fail :: Row - '.$row_id.' '.trim($country_name).'<br>';
		      	}
	    	}
	    }

	    $text .= 'Insert Data Complete : '.$count.' Row';

	    return $text;
	}



	function import_file_raw_monthly($input,$xlsx){
		$fail = false;
		$count = 1; $text = '';
		$port_id = $point_id = array();

		$builder_import = $this->db->table('REPORT_RAW_MONTHLY');
		$builder_import->where('MONTH',$input['month']);
        $builder_import->where('YEAR',$input['year']);
        $builder_import->delete();

	    foreach($xlsx->rows() as $row_id=> $row){
	    	
	    	if($row_id == 6){
	    		foreach($row as $col_id=> $col){
	    			if($col_id >=7 && $col_id<=44){

	    				$builder = $this->db->table('MD_PORT');
			      		$builder->select('PORT_ID');
				      	$builder->where('PORT_NAME_FULL', trim($col));
				      	$builder->where('PORT_MONTHLY',1);
				      	$port = $builder->get()->getRowArray();
				      	if(!empty($port['PORT_ID'])){
				      		$port_id[$col_id] = $port['PORT_ID'];
				      		// echo $col_id.' == '.$port['PORT_ID'].' == ';
				      	}
				      	// echo $col.'<br>';
	    			}
	    			
	    		}
	    	}

	    	if($row_id == 7){
	    		foreach($row as $col_id=> $col){
	    			if($col_id >=7 && $col_id<=44){
	    				
	    				$builder = $this->db->table('MD_PORT_POINT');
			      		$builder->select('*');
			      		$builder->where('POINT_MONTHLY',1);
				      	$builder->where('POINT_NAME', trim($col));
				      	$port = $builder->get()->getRowArray();
				      	if(!empty($port['POINT_ID'])){
				      		$point_id[$col_id] = $port['POINT_ID'];
				      		// echo $port['PORT_ID'].' == '.$port['POINT_ID'].' == ';
				      	}
				      	// echo $col.'<br>';
	    			}
	    		}
	    	}

	    	if($row_id >= 8 ){
		    	$country_name = strtoupper($row[4]);
		    	// echo $country_name;
		    	$builder = $this->db->table('MD_COUNTRY');
	      		$builder->select('COUNTRYID');
		      	$builder->like('COUNTRYSHORTNAMEEN', trim($country_name).'%');
		      	$co = $builder->get()->getRowArray();

		      	$country_name2 = str_replace(' ', '', $country_name);

		      	// switch ($country_name) {
				//   	case "South Africa":
				//      	$co['COUNTRYID'] = '225';
				//     	break;
			    // 	case "USA":
				//      	$co['COUNTRYID'] = '131';
				//     	break;
			    //   	default:
			    //   	 	$co['COUNTRYID'] = '';
			    // }

		      	if(trim($country_name) == 'South Africa' || $country_name2 == 'SOUTHAFRICA'){
			        $co['COUNTRYID'] = '225';
			      }else if(trim($country_name) == 'USA' || $country_name == 'UNITED STATE OF AMERICA'){
			        $co['COUNTRYID'] = '131';
			      }else if( trim($country_name) == 'UNITED  KINGDOM' || trim($country_name) == 'UNITEDKINGDOM'){
			        $co['COUNTRYID'] = '274';
			      }else if( trim($country_name) == 'SRI  LANKA' || trim($country_name) == 'SRILANKA'){
			        $co['COUNTRYID'] = '170';
			      }else if( trim($country_name) == 'NEW  ZEALAND' || trim($country_name) == 'NEWZEALAND'){
			        $co['COUNTRYID'] = '240';
			      }else if( trim($country_name) == 'SAUDI  ARABIA' || trim($country_name) == 'SAUDIARABIA'){
			        $co['COUNTRYID'] = '37';
			      }else if( trim($country_name) == 'FRANCE' ){
			        $co['COUNTRYID'] = '69';
			      }else if( trim($country_name) == 'NETHERLANDS' ){
			        $co['COUNTRYID'] = '72';
			      }else if( trim($country_name) == 'HONG KONG (CHINA)' ){
			        $co['COUNTRYID'] = '156';
			      }else if( trim($country_name) == "DEMOCRATIC PEOPLE'S REPUBLIC OF KOREA" || $country_name == "KOREA (DEM. PEOPLE'S REPUBLIC OF)" ){
			        $co['COUNTRYID'] = '159';
			      }else if( trim($country_name) == 'KOREA (REPUBLIC OF)' ){
			        $co['COUNTRYID'] = '158';
			      }else if( trim($country_name) == 'MACAO (CHINA)' ){
			        $co['COUNTRYID'] = '160';
			      }else if( trim($country_name) == 'BELGIUN' ){
			        $co['COUNTRYID'] = '68';
			      }else if( trim($country_name) == 'RUSSIAN FEDERATION' ){
			        $co['COUNTRYID'] = '62';
			      }else if( trim($country_name) == 'UNITED STATES OF AMERICA' ){
			        $co['COUNTRYID'] = '131';
			      }else if( trim($country_name) == 'SOUTH AFRICA' ){
			        $co['COUNTRYID'] = '225';
			      }else if( trim($country_name) == 'COCOS( KELLING)ISLANDS' ){
			        $co['COUNTRYID'] = '153';
			      }else if( trim($country_name) == 'AFGANISTAN' ){
			        $co['COUNTRYID'] = '163';
			      }else if( trim($country_name) == 'FAEROE ISLANDS' ){
			        $co['COUNTRYID'] = '129';
			      }else if( trim($country_name) == 'LIECHTENSTEIN' ){
			        $co['COUNTRYID'] = '194';
			      }else if( trim($country_name) == 'ANDORA' ){
			        $co['COUNTRYID'] = '95';
			      }else if( trim($country_name) == 'BOSNIA-HERZEGOVINA' ){
			        $co['COUNTRYID'] = '83';
			      }else if( trim($country_name) == 'MADIERA ISLANDS' ){
			        $co['COUNTRYID'] = '75';
			      }else if( trim($country_name) == 'KOSOVO' ){
			        $co['COUNTRYID'] = '43';
			      }else if( trim($country_name) == 'FRENCH SOUTHERN AND ANTARCTIC TERRITORIES' ){
			        $co['COUNTRYID'] = '92';
			      }else if( trim($country_name) == 'ANTIGUA AND BARBUDA' || $country_name2 == 'ANTIGUAANDBARBUDA'){
			        $co['COUNTRYID'] = '21'; 
			      }else if( trim($country_name) == 'BRITISH VIRGIN ISLANDS' || $country_name2 == 'BRITISHVIRGINISLANDS' ){
			        $co['COUNTRYID'] = '1';
			      }else if( trim($country_name) == 'CAYMAN ISLANDS' || $country_name2 == 'CAYMANISLANDS'){
			        $co['COUNTRYID'] = '13';
			      }else if( trim($country_name) == 'REPúBLICA DOMINICANA' ){
			        $co['COUNTRYID'] = '4';
			      }else if( trim($country_name) == 'JAMICA' ){
			        $co['COUNTRYID'] = '8';
			      }else if( trim($country_name) == 'PUERTO RICO' ){
			        $co['COUNTRYID'] = '9';
			      }else if( trim($country_name) == 'SAINT LUCIA' || $country_name2 == 'SAINTLUCIA'){
			        $co['COUNTRYID'] = '17';
			      }else if( trim($country_name) == 'ST. KITTS AND NEVIS' || $country_name2 == 'ST.KITTSANDNEVIS' ){
			        $co['COUNTRYID'] = '18';
			      }else if( trim($country_name) == 'ST. MAARTEN' || trim($country_name) == 'ST.  MAARTEN' ){
			        $co['COUNTRYID'] = '280';
			      }else if( trim($country_name) == 'SAINT MARTIN' || $country_name2 == 'SAINTMARTIN'){
			        $co['COUNTRYID'] = '139';
			      }else if( trim($country_name) == 'SAINT PIERRE AND MIQUELON' || $country_name2 == 'SAINTPIERREANDMIQUELON'){
			        $co['COUNTRYID'] = '140';
			      }else if( trim($country_name) == 'ST. VINCENT AND THE GRENADINES' || $country_name2 == 'ST.VINCENTANDTHEGRENADINES'){
			        $co['COUNTRYID'] = '19';
			      }else if( trim($country_name) == 'TURKS AND CAICOS' || $country_name2 == 'TURKSANDCAICOS'){
			        $co['COUNTRYID'] = '24';
			      }else if( trim($country_name) == 'UNITED STATES VIRGIN ISLAND' || $country_name2 == 'UNITEDSTATESVIRGINISLAND'){
			        $co['COUNTRYID'] = '14';
			      }else if( trim($country_name) == 'NETHERLANDS ANTILLES' || $country_name2 == 'NETHERLANDSANTILLES'){
			        $co['COUNTRYID'] = '135';
			      }else if( trim($country_name) == 'SAINT BARTHELEMY' || $country_name2 == 'SAINTBARTHELEMY'){
			        $co['COUNTRYID'] = '138';
			      }else if( trim($country_name) == 'SAINT EUSTATIUS' || $country_name2 == 'SAINTEUSTATIUS'){
			        $co['COUNTRYID'] = '279';
			      }else if( trim($country_name) == 'CLIPPERTON ISLAND' || $country_name2 == 'CLIPPERTONISLAND' ){
			        $co['COUNTRYID'] = '136';
			      }else if( trim($country_name) == 'GUATAMALA' ){
			        $co['COUNTRYID'] = '112';
			      }else if( trim($country_name) == 'FRENCH GUIANA' || $country_name2 == 'FRENCHGUIANA' ){
			        $co['COUNTRYID'] = '132';
			      }else if( trim($country_name) == 'FALKLAND ISLANDS' || $country_name2 == 'FALKLANDISLANDS'){
			        $co['COUNTRYID'] = '129';
			      }else if( trim($country_name) == 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS' ){
			        $co['COUNTRYID'] = '176';
			      }else if( trim($country_name) == 'LIBIA' ){
			        $co['COUNTRYID'] = '40';
			      }else if( trim($country_name) == 'COOK ISLANDS' || $country_name2 == 'COOKISLANDS' ){
			        $co['COUNTRYID'] = '271';
			      }else if( trim($country_name) == 'FRENCH POLYNESIA' || $country_name2 == 'FRENCHPOLYNESIA'){
			        $co['COUNTRYID'] = '256';
			      }else if( trim($country_name) == 'MICRONESIA FSM' ){
			        $co['COUNTRYID'] = '242';
			      }else if( trim($country_name) == 'N. MARIANA ISLANDS' ){
			        $co['COUNTRYID'] = '260';
			      }else if( trim($country_name) == 'SOLOMON ISLANDS' || $country_name2 == 'SOLOMONISLANDS' ){
			        $co['COUNTRYID'] = '245';
			      }else if( trim($country_name) == 'VANAUTU' ){
			        $co['COUNTRYID'] = '250';
			      }else if( trim($country_name) == 'BAKER ISLAND' || $country_name2 == 'BAKERISLAND'){
			        $co['COUNTRYID'] = '265';
			      }else if( trim($country_name) == 'BOUVET ISLAND'  || $country_name2 == 'BOUVETISLAND'){
			        $co['COUNTRYID'] = '174';
			      }else if( trim($country_name) == 'CORAL SEA ISLANDS' || $country_name2 == 'CORALSEAISLANDS' ){
			        $co['COUNTRYID'] = '259';
			      }else if( trim($country_name) == 'HEARD AND MCDONALD ISLANDS' || $country_name2 == 'HEARDANDMCDONALDISLANDS'){
			        $co['COUNTRYID'] = '175';
			      }else if( trim($country_name) == 'JARVIS ISLAND' || $country_name2 == 'JARVISISLAND'){
			        $co['COUNTRYID'] = '267';
			      }else if( trim($country_name) == 'KINGMAN REEF' || $country_name2 == 'KINGMANREEF'){
			        $co['COUNTRYID'] = '268';
			      }else if( trim($country_name) == 'MIDWAY ISLANDS' || $country_name2 == 'MIDWAYISLANDS'){
			        $co['COUNTRYID'] = '263';
			      }else if( trim($country_name) == 'NORFALK ISLAND' || $country_name2 == 'NORFALKISLAND'){
			        $co['COUNTRYID'] = '254';
			      }else if( trim($country_name) == 'ROSS DEPENDENCY' || $country_name2 == 'ROSSDEPENDENCY'){
			        $co['COUNTRYID'] = '177';
			      }else if( trim($country_name) == 'WAKE ISLAND' || $country_name2 =='WAKEISLAND'){
			        $co['COUNTRYID'] = '261';
			      }else if( trim($country_name) == 'WALLIS AND FUTUNA ISLANDS' || $country_name2 =='WALLISANDFUTUNAISLANDS'){
			        $co['COUNTRYID'] = '264';
			      }else if( trim($country_name) == 'BURKINA FASO' || $country_name2 == 'BURKINAFASO'){
			        $co['COUNTRYID'] = '201';
			      }else if( trim($country_name) == 'CANARY ISLANDS' || $country_name2 == 'CANARYISLANDS'){
			        $co['COUNTRYID'] = '230';
			      }else if( trim($country_name) == 'CAPE VERDE REP.' ){
			        $co['COUNTRYID'] = '202';
			      }else if( trim($country_name) == 'RéPUBLIQUE DU CONGO' ){
			        $co['COUNTRYID'] = '184';
			      }else if( trim($country_name) == "CôTE D'IVOIRE" ){
			        $co['COUNTRYID'] = '193';
			      }else if( trim($country_name) == "RéPUBLIQUE DéMOCRATIQUE DU CONGO" ){
			        $co['COUNTRYID'] = '184';
			      }else if( trim($country_name) == "EQUATORIAL GUINEA" || $country_name2 == 'EQUATORIALGUINEA'){
			        $co['COUNTRYID'] = '187';
			      }else if( trim($country_name) == "GUINEA-BISSAU" ){
			        $co['COUNTRYID'] = '205';
			      }else if( trim($country_name) == "SAINT HELENA" || $country_name2 == 'SAINTHELENA'){
			        $co['COUNTRYID'] = '223';
			      }else if( trim($country_name) == "SAO TOME/PRINCIPE" ){
			        $co['COUNTRYID'] = '178';
			      }else if( trim($country_name) == "SOUTH SUDAN" ){
			        $co['COUNTRYID'] = '235';
			      }else if( trim($country_name) == "WESTERN SAHARA" || $country_name2 == 'WESTERNSAHARA'){
			        $co['COUNTRYID'] = '204';
			      }else if( trim($country_name) == "NORTH MACEDONIA" ){
			        $co['COUNTRYID'] = '85';
			      }else if( trim($country_name) == "TAIWAN PROVINCE OF CHINA" ){
			        $co['COUNTRYID'] = '155';
			      }else if( trim($country_name) == "REP. MOLDOVA" ){
			        $co['COUNTRYID'] = '57';
			      }else if( trim($country_name) == "TAJIKSTAN" ){
			        $co['COUNTRYID'] = '59';
			      }else if( trim($country_name) == "REP. OF KOSOVO" ){
			        $co['COUNTRYID'] = '43';
			      }else if( trim($country_name) == "DOMINICAN REBUBLIC" ){
			        $co['COUNTRYID'] = '4';
			      }else if( trim($country_name) == "COSTARICA" ){
			        $co['COUNTRYID'] = '111';
			      }else if( trim($country_name) == "HONDURUS" ){
			        $co['COUNTRYID'] = '114';
			      }else if( trim($country_name) == "NICARAQUA" ){
			        $co['COUNTRYID'] = '115';
			      }else if( trim($country_name) == "PARAQUAY" ){
			        $co['COUNTRYID'] = '124';
			      }else if( trim($country_name) == "BURANDI" ){
			        $co['COUNTRYID'] = '207';
			      }else if( trim($country_name) == "CôTE D'IVOIRE (IVORY COST)" ){
			        $co['COUNTRYID'] = '193';
			      }else if( trim($country_name) == "DEM. REP. OF THE CONGO" ){
			        $co['COUNTRYID'] = '183';
			      }else if( trim($country_name) == "ESWATINI (SWAZILAND)" ){
			        $co['COUNTRYID'] = '73';
			      }else if( trim($country_name) == "REP. OF SOUTH SUDAN" ){
			        $co['COUNTRYID'] = '235';
			      }


		      	if(!empty($co['COUNTRYID'])){
		      		$count++;

		      		if( $co['COUNTRYID'] == 91
	      				|| trim($co['COUNTRYID'] ) == 1
	      				|| trim($co['COUNTRYID'] ) == 242
	      				|| trim($co['COUNTRYID'] ) == 261
	      				|| trim($co['COUNTRYID'] ) == 228
	      				|| trim($co['COUNTRYID'] ) == 212 ){

			      		foreach($row as $col_id=> $col){
			    			if($col_id >= 7){
				    			if($col_id >=7 && $col_id<=44){

				    				if( !is_numeric($col) ){ 
					      				$text .= 'Fail :: Row - '.($row_id+1).'. '.trim($country_name).' :: '.$col.' is not number <br>';
					      				$fail = true;
					      				break 2;
					      			}
				    				$builder_co = $this->db->table('REPORT_RAW_MONTHLY');
				    				$builder_co->select('NUM');
						            $builder_co->where('COUNTRY_ID',$co['COUNTRYID']);
						            $builder_co->where('PORT_ID',@$port_id[$col_id]);
						            $builder_co->where('POINT_ID',@$point_id[$col_id]);
						            $builder_co->where('MONTH',$input['month']);
						            $builder_co->where('YEAR',$input['year']);
						            $row_co = $builder_co->get()->getRowArray();
						            if(!empty($row_co['NUM'])){
						            	$builder_import = $this->db->table('REPORT_RAW_MONTHLY');
							            $builder_import->where('COUNTRY_ID',$co['COUNTRYID']);
							            $builder_import->where('PORT_ID',@$port_id[$col_id]);
							            $builder_import->where('POINT_ID',@$point_id[$col_id]);
							            $builder_import->where('MONTH',$input['month']);
							            $builder_import->where('YEAR',$input['year']);
							            $builder_import->set('NUM',($col+$row_co['NUM']));
							            $builder_import->update();
						            }else{
						            	$builder_import = $this->db->table('REPORT_RAW_MONTHLY');
							            $builder_import->set('COUNTRY_ID',$co['COUNTRYID']);
							            $builder_import->set('PORT_ID',@$port_id[$col_id]);
							            $builder_import->set('POINT_ID',@$point_id[$col_id]);
							            $builder_import->set('NUM',$col);
							            $builder_import->set('MONTH',$input['month']);
							            $builder_import->set('YEAR',$input['year']);
							            $builder_import->insert();
						            }


				    			}
				    		}
				    	}
				    }else{
		      		// echo ':: '.$co['COUNTRYID'].' == ';
			      		foreach($row as $col_id=> $col){
			    			if($col_id >= 7){
				    			if($col_id >=7 && $col_id<=44){
				    				if( !is_numeric($col) ){ 
					      				$text .= 'Fail :: Row - '.($row_id+1).'. '.trim($country_name).' :: '.$col.' is not number <br>';
					      				$fail = true;
					      				break 2;
					      			}
			    					// echo @$port_id[$col_id].'='.@$point_id[$col_id].'='.$col.' || ';
				    				$builder_import = $this->db->table('REPORT_RAW_MONTHLY');
						            $builder_import->set('COUNTRY_ID',$co['COUNTRYID']);
						            $builder_import->set('PORT_ID',@$port_id[$col_id]);
						            $builder_import->set('POINT_ID',@$point_id[$col_id]);
						            $builder_import->set('NUM',$col);
						            $builder_import->set('MONTH',$input['month']);
						            $builder_import->set('YEAR',$input['year']);
						            $builder_import->insert();
			    				}
			    			}
			    		}	
			    	}
		      	}else if( trim($country_name) == "UTOPIA" 
	      				|| trim($country_name) == "BRITISH COLONY" 
	      				|| trim($country_name) == "TRUST PACIFIC" 
	      				|| trim($country_name) == "UNITED STATES MINOR OUTLYING ISLAND"
	      				|| trim($country_name) == "ESWATINI" 
	      				|| trim($country_name) == "MAURITUN" ){

		      		foreach($row as $col_id=> $col){
		    			if($col_id >= 7){
			    			if($col_id >=7 && $col_id<=44){
			    				if( !is_numeric($col) ){ 
				      				$text .= 'Fail :: Row - '.($row_id+1).'. '.trim($country_name).' :: '.$col.' is not number <br>';
				      				$fail = true;
				      				break 2;
				      			}

			    				if( trim($country_name) == "UTOPIA" ){
			    					$co['COUNTRYID'] = 91;
			    				}else if( trim($country_name) == "BRITISH COLONY" ){
			    					$co['COUNTRYID'] = 1;
			    				}else if( trim($country_name) == "TRUST PACIFIC" ){
			    					$co['COUNTRYID'] = 242;
			    				}else if( trim($country_name) == "UNITED STATES MINOR OUTLYING ISLAND" ){
			    					$co['COUNTRYID'] = 261;
			    				}else if( trim($country_name) == "ESWATINI" ){
			    					$co['COUNTRYID'] = 228;
			    				}else if( trim($country_name) == "MAURITUN" ){
			    					$co['COUNTRYID'] = 212;
			    				}


			    				$builder_co = $this->db->table('REPORT_RAW_MONTHLY');
			    				$builder_co->select('NUM');
					            $builder_co->where('COUNTRY_ID',$co['COUNTRYID']);
					            $builder_co->where('PORT_ID',@$port_id[$col_id]);
					            $builder_co->where('POINT_ID',@$point_id[$col_id]);
					            $builder_co->where('MONTH',$input['month']);
					            $builder_co->where('YEAR',$input['year']);
					            $row_co = $builder_co->get()->getRowArray();
					            if(!empty($row_co['NUM'])){
					            	$builder_import = $this->db->table('REPORT_RAW_MONTHLY');
						            $builder_import->where('COUNTRY_ID',$co['COUNTRYID']);
						            $builder_import->where('PORT_ID',@$port_id[$col_id]);
						            $builder_import->where('POINT_ID',@$point_id[$col_id]);
						            $builder_import->where('MONTH',$input['month']);
						            $builder_import->where('YEAR',$input['year']);
						            $builder_import->set('NUM',($col+$row_co['NUM']));
						            $builder_import->update();
					            }else{
					            	$builder_import = $this->db->table('REPORT_RAW_MONTHLY');
						            $builder_import->set('COUNTRY_ID',$co['COUNTRYID']);
						            $builder_import->set('PORT_ID',@$port_id[$col_id]);
						            $builder_import->set('POINT_ID',@$point_id[$col_id]);
						            $builder_import->set('NUM',$col);
						            $builder_import->set('MONTH',$input['month']);
						            $builder_import->set('YEAR',$input['year']);
						            $builder_import->insert();
					            }


			    			}
			    		}
			    	}


		      	}else{
		      		$text .= 'Fail :: Row - '.($row_id+1).'. '.trim($country_name).'<br>';
		      	}
	    	}
	    }
	    if($fail){
	    	$builder_import = $this->db->table('REPORT_RAW_MONTHLY');
            $builder_import->where('MONTH',$input['month']);
            $builder_import->where('YEAR',$input['year']);
            $builder_import->delete();
	    }else{
	    	$text .= 'Insert Data Complete : '.$count.' Row';
	    }
	    

	    return $text;
	}

	function getRawDataMonthly($year,$month){
		$data = array();
		$builder = $this->db->table('REPORT_RAW_MONTHLY');
		$builder->select('REPORT_RAW_MONTHLY.*,MD_COUNTRY.COUNTRY_NAME_EN');
		$builder->join('MD_COUNTRY','MD_COUNTRY.COUNTRYID = REPORT_RAW_MONTHLY.COUNTRY_ID');
		$builder->where('MONTH',$month);
        $builder->where('YEAR',$year);
        $builder->orderBy('COUNTRY_NAME_EN');
        $query = $builder->get()->getResultArray();
        foreach($query as $row){
        	$point = 0;
        	if($row['POINT_ID']){
        		$point = $row['POINT_ID'];
        	}
        	$data[$row['COUNTRY_ID']]['COUNTRY_NAME_EN'] = $row['COUNTRY_NAME_EN'];
        	if($data[$row['COUNTRY_ID']]['NUM'][$row['PORT_ID']][$point]){
        		$data[$row['COUNTRY_ID']]['NUM'][$row['PORT_ID']][$point] += $row['NUM'];
        	}else{
        		$data[$row['COUNTRY_ID']]['NUM'][$row['PORT_ID']][$point] = $row['NUM'];
        	}
        	
        }

        return $data;
	}

	function getPortMonthly($port_type=''){
		$builder = $this->db->table('MD_PORT');
  		$builder->select('MD_PORT.PORT_ID,MD_PORT.PORT_NAME_FULL,PORT_ORDER_MONTHLY');
      	$builder->join('REPORT_RAW_MONTHLY','REPORT_RAW_MONTHLY.PORT_ID = MD_PORT.PORT_ID','LEFT');
      	$builder->where('MD_PORT.PORT_NAME_FULL is not null');
      	$builder->where('PORT_MONTHLY',1);
      	$builder->groupBy('MD_PORT.PORT_ID,MD_PORT.PORT_NAME_FULL,PORT_ORDER_MONTHLY');
      	if($port_type){
      		$builder->whereIn("MD_PORT.PORT_ID",$port_type);
      	}
      	
      	$builder->orderby('PORT_ORDER_MONTHLY');
      	$query = $builder->get()->getResultArray();

      	return $query;
	}

	function getPointMonthly($point_type=''){
		$data = array();
		$builder = $this->db->table('MD_PORT_POINT');
  		$builder->select('*');
  		if($point_type){
      		$builder->whereIn("POINT_ID",$point_type);
      	}
      	$builder->where('POINT_MONTHLY',1);
      	$query = $builder->get()->getResultArray();
      	foreach($query as $row){
      		$data[$row['PORT_ID']][$row['POINT_ID']] = $row;
      	}

      	return $data;
	}
}