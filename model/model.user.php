<?php

class User extends DBHandler {

    
    public function getAllUsers(){

        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_users");
        $stmt->execute();
    
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    
        return $this->$result;
    }

    public function getUser($id, $param = false){
        
        $passedId = (int)$id;
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_users WHERE cs_user_id = ? LIMIT 1");

        $stmt->bind_param('i', $passedId);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if($param && !empty($result)){
            return $result[0][$param];
        }
        return (empty($result)) ? 'guest' : $result;
    }

    public function getProfile($handle){
        
        $connection = $this->connectDB();
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
        $connection = $this->connectDB();
        
        $stmt = $connection->prepare("SELECT * FROM cs_biddings WHERE cs_bidding_user_id = ?");
        $stmt->bind_param('i', $passedId);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $result;
        
    }

    public function updateUserCol($userId, $column, $binding, $value, $uniq = false){
        
        $connection = $this->connectDB();

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

        $connection = $this->connectDB();
        $stmt = $connection->prepare(
        "SELECT 
        t.cs_bidder_id, 
        t.cs_bid_owner_id, 
        t.cs_bidding_title,
        u.cs_user_name 
        FROM cs_transactions t 
        INNER JOIN cs_users u ON $role_condition_join 
        WHERE $role_condition ");

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $transaction = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(empty($transaction)) { return false; }

        return $transaction;
    }

    public function getRating($from, $to){
        $connection = $this->connectDB();
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
        $connection = $this->connectDB();
        $stmt = $connection->prepare("INSERT INTO cs_user_ratings(cs_user_id, cs_user_rated_id, cs_rating, cs_comment) VALUES(?,?,?,?)");
        $stmt->bind_param('iiis', $from, $to, $rate, $comment);
        if($stmt->execute()){
            return json_encode(array('code' => 1, 'message' => 'Thank you for making canvasspoint a better place.'));
        }
        $stmt->close();
        return json_encode(array('code' => 0, 'message' => 'Uh oh. Something went wrong :('));
    }

    public function successTransaction($transactionId, $value){
        $connection = $this->connectDB();
        $stmt = $connection->prepare("UPDATE cs_offers SET cs_offer_success = ? WHERE cs_offer_id = ?");
        $stmt->bind_param('ii', $value, $transactionId);
        $stmt->execute();
    }

    public function updateRating($from, $to, $rate, $comment){
        $connection = $this->connectDB();
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
        $connection = $this->connectDB();
        $stmt = $connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return true;
    }

}