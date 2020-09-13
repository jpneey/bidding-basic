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

    public function ViewFeed($filter = array(), $emptyMessage = "Welcome to canvasspoint! Unfortunately there are no active biddings as of the moment. How about viewing our suppliers ?"){
        
        $bidsInFeed = $this->getBiddings($filter);
        if(!empty($bidsInFeed)){
    
            foreach($bidsInFeed as $key=>$value){
                $bidInFeedTitle = $bidsInFeed[$key]["cs_bidding_title"];
                $bidInFeedDetails = $bidsInFeed[$key]["cs_bidding_details"];
                $bidInFeedLink = $bidsInFeed[$key]["cs_bidding_permalink"];
                $datePosted = $bidsInFeed[$key]["cs_bidding_added"];
                $tagchip = '<span class="chip grey lighten-2 white-text">'.$bidsInFeed[$key]["cs_category_name"].'</span>';
                $tags = preg_split('@,@', $bidsInFeed[$key]['cs_bidding_tags'], NULL, PREG_SPLIT_NO_EMPTY);
                foreach($tags as $tag) {
                    $tagchip .= '<span class="chip grey lighten-3">'.$tag.'</span>';
                }
               /*  $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($bidsInFeed[$key]['cs_owner_rating'])); */
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
                    <div class="post-card white z-depth-1 waves-effect">    
                            <div class="title grey-text text-darken-3"><b class="truncate"><?= $bidInFeedTitle ?></b></div>
                            <div class="sub-title grey-text"><?= $province.' @ '.$datePosted ?></div>
                            <div class="preview grey-text text-darken-3"><span class="truncate"><?= $bidInFeedDetails ?></span></div>
                            <!-- <span class="ratings"></span> -->
                        
                        <div class="image-wrapper">
                            <?= $bidInFeedPicture ?>
                        </div>
                    </div>
                </a>
                <?php
            }
        } else {
            ?>
            <div class="post-card white z-depth-1 waves-effect" style="padding: 45px !important;">    
                <p><b>Oh, Hello there!</b></p>
                <p><?= $emptyMessage ?></p>
                <a href="<?= $this->BASE_DIR.'supplier/' ?>" class="btn orange white-text">view suppliers</a>
            </div>
            <?php
        }
    }

    public function viewBid($selector) {

        $viewBid = $this->getBid($selector);
        if(is_array($viewBid) && !empty($viewBid[0]['cs_bidding_id'])) {

            $title = $viewBid[0]['cs_bidding_title'];
            $status = $viewBid[0]['cs_bidding_status'];
            $details = $viewBid[0]['cs_bidding_details'];
            $dateNeeded = $viewBid[0]['cs_bidding_date_needed'];
            $location = $viewBid[0]['cs_bidding_location'];
            $tags = preg_split('@,@', $viewBid[0]['cs_bidding_tags'], NULL, PREG_SPLIT_NO_EMPTY);
            $tagchip = '<span class="chip grey lighten-1 white-text">'.$viewBid[0]["cs_category_name"].'</span>';
            $item = $viewBid[0]['cs_product_name'];
            $budget = number_format($viewBid[0]['cs_product_price'], '2', '.', ',');
            $qty = $viewBid[0]['cs_product_qty'] . ' ' . $viewBid[0]['cs_product_unit'];
            foreach($tags as $tag) {
                $tagchip .= '<span class="chip grey lighten-3">'.$tag.'</span>';
            }
            $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($viewBid[0]['cs_owner_rating']));
            $picture = ($viewBid[0]['cs_bidding_picture'] != '#!') ? $viewBid[0]['cs_bidding_picture'] : 'placeholder.svg';
                
            ?>
            
            <div class="page white z-depth-1">
                <div id="introduction" class="content scrollspy">
                    <label><a href="<?= $this->BASE_DIR ?>" class="grey-text">Home</a> > bid > <?= $title ?></label>
                    <br>
                    <br>
                    <h1 class="no-margin">
                        <b><?= $title ?></b>
                        <span class="ratings"><?= $rating ?></span>
                    </h1>
                    <br>
                    
                    <p><?= nl2br($details); ?></p>

                    <?php if($status == 1) { ?>
                    <p id="timer-wrapper">
                        <b>Bidding ends in:</b><br>
                        <span id="days">00</span> <span>days</span>
                        <span id="hours">00</span> <span>hours</span>
                        <span id="minutes">00</span> <span>minutes</span>
                        <span id="seconds">00</span> <span>seconds</span>  
                    </p>
                    <?php } else { ?>
                        <p>
                            <a class="waves-effect waves-light btn orange" href="#~">Bidding Ended</a>
                            <?= $this->getBidWinner($viewBid[0]['cs_bidding_id']); ?>
                            <br><br>
                        </p>
                    <?php } ?>
                    <p>
                        <b>Date Needed:</b><br>
                        <?= date_format(date_create($dateNeeded), 'g:ia \o\n l jS F Y') ?>
                    </p>
                    <div class="glance white">
                        <div class="product-card item" data-budget="₱ <?= $budget ?>" data-item="<?= $item ?>" data-qty="<?= $viewBid[0]['cs_product_qty'] ?>" data-unit="<?= $viewBid[0]['cs_product_unit'] ?>">
                            <div class="thumbnail">
                                <img id="bidding-details" src="<?= $this->BASE_DIR ?>static/asset/bidding/<?= $picture ?>" class="margin-auto materialboxed" />
                            </div>
                            <div class="content">
                                <p class="truncate"><b><?= $location ?></b></p>
                                <p><?= $item ?> <?= $qty ?></p>
                                <p class="truncate grey-text">₱ <?= $budget ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <span><br><?= $tagchip ?></span>
                    
                </div>
            </div>

            <link href="<?= $this->BASE_DIR ?>static/css/timer.css" type="text/css" rel="stylesheet"/>
            <link href="<?= $this->BASE_DIR ?>static/css/bid.css" type="text/css" rel="stylesheet"/>
            <?php if($status) { ?>
            <script> $(function(){ timer('<?= $dateNeeded ?>') }) </script>
            <?php
            }
        }
    }

    public function getBidWinner($biddingId){ 
        $winner = $this->hasWinner($biddingId);
        if(!$winner) {
        ?> 
        <a class="waves-effect waves-light btn orange darken-3" href="#!">Pending Winner </a><br><br>
        * Purchaser is still choosing for a winner.
        <?php } else {   
        $product = unserialize($winner[1]);
        ?>
        <a href="<?= $this->BASE_DIR ?>user/<?= $winner[2][0] ?>/" class="waves-effect waves-light btn orange darken-3">@<?= $winner[2][0] ?> won</a><br>
        <div class="glance white">
            <div class="product-card">
                <div class="thumbnail">
                    <img id="bidding-details" src="<?= $this->BASE_DIR ?>static/asset/user/<?= $winner[2][1] ?>" class="margin-auto materialboxed" />
                </div>
                <div class="content">
                    <p class="truncate"><b>Bid Winner:</b></p>
                    <p><?= $winner[2][0] ?></p>
                    <p class="truncate grey-text">₱ <?= number_format($product["price"][0], 2,'.',',') ?></p>
                </div>
            </div>
        </div>

        <?php
        }
    }

    public function viewUserBidStatus($user_id){ 

        $counts = $this->getDashboardCounts($user_id);

        ?>
            <div class="col s12 m4">
                <div class="dashboard-panel green lighten-0 white-text z-depth-1">
                    <h1><b><?= $counts[0] ?></b></h1>
                    <p>Active Bidding</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="dashboard-panel red lighten-0 white-text z-depth-1">
                    <h1><b><?= $counts[2] ?></b></h1>
                    <p>Expired Bidding</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="dashboard-panel orange lighten-0 white-text z-depth-1">
                    <h1><b><?= $counts[1] ?></b></h1>
                    <p>Finished Bidding</p>
                </div>
            </div>

        <?php
    }

    public function viewUserBids($user_id, $status){

        switch($status){
            case '1':
                $title = "Active Bidding";
                $tip = "This post is still active and suppliers can submit their bidding proposals.";
                $statusStyle = 'feed-border green-text';
                break;
            case '2':
                $title = "Finished Bidding";
                $statusStyle = 'feed-border orange-text';
                $tip = "This bidding is finalized and can be safely deleted.";
                break;
            case '0':
                $title = "Expired Bidding";
                $tip = "An expired post. Suppliers are now waiting for you to choose a winner or finalize this post";
                $statusStyle = 'feed-border red-text';
                break;
        }
        $userBids = $this->getUserBids($user_id, $status);
        if(!empty($userBids)){
            ?>
                <div class="col s12 block">
                    <p><b><?= $title ?></b></p>
                </div>
            <?php
            foreach($userBids as $key=>$value){
                $bidInFeedLink = $userBids[$key]["cs_bidding_permalink"];
                $bidInFeedTitle = $userBids[$key]["cs_bidding_title"];
                $bidInFeedOfferCount = $userBids[$key]["cs_bidding_offer_count"];
                
                echo '<div class="col s12 block tooltipped"  data-position="bottom" data-tooltip="'.$tip.'">';
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
                    <a href="#!" data-selector="<?= $bidInFeedLink ?>" data-mode="bid" class="right data-delete z-depth-1 red white-text center-align">DELETE</a>
                    <a class="z-depth-1 right orange white-text center-align tooltipped" data-position="bottom" data-tooltip="total bids"><?= $bidInFeedOfferCount ?></a>
                </span>
            <?php
            echo '</div>';
            }
        }
    }
    
}

//EOF
