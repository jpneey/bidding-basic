<?php 

$auth->redirect('auth', true, $BASE_DIR.'home/?unauth=1');
$pageTitle = Sanitizer::filter($uri[1], 'variable') ?: 'account';
$myView = 'component/'.$pageTitle.'.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo $pageTitle ?></title>

  <?php
    require "component/head.php";
  ?>

</head>
<body class="minimal">

  <?php
    require "component/navbar.php";
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="container row">
        <div class="col s12 m12">
          <?php
          
            if(file_exists($myView)):
                require $myView;
            else:
                require 'component/404.php';
            endif;

          ?>
        </div>
      </div>
    </div>
  </div>
  
  <?php
    require "./component/footer.php";
  ?>