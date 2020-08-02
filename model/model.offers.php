<?php

class Offers extends DBHandler {

    public function getAllOffers(){

    }

    public function getLowestBidOffer($biddingId){
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT cs_offer, cs_offer_price, cs_date_added FROM cs_offers WHERE cs_bidding_id = ? ORDER BY cs_offer_price ASC LIMIT 1");
        $stmt->bind_param('i', $biddingId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function getBidOffers($userId, $biddingId){

        $result = array();

        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_biddings WHERE cs_bidding_id = ? AND cs_bidding_user_id = ? ");
        $stmt->bind_param('ii', $biddingId, $userId);
        $stmt->execute();
        $exists = $stmt->get_result()->num_rows;
        $stmt->close();

        if(!empty($exists)) {
            $stmt = $connection->prepare("SELECT cs_user_id, cs_offer, cs_offer_price, cs_date_added, cs_offer_status FROM cs_offers WHERE cs_bidding_id = ? ORDER BY cs_offer_price ASC");
            $stmt->bind_param('i', $biddingId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();


            foreach($result as $key=>$value) {
                $userId = $result[$key]['cs_user_id'];
                $stmt = $connection->prepare("SELECT AVG(cs_rating) FROM cs_user_ratings WHERE cs_user_rated_id = '$userId'");
                $stmt->execute();
                $rating = $stmt->get_result()->fetch_row();
                $result[$key]["cs_owner_rating"] = $rating[0];
                $stmt->close();

            }
        }

        return $result;
    }

    public function getUserOffers($userId){
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_offer, cs_date_added FROM cs_offers WHERE cs_user_id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(!empty($result)) {
            foreach($result as $key=>$value) {
                $biddingId = (int)$result[$key]["cs_bidding_id"];
                $stmt = $connection->prepare("SELECT cs_bidding_title FROM cs_biddings WHERE cs_bidding_id = '$biddingId' LIMIT 1");
                $stmt->execute();
                $title = $stmt->get_result()->fetch_row();
                $stmt->close();
                $result[$key]["cs_bidding_title"] = $title[0];
            }
        }

        return $result;
    }
    
    public function getCountOffer($biddingId){
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_offers WHERE cs_bidding_id = ?");
        $stmt->bind_param('i', $biddingId);
        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
        $stmt->close();

        return $count;
    }


    /**
     * Post related functions
     * goes here
     */

    public function postOffer($offerArray){

        $connection = $this->connectDB();
        $stmt = $connection->prepare("INSERT INTO cs_offers($offerArray[0]) VALUES($offerArray[1])");
        
        $stmt->bind_param($offerArray[2], ...$offerArray[3]);
        $saved = $stmt->execute();
        $stmt->close();
        
        if($saved) {
            return json_encode(array('code' => 1, 'message' => 'Successfully posted'));
        }
        return json_encode(array('code' => 0, 'message' => 'Posting failed.'));

    }


}

// EOF
