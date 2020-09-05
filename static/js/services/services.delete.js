$(function(){
    dataDelete();
});


function dataDelete(){
    var $trigger = $('.data-delete');
    var url;

    $trigger.on('click', function(){

        if(!confirm("Are you sure to update/delete this entry?")){ return}

        var selector = $(this).data('selector');
        var mode = $(this).data('mode');
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
                        break;
                    default:
                        var classes = "red";
                        M.toast({
                            html: parsedData.message,
                            classes: classes + " white-text"
                        });
                        return
                }   

                M.toast({
                    html: parsedData.message,
                    classes: classes + " white-text"
                });

                $('.main').load(" .main > *");
                dataDelete();
            }
        })

    })

}