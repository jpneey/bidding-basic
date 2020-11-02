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
  <link href="<?= $BASE_DIR ?>static/css/index.css?v=beta-222s2" type="text/css" rel="stylesheet"/>

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
                        <p  class="un-margin">Where <b>demand</b> meets <b>supply.</b></p>
                        <a href="#features" data-index="1" class="waves-effect swipe-scroll btn btn-small orange white-text z-depth-0">I need an product/service</a><br>
                        <a href="#features" data-index="2" class="waves-effect swipe-scroll btn btn-small teal darken-2 white-text z-depth-0">I supply a product/service</a>
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
                                <h1 class="un-margin">Client</h1>
                                <p  class="un-margin">As a client, you can post your product/service requirement and suppliers will send their best bids based on your specific requirement.<br></p>
                                <br>
                                <p class="has-icon truncate"><i class="number circle green lighten-1 white-text">1</i> Post what you need</p>
                                <p class="has-icon truncate"><i class="number circle green white-text">2</i> Suppliers will send their best bid.</p>
                                <p class="has-icon truncate"><i class="number circle green darken-1 white-text">3</i> Choose from the bids.</p>
                                <p class="has-icon truncate"><i class="number circle green darken-2 white-text">4</i> Complete transaction with the supplier.</p>
                                <a href="#features" data-index="3" class="waves-effect swipe-scroll btn btn-small orange white-text z-depth-0 mm">Get Started</a>
                            </div>

                        </div>
                        <div class="swiper-slide home-panel dark">
                            <div class="panel-content">
                                <h1 class="un-margin">Suppliers</h1>
                                <p  class="un-margin">Find clients who need your product/service in one place and offer your best bid.<br></p>
                                <br>
                                <p class="has-icon truncate"><i class="number circle green lighten-1 white-text">1</i> Choose from the requirement posts.</p>
                                <p class="has-icon truncate"><i class="number circle green white-text">2</i> Provide your best bid.</p>
                                <p class="has-icon truncate"><i class="number circle green darken-1 white-text">3</i> Win the bid once the client chooses you.</p>
                                <p class="has-icon truncate"><i class="number circle green darken-2 white-text">4</i> Complete transaction with the client.</p>
                                <a href="#features" data-index="3" class="waves-effect swipe-scroll btn btn-small orange white-text z-depth-0 mm">Get Started</a>
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