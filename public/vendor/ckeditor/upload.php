<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Upload Photo</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<script type="text/javascript" src="../ckeditor/jquery.js"></script>
<script type="text/javascript" src="../jquery/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.cookies.2.2.0.min.js"></script>

<style type="text/css">
	* {
		font-family: "Microsoft Sans sarif";
		font-size: 13px;
	}
	body {
		margin: 0px;
		overflow: hidden;
	}
</style>

</head>
<body>
  <form id="frmUpload" name="frmUpload" method="post"  enctype="multipart/form-data">
          <div style="text-align: center;margin: 10px auto;width: 450px;border: 1px solid #CCCCCC;background-color: #F1F1F1;padding: 10px 5px 10px 5px;">
          	<div><b>Browse:</b> <input id="file_ckeditor" name="file_ckeditor" type="file" style="width:200px" accept="image/*"/></div>
          	<hr size="1" />
				<div id="div_upload" style="display: none;text-align: center;">
					<table border="0" width="150" cellpadding="3" cellspacing="0" style="margin: 0 auto 0 auto;">
						<tr>
							<td width="32"><span><i class="fa fa-spinner fa-spin fa-3x" ></i></span><!-- <img id="img_upload" src="/images/wait.gif" /> --></td>
							<td valign="middle" align="left"><b>Please wait</b></td>
						</tr>
					</table>
				</div>
            <div>
				<input id="btnSubmit" name="btnSubmit" type="submit" title="Send" value="Submit" style="width: 75px;" />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input id="btnClose" name="btnClose" type="button" title="Close" onclick="parent.jQuery.fancybox.close();" value="Close" style="width: 75px;" />
            </div>
          </div>
          <div style="text-align: left;padding: 10px 5px 10px 5px;width: 450px;margin: 20px auto;border: 1px solid #CCCCCC;background-color: #FFFFFF;">
			<b><font color="#FF0000">Remark</font></b><br />
			<font color="#FF0000"><b>*</b></font> File size not over 5MB.<br />
            <font color="#FF0000"><b>*</b></font> Only .jpg, .jpeg, .gif, .png allowed.<br />
          </div>
  </form>
</body>
</html>

<script type="text/javascript">
$(document).ready(function(){

			$('#frmUpload').on('submit', function(e){  
      	$("#div_upload").css("display","block");

        e.preventDefault();  
        $.ajax({  
           url: "upload.ajax.php",
           method:"POST",  
           data:new FormData(this),  
           contentType: false,  
           cache: false,  
           processData:false,  
           dataType: "json",
           success:function(res){  

						if(!res.error){
							$.cookies.set("return_img", res.msg);
							parent.jQuery.fancybox.close();
						}else{
							alert(res.msg);
						}

						$("#div_upload").css("display","none");
           }  
        });  


      
     }); 


});
</script>
