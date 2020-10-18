<?php if(!$isLoggedIn) { ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Welcome to Canvasspoint</title>

  <?php
    require "component/head.php";
  ?>
  <link href="<?= $BASE_DIR ?>static/css/feed.css?v=beta-sxx2" type="text/css" rel="stylesheet"/>
  <link href="<?= $BASE_DIR ?>static/css/no-side.css?v=beta-sxx2" type="text/css" rel="stylesheet"/>
  <link href="<?= $BASE_DIR ?>static/js/swiper/swiper-bundle.min.css?v=beta-sxx2" type="text/css" rel="stylesheet"/>
  <link href="<?= $BASE_DIR ?>static/css/index.css?v=beta-2222" type="text/css" rel="stylesheet"/>

</head>
<body>

<?php
    require "component/navbar.php";
?>
    <div class="main">
        <div class="row un-margin">
            <div class="col s12 m7 un-pad">
                <div class="home-panel">
                    <div class="panel-content">
                        <h1 class="un-margin">Welcome<br>to Canvasspoint.</h1>
                        <p  class="un-margin">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident rerum error corrupti.<br>
                        Create your account for free!</p>
                        <a href="#features" data-index="1" class="waves-effect swipe-scroll btn btn-small orange darken-4 white-text z-depth-0">Clients</a>
                        <a href="#features" data-index="2" class="waves-effect swipe-scroll btn btn-small orange white-text z-depth-0">Suppliers</a>
                    </div>
                    <div class="overflow"></div>
                    <img src="<?= $BASE_DIR ?>static/asset/media/baking.jpg?v=3" alt="canvasspoint">
                </div>
            </div>
            
            <div class="col s12 m5 un-pad" id="features">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide home-panel dark">
                            <div class="panel-content">
                                <h1 class="un-margin">The Lorem.</h1>
                                <p  class="un-margin">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident rerum error corrupti.</p>
                                <br>
                                <p class="has-icon truncate"><i class="material-icons circle orange darken-1 white-text">done_all</i> Lorem Ipsum dotor sit amet dotor</p>
                                <p class="has-icon truncate"><i class="material-icons circle orange white-text">done_all</i> Rapidly growing community</p>
                                <p class="has-icon truncate"><i class="material-icons circle orange lighten-1 white-text">done_all</i> Free & Scalable Plans</p>
                            </div>
                        </div>
                        <div class="swiper-slide home-panel dark">
                            <div class="panel-content">
                                <h1 class="un-margin">The Clients.</h1>
                                <p  class="un-margin">It consectetur adipisicing elit. Provident rerum error corrupti.<br></p>
                                <br>
                                <p class="has-icon truncate"><i class="number circle green lighten-1 white-text">1</i> Post a bidding for what you need.</p>
                                <p class="has-icon truncate"><i class="number circle green lighten-1 white-text">2</i> Suppliers will make an offer for it.</p>
                                <p class="has-icon truncate"><i class="number circle green lighten-1 white-text">3</i> Choose bidding winner.</p>
                                <p class="has-icon truncate pro tooltipped" data-position="bottom" data-tooltip="Pro Feature"><i class="material-icons circle orange white-text">all_inclusive</i> Choose multiple bidding winners</p>
                                <p class="has-icon truncate"><i class="material-icons pulse circle green darken-2 white-text">done</i> Get what you need.</p>
                            </div>

                        </div>
                        <div class="swiper-slide home-panel dark">
                            <div class="panel-content">
                                <h1 class="un-margin">The Suppliers.</h1>
                                <p  class="un-margin">It consectetur adipisicing elit. Provident rerum error corrupti.<br></p>
                                <br>
                                <p class="has-icon truncate pro tooltipped" data-position="bottom" data-tooltip="Pro Feature"><i class="material-icons circle orange white-text">all_inclusive</i> Publish Your Featured Products</p>
                                <p class="has-icon truncate"><i class="number circle green lighten-1 white-text">1</i> Find active biddings.</p>
                                <p class="has-icon truncate"><i class="number circle green lighten-1 white-text">2</i> Make an offer for it.</p>
                                <p class="has-icon truncate"><i class="number circle green lighten-1 white-text">3</i> Win the bidding.</p>
                                <p class="has-icon truncate"><i class="material-icons pulse circle green darken-2 white-text">done</i> Add sales to your business.</p>
                            </div>
                        </div>

                        <div class="swiper-slide home-panel dark">
                            <div class="panel-content">

                            <form action="<?= $BASE_DIR ?>controller/controller.login.php?mode=register" class="login-form" method="POST" enctype="multipart/form-data">
                                <h1><b>Register</b></h1>
                                <p>Enter a reachable Email Address, and an email confirmation will be sent.</p>
                                <input required name="cs_ems" placeholder="email-address" type="email" class="custom-input browser-default no-border grey lighten-4">
                                <input name="submit" type="submit" value="Confirm my Email" class="browser-default submit no-border orange white-text">
                            </form>

                            </div>
                        </div>

                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= $BASE_DIR ?>static/js/services/services.feed.js?v=beta-199"></script>
    <script src="<?= $BASE_DIR ?>static/js/swiper/swiper-bundle.min.js?v=beta-199"></script>
    <script src="<?= $BASE_DIR ?>static/js/no-side.js?v=beta-222"></script>
    <script src="<?= $BASE_DIR ?>static/js/index.js?v=beta-222"></script>
<?php
    require "./component/footer.php";
    } else {
        require "home.php";
    }
?>