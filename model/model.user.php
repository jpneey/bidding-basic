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

    public function getUserBids($id, $misc = false){

        $id = (int)$id;
        $user = $this->runQuery("SELECT * FROM cs_users WHERE cs_user_id = '$id' AND cs_user_role = '1' LIMIT 1");
        $query = "SELECT * FROM cs_biddings WHERE cs_bidding_user_id = '$id'";
        if($misc){
            $query .= $misc;
        }
        if(!empty($user)){
            return $this->runQuery($query);
        } else {
            return false;
        }
        
    }

}