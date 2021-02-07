
$(function(){
    blogInit();
    contactBlog();
})

function blogInit(){
    $els = $('#blog-post').find('*');
    $ims = $('#blog-post').find('img');

    $els.each(function(){
        $(this).removeAttr("style");
    })   
}

function contactBlog() {

    $('#c-form-on, #c-form-off').on('click', function(){
        $('#c-form').fadeToggle(100);
    })

    $('#c-form').on('submit', function(e){
        e.preventDefault();
        $(".ajax-form, body").css({
            'opacity': '0.5',
            'cursor': 'wait'
        });

        var $inputs = $(this).find("input, select, button, textarea");
        var action = $(this).attr('action');
        var type = $(this).attr('method');
        var formData = new FormData(this);

        $inputs.prop("disabled", true);
        window.onbeforeunload = function () {
            return 'Are you sure you want to navigate away from this page?';
        };
            
        $.ajax({ 
            url: action,
            type: type,
            data: formData,
            success: function(data) {
                window.onbeforeunload = null;
                $(".ajax-form, body").css({
                    'opacity': '1',
                    'cursor': 'auto'
                });
                $inputs.val("");
                $inputs.prop("disabled", false);
                M.toast({
                    html: data,
                    classes: "orange white-text"
                });
                $('#c-form').fadeToggle(100);

            },
            cache: false,
            contentType: false,
            processData: false
        })
    })

}