
    $(function(){
        updateUser();
        $('select').formSelect();
        autoToast();
        linkChecker();
        imageprev();
    })
    

    function updateUser(){

        $(".user-form").on("submit", function(e) { 
  
            e.preventDefault();
            $(".add-form, body").css({
                opacity: "0.5",
                cursor: "wait"
            });
            $('#load-wrap').fadeIn(500);
    
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
                    $('#load-wrap').fadeOut(500);
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

                    if(parsedData.code == '7') {
                        var url = window.location.href;
                        window.location.href = root += 'home/?sidebar=0';
                        return;
                    }

                    if(parsedData.code == '8') {
                        var url = window.location.href;
                        window.location.href = root;
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
            var clean_uri = location.protocol + "//" + location.host + location.pathname;
            window.history.replaceState({}, document.title, clean_uri);
            M.toast({
                html: "Profile Updated" + action,
                classes: "orange white-text"
            });

        }
    }

    function linkChecker(){
        $trigger = $('.link-trigger');
        $trigger.on('keyup', function(){
            $closest = $(this).next('.url-checker');
            $closest.attr('href', $(this).val());
        })
    }

    function imageprev(){
        $('#loglog').on('change', function(){
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
             {
                var reader = new FileReader();
        
                reader.onload = function (e) {
                   $('#profile_pic').attr('src', e.target.result);
                }
               reader.readAsDataURL(input.files[0]);
            }
        });
    }