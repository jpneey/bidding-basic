<?php

require_once "./app/component/import.php";

$meta_title = "Library - Material Dashboard";
$meta_description = "Material Dashboard v-0.1";

require_once "./app/component/head.php";
require_once "./app/component/navbar.php";

if(!in_array($loggedInRole, array(3,5))) {
    require '404.php';
    die();
}

?>

<div class="main">
    <div class="row">
        <div class="col s12 m3">
            <div class="add-image">

                <input id="file-to-trigger" type="file" accept="image/*" class="file browser-default">

                <button type="button" data-target="file-to-trigger"  class="btn-flat file-trigger grey-text z-depth-0"><i class="material-icons">control_point</i></button>
            
            </div>
        </div>
    <?php
        
        $files = glob("./app/static/upload/*.*");
        for ($i=0; $i<count($files); $i++) {
            $image = $files[$i];
            $supported_file = array('gif','jpg','JPG','jpeg','png');
            $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            if (in_array($ext, $supported_file)) { ?>
        
                    <div class="col s12 m3">
                        <div class="card">
                            <div class="card-image">
                                <img class="materialboxed" src="<?= $BASE."../".$image ?>" alt="image">
                            </div>
                            <div class="card-content">
                                <p class="truncate"><?= basename($image) ?></p>
                            </div>
                            <div class="card-action">
                                <a class="copy btn blue white-text waves-effect" data-target="<?= basename($image) ?>" ><i class="material-icons" >content_copy</i></a>
                                <a class="btn red white-text waves-effect" onclick="dataDelete.call(this)" data-mode="image" data-target="<?= basename($image) ?>" ><i class="material-icons" >clear</i></a>
                            </div>
                        </div>
                    </div>

            <?php
            } else {
                continue;
            }
        }
    ?>
    </div>
</div>
<script src="<?= $BASE ?>static/js/drop.js"></script>

<?php

require_once "./app/component/footer.php";