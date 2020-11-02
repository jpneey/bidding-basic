<?php

class viewOffers extends Offers {

    private $BASE_DIR;

    public function __construct($BASE_DIR, $conn = null) {
        $this->BASE_DIR = $BASE_DIR;
        if($conn){
            parent::__construct($conn);
        }
    }

    public function load($v){
        return $v;
    }

    public function viewMyOffers($userId, $biddingId, $supplier = false) {
        $offers = $this->getBidOffers($userId, $biddingId, $supplier);
        if(!empty($offers)) {
            ?>
            <div class="col s12">
                <table class="center-align" id="offer-panel">
                    <thead>
                        <tr>
                            <th>Proposal</th>
                            <th>Rating</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $linkToOwner = '#!';
                        $viewable = $this->getViewable($userId);
                        $thisViewable = $viewable;
                        foreach($offers as $k=>$v) {
                            $offered = unserialize($offers[$k]['cs_offer']);
                            $id = $offers[$k]['cs_offer_id'];
                            $status = $offers[$k]['cs_offer_status'];
                            $price = $offers[$k]['cs_offer_price'];
                            $rated = ($offers[$k]['cs_rated']) ? 'out of ' . $offers[$k]['cs_rated'] . ' review(s)' : 'No ratings yet.';
                            $rating = ($offers[$k]['cs_rated']) ? number_format($offers[$k]['cs_owner_rating'],1,'.',',') : '';
                            echo '<tr>';
                            echo '<td><b>₱</b>'.number_format($price, '2', '.', ',').'<br><label>'.$offered['qty'].' <span class="qty">{qty}</span></label></td>';
                            echo '<td><b>'.$rating.'</b> '.$rated.'</td>';
                            if(!$supplier){
                                switch( $offers[$k]['cs_offer_success']){
                                    case '2':
                                        $successAction = '<a href="#!" class="btn-small waves-effect red white-text">Bad Transaction</a> ';
                                        break;
                                    case '1':
                                        $successAction = '<a href="#!" class="btn-small waves-effect green white-text">Success</a> ';
                                        break;
                                    case '0':
                                    default:
                                        $successAction = '<a href="#!" data-name="'.$id.'" data-to="'.$offers[$k]["cs_user_id"].'" class="btn-small rate-modal-trigger waves-effect orange darken-2 white-text">Finalize Proposal</a> ';
                                        break;
                                }
                                switch($status){
                                    case '0':
                                        echo '<td><a href="#offer-modal" data-offer="'.$id.'" class="modal-trigger offer-modal-trigger btn-small waves-effect green white-text">open</a></td>';
                                        break;
                                    case '1':
                                        $thisViewable--;
                                        echo '<td><a href="#!" data-offer="'.$id.'" class="view-modal btn-small waves-effect orange white-text">view</a> ';
                                        echo $successAction;
                                        echo '</td>';
                                        break;
                                    case '0':
                                    default:
                                        echo '<td><a href="#!" data-offer="'.$id.'" class="btn-small waves-effect red white-text">rejected</a></td>';
                                        break;
                                }
                            } else {
                                
                                echo '<td>';
                                switch($status){
                                    case '1':
                                        echo '<a href="#winner-offer" id="wtrg" class="modal-trigger btn-small waves-effect orange white-text">Winner</a> ';
                                        $linkToOwner = $this->BASE_DIR.'user/'.$offers[$k]['cs_purchaser'];
                                        ?>
                                        <script>
                                        $(function(){
                                            setTimeout(function(){
                                                $('#winner-offer').modal('open')
                                            }, 1000)
                                        })
                                        </script>
                                        <?php
                                        echo '<a href="'.$linkToOwner.'" class="btn-small waves-effect orange darken-2 white-text">Contact Purchaser</a>';
                                        break;
                                    case '2':
                                        echo '<a href="#!" class="btn-small waves-effect red lighten-1 white-text">Rejected</a> ';
                                        echo '<a href="#!" data-mode="offer" data-selector="'.$id.'" class="data-delete btn-small waves-effect red white-text">Delete</a> ';
                                        break;
                                    default:
                                        echo '<a href="#active-offers" class="modal-trigger btn-small waves-effect green white-text">Active</a> ';
                                        echo '<a href="#!" data-mode="offer" data-selector="'.$id.'" class="data-delete btn-small waves-effect red white-text">Cancel</a> ';
                                }
                                echo '</td>';
                            }
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                </table>
                <div id="active-offers" class="modal modal-sm">
                    <div class="modal-content">
                        <p><b>Active</b></p>
                        <p>This proposal's status is still active. This means that the purchaser is still open to consider other bidding proposals.</p>
                    </div>
                </div>
                <div id="winner-offer" class="modal modal-sm">
                    <div class="modal-content">
                        <p><b>Hooray!</b></p>
                        <p>Your proposal won this bidding. Both client and supplier can now view each other's profile.<br><br><a href="<?= $linkToOwner ?>" class="btn orange" >View Purchaser</a></p>
                    </div>
                </div>
                <div id="offer-modal" class="modal" style="max-width: 440px">
                    <div class="modal-content">
                        <p>Your account can only open <b><?= $viewable ?></b> proposal(s) per bidding.
                        <?php
                            if($thisViewable <= 0) { 
                                echo '</p><br><br><a href="mailto:info@canvasspoint.com" class="btn-small orange">Upgrade to Pro</a>';
                                echo ' <a href="#!" class="btn-small red modal-close">cancel</a>';
                            }
                        ?>
                        <?php 
                            if($thisViewable >= 1) { ?>
                            Open this proposal?<br><br>
                            <span class="grey-text text-darken-2 small-text">* the first offer that you'll view will automatically be this bidding's winner.</span>
                            </p>
                            <div>
                                <a href="#!" data-offer="0" id="open-offer" class="btn-small green modal-close">open</a>
                                <a href="#!" class="btn-small red modal-close">cancel</a>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div id="view-offer-modal" class="modal modal-sm">
                    <div class="modal-content">
                        <div id="view-offer-content"></div>
                    </div>
                </div>
            </div>
            <script>$(function(){$(".qty").text($('.item').data('unit'));})</script>
            
        <?php
        } ?>
        <div class="col s12">
        <?php $offers = $this->getBidControl($userId, $biddingId); ?>
        </div>
        <?php
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
        if($biddingId){
            $hasOffer = $this->hasOffer($biddingId, $userId);
            if($isSupplier && !$hasOffer) {
                ?>
                <div class="page white z-depth-0">
                    <div id="submit-offer" class="content sm row scrollspy">
                
                        <form action="#!" data-action="<?= $this->BASE_DIR.'controller/controller.offer.php?action=add&bid='.$biddingId ?>" id="offer-form" method="POST">

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
                                    <!-- 
                                    <p><label>Your offer for <b><span class="qty-c">{qty}</span> <span class="qty">{qty}</span></b></label></p>
                                     -->
                                    <p><label>Your bid / price</b></label></p>
                                    <input 
                                        required 
                                        type="number" 
                                        name="cs_offer_price" 
                                        class="custom-input validate"  
                                        min="0.00"
                                        step="0.01"
                                    />
                                </div>
                            </div>

                            <div class="input-field no-margin col s12">
                                <p><label>Item / Service Availability</label></p>
                                <input 
                                    required 
                                    type="text" 
                                    name="cs_offer_date" 
                                    class="custom-input datepicker validate"  
                                />
                            </div>

                            <div class="input-field no-margin col s12">
                                <p><label>Notes</label></p>
                                <input 
                                    required 
                                    type="text" 
                                    name="cs_offer_notes" 
                                    class="custom-input validate"  
                                />
                            </div>
                            <div id="imagesForm" style="display: none;">
                            
                                <div class="col s12">
                                    <Label><br>Maximum of three(3)</Label>
                                </div>
                                <div id="im_1" class="file-field input-field col s12">
                                    <div class="btn">
                                        <span>Add Images</span>
                                        <input type="file" accept="image/*" name="cs_offer_image[]" multiple="true" />
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" placeholder=".jpg, with less than 3mb" type="text">
                                    </div>
                                </div>
                            </div>
                                
                            <div class="col s12">
                                <br>
                                <a href="#!" class="btn addImage waves-effect orange white-text">Attach Image</a>
                                <p><?= $this->postOfferTitle($this->getCountOffer($biddingId)) ?></p>
                                <button type="submit" class="btn white-text">Submit Offer</button>
                                <a href="#bid-faqs" class="btn modal-trigger waves-effect grey white-text">Faqs</a>
                            </div>

                        </form>
                        <div class="col s12">
                            <?php $this->viewLowestOffer($biddingId); ?>
                            <div id="placeholder">
                                <p><?= $this->postOfferTitle($this->getCountOffer($biddingId)) ?></p>
                                <a class="waves-effect waves-light btn generate-form" href="#~">Submit Offer</a>
                                <a href="#bid-faqs" class="btn modal-trigger waves-effect grey white-text">Faqs</a>
                            </div>
                        </div>

                    </div>
                </div>
                
                <script src="<?= $this->BASE_DIR ?>static/js/services/services.addoffer.js?v=beta-s20s67asd56sss0" type="text/javascript"></script>

                <?php
            } else {
                ?>
                <div class="page white z-depth-0">
                    <div id="submit-offer" class="content sm row scrollspy">
                        
                        <?php $this->viewLowestOffer($biddingId); ?>
                        <?php $this->viewMyOffers($userId, $biddingId); ?>
                        <?php if(!$isSupplier){ ?>
                        <div class="col s12">
                            <?php if(!$userId) { ?>
                            <p>You need to login on a supplier account inorder to participate in biddings. Bidders remain anonymous until it's offer is selected by the client and won the bidding.</p>
                            <div id="how-to-bid" class="modal modal-sm">
                                <div class="modal-content">
                                    <p><b>Canvasspoint Suppliers</b></p>
                                    <p>Duis eget neque eget massa viverra dignissim.</p>
                                    
                                    <a href="<?= $this->BASE_DIR ?>home/?sidebar=2" class="modal-close waves-effect waves-green btn">Register Now</a>
                                    <a href="<?= $this->BASE_DIR ?>home/?sidebar=0" class="modal-close red white-text waves-effect btn-flat">Login</a>
                                </div>
                            </div>

                            <a href="#how-to-bid" class="modal-trigger btn waves-effect orange white-text">Learn how</a>
                            <?php } ?>
                        </div>
                        <?php } else { ?>
                        <?php $this->viewMyOffers($userId, $biddingId, true); ?>
                        <div class="col s12">
                            <br>
                            <p>Your Offer was submitted successfully and only one offer per supplier is allowed per bidding. Offers can't be canceled once the bidding reaches three (3) days before expiration.</p>
                            <a href="#!" class="btn waves-effect grey lighten-1 white-text">Offer Submitted</a>
                            <a href="<?= $this->BASE_DIR ?>my/dashboard/" class="btn waves-effect green white-text">Dashboard</a>
                        </div>
                        <script src="<?= $this->BASE_DIR ?>static/js/services/services.delete.js" type="text/javascript"></script>
                        <?php
                        } ?>
                    </div>
                </div>
                <?php
            }
        }
    
    }



    protected function postOfferTitle($count){
        switch($count) {
            case '0':
                return 'Be the first one to submit an offer in this thread. Bidders remain anonymous until it\'s offer is selected by the client and won the bidding.';
            default:
                return 'Join '.$count.' other supplier and submit your offer. Bidders remain anonymous until it\'s offer is selected by the client and won the bidding.';
        }
    }
    
    public function viewUserOfferStatus($user_id){ 

        $counts = $this->getDashboardCounts($user_id);

        ?>
            <div class="col s12 m4">
                <div class="dashboard-panel green lighten-0 white-text z-depth-0">
                    <h1><b><?= $counts[0] ?></b></h1>
                    <p>Active Proposal</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="dashboard-panel red lighten-0 white-text z-depth-0">
                    <h1><b><?= $counts[2] ?></b></h1>
                    <p>Rejected Proposal</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="dashboard-panel orange lighten-0 white-text z-depth-0">
                    <h1><b><?= $counts[1] ?></b></h1>
                    <p>Accepted Proposal</p>
                </div>
            </div>

        <?php
    }

    public function viewUserOffers($userId, $status){
        
        $userOffers = $this->getUserOffers($userId, $status);
        switch($status){
            case '0':
                $titled = "Active Proposals";
                $tip = "This means the bidding is yet to end and your proposal can still be chosen.";
                $statusStyle = 'feed-border green-text';
                break;
            case '1':
                $titled = "Accepted Proposals";
                $tip = "Propsals that won the bidding and proposals openned by the purchaser goes here.";
                $statusStyle = 'feed-border orange-text';
                break;
            case '2':
                $titled = "Rejected Proposals";
                $tip = "Rejected proposals goes here. Rejected proposals can be safely deleted.";
                $statusStyle = 'feed-border red-text';
                break;
        }
        
        if(!empty($userOffers)){
            ?>
            <div class="col s12 block">
                <p><b><?= $titled ?></b><br><span class="grey-text" style="font-size: 12px;"><?= $tip ?></span></p>
            </div>
            <?php
            foreach($userOffers as $key=>$value){
                
                $title = $userOffers[$key]["cs_bidding_title"];
                $link = $userOffers[$key]["cs_bidding_permalink"];
                $offerId = $userOffers[$key]["cs_offer_id"];
                $datePosted = date_format(date_create($userOffers[$key]["cs_date_added"]), 'D d M Y');
                $datePosted = '<time>'.$datePosted.'</time>'; 
            ?>
            <div class="col s12 block">
                <a href="<?= $this->BASE_DIR.'bid/'.$link.'/' ?>">
                    <div class="feed-card feed-card-full white z-depth-0 <?= $statusStyle ?>">
                        <div class="feed-card white z-depth-0">
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
                    <a href="#!" data-selector="<?= $offerId ?>" data-mode="offer" class="right data-delete z-depth-0 red white-text center-align">DELETE</a>
                    <a href="#!" data-offer="<?= $offerId ?>" data-mode="offer" class="view-modal right z-depth-0 green white-text center-align">VIEW</a>
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

    public function getBidControl($userId, $biddingId) {
        $status = $this->bidStatus($userId, $biddingId);
        if($status){ ?>
            <script src="<?= $this->BASE_DIR ?>static/js/services/services.delete.js?v=beta-199" type="text/javascript"></script>
            <?php
            switch($status[0]) {
                case '0':
                case 0:
                case '1':
                case 1:
                    echo "<br><a href=\"#!\" data-selector=\"$status[1]\" data-mode=\"bid-finish\" class=\"data-delete btn waves-effect orange white-text\">Mark as <b>Complete</b></a>";
                    break;
                case '2':
                case 2:
                    echo "<br><a href=\"#!\" data-selector=\"$status[1]\" data-mode=\"bid\" class=\"data-delete btn waves-effect red white-text\">Permanently Delete bidding</a>";
                    break;
            }
        }
    }
}