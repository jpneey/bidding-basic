<?php

class Supplier extends DBHandler {

    public function getSuppliers(){
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT cs_user_id, cs_business_name, cs_business_link, cs_business_category FROM cs_business WHERE cs_business_status != 0");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if(!empty($result)){
            foreach($result as $key=>$value){
                $cs_user_id = (int)$result[$key]['cs_user_id'];
                $cs_category_id = (int)$result[$key]['cs_business_category'];

                $stmt = $connection->prepare("SELECT cs_user_avatar FROM cs_users WHERE cs_user_id = '$cs_user_id'");
                $stmt->execute();
                $image = $stmt->get_result()->fetch_row();
                $stmt->close();
                $result[$key]['cs_business_logo'] = (!empty($image)) ? $image[0] : '#!';

                $stmt = $connection->prepare("SELECT AVG(cs_rating) FROM cs_user_ratings WHERE cs_user_rated_id = '$cs_user_id'");
                $stmt->execute();
                $rating = $stmt->get_result()->fetch_row();
                $result[$key]["cs_owner_rating"] = (!empty($rating)) ? $rating[0] : 0;
                $stmt->close();

                $stmt = $connection->prepare("SELECT cs_category_name FROM cs_categories WHERE cs_category_id = '$cs_category_id'");
                $stmt->execute();
                $category = $stmt->get_result()->fetch_row();
                $stmt->close();
                $result[$key]['cs_business_category'] = (!empty($category)) ? $category[0] : 'Undefined';
            }
        }

        return $result;
    }

    public function getSupplier($selector){
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_business WHERE cs_business_status != 0 AND cs_business_link = ?");
        $stmt->bind_param('s', $selector);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row();
        $stmt->close();

        if(!empty($result)){
            foreach($result as $key){
                $cs_user_id = (int)$result[1];
                $cs_category_id = (int)$result[7];

                $stmt = $connection->prepare("SELECT cs_user_email, cs_contact_details, cs_user_detail, cs_user_avatar FROM cs_users WHERE cs_user_id = '$cs_user_id'");
                $stmt->execute();
                $user = $stmt->get_result()->fetch_row();
                $stmt->close();
                $result[8] = (!empty($user)) ? $user[0] : 'no email address';
                $result[9] = (!empty($user)) ? unserialize($user[1]) : array();
                $result[10] = (!empty($user)) ? $user[2] : '#!';
                $result[11] = (!empty($user)) ? $user[3] : '#!';

                $stmt = $connection->prepare("SELECT AVG(cs_rating) FROM cs_user_ratings WHERE cs_user_rated_id = '$cs_user_id'");
                $stmt->execute();
                $rating = $stmt->get_result()->fetch_row();
                $result[12] = (!empty($rating)) ? $rating[0] : 0;
                $stmt->close();

                $stmt = $connection->prepare("SELECT cs_category_name FROM cs_categories WHERE cs_category_id = '$cs_category_id'");
                $stmt->execute();
                $category = $stmt->get_result()->fetch_row();
                $stmt->close();
                $result[13] = (!empty($category)) ? $category[0] : 'Undefined';

                $stmt = $connection->prepare("SELECT * FROM cs_user_ratings WHERE cs_user_rated_id = '$cs_user_id'");
                $stmt->execute();
                $ratings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
                $result[14] = $ratings;

            }
        }

        return $result;
    }

}