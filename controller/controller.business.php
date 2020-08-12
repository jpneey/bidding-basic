<?php

require_once "./controller.auth.php";
require_once "./controller.sanitizer.php";
require_once "./controller.database.php";
require_once "./controller.filevalidator.php";
require_once "../model/model.user.php";
require_once "../model/model.business.php";
require_once "../model/model.constant.php";

$auth = new Auth();
$dbhandler = new DBHandler();
$user = new User();
$business = new Business();
$connection = $dbhandler->connectDB();
$action = Sanitizer::filter('action', 'get');

if(!$auth->compareSession('auth', true) && $auth->compareSession('__user_role', 2)){
    echo json_encode(array('code' => 0, 'message' => 'Oh no! You need to login to perform this action.'));
    exit();
}
$__user_id = (int)$auth->getSession('__user_id');


switch ($action) {

    case 'update':

        $stmt = $connection->prepare("SELECT cs_business_id, cs_business_featured FROM cs_business WHERE cs_user_id = '$__user_id'");
        $stmt->execute();
        $exist = $stmt->get_result()->fetch_row();
        $stmt->close();

        $update = (!empty($exist)) ? true : false;
        
        $cs_business_name = Sanitizer::filter('cs_business_name', 'post');
        
        $cs_bussines_link = strtolower(str_replace(' ', '-', filter_var(trim(preg_replace("/[^A-Za-z0-9 ]/", '', $cs_business_name)), FILTER_SANITIZE_STRING)));
        $cs_bussines_link = Sanitizer::url($cs_bussines_link);

        $stmt = $connection->prepare("SELECT cs_business_link FROM cs_business WHERE cs_business_link = ? AND cs_user_id != '$__user_id'");
        $stmt->bind_param('s', $cs_bussines_link);
        $stmt->execute();
        $exist = $stmt->get_result()->num_rows;
        $stmt->close();

        if(!empty($exist)){
            $cs_bussines_link .= '-'.$exist;
        }

        $cs_business_category = Sanitizer::filter('cs_business_category', 'post', 'int');
        $cs_bidding_tags = Sanitizer::filter('cs_bidding_tags', 'post');

        $cs_business_status = '1';

        $businessToStore = array(
            $__user_id,
            $cs_business_name,
            $cs_bussines_link,
            $cs_bidding_tags,
            $cs_business_status,
            $cs_business_category
        );

        $message = ($update) ? $business->updateUserBusiness($businessToStore) : $business->postUserBusiness($businessToStore) ; 

        break;

    
    case 'update-product':

        $stmt = $connection->prepare("SELECT cs_business_id, cs_business_featured FROM cs_business WHERE cs_user_id = '$__user_id'");
        $stmt->execute();
        $exist = $stmt->get_result()->fetch_row();
        $stmt->close();

        $update = (!empty($exist)) ? true : false;
        
        $cs_product_image = "#!";
        $cs_product_name = Sanitizer::filter('cs_product_name', 'post');
        $cs_product_unit = Sanitizer::filter('cs_product_unit', 'post');
        $cs_product_qty = Sanitizer::filter('cs_product_qty', 'post', 'int');
        $cs_product_price = Sanitizer::filter('cs_product_price', 'post');

        if (
            FileValidator::isUploaded('cs_featured_image') &&
            FileValidator::allowedSize('cs_featured_image', 3000000) &&
            FileValidator::allowedType('cs_featured_image', array('jpg', 'png', 'jpeg', 'gif'))
        ) {
            $directory = '../static/asset/bidding/';
            $cs_product_image = FileValidator::rename('featured-product', 'cs_featured_image');

            if (!FileValidator::upload($directory, 'cs_featured_image', $cs_product_image)) {
                $message = "File Upload(".$cs_product_image.") failed!";
                echo json_encode(array('code' => 0, 'message' => $message));
                exit();
            }
            if($update){
                $featured = unserialize($exist[1]);
                if(!empty($featured)){
                    if(file_exists($directory.$featured[0])){
                        unlink($directory.$featured[0]);
                    }
                }
            }
        }

        $product = array(
            $cs_product_image,
            $cs_product_name,
            $cs_product_unit,
            $cs_product_qty,
            $cs_product_price
        );
        $productToStore = serialize($product);

        $message = $business->postUserFeatured($__user_id, $productToStore) ;
        break;

    case 'delete':
        $stmt = $connection->prepare("SELECT cs_business_id, cs_business_featured FROM cs_business WHERE cs_user_id = '$__user_id'");
        $stmt->execute();
        $exist = $stmt->get_result()->fetch_row();
        $stmt->close();

        $featured = unserialize($exist[1]);
        if(!empty($featured)){
            $directory = '../static/asset/bidding/';
            if(file_exists($directory.$featured[0])){
                unlink($directory.$featured[0]);
            }
        }

        $productToStore = serialize(array('#!', '', '', '', ''));
        $message = $business->postUserFeatured($__user_id, $productToStore) ;
        break;
}

echo $message;