<div class="col s12">
        <table class="responsive-table">
            <tr>
                <th>Order ID</th>
                <th>Date Added</th>
                <th>Payment Method</th>
                <th>Plan Status</th>
                <th>Expires</th>
            </tr>
            <?php foreach($loop as $k => $v){ 
                $added = date('d M Y', strtotime($loop[$k]["date_added"]));
                $expires = date('d M Y', strtotime($loop[$k]["expires"]));
                $payment = ucwords($loop[$k]["cs_plan_payment"]);
                switch($loop[$k]["cs_plan_status"]){
                    case 0:
                        $status = "<b>Processing</b>";
                        $expires = "--";
                        break;
                    case 1:
                        $status = "<b>Active</b>";
                        break;
                    case 2:
                        $status = "<b>Expired</b>";
                        break;
                    default:
                        $status = "<b>Canceled</b>";
                        $expires = "--";
                }  
            ?>
            <tr>
                <td>#CNPPRO<?= $loop[$k]["cs_plan_id"] ?></td>
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