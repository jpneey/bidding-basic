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

    public function ViewFeed($filter = array(), $emptyMessage = "Active Biddings will go here but unfortunately there are no active biddings as of the moment. How about viewing our suppliers ?", $loggedInUserRole = 0){
        $bidsInFeed = $this->getBiddings($filter);
        ?>
        <script type="text/javascript" src="<?= $this->BASE_DIR ?>static/js/lazy.js"></script>
        <script type="text/javascript" src="<?= $this->BASE_DIR ?>static/js/lazy-init.js"></script>
        <?php
        if(!empty($bidsInFeed)){
    
            foreach($bidsInFeed as $key=>$value){
                $bidInFeedTitle = $bidsInFeed[$key]["cs_bidding_title"];
                $bidInFeedDetails = $bidsInFeed[$key]["cs_bidding_details"];
                $bidInFeedLink = $bidsInFeed[$key]["cs_bidding_permalink"];
                $datePosted = $bidsInFeed[$key]["cs_bidding_added"];
                $province = $bidsInFeed[$key]["cs_bidding_location"];
                $datePosted = '<time class="timeago" datetime="'.$bidsInFeed[$key]["cs_bidding_added"].'">'.$bidsInFeed[$key]["cs_bidding_added"].'</time>';
                $bidInFeedPicture = '';
                $rated = $bidsInFeed[$key]["cs_rated"];
                if($bidsInFeed[$key]["cs_bidding_picture"] !== '#!'){
                    $bidInFeedPicture = '
                    <div class="feed-image-wrapper">
                        <img class="lazy" data-src="'.$this->BASE_DIR.'static/asset/bidding/'.$bidsInFeed[$key]["cs_bidding_picture"].'" alt="'.$bidInFeedTitle.'"/>
                    </div>
                    ';
                }
                $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($bidsInFeed[$key]['cs_owner_rating']));
                if(empty($rated)){
                    $rating = str_repeat('<i class="material-icons orange-text">star</i>', 3);    
                }
                
                ?>
                <a href="<?= $this->BASE_DIR.'bid/'.$bidInFeedLink ?>">
                    <div class="post-card white z-depth-0 waves-effect">    
                        <div class="title grey-text text-darken-3"><b class="truncate"><?= $bidInFeedTitle ?></b></div>
                        <div class="sub-title grey-text"><?= $province.' @ '.$datePosted ?></div>
                        <div class="preview grey-text text-darken-3"><span class="truncate"><?= $bidInFeedDetails ?></span></div>
                        
                        <div class="sub-title grey-text">
                        <?php if(!empty($rated)) { ?>
                        <?= number_format($bidsInFeed[$key]['cs_owner_rating'], 1, '.', ',') ?> out of <?= $rated ?> review(s)
                        <?php } ?>
                        </div>
                        <div class="ratings"><?= $rating ?></div>
                        <div class="image-wrapper">
                            <?= $bidInFeedPicture ?>
                        </div>
                    </div>
                </a>
                <?php
            }
        } else {
            switch($loggedInUserRole) { 
                
                case(2):
                    $emptyMessage = "Active Biddings will go here but unfortunately there are no active biddings as of the moment. How about updating your Canvasspoint business profile ?";
                    $buttonLink = "my/business/";
                    $button = "My Business";
                    break;

                default:
                    $buttonLink = "supplier/";
                    $button = "View Suppliers";
                    break;
            }
            ?>
            
            <div class="post-card white z-depth- waves-effect">    
                <div class="title"><b>There's nothing here.</b></div>
                <div class="sub-title grey-text"><?= $emptyMessage ?></div>
                <p class="sub-title grey-text"><a href="<?= $this->BASE_DIR.$buttonLink ?>" class="btn orange white-text"><?= $button ?></a></p>
                <div class="image-wrapper"></div>
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
            /* $tags = preg_split('@,@', $viewBid[0]['cs_bidding_tags'], NULL, PREG_SPLIT_NO_EMPTY); */
            $tagchip = '<a href="'.$this->BASE_DIR.'search/?queue='.$viewBid[0]["cs_category_name"].'"><span class="chip grey lighten-1 white-text">'.$viewBid[0]["cs_category_name"].'</span></a>';
            $tagchip .= '<a href="'.$this->BASE_DIR.'search/?queue='.$location.'"><span class="chip grey lighten-3">'.$location.'</span></a>';
            $item = $viewBid[0]['cs_product_name'];
            $budget = number_format($viewBid[0]['cs_product_price'], '2', '.', ',');
            $qty = $viewBid[0]['cs_product_qty'] . ' ' . $viewBid[0]['cs_product_unit'];
            /* foreach($tags as $tag) {
                $tagchip .= '<span class="chip grey lighten-3">'.$tag.'</span>';
            } */
            $rated = $viewBid[0]["cs_rated"];
            $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($viewBid[0]['cs_owner_rating']));
            $picture = ($viewBid[0]['cs_bidding_picture'] != '#!') ? $viewBid[0]['cs_bidding_picture'] : 'placeholder.svg';

            if(empty($rated)) { 
                $rating = str_repeat('<i class="material-icons orange-text">star</i>', 3);
            }
                
            ?>
            
            <div class="page white z-depth-0">
                <div id="introduction" class="content scrollspy">
                    <label><a href="<?= $this->BASE_DIR ?>" class="grey-text">Home</a> > bid > <?= $title ?></label>
                    <br>
                    <br>
                    <h1 class="no-margin">
                        <b><?= $title ?></b>
                    </h1>
                    <br>
                    <p class="no-margin"><b>Client's Rating</b></p>    
                    <span class="ratings no-padding"><?= $rating ?></span>
                    <?php if(!empty($rated)){ ?>
                    <p class="no-margin"><?=  number_format($viewBid[0]['cs_owner_rating'], 1,'.',',') . ' out of ' . $rated ?> review(s)</p>
                    <?php } ?>
                    <br>
                    <br>
                    <div class="divider" ></div>
                    <br>
                    <br>
                    
                    <p><b>Details</b><br><?= nl2br($details); ?></p>

                    <?php if($status == 1) { ?>
                    <p id="timer-wrapper">
                        <b>Bidding ends in</b><br>
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
                        <b>Date Needed</b><br>
                        <?= date_format(date_create($dateNeeded), 'g:ia \o\n l jS F Y') ?>
                    </p>
                    <p>
                        <b>Location</b><br>
                        <?= $location ?>
                    </p>
                    <br>
                    <div class="glance white">
                        <div class="product-card item" data-budget="₱ <?= $budget ?>" data-item="<?= $item ?>" data-qty="<?= $viewBid[0]['cs_product_qty'] ?>" data-unit="<?= $viewBid[0]['cs_product_unit'] ?>">
                            <div class="thumbnail">
                                <img id="bidding-details" src="<?= $this->BASE_DIR ?>static/asset/bidding/<?= $picture ?>" class="margin-auto materialboxed" />
                            </div>
                            <div class="content">
                                <p><b><?= $item ?></b></p>
                                <p><?= $qty ?></p>
                                <p class="grey-text"></p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <p>
                        <b>Budget</b><br>
                        ₱ <?= $budget ?>
                    </p>
                    
                    <p>
                        <b>Category</b><br>
                        <span>(Click category below to see more related items)</span>
                    </p>
                    <span><br><?= $tagchip ?></span>
                    
                </div>
            </div>

            <link href="<?= $this->BASE_DIR ?>static/css/timer.css" type="text/css" rel="stylesheet"/>
            <link href="<?= $this->BASE_DIR ?>static/css/bid.css?v=1" type="text/css" rel="stylesheet"/>
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
        * Client is still choosing for a winner.
        <?php } else {   
        $product = unserialize($winner[1]);
        ?>
        <a href="<?= $this->BASE_DIR ?>user/<?= $winner[2][0] ?>/" class="waves-effect waves-light btn orange darken-3">@<?= $winner[2][0] ?> won</a><br>
        <div class="white">
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
                <div class="dashboard-panel green lighten-0 white-text z-depth-0">
                    <h1><b><?= $counts[0] ?></b></h1>
                    <p>Active Bidding</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="dashboard-panel red lighten-0 white-text z-depth-0">
                    <h1><b><?= $counts[2] ?></b></h1>
                    <p>Expired Bidding</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="dashboard-panel orange lighten-0 white-text z-depth-0">
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
                $tip = "Active Biddings means that the post is yet to expire and still accepting bid proposals from our suppliers.";
                $statusStyle = 'feed-border green-text';
                break;
            case '2':
                $title = "Finished Bidding";
                $statusStyle = 'feed-border orange-text';
                $tip = "This bidding is finalized and can now be safely deleted.";
                break;
            case '0':
                $title = "Expired Bidding";
                $tip = "This bidding has expired and will not receive future proposals anymore. Suppliers are now waiting for you to choose a winner or finalize this post";
                $statusStyle = 'feed-border red-text';
                break;
        }
        $userBids = $this->getUserBids($user_id, $status);
        if(!empty($userBids)){
            ?>
                <div class="col s12 block">
                    <p><b><?= $title ?></b><br><span class="grey-text" style="font-size: 12px;"><?= $tip ?></span></p>
                </div>
            <?php
            foreach($userBids as $key=>$value){
                $bidInFeedLink = $userBids[$key]["cs_bidding_permalink"];
                $bidInFeedTitle = $userBids[$key]["cs_bidding_title"];
                $bidInFeedOfferCount = $userBids[$key]["cs_bidding_offer_count"];
                
                echo '<div class="col s12 block">';
                $datePosted = '<time>'.date_format(date_create($userBids[$key]["cs_bidding_added"]), 'D d M Y').'</time>'; ?>
 
                <a href="<?= $this->BASE_DIR.'bid/'.$bidInFeedLink ?>">
                    <div class="feed-card feed-card-full white z-depth-0 <?= $statusStyle ?>">
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
                    <a href="#!" data-selector="<?= $bidInFeedLink ?>" data-mode="bid" class="right data-delete z-depth-0 red white-text center-align">DELETE</a>
                    <a class="z-depth-0 right orange white-text center-align tooltipped" data-position="bottom" data-tooltip="total bids"><?= $bidInFeedOfferCount ?></a>
                </span>
            <?php
            echo '</div>';
            }
        }
    }

    public function viewSideBar($loggedInUserRole) { 
        ?>
        
        <div class="post-card white z-depth-0 waves-effect">    
            <div class="title grey-text text-darken-3"><b>What's New?</b></div>
            <div class="sub-title grey-text">Lorem Ipsum dotor sit amte, connectiture de` elipsis.</div>
            <div class="sub-title">
                <p><a href="<?= $this->BASE_DIR ?>blogs/" class="btn btn-small orange white-text z-depth-0">Blog <i class="material-icons right">trending_up</i></a></p>
            </div>
            
            <div class="image-wrapper"></div>
        </div>
        <?php
    }
    
}

//EOF
