<?php

defined('included') || die("Bad request");

$bidsInFeed = $dbhandle->runQuery("SELECT * FROM cs_biddings WHERE cs_bidding_status in('1', '2') ORDER BY cs_bidding_added DESC");

if(!empty($bidsInFeed)){

    foreach($bidsInFeed as $key=>$value){
        $bidInFeedTitle = $bidsInFeed[$key]["cs_bidding_title"];
        $bidInFeedId = $bidsInFeed[$key]["cs_bidding_id"];
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
        switch($bidsInFeed[$key]["cs_bidding_status"]){
            case '1':
                $statusStyle = 'green lighten-1';
                break;
            case '2':
                $statusStyle = 'orange lighten-2';
                break;
            case '0':
                $statusStyle = 'red lighten-2';
                break;
        }
        ?>
        <div class="feed-card white z-depth-1">
            <div class="feed-head">
                <div class="feed-user-avatar green lighten-2 <?php echo $statusStyle ?>"></div>
                <p class="grey-text text-darken-3">
                    <?php echo $bidInFeedTitle ?><br>
                    <span class="grey-text lighten-2">
                    <?php echo 'Posted @ '.$datePosted ?><br>
                    </span>
                </p>
            </div>
            <?php echo $bidInFeedPicture ?>
            <div class="content">
                <a href="<?php echo $BASE_DIR.'bid/'.$bidInFeedId ?>" class="waves-effect waves-light btn-flat normal-text">Read More <i class="material-icons right">launch</i></a>
            </div>
        </div>

        

        <?php
    }

}