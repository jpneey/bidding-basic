
    $(function(){
        addBid();
        formChips();
        datePicker();
    })

    function formChips() {
        var chipsData = $("#tags").val();
        $('.myChip').chips({
            placeholder: 'Enter tags',
            limit: 5,
            data: chipsData,
            onChipAdd: (event, chip) => {
                var chipsData = M.Chips.getInstance($('.myChip')).chipsData;
                var chipsDataJson = $.map(chipsData, function(e){
                    return e.tag;
                });
                $("#tags").val(chipsDataJson);
                console.log(chipsData);
            },
            onChipDelete: () => {
                var chipsData = M.Chips.getInstance($('.myChip')).chipsData;
                var chipsDataJson = $.map(chipsData, function(e){
                    return e.tag;
                });
                $("#tags").val(chipsDataJson);
            }
        })
        $('.chips').each(function() {
            var that=this;
            $(this).find('input').after('<a href="#" class="add circle grey lighten-2 center-align"><i class="material-icons tiny">add</i></a>');
            $(this).on('click', 'a.add', function(e) {
                e.preventDefault();
                var input=$(e.currentTarget).prev('input');
                $(that).chips('addChip', {
                    tag: input.val()
                }); 
                input.val('');
            });
        });
    }

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
    function addBid(){

        $(".add-form").on("submit", function(e) { 
  
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
                    
                        M.toast({
                            html: parsedData.message,
                            classes: "orange white-text"
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