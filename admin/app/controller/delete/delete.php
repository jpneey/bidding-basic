<?php

require_once "../controller.sanitizer.php";
require_once "../controller.utility.php";
require_once "../controller.auth.php";
require_once "../controller.db.php";

$auth = new Auth();
$dbhandle = new DBHandler();

$connection = $dbhandle->connectDB();

$isLoggedIn = $auth->getSession("admin_auth");
$mode = Sanitizer::filter('mode', 'get');
$target = Sanitizer::filter('target', 'get');

if(!$isLoggedIn){
    die("You are not authorized to perfrom this action.");
}

$error = array();

switch($mode) {

    case "image":
        $response = "Unable to delete file. Please try again";
        if(file_exists("../../static/upload/".$target)) {
            unlink("../../static/upload/".$target);
            $response = "Image deleted. Kindly refresh the page";
        }
        break;

    case "location":
        $id = (int)$target;
        require_once "../../model/model.location.php";
        $location = new Location();
        $location->deleteLocation($id);
        $response = "Location Deleted";
        break;

    case "category":
        $id = (int)$target;
        require_once "../../model/model.category.php";
        $category = new Category();
        $category->deleteCategory($id);
        $response = "Category Deleted";
        break;

    case "tag":
        $id = (int)$target;
        require_once "../../model/model.category.php";
        $category = new Category();
        $category->deleteTag($id);
        $response = "tag Deleted";
        break;
        
    case "blog":
        $id = (int)$target;
        require_once "../../model/model.blog.php";
        $blog = new Blog();
        $blog->deleteBlog($id);
        $response = "Blog Deleted";
        break;

    default:
        $response = "Sorry we can't find what you're looking for.";
        
}

echo $response;

