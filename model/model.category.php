<?php

class Category extends DBHandler {

    public function getCategories(){

        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_categories ORDER BY cs_category_name ASC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function getCategory($id, $param = false){
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_categories WHERE cs_category_id = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $param ? $result[0][$param] : $result;
    }

}