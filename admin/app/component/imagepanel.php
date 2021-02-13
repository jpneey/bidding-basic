<br>
<br>
<div class="imagepanel">
<?php

    $files = glob("./app/static/upload/*.*");
    for ($i=0; $i<count($files); $i++) {
        $image = $files[$i];
        $supported_file = array('gif','jpg','JPG','jpeg','png');
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if (in_array($ext, $supported_file)) { ?>
    
            <img class="copy" data-target="<?= basename($image) ?>" src="<?= $BASE."../".$image ?>" alt="image">


        <?php
        } else {
            continue;
        }
    }
?>
</div>
