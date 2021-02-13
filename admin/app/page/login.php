<?php

require_once "./app/controller/controller.auth.php";
require_once "./app/controller/controller.utility.php";

$auth = new Auth();
$BASE = Utility::getBase();
$BASE_DIR = Utility::getBase(false);

if($auth->getSession('admin_auth')) { header("location: ".$BASE_DIR); die(); }

$meta_title = "Login - Material Dashboard";
$meta_description = "Material Dashboard v-0.1";

require_once "./app/component/head.php";

?>
<link rel="stylesheet" href="<?= $BASE ?>static/css/login.css">

<div class="full-screen">
    <div class="form-wrap white z-depth-1">
        <div class="login-title">
            <!-- <p class="white-text">Welcome back</p> -->
            <!-- <img src="https://pmc.ph/app/static/image/logo.png" alt="Progressive Medical Corporation's Logo" style="
                margin: auto;
                display: block;
                height: 45px;"> -->
        </div>
        <form action="<?= $BASE_DIR ?>./app/controller/post/post.login.php?mode=login" method="POST" class="content row ajax-form" >
            
            <div class="input-field col s12">
                <input required name="user_name" placeholder="enter user name here" id="user_name" type="text" class="validate">
                <label for="user_name">User Name</label>
            </div>

            <div class="input-field col s12">
                <input required name="user_password" placeholder="enter password here" id="password" type="password" class="validate">
                <label for="password">Password</label>
            </div>

            
            <div class="input-field col s12">
                <button type="submit" class="btn-flat waves-effect white-text" style="background: #10155e">Login</button>
            </div>

        </form>
    </div>
</div>


<?php

require_once "./app/component/footer.php";
