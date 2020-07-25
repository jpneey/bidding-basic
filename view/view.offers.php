<?php

class viewOffers extends Offers {

    private $BASE_DIR;

    public function __construct($BASE_DIR) {
        $this->BASE_DIR = $BASE_DIR;
    }
    
    public function viewOffers($biddingId) {
        ?>
        hi
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

}