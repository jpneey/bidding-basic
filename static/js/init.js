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
    starRates();
})


const cleanJSON = (s) => {
    s = s.replace(/\\n/g, "\\n")  
     .replace(/\\'/g, "\\'")
     .replace(/\\"/g, '\\"')
     .replace(/\\&/g, "\\&")
     .replace(/\\r/g, "\\r")
     .replace(/\\t/g, "\\t")
     .replace(/\\b/g, "\\b")
     .replace(/\\f/g, "\\f");
    s = s.replace(/[\u0000-\u0019]+/g,""); 

    return JSON.parse(s);
}

function starRates() {
    var $el = $('.ratings');
    var child = (5 - $el.children().length);
    $el.append(new Array(++child).join('<i class="material-icons orange-text">star_outline</i>'));
}