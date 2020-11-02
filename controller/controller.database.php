<?php

class DBHandler extends Sanitizer {
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

	private $c;
	
	function __construct() {
		$this->conn = $this->connectDB();
		if(!$this->conn) {
			echo "Connecting to database failed!";
		}
	}
	
	function connectDB() {
		if(!$this->c){
			$this->c = new mysqli($this->host,$this->user,$this->password,$this->database);
		}
		return $this->c;
	}
	
}