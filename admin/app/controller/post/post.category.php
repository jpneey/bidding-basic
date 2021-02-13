<?php 

require_once "../controller.auth.php";
require_once "../controller.sanitizer.php";
require_once "../controller.db.php";
require_once "../../model/model.category.php";


$auth = new Auth();
$db = new DBHandler();
$connection = $db->connectDB();
$category = new Category();

$mode = Sanitizer::filter('mode', 'get');


$isLoggedIn = $auth->getSession('admin_auth');
if(!$isLoggedIn) { die();}

switch($mode) {
    case 'add':

        $posts = array('name', 'desciption');

        foreach($posts as $post) {
            ${$post} = Sanitizer::filter($post, 'post');
            if(!${$post}) {
                echo json_encode(array('code' => 0, 'message' => 'Field Error'));
                die();
            }
        }
        $category->postCategory($name, $desciption);       
        $code = 2;
        $message = "Category Added";
        break;
        
    case 'add-tag':

        $posts = array('name', 'category_id');

        foreach($posts as $post) {
            ${$post} = Sanitizer::filter($post, 'post');
            if(!${$post}) {
                echo json_encode(array('code' => 0, 'message' => 'Field Error'));
                die();
            }
        }
        $category->postTag($category_id, $name);       
        $code = 2;
        $message = "Tag Added";
        break;
        
    case 'update':

        $posts = array('name', 'desciption');
        $id = Sanitizer::filter('id', 'get', 'int');
        foreach($posts as $post) {
            ${$post} = Sanitizer::filter($post, 'post');
            if(!${$post}) {
                echo json_encode(array('code' => 0, 'message' => 'Field Error'));
                die();
            }
        }
        $category->updateCategory($name, $desciption, $id);       
        $code = 2;
        $message = "Category Updated";
        break;

    default:
        $code = 0;
        $message = "Bad Request";
}


echo json_encode(array('code' => $code, 'message' => $message));
