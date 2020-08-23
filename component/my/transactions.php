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
                    <label>Home > My > Transaction</label>
                    <h1><b>Transactions</b></h1>
                </div>
                <div class="col s12" style="overflow: auto;">
                    <table style="min-width: 500px;">
                        <thead>
                            <tr>
                                <th>Transaction</th>
                                <th>Bidders / Bid Owners</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                                $transaction = $user->getTransactions($__user_id, $loggedInUserRole);
                                switch($loggedInUserRole) {
                                    case '1':
                                        $rated = 'cs_bidder_id';
                                        break;
                                    default:
                                        $rated = 'cs_bid_owner_id';
                                        break;
                                }
                                if(!empty($transaction)) {
                                    foreach($transaction as $key => $value){
                                        echo '<tr>';
                                        echo '<td>'.$transaction[$key]["cs_bidding_title"].'</td>';
                                        echo '<td><a href="'.$BASE_DIR.'user/'.$transaction[$key]["cs_user_name"].'" class="black-text" >@'.$transaction[$key]["cs_user_name"].'</td>';
                                        echo '<td><a href="#!" data-name="'.$transaction[$key]["cs_user_name"].'" data-to="'.$transaction[$key][$rated].'" class="rate-modal-trigger btn orange waves-effect waves-light">Rate User</a></td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="3">No transactions yet</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>

                    <div id="rate-modal" class="modal">
                        <div class="modal-content">
                            <h4 id="to-name">Modal Header</h4>
                            <p>How would you describe your transaction with this user ?</p>
                            <form id="rate-form" action="" method="POST" class="row">
                            <div class="col s12">
                                <p>
                                    <label>
                                        <input name="rate" required value="5" type="radio"/>
                                        <span>Great</span>
                                    </label>
                                    <label>
                                        <input name="rate" value="4" type="radio"/>
                                        <span>Good</span>
                                    </label>
                                    <label>
                                        <input name="rate" value="3" type="radio"/>
                                        <span>Decent</span>
                                    </label>
                                    <label>
                                        <input name="rate" value="2" type="radio"/>
                                        <span>Poor</span>
                                    </label>
                                    <label>
                                        <input name="rate" value="1" type="radio"/>
                                        <span>Very poor</span>
                                    </label>
                                </p>
                                <textarea id="comments" name="comment" required class="materialize-textarea"></textarea>
                                <label for="comments">Comments</label><br><br>
                                <input type="submit" class="waves-effect waves-green btn white-text" value="Submit" />
                            </div>
                        </div>
                        </form>
                    </div>

                </div>    
            </div>
        </div>
    </div>
</div>

<script>

    $(function(){
        rateModal();
        submitRate();
    })

    function rateModal() {
        $trigger = $('.rate-modal-trigger');
        $trigger.on('click', function(){
            var to = $(this).data('to');
            var name = $(this).data('name');
            $('#to-name').text(name);
            $('#rate-modal').modal();
            $('#rate-modal').modal('open');
            
            $.ajax({
                url: root + 'controller/controller.user.php?action=rate&to=' + to,
                type: 'GET',
                processData: false,
                contentType: false,
                success: function(data){
                    var parsedData = JSON.parse(data);
                    var formMode = parsedData.mode
                    
                    $('#rate-form').attr('action', root + 'controller/controller.user.php?action=rate-'+formMode+'&to='+to);
                    $("input[name=rate][value=" + parsedData.rate + "]").prop('checked', true);
                    $('#comments').val(parsedData.comment);
                    M.textareaAutoResize($('#comments'));
                    
                }
            })
            
        })
    }

    function submitRate() {
        $('#rate-form').on('submit', function(e){
            e.preventDefault();
            var $inputs = $(this).find("input, select, button, textarea");
            var action = $(this).attr("action");
            var type = $(this).attr("method");
            var formData = new FormData(this);

            $inputs.prop("disabled", true);
            window.onbeforeunload = function() {
                return "Are you sure you want to navigate away from this page?";
            };
            $.ajax({
                url: action,
                type: type,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    window.onbeforeunload = null;
                    $inputs.prop("disabled", false);
                    var parsedData = JSON.parse(data);
                    if(parsedData.code == '1') {
                        $('#rate-modal').modal();
                        $('#rate-modal').modal('close');
                    }
                    M.toast({
                        html: parsedData.message,
                        classes: "orange white-text"
                    });
                }
            })
        })
    }

</script>
