<?php

require_once "./controller.auth.php";
require_once "./controller.sanitizer.php";
require_once "./controller.database.php";
require_once "./controller.filevalidator.php";
require_once "../model/model.user.php";
require_once "../model/model.bids.php";
require_once "../model/model.constant.php";

$auth = new Auth();
$dbhandler = new DBHandler();
$user = new User();
$bid = new Bids();

$connection = $dbhandler->connectDB();
$action = Sanitizer::filter('action', 'get');

switch ($action) {

    case 'add':
        
        if(!$auth->compareSession('auth', true) && $auth->compareSession('__user_role', 1)){
            echo json_encode(array('code' => 0, 'message' => 'Oh no! You need to login to perform this action.'));
            exit();
        }

        $safeImage = '#!';
        $uploaded = false;
        if (
            FileValidator::isUploaded('cs_bidding_picture') &&
            FileValidator::allowedSize('cs_bidding_picture', 3000000) &&
            FileValidator::allowedType('cs_bidding_picture', array('jpg', 'png', 'jpeg', 'gif'))
        ) {
            $directory = '../static/asset/bidding/';
            $safeImage = FileValidator::rename('jp', 'cs_bidding_picture');

            if (!FileValidator::upload($directory, 'cs_bidding_picture', $safeImage)) {
                $message = "File Upload(".$safeImage.") failed!";
                echo json_encode(array('code' => 0, 'message' => $message));
                exit();
            }
            $uploaded = true;   
        }

        $_POST['cs_bidding_picture'] = Sanitizer::sanitize($safeImage);
        $_POST['cs_bidding_user_id'] = $auth->getSession('__user_id');
        $_POST['cs_bidding_category_id'] = '1';
        $cs_bidding_permalink = strtolower(str_replace(' ', '-', filter_var(trim(preg_replace("/[^A-Za-z0-9 ]/", '', $_POST['cs_bidding_title'])), FILTER_SANITIZE_STRING)));

        $today = date("Y-m-d H:i:s");
        $expiration = date("Y-m-d H:i:s", strtotime("+7 day"));
        $prod_bind_param_type = $bind_param_type = $message = "";
        $errors = $prod_bind_param_variables = $bind_param_variables = array();

        $cs_bidding_permalink_like = "%{$cs_bidding_permalink}%";
        $stmt = $connection->prepare("SELECT * FROM cs_biddings WHERE cs_bidding_permalink LIKE ?");
        $stmt->bind_param("s", $cs_bidding_permalink_like);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows;
        $stmt->close();

        if(!empty($result)){
            if(!empty($_POST['cs_bidding_title'])) {
                $cs_bidding_permalink .= '-'.($result + 1);
            }
        }

        $_POST['cs_bidding_permalink'] = $cs_bidding_permalink;

        $postArr = array(
            array("cs_bidding_category_id", "int", "i", "post"),
            array("cs_bidding_user_id", "int", "i", "post"),
            array("cs_bidding_title", "str", "s", "post"),
            array("cs_bidding_permalink", "str", "s", "post"),
            array("cs_bidding_picture", "str", "s", "post"),
            array("cs_bidding_details", "str", "s", "post"),
            array("cs_bidding_tags", "str", "s", "post"),
            array("cs_bidding_location", "str", "s", "post"),
            array("cs_bidding_date_needed", "str", "s", "post")
        );

        $tableCol = "";
        foreach($postArr as $key => $value){
            $tableCol .= $postArr[$key][0] . ', ';
            ${$postArr[$key][0]} = Sanitizer::filter($postArr[$key][0], $postArr[$key][3], $postArr[$key][1]);
            if(!${$postArr[$key][0]}){
                $errors[] = str_replace(array('cs', '_'), array('', ' '), $postArr[$key][0]) . ', ';
            }

            $bind_param_type .= $postArr[$key][2];
            $bind_param_variables[] = ${$postArr[$key][0]};
        }

        $productTableCol = '';
        $productArray = array(
            array("cs_product_name",  "str", "s", "post"),
            array("cs_product_unit",  "str", "s", "post"),
            array("cs_product_qty",  "int", "i", "post"),
            array("cs_product_price", "str", "s", "post")
        );

        foreach($productArray as $key => $value){
            
            $productTableCol .= $productArray[$key][0] . ', ';
            ${$productArray[$key][0]} = Sanitizer::filter($productArray[$key][0], $productArray[$key][3], $productArray[$key][1]);
            if(!${$postArr[$key][0]}){
                $errors[] = str_replace(array('cs', '_'), array('', ' '), $productArray[$key][0]) . ', ';
            }
                
            $prod_bind_param_type .= $productArray[$key][2];
            $prod_bind_param_variables[] = ${$productArray[$key][0]};
        }

        $cs_bidding_permalink = Sanitizer::url($cs_bidding_permalink);
        $cs_bidding_date_needed = date('Y-m-d H:i:s', strtotime($cs_bidding_date_needed));

        if(strtotime($cs_bidding_date_needed) > strtotime($expiration)){
            if($uploaded){ unlink($directory.$cs_bidding_picture);}
            echo json_encode(array('code' => 0, 'message' => 'Your expected date exceeds your post\'s expiration!'));
            exit();
        }

        if(!empty($errors)) {
            if($uploaded){ unlink($directory.$cs_bidding_picture);}
            foreach($errors as $error){ $message .= $error; }
            echo json_encode(array('code' => 0, 'message' => $message . ' can\'t be empty'));
            exit();
        }

        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_biddings WHERE cs_bidding_user_id = ? AND cs_bidding_status != '0'");
        $stmt->bind_param("i", $cs_bidding_user_id);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows();
        $stmt->close();

        if(4 <= $result){
            if($uploaded){ unlink($directory.$cs_bidding_picture);}
            echo json_encode(array('code' => 0, 'message' => 'Your account exceeds the current active bidding limit :('));
            exit();
        }

        $stmt = $connection->prepare("SELECT * FROM cs_biddings WHERE cs_bidding_permalink = ?");
        $stmt->bind_param("s", $cs_bidding_permalink);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows();
        $stmt->close();
        
        $clause = implode(',', array_fill(0, count($postArr), '?'));
        $prodClause = implode(',', array_fill(0, count($productArray), '?'));

        $prepTableCol = $tableCol . 'cs_bidding_added, cs_bidding_expiration, cs_bidding_status';
        $prodTableCol = substr(trim($productTableCol), 0, -1);

        $bidArray  = array($prepTableCol, $clause, $bind_param_type, $bind_param_variables);
        $prodArray = array($prodTableCol, $prodClause, $prod_bind_param_type, $prod_bind_param_variables);

        $message = $bid->postBidding($bidArray, $prodArray);

        break;

    case 'get':
        $message = json_encode($bid->getBid($_GET['id']));
        break;

    case 'delete':
        
        $selector = Sanitizer::filter('selector', 'get');
        if(!$auth->compareSession('auth', true) && $auth->compareSession('__user_role', 1) || !$selector){
            echo json_encode(array('code' => 0, 'message' => 'You are unauthorized to perform this action.'));
            exit();
        }
        $userId = $auth->getSession('__user_id');
        $message = $bid->deleteBid($selector, $userId);
        break;
        
    case 'expires':
        $message = $bid->biddingExpires();
}

echo $message;