<?php

class Offers extends DBHandler {

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

    public function getLowestBidOffer($biddingId){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_offer, cs_offer_price, cs_date_added FROM cs_offers WHERE cs_bidding_id = ? ORDER BY cs_offer_price ASC LIMIT 1");
        $stmt->bind_param('i', $biddingId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function getBidOffers($userId, $biddingId, $supplier = false){

        $result = array();

        $connection = $this->getconn();
        if(!$supplier){
            $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_biddings WHERE cs_bidding_id = ? AND cs_bidding_user_id = ? ");
            $stmt->bind_param('ii', $biddingId, $userId);
        } else {
            $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_user_id FROM cs_biddings WHERE cs_bidding_id = ?");
            $stmt->bind_param('i', $biddingId);
        }
        $stmt->execute();
        $exists = $stmt->get_result()->fetch_row();
        $stmt->close();

        $username = NULL;

        if(!empty($exists)) {
            if(!$supplier) {
                $stmt = $connection->prepare("SELECT cs_offer_id, cs_user_id, cs_offer, cs_offer_price, cs_date_added, cs_offer_status, cs_offer_success FROM cs_offers WHERE cs_bidding_id = ? ORDER BY cs_offer_price ASC");
                $stmt->bind_param('i', $biddingId);
            } else {

                $stmt = $connection->prepare("SELECT cs_user_name FROM cs_users WHERE cs_user_id = ?");
                $stmt->bind_param("i", $exists[1]);
                $stmt->execute();
                $username = $stmt->get_result()->fetch_row();
                $stmt->close();

                $username = $username[0];

                $stmt = $connection->prepare("SELECT cs_offer_id, cs_user_id, cs_offer, cs_offer_price, cs_date_added, cs_offer_status, cs_offer_success FROM cs_offers WHERE cs_bidding_id = ? AND cs_user_id = ? ORDER BY cs_offer_price ASC");
                $stmt->bind_param('ii', $biddingId, $userId);
            }
            
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            foreach($result as $key=>$value) {
                $userId = $result[$key]['cs_user_id'];
                $stmt = $connection->prepare("SELECT AVG(cs_rating), COUNT(cs_rating) FROM cs_user_ratings WHERE cs_user_rated_id = '$userId'");
                $stmt->execute();
                $rating = $stmt->get_result()->fetch_row();
                $result[$key]["cs_owner_rating"] = (!empty($rating)) ? $rating[0] : 0;
                $result[$key]["cs_rated"] = (!empty($rating)) ? $rating[1] : 0;
                $result[$key]["cs_purchaser"] = $username;
                $stmt->close();
            }
        }

        return $result;
    }

    public function isDeletable($selector) {

        $connection = $this->getconn();
        date_default_timezone_set('Asia/Manila');
        $currentDateTime = date('Y-m-d');
    
        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_offers WHERE cs_offer_id = ?");
        $stmt->bind_param('i', $selector);
        $stmt->execute();
        $id = $stmt->get_result()->fetch_row();
        $stmt->close();

        $stmt = $connection->prepare("SELECT cs_bidding_status, DATEDIFF(DATE(cs_bidding_date_needed), '$currentDateTime') AS days FROM cs_biddings WHERE cs_bidding_id = ?");
        $stmt->bind_param('i', $id[0]);
        $stmt->execute();
        $bid = $stmt->get_result()->fetch_row();
        $stmt->close();
        
        if(!empty($bid) && $bid[1] <= 3) {
            if($bid[0] == 2) {
                return true;
            }
            return false;
        }

        return true;
    }

    public function viewOffer($selector, $userId, $view = false){
        $connection = $this->getconn();
        $supplier = false;

        $initQuery = "SELECT * FROM cs_offers WHERE cs_offer_id = ? LIMIT 1";

        /*  */

        $stmt = $connection->prepare($initQuery);
        $stmt->bind_param('i', $selector);
        $stmt->execute();
        $offer = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($offer)){
            return json_encode(array('code' => 0, 'message' => 'It\'s not your fault, but something went wrong. :(('));
        }
        
        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_bidding_user_id, cs_bidding_title, cs_bidding_permalink FROM cs_biddings WHERE cs_bidding_id = ? AND cs_bidding_user_id = ? LIMIT 1");
        $stmt->bind_param('ii', $offer[1], $userId);
        $stmt->execute();
        $exists = $stmt->get_result()->fetch_row();
        $stmt->close();

        
        $stmt = $connection->prepare("SELECT cs_bidding_user_id FROM cs_biddings WHERE cs_bidding_id = ? LIMIT 1");
        $stmt->bind_param('i', $offer[1]);
        $stmt->execute();
        $owner = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($exists) && $userId != $offer[2]){
            return json_encode(array('code' => 0, 'message' => 'You are not authorized to open this offer.'));
        }

        if($userId == $offer[2]) { $supplier = true; }

        if(!$view){

            $cs_offer_id = (int)$offer[0];
            $cs_bidding_id = (int)$offer[1];
            $cs_bidder_id = (int)$offer[2];
            $cs_offer_to_save = unserialize($offer[3]);
            $cs_offer_to_save["price"][] = $offer[4];
            $cs_offer_to_save = serialize($cs_offer_to_save);
            $cs_bid_owner_id = (int)$exists[1];
            $cs_bidding_title = $this->filter($exists[2], 'var');
            $cs_bidding_link = $this->filter($exists[3], 'var');

            if(!$this->hasWinner($cs_bidding_id)) {

                
                date_default_timezone_set('Asia/Manila');
                $currentDateTimeStamp = date('Y-m-d H:i:s');

                $stmt = $connection->prepare("INSERT INTO cs_bidding_winners(cs_offer_id, cs_bidding_id, cs_offer_owner_id, cs_bidding_owner_id, cs_offer) VALUES(?,?,?,?,?)");
                $stmt->bind_param("iiiis", $cs_offer_id, $cs_bidding_id, $cs_bidder_id, $cs_bid_owner_id, $cs_offer_to_save);
                $stmt->execute();
                $stmt->close();

                $stmt = $connection->prepare("SELECT cs_user_id FROM cs_offers WHERE cs_bidding_id = '$cs_bidding_id' AND cs_user_id != '$cs_bidder_id'");
                $stmt->execute();
                $toNotif = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                if(!empty($toNotif)) {


                    $notification = "Bidding: <a data-to=\"bid/$cs_bidding_link\"><b>".$cs_bidding_title. "</b></a> - bidding winner was chosen.";
                    foreach($toNotif as $key=>$value){
                        $id = $toNotif[$key]["cs_user_id"];
                        $stmt = $connection->prepare("INSERT INTO cs_notifications(cs_notif, cs_user_id, cs_added) VALUES('$notification', '$id', '$currentDateTimeStamp')");
                        $stmt->execute();
                        $stmt->close();
                    }
                }

                $stmt = $connection->prepare("UPDATE cs_biddings SET cs_bidding_status = 0 WHERE cs_bidding_id = ? LIMIT 1");
                $stmt->bind_param('i', $cs_bidding_id);
                $stmt->execute();
                $stmt->close();


                $notification = "Bidding: <a data-to=\"bid/$cs_bidding_link\"><b>".$cs_bidding_title. "</b></a> - Congratulations! You won the bidding!";

                $stmt = $connection->prepare("INSERT INTO cs_notifications(cs_notif, cs_user_id, cs_added) VALUES('$notification', '$cs_bidder_id', '$currentDateTimeStamp')");
                $stmt->execute();
                $stmt->close();
            }

            $stmt = $connection->prepare("UPDATE cs_offers SET cs_offer_status = 1 WHERE cs_offer_id = ? LIMIT 1");
            $stmt->bind_param('i', $selector);
            $stmt->execute();
            $stmt->close();

            $connection->query("INSERT INTO cs_transactions(cs_bidder_id, cs_bid_owner_id, cs_bidding_title, cs_bidding_id) VALUES('$cs_bidder_id', '$cs_bid_owner_id', '$cs_bidding_title', '$cs_bidding_id')");

            return json_encode(array('code' => 1, 'id' => $selector)); 
        }

        if($offer[6] != 1 && !$supplier) {
            return json_encode(array('code' => 0, 'message' => 'You are not authorized to open this offer.'));
        }
        
        $stmt = $connection->prepare("SELECT cs_user_name, cs_user_email FROM cs_users WHERE cs_user_id = ?");
        $stmt->bind_param("i", $offer[2]);
        $stmt->execute();
        $em = $stmt->get_result()->fetch_row();
        $stmt->close();

        $email = (!empty($em)) ? $em[1] : 'info@canvasspoint.com';
        $username = (!empty($em)) ? $em[0] : 'Deleted User';

        $quickConnect = 'mailto:'.$email;

        $modal = (!$supplier) ? '<h1><b>'.$username.'</b></h1>' : '';
        $offers = unserialize($offer[3]);
        $modal .= '<b>Offer:</b><br>₱ '.number_format($offer[4], '2', '.', ',').' - '.$offers["product"].' x '.$offers["qty"].' <b><span class="qty"></span></b>';
        $modal .= '<br>'.date_format(date_create($offer[5]), '\A\v\a\i\l\a\b\l\e \o\n l jS F Y');
        $modal .= '<br><br><b>Notes:</b><br>'.$offers["notes"].'';

        $image = $offers['img'];
        $image_two = $offers['img-two'];
        $image_three = $offers['img-three'];

        $bID = (!empty($owner)) ? $owner[0] : '404';

        return json_encode(array('code' => 1, 'offer' => $modal, 'email' => $email, 'connect' => $quickConnect, 'view' => $username, 'owner' => $bID, 'img' => $image, 'img_two' => $image_two, 'img_three' => $image_three));

    }

