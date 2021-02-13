<?php

require_once "./app/component/import.php";

$meta_title = "Categories - Material Dashboard";
$meta_description = "Material Dashboard v-0.1";

require_once "./app/component/head.php";
require_once "./app/component/navbar.php";

?>

<link rel="stylesheet" href="<?= $BASE ?>static/lib/datatables.min.css">
<link rel="stylesheet" href="<?= $BASE ?>static/css/table.css">
<script src="<?= $BASE ?>static/lib/datatables.min.js"></script>    

<div class="main">
    <div class="row">
        <div class="col s12 table-wrap z-depth-1">
        
            <table id="categoryTable" class="white">
                <thead>
                    <tr>
                        <th>
                            <a href="#add-category" class="btn modal-trigger waves-effect"><i class="material-icons">add</i></a>Category</th>
                        <th>Description</th>
                        <th>
                            <input id="categoryTableSearch" class="browser-default" type="text" placeholder="Search" />
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ajax Content -->
                </tbody>
            </table>

        </div>
    </div>
</div>

<div id="add-category" class="modal">
    <div class="modal-content">
        <form id="category-form" class="ajax-form row" action="<?= $BASE ?>controller/post/post.category.php?mode=add" method="POST">
            <div class="input-field col s12">
                <h6><b>Add Category</b></h6>
            </div>
            <div class="input-field col s12 m4">
                <input required type="text" name="name" placeholder="Category Name" />
            </div>
            <div class="input-field col s12 m8">
                <input required type="text" name="desciption" placeholder="Short Description" />
            </div>

            <div class="input-field col s12 m4">
                <button type="submit" class="btn orange darken-2 waves-effect white-text">Submit</button>
            </div>
        </form>
    </div>
</div>

<div id="add-tag" class="modal">
    <div class="modal-content">
        <form id="tag-form" class="ajax-form row" action="<?= $BASE ?>controller/post/post.category.php?mode=add-tag" method="POST">
            <div class="input-field col s12">
                <h6><b id="category-on-tag"></b></h6>
            </div>
            <div class="input-field col s12 m4">
                <input required type="text" name="name" id="tag-name" placeholder="Product / Service name" />
                <input required type="hidden" name="category_id" id="cat-on-tag-id" />
            </div>
            <div class="input-field col s12 m4">
                <button type="submit" class="btn orange darken-2 waves-effect white-text">Submit</button>
            </div>
            <div class="input-field col s12" id="tags">
            </div>
        </form>
    </div>
</div>

<script src="<?= $BASE ?>static/js/services/table.js"></script>
<script>
    $(function(){
        categoryTable();
    })

    
    var updateCategory = function() {
        
        var id = $(this).data('id');
        
        $.ajax({
            url: root + "app/controller/get/get.category.php?mode=get&id=" + id,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data) {
                var response = JSON.parse(data);
                $('#category-form').attr('action', root + "app/controller/post/post.category.php?mode=update&id=" + id);
                $('#add-category').modal('open');
                $('#category-form').find('input[name=name]').val(response[1]);
                $('#category-form').find('input[name=desciption]').val(response[2]);
            }
        })
    }

    var updateTag = function() {
        
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#category-on-tag').text(name);
        $('#cat-on-tag-id').val(id);
        $('#tag-name').val('');
        var action = $('#tag-form').attr('action') + "&id=" + id;
        $('#tag-form').attr('action', action);
        $.ajax({
            url: root + "app/controller/get/get.category.php?mode=get-tags&id=" + id,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data) {
                $('#tags').html(data);
                $('#add-tag').modal('open');
            }
        })
    }

</script>    
<?php

require_once "./app/component/footer.php";