<?php

defined('included') || die("Bad request");

class viewBids extends Bids {

    private $BASE_DIR;

    public function __construct($BASE_DIR, $conn = null) {
        $this->BASE_DIR = $BASE_DIR;
        if($conn){
            parent::__construct($conn);
        }
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
                $catName = $bidsInFeed[$key]["cs_category_name"];
                $datePosted = '<time class="timeago" datetime="'.$bidsInFeed[$key]["cs_bidding_added"].'">'.$bidsInFeed[$key]["cs_bidding_added"].'</time>';
                $bidInFeedPicture = '';
                $rated = $bidsInFeed[$key]["cs_rated"];

                $bidInFeedPicture = ($bidsInFeed[$key]["cs_bidding_picture"] == '#!') ?
                    '<img class="lazy" src="'.$this->BASE_DIR.'static/asset/media/default.jpg" data-src="'.$this->BASE_DIR.'static/asset/media/default.jpg" alt="'.$bidInFeedTitle.'"/>' :
                    '<img class="lazy" src="'.$this->BASE_DIR.'static/asset/media/default.jpg" data-src="'.$this->BASE_DIR.'static/asset/bidding/'.$bidsInFeed[$key]["cs_bidding_picture"].'" alt="'.$bidInFeedTitle.'"/>' ;
                $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($bidsInFeed[$key]['cs_owner_rating']));
                if(empty($rated)){
                    $rating = str_repeat('<i class="material-icons orange-text">star</i>', 3);    
                }
                