    public function hasWinner($biddingId){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_offer_owner_id FROM cs_bidding_winners WHERE cs_bidding_id = ?");
        $stmt->bind_param('i', $biddingId);
        $stmt->execute();
        $hasWinner = ($stmt->get_result()->fetch_array(MYSQLI_ASSOC)) ?: false;
        $stmt->close();
        return $hasWinner;
    }

    public function getViewable($userId){
        $connection = $this->getconn();
        $userId = (int)$userId;
        /* $stmt = $connection->prepare("SELECT cs_allowed_view FROM cs_bidder_options WHERE cs_user_id = '$userId'"); */
        $stmt = $connection->prepare("SELECT cs_to_view FROM cs_plans WHERE cs_user_id = '$userId'");
        $stmt->execute();
        $allowed = $stmt->get_result()->fetch_row();
        $stmt->close();
        return (!empty($allowed)) ? $allowed[0] : 1;
    }

    public function hasOffer($biddingId, $userId){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_offer_id FROM cs_offers WHERE cs_bidding_id = ? AND cs_user_id = ?");
        $stmt->bind_param("ii", $biddingId, $userId);
        $stmt->execute();
        $hasOffer = (empty($stmt->get_result()->fetch_row())) ? false : true;
        $stmt->close();
        return $hasOffer;
    }

