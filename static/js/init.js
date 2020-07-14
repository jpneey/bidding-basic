var root = 'http://localhost/bidding-basic/';
$(function(){
    $('.dropdown-trigger').dropdown();
    $('.modal').modal();
    $('.fixed-action-btn').floatingActionButton({
        hoverEnabled: false
    });
    $('.collapsible').collapsible();
    $('#profile-nav').sidenav();
    $('#category-nav').sidenav({
        menuWidth: '200',
        edge: 'right'
    });
    $('.materialboxed').materialbox();
    $("time.timeago").timeago();
})