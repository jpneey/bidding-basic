$(function(){
    triggerInput();
})

function triggerInput() {
    $('.file-trigger').on('click', function() {
        var input = '#'+$(this).data('target');
        $(input).click();
        uploadImage(input);
    })
    
}

function uploadImage(input){
    
    $(input).on('change', function() {
    
        var formData = new FormData();
        formData.append('image', $(this)[0].files[0]);
        loading(false);

        $.ajax({
            url : root + "app/controller/post/post.image.php?mode=add",
            type : 'POST',
            data : formData,
            processData: false,
            contentType: false,  
            success : function(data) {
                var parsedData = JSON.parse(data);
                loading(true);
                
                if(parsedData.code == "3") {
                    window.location.reload();
                    return
                }
                M.toast({
                    html: parsedData.message,
                    classes: "red white-text"
                })

            }
        });

    })
}