    public function getUserOffers($userId, $status){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_offer_id, cs_bidding_id, cs_offer, cs_date_added, cs_offer_status FROM cs_offers WHERE cs_user_id = ? AND cs_offer_status = '$status'");
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
        $connection = $this->getconn();
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

        $connection = $this->getconn();
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
        
        date_default_timezone_set('Asia/Manila');
        $currentDateTimeStamp = date('Y-m-d H:i:s');

        $connection = $this->getconn();

        $stmt = $connection->prepare("SELECT cs_bidding_title, cs_bidding_permalink, cs_bidding_user_id FROM cs_biddings WHERE cs_bidding_id = ?");
        $stmt->bind_param("i",$offerArray[3][0]);
        $stmt->execute();
        $notifDetails = $stmt->get_result()->fetch_row();
        $stmt->close();

        $notificationMessage = "Bidding: <a data-to='bid/$notifDetails[1]/'><b>$notifDetails[0]</b></a> - Someone submitted a bid.";

        $stmt = $connection->prepare("INSERT INTO cs_notifications(cs_notif, cs_user_id, cs_added) VALUES(?,?,?)");
        $stmt->bind_param("sis", $notificationMessage,$notifDetails[2], $currentDateTimeStamp);
        $stmt->execute();
        $stmt->close();
 
        $stmt = $connection->prepare("INSERT INTO cs_offers($offerArray[0]) VALUES($offerArray[1])");
        
        $stmt->bind_param($offerArray[2], ...$offerArray[3]);
        $saved = $stmt->execute();
        $stmt->close();
        
        if($saved) {
            return json_encode(array('code' => 1, 'message' => 'Successfully posted'));
        }
        return json_encode(array('code' => 0, 'message' => 'Posting failed.'));

    }

