<?php

class viewOffers extends Offers {

    private $BASE_DIR;

    public function __construct($BASE_DIR) {
        $this->BASE_DIR = $BASE_DIR;
    }

    public function load($v){
        return $v;
    }

    public function viewMyOffers($userId, $biddingId) {
        $offers = $this->getBidOffers($userId, $biddingId);
        if(!empty($offers)) {
        ?>
        <div class="col s12">
            <table class="center-align">
                <thead>
                    <tr>
                        <th>Bidding Proposal</th>
                        <th>Supplier Rating</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
            <?php 
                    foreach($offers as $k=>$v) {
                        $offered = unserialize($offers[$k]['cs_offer']);
                        $price = $offers[$k]['cs_offer_price'];
                        $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($offers[$k]['cs_owner_rating']));
                        echo '<tr>';
                        echo '<td><b>₱</b>'.number_format($price, '2', '.', ',').'<br><label>'.$offered['qty'].' <span class="qty">{qty}</span></label></td>';
                        echo '<td><span class="ratings">'.$rating.'</span></td>';
                        echo '<td><a href="?open=true&token='.$biddingId.'" class="btn-small waves-effect green white-text">Open</a></td>';
                        echo '</tr>';
                    }
            ?>
                </tbody>
            </table>
        </div>
        <script>$(function(){$(".qty").text($('.item').data('unit'));})</script>
        <?php
    }
}
    public function viewLowestOffer($biddingId) {
        $offers = $this->getLowestBidOffer($biddingId);
        ?>
        <div class="col s12">
            <?php 
                if(!empty($offers)) {
                    echo '<p><b>Lowest Bid</b></p>';
                    foreach($offers as $k=>$v) {
                        $postedOn = $offers[$k]['cs_date_added'];
                        $price = $offers[$k]['cs_offer_price'];
                        $datePosted = '<time class="timeago" datetime="'.$postedOn.'">'.$postedOn.'</time>';
                        echo '<div class="bid-offer orange-text">';
                        echo '<p class="truncate"><b>₱</b> '.number_format($price, '2', '.', ',').'</p>';
                        echo '<label>'.$datePosted.'</label>';
                        echo '</div>';
                    }
                }
            ?>
            <br>
        </div>
        <?php
    }

    public  function viewOfferForm($biddingId, $isSupplier, $userId) {

        if($isSupplier) {
            ?>
            <div class="page white z-depth-1">
                <div id="submit-offer" class="content row scrollspy">
            
                    <form class="col s12 row" action="#!" data-action="<?= $this->BASE_DIR.'controller/controller.offer.php?action=add&bid='.$biddingId ?>" id="offer-form" method="POST">

                        <div class="fields orig">
                            <div class="input-field no-margin col s12 m5">
                                <p><label>Item Name</label></p>
                                <input 
                                    required
                                    type="text" 
                                    name="cs_offer_product" 
                                    class="custom-input validate"  
                                />
                            </div>
                            <div class="input-field no-margin col s12 m3">
                                <p><label>Qty in <b><span class="qty">{qty}</span></b></label></p>
                                <input 
                                    required 
                                    type="number" 
                                    name="cs_offer_qty" 
                                    class="custom-input validate" 
                                    min="0" 
                                    step="1" 
                                    oninput="validity.valid||(value='');" 
                                    pattern=" 0+\.[0-9]*[1-9][0-9]*$"  
                                />
                            </div>
                            
                            <div class="input-field no-margin col s12 m4">
                                <p><label>Offer Pricing</label></p>
                                <input 
                                    required 
                                    type="number" 
                                    name="cs_offer_price" 
                                    class="custom-input validate"  
                                    min="0.00" 
                                    max="10000.00" 
                                    step="0.01"
                                />
                            </div>
                        </div>

                        <div class="input-field no-margin col s12 m4">
                            <p><label>Date Available</label></p>
                            <input 
                                required 
                                type="text" 
                                name="cs_offer_date" 
                                class="custom-input datepicker validate"  
                            />
                        </div>

                        <div class="input-field no-margin col s12 m8">
                            <p><label>Notes</label></p>
                            <input 
                                required 
                                type="text" 
                                name="cs_offer_notes" 
                                class="custom-input validate"  
                            />
                        </div>
                            
                        <div class="col s12">
                            <p><?= $this->postOfferTitle($this->getCountOffer($biddingId)) ?></p>
                            <input type="submit" value="Submit offer" class="btn white-text" />
                        </div>

                    </form>
                    <div class="col s12 row">
                    
                        <?php $this->viewLowestOffer($biddingId); ?>
                        <div class="col s12" id="placeholder">
                            <p><?= $this->postOfferTitle($this->getCountOffer($biddingId)) ?></p>
                            <a class="waves-effect waves-light btn generate-form" href="#~">Submit Offer</a>
                        </div>
                    </div>

                </div>
            </div>
            
            <script src="<?= $this->BASE_DIR ?>static/js/services/services.addoffer.js" type="text/javascript"></script>

            <?php
        } else {
            ?>
            <div class="page white z-depth-1">
                <div id="submit-offer" class="content row scrollspy">
                    
                    <?php $this->viewLowestOffer($biddingId); ?>
                    <?php $this->viewMyOffers($userId, $biddingId); ?>
                    <div class="col s12">
                        <p>You need to login on a supplier account inorder to participate in biddings.</p>
                        <a href="#!" class="btn waves-effect orange white-text">Learn how</a>
                    </div>
                </div>
            </div>
            <?php
        }
    }



    protected function postOfferTitle($count){
        switch($count) {
            case '0':
                return 'Be the first one to offer in this thread.';
            default:
                return 'Join '.$count.' other supplier and submit your offer.';
        }
    }
    
    public function viewUserOfferStatus($user_id){ 

        $counts = $this->getDashboardCounts($user_id);

        ?>
            <div class="col s12 m4">
                <div class="dashboard-panel green lighten-0 white-text z-depth-1">
                    <h1><b><?= $counts[0] ?></b></h1>
                    <p>Active Offers</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="dashboard-panel red lighten-0 white-text z-depth-1">
                    <h1><b><?= $counts[2] ?></b></h1>
                    <p>Rejected Offers</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="dashboard-panel orange lighten-0 white-text z-depth-1">
                    <h1><b><?= $counts[1] ?></b></h1>
                    <p>Accepted Offers</p>
                </div>
            </div>

        <?php
    }

    public function viewUserOffers($userId){
        
        $userOffers = $this->getUserOffers($userId);
        
        if(!empty($userOffers)){
            foreach($userOffers as $key=>$value){
                
                $title = $userOffers[$key]["cs_bidding_title"];
                $link = $userOffers[$key]["cs_bidding_permalink"];
                $offerId = $userOffers[$key]["cs_offer_id"];
                $datePosted = date_format(date_create($userOffers[$key]["cs_date_added"]), 'D d M Y');
                
                $datePosted = '<time>'.$datePosted.'</time>'; 
                switch($userOffers[$key]["cs_offer_status"]){
                    case '0':
                        $statusStyle = 'feed-border green-text text-lighten-0';
                        break;
                    case '1':
                        $statusStyle = 'feed-border orange-text text-lighten-2';
                        break;
                    case '2':
                        $statusStyle = 'feed-border red-text text-lighten-2';
                        break;
                }
            ?>
                
            <div class="col s12 block">
                <a href="<?= $this->BASE_DIR.'bid/'.$link.'/' ?>">
                    <div class="feed-card feed-card-full white z-depth-1 <?= $statusStyle ?>">
                        <div class="feed-card white z-depth-1">
                            <div class="feed-head">
                                <div class="feed-user-avatar">
                                </div>
                                <p class="grey-text text-darken-3">
                                    <?= $title ?><br>
                                    <span class="grey-text lighten-2">
                                    <?= 'Posted @ '.$datePosted ?><br>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
                
                <span class="card-counter">
                    <a href="#!" data-selector="<?= $offerId ?>" data-mode="offer" class="data-delete z-depth-1 red white-text center-align">delete</a>
                    <a class="z-depth-1 green white-text center-align">edit</a>
                </span>

            </div>
            <?php
            }
        }
    }

}