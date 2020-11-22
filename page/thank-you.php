<?php
$auth->redirect('auth', true, $BASE_DIR.'404/?unauth=1');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title><?php echo 'Canvasspoint - Thank You' ?></title>
  <?php
    require "component/head.php";
  ?>
</head>
<body class="minimal">

  <?php
    require "component/navbar.php";
    $direct = Sanitizer::filter('direct', 'get');
    $orderId = Sanitizer::filter('order', 'get');
    
    $orderId = ($orderId) ? "#CNPPRO" . $orderId : "Thank You" ;
    
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="container row">
        <div class="col s12 m12">
          <div class="col s12 white page z-depth-1" id="this-plan">
            <div class="row content">
              <div class="col s12">
                <div class="row">
                  <div class="col s12">
                    <label><a class="grey-text" href="<?= $BASE_DIR ?>">Home</a> > Plan > Thank You</label>
                    <br>
                    <br>
                    <br>
                    <label>Order Number</label>
                    <h1 class="no-margin"><b><?= $orderId ?></b></h1>
                    <br>
                    <div class="order">
                      <p><b>Thank you for your purchase.</b></p>
                      <p>
                        <?php
                          switch($direct) {
                              case "0":
                              case 0:
                                  echo "You will be contacted by one of our sales person to arrange the payment mode for your order. This should only take around 3 working days depending on the said arrangement.";
                                  break;
                              case "1":
                              case 1:
                                  echo "You will be notified once your payment was verified on our end.<br>This should only take around 3 working days.";
                                  break;
                          }
                        ?>
                      </p>
                      <a href="<?= $BASE_DIR ?>my/plan/" class="btn orange waves waves-effect">My Plans</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
    require "./component/footer.php";
  ?>