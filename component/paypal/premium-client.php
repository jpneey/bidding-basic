<script src="https://www.paypal.com/sdk/js?client-id=AfZdF2lOZy9aFXfW4yjrTM6lXyrQ6o2B3ZDD7JEdewVo41eURFDZieln1b4MupLzVgv-dr9GOe15ndTZ&currency=PHP"> // Replace YOUR_SB_CLIENT_ID with your sandbox client ID
</script>
<div id="paypal-button-container"></div>

<!-- Add the checkout buttons, set up the order and approve the order -->
<script>

  paypal.Buttons({

    style: {
      shape: 'rect',
      color: 'black',
      layout: 'vertical',
      label: 'paypal',
      size: 'responsive'     
    },

    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '<?= $toPay ?>'
          }
        }]

      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        $('#load-wrap').fadeIn(100);
        $.ajax({
          url: 
            root + "controller/controller.payment.php?action=cli-paypal&or="
            +data.orderID
            +"&nm="+details.payer.name.given_name + " " + details.payer.name.surname
            +"&em="+details.payer.email_address,
          type: 'get',
          processData: false,
          contentType: false,
          success: function(data){

            data = JSON.parse(data);
            switch(data.code){
              case 1:
                  setTimeout(function(){
                      window.location.href = root + "thank-you/?direct=1&order=" + data.order_id;
                  }, 1500)                          
                  return
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
      });
    }
  }).render('#paypal-button-container'); // Display payment options on your web page
</script>

<script>
    $(function(){
        $('#sup-pro').on('click', function(){
            $('#load-wrap').fadeIn(500);
            $('#sup-pro').attr('disabled', true);
            $('.modal').modal('close');
            $.ajax({
                method: "GET",
                url: root + "controller/controller.payment.php?action=cli-pro",
                success: function(data){
                    data = JSON.parse(data);
                    switch(data.code){
                        case 1:
                            setTimeout(function(){
                                window.location.href = root + "thank-you/?direct=0&order=" + data.order_id;
                            }, 1500)                          
                            return
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

