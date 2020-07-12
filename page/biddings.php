<?php
  
require "model/model.bidding.php";

$bidding = new Bids();
$biddingId = isset($uri[1]) ? (int)$uri[1] : 'none';
$fetchedBidding = $bidding->getBid($biddingId);

$isMine = ((int)$biddingId === (int)$__user_id) ? true : false;

if(empty($fetchedBidding)){
  header("location: ../../404");
  die(); 
}

$fetchedBiddingTitle = $fetchedBidding[0]["cs_bidding_title"];
$fetchedBiddingDetails = $fetchedBidding[0]["cs_bidding_details"];
$fetchedNeededDate = $fetchedBidding[0]["cs_bidding_date_needed"];

$fetchedBiddingQty = $fetchedBidding[0]["cs_bidding_product_qty"].' '.
                     $fetchedBidding[0]["cs_bidding_product_unit"];
$fetchedBiddingPrice = $fetchedBidding[0]["cs_bidding_product_price"];


$bidCardNeededDate = $fetchedNeededDate;
$date = date_create($bidCardNeededDate);
$bidCardNeededDate = date_format($date, 'jS  \o\f\ F Y');

$bidCardAction = '#!';
$bidCardProduct = $fetchedBidding[0]["cs_bidding_product"];
$bidCardThumb = 
  ($fetchedBidding[0]["cs_bidding_picture"] != "#!") ?
  $fetchedBidding[0]["cs_bidding_picture"] :
  'placeholder.svg';
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo $fetchedBiddingTitle . ' - '.$pageTitle ?></title>

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
        
        <h3 class="no-margin">
          <b><?php echo $fetchedBiddingTitle ?></b>
        </h3>
        <br>
        
        <div>
          <p class="title">
            <b><?php echo $bidCardProduct ?></b><br>
            <span class="mini">
              <b><?php echo $fetchedBiddingQty ?></b>
              - PHP <?php echo $fetchedBiddingPrice ?>
            </span>
          </p>
        </div>
        <br>

        <div>
          <?php echo $fetchedBiddingDetails ?>
        </div>
        <br>

        <span id="expiree" class="hide-all" data-date="<?php echo $fetchedNeededDate ?>"></span>
        <div class="row">
          <div class="col s6 m3">
            <div class="card-panel center-align">
              <h3 class="no-margin" id="days">00</h3>
              <span class="timer-unit mini black-text">Days</span>
            </div>
          </div>
          <div class="col s6 m3">
            <div class="card-panel center-align">
              <h3 class="no-margin" id="hours">00</h3>
              <span class="timer-unit mini black-text">Hours</span>
            </div>
          </div>
          <div class="col s6 m3">
            <div class="card-panel center-align">
              <h3 class="no-margin" id="minutes">00</h3>
              <span class="timer-unit mini black-text">Minutes</span>
            </div>
          </div>
          <div class="col s6 m3">
            <div class="card-panel center-align">
              <h3 class="no-margin" id="seconds">00</h3>
              <span class="timer-unit mini black-text">Seconds</span>
            </div>
          </div>
          
        </div>
      </div>

    </div>
    <?php
      echo "<div class=\"col s12 pull-m8 m4 pull-l9 l3\">";
      require "component/card.php";
      echo "</div>";
    ?>
  </div>
  <?php if($isMine){ ?>
  <div class="fixed-action-btn">
    <a class="btn-floating btn-large orange darken-1">
      <i class="large material-icons">mode_edit</i>
    </a>
    <ul>
      <li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>
      <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
      <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
      <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
    </ul>
  </div>

  <?php } ?>
  
  <script>
    // Set the date we're counting down to
    var countDownDate = new Date($('#expiree').data('date')).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();
        
      // Find the distance between now and the count down date
      var distance = countDownDate - now;
        
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
      // Output the result in an element with id="demo"
      $('#days').text(days);
      $('#seconds').text(seconds);
      $('#hours').text(hours);
      $('#minutes').text(minutes);
      // If the count down is over, write some text 
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("expiree").innerHTML = "EXPIRED";
      }
    }, 1000);
  </script>

  <?php
    require "./component/footer.php";
  ?>