    public function checkOwnership($selector, $userId){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_bidding_id FROM cs_biddings WHERE cs_bidding_user_id = ? AND cs_bidding_id = ?");
        $stmt->bind_param('ii', $userId, $selector);
        $stmt->execute();
        $result = $stmt->get_result()->num_rows;
        $stmt->close();
        return (empty($result)) ? false : true;
    }

    public function isPro($userId){
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_plan_id FROM cs_plans WHERE cs_user_id = ? AND cs_plan_status = 1");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->num_rows;
        $stmt->close();
        return (empty($result)) ? false : true;
    }

    public function validateActiveOffers($userId){
        $max = ($this->isPro($userId)) ? 6 : 3;
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_offer_id FROM cs_offers WHERE cs_user_id = ? AND cs_offer_status = 0");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->num_rows;
        $stmt->close();

        return ($result >= $max) ? false : true;
    }

    /**
     * Delete related functions
     * goes here
     */

    public function deleteOffer($selector, $userId){
        $connection = $this->getconn();

        $stmt = $connection->prepare("SELECT cs_bidding_id, cs_offer FROM cs_offers WHERE cs_offer_id = ? AND cs_user_id = ?");
        $stmt->bind_param('ii', $selector, $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(!empty($result)) {
            $image = unserialize($result[1]);
            $link = '../static/asset/bidding/'.$image['img'];
            if(file_exists($link)){ unlink($link);}
            $link = '../static/asset/bidding/'.$image['img-two'];
            if(file_exists($link)){ unlink($link);}
            $link = '../static/asset/bidding/'.$image['img-three'];
            if(file_exists($link)){ unlink($link);}
        }

        // send notification

        $biddingId = $result[0];

        $stmt = $connection->prepare("SELECT cs_bidding_user_id, cs_bidding_title, cs_bidding_permalink FROM cs_biddings WHERE cs_bidding_id = '$biddingId'");
        $stmt->execute();
        $notifDetails = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(!empty($notifDetails)) {
            $notificationMessage = "Bidding: <a data-to='bid/".$notifDetails[2]."'><b>".$notifDetails[1]."</b></a> - A proposal was deleted.";
            $id = $notifDetails[0];
            date_default_timezone_set('Asia/Manila');
            $currentDateTimeStamp = date('Y-m-d H:i:s');

            $stmt = $connection->prepare("INSERT INTO cs_notifications(cs_notif, cs_user_id, cs_added) VALUES(?,?,?)");
            $stmt->bind_param("sis", $notificationMessage,$id, $currentDateTimeStamp);
            $stmt->execute();
            $stmt->close();
        }

        $stmt = $connection->prepare("DELETE FROM cs_offers WHERE cs_offer_id = ? AND cs_user_id = ?");
        $stmt->bind_param('ii', $selector, $userId);
        $stmt->execute();
        $stmt->close();
        return json_encode(array('code' => 1, 'message' => 'Submission was deleted successfully.'));

    }

    public function bidStatus($userId, $biddingId) {
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT cs_bidding_status, cs_bidding_permalink FROM cs_biddings WHERE cs_bidding_id = ? AND cs_bidding_user_id = ?");
        $stmt->bind_param("ii", $biddingId, $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();
        return $result;
    }


}

// EOF
