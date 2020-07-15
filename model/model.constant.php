<?php

class Constant {

    public static function getUserRole($user_id){
        switch($user_id){
            case '1':
                return "Bidder";
            default:
                return "Undefined";
        }
    }

    public static function getBidStatus($bid_status){
        switch($bid_status){
            case '0':
                return "Expired";
            case '1':
                return "Active";
            case '2':
                return "Featured";
            default:
                return "Undefined";
        }
    }

}