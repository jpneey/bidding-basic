<?php

define('included', true);
require_once "./controller.sanitizer.php";
require_once "./controller.database.php";
require_once "../model/model.bids.php";
require_once "../model/model.constant.php";
require_once "../view/view.feed.bid.php";

$dbhandler = new DBHandler();
$bid = new Bids();

$connection = $dbhandler->connectDB();
$id = Sanitizer::filter('token', 'get');
$BASE_DIR = Sanitizer::filter('base', 'get'); 

$bid = new Bids();
$viewFeedBids = new viewFeedBids($BASE_DIR);
echo $viewFeedBids->viewFeed(" AND cs_bidding_id < ? ORDER BY cs_bidding_id DESC LIMIT 20", 'i', array($id));  

?>