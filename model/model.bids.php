<?php

class Bids extends DBHandler {

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

    public function getAllBids(){

        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT * FROM cs_biddings ORDER BY cs_bidding_expiration DESC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function checkOwnership($selector, $userId){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_biddings WHERE cs_bidding_user_id = ? AND cs_bidding_permalink = ?");
        $stmt->bind_param('is', $userId, $selector);
        $stmt->execute();
        $result = $stmt->get_result()->num_rows;
        $stmt->close();
        return (empty($result)) ? false : true;
    }

    public function getBid($id, $param = false){
        
        $connection = $this->getconn();
        $stmt = $connection->prepare("
            SELECT 
            b.*, 
            p.*,
            c.cs_category_name,
            AVG(r.cs_rating) AS cs_owner_rating,
            COUNT(r.cs_rating) AS cs_rated
            FROM cs_biddings b 
            LEFT JOIN cs_products_in_biddings p ON
            p.cs_bidding_id = b.cs_bidding_id
            LEFT JOIN cs_categories c ON
            c.cs_category_id = b.cs_bidding_category_id
            LEFT JOIN cs_user_ratings r ON
            r.cs_user_rated_id = b.cs_bidding_user_id
            WHERE b.cs_bidding_permalink = ? ");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $param ? $result[0][$param] : $result;
    }

    
    public function getBiddingDate($date){
        $date = date_create($date);
        return date_format($date, 'jS  \o\f\ F Y');
    }

    public function getBiddings($filter = array()){
        $connection = $this->getconn();
        $query = "SELECT  
        b.cs_bidding_title, b.cs_bidding_permalink, 
        b.cs_bidding_added, b.cs_bidding_location,
        b.cs_bidding_details, b.cs_bidding_picture,
        AVG(r.cs_rating) AS cs_owner_rating, 
        COUNT(r.cs_rating) AS cs_rated,
        c.cs_category_name  
        FROM cs_biddings b LEFT JOIN cs_user_ratings r ON b.cs_bidding_user_id = r.cs_user_rated_id LEFT JOIN cs_categories c ON b.cs_bidding_category_id = c.cs_category_id WHERE b.cs_bidding_status = 1";
        
        if(!empty($filter)) { $query .= " ".$filter[0];}

        $query .= " GROUP BY cs_bidding_id ORDER BY cs_owner_rating DESC, cs_bidding_title ASC";

        $stmt = $connection->prepare($query);
        if(!empty($filter)) {
            $stmt->bind_param($filter[1], ...$filter[2]);
        }
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;

    }

    public function getUserBids($user_id, $status = 0){
        $passedId = (int)$user_id;
        $connection = $this->getconn();
        
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_title, cs_bidding_permalink, cs_bidding_status, cs_bidding_added FROM cs_biddings WHERE cs_bidding_user_id = ? AND cs_bidding_status = $status ORDER BY cs_bidding_id DESC");
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

    public function isDeletable($selector){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_status FROM cs_biddings WHERE cs_bidding_permalink = ? LIMIT 1");
        $stmt->bind_param('s', $selector);
        $stmt->execute();
        $biddingId = $stmt->get_result()->fetch_row();
        $stmt->close();

        if($biddingId[1] == 2) { return true; }

        if(empty($biddingId)) { return false; }

        if(!$this->hasOpenBid($biddingId[0])) { return false; }

        return true;
    }

    public function hasOpenBid($biddingId) {
        
        $connection = $this->getconn();

        $stmt = $connection->prepare("SELECT cs_offer_status, cs_offer_success FROM cs_offers WHERE cs_bidding_id = '$biddingId'");
        $stmt->execute();
        $offers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(empty($offers)) { return false; }

        foreach($offers as $key => $value) {
            if($offers[$key]["cs_offer_status"] == 1 && $offers[$key]["cs_offer_success"] == 0) {
                return true;
            }
        }

        return false;
    }

    public function hasOnlyClosedBid($biddingId) {
        
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_offer_status, cs_user_id FROM cs_offers WHERE cs_bidding_id = '$biddingId'");
        $stmt->execute();
        $offers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(empty($offers)) { return false; }

        foreach($offers as $key => $value) {
            if($offers[$key]["cs_offer_status"] == 1) {
                return false;
            }
        }
        return $offers;
    }

    public function hasWinner($biddingId){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_offer_owner_id, cs_offer FROM cs_bidding_winners WHERE cs_bidding_id = ?");
        $stmt->bind_param('i', $biddingId);
        $stmt->execute();
        $hasWinner = ($stmt->get_result()->fetch_row()) ?: false;
        $stmt->close();
        
        if(!$hasWinner) { return false; }

        $stmt = $connection->prepare("SELECT cs_user_name, cs_user_avatar FROM cs_users WHERE cs_user_id = ?");
        $stmt->bind_param('i', $hasWinner[0]);
        $stmt->execute();
        $hasWinner[] = $stmt->get_result()->fetch_row();
        $stmt->close();

        return $hasWinner;

    }

    public function getDashboardCounts($user_id) {
        
        $user_id = (int)$user_id;

        $connection = $this->getconn();
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

        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_biddings WHERE  cs_bidding_status = 2 AND cs_bidding_user_id = '$user_id'");
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

        date_default_timezone_set('Asia/Manila');
        $currentDateTime = date('Y-m-d H:i:s');
        $nextweek = date('Y-m-d H:i:s', strtotime('+1 week'));
        
        $connection = $this->getconn();
        $stmt = $connection->prepare("INSERT INTO cs_biddings($prepArray[0]) VALUES($prepArray[1], '$currentDateTime', '$nextweek', 1)");
        $stmt->bind_param($prepArray[2], ...$prepArray[3]);
        $stmt->execute();
        $stmt->store_result();
        $bidding_id = $stmt->insert_id;
        $stmt->close();
        
        return $this->postProductInBidding($prodArray, $bidding_id, $prepArray[3][3]);

    }

    public function postProductInBidding($prodArray, $bidding_id, $link){
        
        $connection = $this->getconn();
        $stmt = $connection->prepare("INSERT INTO cs_products_in_biddings(cs_bidding_id, $prodArray[0]) VALUES($bidding_id, $prodArray[1])");
        $stmt->bind_param($prodArray[2], ...$prodArray[3]);
        $result = $stmt->execute();
        $stmt->close();
        
        if($result){
            return json_encode(array('code' => 2, 'message' => 'Bidding Successfully posted.', 'link' => $link));
        }
        return json_encode(array('code' => 0, 'message' => 'Uh oh. Something went wrong :('));

    }
    
    /**
     * Put related functions
     * goes here
     */

    public function biddingExpires(){
    
        date_default_timezone_set('Asia/Manila');
        $currentDateTime = date('Y-m-d');
        $currentDateTimeStamp = date('Y-m-d H:i:s');

        $connection = $this->getconn();
        $stmt = $connection->prepare("UPDATE cs_biddings SET cs_bidding_status = '0' WHERE DATE(cs_bidding_date_needed) <= '$currentDateTime' AND cs_bidding_status = '1'");
        $stmt->execute();
        $stmt->close();

        $stmt = $connection->prepare("SELECT cs_bidding_user_id, cs_bidding_title, cs_bidding_permalink FROM cs_biddings WHERE cs_bidding_status = 0 AND cs_expired_notif = 0");
        $stmt->execute();
        $toNotif = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(!empty($toNotif)){
            $list = array();
            foreach($toNotif as $key=>$value){
                $id = $toNotif[$key]["cs_bidding_user_id"];
                $list[] = $id;
                $link = $toNotif[$key]['cs_bidding_permalink'];
                $notification = "Bidding: <a data-to=\"bid/$link\"><b>".$toNotif[$key]["cs_bidding_title"] . "</b></a> has expired.";
                $stmt = $connection->prepare("INSERT INTO cs_notifications(cs_notif, cs_user_id, cs_added) VALUES('$notification', '$id', '$currentDateTimeStamp')");
                $stmt->execute();
                $stmt->close();
            }

            $stmt = $connection->prepare("UPDATE cs_biddings SET cs_expired_notif = 1 WHERE cs_bidding_user_id IN (".implode(',', $list).")");
            $stmt->execute();
            $stmt->close();
        }

        return json_encode(array('code' => 1, 'message' => 'Bidding ended.'));
    }

    
    public function biddingFinish($userId, $selector){

        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_title, cs_bidding_permalink FROM cs_biddings WHERE cs_bidding_user_id = ? AND cs_bidding_permalink = ?");
        $stmt->bind_param("is", $userId, $selector);
        $stmt->execute();
        $bidding = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($bidding)) { return json_encode(array('code' => 0, 'message' => 'Bidding not found'));  }

        $biddingId = $bidding[0];
    
        if($this->hasOpenBid($biddingId)) { 
            return json_encode(array('code' => 0, 'message' => 'Please finalize opened proposals first.')); 
        }
        
        $offers = $this->hasOnlyClosedBid($biddingId);
        
        if($offers) {

            date_default_timezone_set('Asia/Manila');
            $currentDateTimeStamp = date('Y-m-d H:i:s');

            foreach($offers as $key=>$value){
                $id = $offers[$key]["cs_user_id"];
                $notification = "Bidding: <a data-to=\"bid/$bidding[2]\"><b>".$bidding[1] . "</b></a> has ended - No Supplier has won the bidding. Client rejected all proposals";
                $stmt = $connection->prepare("INSERT INTO cs_notifications(cs_notif, cs_user_id, cs_added) VALUES('$notification', '$id', '$currentDateTimeStamp')");
                $stmt->execute();
                $stmt->close();

            }
        }
        
        $stmt = $connection->prepare("UPDATE cs_biddings SET cs_bidding_status = 2 WHERE cs_bidding_user_id = ? AND cs_bidding_id = ?");
        $stmt->bind_param("ii", $userId, $biddingId);
        $stmt->execute();
        $stmt->close();

        $stmt = $connection->prepare("UPDATE cs_offers SET cs_offer_status = 2 WHERE cs_bidding_id = ? AND cs_offer_status = 0");
        $stmt->bind_param("i", $biddingId);
        $stmt->execute();
        $stmt->close();

        return json_encode(array('code' => 1, 'message' => 'Bidding marked as \'completed\'.'));
    }

    /**
     * Delete related functions
     * goes here
     */

    public function deleteBid($selector, $userId){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_picture FROM cs_biddings WHERE (cs_bidding_user_id = ? AND cs_bidding_permalink = ? AND cs_bidding_status = 2)");
        $stmt->bind_param('is', $userId, $selector);
        $stmt->execute();
        $exist = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($exist)){
            return json_encode(array('code' => 0, 'message' => 'Unable to delete bidding. Please mark it as \'complete\'.'));
        }

        $image = '../static/asset/bidding/'.$exist[1];

        if(file_exists($image)){
            unlink($image);
        }

        $stmt = $connection->prepare("UPDATE cs_offers SET cs_offer_status = 2 WHERE cs_bidding_id = ? AND cs_offer_status = 0");
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