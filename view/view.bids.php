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

    public function ViewFeed(){

        $bidsInFeed = $this->getBiddings();

        if(!empty($bidsInFeed)){

            foreach($bidsInFeed as $key=>$value){
                $bidInFeedTitle = $bidsInFeed[$key]["cs_bidding_title"];
                $bidInFeedLink = $bidsInFeed[$key]["cs_bidding_permalink"];
                $datePosted = $bidsInFeed[$key]["cs_bidding_added"];
                $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($bidsInFeed[0]['cs_owner_rating']));
                $province = !empty($bidsInFeed[0]['cs_owner_location']) ? $bidsInFeed[0]['cs_owner_location'] : 'Philippines';
                $datePosted = '<time class="timeago" datetime="'.$bidsInFeed[$key]["cs_bidding_added"].'">'.$bidsInFeed[$key]["cs_bidding_added"].'</time>';
                $bidInFeedPicture = '';
                if($bidsInFeed[$key]["cs_bidding_picture"] !== '#!'){
                    $bidInFeedPicture = '
                    <div class="feed-image-wrapper">
                        <img src="'.$this->BASE_DIR.'static/asset/bidding/'.$bidsInFeed[$key]["cs_bidding_picture"].'" class="materialboxed" />
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
                        <div class="feed-user-avatar green lighten-2 <?= $statusStyle ?>"></div>
                        <p class="grey-text text-darken-3">
                            <?= $bidInFeedTitle ?><br>
                            <span class="grey-text lighten-2">
                            <?= $province.' @ '.$datePosted ?><br>
                            </span>
                        </p>
                    </div>
                    <?= $bidInFeedPicture ?>
                    <div class="content">
                        <a href="<?= $this->BASE_DIR.'bid/'.$bidInFeedLink ?>" class="waves-effect waves-light btn-flat normal-text">Read More <i class="material-icons right">launch</i></a>
                        <span class="ratings"><?= $rating ?></span>
                    
                    </div>
                </div>
                <?php
            }
        }
    }

    public function viewBid($selector) {

        $viewBid = $this->getBid($selector);
        if(!empty($viewBid)) {
            $title = $viewBid[0]['cs_bidding_title'];
            $details = $viewBid[0]['cs_bidding_details'];
            $item = $viewBid[0]['cs_bidding_product'];
            $budget = $viewBid[0]['cs_bidding_product_price'];
            $qty = $viewBid[0]['cs_bidding_product_qty'] . ' ' . $viewBid[0]['cs_bidding_product_unit'];
            $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($viewBid[0]['cs_owner_rating']));
            $picture = 
                ($viewBid[0]['cs_bidding_picture'] != '#!') ? 
                '<img id="bidding-details" src="'.$this->BASE_DIR.'static/asset/bidding/'.$viewBid[0]['cs_bidding_picture'].'" class="margin-auto materialboxed scrollspy" />' :
                '';
            ?>
            <div class="page white z-depth-1">
                <div id="introduction" class="content scrollspy">
                    <label>Home > bid > <?= $title ?></label>
                    <h1><?= $title ?><span class="ratings"><?= $rating ?></span></h1>
                    <div class="glance grey lighten-4">
                        <table class="responsive-table center-align">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $item ?></td>
                                    <td><?= $qty ?></td>
                                    <td><?= $budget ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?= $picture ?>
                <div class="content">
                    <p><?= $details ?></p>
                </div>
            </div>

            <?php
        }
    }
    
}

//EOF
