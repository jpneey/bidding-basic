<?php

class User extends DBHandler {

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
    public function getAllUsers(){

        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT * FROM cs_users");
        $stmt->execute();
    
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    
        return $this->$result;
    }

    public function getUser($id, $param = false){
        
        $passedId = (int)$id;
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT u.*, p.* FROM cs_users u LEFT JOIN cs_plans p ON (u.cs_user_id = p.cs_user_id AND p.cs_plan_status = 1) WHERE u.cs_user_id = ? GROUP BY u.cs_user_id LIMIT 1");

        $stmt->bind_param('i', $passedId);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if($param && !empty($result)){
            return $result[0][$param];
        }
        return (empty($result)) ? 'guest' : $result;
    }

    public function getPlans($userId, $expires = true, $expired_only = false){
        
        $passedId = (int)$userId;
        $connection = $this->getconn();
        $query = "SELECT p.* FROM cs_plans p WHERE p.cs_user_id = ? ORDER BY cs_plan_id DESC";
        if(!$expires) { $query = "SELECT p.* FROM cs_plans p WHERE p.cs_user_id = ? AND p.cs_plan_status != 2 ORDER BY cs_plan_id DESC"; }
        if($expired_only) { $query = "SELECT p.* FROM cs_plans p WHERE p.cs_user_id = ? AND p.cs_plan_status = 2 ORDER BY cs_plan_id DESC"; }
        $stmt = $connection->prepare($query);
        $stmt->bind_param('i', $passedId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function requestUpgrade($type, $id, $em = false, $get_id = false){
        $connection = $this->getconn();
        $passedId = (int)$id;
        $mod = "Direct Pay";
        
        $hash = $passedId . microtime(false) . $passedId . '_dp';
        switch($type){
            case "supplier":
                $toView = 0;
                $toOpen = 0;
                $toFeat = 3;
                break;
            case "client":
                $toView = 4;
                $toOpen = 4;
                $toFeat = 0;
                break;
            case "paypal-client":
                $toView = 4;
                $toOpen = 4;
                $toFeat = 0;
                $mod = "Paypal";
                $hash = ($em) ?: 'n/a';
                break;
            case "paypal-supplier":
                $toView = 0;
                $toOpen = 0;
                $toFeat = 3;
                $mod = "Paypal";
                $hash = ($em) ?: 'n/a';
                break;
        }

        
        date_default_timezone_set('Asia/Manila');
        $currentDateTime = date('Y-m-d H:i:s');

        $query = "INSERT INTO 
            cs_plans(cs_user_id, cs_plan_status, 
                    cs_to_open, cs_to_view, cs_to_featured, 
                    date_added, cs_plan_payment, cs_gateway_comment, expires) 
            VALUES (?, 0, ?, ?, ?, ?, '$mod', ?, ?)";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("iiiisss", $passedId, $toOpen, $toView, $toFeat, $currentDateTime, $hash, $currentDateTime);
        $exec = $stmt->execute();

        if($get_id) {
            $exec = $stmt->insert_id;
        }

        $stmt->close();

        return $exec;


    }

    public function hasActivePlan($userId){
        
        $passedId = (int)$userId;
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT p.* FROM cs_plans p WHERE p.cs_user_id = ? AND (p.cs_plan_status = 1 OR p.cs_plan_status = 0)");
        $stmt->bind_param('i', $passedId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return (empty($result)) ? false : true;
    }

    public function getProfile($handle){
        
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT * FROM cs_users WHERE cs_user_name = ? LIMIT 1");

        $stmt->bind_param('s', $handle);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(!empty($result)){
            $userId = $result[0]['cs_user_id'];
            $stmt = $connection->prepare("SELECT AVG(cs_rating) FROM cs_user_ratings WHERE cs_user_rated_id = '$userId'");
            $stmt->execute();
            $rating = $stmt->get_result()->fetch_row();
            $result[0]["cs_user_rating"] = (!empty($rating)) ? $rating[0] : 0;
            $stmt->close();

            $stmt = $connection->prepare("SELECT * FROM cs_user_ratings WHERE cs_user_rated_id = '$userId'");
            $stmt->execute();
            $ratings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $result[0]["cs_user_ratings"] = $ratings;
            $stmt->close();

            $stmt = $connection->prepare("SELECT cs_business_link FROM cs_business WHERE cs_user_id = '$userId' LIMIT 1");
            $stmt->execute();
            $business = $stmt->get_result()->fetch_row();
            $result[0]["cs_user_business"] = (empty($business)) ? '0' : $business[0];
            $stmt->close();
        }

        return $result;
    }

    public function getUserBids($id, $misc = false){

        $passedId = (int)$id;
        $connection = $this->getconn();
        
        $stmt = $connection->prepare("SELECT * FROM cs_biddings WHERE cs_bidding_user_id = ?");
        $stmt->bind_param('i', $passedId);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $result;
        
    }

    public function updateUserCol($userId, $column, $binding, $value, $uniq = false){
        
        $connection = $this->getconn();

        if($uniq){
            $stmt = $connection->prepare("SELECT cs_user_id FROM cs_users WHERE $column = ? AND cs_user_id != ?");
            $stmt->bind_param($binding.'i', $value, $userId);
            $stmt->execute();
            $exists = $stmt->get_result()->num_rows;
            $stmt->close();
            if(!empty($exists)){
                return false;
            }
        }
        $stmt = $connection->prepare("UPDATE cs_users SET $column = ? WHERE cs_user_id = ?");
        $stmt->bind_param($binding.'i', $value, $userId);
        $execute = $stmt->execute();
        $stmt->close();
        return $execute;
    }

    public function getTransactions($userId, $role = 1){

        switch($role) {
            case '1':        
                $role_condition = "cs_bid_owner_id = ?";
                $role_condition_join = "u.cs_user_id = t.cs_bidder_id"; 
                break;
            default:
                $role_condition = "cs_bidder_id = ?";
                $role_condition_join = "u.cs_user_id = t.cs_bid_owner_id"; 
                break;
        }

        $connection = $this->getconn();
        $stmt = $connection->prepare(
        "SELECT 
        t.cs_bidder_id, 
        t.cs_bid_owner_id, 
        t.cs_bidding_title,
        u.cs_user_name 
        FROM cs_transactions t 
        INNER JOIN cs_users u ON $role_condition_join 
        WHERE $role_condition");

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $transaction = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(empty($transaction)) { return false; }

        return $transaction;
    }

    public function getRating($from, $to){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_rating_id, cs_rating, cs_comment FROM cs_user_ratings WHERE cs_user_id = ? AND cs_user_rated_id = ?");
        $stmt->bind_param('ii', $from, $to);
        $stmt->execute();
        $rating = $stmt->get_result()->fetch_row();
        $stmt->close();
        $mode = 'insert';
        $comment = '';
        $id = $rate = 0;
        if(!empty($rating)) {
            $mode = 'update';
            $id = $rating[0];
            $rate = $rating[1];
            $comment = $rating[2];
        }
        return json_encode(array('code' => 1, 'mode' => $mode, 'id' => $id, 'rate' => $rate, 'comment' => $comment));
    }

    public function postRating($from, $to, $rate, $comment){
        $connection = $this->getconn();
        $stmt = $connection->prepare("INSERT INTO cs_user_ratings(cs_user_id, cs_user_rated_id, cs_rating, cs_comment) VALUES(?,?,?,?)");
        $stmt->bind_param('iiis', $from, $to, $rate, $comment);
        if($stmt->execute()){
            return json_encode(array('code' => 1, 'message' => 'Thank you for making canvasspoint a better place.'));
        }
        $stmt->close();
        return json_encode(array('code' => 0, 'message' => 'Uh oh. Something went wrong :('));
    }

    public function successTransaction($transactionId, $value){
        $connection = $this->getconn();
        $stmt = $connection->prepare("UPDATE cs_offers SET cs_offer_success = ? WHERE cs_offer_id = ?");
        $stmt->bind_param('ii', $value, $transactionId);
        $stmt->execute();
    }

    public function updateRating($from, $to, $rate, $comment){
        $connection = $this->getconn();
        $stmt = $connection->prepare("UPDATE cs_user_ratings SET cs_rating = ?, cs_comment = ? WHERE cs_user_id = ? AND cs_user_rated_id = ?");
        $stmt->bind_param('isii', $rate, $comment, $from, $to);
        if($stmt->execute()){
            return json_encode(array('code' => 1, 'message' => 'Thank you for making canvasspoint a better place.'));
        }
        $stmt->close();
        return json_encode(array('code' => 0, 'message' => 'Uh oh. Something went wrong :('));
    }

    public function readNotifs($id, $t){
        $query = "UPDATE cs_notifications SET cs_notif_read = 1 WHERE cs_user_id = ? AND cs_notif_read != 1";
        if($t) {
            $t = (int)$t;
            $query .= " AND cs_notif_id = '$t'";
        }
        $connection = $this->getconn();
        $stmt = $connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return true;
    }

    public function deleteNotifs($id, $all = false){
        $query = "DELETE FROM cs_notifications WHERE cs_user_id = ? AND cs_notif_read = 1";
        if($all){ $query = "DELETE FROM cs_notifications WHERE cs_user_id = ?"; }
        $connection = $this->getconn();
        $stmt = $connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
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

    public function deleteUser($userId){
        $connection = $this->getconn();
        $query = "SELECT cs_user_avatar FROM cs_users WHERE cs_user_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(!empty($result)) {
            if(file_exists('../static/asset/user/'.$result[0])) {
                unlink('../static/asset/user/'.$result[0]);
            }
        }

        $query = "DELETE FROM cs_users WHERE cs_user_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->close();

        $this->deleteUserOffer($userId);
        $this->deleteUserBid($userId);
        $this->deleteUserProducts($userId);
        $this->deleteNotifs($userId, true);
    }

    public function deleteUserOffer($userId){
        
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_offer FROM cs_offers WHERE cs_user_id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(!empty($result)) {
            foreach($result as $key => $value) {
                $image = unserialize($result[$key]["cs_offer"]);
                $link = '../static/asset/bidding/'.$image['img'];
                if(file_exists($link)){ unlink($link);}
                $link = '../static/asset/bidding/'.$image['img-two'];
                if(file_exists($link)){ unlink($link);}
                $link = '../static/asset/bidding/'.$image['img-three'];
                if(file_exists($link)){ unlink($link);}
            }
        }

        $stmt = $connection->prepare("DELETE FROM cs_offers WHERE cs_user_id = ?");
        $stmt->bind_param('i',$userId);
        $exec = $stmt->execute();
        $stmt->close();
        return ($exec) ?: false;
    }


    public function deleteUserBid($userId){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_picture FROM cs_biddings WHERE cs_bidding_user_id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $exist = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        foreach($exist as $key => $value){

            $image = '../static/asset/bidding/'.$exist[$key]["cs_bidding_picture"];
            $biddingId = $exist[$key]["cs_bidding_id"];
            
            if(file_exists($image)){ unlink($image); }

            $stmt = $connection->prepare("DELETE FROM cs_products_in_biddings WHERE cs_bidding_id = ?");
            $stmt->bind_param('i', $biddingId);
            $stmt->execute();
            $stmt->close();

            $stmt = $connection->prepare("UPDATE cs_offers SET cs_offer_status = 2 WHERE cs_bidding_id = ? AND cs_offer_status = 0");
            $stmt->bind_param('i', $biddingId);
            $stmt->execute();
            $stmt->close();
        }

        $stmt = $connection->prepare("DELETE FROM cs_biddings WHERE cs_bidding_user_id = ?");
        $stmt->bind_param('i', $userId);
        $exec = $stmt->execute();
        $stmt->close();

        return ($exec) ?: false;
    }

    public function deleteUserProducts($userId){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_product_image FROM cs_products WHERE cs_user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $image = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(!empty($image)){
            foreach($image as $key => $value){
                $link = '../static/asset/product/'.$image[$key]["cs_product_image"];
                if(file_exists($link) && !is_dir($link)){ unlink($link);}
            }
        }

        $stmt = $connection->prepare("DELETE FROM cs_products WHERE cs_user_id = ?");
        $stmt->bind_param("i", $userId);
        $exec = $stmt->execute();
        $stmt->close();

        return ($exec) ?: false;
    }

    /* site settings */

    public function getAdminEmail(){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_setting_value FROM cs_store WHERE cs_setting_name = 'admin_email' AND cs_status = 1 LIMIT 1");
        $stmt->execute();
        $email = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($email)) { return false; }
        if(!filter_var($email[0], FILTER_SANITIZE_EMAIL)) { return false; }

        return $email[0];
    }

    public function getTotalCounts(){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_setting_value FROM cs_store WHERE cs_setting_name = 'admin_home' AND cs_status = 1 LIMIT 1");
        $stmt->execute();
        $settings = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(!empty($settings)) { 
            $values = explode(',', $settings[0]);
            $index = 0;            
            foreach($values as $value){
                if(empty($value)) {
                    switch($index) {
                        case 0:
                            $values[$index] = $this->getHomeData("bids");
                            break;
                        case 1:
                            $values[$index] = $this->getHomeData("clients");
                            break;
                        case 2:
                            $values[$index] = $this->getHomeData("suppliers");
                            break;
                        case 3: 
                            $values[$index] = $this->getHomeData("bid-today");
                            break;
                    }
                }
                $index++;
            }
        } else {
            $values = array(
                $values[0] = $this->getHomeData("bids"),
                $values[1] = $this->getHomeData("clients"),
                $values[2] = $this->getHomeData("suppliers"),
                $values[3] = $this->getHomeData("bid-today")
            );
        }
        
        return $values;
    }

    public function getHomeData($kind){
        $connection = $this->getconn();
        switch($kind){
            case "bids":
                $query = "SELECT COUNT(cs_bidding_id) AS counted FROM cs_biddings";
                break;
            case "suppliers":
                $query = "SELECT COUNT(cs_user_id) AS counted FROM cs_users WHERE cs_user_role = 2";
                break;
            case "clients":
                $query = "SELECT COUNT(cs_user_id) AS counted FROM cs_users WHERE cs_user_role = 1";
                break;
            case "bid-today":
                $date = date("Y-m-d");
                $query = "SELECT COUNT(cs_bidding_id) AS counted FROM cs_biddings WHERE DATE(cs_bidding_added) = '$date'";
                break;
        }

        $stmt = $connection->prepare($query);
        $stmt->execute();
        $counted = $stmt->get_result()->fetch_row();
        $stmt->close();

        return (!empty($counted)) ? $counted[0] : 0;
    }

    public function sendMail($emailSubject, $emailPreheader, $emailGreeting, $emailContent, $emailAction, $emailActionText, $emailFooterContent, $emailRegards, $to = false){
        
        if(!$to) { $to = $this->getAdminEmail(); };
        if(!$to) { return false; }
        
        require "../controller/mail/mail.php";

        $mail->AddAddress($to);
          
        ob_start();
        require '../controller/mail/template/basic.php';
        $htmlMessage = ob_get_contents();
        ob_end_clean(); 
        
        
        $mail->Subject = $emailSubject;
        $mail->Body = $htmlMessage;

        return $mail->send();
    }
}