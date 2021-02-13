<?php

class User extends DBHandler {

    private $conn;

    public function __construct(){
        $this->conn = $this->connectDB();
    }

    public function getUsers() {
        
        $query = "SELECT cs_admin_user, cs_admin_role FROM cs_admin WHERE ";
        
    }

    public function viewable($id, $value) {
        $query = "SELECT cs_option_id FROM cs_bidder_options WHERE cs_user_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($id));
        $ex = $this->fetchRow($stmt);

        if(empty($ex)) {
            $query = "INSERT INTO cs_bidder_options(cs_user_id, cs_allowed_view) VALUES(?,?)";
            $stmt = $this->prepareQuery($this->conn, $query, "ii", array($id, $value));
            $e = $this->execute($stmt);
        } else {
            $query = "UPDATE cs_bidder_options SET cs_allowed_view = ? WHERE cs_user_id = ?";
            $stmt = $this->prepareQuery($this->conn, $query, "ii", array($value, $id));
            $e = $this->execute($stmt);    
        }

        return $e;
    }

    public function status($id, $value) {
        
        $query = "UPDATE cs_users SET cs_account_status = ? WHERE cs_user_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "ii", array($value, $id));
        $e = $this->execute($stmt);
        if(empty($value)) {
            $this->viewable($id, 1);
        } else {
            $this->viewable($id, 4);
        }

        return $e;
    }

    public function getAllUsers($t = 1){
        $query = "SELECT 
        u.cs_user_id,
        u.cs_user_name,
        u.cs_user_email,
        u.cs_user_role,
        u.cs_user_avatar,
        u.cs_account_status,
        AVG(r.cs_rating) AS cs_rate,
        p.cs_plan_id
        FROM cs_users u LEFT JOIN
        cs_user_ratings r ON r.cs_user_rated_id = u.cs_user_id
        LEFT JOIN cs_plans p ON (p.cs_user_id = u.cs_user_id AND p.cs_plan_status = 1)
        WHERE u.cs_user_role = ?
        GROUP BY u.cs_user_id
        ";

        if($t == 1) {
            $query = "SELECT 
            u.cs_user_id,
            u.cs_user_name,
            u.cs_user_email,
            u.cs_user_role,
            u.cs_user_avatar,
            u.cs_account_status,
            AVG(r.cs_rating) AS cs_rate,
            o.cs_allowed_view,
            p.cs_plan_id
            FROM cs_users u LEFT JOIN
            cs_user_ratings r ON r.cs_user_rated_id = u.cs_user_id LEFT JOIN
            cs_bidder_options o ON o.cs_user_id = u.cs_user_id
            LEFT JOIN cs_plans p ON (p.cs_user_id = u.cs_user_id AND p.cs_plan_status = 1)
            WHERE u.cs_user_role = ?
            GROUP BY u.cs_user_id
            ";
        }

        $stmt = $this->prepareQuery($this->conn, $query, "i", array($t));
        return $this->fetchAssoc($stmt);
    }

    public function getAllUserDetails($username){
        $response = array();

        $query = "SELECT * FROM cs_users WHERE cs_user_name = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "s", array($username));
        $userTable = $this->fetchRow($stmt);

        if(empty($userTable)) {
            return array();
        }

        $userid = $userTable[0];

        /* $query = "SELECT * FROM cs_user_address WHERE cs_user_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($userid));
        $userAddress = $this->fetchRow($stmt); */

        $query = "SELECT * FROM cs_user_ratings WHERE cs_user_rated_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($userid));
        $userRatings = $this->fetchAssoc($stmt);

        $query = "SELECT * FROM cs_transactions WHERE cs_bidder_id = ? OR cs_bid_owner_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "ii", array($userid, $userid));
        $userTransactions = $this->fetchAssoc($stmt);

        $query = "SELECT * FROM cs_products WHERE cs_user_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($userid));
        $userProducts = $this->fetchAssoc($stmt);

        $query = "SELECT * FROM cs_plans WHERE cs_user_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($userid));
        $userPlans = $this->fetchAssoc($stmt);

        $query = "SELECT * FROM cs_offers WHERE cs_user_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($userid));
        $userOffers = $this->fetchAssoc($stmt);

        $query = "SELECT * FROM cs_notifications WHERE cs_user_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($userid));
        $userNotifications = $this->fetchAssoc($stmt);

        $query = "SELECT * FROM cs_business WHERE cs_user_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($userid));
        $userBusiness = $this->fetchRow($stmt);
        
        //$query = "SELECT b.*, p.* FROM cs_biddings b LEFT JOIN cs_products_in_biddings p ON b.cs_bidding_id = p.cs_bidding_id WHERE cs_bidding_user_id = ? GROUP BY cs_bidding_id";
        $query = "SELECT * FROM cs_biddings WHERE cs_bidding_user_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($userid));
        $userBiddings = $this->fetchRow($stmt);

        $response['details'] = array($userTable);
        // $response['address'] = array($userAddress);
        $response['ratings'] = array($userRatings);
        $response['transactions'] = array($userTransactions);
        $response['products'] = array($userProducts);
        $response['plans'] = array($userPlans);
        $response['offers'] = array($userOffers);
        $response['notifications'] = array($userNotifications);
        $response['business'] = array($userBusiness);
        $response['biddings'] = array($userBiddings);

        return $response;
    }

}