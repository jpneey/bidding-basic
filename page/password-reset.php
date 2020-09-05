<?php

$auth->sessionDie();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo 'Canvasspoint - '. ucfirst($pageTitle); ?></title>

  <?php
    require "component/head.php";
  ?>
  <link href="<?= $BASE_DIR ?>static/css/feed.css?v=beta-2" type="text/css" rel="stylesheet"/>

</head>
<body>

  <?php
    require "component/navbar.php";
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="container row">
        <div class="col s12" id="bidding-feed">
        <form action="<?= $BASE_DIR ?>controller/controller.reset.php" class="user-form" method="POST" enctype="multipart/form-data" >
<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label>Home > Password Reset</label>
                    <h1><b>Reset Password</b></h1>
                </div>

                <div class="input-field no-margin col s12">
                    <p><label>New Password *</label></p>
                    <input 
                        required 
                        type="password" 
                        name="cs_new_password" 
                        class="custom-input validate"
                    />
                </div>
                <div class="input-field no-margin col s12">
                    <p><label>Confirm Password *</label></p>
                    <input 
                        required 
                        type="password" 
                        name="cs_confirm_password" 
                        class="custom-input validate"
                    />
                </div>
                <input 
                    type="hidden" 
                    name="token"
                    value="<?= urldecode(Sanitizer::filter('token', 'get')) ?>"
                /><input 
                    type="hidden" 
                    name="em"
                    value="<?= urldecode(Sanitizer::filter('e', 'get')) ?>"
                />

                <div class="input-field no-margin col s12">
                <br>
                <br>
                    <input type="submit" class="btn z-depth-1 orange white-text" value="Reset Password" />
                </div>

                
            </div>
        </div>
    </div>
</div>
</form>
<script src="<?php echo $BASE_DIR ?>static/js/services/services.user.js" type="text/javascript"></script>
       
        
        </div>

      </div>
    </div>
  </div>
  <script src="<?= $BASE_DIR ?>static/js/services/services.feed.js"></script>
  <?php
    require "./component/footer.php";
  ?>