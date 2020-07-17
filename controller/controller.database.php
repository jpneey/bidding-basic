<?php

class DBHandler extends Sanitizer {
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
		$conn = new mysqli($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
}