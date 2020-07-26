<?php

class viewOffers extends Offers {

    private $BASE_DIR;

    public function __construct($BASE_DIR) {
        $this->BASE_DIR = $BASE_DIR;
    }
    
    public function viewOffers($biddingId) {
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
    public function load($v){
        return $v;
    }

    public  function viewOfferForm($biddingId, $isSupplier = false) {

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
                    
                        <?php $this->viewOffers($biddingId); ?>
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
                    
                    <?php $this->viewOffers($biddingId); ?>
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
    


    public function viewUserOffers($user_id){
        
        $userOffers = $this->getUserOffers($user_id);
        
        if(!empty($userOffers)){
            foreach($userOffers as $key=>$value){
                
                $title = $userOffers[$key]["cs_bidding_title"];
                $datePosted = date_format(date_create($userOffers[$key]["cs_date_added"]), 'D d M Y');
                
                $datePosted = '<time>'.$datePosted.'</time>'; ?>
                <a href="<?= $this->BASE_DIR.'bid/' ?>">
                    <div class="col s12 feed-card white z-depth-1">
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
                </a>
            <?php
            }
        }
        else {
            $BASE_DIR = $this->BASE_DIR;
            require 'component/empty.php';
        }
    }

}