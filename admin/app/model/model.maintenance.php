<?php

class Maintenance extends DBHandler {

    private $conn;

    public function __construct() {
        $this->conn = $this->connectDB();
    }

    public function getAdminEmail() {
        $query = "SELECT cs_setting_value FROM cs_store WHERE cs_setting_name = 'admin_email'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $em = $this->fetchRow($stmt);
        if(!empty($em)) {
            return $em[0];
        } else {
            return 'info@canvasspoint.com';
        }
    }

    public function getHomeData() {
        $query = "SELECT cs_setting_value FROM cs_store WHERE cs_setting_name = 'admin_home'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $em = $this->fetchRow($stmt);
        if(!empty($em)) {
            return $em[0];
        } else {
            return '0,0,0,0';
        }
    }

    public function updateHomeData($data){
        $query = "UPDATE cs_store SET cs_setting_value = ? WHERE cs_setting_name = 'admin_home'";
        $stmt = $this->prepareQuery($this->conn, $query, "s", array($data));
        return $this->execute($stmt);
    }

    

    public function updateAdminEmail($email){
        $query = "UPDATE cs_store SET cs_setting_value = ? WHERE cs_setting_name = 'admin_email'";
        $stmt = $this->prepareQuery($this->conn, $query, "s", array($email));
        return $this->execute($stmt);
    }

}