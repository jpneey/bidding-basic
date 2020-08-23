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
            $stmt = $connection->prepare("SELECT cs_offer_id, cs_user_id, cs_offer, cs_offer_price, cs_date_added, cs_offer_status FROM cs_offers WHERE cs_bidding_id = ? ORDER BY cs_offer_price ASC");
            $stmt->bind_param('i', $biddingId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            foreach($result as $key=>$value) {
                $userId = $result[$key]['cs_user_id'];
                $stmt = $connection->prepare("SELECT AVG(cs_rating) FROM cs_user_ratings WHERE cs_user_rated_id = '$userId'");
                $stmt->execute();
                $rating = $stmt->get_result()->fetch_row();
                $result[$key]["cs_owner_rating"] = (!empty($rating)) ? $rating[0] : 0;
                $stmt->close();
            }
        }

        return $result;
    }

    public function viewOffer($selector, $userId, $view = false){
        $connection = $this->connectDB();

        $initQuery = "SELECT * FROM cs_offers WHERE cs_offer_id = ?";
        ($view) ? $initQuery .= " AND cs_offer_status = 1 LIMIT 1" : " LIMIT 1";
        $stmt = $connection->prepare($initQuery);
        $stmt->bind_param('i', $selector);
        $stmt->execute();
        $offer = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($offer)){
            return json_encode(array('code' => 0, 'message' => 'It\'s not your fault, but something went wrong. :('));
        }
        
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_user_id, cs_bidding_title FROM cs_biddings WHERE cs_bidding_id = ? AND cs_bidding_user_id = ? LIMIT 1");
        $stmt->bind_param('ii', $offer[1], $userId);
        $stmt->execute();
        $exists = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($exists)){
            return json_encode(array('code' => 0, 'message' => 'You are not authorized to open this offer. s:'.$selector.' u:'. $userId));
        }

        if(!$view){
            
            $cs_bidder_id = (int)$offer[2];
            $cs_bid_owner_id = (int)$exists[1];
            $cs_bidding_title = $this->filter($exists[2], 'var');

            $stmt = $connection->prepare("UPDATE cs_offers SET cs_offer_status = 1 WHERE cs_offer_id = ? LIMIT 1");
            $stmt->bind_param('i', $selector);
            $stmt->execute();
            $stmt->close();

            $connection->query("INSERT INTO cs_transactions(cs_bidder_id, cs_bid_owner_id, cs_bidding_title) VALUES('$cs_bidder_id', '$cs_bid_owner_id', '$cs_bidding_title')");

            return json_encode(array('code' => 1, 'id' => $selector)); 
        }
        
        $stmt = $connection->prepare("SELECT cs_user_email FROM cs_users WHERE cs_user_id = ?");
        $stmt->bind_param("i", $offer[2]);
        $stmt->execute();
        $em = $stmt->get_result()->fetch_row();
        $stmt->close();

        $email = (!empty($em)) ? $em[0] : 'info@canvasspoint.com';

        $quickConnect = 'mailto:'.$email;

        $modal = '';
        $offers = unserialize($offer[3]);
        $modal .= '₱ '.number_format($offer[4], '2', '.', ',').' - '.$offers["product"].' '.$offers["qty"].' <b><span class="qty">{qty}</span></b>';
        $modal .= '<br>'.$offers["notes"].'';

        return json_encode(array('code' => 1, 'offer' => $modal, 'email' => $email, 'connect' => $quickConnect, 'view' => $offer[2]));

    }

    public function getViewable($userId){
        $connection = $this->connectDB();
        $userId = (int)$userId;
        $stmt = $connection->prepare("SELECT cs_allowed_view FROM cs_bidder_options WHERE cs_user_id = '$userId'");
        $stmt->execute();
        $allowed = $stmt->get_result()->fetch_row();
        $stmt->close();
        return (!empty($allowed)) ? $allowed[0] : 1;
    }

    public function getUserOffers($userId){
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT cs_offer_id, cs_bidding_id, cs_offer, cs_date_added, cs_offer_status FROM cs_offers WHERE cs_user_id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(!empty($result)) {
            foreach($result as $key=>$value) {
                $biddingId = (int)$result[$key]["cs_bidding_id"];
                $stmt = $connection->prepare("SELECT cs_bidding_title, cs_bidding_permalink FROM cs_biddings WHERE cs_bidding_id = '$biddingId' LIMIT 1");
                $stmt->execute();
                $title = $stmt->get_result()->fetch_row();
                $stmt->close();
                
                $result[$key]["cs_bidding_title"] = (!empty($title)) ? $title[0] : 'Bidding Deleted';
                $result[$key]["cs_bidding_permalink"] = (!empty($title)) ? $title[1] : '#!';
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

    public function getDashboardCounts($user_id) {
        
        $user_id = (int)$user_id;

        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_offers WHERE cs_offer_status = 0 AND cs_user_id = '$user_id'");
        $stmt->execute();
        $stmt->store_result();
        $activeCount = $stmt->num_rows;
        $stmt->close();

        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_offers WHERE cs_offer_status = 2 AND cs_user_id = '$user_id'");
        $stmt->execute();
        $stmt->store_result();
        $expiredCount = $stmt->num_rows;
        $stmt->close();

        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_offers WHERE cs_offer_status = 1 AND cs_user_id = '$user_id'");
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

    /**
     * Delete related functions
     * goes here
     */

    public function deleteOffer($selector, $userId){
        $connection = $this->connectDB();
        $stmt = $connection->prepare("DELETE FROM cs_offers WHERE cs_offer_id = ? AND cs_user_id = ?");
        $stmt->bind_param('ii', $selector, $userId);
        $stmt->execute();
        $stmt->close();
        return json_encode(array('code' => 1, 'message' => 'Submission was deleted successfully.'));

    }


}

// EOF
