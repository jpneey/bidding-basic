<?php

error_reporting(0);

class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "cs_canvasspoint";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
		if(!$this->conn) {
			echo "Connecting to database failed!";
		}
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	public function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
}