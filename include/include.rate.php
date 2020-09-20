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
            $('#to-success').val(name);
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
                    
                    $('#rate-modal').modal();
                    $('#rate-modal').modal('close');
                    if(parsedData.code == '1') {
                        window.location.reload();
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
