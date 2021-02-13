<?php

class Location extends DBHandler {

    private $conn;

    public function __construct() {
        $this->conn = $this->connectDB();
    }

    public function getLocations() {
        $query = "SELECT * FROM cs_locations";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getLocation($id) {
        $query = "SELECT * FROM cs_locations WHERE cs_location_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($id));
        return $this->fetchRow($stmt);
    }

    public function postLocation($name, $type=2) {
        $query = "INSERT INTO cs_locations(cs_location_type, cs_location) VALUES(?,?)";
        $stmt = $this->prepareQuery($this->conn, $query, "is", array($type, $name));
        $this->execute($stmt);
        return true;
    }

    public function updateLocation($id, $name, $type=2) {
        $query = "UPDATE cs_locations SET cs_location = ? WHERE cs_location_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "si", array($name, $id));
        $this->execute($stmt);
        return true;
    }

    public function deleteLocation($id) {
        $query = "DELETE FROM cs_locations WHERE cs_location_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($id));
        return $this->execute($stmt);
    }


}