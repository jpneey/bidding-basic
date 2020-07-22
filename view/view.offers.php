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
                <div id="submit-offer" class="content scrollspy">
                    <p><?= $this->postOfferTitle($this->getCountOffer($biddingId)) ?></p>
                    <a href="#addOffer" class="btn waves-effect orange white-text modal-trigger">Learn how</a>
                    <div id="addOffer" class="modal bottom-sheet">
                        <div class="modal-content">
                        
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
                        </div>
                    </div>
                </div>
            </div>
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