<?php
$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $isSecure = true;
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
    $isSecure = true;
}
$REQUEST_PROTOCOL = $isSecure ? 'https' : 'http';

if(isset($_FILES['file_ckeditor'])){
  $pathuploadname = "../uploads/content";
  $pathdisplayname = $REQUEST_PROTOCOL.'://'.$_SERVER['HTTP_HOST']."/public/uploads/content";
        $filen = $_FILES['file_ckeditor']['tmp_name'];
        $con_images = $pathuploadname.'/'.$_FILES['file_ckeditor']['name'];
        @copy($filen, $con_images );
       $url = $pathdisplayname.'/'.$_FILES['file_ckeditor']['name'];

   $funcNum = $_GET['CKEditorFuncNum'] ;
   // Optional: instance name (might be used to load a specific configuration file or anything else).
   $CKEditor = $_GET['CKEditor'] ;
   // Optional: might be used to provide localized messages.
   $langCode = $_GET['langCode'] ;

   // Usually you will only assign something here if the file could not be uploaded.
   $message = '';
   echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
}
?>
