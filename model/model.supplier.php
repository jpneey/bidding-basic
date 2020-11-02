<?php

class Supplier extends DBHandler {

    public function getProducts(){
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT p.*, c.cs_category_name, u.cs_user_name, AVG(r.cs_rating) AS cs_owner_rating FROM cs_products p LEFT JOIN cs_categories c ON c.cs_category_id = p.cs_category_id LEFT JOIN cs_user_ratings r ON p.cs_user_id = r.cs_user_rated_id LEFT JOIN cs_users u ON u.cs_user_id = p.cs_user_id GROUP BY p.cs_product_id");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

}