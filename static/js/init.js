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
    $('.tooltipped').tooltip();
})

$(window).on('load', function(){
    pageFade();
})

$.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
};


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
    $('#load-wrap').fadeOut(500);
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