<?php

class User extends DBController {

    public function getAllUsers(){
        return $this->runQuery("SELECT * FROM cs_users");
    }

    public function getUser($id, $param = false){
        $id = (int)$id;
        $value = $this->runQuery("SELECT * FROM cs_users WHERE cs_user_id = '$id' LIMIT 1");
        if($param && !empty($value)){
            return $value[0][$param];
        }
        return (empty($value)) ? 'guest' : $value;
    }

    public function getUserPicture($id){
        $id = (int)$id;
        $thisUser = $this->runQuery("SELECT * FROM cs_users WHERE cs_user_id = '$id' LIMIT 1");
        return !empty($thisUser) ? $thisUser[0]["cs_user_name"] : 'guest';
    }

    public function getUserBids($id){

        $id = (int)$id;
        $user = $this->runQuery("SELECT * FROM cs_users WHERE cs_user_id = '$id' AND cs_user_role = 'bidder' LIMIT 1");

        if(!empty($user)){
            return $this->runQuery("SELECT * FROM cs_biddings WHERE cs_bidding_user_id = '$id'");
        } else {
            return false;
        }
        
    }

}