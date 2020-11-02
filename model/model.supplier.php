<?php

class Supplier extends DBHandler {

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

    public function getProducts(){ 
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT p.*, c.cs_category_name, u.cs_user_name, AVG(r.cs_rating) AS cs_owner_rating FROM cs_products p LEFT JOIN cs_categories c ON c.cs_category_id = p.cs_category_id LEFT JOIN cs_user_ratings r ON p.cs_user_id = r.cs_user_rated_id LEFT JOIN cs_users u ON u.cs_user_id = p.cs_user_id GROUP BY p.cs_product_id ORDER BY cs_inquired DESC, cs_product_id DESC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function searchProducts($filter){ 
        $connection = $this->getconn();

        $query = "SELECT p.*, c.cs_category_name, u.cs_user_name, AVG(r.cs_rating) AS cs_owner_rating FROM cs_products p LEFT JOIN cs_categories c ON c.cs_category_id = p.cs_category_id LEFT JOIN cs_user_ratings r ON p.cs_user_id = r.cs_user_rated_id LEFT JOIN cs_users u ON u.cs_user_id = p.cs_user_id WHERE 1 = 1";
        /* where */

        if(!empty($filter)) { $query .= " ".$filter[0];}
        
        $query .= " GROUP BY p.cs_product_id ORDER BY cs_inquired DESC, cs_product_id DESC";
        
        $stmt = $connection->prepare($query);
        if(!empty($filter)) {
            $stmt->bind_param($filter[1], ...$filter[2]);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

}