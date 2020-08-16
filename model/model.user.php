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

}