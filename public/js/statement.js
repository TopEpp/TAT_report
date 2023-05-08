setTimeout(function(){
  $(document).ready(function() {
    $('#state_type').change(function () {
      var state_type = $('#state_type').val();
      if (state_type == 2) {
        $(".form_type2").css("display", "block");
        $(".form_type3").css("display", "none");
      }else if (state_type == 3) {
        $(".form_type2").css("display", "none");
        $(".form_type3").css("display", "block");
      } else {
        $(".form_type2").css("display", "block");
        $(".form_type3").css("display", "none");
      }
    });
  });
  $('.datepicker').datepicker({
    format: "dd/mm/yyyy",
   autoclose: true,
    language:'th-th',
  });
}, 100);
