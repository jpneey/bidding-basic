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

    public function updateUserCol($userId, $column, $binding, $value){
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("UPDATE cs_users SET $column = ? WHERE cs_user_id = ?");
        $stmt->bind_param($binding.'i', $value, $userId);
        $execute = $stmt->execute();
        $stmt->close();
        return $execute;
    }

}