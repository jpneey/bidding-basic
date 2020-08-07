<?php

class Location extends DBHandler {

    public function getLocations(){

        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_locations ORDER BY cs_location ASC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }

    public function getLocation($id, $param = false){
        
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_locations WHERE cs_location_id = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $param ? $result[0][$param] : $result;
    }

}