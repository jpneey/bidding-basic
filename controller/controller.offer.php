<?php

require_once "./controller.auth.php";
require_once "./controller.sanitizer.php";
require_once "./controller.database.php";
require_once "../model/model.user.php";
require_once "../model/model.offers.php";
require_once "../model/model.constant.php";

$auth = new Auth();
$dbhandler = new DBHandler();
$user = new User();
$offer = new Offers();

$action = Sanitizer::filter('action', 'get');

switch ($action) {

    case 'add':
        
        if(!$auth->compareSession('auth', true) && $auth->compareSession('__user_role', 2)){
            echo json_encode(array('code' => 0, 'message' => 'Oh no! You need to login to perform this action.'));
            exit();
        }

        $_POST['cs_bidding_user_id'] = $auth->getSession('__user_id');
        
        $postArr = array(
            array("cs_bidding_id", "int"),
            array("cs_user_id", "int"),
            array("cs_offer_product", "str"),
            array("cs_offer_qty", "int"),
            array("cs_offer_price", "str"),
        );

        foreach($postArr as $key => $value){
            ${$postArr[$key][0]} = Sanitizer::filter($postArr[$key][0], 'post', $postArr[$key][1]);
            if(!${$postArr[$key][0]}){
                $errors[] = str_replace(array('cs', '_'), array('', ' '), $postArr[$key][0]) . ', ';
            }
        }

        if(!empty($errors)) {
            foreach($errors as $error){ $message .= $error; }
            echo json_encode(array('code' => 0, 'message' => $message . ' can\'t be empty'));
            exit();
        }


        $connection = $dbhandler->connectDB();
        $stmt = $connection->prepare("SELECT cs_offer_id FROM cs_offers WHERE cs_bidding_id = ? AND cs_user_id = ?");
        $stmt->bind_param("ii", $cs_bidding_id, $cs_user_id);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows();
        $stmt->close();

        if(!empty($result)){
            echo json_encode(array('code' => 0, 'message' => 'You have already submitted an offer on this bidding thread.'));
            exit();
        }
        
        $columns = 'cs_bidding_id, cs_user_id, cs_offer';
        $placeholder = '?,?,?';
        $bindings = 'iis';
        $cs_offer_array = array(
            'product' => $cs_offer_product, 
            'qty'     => $cs_offer_qty,
            'price'   => $cs_offer_price
        );
        $cs_offer_array = serialize($cs_offer_array);
        $values = array($cs_bidding_id, $cs_user_id, $cs_offer_array);

        $offerArray = array($columns, $placeholder, $bindings, $cs_offer_array);
        $message = $offer->postOffer($offerArray);

        break;
}

echo $message;