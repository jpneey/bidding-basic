<?php

require_once "./app/component/import.php";

$meta_title = "Maintenance - Material Dashboard";
$meta_description = "Material Dashboard v-0.1";

require_once "./app/controller/controller.sanitizer.php";

require_once "./app/component/head.php";
require_once "./app/component/navbar.php";

require_once "./app/model/model.maintenance.php";
$maintenance = new Maintenance();

$adminEmail = $maintenance->getAdminEmail();
$homeData = explode(',', $maintenance->getHomeData());


$vSup = Sanitizer::filter('suppliers', 'get');

?>


<div class="main">
    <div class="row">
        <div class="col s12 table-wrap">
            <form class="ajax-form card-panel white" method="POST" action="<?= $BASE_DIR ?>./app/controller/post/post.maintenance.php?mode=email">
                <label><b>Admin Email</b></label>
                <input required type="email" name="em" value="<?= $adminEmail ?>" />
                <button type="submit" class="btn orange">Update Admin Email</button>
            </form>
        </div>

        <div class="col s12 table-wrap">
            <form class="ajax-form card-panel white" method="POST" action="<?= $BASE_DIR ?>./app/controller/post/post.maintenance.php?mode=home">
                <label><b>Home Details</b></label>
                <br>
                <p>Assign '0' value to use actual data.</p>
                <div class="row">
                    <div class="col s12 m4">
                        <label>Total Bids</label>
                        <input required type="number" name="a" min="0" value="<?= $homeData[0] ?>" />
                    </div>
                    <div class="col s12 m4">
                        <label>Total Clients</label>
                        <input required type="number" name="b" min="0" value="<?= $homeData[1] ?>" />
                    </div>
                    <div class="col s12 m4">
                        <label>Total Suppliers</label>
                        <input required type="number" name="c" min="0" value="<?= $homeData[2] ?>" />
                    </div>
                    <div class="col s12 m4">
                        <label>Bids Today</label>
                        <input required type="number" name="d" min="0" value="<?= $homeData[3] ?>" />
                    </div>
                </div>
                <button type="submit" class="btn orange">Update Home Data</button>
            </form>
        </div>

    </div>
</div>
<?php

require_once "./app/component/footer.php";