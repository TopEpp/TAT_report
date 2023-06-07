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
		$countData = 0; $text='';
		foreach($xlsx->rows() as $key => $row){
			$PORT['PORT_ID'] = $visa['VISA_ID'] = $country['COUNTRY_ID'] = null;
			if(is_numeric($row[6])){

				if(empty($temp_PORT[$row[4]])){
					$builder_PORT = $this->db->table('MD_PORT');
					$builder_PORT->select('PORT_ID');
					$builder_PORT->where('PORT_NAME',$row[4]);
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
					if($row[2]=='ไม่มีสัญชาติ'){
						$country['COUNTRY_ID'] = 275;
					}else if( $row[2]=='บริติช (OVERSEAS)'){
						$country['COUNTRY_ID'] = 274;
					}else if( $row[2]=='ดินามาร์คซ'){
						$country['COUNTRY_ID'] = 102;
					}else if( $row[2]=='คอซอวอ'){
						$country['COUNTRY_ID'] = 43;
					}else if( $row[2]=='กินี'){
						$country['COUNTRY_ID'] = 192;
					}else if( $row[2]=='โคโลนีอังกฤษ'){
						$country['COUNTRY_ID'] = 1;
					}else if( $row[2]=='รัฐเอกราชซามัว'){
						$country['COUNTRY_ID'] = 244;
					}else if( $row[2]=='ซาอีร์'){
						$country['COUNTRY_ID'] = 183;
					}else if( $row[2]=='สาธารณรัฐซิมบับเว (ZWE)'){
						$country['COUNTRY_ID'] = 185;
					}else if( $row[2]=='ไดโต'){
						$country['COUNTRY_ID'] = 122;
					}else if( $row[2]=='สาธารณรัฐติมอร์ตะวันออก'){
						$country['COUNTRY_ID'] = 151;
					}else if( $row[2]=='ทรัสต์แปซิฟิค'){
						$country['COUNTRY_ID'] = 242;
					}else if( $row[2]=='มาเรียนา'){
						$country['COUNTRY_ID'] = 131;
					}else if( $row[2]=='สหพันธ์สาธารณรัฐยูโกสลาเวีย'){
						$country['COUNTRY_ID'] = 43;
					}else if( $row[2]=='ยูโทเปีย'){
						$country['COUNTRY_ID'] = 91;
					}else if( $row[2]=='ยูเอส ไมเนอร์ เอ๊าไลน์นิ่ง ไอร์แลนด์'){
						$country['COUNTRY_ID'] = 261;
					}else if( $row[2]=='เยเมนเหนือ'){
						$country['COUNTRY_ID'] = 39;
					}else if( $row[2]=='เยอรมันตะวันออก'){
						$country['COUNTRY_ID'] = 48;
					}else if( $row[2]=='นครรัฐวาติกัน'){
						$country['COUNTRY_ID'] = 88;
					}else if( $row[2]=='สก็อตแลนด์'){
						$country['COUNTRY_ID'] = 274;
					}else if( $row[2]=='สฟาลบาร์และหมู่เกาะยานไมเอน'){
						$country['COUNTRY_ID'] = 105;
					}else if( $row[2]=='อัลมาดินา'){
						$country['COUNTRY_ID'] = 37;
					}else if( $row[2]=='อังกฤษ-ฮ่องกง'){
						$country['COUNTRY_ID'] = 156;
					}else if( $row[2]=='สาธารณรัฐเซาท์ซูดาน'){
						$country['COUNTRY_ID'] = 235;
					}else if( $row[2]=='เฟรนช์โปลินีเซีย'){
						$country['COUNTRY_ID'] = 256;
					}else if( $row[2]=='ปรินซีเบิล'){
						$country['COUNTRY_ID'] = 0;
					}else if( $row[2]=='ผู้อพยพ (1951 CONVENTION)'){
						$country['COUNTRY_ID'] = 0;
					}else if( $row[2]=='ผู้อพยพ (อื่นๆ)'){
						$country['COUNTRY_ID'] = 0;
					}else if( $row[2]=='หน่วยงานพิเศษ ยูเอ็น'){
						$country['COUNTRY_ID'] = 0;
					}else if( $row[2]=='ยูเอ็น'){
						$country['COUNTRY_ID'] = 0;
					}else if( $row[2]=='องค์การสหประชาชาติ'){
						$country['COUNTRY_ID'] = 0;
					}

				}


				if(!empty($PORT['PORT_ID']) && !empty($visa['VISA_ID']) &&  (!empty($country['COUNTRY_ID']) || $country['COUNTRY_ID']==0) ) {
					$builder = $this->db->table($this->table);
					$builder->set('REPORT_DATE', 'to_date(' . '\'' . $this->Mydate->date_thai2eng($input['REPORT_DATE'], -543) . '\'' . ',\'YYYY-MM-DD\')', false);
					$builder->set('DIRECTION',$row[1]);
					$builder->set('NATION',$row[2]);
					$builder->set('VISA',$row[3]);
					$builder->set('OFFICE',$row[4]);
					$builder->set('HEAD_OFFICE',$row[5]);
					$builder->set('NUM',$row[6]);
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

					if(empty($country['COUNTRY_ID']) && $country['COUNTRY_ID'] != 0){
						$text .= ' NATION :: '.$row[2];
					}
					$text .= '<br>';
				}				
			}
		}

		$text .= 'Insert Data Complete : '.$countData.' Row';

		return $text;

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

	function import_file_raw_monthly($input,$xlsx){
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
			      }else if( trim($country_name) == 'ANTIGUA AND BARBUDA' ){
			        $co['COUNTRYID'] = '21';
			      }else if( trim($country_name) == 'BRITISH VIRGIN ISLANDS' ){
			        $co['COUNTRYID'] = '1';
			      }else if( trim($country_name) == 'CAYMAN ISLANDS' ){
			        $co['COUNTRYID'] = '13';
			      }else if( trim($country_name) == 'REPúBLICA DOMINICANA' ){
			        $co['COUNTRYID'] = '4';
			      }else if( trim($country_name) == 'JAMICA' ){
			        $co['COUNTRYID'] = '8';
			      }else if( trim($country_name) == 'PUERTO RICO' ){
			        $co['COUNTRYID'] = '9';
			      }else if( trim($country_name) == 'SAINT LUCIA' ){
			        $co['COUNTRYID'] = '17';
			      }else if( trim($country_name) == 'ST. KITTS AND NEVIS' ){
			        $co['COUNTRYID'] = '18';
			      }else if( trim($country_name) == 'ST. MAARTEN' ){
			        $co['COUNTRYID'] = '280';
			      }else if( trim($country_name) == 'SAINT MARTIN' ){
			        $co['COUNTRYID'] = '139';
			      }else if( trim($country_name) == 'SAINT PIERRE AND MIQUELON' ){
			        $co['COUNTRYID'] = '140';
			      }else if( trim($country_name) == 'ST. VINCENT AND THE GRENADINES' ){
			        $co['COUNTRYID'] = '19';
			      }else if( trim($country_name) == 'TURKS AND CAICOS' ){
			        $co['COUNTRYID'] = '24';
			      }else if( trim($country_name) == 'UNITED STATES VIRGIN ISLAND' ){
			        $co['COUNTRYID'] = '14';
			      }else if( trim($country_name) == 'NETHERLANDS ANTILLES' ){
			        $co['COUNTRYID'] = '135';
			      }else if( trim($country_name) == 'SAINT BARTHELEMY' ){
			        $co['COUNTRYID'] = '138';
			      }else if( trim($country_name) == 'SAINT EUSTATIUS' ){
			        $co['COUNTRYID'] = '279';
			      }else if( trim($country_name) == 'CLIPPERTON ISLAND' ){
			        $co['COUNTRYID'] = '136';
			      }else if( trim($country_name) == 'GUATAMALA' ){
			        $co['COUNTRYID'] = '112';
			      }else if( trim($country_name) == 'FRENCH GUIANA' ){
			        $co['COUNTRYID'] = '132';
			      }else if( trim($country_name) == 'FALKLAND ISLANDS' ){
			        $co['COUNTRYID'] = '129';
			      }else if( trim($country_name) == 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS' ){
			        $co['COUNTRYID'] = '176';
			      }else if( trim($country_name) == 'LIBIA' ){
			        $co['COUNTRYID'] = '40';
			      }else if( trim($country_name) == 'COOK ISLANDS' ){
			        $co['COUNTRYID'] = '271';
			      }else if( trim($country_name) == 'FRENCH POLYNESIA' ){
			        $co['COUNTRYID'] = '256';
			      }else if( trim($country_name) == 'MICRONESIA FSM' ){
			        $co['COUNTRYID'] = '242';
			      }else if( trim($country_name) == 'N. MARIANA ISLANDS' ){
			        $co['COUNTRYID'] = '260';
			      }else if( trim($country_name) == 'SOLOMON ISLANDS' ){
			        $co['COUNTRYID'] = '245';
			      }else if( trim($country_name) == 'VANAUTU' ){
			        $co['COUNTRYID'] = '250';
			      }else if( trim($country_name) == 'BAKER ISLAND' ){
			        $co['COUNTRYID'] = '265';
			      }else if( trim($country_name) == 'BOUVET ISLAND' ){
			        $co['COUNTRYID'] = '174';
			      }else if( trim($country_name) == 'CORAL SEA ISLANDS' ){
			        $co['COUNTRYID'] = '259';
			      }else if( trim($country_name) == 'HEARD AND MCDONALD ISLANDS' ){
			        $co['COUNTRYID'] = '175';
			      }else if( trim($country_name) == 'JARVIS ISLAND' ){
			        $co['COUNTRYID'] = '267';
			      }else if( trim($country_name) == 'KINGMAN REEF' ){
			        $co['COUNTRYID'] = '268';
			      }else if( trim($country_name) == 'MIDWAY ISLANDS' ){
			        $co['COUNTRYID'] = '263';
			      }else if( trim($country_name) == 'NORFALK ISLAND' ){
			        $co['COUNTRYID'] = '254';
			      }else if( trim($country_name) == 'ROSS DEPENDENCY' ){
			        $co['COUNTRYID'] = '177';
			      }else if( trim($country_name) == 'WAKE ISLAND' ){
			        $co['COUNTRYID'] = '261';
			      }else if( trim($country_name) == 'WALLIS AND FUTUNA ISLANDS' ){
			        $co['COUNTRYID'] = '264';
			      }else if( trim($country_name) == 'BURKINA FASO' ){
			        $co['COUNTRYID'] = '201';
			      }else if( trim($country_name) == 'CANARY ISLANDS' ){
			        $co['COUNTRYID'] = '230';
			      }else if( trim($country_name) == 'CAPE VERDE REP.' ){
			        $co['COUNTRYID'] = '202';
			      }else if( trim($country_name) == 'RéPUBLIQUE DU CONGO' ){
			        $co['COUNTRYID'] = '184';
			      }else if( trim($country_name) == "CôTE D'IVOIRE" ){
			        $co['COUNTRYID'] = '193';
			      }else if( trim($country_name) == "RéPUBLIQUE DéMOCRATIQUE DU CONGO" ){
			        $co['COUNTRYID'] = '184';
			      }else if( trim($country_name) == "EQUATORIAL GUINEA" ){
			        $co['COUNTRYID'] = '187';
			      }else if( trim($country_name) == "GUINEA-BISSAU" ){
			        $co['COUNTRYID'] = '205';
			      }else if( trim($country_name) == "SAINT HELENA" ){
			        $co['COUNTRYID'] = '223';
			      }else if( trim($country_name) == "SAO TOME/PRINCIPE" ){
			        $co['COUNTRYID'] = '178';
			      }else if( trim($country_name) == "SOUTH SUDAN" ){
			        $co['COUNTRYID'] = '235';
			      }else if( trim($country_name) == "WESTERN SAHARA" ){
			        $co['COUNTRYID'] = '204';
			      }

		      	if(!empty($co['COUNTRYID'])){
		      		$count++;
		      		// echo ':: '.$co['COUNTRYID'].' == ';
		      		foreach($row as $col_id=> $col){
		    			if($col_id >= 7){
			    			if($col_id >=7 && $col_id<=44){
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
		      	}else{
		      		$text .= 'Fail :: '.trim($country_name).'<br>';
		      	}
	    	}
	    }

	    $text .= 'Insert Data Complete : '.$count.' Row';

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
        	$data[$row['COUNTRY_ID']]['NUM'][$row['PORT_ID']][$point] = $row['NUM'];
        }

        return $data;
	}

	function getPortMonthly($port_type=''){
		$builder = $this->db->table('MD_PORT');
  		$builder->select('MD_PORT.PORT_ID,MD_PORT.PORT_NAME_FULL,PORT_ORDER_MONTHLY');
      	$builder->join('REPORT_RAW_MONTHLY','REPORT_RAW_MONTHLY.PORT_ID = MD_PORT.PORT_ID');
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
      	$query = $builder->get()->getResultArray();
      	foreach($query as $row){
      		$data[$row['PORT_ID']][$row['POINT_ID']] = $row;
      	}

      	return $data;
	}
}