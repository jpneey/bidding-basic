<?php
  
require "model/model.bidding.php";
require "model/model.user.php";

$auth->redirect('auth', true, '../home');

$user = new User();
$bids = new Bids();

$getUser = $user->getUser($__user_id);
$userBids = $user->getUserBids($__user_id);

$userName = $getUser[0]["cs_user_name"];
$userEmail = $getUser[0]["cs_user_email"];
$userPassword = $getUser[0]["cs_user_password"];


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo 'My Account - '.$userName ?></title>

  <?php
    require "component/head.php";
  ?>

</head>
<body>

  <?php
    require "component/navbar.php";
  ?>

  <div class="container row">
    <div class="col s12 push-m4 m8 push-l3 l9">
      
      <div class="page">
        
        <ul class="collection">
          <?php

            if(!empty($userBids)){ 

              foreach($userBids as $key=>$value){
                
                $bidTitle = $userBids[$key]["mc_bidding_title"];

              }
              
          ?>
              <li class="collection-item avatar">
                <img src="images/yuna.jpg" alt="" class="circle">
                <span class="title">Title</span>
                <p>First Line <br>
                  Second Line
                </p>
                <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
              </li>
          <?php } ?>
        </ul>

      </div>

    </div>
  </div>

  <?php
    require "./component/footer.php";
  ?>

