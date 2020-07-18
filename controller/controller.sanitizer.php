<?php

class Sanitizer {
    
    public static function filter($variable, $method, $type=null) {
        switch($method) {
            case 'post':
                $var = isset($_POST[$variable]) ? $_POST[$variable] : NULL;
                break;
            case 'get':
                $var = isset($_GET[$variable]) ? $_GET[$variable] : NULL;
                break;
            default:
                $var = !empty(trim($variable)) ? $variable : NULL;
                break;
        }
        
        if(!$var) { return NULL; }
        return self::sanitize($var, $type);
    }
    
    public static function sanitize($variable, $type=null) {

        $type = self::type($type);

        $strip = strip_tags($variable);
        $trim = trim($strip);
        $sanitized = filter_var($trim, $type);

        return $sanitized;
    }

    public static function type($type=null) {
        switch($type) {
            case 'int':
                $type = FILTER_SANITIZE_NUMBER_INT;
                break;

            case 'float':
                $type = FILTER_SANITIZE_NUMBER_FLOAT;
                break;

            case 'email':
                $type = FILTER_SANITIZE_EMAIL;
                break;
            default:
                $type = FILTER_SANITIZE_STRING;
                break;
        }
        return $type;
    }

    public static function url($str = '') {
        
        $friendlyURL = htmlentities($str, ENT_COMPAT, "UTF-8", false); 
        $friendlyURL = preg_replace('/&([a-z]{1,2})(?:acute|circ|lig|grave|ring|tilde|uml|cedil|caron);/i','\1',$friendlyURL);
        $friendlyURL = html_entity_decode($friendlyURL,ENT_COMPAT, "UTF-8"); 
        $friendlyURL = preg_replace('/[^a-z0-9-]+/i', '-', $friendlyURL);
        $friendlyURL = preg_replace('/-+/', '-', $friendlyURL);
        $friendlyURL = trim($friendlyURL, '-');
        $friendlyURL = strtolower($friendlyURL);
        return $friendlyURL;
    
    }
    	
}