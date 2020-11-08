$(function(){
    dataDelete();
});


function dataDelete(){
    var $trigger = $('.data-delete');

    $trigger.on('click', function(){

        var selector = $(this).data('selector');
        var mode = $(this).data('mode');

        var message = $(this).data('message');
        var confirm;

        if(typeof(message) != 'undefined'){ $('#confirm-message').html(message); }
        $('#confirm').modal({dismissible: false});
        $('#confirm').modal('open');

        $('.modal-confirm').on('click', function(){
            confirm = $(this).data('confirm');
            $('#confirm').modal('close');
            $('.modal-confirm').off('click');
            if(confirm){ deleteNow(mode, selector); }
        })

        return;
    })
}

function deleteNow(mode, selector){
    var url;
    switch(mode){
        case 'bid':
            url = 'controller/controller.bidding.php?action=delete&selector='+selector;
            break;
        case 'bid-finish':
            url = 'controller/controller.bidding.php?action=finish&selector='+selector;
            break;
        case 'featured':
            url = 'controller/controller.business.php?action=delete';
            break;
        case 'offer':
            url = 'controller/controller.offer.php?action=delete&selector='+selector;
            break;
    }
    $("body, html").css({
        opacity: "0.5",
        cursor: "wait"
    });
    $('#load-wrap').fadeIn(500);
    window.onbeforeunload = function() { return "Reloading may not save your changes. Are you sure you want to leave the page?";};
    $.ajax({
        url: root + url,
        type: 'GET',
        processData: false,
        contentType: false,
        success: function(data) {
            $('#load-wrap').fadeOut(500);
            window.onbeforeunload = null;
            $("body, html").css({
                opacity: "1",
                cursor: "auto"
            });
            var parsedData = JSON.parse(data);

            switch(parsedData.code){
                case 1:
                    var classes = "green";
                    window.location.reload();
                    return;
                default:
                    var classes = "red";
                    M.toast({
                        html: parsedData.message,
                        classes: classes + " white-text"
                    });
                    return
            }
        }
    })
}