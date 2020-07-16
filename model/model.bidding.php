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
        
        $id = (int)$id;

        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_biddings WHERE cs_bidding_id = ? ");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $param ? $result[0][$param] : $result;
    }

    
    public function getBiddingDate($date){
        $date = date_create($date);
        return date_format($date, 'jS  \o\f\ F Y');
    }

    public function getBiddingPicture($picture){
        return !empty($picture) ?: 'placholder.svg';
    }

    public function getBiddingStatus($status){
        switch($status){
            case '1':
                return 'Active';
            case '2':
                return 'Featured';
            case '0':
            default:
                return 'Expired';
        }
    }

    public function getBiddings($status_array = array('1', '2')){

        $clause = implode(',', array_fill(0, count($status_array), '?'));
        $types = str_repeat('i', count($status_array));
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_biddings WHERE cs_bidding_status in($clause)  ORDER BY cs_bidding_added DESC");
        
        $stmt->bind_param($types, ...$status_array);

        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;

    }

}