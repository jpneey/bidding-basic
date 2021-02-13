<?php

require_once "../controller.sanitizer.php";
require_once "../controller.utility.php";
require_once "../controller.auth.php";
require_once "../controller.db.php";

require_once "../../model/model.location.php";

$auth = new Auth();
$dbhandle = new DBHandler();
$location = new Location();

$isLoggedIn = $auth->getSession("admin_auth");
$mode = Sanitizer::filter('mode', 'get');

$error = array();

switch($mode) {

    case "get":
        $id = Sanitizer::filter('id', 'get');
        $response = json_encode($location->getLocation($id));
        break;
    
    case "table":
        $locations = $location->getLocations();

        foreach($locations as $key => $v) {
            $locations[$key]['cs_location_action'] = '<a class="btn-small green darken-2 white-text" onclick="updateLocation.call(this)" data-id="'.$locations[$key]['cs_location_id'].'"><i class="material-icons">sync</i></a> ';
            $locations[$key]['cs_location_action'] .= '<a class="btn-small red darken-2 white-text data-delete" onclick="dataDelete.call(this)" data-mode="location" data-target="'.$locations[$key]['cs_location_id'].'"><i class="material-icons">delete</i></a>';
        }
        $response = json_encode(array("data" => $locations));
        break;
    default:
        $response = json_encode(array("code" => 0, "message" => "Sorry we can't find what you're looking for."));
        
}

echo $response;

