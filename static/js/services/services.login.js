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
    $('#load-wrap').fadeIn(500);

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
        $('#load-wrap').fadeOut(500);
        window.onbeforeunload = null;
        $(".login-form, body").css({
          opacity: "1",
          cursor: "auto"
        });

        $inputs.prop("disabled", false);

        var parsedData = JSON.parse(data);

        if(parsedData.code == '0') {
          location.reload();
          return;
        }

        var action = '<button onclick="M.Toast.dismissAll();" class="btn-flat toast-action"><i class="close material-icons">close</i></button>';

        
        if(parsedData.code == '11') {
          M.toast({
            html: parsedData.message + action,
            classes: "orange white-text",
            displayLength: 3600000
          });
          return;
        }
        M.toast({
          html: parsedData.message + action,
          classes: "orange white-text"
        });

      }
    })
    

  });

}