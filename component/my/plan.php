<?php 

defined('included') || die("Bad request"); 

$_plans = $user->getPlans($__user_id);

$direct_pay_msg = '<p>After submitting your  <span class="orange-text">upgrade to pro</span> request, You will be contacted by one of our sales person to arrange the payment mode for your order. This should only take around 3 working days depending on the said arrangement.</p>';

ob_start();
?>
<script>
    $(function(){
        $('#sup-pro').on('click', function(){
            $('#load-wrap').fadeIn(500);
            $('#sup-pro').attr('disabled', true);
            $('.modal').modal('close');
            $.ajax({
                method: "GET",
                url: root + "controller/controller.user.php?action=cli-pro",
                success: function(data){
                    data = JSON.parse(data);
                    switch(data.code){
                        case 1:
                            var classes = 'green darken-2 white-text';
                            $('#this-plan').load(location.href+" #this-plan>*", "");
                            break;
                        default:
                            var classes = 'red white-text';
                            break;
                    }
                    var action = '<button onclick="M.Toast.dismissAll();" class="btn-flat toast-action"><i class="close material-icons">close</i></button>';
                    M.toast({
                        html: data.message + action,
                        classes: classes,
                        displayLength: 12000
                    });
                    $('#sup-pro').attr('disabled', true);
                    setTimeout(function(){
                        $('#load-wrap').fadeOut(500);
                    }, 1000)
                    return
                }
            })
        })
    })
</script>
<?php
$pay_script = ob_get_clean();

if(!empty($_plans)){ 
    ob_start();
    ?>
    <div class="col s12">
        <table class="responsive-table">
            <tr>
                <th>Plan</th>
                <th>Date Added</th>
                <th>Payment Method</th>
                <th>Plan Status</th>
                <th>Expires</th>
            </tr>
            <?php foreach($_plans as $k => $v){ 
                $added = date('d M Y', strtotime($_plans[$k]["date_added"]));
                $expires = date('d M Y', strtotime($_plans[$k]["expires"]));
                $payment = ucwords($_plans[$k]["cs_plan_payment"]);
                switch($_plans[$k]["cs_plan_status"]){
                    case 0:
                        $status = "<span class='btn btn-sm orange darken-2 white-text'>Processing</span>";
                        $expires = "--";
                        break;
                    case 1:
                        $status = "<span class='btn btn-sm green darken-2 white-text'>Active</span>";
                        break;
                    case 2:
                        $status = "<span class='btn btn-sm red darken-2 white-text'>Expired</span>";
                        break;
                    default:
                        $status = "<span class='btn btn-sm grey darken-2 white-text'>Canceled</span>";
                        $expires = "--";
                }  
            ?>
            <tr>
                <td>Premium</td>
                <td><?= $added ?></td>
                <td><?= $payment ?></td>
                <td><?= $status ?></td>
                <td><?= $expires ?></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <br>
    </div>
<?php 
    $_plans = ob_get_clean();
} else { $_plans = ""; } ?>

<div class="col s12 white page z-depth-1" id="this-plan">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label><a class="grey-text" href="<?= $BASE_DIR ?>">Home</a> > My > Plan</label>
                    <br>
                    <br>
                    <br>
                </div>

                <?php if($isBidder) { echo $_plans ?>
                <div class="col s12 m6">
                    <div class="plan <?= ($loggedInAccountType) ?: 'active' ?>">
                        <span class="plan-title">Free</span>
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
                        <span class="plan-title">Premium</span>
                        <ul class="plan-features">
                            <li>All on free</li>
                            <li>Open up to four (4) offers per bid for a year.</li>
                        </ul>
                        <?php if(!$loggedInAccountType){ ?>
                        <button class="plan-button waves-effect modal-trigger" data-target="direct-pay">₱ 420.69 / Year</button>

                        <?php /* require "component/paypal/premium-client.php" */ ?>     


                        <div id="direct-pay" class="modal modal-sm left-align">
                            <div class="modal-content">
                                <p><b>Premium Client</b></p>
                                <?= $direct_pay_msg ?>
                                <button type="button" id="sup-pro" class="btn btn-sm orange white-text">Become a Pro</button>
                                <?= $pay_script; ?>
                            </div>
                        </div>

                        <?php } else { ?>
                        <button class="plan-button waves-effect">Current Plan</button>                        
                        <?php } ?>
                        
                    </div>
                  </div>
                
                <?php } ?>
                <?php if($isSupplier) { echo $_plans ?>
                    
                <div class="col s12 m6">
                    <div class="plan <?= ($loggedInAccountType) ?: 'active' ?>">
                        <span class="plan-title">Free</span>
                        <ul class="plan-features">
                            <li>Submit one (1) proposal per bidding</li>
                        </ul>
                        <button class="plan-button waves-effect">Free / Lifetime</button>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="plan <?= ($loggedInAccountType) ? 'active' : 'x' ?>">
                        <span class="plan-title">Premium</span>
                        <ul class="plan-features">
                            <li>All on free</li>
                            <li>Post up to three (3) featured item on canvasspoint</li>
                        </ul>
                        <?php if(!$loggedInAccountType){ ?>
                        <button class="plan-button waves-effect modal-trigger" data-target="direct-pay">₱ 420.69 / Year</button>

                        <div id="direct-pay" class="modal modal-sm left-align">
                            <div class="modal-content">
                                <p><b>Premium Supplier</b></p>
                                <?= $direct_pay_msg ?>
                                <button type="button" id="sup-pro" class="btn btn-sm orange white-text">Become a Pro</button>
                                <?= $pay_script; ?>
                            </div>
                        </div>

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
