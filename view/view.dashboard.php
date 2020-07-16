<?php

defined('included') || die("Bad request");

$dashboardAction = Sanitizer::filter('action', 'get');

if($isBidder)

    switch($dashboardAction){
        case 'add':
            require 'dashboard.add.php';
            break;

        default:
    ?>
    <p><b>My Posts</b></p>
    <?php
    $userBids = $user->getUserBids($__user_id);
    if(!empty($userBids)){
        foreach($userBids as $key=>$value){
            $bidInFeedId = $userBids[$key]["cs_bidding_id"];
            $bidInFeedTitle = $userBids[$key]["cs_bidding_title"];
            switch($userBids[$key]["cs_bidding_status"]){
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
            $datePosted = '<time>'.date_format(date_create($userBids[$key]["cs_bidding_added"]), 'D d M Y').'</time>'; ?>
            <a href="<?php echo $BASE_DIR.'bid/'.$bidInFeedId ?>" class="hoverable">
                <div class="col s12 feed-card white z-depth-1">
                    <div class="feed-head">
                        <div class="feed-user-avatar <?php echo $statusStyle ?>">
                            
                        </div>
                        <p class="grey-text text-darken-3">
                            <?php echo $bidInFeedTitle ?><br>
                            <span class="grey-text lighten-2">
                            <?php echo 'Posted @ '.$datePosted ?><br>
                            </span>
                        </p>
                    </div>
                </div>
            </a>
            <?php
            }
        }
    }