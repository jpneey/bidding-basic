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
<body>

  <?php
    require "component/navbar.php";
  ?>

  <div class="container row">
    
      <?php
        require "model/model.bidding.php";
        $bidding = new Bids();

        $allBidding = $bidding->getAllBids();
        if(!empty($allBidding)){

          foreach($allBidding as $key=>$value){
            $bidCardAction = 'biddings/'.$allBidding[$key]["cs_bidding_id"];
            $bidCardDate = $bidding->getBiddingProduct($allBidding[$key]["cs_bidding_id"], true);
            $bidCardProduct = $bidding->getBiddingProduct($allBidding[$key]["cs_bidding_id"], true);
            $bidCardThumb = 
              ($bidding->getBiddingPicture($allBidding[$key]["cs_bidding_id"]) != "#!") ?
              $bidding->getBiddingPicture($allBidding[$key]["cs_bidding_id"]) :
              'placeholder.svg';

            $bidCardNeededDate = $allBidding[$key]["cs_bidding_date_needed"];
            $date = date_create($bidCardNeededDate);
            $bidCardNeededDate = date_format($date, 'jS  \o\f\ F Y');

            echo "<div class=\"col s6 m4 l3\">";
            require "component/card.php";
            echo "</div>";


          }

        }
      ?>
  </div>
  
  <?php
    require "./component/footer.php";
  ?>

