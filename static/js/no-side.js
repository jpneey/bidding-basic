$(function(){ unfixSide(); })

function unfixSide(){
    $('#profile-nav').sidenav('destroy');
    $('#profile-nav, .bottom-bar').remove();
    let nh = $('.navbar-fixed').outerHeight();
    $('.main').css({
        'height' : window.innerHeight - nh
    })
}