<?php

$bidsInFeed = $dbhandle->runQuery("SELECT * FROM cs_biddings WHERE cs_bidding_status in('1', '2') ORDER BY cs_bidding_added DESC");

if(!empty($bidsInFeed)){

    foreach($bidsInFeed as $key=>$value){

        $bidInFeedTitle = $bidsInFeed[$key]["cs_bidding_title"];
        $bidInFeedAuthor = $user->getUserName($bidsInFeed[$key]["cs_bidding_user_id"]);
        $datePosted = Render::dateFormat($bidsInFeed[$key]["cs_bidding_added"]);
        $bidInFeedAuthorAvatar = 'avatar.png';
        $datePosted = '<time class="timeago" datetime="'.$bidsInFeed[$key]["cs_bidding_added"].'">'.$bidsInFeed[$key]["cs_bidding_added"].'</time>';
        $bidInFeedPicture = '';
        $bidInFeedDetails = $bidsInFeed[$key]["cs_bidding_details"];
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
                <div class="feed-user-avatar">
                    <img src="<?php echo $BASE_DIR.'static/asset/user/'.$bidInFeedAuthorAvatar; ?>" alt="<?php echo $bidInFeedAuthor.'\'s'; ?> avatar" />
                </div>
                <p class="grey-text text-darken-3">
                    <?php echo $bidInFeedTitle ?><br>
                    <span class="grey-text lighten-2">
                    <?php echo '<a href="'.$BASE_DIR.'user/'.$bidInFeedAuthor.'">@'.$bidInFeedAuthor.'</a>  '.$datePosted ?><br>
                    </span>
                </p>
            </div>
            <div class="content">
                <?php echo $bidInFeedDetails ?>
            </div>
            <?php echo $bidInFeedPicture ?>
        </div>

        

        <?php
    }

}