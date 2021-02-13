<?php

require_once "./app/component/import.php";

$meta_title = "Users - Material Dashboard";
$meta_description = "Material Dashboard v-0.1";

require_once "./app/controller/controller.sanitizer.php";

require_once "./app/component/head.php";
require_once "./app/component/navbar.php";

$userName = Sanitizer::filter('user', 'get');

$all = $user->getAllUserDetails($userName);

if(empty($all)) {
    ?>
    <div class="main">
    <div class="row">
    <div class="col s12 table-wrap z-depth-0">
    <div class="table-wrap z-depth-1 white " style="padding: 15px;">
    <?php
    echo 'No Data Available';
    ?>
    </div></div></div></div>
    <?php
    die();
}

?>

<link rel="stylesheet" href="<?= $BASE ?>static/lib/datatables.min.css">
<link rel="stylesheet" href="<?= $BASE ?>static/css/table.css">
<script src="<?= $BASE ?>static/lib/datatables.min.js"></script>    

<style> 
    td, th { white-space: nowrap; min-width: 150px; text-align: left;}
    .table-wrap {
        overflow: auto;
        margin-bottom: 25px !important;
    }
    table {
        background: white;
    }
</style>

<div class="main">
    <div class="row">
        <div class="col s12 table-wrap z-depth-0">
            <div class="table-wrap z-depth-1">

                <a href="<?= $BASE_DIR . "as/?token=" . $all['details'][0][0] . "&mod=" . $all['details'][0][6] ?>" class="btn orange white-text">Log in as <?= $all['details'][0][1] ?></a>

                <br><br>
                <table id="userTable">
                    <thead>
                        <tr>
                            <th style="min-width: 150px;">Field</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1. User ID</td>
                            <td><?= $all['details'][0][0] ?></td>
                        </tr>
                        <tr>
                            <td>2. Username</td>
                            <td><?= $all['details'][0][1] ?></td>
                        </tr>
                        <tr>
                            <td>3. Email Address</td>
                            <td><?= $all['details'][0][2] ?></td>
                        </tr>
                        <tr>
                            <td>4. Contact Details</td>
                            <td>
                                <?php 
                                $contacts = unserialize($all['details'][0][3]);
                                ?>
                                <table>
                                    <tr><td>Facebook</td><td><a href="<?= $contacts['cs_facebook'] ?>" target="_blank"><?= ($contacts['cs_facebook']) ?: 'N/A' ?></a></td></tr>
                                    <tr><td>Linkedin</td><td><a href="<?= $contacts['cs_linkedin'] ?>" target="_blank"><?= ($contacts['cs_linkedin']) ?: 'N/A' ?></a></td></tr>
                                    <tr><td>Website</td><td><a href="<?= $contacts['cs_website'] ?>" target="_blank"><?= ($contacts['cs_website']) ?: 'N/A' ?></a></td></tr>
                                    <tr><td>Phone</td><td><a href="tel:<?= $contacts['cs_telephone'] ?>" target="_blank"><?= ($contacts['cs_telephone']) ?: 'N/A' ?></a></td></tr>
                                    <tr><td>Mobile</td><td><a href="tel:<?= $contacts['cs_mobile'] ?>" target="_blank"><?= ($contacts['cs_mobile']) ?: 'N/A' ?></a></td></tr>

                                </table>
                            </td>
                        </tr>     
                        <tr>
                            <td>5. About</td>
                            <td><?= $all['details'][0][4] ?></td>
                        </tr>
                        <tr>
                            <td>6. Role</td>
                            <td><?= ($all['details'][0][6] == 1) ? 'Client' : 'Supplier' ?></td>
                        </tr>
                        <tr>
                            <td>7. Profile Picture</td>
                            <td><a href="#!" target="_blank"><?= $all['details'][0][7] ?></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="table-wrap z-depth-1">
                <table id="ratingTable">
                    <thead>
                        <tr>
                            <th>Rating ID</th>
                            <th>Rating</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($all['ratings'][0] as $key => $value){ ?>
                    <tr>
                        <td><?= $all['ratings'][0][$key]['cs_rating_id'] ?></td>
                        <td><?= $all['ratings'][0][$key]['cs_rating'] ?> / 5</td>
                        <td><?= $all['ratings'][0][$key]['cs_comment'] ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="table-wrap z-depth-1">
                <table id="transactionTable">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Bidding Title</th>
                            <th>Is Success</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($all['transactions'][0] as $key => $value){ ?>
                    <tr>
                        <td><?= $all['transactions'][0][$key]['cs_transaction_id'] ?></td>
                        <td><?= $all['transactions'][0][$key]['cs_bidding_title'] ?></td>
                        <td><?= $all['transactions'][0][$key]['cs_is_success'] ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="table-wrap z-depth-1">
                <table id="productTable">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($all['products'][0] as $key => $value){ ?>
                    <tr>
                        <td><?= $all['products'][0][$key]['cs_product_id'] ?></td>
                        <td><?= $all['products'][0][$key]['cs_product_name'] ?></td>
                        <td><?= $all['products'][0][$key]['cs_product_permalink'] ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="table-wrap z-depth-1">
                <table id="planTable">
                    <thead>
                        <tr>
                            <th>Plan ID</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($all['plans'][0] as $key => $value){ ?>
                        <tr>
                            <td><?= $all['plans'][0][$key]['cs_plan_id'] ?></td>
                            <td><?php switch($all['plans'][0][$key]['cs_plan_status']){
                                case "1":
                                    echo "Active";
                                    break;
                                case "2":
                                    echo "Expired";
                                    break;
                                default:
                                    echo "Processing";
                                    break;
                            } ?></td>
                            <td><?= $all['plans'][0][$key]['cs_plan_payment'] ?></td>
                            <td><?= $all['plans'][0][$key]['cs_gateway_comment'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="table-wrap z-depth-1">
                <table id="offerTable">
                    <thead>
                        <tr>
                            <th>OfferID</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Added</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($all['offers'][0] as $key => $value){ ?>
                    <tr>
                        <td><?= $all['offers'][0][$key]['cs_offer_id'] ?></td>
                        <td>
                            <?php 
                                $item =  unserialize($all['offers'][0][$key]['cs_offer']); 
                                echo $item['product'];
                                echo ' - ' . $item['qty'];
                            ?>
                        </td>
                        <td>P <?= $all['offers'][0][$key]['cs_offer_price'] ?></td>
                        <td><?= $all['offers'][0][$key]['cs_date_added'] ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>    
            
            <div class="table-wrap z-depth-1">
                <table id="notifTable">
                    <thead>
                        <tr>
                            <th>Notification ID</th>
                            <th>Notification</th>
                            <th>Read</th>
                            <th>Added</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($all['notifications'][0] as $key => $value){ ?>
                    <tr>
                        <td><?= $all['notifications'][0][$key]['cs_notif_id'] ?></td>
                        <td><?= $all['notifications'][0][$key]['cs_notif'] ?></td>
                        <td><?= ($all['notifications'][0][$key]['cs_notif_read']) ? 'Read' : 'Not yet' ?></td>
                        <td><?= $all['notifications'][0][$key]['cs_added'] ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        
        $('#userTable, #ratingTable, #transactionTable, #productTable, #planTable, #offerTable, #notifTable').DataTable({
            "pagingType": "simple",
            "bLengthChange": false
        });
    })
</script>

<?php

require_once "./app/component/footer.php";