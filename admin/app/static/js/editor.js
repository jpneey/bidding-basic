$(function() {
    blogField();
    $('.richText *').addClass('browser-default');
})

function blogField() {
    $('.blog-field').richText({
        // fonts
        fonts: false,
        fontColor: false,
        fontSize: false,
        fileUpload: false,
        videoEmbed: false,
        table: false,
        // code
        removeStyles: true,
        code: true,
        imageHTML: '',
        id: "blog-post"
    });
    textAreaAdjust('#blog-post .richText-editor');
}

function textAreaAdjust(selector) {
    $(selector).on('keyup', function(e) {
        while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
            $(this).height($(this).height()+50);
        };
    });

    
}