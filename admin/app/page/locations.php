<?php

require_once "./app/component/import.php";

$meta_title = "Locations - Material Dashboard";
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
        
            <table id="locationTable" class="white">
                <thead>
                    <tr>
                        <th>
                            <a href="#add-location" class="btn modal-trigger waves-effect"><i class="material-icons">add</i></a>Locations</th>
                        <th>
                            <input id="locationTableSearch" class="browser-default" type="text" placeholder="Search" />
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

<div id="add-location" class="modal">
    <div class="modal-content">
        <form id="location-form" class="ajax-form row" action="<?= $BASE ?>controller/post/post.location.php?mode=add" method="POST">
            <div class="input-field col s12">
                <h6><b id="form-title">Add Location</b></h6>
            </div>
            <div class="input-field col s12 m4">
                <input required type="text" name="name" placeholder="Location" />
            </div>
            <div class="input-field col s12 m4">
                <button type="submit" class="btn orange darken-2 waves-effect white-text">Submit</button>
            </div>
        </form>
    </div>
</div>

<script src="<?= $BASE ?>static/js/services/table.js?v=2.1"></script>
<script>
    $(function(){
        locationTable();
    })

    
    var updateLocation = function() {
        $('#form-title').text('Update Location');
        var id = $(this).data('id');    
        $.ajax({
            url: root + "app/controller/get/get.location.php?mode=get&id=" + id,
            type: 'GET',
            processData: false,
            contentType: false,
            success: function(data) {
                var response = JSON.parse(data);
                $('#location-form').attr('action', root + "app/controller/post/post.location.php?mode=update&id=" + id);
                $('#add-location').modal('open');
                $('#location-form').find('input[name=name]').val(response[2]);
            }
        })
    }

</script>    
<?php

require_once "./app/component/footer.php";