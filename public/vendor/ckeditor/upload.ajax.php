<?php

	unset($error);
	date_default_timezone_set('Asia/Bangkok');
	$return = array('error'=>false,'msg'=>'');
	if(empty($_FILES['file_ckeditor'])) {
		// echo "{";
		// echo				"error: 'Please browse image!!!',\n";
		// echo				"msg: ''\n";
		// echo "}";

		$return['error'] = true;
		$return['msg'] = "Please browse image!!! \n";
	} else {
		$error = "" ;
		$isSecure = false;
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
		    $isSecure = true;
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
		    $isSecure = true;
		}

		$REQUEST_PROTOCOL = $isSecure ? 'https' : 'http';
		$pathuploadname = "../../uploads/inter_market";
		// $pathdisplayname = $REQUEST_PROTOCOL.'://'.$_SERVER['HTTP_HOST']."/public/uploads/content";
		$pathdisplayname = 'http://'.$_SERVER['HTTP_HOST']."/public/uploads/inter_market";


		if(!empty($_FILES["file_ckeditor"])) {
			$ints = date('YmdGis');
			if($_FILES["file_ckeditor"]["type"]=="image/png"||$_FILES["file_ckeditor"]["type"]=="image/x-png")
				$imgsn = $ints.".png";
			elseif($_FILES["file_ckeditor"]["type"]=="image/gif")
				$imgsn = $ints.".gif";
			elseif($_FILES["file_ckeditor"]["type"]=="image/pjpeg"||$_FILES["file_ckeditor"]["type"]=="image/jpeg")
				$imgsn = $ints.".jpg";

			if(!empty($imgsn)) {
				copy($_FILES["file_ckeditor"]["tmp_name"],$pathuploadname."/".$imgsn);
				$returnvalue=$pathdisplayname.'/'.$imgsn;

					$return['error'] = false;
					$return['msg'] = $returnvalue;

					// echo "{";
					// echo				"error: '{$error}',\n";
					// echo				"msg: '{$returnvalue}'\n";
					// echo "}";

			}else{
				$return['error'] = true;
				$return['msg'] = 'Upload Error!!!';
				// echo "{";
				// echo				"error: 'Error',\n";
				// echo				"msg: ''\n";
				// echo "}";
			}
		}
	}

	echo json_encode($return);
	//exit;
?>
