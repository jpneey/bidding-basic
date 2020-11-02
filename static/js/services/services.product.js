$(function(){
    productToast();
    deleteProduct();
    updateProduct();
})

function productToast(){
    var action = '<button onclick="M.Toast.dismissAll();" class="btn-flat toast-action"><i class="close material-icons">close</i></button>';        
    if (window.location.href.indexOf("updated") > -1) {
        var clean_uri = location.protocol + "//" + location.host + location.pathname;
        window.history.replaceState({}, document.title, clean_uri);
        M.toast({
            html: "Products Updated" + action,
            classes: "orange white-text"
        });

        $("html, body").animate({
            scrollTop: $('#products').offset().top
        }, 900)
    }
}

function deleteProduct(){
    $('.delete-product').on('click', function(){
        $('#to-d').val($(this).data('target'));
        $('#delete-product').modal('open');
    })
}

function updateProduct(){

    $('.update-product').on('click', function(){
        var editName = $(this).data('name');
        var editId = $(this).data('id');
        var editCategory = $(this).data('category');
        var editDetails = $(this).data('details');
        var editUnit = $(this).data('unit');
        var editPrice = $(this).data('price');
        var editSale = $(this).data('sale');
        var editImage = $(this).data('image');

        $('#edit-name').val(editName);
        $('#edit-id').val(editId);
        $('#edit-image').val(editImage);
        $('#edit-id-img').val(editId);
        $('#edit-details').val(editDetails);
        $('#edit-category').val(editCategory);
        $('#edit-unit').val(editUnit);
        $('#edit-price').val(editPrice);
        $('#edit-sale').val(editSale);

        $('#update-product').modal('open');
    })
}