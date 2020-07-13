<?php

class User extends DBController {

    public function getAllUsers(){
        return $this->runQuery("SELECT * FROM cs_users");
    }

    public function getUser($id){
        $id = (int)$id;
        return $this->runQuery("SELECT * FROM cs_users WHERE cs_user_id = '$id' LIMIT 1");
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