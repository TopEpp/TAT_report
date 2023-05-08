<?php
	unset($error);
	if(empty($_FILES)) {
		echo "{";
		echo				"error: 'กรุณาเลือกไฟล์',\n";
		echo				"msg: ''\n";
		echo "}";
	} else {


		$pathname = "public/uploads/content";
		if(!empty($_FILES["file_ckeditor"])) {
			$x = pathinfo($_FILES["file_ckeditor"]["name"]);
			$ext = $x["extension"];
			$filename = date('YmdGis').".{$ext}";

			copy($_FILES["file_ckeditor"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/{$pathname}/{$filename}");
			$returnvalue = "http://".$_SERVER["HTTP_HOST"]."/{$pathname}/{$filename}";
			//$data["error"] = $error;
			//$data["msg"] = $returnvalue;
			//echo json_encode($data);

				echo "{";
				echo				"error: '{$error}',\n";
				echo				"msg: '{$returnvalue}'\n";
				echo "}";

		}
	}
?>
