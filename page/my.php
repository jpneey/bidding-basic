<?php 

$auth->redirect('auth', true, $BASE_DIR.'404/?unauth=1');
$pageTitle = Sanitizer::filter($uri[1], 'variable') ?: 'account';
$myView = 'component/my/'.$pageTitle.'.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo 'Canvasspoint - '.ucfirst($pageTitle); ?></title>

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
      <div class="container on-plan row">
        <div class="col s12 m12">
          <?php
          
            if(file_exists($myView)):
                require $myView;
            else:
                $emptyTitle = "Ah yes, 404";
                $emptyMessage = "It seems like the page you are looking for was moved, deleted or didn't exist at all.";  
                require 'component/empty.php';
            endif;

          ?>
        </div>
      </div>
    </div>
  </div>
  
  <?php
    require "./component/footer.php";
  ?>