<div id="smart-button-container">
    <div style="text-align: center;">
        <div id="paypal-button-container"></div>
    </div>
</div>


<script src="https://www.paypal.com/sdk/js?client-id=AfZdF2lOZy9aFXfW4yjrTM6lXyrQ6o2B3ZDD7JEdewVo41eURFDZieln1b4MupLzVgv-dr9GOe15ndTZ&currency=PHP" data-sdk-integration-source="button-factory"></script>
<script>
    function initPayPalButton() {
        paypal.Buttons({
            style: {
            shape: 'rect',
            color: 'gold',
            layout: 'vertical',
            label: 'paypal',
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"Canvasspoint Premium Client","amount":{"currency_code":"PHP","value":420.69}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details, data) {
            seedDB(details);
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }

    initPayPalButton();

    function seedDB(details){
        
        var em = details.payer.email_address
        var nm = details.payer.name.given_name + " " + details.payer.name.surname

        $.ajax({
            method: "GET",
            url: root + "controller/controller.user.php?action=cli-pro-ppal&em="+em+nm,
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
    }
</script>                 