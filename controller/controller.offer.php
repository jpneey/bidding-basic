<?php

require_once "./controller.auth.php";
require_once "./controller.sanitizer.php";
require_once "./controller.database.php";
require_once "./controller.filevalidator.php";
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

        $_POST['cs_user_id'] = $auth->getSession('__user_id');
        $_POST['cs_bidding_id'] = Sanitizer::filter('bid', 'get', 'int');
        
        $postArr = array(
            array("cs_bidding_id", "int"),
            array("cs_user_id", "int"),
            array("cs_offer_product", "str"),
            array("cs_offer_qty", "int"),
            array("cs_offer_price", "str"),
            array("cs_offer_date", "str"),
            array("cs_offer_notes", "str")
        );

        foreach($postArr as $key => $value){
            ${$postArr[$key][0]} = Sanitizer::filter($postArr[$key][0], 'post', $postArr[$key][1]);
            if(!${$postArr[$key][0]}){
                $errors[] = str_replace(array('cs', '_'), array('', ' '), $postArr[$key][0]) . ', ';
            }
        }

        if(!empty($errors)) {
            $message = '';
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

        $stmt = $connection->prepare("SELECT cs_bidding_status FROM cs_biddings WHERE cs_bidding_id = ? AND cs_bidding_status != '0'");
        $stmt->bind_param('i', $cs_bidding_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($result)){
            echo json_encode(array('code' => 0, 'message' => 'This bidding already ended.'));
            exit();
        }

        $images = array('cs_offer_image_one', 'cs_offer_image_two', 'cs_offer_image_three');

        $cs_offer_image_one = $cs_offer_image_two = $cs_offer_image_three = '#!';


        if(isset($_FILES['cs_offer_image']) && !empty($_FILES['cs_offer_image'])) {

            $totalImages = count($_FILES['cs_offer_image']['name']);
            if($totalImages > 3) {
                echo json_encode(array('code' => 0, 'message' => 'Only 3 attachments are allowed.'));
                die(); 
            }
            for( $i=0 ; $i < $totalImages ; $i++ ) {
                ${$images[$i]} = FileValidator::validateFile('cs_offer_image', 3000000, array('jpg', 'png', 'jpeg', 'gif'), 'img', '../static/asset/bidding/', true, $i);
                if(!${$images[$i]}) { 
                    echo json_encode(array('code' => 0, 'message' => 'Image Upload Failed. Images must be less than 3mb.'));
                    die(); 
                }
            }
        }
        
        $columns = 'cs_bidding_id, cs_user_id, cs_offer, cs_offer_price';
        $placeholder = '?,?,?,?';
        $bindings = 'iisd';
        $cs_offer_array = array(
            'product' => $cs_offer_product, 
            'qty'     => $cs_offer_qty,
            'date'    => $cs_offer_date,
            'notes'   => $cs_offer_notes,
            'img'     => $cs_offer_image_one,
            'img-two' => $cs_offer_image_two,
            'img-three' => $cs_offer_image_three,
        );

        
        if(!is_array($cs_offer_array)) {
            echo json_encode(array('code' => 0, 'message' => 'Something is not right. Please try reloading the page and try again.'));
            exit();
        }

        
        $cs_offer_array = serialize($cs_offer_array);

        $values = array($cs_bidding_id, $cs_user_id, $cs_offer_array, $cs_offer_price);

        $offerArray = array($columns, $placeholder, $bindings, $values);

        $message = $offer->postOffer($offerArray);

        break;

    case 'delete':
    
        $selector = Sanitizer::filter('selector', 'get');
        if(!$auth->compareSession('auth', true) && $auth->compareSession('__user_role', 2) || !$selector){
            echo json_encode(array('code' => 0, 'message' => 'You are unauthorized to perform this action.'));
            exit();
        }
        
        if(!$offer->isDeletable($selector)) {
            echo json_encode(array('code' => 0, 'message' => '
                Offers with biddings that expires in less than three(3) days can\'t be deleted until the bidding owner marks the bidding as completed
            '));
            exit();
        }

        $userId = $auth->getSession('__user_id');
        $message = $offer->deleteOffer($selector, $userId);
        break;

    case 'open':
        $selector = Sanitizer::filter('selector', 'get');
        if(!$auth->compareSession('auth', true) || !$auth->compareSession('__user_role', 1) || !$selector){
            echo json_encode(array('code' => 0, 'message' => 'You are unauthorized to perform this action.'));
            exit();
        }

        $userId = $auth->getSession('__user_id');
        $message = $offer->viewOffer($selector, $userId);
        break;

    case 'view':
        $selector = Sanitizer::filter('selector', 'get');
        if(!$auth->compareSession('auth', true) || !$selector){
            echo json_encode(array('code' => 0, 'message' => 'You are unauthorized to perform this action.'));
            exit();
        }
        $userId = $auth->getSession('__user_id');
        $message = $offer->viewOffer($selector, $userId, true);
        break;
}

echo $message;