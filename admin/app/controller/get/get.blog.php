<?php

require_once "../controller.sanitizer.php";
require_once "../controller.utility.php";
require_once "../controller.auth.php";
require_once "../controller.db.php";

require_once "../../model/model.blog.php";

$auth = new Auth();
$dbhandle = new DBHandler();
$blog = new Blog();

$isLoggedIn = $auth->getSession("admin_auth");
$mode = Sanitizer::filter('mode', 'get');

$error = array();

switch($mode) {

    
    case "table":
        $blogs = $blog->getBlogs();

        foreach($blogs as $k => $v) {
            $id = $blogs[$k]["cs_blog_id"];
            $blogs[$k]["cs_blog_action"] = "<a href='../blog-update/?k=$id' class='btn orange white-text' >Update</a>";
            $blogs[$k]["cs_blog_action"] .= " <a href='#!' class='data-delete btn red white-text' onclick=\"dataDelete.call(this)\" data-mode=\"blog\" data-target=\"$id\">Delete</a>";

        }

        $response = json_encode(array("data" => $blogs));
        break;
    default:
        $response = json_encode(array("code" => 0, "message" => "Sorry we can't find what you're looking for."));
        
}

echo $response;

