<?php

class Business extends DBHandler {

    private $conn;

    public function __construct(){
        $this->conn = $this->connectDB();
    }

    public function getAllBusiness(){
        $query = "SELECT 
        u.cs_user_id,
        u.cs_user_name,
        u.cs_user_email,
        u.cs_user_role,
        u.cs_user_avatar,
        u.cs_account_status,
        AVG(r.cs_rating) AS cs_rate
        FROM cs_users u LEFT JOIN
        cs_user_ratings r ON r.cs_user_rated_id = u.cs_user_id
        WHERE u.cs_user_role = ?
        GROUP BY u.cs_user_id
        ";
    }

    
}