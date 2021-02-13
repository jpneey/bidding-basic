<?php 

require_once "../controller.auth.php";
require_once "../controller.sanitizer.php";
require_once "../controller.db.php";
require_once "../../model/model.blog.php";


$auth = new Auth();
$db = new DBHandler();
$connection = $db->connectDB();
$blog = new Blog();

$mode = Sanitizer::filter('mode', 'get');


$isLoggedIn = $auth->getSession('admin_auth');
if(!$isLoggedIn) { die();}

switch($mode) {
    case 'add':
        
        $required = array(
            'cs_blog_title',
            'cs_blog_featured_image',
            'cs_blog_category_id',
            'cs_blog_description',
            'cs_blog_keywords',
            'cs_blog_status'
        );

        foreach($required as $field) {
            ${$field} = Sanitizer::filter($field, 'post');
        }
        $cs_blog_content = (isset($_POST["cs_blog_content"])) ? $_POST["cs_blog_content"] : '';
        $cs_blog_permalink = Sanitizer::url($cs_blog_title, true);
        $cs_blog_added = date('Y-m-d');

        $cs_blog_status = ($cs_blog_status == 2) ? 0 : $cs_blog_status;

        $blog->postBlog(
            $cs_blog_title, 
            $cs_blog_permalink, 
            $cs_blog_featured_image, 
            $cs_blog_category_id, 
            $cs_blog_content, 
            $cs_blog_description,
            $cs_blog_keywords,
            $cs_blog_added,
            $cs_blog_status
        );

        $code = 2;
        $message = "Post Added ";
        break;

        
    case 'update':
        $id= Sanitizer::filter('id', 'get');
        
        $required = array(
            'cs_blog_title',
            'cs_blog_featured_image',
            'cs_blog_category_id',
            'cs_blog_description',
            'cs_blog_keywords',
            'cs_blog_status'
        );

        foreach($required as $field) {
            ${$field} = Sanitizer::filter($field, 'post');
        }
        $cs_blog_content = (isset($_POST["cs_blog_content"])) ? $_POST["cs_blog_content"] : '';
        $cs_blog_permalink = Sanitizer::url($cs_blog_title, true);
        $cs_blog_added = date('Y-m-d');

        $cs_blog_status = ($cs_blog_status == 2) ? 0 : $cs_blog_status;

        $blog->updateBlog(
            $cs_blog_title, 
            $cs_blog_permalink, 
            $cs_blog_featured_image, 
            $cs_blog_category_id, 
            $cs_blog_content, 
            $cs_blog_description,
            $cs_blog_keywords,
            $cs_blog_added,
            $cs_blog_status,
            $id
        );

        $code = 2;
        $message = "Post Updated ";
        break;

    default:
        $code = 0;
        $message = "Bad Request";
}


echo json_encode(array('code' => $code, 'message' => $message));
