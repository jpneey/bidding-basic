<?php

class Business extends DBHandler {

    public function getBusinesses($filter = 'ORDER BY cs_business_id DESC'){
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_business WHERE cs_business_status IN(1,2) $filter");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function getUserBusiness($__user_id){
        $id = (int)$__user_id;
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_business WHERE cs_user_id = '$id' LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(empty($result)) {
            $result[2] = '';
            $result[4] = '';
            $result[5] = '';
            $result[7] = '';
        }

        return $result;
    }

    public function postUserBusiness($value = array()){
        if(empty($value)){
            return json_encode(array('code' => 1, 'message' => 'Missing Value parameter'));
        }
        $connection = $this->connectDB();
        $stmt = 
        $connection->prepare("INSERT INTO 
        cs_business(cs_user_id, cs_business_name, cs_business_link, 
        cs_business_tags, cs_business_featured, cs_business_status, cs_business_category)
        VALUES(?,?,?,?,'',?,?)");
        $stmt->bind_param('isssii', ...$value);
        $stmt->execute();
        $stmt->close();
        return json_encode(array('code' => 1, 'message' => 'Business Added'));
    }

    public function postUserFeatured($__user_id, $value){
        $connection = $this->connectDB();
        $stmt = $connection->prepare("UPDATE cs_business SET cs_business_featured = ? WHERE cs_user_id = ?");
        $stmt->bind_param('si', $value,$__user_id);
        $stmt->execute();
        $stmt->close();
        return json_encode(array('code' => 1, 'message' => 'Featured Product Updated'));
    }

    public function updateUserBusiness($value = array()){
        if(empty($value)){
            return json_encode(array('code' => 1, 'message' => 'Missing Value parameter'));
        }
        $connection = $this->connectDB();
        $stmt = $connection->prepare("UPDATE cs_business SET cs_business_name = ?, cs_business_link = ?, cs_business_tags = ?, cs_business_category = ? WHERE cs_user_id = ?");
        $stmt->bind_param('sssii', $value[1],$value[2],$value[3],$value[5],$value[0]);
        $stmt->execute();
        $stmt->close();
        return json_encode(array('code' => 1, 'message' => 'Business Updated'));
    }

    

}