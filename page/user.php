<?php 

$selector = Sanitizer::filter($uri[1], 'var');
if(!$selector){
    require "404.php";
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Canvasspoint - <?php echo str_replace('-', ' ', $selector) ?></title>

  <?php
    require "component/head.php";
  ?>

</head>
<body class="minimal un-pad-stars">

  <?php
    require "component/navbar.php";
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="row">
        <div class="col s12">
          <?php
            require_once "view/view.user.php";
            $viewUser = new viewUser($BASE_DIR, $conn);
            $viewUser->viewProfile($selector);
          ?>
        </div>
        
      </div>
    </div>
  </div>

  <script src="<?php echo $BASE_DIR ?>static/js/services/services.feed.js?v=beta_1.008" type="text/javascript"></script>
  <?php
    $viewOnLoad = Sanitizer::filter('view', 'get', 'int');
    if($viewOnLoad){ ?>
    <script>
        $(function(){
            prepareModal(<?= $viewOnLoad ?>)
        })
    </script>
    <script src="<?= $BASE_DIR ?>static/js/services/services.feed.js?v=beta-199"></script>
    <?php
    }
    require "./component/footer.php";
  ?>