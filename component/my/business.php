<?php 

if(!$isSupplier){
    $emptyTitle = "Whoops Are you lost?";
    $emptyMessage = "It seems like the page you are looking for was moved, deleted or didn't exist at all.";
    require_once "component/empty.php"; 
    die(); 
}

require_once "business.add.php";

?>