<?php

class DBHandler {
    
    private $host = "localhost";
	private $user = "root";
	private $password = "";
    private $database = "cs_canvasspoint";
    
    private $conn;

    /* private $host = "sql100.epizy.com";
	private $user = "epiz_26364296";
	private $password = "nG9FIT86L2J";
	private $database = "epiz_26364296_cpoint";
	private $conn; */
	
	
	function __construct() {
		$this->conn = $this->connectDB();
		if(!$this->conn) {
			echo "Connecting to database failed!";
		}
	}
	
	public function connectDB() {
		$conn = new mysqli($this->host,$this->user,$this->password,$this->database);
		return $conn;
    }

    function numRows($conn, $query) {
		$result  = mysqli_query($conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
    }
    
    function runQuery($conn, $query) {
		$result = mysqli_query($conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
    
    public function prepareQuery($connection, $query, $types = "", $values = array()) {
        $stmt = $connection->prepare($query);
        if(!empty($types) && !empty($values)) {
            $stmt->bind_param($types, ...$values);
        }
        return $stmt;
    }

    public function fetchAssoc($stmt){
        $stmt->execute();
        $response = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $response;
    }

    public function fetchRow($stmt){
        $stmt->execute();
        $response = $stmt->get_result()->fetch_row();
        $stmt->close();
        return $response;
    }

    public function fetchCount($stmt){
        $stmt->execute();
        $response = $stmt->get_result()->num_rows;
        $stmt->close();
        return $response;
    }

    public function execute($stmt){
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
	
}