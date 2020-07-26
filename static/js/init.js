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
    $('.tooltipped').tooltip();
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