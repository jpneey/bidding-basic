<?php

require_once "./controller.auth.php";
require_once "./controller.filevalidator.php";
require_once "./controller.sanitizer.php";
require_once "./controller.database.php";
require_once "../model/model.user.php";
require_once "../model/model.bidding.php";
require_once "../model/model.constant.php";

$auth = new Auth();
$dbhandler = new DBHandler();
$user = new User();
$bid = new Bids();