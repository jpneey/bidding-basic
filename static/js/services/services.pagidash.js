$.fn.extend({
    toggleText: function(a, b){
        return this.text(this.text() == b ? a : b);
    }
});

$(function(){
    pagiDash();
})

function pagiDash() {

    var arr = ['.p-expired-biddings', '.p-active-biddings', '.p-finished-biddings', '.p-active-proposals', '.p-accepted-proposals', '.p-rejected-proposals'];

    $.each(arr, function(i){

        var tot = $(arr[i] + ' .col').length;
        console.log(tot);
        if(tot > 3) {
            
            $(arr[i]).append(
                `<div class="col s12">
                    <button class="btn white-text orange showAll" data-target="${arr[i]}">Show All</button>
                </div>`
            )
        }
    })


    $(document).on('click', '.showAll', function(){
        var t = $(this).data('target');

        $(this).toggleText('Show All', 'Show Less');
        $(t + " .toLoad").fadeToggle('100');
    })

}