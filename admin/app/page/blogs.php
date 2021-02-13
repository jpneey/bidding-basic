<?php

require_once "./app/component/import.php";

$meta_title = "Blogging - Material Dashboard";
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
        
            <table id="blogTable" class="white">
                <thead>
                    <tr>
                        <th>
                            <a href="<?= $BASE ?>../add-blog/" class="btn modal-trigger waves-effect"><i class="material-icons">add</i></a>Blogs
                        </th>
                        <th>Category</th>
                        <th>Date Added</th>
                        <th>
                            <input id="blogTableSearch" class="browser-default" type="text" placeholder="Search" />
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

<script src="<?= $BASE ?>static/js/services/table.js?v=2.15x"></script>
<script>
    $(function(){
        blogTable();
    })
</script>    
<?php

require_once "./app/component/footer.php";