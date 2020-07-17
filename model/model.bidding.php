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
        $stmt->bind_param("i", $id);
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
        $types = str_repeat("i", count($status_array));
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_biddings WHERE cs_bidding_status in($clause)  ORDER BY cs_bidding_added DESC");
        
        $stmt->bind_param($types, ...$status_array);

        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;

    }

    public function postBidding(){

        
        $today = date("Y-m-d H:i:s");
        $expiration = date("Y-m-d H:i:s", strtotime("+7 day"));
        $bind_param_type = $message = "";
        $errors = $bind_param_variables = array();
        $postArr = array(
            array("cs_bidding_category_id", "int", "i"),
            array("cs_bidding_user_id", "int", "i"),
            array("cs_bidding_title", "str", "s"),
            array("cs_bidding_picture", "str", "s"),
            array("cs_bidding_details", "str", "s"),
            array("cs_bidding_date_needed", "str", "s"),
            array("cs_bidding_product",  "str", "s"),
            array("cs_bidding_product_qty",  "int", "i"),
            array("cs_bidding_product_unit",  "str", "s"),
            array("cs_bidding_product_price", "float", "s")
        );

        $tableCol = "";
        foreach($postArr as $key => $value){
            
            
            $tableCol .= $postArr[$key][0] . ', ';

            ${$postArr[$key][0]} = self::filter($postArr[$key][0], 'post', $postArr[$key][1]);
            if(!${$postArr[$key][0]}){
                $errors[] = str_replace(array('cs', '_'), array('', ' '), $postArr[$key][0]) . ', ';
            }
        }

        $cs_bidding_date_needed = date('Y-m-d H:i:s', strtotime($cs_bidding_date_needed));

        if(strtotime($cs_bidding_date_needed) > strtotime($expiration)){
            return json_encode(array('code' => 0, 'message' => 'Your expected date exceeds your post\'s expiration!'));
        }
        
        if(strtotime($cs_bidding_date_needed) <= strtotime($today)){
            return json_encode(array('code' => 0, 'message' => 'Your expected date is behind the current date!\'s expiration!'));
        }

        if(!empty($errors)) {
            foreach($errors as $error){ $message .= $error; }
            return json_encode(array('code' => 0, 'message' => $message . ' can\'t be empty'));
        }

        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_biddings WHERE cs_bidding_user_id = ? AND cs_bidding_status != '0'");
        $stmt->bind_param("i", $cs_bidding_user_id);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows();
        $stmt->close();

        if(4 <= $result){
            return json_encode(array('code' => 0, 'message' => 'Your account exceeds the current active bidding limit :('));
        }
        
        $clause = implode(',', array_fill(0, count($postArr), '?'));
        $prepTableCol = $tableCol . 'cs_bidding_added, cs_bidding_expiration, cs_bidding_status';

        $stmt = $connection->prepare("INSERT INTO cs_biddings($prepTableCol) VALUES($clause, NOW(), NOW() + INTERVAL 7 DAY, 1)");
        
        foreach($postArr as $key=>$value){
            $bind_param_type .= $postArr[$key][2];
            $bind_param_variables[] = ${$postArr[$key][0]};
        }

        $stmt->bind_param($bind_param_type, ...$bind_param_variables);

        if($stmt->execute()){
            return json_encode(array('code' => 1, 'message' => 'Bidding Successfully posted'));
        }
        
        return json_encode(array('code' => 0, 'message' => 'Uh oh. Somethin went wrong :('));


    }
    

}