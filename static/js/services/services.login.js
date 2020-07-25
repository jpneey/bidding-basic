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

        $inputs.prop("disabled", false);

        var parsedData = JSON.parse(data);

        if(parsedData.code == '0') {

          location.reload();
          return;

        }

        var action = '<button onclick="M.Toast.dismissAll();" class="btn-flat toast-action"><i class="close material-icons">close</i></button>';

        M.toast({
          html: parsedData.message + action,
          classes: "orange white-text"
        });

      }
    })
    

  });

}