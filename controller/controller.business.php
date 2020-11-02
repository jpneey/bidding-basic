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
$conn = $dbhandler->connectDB();
$user = new User($conn);
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
        $cs_bidding_tags = "";

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

    case "product-delete":
        $cs_user_id = $__user_id;
        $toDelete = Sanitizer::filter('to-d', 'post', 'int');
        $message = $business->deleteProduct($toDelete, $cs_user_id);
        break;

    case "product-update":

        $cs_product_id = Sanitizer::filter('cs_product_id', 'post', 'int');
        $cs_category_id = Sanitizer::filter('cs_category_id', 'post');
        $cs_user_id = $__user_id;
        $cs_product_name = Sanitizer::filter('cs_product_name', 'post');
        $cs_product_details = Sanitizer::filter('cs_product_details', 'post');
        
        $cs_product_price = Sanitizer::filter('cs_product_price', 'post');
        $cs_sale_price = (Sanitizer::filter('cs_sale_price', 'post')) ?: $cs_product_price;
        $cs_unit = Sanitizer::filter('cs_unit', 'post');
        $cs_product_permalink = strtolower(Sanitizer::url($cs_product_name) . '-' . $cs_user_id.Sanitizer::generatePassword(3));
        $cs_link = "#!";
        $cs_link_text = "Add to Cart";

        $response = $business->updateBusinessProduct($cs_category_id, $cs_user_id, $cs_product_name, $cs_product_details, $cs_product_price, $cs_sale_price, $cs_unit, $cs_product_permalink, $cs_link, $cs_link_text, $cs_product_id);
        $message = $response;
        break;

    case "product-image":

        $cs_user_id = $__user_id;
        $cs_product_id = Sanitizer::filter('cs_product_id', 'post', 'int');
        $cs_product_old_image = Sanitizer::filter('cs_product_old_image', 'post');
        $cs_product_image = '#!';
        if (
            FileValidator::isUploaded('cs_product_image') &&
            FileValidator::allowedSize('cs_product_image', 3000000) &&
            FileValidator::allowedType('cs_product_image', array('jpg', 'png', 'jpeg', 'gif'))
        ) {
            $directory = '../static/asset/product/';
            $cs_product_image = FileValidator::rename('prod', 'cs_product_image');

            if (!FileValidator::upload($directory, 'cs_product_image', $cs_product_image)) {
                $message = "File Upload(".$cs_product_image.") failed!";
                echo json_encode(array('code' => 0, 'message' => $message));
                exit();
            } 
        }

        $cs_product_image = Sanitizer::sanitize($cs_product_image);
        $message = $business->updateProductImage($cs_user_id, $cs_product_id, $cs_product_old_image, $cs_product_image);
    
        break;

    case "product":

        $cs_category_id = Sanitizer::filter('cs_category_id', 'post');
        $cs_user_id = $__user_id;
        $cs_product_name = Sanitizer::filter('cs_product_name', 'post');
        $cs_product_details = Sanitizer::filter('cs_product_details', 'post');

        $cs_product_image = '#!';
        if (
            FileValidator::isUploaded('cs_product_image') &&
            FileValidator::allowedSize('cs_product_image', 3000000) &&
            FileValidator::allowedType('cs_product_image', array('jpg', 'png', 'jpeg', 'gif'))
        ) {
            $directory = '../static/asset/product/';
            $cs_product_image = FileValidator::rename('prod', 'cs_product_image');

            if (!FileValidator::upload($directory, 'cs_product_image', $cs_product_image)) {
                $message = "File Upload(".$cs_product_image.") failed!";
                echo json_encode(array('code' => 0, 'message' => $message));
                exit();
            } 
        }

        $cs_product_image = Sanitizer::sanitize($cs_product_image);

        $cs_product_price = Sanitizer::filter('cs_product_price', 'post');
        $cs_sale_price = (Sanitizer::filter('cs_sale_price', 'post')) ?: $cs_product_price;
        $cs_unit = Sanitizer::filter('cs_unit', 'post');
        $cs_product_permalink = strtolower(Sanitizer::url($cs_product_name) . '-' . $cs_user_id.Sanitizer::generatePassword(3));
        $cs_link = "#!";
        $cs_link_text = "Add to Cart";
        $response = $business->addBusinessProduct($cs_category_id, $cs_user_id, $cs_product_name, $cs_product_details, $cs_product_image, $cs_product_price, $cs_sale_price, $cs_unit, $cs_product_permalink, $cs_link, $cs_link_text);
        $message = $response;
        break;
}

echo $message;