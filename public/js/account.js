$(document).ready(function() {
  $('.state_id').click(function() {
    var state_id = $(this).attr('data-id');
    $.ajax({
      url:'/finance/account/get_statement/'+state_id,
      method:'GET',
      success:function(res) {
        var obj = JSON.parse(res);
        console.log(obj);
        if (obj.form.state_type == 1) {
        $('#state_type').html('เงินโครงการ');
        $('.state_type1').css('display','block');
        $('.state_type3').css('display','none');
        $('.state_type4').css('display','none');
        $('#type_account').html('บัญชี -'+obj.form.acc_name+' '+'รายการรับ');
        $('#show_budget').html(obj.budget_type);
      }else if (obj.form.state_type == 2) {
        $('#state_type').html('เงินโครงการ');
        $('.state_type1').css('display','block');
        $('.state_type3').css('display','none');
        $('.state_type4').css('display','none');
        $('#show_budget').html(obj.budget_type);
      }else if (obj.form.state_type == 3) {
        $('#state_type').html('โอนเงินบัญชีภายใน');
        $('.state_type1').css('display','none');
        $('.state_type3').css('display','block');
        $('.state_type4').css('display','none');
        $('#show_budget').html(obj.budget_type);
        } else {
        $('#state_type').html('โอนเงินบัญชีอื่น');
        $('.state_type1').css('display','none');
        $('.state_type3').css('display','none');
        $('.state_type4').css('display','block');
        $('#type_account').html('บัญชี -'+obj.form.acc_name+' '+'รายการจ่าย');
        $('#acc_receive_name').html(obj.form.acc_receive_name);
        $('#acc_receive_no').html(obj.form.acc_receive_no);
        $('#show_budget').html(obj.budget_type);
        }
        $('#state_no').html(obj.form.state_no);
        $('#acc_transfer_name').html(obj.form.acc_transfer_name);
        $('#prj_name').html(obj.form.prj_code+' '+obj.form.prj_name);
        $('#state_desc').html(obj.form.state_desc);
        $('#state_budget').html(obj.form.state_budget);
        if (obj.form.state_date != '') {
        var d = new Date(obj.form.state_date);
        var month = (('0' + (d.getMonth()+1)).slice(-2));
        var day = ('0' + d.getDate()).slice(-2);
        var year = d.getFullYear() + 543;
        var date_format = day+'/'+month+'/'+year;
        $('#state_date').html(date_format);
        }
        $('#show_budget').html(obj.budget_type);
      }
    });
  });
});
