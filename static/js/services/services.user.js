
    $(function(){
        updateUser();
        $('select').formSelect();
        autoToast();
    })
    

    function updateUser(){

        $(".user-form").on("submit", function(e) { 
  
            e.preventDefault();
            $(".add-form, body").css({
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
                    $(".add-form, body").css({
                        opacity: "1",
                        cursor: "auto"
                    });

                    $inputs.prop("disabled", false);

                    var parsedData = JSON.parse(data);

                    if(parsedData.code == '1') {
                        var url = window.location.href;
                        window.location.href = url += '?updated=1';
                        return;
                    }

                    var action = '<button onclick="M.Toast.dismissAll();" class="btn-flat toast-action"><i class="close material-icons">close</i></button>';

                    M.toast({
                        html: parsedData.message + action,
                        classes: "red white-text"
                    });

                }   
            })
        })
    }

    function autoToast(){
        var action = '<button onclick="M.Toast.dismissAll();" class="btn-flat toast-action"><i class="close material-icons">close</i></button>';        
        if (window.location.href.indexOf("updated") > -1) {
            M.toast({
                html: "Profile Updated" + action,
                classes: "orange white-text"
            });
        }
    }