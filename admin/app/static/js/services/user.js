$(function(){
    viewable();
    accstatus();
})

function viewable(){

    $('body').on('change', '.viewable', function(){

        var target = $(this).data('target');
        var value = $(this).val();

        $.ajax({
            url : root + "app/controller/post/post.user.php?mode=viewable&id="+target+"&value="+value,
            type : 'GET',
            processData: false,
            contentType: false,  
            success : function(data) {
                var parsedData = JSON.parse(data);
                M.toast({
                    html: parsedData.message,
                    classes: "green white-text"
                })

            }
        });
    })

}

function accstatus(){

    $('body').on('change', '.account-status', function(){

        var target = $(this).data('target');
        var value = $(this).val();
        var current = $(this).data('current');

        var message = "";

        if(value == current){
            return
        }

        switch(value){
            case "3":
            case 3:
                message = "Proceed to delete this transaction?";
                break;
            case "2":
            case 2:
                message = "Proceed to set this transaction as 'expired'?";
                break;
            case "1":
            case 1:
                message = "Mark this user's plan as pain? if yes, the user will be granted premium priviledges for up to one year from now.";
                break;
            case "0":
            case 0:
                message = "Revert this transaction to 'processing'?";
                break;
        }

        if(!confirm(message)){
            return;
        }

        $.ajax({
            url : root + "app/controller/post/post.user.php?mode=status&id="+target+"&value="+value,
            type : 'GET',
            processData: false,
            contentType: false,  
            success : function(data) {
                var parsedData = JSON.parse(data);
                M.toast({
                    html: parsedData.message,
                    classes: "green white-text"
                })
                $("#userTable")
                .DataTable()
                .ajax.reload();

            }
        });
    })

}