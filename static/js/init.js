var root = 'http://localhost/bidding-basic/';
/* var root = 'http://jpburato.epizy.com/'; */


$.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
};

$(function(){
    $('.dropdown-trigger').dropdown();
    $('.modal').modal({
        inDuration : '500',
        outDuration : '500',
        preventScrolling: false
    });
    $('.fixed-action-btn').floatingActionButton({
        hoverEnabled: false
    });
    $('.collapsible').collapsible();
    $('#profile-nav').sidenav();
    $('#notification-nav').sidenav({
        menuWidth: '200',
        edge: 'right'
    });
    $('.materialboxed').materialbox();
    $("time.timeago").timeago();
    $('.tooltipped').tooltip();
    searchToggle();
    markAsRead();
    sidebars();
})

$(window).on('load', function(){
    setTimeout(function(){
        pageFade();
    }, 500)
})

function sidebars(){
    var urlParams = new URLSearchParams(window.location.search); //get all parameters
    var foo = urlParams.get('sidebar');
    if(foo !== null){
        $('#profile-nav').sidenav('open');
        var clean_uri = location.protocol + "//" + location.host + location.pathname;
        window.history.replaceState({}, document.title, clean_uri);

    }
}


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

function pageFade(){
    $('#load-wrap').fadeOut(100);
}

function updateExpiredBiddings(showToast = false){
    
    $.ajax({
        url: root + 'controller/controller.bidding.php?action=expires',
        type: 'GET',
        processData: false,
        contentType: false,
        success: function(data) {
            var parsedData = JSON.parse(data);
            if(showToast) {
                var action = '<button onclick="M.Toast.dismissAll();" class="btn-flat toast-action"><i class="close material-icons">close</i></button>';
                M.toast({
                    html: parsedData.message + action,
                    classes: "orange white-text"
                });
                $('#offer-form').remove();
                $('#timer-wrapper').html('<a class="waves-effect waves-light btn red" href="#~">Bidding Expired</a><br><br>');
            }

        }   
    })
}

function searchToggle() {
    $('a.filter').on('click', function(){
        $('.filter-panel').fadeToggle(0);
    })
}

function markAsRead(){
    $('.mark-as-read').on('click', function(){
        $('.unread').fadeOut(500);
        $('.notif-panel').addClass('read');
        $.ajax({
            url: root + 'controller/controller.user.php?action=read',
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data) {
                
            }   
        })
    })

    $('.mark-this-read a').on('click', function(e){
        e.preventDefault();
        var t = $(this).parent('.mark-this-read').data('del');
        var u = $(this).data('to');
        $.ajax({
            url: root + 'controller/controller.user.php?action=read&t='+t,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function() {
                window.location.href = root + u;
            }   
        })
    })

    $(".notif-panel a" ).each(function( index ) {
        var link = $(this).data('to');
        var src = root + link;
        $(this).attr('href', src);
    });
}