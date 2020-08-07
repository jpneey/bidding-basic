
    $(function(){
        addOffer();
        datePicker();
        showForm();
    })

    function datePicker() {
        var mindate = new Date();
        var maxdate = new Date();
        maxdate.setDate(maxdate.getDate() + 6);
        $('.datepicker').datepicker({
            minDate: mindate,
            maxDate: maxdate,
            defaultDate: mindate,
            setDefaultDate: mindate,
            format: 'yyyy-m-d 8:00:00'
        });
    }

    function showForm(){
        $('#offer-form').fadeOut('100');
        $('.generate-form').on('click', function(){
            generateForm();
        })
    }

    function generateForm(){
        $item = $('.item');
        $item.each(function(index){
            var itemName = $(this).data('item');
            var itemQty = $(this).data('qty');
            var itemUnit = $(this).data('unit');

            var clone = $('.fields').clone().removeClass('orig');

            clone.find("input[name='cs_offer_product']").val(itemName);
            clone.find(".qty").text(itemUnit);
            clone.find("input[name='cs_offer_qty']").val(itemQty);

            $('.orig').remove();
            $('#offer-form').prepend(clone);

        });
        $('#placeholder').fadeOut('500');
        $('#offer-form').fadeIn('500');
    }

    function addOffer(){

        $("#offer-form").on("submit", function(e) { 
  
            e.preventDefault();
            $("#offer-form, body").css({
                opacity: "0.5",
                cursor: "wait"
            });
            
            $('#load-wrap').fadeIn(500);

            var $inputs = $(this).find("input, select, button, textarea");
            var action = $(this).data("action");
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
                    $("#offer-form, body").css({
                        opacity: "1",
                        cursor: "auto"
                    });
                    $('#load-wrap').fadeOut(500);
                    $inputs.prop("disabled", false);

                    var parsedData = JSON.parse(data);

                    if(parsedData.code == '1') {
                    
                        M.toast({
                            html: parsedData.message,
                            classes: "orange white-text"
                        });
                        $("#submit-offer").load(" #submit-offer > *", function(){
                            $('#offer-form').fadeOut('100');
                        });    
                        return;
                    }

                    var action = '<button onclick="M.Toast.dismissAll();" class="btn-flat toast-action"><i class="close material-icons">close</i></button>';

                    M.toast({
                        html: parsedData.message + action,
                        classes: "orange white-text"
                    });

                }   
            })
        })
    }