<?php

class Bids extends DBController {

    public function getAllBids(){
        return $this->runQuery("SELECT * FROM cs_biddings ORDER BY cs_bidding_expiration DESC");
    }

    public function getBid($id){
        $id = (int)$id;
        return $this->runQuery("SELECT * FROM cs_biddings WHERE cs_bidding_id = '$id'");
    }

    public function getBiddingTitle($id){
        $id = (int)$id;
        $bid = $this->runQuery("SELECT * FROM cs_biddings WHERE cs_bidding_id = '$id' LIMIT 1");
        return !empty($bid) ? $bid[0]["cs_bidding_title"] : 'Not Found';
    }
    public function getBiddingDate($id){
        $id = (int)$id;
        $bid = $this->runQuery("SELECT * FROM cs_biddings WHERE cs_bidding_id = '$id' LIMIT 1");
        $date = !empty($bid) ? $bid[0]["cs_bidding_date_needed"] : 'Not Found';
        $date = date_create($date);
        return date_format($date, 'jS  \o\f\ F Y');
    }
    public function getBiddingPicture($id){
        $id = (int)$id;
        $bid = $this->runQuery("SELECT * FROM cs_biddings WHERE cs_bidding_id = '$id' LIMIT 1");
        return !empty($bid) ? $bid[0]["cs_bidding_picture"] : 'placholder.svg';
    }
    public function getBiddingDetails($id){
        $id = (int)$id;
        $bid = $this->runQuery("SELECT * FROM cs_biddings WHERE cs_bidding_id = '$id' LIMIT 1");
        return !empty($bid) ? $bid[0]["cs_bidding_details"] : 'Not Found';
    }
    public function getBiddingStatus($id){
        $id = (int)$id;
        $bid = $this->runQuery("SELECT * FROM cs_biddings WHERE cs_bidding_id = '$id' LIMIT 1");
        $status = !empty($bid) ? $bid[0]["cs_bidding_status"] : '0';
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
    public function getBiddingProduct($id, $qty = false){
        $id = (int)$id;
        $bid = $this->runQuery("SELECT * FROM cs_biddings WHERE cs_bidding_id = '$id' LIMIT 1");
        $data = !empty($bid) ? $bid[0]["cs_bidding_product"] : 'Not Found';
        if($qty){
            $data = 
            !empty($bid) ? $bid[0]["cs_bidding_product_qty"]
            .' '.$bid[0]["cs_bidding_product_unit"]
            .' '.$bid[0]["cs_bidding_product"] : 'Not Found'; 
        }
        return $data;
    }

}