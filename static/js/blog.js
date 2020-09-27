
$(function(){
    blogInit();
})

function blogInit(){
    $els = $('#blog-post').find('*');
    $ims = $('#blog-post').find('img');

    $els.each(function(){
        $(this).removeAttr("style");
    })

    $ims.each(function(){
        $(this).addClass('materialboxed');
    })
    $('.materialboxed').materialbox();
}