<?php

class Location extends DBHandler {

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

    public function getLocations($type = 2){
        $type = (int)$type;
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT * FROM cs_locations WHERE cs_location_type = '$type' ORDER BY cs_location ASC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function getLocation($id, $param = false){
        
        $connection = $this->getconn();
        $stmt = $connection->prepare("SELECT * FROM cs_locations WHERE cs_location_id = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $param ? $result[0][$param] : $result;
    }

}