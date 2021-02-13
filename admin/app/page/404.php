<?php

require_once "./app/controller/controller.auth.php";
require_once "./app/controller/controller.utility.php";

$auth = new Auth();
$BASE = Utility::getBase();
$BASE_DIR = Utility::getBase(false);


$meta_title = "404 - Material Dashboard";
$meta_description = "Material Dashboard v-0.1";

require_once "./app/component/head.php";

?>
<link rel="stylesheet" href="<?= $BASE ?>static/css/login.css">

<div class="full-screen">
    <div class="form-wrap white z-depth-1">
        <div class="login-title blue">
            <p class="white-text">404 - Page Not Found!</p>
        </div>
        <form action="<?= $BASE_DIR ?>./app/controller/post/post.user.php?mode=login" method="POST" class="content row ajax-form" >
            
            <div class="input-field col s12">
                <p>Are you lost ?</p>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sequi, eius? Repudiandae recusandae possimus</p>
                <a href="<?= $BASE ?>../" class="btn waves-effect blue white-text" >take me home</a>
            </div>

        </form>
    </div>
</div>


<?php

require_once "./app/component/footer.php";
