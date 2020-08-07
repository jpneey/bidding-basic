<?php

defined('included') || die("Bad request");

class viewBids extends Bids {

    private $BASE_DIR;

    public function __construct($BASE_DIR) {
        $this->BASE_DIR = $BASE_DIR;
    }

    public function load($v){
        return $v;
    }

    public function ViewFeed($filter = "ORDER BY cs_bidding_id DESC LIMIT 20", $type = '', $value = array()){
        
        $bidsInFeed = $this->getBiddings($filter, $type, $value);
        $bidsInFeedCount = count($bidsInFeed);
        $iteration = 0;
        if(!empty($bidsInFeed)){

            foreach($bidsInFeed as $key=>$value){
                $iteration++;
                $bidsInFeedId = $bidsInFeed[$key]["cs_bidding_id"];
                $bidInFeedTitle = $bidsInFeed[$key]["cs_bidding_title"];
                $bidInFeedDetails = $bidsInFeed[$key]["cs_bidding_details"];
                $bidInFeedLink = $bidsInFeed[$key]["cs_bidding_permalink"];
                $datePosted = $bidsInFeed[$key]["cs_bidding_added"];
                $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($bidsInFeed[$key]['cs_owner_rating']));
                $province = $bidsInFeed[$key]["cs_bidding_location"];
                $datePosted = '<time class="timeago" datetime="'.$bidsInFeed[$key]["cs_bidding_added"].'">'.$bidsInFeed[$key]["cs_bidding_added"].'</time>';
                $bidInFeedPicture = '';
                if($bidsInFeed[$key]["cs_bidding_picture"] !== '#!'){
                    $bidInFeedPicture = '
                    <div class="feed-image-wrapper">
                        <img src="'.$this->BASE_DIR.'static/asset/bidding/'.$bidsInFeed[$key]["cs_bidding_picture"].'" alt="'.$bidInFeedTitle.'"/>
                    </div>
                    ';
                }
                
                ?>
                <a href="<?= $this->BASE_DIR.'bid/'.$bidInFeedLink ?>">
                    <div class="post-card white z-depth-1 hoverable">    
                            <div class="title grey-text text-darken-3"><b class="truncate"><?= $bidInFeedTitle ?></b></div>
                            <div class="sub-title grey-text"><?= $province.' @ '.$datePosted ?></div>
                            <div class="preview grey-text text-darken-3"><span class="truncate"><?= $bidInFeedDetails ?></span></div>
                            <span class="ratings"><?= $rating ?></span>
                        
                        <div class="image-wrapper grey lighten-4">
                            <?= $bidInFeedPicture ?>
                        </div>
                    </div>
                </a>
                <?php
                if($bidsInFeedCount == $iteration){
                    echo '<span id="bidFeedNext" data-base="'.$this->BASE_DIR.'"  data-id="'.$bidsInFeedId.'"><br></span>';
                }
            }
        }
    }

    public function viewBid($selector) {

        $viewBid = $this->getBid($selector);
        if(!empty($viewBid)) {
            $title = $viewBid[0]['cs_bidding_title'];
            $status = $viewBid[0]['cs_bidding_status'];
            $details = $viewBid[0]['cs_bidding_details'];
            $products = $viewBid[0]['cs_bidding_products'];
            $dateNeeded = $viewBid[0]['cs_bidding_date_needed'];
            $location = $viewBid[0]['cs_bidding_location'];
            $tags = preg_split('@,@', $viewBid[0]['cs_bidding_tags'], NULL, PREG_SPLIT_NO_EMPTY);
            $tagchip = '';
            foreach($tags as $tag) {
                $tagchip .= '<span class="chip grey lighten-4">'.$tag.'</span>';
            }
            $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($viewBid[0]['cs_owner_rating']));
            $picture = 
                ($viewBid[0]['cs_bidding_picture'] != '#!') ? 
                '<img id="bidding-details" src="'.$this->BASE_DIR.'static/asset/bidding/'.$viewBid[0]['cs_bidding_picture'].'" class="margin-auto materialboxed scrollspy" />' :
                '';
            ?>
            
            <div class="page white z-depth-1">
                <div id="introduction" class="content scrollspy">
                    <label>Home > bid > <?= $title ?></label>
                    <br>
                    <br>
                    <h1 class="no-margin">
                        <b><?= $title ?></b>
                        <span class="ratings"><?= $rating ?></span>
                    </h1>
                    <br>
                    <div class="glance white">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($products as $k=>$v) {                     
                                        $item = $products[$k]['cs_product_name'];
                                        $budget = number_format($products[$k]['cs_product_price'], '2', '.', ',');
                                        $qty = $products[$k]['cs_product_qty'] . ' ' . $products[$k]['cs_product_unit'];
                                ?>
                                <tr class="item" data-item="<?= $item ?>" data-qty="<?= $products[$k]['cs_product_qty'] ?>" data-unit="<?= $products[$k]['cs_product_unit'] ?>">
                                    <td><?= $item ?></td>
                                    <td><?= $qty ?></td>
                                    <td>₱ <?= $budget ?></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <?php if($status) { ?>
                    <p id="timer-wrapper">
                        <b>Bidding ends in:</b><br>
                        <span id="days">00</span> <span>days</span>
                        <span id="hours">00</span> <span>hours</span>
                        <span id="minutes">00</span> <span>minutes</span>
                        <span id="seconds">00</span> <span>seconds</span>  
                    </p>
                    <?php } else {
                        echo '<p><a class="waves-effect waves-light btn red" href="#~">Bidding Expired</a><br><br></p>';
                    } ?>
                    <p>
                        <b>Date Needed:</b><br>
                        <?= date_format(date_create($dateNeeded), 'g:ia \o\n l jS F Y') ?>
                    </p>
                    <p>
                        <b>Location:</b><br>
                        <?= $location ?>
                    </p>
                    <p><?= nl2br($details); ?></p>
                    
                    <span><br><?= $tagchip ?></span>
                    
                </div>
                <?= $picture ?>
            </div>

            <link href="<?= $this->BASE_DIR ?>static/css/timer.css" type="text/css" rel="stylesheet"/>
            <?php if($status) { ?>
            <script> $(function(){ timer('<?= $dateNeeded ?>') }) </script>
            <?php
            }
        }
    }

    public function viewUserBidStatus($user_id){ 

        $counts = $this->getDashboardCounts($user_id);

        ?>
            <div class="col s12 m4">
                <div class="dashboard-panel green lighten-0 white-text z-depth-1">
                    <h1><b><?= $counts[0] ?></b></h1>
                    <p>Active Posts</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="dashboard-panel red lighten-0 white-text z-depth-1">
                    <h1><b><?= $counts[2] ?></b></h1>
                    <p>Expired Posts</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="dashboard-panel orange lighten-0 white-text z-depth-1">
                    <h1><b><?= $counts[1] ?></b></h1>
                    <p>Total Post</p>
                </div>
            </div>

        <?php
    }

    public function viewUserBids($user_id){
        
        $userBids = $this->getUserBids($user_id);
        if(!empty($userBids)){
            foreach($userBids as $key=>$value){
                $bidInFeedLink = $userBids[$key]["cs_bidding_permalink"];
                $bidInFeedTitle = $userBids[$key]["cs_bidding_title"];
                $bidInFeedOfferCount = $userBids[$key]["cs_bidding_offer_count"];
                switch($userBids[$key]["cs_bidding_status"]){
                    case '1':
                        $statusStyle = 'feed-border green-text text-lighten-0';
                        break;
                    case '2':
                        $statusStyle = 'feed-border orange-text text-lighten-2';
                        break;
                    case '0':
                        $statusStyle = 'feed-border red-text text-lighten-2';
                        break;
                }
                echo '<div class="col s12 block">';
                $datePosted = '<time>'.date_format(date_create($userBids[$key]["cs_bidding_added"]), 'D d M Y').'</time>'; ?>
 
                <a href="<?= $this->BASE_DIR.'bid/'.$bidInFeedLink ?>">
                    <div class="feed-card feed-card-full white z-depth-1 <?= $statusStyle ?>">
                        <div class="feed-head">
                            <p class="grey-text text-darken-3">
                                <?= $bidInFeedTitle ?><br>
                                <span class="grey-text lighten-2">
                                <?= 'Posted @ '.$datePosted ?><br>
                                </span>
                            </p>
                        </div>
                    </div>
                </a>
                
                <span class="card-counter">
                    <a class="z-depth-1 orange white-text center-align"><?= $bidInFeedOfferCount ?></a>
                    <a href="#!" data-selector="<?= $bidInFeedLink ?>" data-mode="bid" class="data-delete z-depth-1 red white-text center-align">delete</a>
                    <a class="z-depth-1 green white-text center-align">edit</a>
                </span>
            <?php
            echo '</div>';
            }
        }
    }
    
}

//EOF
