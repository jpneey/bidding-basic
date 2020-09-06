<?php 

defined('included') || die("Bad request"); 

$message = Sanitizer::filter('p', 'get');

$newUser = (empty($loggedInUserRole)) ? true : false;
$loggedInUserDetail = $user->getUser($__user_id, "cs_user_detail");

?>

<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label><a class="grey-text" href="<?= $BASE_DIR ?>">Home</a > My > Transaction</label>
                    <h1><b>Transactions</b></h1>
                </div>
                <div class="col s12" style="overflow: auto;">
                    <table style="min-width: 500px;">
                        <thead>
                            <tr>
                                <th>Transaction</th>
                                <th>Username</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                                $transaction = $user->getTransactions($__user_id, $loggedInUserRole);
                                switch($loggedInUserRole) {
                                    case '1':
                                        $rated = 'cs_bidder_id';
                                        $rateMessage = 'Rate Supplier';
                                        break;
                                    default:
                                        $rated = 'cs_bid_owner_id';
                                        $rateMessage = 'Rate Purchaser';
                                        break;
                                }
                                if(!empty($transaction)) {
                                    foreach($transaction as $key => $value){
                                        echo '<tr>';
                                        echo '<td>'.$transaction[$key]["cs_bidding_title"].'</td>';
                                        echo '<td><a href="'.$BASE_DIR.'user/'.$transaction[$key]["cs_user_name"].'" class="orange  btn white-text" >@'.$transaction[$key]["cs_user_name"].'</td>';
                                        echo '<td><a href="#!" data-name="'.$transaction[$key]["cs_user_name"].'" data-to="'.$transaction[$key][$rated].'" class="rate-modal-trigger btn orange darken-2 waves-effect waves-light">'.$rateMessage.'</a></td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="3">No transactions yet</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>

                    <?php
                        require_once "./include/include.rate.php";
                    ?>

                </div>    
            </div>
        </div>
    </div>
</div>