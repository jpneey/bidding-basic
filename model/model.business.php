<?php

class Business extends DBHandler {

    private $connect;

    public function __construct($conn = null){
        if($conn) {
           $this->connect = $conn; 
        } else {
            $this->connect = $this->connectDB();
        }
    }

    public function getconn(){
        if(!$this->connect){
            $this->connect = $this->connectDB();
        }
        return $this->connect;
    }

    public function getBusinesses($filter = 'ORDER BY cs_business_id DESC'){
        
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT * FROM cs_business WHERE cs_business_status IN(1,2) $filter");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function getMaxProduct($__user_id){
        $id = (int)$__user_id;
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_to_featured FROM cs_plans WHERE cs_user_id = ? AND cs_plan_status = 1");
        $stmt->bind_param("i", $__user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return (!empty($result)) ? $result[0]["cs_to_featured"] : 0;
    }

    public function getUserBusiness($__user_id){
        $id = (int)$__user_id;
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT * FROM cs_business WHERE cs_user_id = '$id' LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($result)) {
            $result[2] = '';
            $result[4] = '';
            $result[5] = '';
            $result[7] = '';
        }

        return $result;
    }
    
    public function getBusinessProducts($__user_id){
        
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT p.*, c.cs_category_name, AVG(r.cs_rating) AS cs_owner_rating FROM cs_products p LEFT JOIN cs_categories c ON c.cs_category_id = p.cs_category_id LEFT JOIN cs_user_ratings r ON p.cs_user_id = r.cs_user_rated_id WHERE p.cs_user_id = ? GROUP BY p.cs_product_id");
        $stmt->bind_param("i", $__user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function postUserBusiness($value = array()){
        if(empty($value)){
            return json_encode(array('code' => 1, 'message' => 'Missing Value parameter'));
        }
        $connection = $this->getconn();
        $stmt = 
        $connection->prepare("INSERT INTO 
        cs_business(cs_user_id, cs_business_name, cs_business_link, 
        cs_business_tags, cs_business_featured, cs_business_status, cs_business_category)
        VALUES(?,?,?,?,'',?,?)");
        $stmt->bind_param('isssii', ...$value);
        $stmt->execute();
        $stmt->close();
        return json_encode(array('code' => 1, 'message' => 'Business Added'));
    }

    public function postUserFeatured($__user_id, $value){
        $connection = $this->getconn();
        $stmt = $connection->prepare("UPDATE cs_business SET cs_business_featured = ? WHERE cs_user_id = ?");
        $stmt->bind_param('si', $value,$__user_id);
        $stmt->execute();
        $stmt->close();
        return json_encode(array('code' => 1, 'message' => 'Featured Product Updated'));
    }

    public function updateUserBusiness($value = array()){
        if(empty($value)){
            return json_encode(array('code' => 1, 'message' => 'Missing Value parameter'));
        }
        $connection = $this->getconn();
        $stmt = $connection->prepare("UPDATE cs_business SET cs_business_name = ?, cs_business_link = ?, cs_business_tags = ?, cs_business_category = ? WHERE cs_user_id = ?");
        $stmt->bind_param('sssii', $value[1],$value[2],$value[3],$value[5],$value[0]);
        $stmt->execute();
        $stmt->close();
        return json_encode(array('code' => 1, 'message' => 'Business Updated'));
    }

    public function updateBusinessProduct($cs_category_id, $cs_user_id, $cs_product_name, $cs_product_details, $cs_product_price, $cs_sale_price, $cs_unit, $cs_product_permalink, $cs_link, $cs_link_text, $cs_product_id){
        $connection = $this->getconn();
        $stmt = $connection->prepare("UPDATE cs_products SET 
            cs_category_id = ?,
            cs_product_name = ?,
            cs_product_details = ?,
            cs_product_price = ?,
            cs_sale_price = ?,
            cs_unit = ?,
            cs_product_permalink = ?,
            cs_link = ?,
            cs_link_text = ?
            WHERE cs_product_id = ? AND cs_user_id = ?
        ");

        $stmt->bind_param("issssssssii",$cs_category_id, $cs_product_name, $cs_product_details, $cs_product_price, $cs_sale_price, $cs_unit, $cs_product_permalink, $cs_link, $cs_link_text, $cs_product_id, $cs_user_id);
        $stmt->execute();
        $stmt->close();
        return json_encode(array('code' => 2, 'message' => 'Product Updated', 'link' => '../my/business/?updated=product'));
    }

    public function addBusinessProduct($cs_category_id, $cs_user_id, $cs_product_name, $cs_product_details, $cs_product_image, $cs_product_price, $cs_sale_price, $cs_unit, $cs_product_permalink, $cs_link, $cs_link_text){
        
        error_reporting(0);
        
        $connection = $this->getconn();
        // $stmt = $connection->prepare("SELECT cs_account_status FROM cs_users WHERE cs_user_role = 2 AND cs_user_id = ?");
        $stmt = $connection->prepare("SELECT p.cs_plan_id, u.cs_user_role FROM cs_users u LEFT JOIN cs_plans p ON (u.cs_user_id = p.cs_user_id AND p.cs_plan_status = 1) WHERE u.cs_user_role = 2 AND u.cs_user_id = ?");
        $stmt->bind_param('i', $cs_user_id);
        $stmt->execute();
        $cs_account_status = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($cs_account_status) || !$cs_account_status[0]) {
            return json_encode(array('code' => 0, 'message' => 'Please upgrade to PRO'));
        }

        $stmt = $connection->prepare("SELECT cs_product_id FROM cs_products WHERE cs_user_id = ?");
        $stmt->bind_param('i', $cs_user_id);
        $stmt->execute();
        $total_products = $stmt->get_result()->num_rows;
        $stmt->close();
        $max = $this->getMaxProduct($cs_user_id);
        if($total_products > $max){
            return json_encode(array('code' => 0, 'message' => 'You\'ve reached your maximum('.$max.') amount of featured products.'));
        }

        $stmt = $connection->prepare("INSERT INTO cs_products(cs_category_id, cs_user_id, cs_product_name, cs_product_details, cs_product_image, cs_product_price, cs_sale_price, cs_unit, cs_product_permalink, cs_link, cs_link_text) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iisssssssss", $cs_category_id, $cs_user_id, $cs_product_name, $cs_product_details, $cs_product_image, $cs_product_price, $cs_sale_price, $cs_unit, $cs_product_permalink, $cs_link, $cs_link_text);
        $stmt->execute();
        $stmt->close();

        return json_encode(array('code' => 2, 'message' => 'Product Added', 'link' => '../my/business/?updated=product'));
    }

    private function deleteProductImage($cs_product_id, $cs_user_id){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_product_image FROM cs_products WHERE cs_product_id = ? AND cs_user_id = ?");
        $stmt->bind_param("ii", $cs_product_id, $cs_user_id);
        $stmt->execute();
        $image = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($image)) {
            return json_encode(array('code' => 0, 'message' => 'It looks like you are unauthorized to perform this action.'));
        }

        $link = '../static/asset/product/'.$image[0];
        if(file_exists($link) && !is_dir($link)){ unlink($link);}
    }

    public function updateProductImage($cs_user_id, $cs_product_id, $cs_product_old_image, $cs_product_image){
        $this->deleteProductImage($cs_product_id, $cs_user_id);
        $connection = $this->getconn();
        $stmt = $connection->prepare("UPDATE cs_products SET cs_product_image = ? WHERE cs_product_id = ? AND cs_user_id = ?");
        $stmt->bind_param("sii", $cs_product_image, $cs_product_id, $cs_user_id);
        $stmt->execute();
        $stmt->close();
        return json_encode(array('code' => 2, 'message' => 'Image Updated', 'link' => '../my/business/?updated=product'));
    }

    public function deleteProduct($id, $userId){

        $this->deleteProductImage($id, $userId);
        $connection = $this->getconn();
        $stmt = $connection->prepare("DELETE FROM cs_products WHERE cs_product_id = ? AND cs_user_id = ?");
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();
        $stmt->close();

        return json_encode(array('code' => 2, 'message' => 'Item permanently deleted', 'link' => '../my/business/?updated=product'));

    }

    

}