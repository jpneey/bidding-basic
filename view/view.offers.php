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
                <table class="center-align" id="offer-panel">
                    <thead>
                        <tr>
                            <th>Proposal</th>
                            <th>Rating</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $viewable = $this->getViewable($userId);
                        $thisViewable = $viewable;
                        foreach($offers as $k=>$v) {
                            $offered = unserialize($offers[$k]['cs_offer']);
                            $id = $offers[$k]['cs_offer_id'];
                            $status = $offers[$k]['cs_offer_status'];
                            $price = $offers[$k]['cs_offer_price'];
                            $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($offers[$k]['cs_owner_rating']));
                            echo '<tr>';
                            echo '<td><b>₱</b>'.number_format($price, '2', '.', ',').'<br><label>'.$offered['qty'].' <span class="qty">{qty}</span></label></td>';
                            echo '<td><span class="ratings">'.$rating.'</span></td>';
                            switch($status){
                                case '0':
                                    echo '<td><a href="#offer-modal" data-offer="'.$id.'" class="modal-trigger offer-modal-trigger btn-small waves-effect green white-text">open</a></td>';
                                    break;
                                case '1':
                                    $thisViewable--;
                                    echo '<td><a href="#!" data-offer="'.$id.'" class="view-modal btn-small waves-effect orange white-text">view</a></td>';
                                    break;
                            }
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                </table>
                <div id="offer-modal" class="modal" style="max-width: 440px">
                    <div class="modal-content">
                        <p>Your account can only open <b><?= $viewable ?></b> proposal(s) per bidding.
                        <?php
                            if($thisViewable <= 0) { 
                                echo '<br><br><a href="mailto:info@canvasspoint.com" class="btn-small orange">Upgrade to Pro</a>';
                                echo ' <a href="#!" class="btn-small red modal-close">cancel</a>';
                            }
                        ?>
                        <?php 
                            if($thisViewable >= 1) { ?>
                            Proceed to open this proposal?</p>
                            <div>
                                <a href="#!" data-offer="0" id="open-offer" class="btn-small green modal-close">open</a>
                                <a href="#!" class="btn-small red modal-close">cancel</a>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div id="view-offer-modal" class="modal">
                    <div class="modal-content">
                        <div id="view-offer-content"></div>
                    </div>
                </div>
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
                <div id="submit-offer" class="content sm row scrollspy">
            
                    <form class="col s12 row" action="#!" data-action="<?= $this->BASE_DIR.'controller/controller.offer.php?action=add&bid='.$biddingId ?>" id="offer-form" method="POST">

                        <div class="fields orig">
                            <div class="input-field no-margin col s12 m5">
                                <p><label>Item Name</label></p>
                                <input 
                                    required
                                    type="text" 
                                    name="cs_offer_product" 
                                    class="custom-input validate"
                                    readonly  
                                />
                            </div>
                                <input 
                                    required 
                                    type="hidden" 
                                    name="cs_offer_qty" 
                                    class="custom-input validate" 
                                    min="0" 
                                    step="1" 
                                    oninput="validity.valid||(value='');" 
                                    pattern=" 0+\.[0-9]*[1-9][0-9]*$"  
                                />
                            
                            <div class="input-field price-tooltip no-margin col s12 m7 tooltipped" 
                                    data-position="bottom" 
                                    data-tooltip="expected budget">
                                <p><label>Total Pricing for <b><span class="qty-c">{qty}</span> <span class="qty">{qty}</span></b></label></p>
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

                        <div class="file-field input-field col s12">
                            <div class="btn">
                                <span>Add Photo (optional)</span>
                                <input type="file" accept="image/*" name="cs_offer_image_one" />
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" placeholder=".jpg, with less than 3mb" type="text">
                            </div>
                        </div>

                        <div class="file-field input-field col s12">
                            <div class="btn">
                                <span>Add Photo (optional)</span>
                                <input type="file" accept="image/*" name="cs_offer_image_two" />
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" placeholder=".jpg, with less than 3mb" type="text">
                            </div>
                        </div>
                            
                        <div class="col s12">
                            <p><?= $this->postOfferTitle($this->getCountOffer($biddingId)) ?></p>
                            <input type="submit" value="Submit offer" class="btn white-text" />
                            <a href="<?= $this->BASE_DIR ?>about/faqs/" class="btn waves-effect orange white-text">Faqs</a>
                        </div>

                    </form>
                    <div class="col s12 row">
                    
                        <?php $this->viewLowestOffer($biddingId); ?>
                        <div class="col s12" id="placeholder">
                            <p><?= $this->postOfferTitle($this->getCountOffer($biddingId)) ?></p>
                            <a class="waves-effect waves-light btn generate-form" href="#~">Submit Offer</a>
                            <a href="#bid-faqs" class="btn modal-trigger waves-effect orange white-text">Faqs</a>
                        </div>
                    </div>

                </div>
            </div>
            
            <script src="<?= $this->BASE_DIR ?>static/js/services/services.addoffer.js" type="text/javascript"></script>

            <?php
        } else {
            ?>
            <div class="page white z-depth-1">
                <div id="submit-offer" class="content sm row scrollspy">
                    
                    <?php $this->viewLowestOffer($biddingId); ?>
                    <?php $this->viewMyOffers($userId, $biddingId); ?>
                    <div class="col s12">
                        <p>You need to login on a supplier account inorder to participate in biddings. Bidders remain anonymous until it's offer is selected.</p>
                        <?php if(!$userId) { ?>

                        <div id="how-to-bid" class="modal modal-fixed-footer">
                            <div class="modal-content">
                                <h4>Canvasspoint Suppliers</h4>
                                <p>Duis eget neque eget massa viverra dignissim. Ut nec eros sit amet purus finibus dictum ac quis nulla. Ut mollis odio at lobortis dignissim. Aliquam id orci odio. Donec ultrices lorem eget nunc condimentum, sit amet ornare diam consectetur. Quisque vel ligula a velit fringilla euismod. Nulla facilisi. Donec vehicula mollis arcu a consequat. Praesent rhoncus rhoncus velit at hendrerit. Praesent porttitor quam ut ante ullamcorper volutpat. In a convallis elit. Ut posuere blandit est, ut congue libero sagittis id. Nulla orci enim, varius sed pretium eleifend, laoreet congue orci. Etiam tempor urna a ex auctor, posuere pellentesque sem varius. Donec magna leo, maximus eu risus eget, sodales fringilla eros. Mauris hendrerit augue at turpis dapibus, nec condimentum lorem vestibulum.</p>
                            </div>
                            <div class="modal-footer">
                                <a href="<?= $this->BASE_DIR ?>home/?sidebar=2" class="modal-close waves-effect waves-green btn">Register Now</a>
                                <a href="#!" class="modal-close red white-text waves-effect btn-flat">Close</a>
                            </div>
                        </div>

                        <a href="#how-to-bid" class="modal-trigger btn waves-effect orange white-text">Learn how</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }



    protected function postOfferTitle($count){
        switch($count) {
            case '0':
                return 'Be the first one to submit an offer in this thread. Bidders remain anonymous until it\'s offer is selected.';
            default:
                return 'Join '.$count.' other supplier and submit your offer.Bidders remain anonymous until it\'s offer is selected.';
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
                        $statusStyle = 'feed-border green-text';
                        break;
                    case '1':
                        $statusStyle = 'feed-border orange-text';
                        break;
                    case '2':
                        $statusStyle = 'feed-border red-text';
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
                    <a href="#!" data-selector="<?= $offerId ?>" data-mode="offer" class="right data-delete z-depth-1 red white-text center-align">DELETE</a>
                    <a href="#!" data-offer="<?= $offerId ?>" data-mode="offer" class="view-modal right z-depth-1 green white-text center-align">VIEW</a>
                </span>

                <div id="view-offer-modal" class="modal">
                    <div class="modal-content">
                        <div id="view-offer-content"></div>
                    </div>
                </div>
            </div>
            <?php
            }
        }
    }

}