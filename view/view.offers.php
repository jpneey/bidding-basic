<?php

class viewOffers extends Offers {

    private $BASE_DIR;

    public function __construct($BASE_DIR) {
        $this->BASE_DIR = $BASE_DIR;
    }
    
    public function load($v){
        return $v;
    }

    public  function viewOfferForm($biddingId, $isSupplier = false) {

        if($isSupplier) {
            ?>
            <div class="page white z-depth-1">
                <div id="submit-offer" class="content row scrollspy">
                    <div class="col s12">
                        <p><?= $this->postOfferTitle($this->getCountOffer($biddingId)) ?></p>
                        <a class="waves-effect waves-light btn modal-trigger" href="#offerModal">Submit Offer</a>
                    </div>
                    

                    <div id="offerModal" class="modal">
                        <div class="modal-content">
                            <div class="row">
                                <div class="col s12">
                                    <h1><b>Submit Offer</b></h1>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
                        </div>
                    </div>

                </div>
            </div>
            
            <script src="<?= $this->BASE_DIR ?>static/js/services/services.addoffer.js" type="text/javascript"></script>

            <?php
        } else {
            ?>
            <div class="page white z-depth-1">
                <div id="submit-offer" class="content scrollspy">
                    <p>You need to login on a supplier account inorder to participate in biddings.</p>
                    <a href="#!" class="btn waves-effect orange white-text">Learn how</a>
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