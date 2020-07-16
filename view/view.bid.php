<?php

defined('included') || die("Bad request");

$thisViewBidId = (int)$uri[1];

$bidsInFeed = $bid->getBid($thisViewBidId);

if(!empty($bidsInFeed)){

    foreach($bidsInFeed as $key=>$value){
        $bidInFeedTitle = $bidsInFeed[$key]["cs_bidding_title"];
        $bidInFeedId = $bidsInFeed[$key]["cs_bidding_id"];
        
        $bidInFeedProduct = $bidsInFeed[$key]["cs_bidding_product"];
        $bidInFeedQty = $bidsInFeed[$key]["cs_bidding_product_qty"] . ' ' . $bidsInFeed[$key]["cs_bidding_product_unit"];
        
        $datePosted = $bidsInFeed[$key]["cs_bidding_added"];
        
        $datePosted = '<time class="timeago" datetime="'.$bidsInFeed[$key]["cs_bidding_added"].'">'.$bidsInFeed[$key]["cs_bidding_added"].'</time>';
        $bidInFeedPicture = '';
        if($bidsInFeed[$key]["cs_bidding_picture"] !== '#!'){
            $bidInFeedPicture = '
            <div class="feed-image-wrapper">
                <img src="'.$BASE_DIR.'static/asset/bidding/'.$bidsInFeed[$key]["cs_bidding_picture"].'" class="materialboxed" />
            </div>
            ';
        }
        ?>
        <div class="feed-card white z-depth-1">
            <div class="feed-head">
                <p class="grey-text text-darken-3">
                    <?php echo $bidInFeedTitle ?><br>
                    <span class="grey-text lighten-2">
                    <?php echo 'Posted @ '.$datePosted ?><br>
                    </span>
                </p>
            </div>
            <?php echo $bidInFeedPicture ?>
            <div class="content row">
                <div class="col s12 m5">
                    <p><b>Item needed:</b><br><?php echo $bidInFeedProduct ?></p>
                </div>
                <div class="col s12 m6">
                    <p><b>Quantity:</b><br><?php echo $bidInFeedQty ?></p>
                </div>
                <div class="col s12">
                    <p class="no-margin">Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus earum eaque, adipisci consequuntur reiciendis commodi magnam ipsa mollitia atque quidem vel voluptas dicta eius delectus. Nesciunt temporibus praesentium beatae ea.</p>
                    <p><b>Tags:</b></p>
                    
                    <div class="chip z-depth-2 white">
                    The New Lorem
                    <i class="close material-icons">close</i>
                    </div>
                    <br>
                    <br>
                </div>            
            </div>
        </div>

        

        <?php
    }

}