<?php

class Bids extends DBHandler {

    public function getAllBids(){

        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_biddings ORDER BY cs_bidding_expiration DESC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function getBid($id, $param = false){
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_biddings WHERE cs_bidding_id = ? or cs_bidding_permalink = ? ");
        $stmt->bind_param("is", $id, $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(!empty($result)){
            
            $biddingId = (int)$result[0]["cs_bidding_id"];

            $stmt = $connection->prepare("SELECT * FROM cs_products_in_biddings WHERE cs_bidding_id = '$biddingId'");
            $stmt->execute();
            $result[0]["cs_bidding_products"] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            $userId = (int)$result[0]["cs_bidding_user_id"];

            $stmt = $connection->prepare("SELECT cs_address_province FROM cs_user_address WHERE cs_user_id = '$userId'");
            $stmt->execute();
            $location = $stmt->get_result()->fetch_row();
            $result[0]["cs_owner_location"] = $location[0];
            $stmt->close();
            
            $stmt = $connection->prepare("SELECT AVG(cs_rating) FROM cs_user_ratings WHERE cs_user_rated_id = '$userId'");
            $stmt->execute();
            $rating = $stmt->get_result()->fetch_row();
            $result[0]["cs_owner_rating"] = $rating[0];
            $stmt->close();


        }

        return $param ? $result[0][$param] : $result;
    }

    
    public function getBiddingDate($date){
        $date = date_create($date);
        return date_format($date, 'jS  \o\f\ F Y');
    }

    public function getBiddings($status_array = array('1', '2')){

        $clause = implode(',', array_fill(0, count($status_array), '?'));
        $types = str_repeat("i", count($status_array));
        $connection = $this->connectDB();
        $filter = "ORDER BY cs_bidding_added DESC";
        $stmt = $connection->prepare(
            "SELECT 
            cs_bidding_title, 
            cs_bidding_details, 
            cs_bidding_user_id, 
            cs_bidding_permalink, 
            cs_bidding_added, 
            cs_bidding_picture, 
            cs_bidding_status  FROM cs_biddings WHERE cs_bidding_status in($clause)  $filter");
        $stmt->bind_param($types, ...$status_array);

        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        if(!empty($result)){
            $userId = (int)$result[0]["cs_bidding_user_id"];
            $stmt = $connection->prepare("SELECT cs_address_province FROM cs_user_address WHERE cs_user_id = '$userId'");
            $stmt->execute();
            $rating = $stmt->get_result()->fetch_row();
            $result[0]["cs_owner_location"] = $rating[0];
            $stmt->close();

            $stmt = $connection->prepare("SELECT AVG(cs_rating) FROM cs_user_ratings WHERE cs_user_rated_id = '$userId'");
            $stmt->execute();
            $rating = $stmt->get_result()->fetch_row();
            $result[0]["cs_owner_rating"] = $rating[0];
            $stmt->close();
        }
        return $result;

    }

    public function getUserBids($user_id){
        $passedId = (int)$user_id;
        $connection = $this->connectDB();
        
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_title, cs_bidding_status, cs_bidding_added FROM cs_biddings WHERE cs_bidding_user_id = ?");
        $stmt->bind_param('i', $passedId);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $result;
    }

    public function postBidding($prepArray, $prodArray){

        $connection = $this->connectDB();
        $stmt = $connection->prepare("INSERT INTO cs_biddings($prepArray[0]) VALUES($prepArray[1], NOW(), NOW() + INTERVAL 7 DAY, 1)");
        $stmt->bind_param($prepArray[2], ...$prepArray[3]);
        $stmt->execute();
        $stmt->store_result();
        $bidding_id = $stmt->insert_id;
        $stmt->close();
        
        return $this->postProductInBidding($prodArray, $bidding_id);

    }

    public function postProductInBidding($prodArray, $bidding_id){
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("INSERT INTO cs_products_in_biddings(cs_bidding_id, $prodArray[0]) VALUES($bidding_id, $prodArray[1])");
        $stmt->bind_param($prodArray[2], ...$prodArray[3]);
        $result = $stmt->execute();
        $stmt->close();
        
        if($result){
            return json_encode(array('code' => 1, 'message' => 'Bidding Successfully posted'));
        }
        return json_encode(array('code' => 0, 'message' => 'Uh oh. Something went wrong :('));

    }
    

}