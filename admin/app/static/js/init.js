var root = "http://localhost/admin/";
/* var root = "http://jpburato.epizy.com/admin/"; */

$(function(){
    initApp();
})

function initApp() {
    materialInit();
    ajaxForm();
    copyToClipboard();
}

function materialInit(){
    $('.collapsible').collapsible();
    $('.modal').modal();
    $(".dropdown-trigger").dropdown();
    $('.sidenav').sidenav();
    $('.modal-form').modal({
        dismissible: false
    });
    $('select').formSelect();
    $('.materialboxed').materialbox({
        onOpenStart: function(){
            $('.navbar-fixed, .sidenav').fadeTo(100,0);
        },
        onCloseEnd: function(){
            $('.navbar-fixed, .sidenav').fadeTo(100,1);
        },
    });
}

function ajaxForm(){

    $('.ajax-form').on('submit', function(event){

        event.preventDefault();

        var $inputs = $(this).find("input, select, button, textarea");
        var action = $(this).attr("action");
        var type = $(this).attr("method");
        var formData = new FormData(this);

        $inputs.prop("disabled", true);

        loading(false);

        $.ajax({
            url: action,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) { 

                loading(true);
                $inputs.prop("disabled", false);
                var parsedData = JSON.parse(data);

                switch(parsedData.code) {
                    case 0:
                        var style = "red";
                        break;
                    case 1:
                        var style = "green";
                        break;
                    case 2:
                        var style = "green";
                        $('.modal.open').modal('close');
                        reloadTables();
                        break;
                    default:
                        window.location.reload();
                        return
                }
                M.toast({
                    html: parsedData.message,
                    classes: style+" white-text"
                })
            }
        })
    })
}

function reloadTables() { return }

var dataDelete = function () {

    if(!confirm("Confirm item deletion")){ return }
    var mode = $(this).data('mode');
    var target = $(this).data('target');
    var url = root + "app/controller/delete/delete.php?mode="+mode+"&target="+target;
    
    loading(false);
    
    $.ajax({
        url: url,
        type: 'GET',
        processData: false,
        contentType: false,
        success: function(data) { 
            $('.modal').each(function(){
                $(this).modal('close');
            })
            reloadTables();
            M.toast({
                html: data,
                classes: "red white-text"
            })
            setTimeout(function(){
                loading(true);
            }, 500)
        }
    })
}


function copyToClipboard() {

    $('.copy').on('click', function(){
        var $temp = $("<input>");
        var text = $(this).data('target');
        $("body").append($temp);
        $temp.val(root + "app/static/upload/" + text).select();
        document.execCommand("copy");
        $temp.remove();

        M.toast({
            html: text + " copied to clipboard",
            classes: "green white-text"
        })
    })

}

function loading(finished = false) {
    if(!finished) {
        $('body').append("<div id=\"temp-load\" class=\"progress\"><div class=\"indeterminate\"></div></div>");
        $('.sidenav, .main').fadeTo('100', 0.5);
        window.onbeforeunload = function() { return "Are you sure you want to navigate away from this page?";};
        return
    }
    $('#temp-load').remove();
    $('.sidenav, .main').fadeTo('100', 1);
    window.onbeforeunload = null;
    return
}