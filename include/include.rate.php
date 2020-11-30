<?php

$addSuccess = (isset($successToRate)) ?: false;

?>
<div id="rate-modal" class="modal modal-sm">
    <div class="modal-content">
        <form id="rate-form" action="" method="POST" class="row">
            <p>How would you describe your transaction with this user ?</p>
            <?php if($addSuccess) { ?>
            <p><label>Is the transaction successful?</label></p>
            <input type="hidden" id="to-success" name="offer_id" required readonly >
            <p>
                <label>
                    <input name="success" required value="1" type="radio"/>
                    <span>Yes, Good transaction</span>
                </label>
                <label>
                    <input name="success" value="2" type="radio"/>
                    <span>Unfortuantely No</span>
                </label>
            </p>
            <?php } ?>
            <p><label>Rating</label></p>
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
            <p><label>Comments</label></p>
            <textarea id="comments" name="comment" required class="materialize-textarea custom-input"></textarea>
            <button type="submit" class="waves-effect waves-green btn white-text">Submit</button>
    </div>
    </form>
</div>

<script src="<?= $BASE_DIR ?>static/js/services/services.rate.js" type="text/javascript"></script>

