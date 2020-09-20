<?php

require_once 'controller.sanitizer.php';
require_once 'controller.database.php';

$dbhandle = new DBHandler();
$connection = $dbhandle->connectDB();

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'none'; 

$code = '1';
$message = 'Undefined Mode';

switch($mode) {

    case 'generic':
        $resp = array();
        /* $query = "SELECT cs_category_name FROM cs_categories";
        $cats = $connection->query($query)->fetch_all();
        foreach($cats as $k=>$v) {
            $resp[$cats[$k][0]] = null;
        } */
        
        $query = "SELECT cs_tag FROM cs_tags";
        $tags = $connection->query($query)->fetch_all();
        foreach($tags as $k=>$v) {
            $resp[$tags[$k][0]] = null;
        }
        

        $query = "SELECT cs_bidding_title FROM cs_biddings WHERE cs_bidding_status = 1 LIMIT 50";
        $bids = $connection->query($query)->fetch_all();
        foreach($bids as $k=>$v) {
            $resp[$bids[$k][0]] = null;
        }
        
        $query = "SELECT cs_location FROM cs_locations";
        $locs = $connection->query($query)->fetch_all();
        foreach($locs as $k=>$v) {
            $resp[$locs[$k][0]] = null;
        }
        
        $response = json_encode($resp);

        break;

    case 'tag':
    default:
        $resp = array();
        $id = Sanitizer::filter('id', 'get', 'int');
        $query = "SELECT cs_tag FROM cs_tags";
        if($id) {
            $query = "SELECT cs_tag FROM cs_tags WHERE cs_category_id = '$id'";
        }
        $tags = $connection->query($query)->fetch_all();
        foreach($tags as $k=>$v) {
            $resp[$tags[$k][0]] = null;
        }
        $response = json_encode($resp);    

}

echo $response;
