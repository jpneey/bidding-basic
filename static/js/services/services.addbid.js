
    
    
    $(function(){
        
        
        /* dynamicSuggestions();
        getSuggestion(); */

        addBid();
        datePicker();
        $('.timepicker').timepicker({
            'defaultTime' : 'now'
        });
    })


    /* function dynamicSuggestions() {
        $('select[name=cs_bidding_category_id]').on('change', function(){
            $.ajax({
                url: root + 'controller/controller.autocomplete.php?mode=tag&id='+$(this).val(),
                type: 'GET',
                processData: false,
                contentType: false,
                success: function(data){
                    $('.myChip').find('input').autocomplete('updateData', JSON.parse(data));
                }
            })
        })
    } */

    /* function getSuggestion(id = 0) {
        $.ajax({
            url: root + 'controller/controller.autocomplete.php?mode=tag&id='+id,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data){
                formChips(JSON.parse(data));
            }
        })
    } */

    /* function formChips(autoTag) {
        $('.myChip').on('keyup', function(){        
            $(this).find('input').autocomplete('open');
        })

        var chipsData = $("#tags").val();
        $('.myChip').chips({
            placeholder: 'Enter tags',
            limit: 5,
            data: chipsData,
            autocompleteOptions: {
                data: autoTag,
                minLength: 0,
                limit: 5
            },
            onChipAdd: (event, chip) => {
                var chipsData = M.Chips.getInstance($('.myChip')).chipsData;
                var chipsDataJson = $.map(chipsData, function(e){
                    return e.tag;
                });
                $("#tags").val(chipsDataJson);
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
            $(this).find('input').after('<a href="#" class="add orange darken-2 white-text center-align"><i class="material-icons tiny">add</i></a>');
            $(this).on('click', 'a.add', function(e) {
                e.preventDefault();
                var input=$(e.currentTarget).prev('input');
                $(that).chips('addChip', {
                    tag: input.val()
                }); 
                input.val('');
            });
        });
    } */

    function datePicker() {
        var mindate = new Date();
        var maxdate = new Date();
        maxdate.setDate(maxdate.getDate() + 6);
        $('.datepicker').datepicker({
            minDate: mindate,
            maxDate: maxdate,
            defaultDate: mindate,
            setDefaultDate: mindate,
            format: 'yyyy-m-d'
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

                    if(parsedData.code == '2'){
                        window.location.href = root + '/bid/' + parsedData.link;
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