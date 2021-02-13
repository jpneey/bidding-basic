<?php

require_once "./app/component/import.php";

$meta_title = "Table - Material Dashboard";
$meta_description = "Material Dashboard v-0.1";

require_once "./app/component/head.php";
require_once "./app/component/navbar.php";

?>

<link rel="stylesheet" href="<?= $BASE ?>static/lib/datatables.min.css">
<link rel="stylesheet" href="<?= $BASE ?>static/css/table.css">
<script src="<?= $BASE ?>static/lib/datatables.min.js"></script>    

<div class="main">
    <div class="row">
        <div class="col s12 table-wrap">
            
            <table id="dataTable" class="white z-depth-13">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Item Name</th>
                        <th>Item Name</th>
                        <th><input id="dataTableSearch" class="browser-default" type="text" placeholder="Search" /></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <p>
                                <label>
                                    <input type="checkbox" class="filled-in" />
                                    <span class="black-text">John Doe</span>
                                </label>
                            </p>
                        </td>
                        <td>doe@google.com</td>
                        <td>********</td>
                        <td>
                            <a href='#!' class="btn-flat waves-effect" ><i class="material-icons">more_horiz</i></a>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>
                                <label>
                                    <input type="checkbox" class="filled-in" />
                                    <span class="black-text">John Doe</span>
                                </label>
                            </p>
                        </td>
                        <td>doe@google.com</td>
                        <td>********</td>
                        <td>
                            <a href='#!' class="btn-flat waves-effect" ><i class="material-icons">more_horiz</i></a>
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>

<script src="<?= $BASE ?>static/js/services/table.js"></script>    
<?php

require_once "./app/component/footer.php";