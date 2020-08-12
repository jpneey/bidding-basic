<?php

defined('included') || die("Bad request");

class viewFeedBids extends Bids {

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
                    <div class="post-card white z-depth-1 waves-effect">    
                            <div class="title grey-text text-darken-3"><b class="truncate"><?= $bidInFeedTitle ?></b></div>
                            <div class="sub-title grey-text"><?= $province.' @ '.$datePosted ?></div>
                            <div class="preview grey-text text-darken-3"><span class="truncate"><?= $bidInFeedDetails ?></span></div>
                            <span class="ratings"><?= $rating ?></span>
                        
                        <div class="image-wrapper">
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
    
}

//EOF
