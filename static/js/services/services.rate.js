$(function(){
    rateModal();
    submitRate();
    dashboardNavi();
    autoRate();
})

function rateModal() {
    $trigger = $('.rate-modal-trigger');
    $trigger.on('click', function(){
        var to = $(this).data('to');
        var name = $(this).data('name');
        $('#to-name').text(name);
        $('#to-success').val(name);
        $('#rate-modal').modal();
        $('#rate-modal').modal('open');
        
        $.ajax({
            url: root + 'controller/controller.user.php?action=rate&to=' + to,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data){
                var parsedData = JSON.parse(data);
                var formMode = parsedData.mode
                
                $('#rate-form').attr('action', root + 'controller/controller.user.php?action=rate-'+formMode+'&to='+to);
                $("input[name=rate][value=" + parsedData.rate + "]").prop('checked', true);
                $('#comments').val(parsedData.comment);
                M.textareaAutoResize($('#comments'));
                
            }
        })
        
    })
}

function submitRate() {
    $('#rate-form').on('submit', function(e){
        e.preventDefault();
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
                $inputs.prop("disabled", false);
                var parsedData = JSON.parse(data);
                
                $('#rate-modal').modal();
                $('#rate-modal').modal('close');
                if(parsedData.code == '1') {
                    window.location.reload();
                }
                M.toast({
                    html: parsedData.message,
                    classes: "orange white-text"
                });
            }
        })
    })
}

function autoRate(){
    var urlParams = new URLSearchParams(window.location.search); //get all parameters
    var foo = urlParams.get('to');
    if(foo !== null){

        $('[data-target="#transaction-dashboard"]').trigger('click').click();

        $('a[data-name="'+foo+'"]').trigger('click').click();
        var clean_uri = location.protocol + "//" + location.host + location.pathname;
        window.history.replaceState({}, document.title, clean_uri);

    }
}

function dashboardNavi() {
    $('.dashboard-show').on('click', function () {

        $.each($('.dashboard-show'), function () {
            $(this).css(({'border' : 'none'}));
        })

        $(this).css({'border' : '2px dashed #999'});

        var $toShow = $($(this).data('target'));
        $toShow.fadeIn();
        $toHide = $($toShow.data('target'));
        $toHide.fadeOut();
    })
}