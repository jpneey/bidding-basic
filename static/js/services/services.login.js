$(function(){
  
  login();
  
});


function login(){

  $(".login-form").on("submit", function(e) { 
    
    e.preventDefault();
    $(".login-form, body").css({
      opacity: "0.5",
      cursor: "wait"
    });
    
    var $inputs = $(this).find("input, select, button, textarea");
    var action = $(this).attr("action");
    var type = $(this).attr("method");
    var formData = new FormData(this);

    $inputs.prop("disabled", true);
    window.onbeforeunload = function() {
      return "Are you sure you want to navigate away from this page?";
    };
    $.ajax({
        url: action,
        type: type,
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
          window.onbeforeunload = null;
          $(".login-form, body").css({
            opacity: "1",
            cursor: "auto"
          });
          
          $inputs.val("");
          $('button').text('Login');
          $inputs.prop("disabled", false);
          var parsedData = JSON.parse(data);
          if(parsedData.code == '0') {
            location.reload();
            return;
          }
          $('.submit').val('Login');
          M.toast({
            html: parsedData.message,
            classes: "red darken-2 white-text normal-text"
          });

        }
    })

  });

}