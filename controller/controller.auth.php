<?php

class Auth {

	function __construct() {
        $this->sessionStart();
    }
    
    function sessionStart() {
        if(!isset($_SESSION)) {
            session_start();
        }
    }

    function getSession($var) {
        return isset($_SESSION[$var]) && !empty($_SESSION[$var]) ? $_SESSION[$var] : false;
    }

    function setSession($var, $val) {
        $_SESSION[$var] = $val;
    }

    function compareSession($var, $expected) {
        
        $ses = isset($_SESSION[$var]) && !empty($_SESSION[$var]) ? $_SESSION[$var] : false;
        return $ses === $expected ? true : false;
    }

    function sessionDie($location=null) {
        session_unset();
        session_destroy();
        if($location) {
            header('location: ' . $location);
            exit();
        }
    }

    function forbid($var, $expected) {
        if (!$this->compareSession($var, $expected)) {
            echo "Forbidden";
            die();
        }
    }

    function redirect($var, $expected, $location=null) {
        if (!$this->compareSession($var, $expected)) {
            if($location) {
                header('location: ' . $location);
            }
            exit();
        } 
    }

}