var loadFile = function(event) {
var reader = new FileReader();
reader.onload = function(){
var output = document.getElementById('output');
output.src = reader.result;
 };
 reader.readAsDataURL(event.target.files[0]);
};
  
function UserEdit(org_id,user_id){
  $('#user_org_id').val(org_id);
  $('#user_profile').modal('show');
  $.ajax({
    url: $('#base_url').val()+'/user/get_user',
    method:"POST",
    data:{user_id:user_id},
    success:function(data){
      var obj = JSON.parse(data);
       $('#username').val(obj.username);
       // $('#password').val(obj.password);
       $('#first_name').val(obj.first_name);
       $('#last_name').val(obj.last_name);
       $('#phone').val(obj.phone);
       $('#email').val(obj.email);
       $('#status').val(obj.status);
       $('#user_id').val(obj.user_id);
       if (obj.user_img != '') {
         $('#output').attr('src',$('#base_url').val()+'/public/uploads/user/'+obj.user_img);
       }
    }
  });
}

$(document).ready(function(){  
    $('#form_user').on('submit', function(e){  
      var user_name = $('#user_name').val();
      var first_name = $('#first_name').val();
      var last_name = $('#last_name').val();
      var phone = $('#phone').val();
      var email = $('#email').val();
      var status = $('#status').val();
      var user_type = $('#user_type').val();
      var user_id = $('#user_id').val();
      var password = $('#password').val();
      var password_re = $('#password_re').val();

    if($('#user_id').val()==''){
      if(password==''){
        $.toast({
          heading: 'Warning',
          text: 'กรุณากรอก รหัสผ่าน',
          icon: 'warning',
          loaderBg : '#dd690b'
        });
        $('#password').focus();
        return false;
      }
    }

    if(password!=''){
      if(password!=password_re){
        $.toast({
          heading: 'Warning',
          text: 'รหัสผ่านไม่ถูกต้อง กรุณากรอกใหม่อีกครั้ง',
          icon: 'warning',
          loaderBg : '#dd690b'
        });
        $('#password_re').focus();
        return false;
      }
    }

    if (user_name == '') {
      $.toast({
        heading: 'Warning',
        text: 'กรุณากรอก ชื่อผู้ใช้งาน',
        icon: 'warning',
        loaderBg : '#dd690b'
      });
      $('#user_name').focus();
      return false;
    }else if (first_name == '') {
      $.toast({
        heading: 'Warning',
        text: 'กรุณากรอก ชื่อ',
        icon: 'warning',
        loaderBg : '#dd690b'
      });
      $('#first_name').focus();
      return false;
    }else if (last_name == '') {
      $.toast({
        heading: 'Warning',
        text: 'กรุณากรอก นามสกุล',
        icon: 'warning',
        loaderBg : '#dd690b'
      });
      $('#last_name').focus();
      return false;
    }else if (phone == '') {
      $.toast({
        heading: 'Warning',
        text: 'กรุณากรอก เบอร์โทรศัพท์',
        icon: 'warning',
        loaderBg : '#dd690b'
      });
      $('#phone').focus();
      return false;
    }else if (email == '') {
      $.toast({
        heading: 'Warning',
        text: 'กรุณากรอก อีเมลล์',
        icon: 'warning',
        loaderBg : '#dd690b'
      });
      $('#email').focus();
      return false;
    }else {
      e.preventDefault();  
      $.ajax({  
         url: $('#base_url').val()+"/user/user_update",
         method:"POST",  
         data:new FormData(this),  
         contentType: false,  
         cache: false,  
         processData:false,  
         dataType: "json",
         success:function(res){  
            // $.toast({
            //    heading: 'success',
            //    text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
            //    icon: 'success',
            //    loaderBg : '#109657'
            //  });

            // $('#user_profile').modal('hide');
            // $tgOrg.treegrid('reload');
         }  
      });  

      $.toast({
         heading: 'success',
         text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
         icon: 'success',
         loaderBg : '#109657'
       });

      $('#user_profile').modal('hide');
      $tgOrg.treegrid('reload');
            
    }  
   }); 
 }); 