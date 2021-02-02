<?php 

defined('included') || die("Bad request"); 

$clientPlan = 200.00;
$supplierPlan = 150.00;

$toPay = 180;

$_plans_expired = $user->getPlans($__user_id, false, true);

$_plans = $user->getPlans($__user_id, false);

$direct_pay_msg = '<p>After submitting your  <span class="orange-text">upgrade to pro</span> request, You will be contacted by one of our sales person to arrange the payment mode for your order. This should only take around 3 working days depending on the said arrangement.</p>';
$pay_script = "";

if(!empty($_plans)){
    $loop = $_plans;
    if(!empty($_plans_expired)) {
        $loop = $user->getPlans($__user_id, true);
    }
    ob_start();
    require "component/paypal/history.php";
    $_plans = ob_get_clean();
} else  { 
    $_plans = ""; 
}

if(!empty($_plans_expired) && empty($_plans)){
    $loop = $_plans_expired; 
    ob_start();
    require "component/paypal/history.php";
    $_plans_expired = ob_get_clean();
} else {
    $_plans_expired = "";
}



?>

<div class="col s12 white page z-depth-1" id="this-plan">
    <div class="row content" style="padding: 15px">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label><a class="grey-text" href="<?= $BASE_DIR ?>">Home</a> > My > Plan</label>
                    <br>
                    <br>
                    <br>
                </div>

                <?php if($isBidder) { echo $_plans; echo $_plans_expired; ?>
                <div class="col s12 m6">
                    <div class="plan <?= ($loggedInAccountType) ?: 'active' ?>">
                        <h1><b>Free</b></h1>
                        <span class="plan-title">Free / Lifetime</span>
                        <ul class="plan-features">
                            <li>Open one (1) offer per bid</li>
                            <li>Post up to four (4) active biddings</li>
                            <li>Inquire directly<br>on product / service listed on canvasspoint</li>
                        </ul>
                        <button class="plan-button waves-effect">Free / Lifetime</button>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="plan <?= ($loggedInAccountType) ? 'active' : 'x' ?>">
                    
                        <?php $toPay = $clientPlan; ?>

                        <h1><b>Pro</b></h1>
                        <span class="plan-title">₱ <?= number_format($clientPlan, 2, '.', ',') ?> / Year</span>
                        <ul class="plan-features">
                            <li>All on free</li>
                            <li>Open up to four (4) offers per bid for a year.</li>
                        </ul>
                        <?php if(!$loggedInAccountType){ ?>

                        <?php if(empty($_plans)){ ?>

                        <button class="plan-button waves-effect modal-trigger" data-target="direct-pay">Contact Sales</button>
                             
                        <div id="direct-pay" class="modal modal-sm left-align">
                            <div class="modal-content">
                                <p><b>Premium Client</b></p>
                                <?= $direct_pay_msg ?>
                                <button type="button" id="sup-pro" class="btn btn-sm orange white-text">Become a Pro</button>
                                <?= $pay_script; ?>
                            </div>
                        </div>

                        <?php require "component/paypal/premium-client.php"; ?>

                        <?php } else { ?>
                        <button class="plan-button waves-effect">Purchase Pending</button>
                        <?php } ?>

                        <?php } else { ?>
                        <button class="plan-button waves-effect">Current Plan</button>                        
                        <?php } ?>
                        
                    </div>
                  </div>
                
                <?php } ?>
                <?php if($isSupplier) { echo $_plans; echo $_plans_expired; ?>
                    
                <div class="col s12 m6">
                    <div class="plan <?= ($loggedInAccountType) ?: 'active' ?>">
                        <h1><b>Free</b></h1>
                        <span class="plan-title">Free / Lifetime</span>
                        <ul class="plan-features">
                            <li>Maximum of one(1) proposal per bidding</li>
                            <li style="border-color: transparent">&nbsp;</li>
                        </ul>
                        <button class="plan-button waves-effect">Free / Lifetime</button>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="plan <?= ($loggedInAccountType) ? 'active' : 'x' ?>">

                        <?php $toPay = $supplierPlan; ?>

                        <h1><b>Pro</b></h1>
                        <span class="plan-title">₱ <?= number_format($supplierPlan, 2, '.', ',') ?> / Year</span>

                        <ul class="plan-features">
                            <li>Maximum of one(1) proposal per bidding</li>
                            <li>Feature up to 3 products/services</li>
                        </ul>
                        <?php if(!$loggedInAccountType){ ?>

                        <?php if(empty($_plans)){ ?>

                        <button class="plan-button waves-effect modal-trigger" data-target="direct-pay">Contact Sales</button>

                        <div id="direct-pay" class="modal modal-sm left-align">
                            <div class="modal-content">
                                <p><b>Premium Supplier</b></p>
                                <?= $direct_pay_msg ?>
                                <button type="button" id="sup-pro" class="btn btn-sm orange white-text">Become a Pro</button>
                                <?= $pay_script; ?>
                            </div>
                        </div>
                        
                        <?php require_once "component/paypal/premium-client.php"; ?>
                        
                        <?php } else { ?>
                        <button class="plan-button waves-effect">Purchase Pending</button>
                        <?php } ?>

                        <?php } else { ?>
                        <button class="plan-button waves-effect">Current Plan</button>                        
                        <?php } ?>

                    </div>
                </div>
                
                <?php } ?>
                
                
            </div>
        </div>
    </div>
</div>
