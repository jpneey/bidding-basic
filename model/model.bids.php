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

    public function checkOwnership($selector, $userId){
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_biddings WHERE cs_bidding_user_id = ? AND cs_bidding_permalink = ?");
        $stmt->bind_param('is', $userId, $selector);
        $stmt->execute();
        $result = $stmt->get_result()->num_rows;
        $stmt->close();
        return (empty($result)) ? false : true;
    }

    public function getBid($id, $param = false){
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_biddings WHERE cs_bidding_permalink = ? ");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(!empty($result)){
            
            foreach($result as $key=>$value) {

                $biddingId = (int)$result[$key]["cs_bidding_id"];

                $stmt = $connection->prepare("SELECT * FROM cs_products_in_biddings WHERE cs_bidding_id = '$biddingId'");
                $stmt->execute();
                $result[$key]["cs_bidding_products"] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                $userId = (int)$result[$key]["cs_bidding_user_id"];
                
                $stmt = $connection->prepare("SELECT AVG(cs_rating) FROM cs_user_ratings WHERE cs_user_rated_id = '$userId'");
                $stmt->execute();
                $rating = $stmt->get_result()->fetch_row();
                $result[$key]["cs_owner_rating"] = (!empty($rating)) ? $rating[0] : 0;
                $stmt->close();
            
            }

        }

        return $param ? $result[0][$param] : $result;
    }

    
    public function getBiddingDate($date){
        $date = date_create($date);
        return date_format($date, 'jS  \o\f\ F Y');
    }

    public function getBiddings($filter, $type = '', $value = array()){
        
        $status_array = array('1', '2');
        $clause = implode(',', array_fill(0, count($status_array), '?'));
        $types = str_repeat("i", count($status_array));
        $types .= $type;
        $connection = $this->connectDB();
        $query = "
            SELECT
            cs_bidding_id, 
            cs_bidding_title, 
            cs_bidding_details, 
            cs_bidding_user_id, 
            cs_bidding_permalink, 
            cs_bidding_added, 
            cs_bidding_picture, 
            cs_bidding_status,
            cs_bidding_location  FROM cs_biddings WHERE cs_bidding_status in($clause) $filter";

        $stmt = $connection->prepare($query);

        $stmt->bind_param($types, ...$status_array,...$value);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        if(!empty($result)){

            foreach($result as $key=>$value) {
                $userId = (int)$result[$key]["cs_bidding_user_id"];
                $stmt = $connection->prepare("SELECT AVG(cs_rating) FROM cs_user_ratings WHERE cs_user_rated_id = '$userId'");
                $stmt->execute();
                $rating = $stmt->get_result()->fetch_row();
                $result[$key]["cs_owner_rating"] = (!empty($rating)) ? $rating[0] : 0;
                $stmt->close();
            }
        }
        return $result;

    }

    public function getUserBids($user_id){
        $passedId = (int)$user_id;
        $connection = $this->connectDB();
        
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_title, cs_bidding_permalink, cs_bidding_status, cs_bidding_added FROM cs_biddings WHERE cs_bidding_user_id = ? ORDER BY cs_bidding_id DESC");
        $stmt->bind_param('i', $passedId);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        foreach($result as $key=>$value) {
            $biddingId = $result[$key]['cs_bidding_id'];
            $stmt = $connection->prepare("SELECT cs_user_id FROM cs_offers WHERE cs_bidding_id = '$biddingId'");
            $stmt->execute();
            $stmt->store_result();
            $count = $stmt->num_rows;
            $stmt->close();
            $result[$key]["cs_bidding_offer_count"] = $count;
        }

        return $result;
    }

    public function getDashboardCounts($user_id) {
        
        $user_id = (int)$user_id;

        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_biddings WHERE cs_bidding_status = 1 AND cs_bidding_user_id = '$user_id'");
        $stmt->execute();
        $stmt->store_result();
        $activeCount = $stmt->num_rows;
        $stmt->close();

        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_biddings WHERE cs_bidding_status = 0 AND cs_bidding_user_id = '$user_id'");
        $stmt->execute();
        $stmt->store_result();
        $expiredCount = $stmt->num_rows;
        $stmt->close();

        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_biddings WHERE  cs_bidding_user_id = '$user_id'");
        $stmt->execute();
        $stmt->store_result();
        $total = $stmt->num_rows;
        $stmt->close();


        $result = array($activeCount, $total, $expiredCount);
        return $result;
    }
    /**
     * Post related functions
     * goes here
     */

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
    
    /**
     * Put related functions
     * goes here
     */

    public function biddingExpires(){
    
        $connection = $this->connectDB();
        $stmt = $connection->prepare("UPDATE cs_biddings SET cs_bidding_status = '0' WHERE cs_bidding_date_needed < NOW()");
        $stmt->execute();
        $stmt->store_result();
        $affected = $stmt->num_rows;
        $stmt->close();
        
        return json_encode(array('code' => 1, 'message' => $affected .' bidding entry updated to expired.'));
        
    }

    /**
     * Delete related functions
     * goes here
     */

    public function deleteBid($selector, $userId){
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_picture FROM cs_biddings WHERE cs_bidding_user_id = ? AND cs_bidding_permalink = ?");
        $stmt->bind_param('is', $userId, $selector);
        $stmt->execute();
        $exist = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($exist)){
            return json_encode(array('code' => 0, 'message' => 'Unable to delete bidding. Bidding does not exists.'));
        }

        $image = '../static/asset/bidding/'.$exist[1];

        if(file_exists($image)){
            unlink($image);
        }

        $stmt = $connection->prepare("UPDATE cs_offers SET cs_offer_status = 2 WHERE cs_bidding_id = ?");
        $stmt->bind_param('i', $exist[0]);
        $stmt->execute();
        $stmt->close();

        $stmt = $connection->prepare("DELETE FROM cs_biddings WHERE cs_bidding_user_id = ? AND cs_bidding_permalink = ?");
        $stmt->bind_param('is', $userId, $selector);
        $stmt->execute();
        $stmt->close();

        $stmt = $connection->prepare("DELETE FROM cs_products_in_biddings WHERE cs_bidding_id = ?");
        $stmt->bind_param('i', $exist[0]);
        $stmt->execute();
        $stmt->close();

        return json_encode(array('code' => 1, 'message' => 'Bidding posting was deleted successfully.'));
    }

}