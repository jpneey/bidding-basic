<?php

require_once "./app/component/import.php";

$meta_title = "Users - Material Dashboard";
$meta_description = "Material Dashboard v-0.1";

require_once "./app/controller/controller.sanitizer.php";

require_once "./app/component/head.php";
require_once "./app/component/navbar.php";

$vSup = Sanitizer::filter('suppliers', 'get');

?>

<link rel="stylesheet" href="<?= $BASE ?>static/lib/datatables.min.css">
<link rel="stylesheet" href="<?= $BASE ?>static/css/table.css">
<script src="<?= $BASE ?>static/lib/datatables.min.js"></script>    
<style> select { display: block } </style>
<Style> td, th { white-space: nowrap; } </style>

<div class="main">
    <div class="row">
        <div class="col s12 table-wrap z-depth-1">
        
            <table id="userTable" class="white">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><input id="userTableSearch" class="browser-default" type="text" placeholder="Search" style="width: 170px" /></th>
                        <th>Email Address</th>
                        <th>User Type</th>
                        <th>Rating</th>
                        <th>Account</th>
                        <th>Account Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ajax Content -->
                </tbody>
            </table>

        </div>
    </div>
</div>


<script src="<?= $BASE ?>static/js/services/table.js?v=5"></script>
<script src="<?= $BASE ?>static/js/services/user.js"></script>
<script>
    $(function(){
        <?php if($vSup) { ?>
        userTable('suppliers');
        <?php } else { ?> 
        userTable('clients');    
        <?php } ?>
    })
</script>    
<?php

require_once "./app/component/footer.php";