                ?> 
                <a href="<?= $this->BASE_DIR . 'bid/' . $bidInFeedLink ?>" class="grey-text text-darken-3">               
                <div class="card feed categ-filter loc-filter z-depth-0"
                data-category="<?= $catName ?>"
                data-location="<?= $province ?>"
                >   <div class="hoverable">
                        <div class="card-image">
                            <?= $bidInFeedPicture ?>
                            <!-- <div class="overlay"></div> -->
                            <span class="card-title truncate">
                                <button class="btn btn-xs card-tag-v"><?= $catName ?></button>
                                <button class="btn btn-xs card-tag-v"><?= $province ?></button>
                            </span>
                        </div>
                        <div class="card-content">
                            <span class="truncate"><?= $bidInFeedTitle ?></span>
                            <p class="truncate un-margin"><?= $datePosted .' - ' . $bidInFeedDetails ?></p>
                            <span class="ratings un-pad star-on-feed"><?= $rating ?></span>
                            <p>
                                <small>
                                <?php if(!empty($rated)) { ?>
                                <?= number_format($bidsInFeed[$key]['cs_owner_rating'], 1, '.', ',') ?> out of <?= $rated ?> review(s)
                                <?php } else { echo "No reviews yet"; } ?>
                                </small>
                            </p>
                        </div>
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
                    $button = "View Featured Items";
                    break;
            }
            ?>
            
            <div class="card feed z-depth-0">
                <div class="card-content">
                    <p><b>There's nothing here.</b></p>
                    <br>
                    <p><?= $emptyMessage ?></p>
                    <br>
                    <p class="sub-title grey-text"><a href="<?= $this->BASE_DIR.$buttonLink ?>" class="btn orange white-text"><?= $button ?></a></p>
                </div>
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
                    <div class="product-card item no-p-m" data-budget="₱ <?= $budget ?>" data-item="<?= $item ?>" data-qty="<?= $viewBid[0]['cs_product_qty'] ?>" data-unit="<?= $viewBid[0]['cs_product_unit'] ?>"></div>
                    
                    <p><b>Bidding Details</b><br><?= nl2br($details); ?></p>
                    <p>
                        <b>Categories</b><br>
                        <span>Click category below to see more related items.</span>
                        <span><br><br><?= $tagchip ?></span>
                    </p>
                    <div class="row">
                        <p class="col s12">
                            <b>Bidding Expiration</b><br>
                            <?= date_format(date_create($dateNeeded), 'g:ia jS F Y') ?>
                        </p>
                        <p class="col s12">
                            <b>Location</b><br>
                            <?= $location ?>
                        </p>
                    </div>
                    <?php if($status == 1) { ?>

                    <div class="this-timer dashed white" id="timer-wrapper">
                        <div class="time">
                            <span id="days">00</span>
                            <label>Days</label>
                        </div>
                        <div class="time">
                            <span id="hours">00</span>
                            <label>hours</label>
                        </div>
                        <div class="time">
                            <span id="minutes">00</span>
                            <label>minutes</label>
                        </div>
                        <div class="time">
                            <span id="seconds">00</span>
                            <label>seconds</label>
                        </div>
                    </div>

                    <?php } else { ?>
                        <?= $this->getBidWinner($viewBid[0]['cs_bidding_id']); ?>
                    <?php } ?>
                    <br>
                    <p><b>Item / Service Needed</b></p>
                    <div class="this-timer white sm">
                        <div class="time">
                            <img id="bidding-details" src="<?= $this->BASE_DIR ?>static/asset/bidding/<?= $picture ?>" class="margin-auto image-pop" />
                        </div>
                        <div class="time w-50">
                            <span class="truncate"><?= $item ?></span>
                            <label>₱ <?= $budget ?> / <?= $qty ?></label>
                        </div>
                    </div>
                    
                </div>
            </div>

            <link href="<?= $this->BASE_DIR ?>static/css/timer.css" type="text/css" rel="stylesheet"/>
            <link href="<?= $this->BASE_DIR ?>static/css/bid.css?v=1" type="text/css" rel="stylesheet"/>
            <?php if($status) { ?>
            <script> $(function(){ timer('<?= $dateNeeded ?>') }) </script>
            <?php
            }
        } else { ?>
            <script>
                window.location.href = root + "my/dashboard/";
            </script>
            <?php
        }
    }

    public function getBidWinner($biddingId){ 
        $winner = $this->hasWinner($biddingId);
        ?>
        <p><b>Bidding Ended</b></p>
        <?php
        if(!$winner) {
        ?> 
        <div class="this-timer white sm">
            <div class="time">
                <i class="material-icons grey-text text-lighten-2">help_outline</i>
            </div>
            <div class="time w-50">
                <span>Bidding Ended</span>
                <label>The client is still choosing for a winner</label>
            </div>
        </div>

        <?php } else {   
        $product = unserialize($winner[1]);
        ?>
        <!-- 
        <a href="<?= $this->BASE_DIR ?>user/<?= $winner[2][0] ?>/" class="waves-effect waves-light btn orange darken-3">@<?= $winner[2][0] ?> won</a><br>
         -->
        <div class="this-timer white sm">
            <div class="time">
                <img id="bidding-details" src="<?= $this->BASE_DIR ?>static/asset/user/<?= $winner[2][1] ?>" class="margin-auto image-pop" />
            </div>
            <div class="time w-50">
                <span>@<?= $winner[2][0] ?></span>
                <label>Bidding Winner</label>
            </div>
        </div>

        <?php
        }
    }

    public function viewUserBidStatus($user_id){ 

        $counts = $this->getDashboardCounts($user_id);

        ?>
            <div class="col s12 m4">
                <a href="#active-biddings">
                    <div class="dashboard-panel green lighten-0 white-text z-depth-0">
                        <h1><b><?= $counts[0] ?></b></h1>
                        <p>Active Bidding</p>
                    </div>
                </a>
            </div>
            
            <div class="col s12 m4">
                <a href="#finished-biddings">
                    <div class="dashboard-panel orange lighten-0 white-text z-depth-0">
                        <h1><b><?= $counts[1] ?></b></h1>
                        <p>Finished Bidding</p>
                    </div>
                </a>
            </div>

            <div class="col s12 m4">
                <a href="#expired-biddings">
                    <div class="dashboard-panel red lighten-0 white-text z-depth-0">
                        <h1><b><?= $counts[2] ?></b></h1>
                        <p>Expired Bidding</p>
                    </div>
                </a>
            </div>

        <?php
    }

    public function viewUserBids($user_id, $status){

        switch($status){
            case '1':
                $title = "Active Bidding";
                $tip = "Active Biddings means that the post is yet to expire and still accepting bid proposals from our suppliers.";
                $statusStyle = 'feed-border green-text';
                $ref = 'active-biddings';
                break;
            case '2':
                $title = "Finished Biddings";
                $statusStyle = 'feed-border orange-text';
                $ref = 'finished-biddings';
                $tip = "This bidding is finalized and can now be safely deleted.";
                break;
            case '0':
                $title = "Expired Biddings";
                $tip = "This bidding has expired and will not receive future proposals anymore. Suppliers are now waiting for you to choose a winner or finalize this post";
                $statusStyle = 'feed-border red-text';
                $ref = 'expired-biddings';
                break;
        }
        $userBids = $this->getUserBids($user_id, $status);
        if(!empty($userBids)){
            ?>
                <div class="col s12 block" id="<?= $ref ?>">
                    <p><b><?= $title ?></b><br><span class="grey-text" style="font-size: 12px;"><?= $tip ?></span></p>
                </div>
                <div class="col s12  block row no-margin <?= 'p-'.$ref ?>" style="padding: 0;">

            <?php
            $iteration = 0;
            foreach($userBids as $key=>$value){
                $bidInFeedLink = $userBids[$key]["cs_bidding_permalink"];
                $bidInFeedTitle = $userBids[$key]["cs_bidding_title"];
                $bidInFeedOfferCount = $userBids[$key]["cs_bidding_offer_count"];
                $style = ($iteration > 2) ? "style='display: none'" : "";
                $toLoad = ($iteration > 2) ? "toLoad" : "";
                echo "<div class=\"col s12 block $toLoad\" $style>";
                $datePosted = '<time>'.date_format(date_create($userBids[$key]["cs_bidding_added"]), 'D d M Y').'</time>'; ?>
 
                <a href="<?= $this->BASE_DIR.'bid/'.$bidInFeedLink ?>">
                    <div class="feed-card feed-card-full white <?= $statusStyle ?> hoverable">
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
                    <a href="#!" data-selector="<?= $bidInFeedLink ?>" data-mode="bid"  data-message="This action is permanent. Proceed to delete this post?" class="right data-delete z-depth-0 red white-text center-align">DELETE</a>
                    <a class="z-depth-0 right orange white-text center-align tooltipped" data-position="bottom" data-tooltip="total bids"><?= $bidInFeedOfferCount ?></a>
                </span>
            <?php
            $iteration++;
            echo '</div>';
            }
            echo '</div>';
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
