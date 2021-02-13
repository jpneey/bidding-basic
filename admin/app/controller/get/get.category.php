<?php

require_once "../controller.sanitizer.php";
require_once "../controller.utility.php";
require_once "../controller.auth.php";
require_once "../controller.db.php";

require_once "../../model/model.category.php";

$auth = new Auth();
$dbhandle = new DBHandler();
$category = new Category();

$isLoggedIn = $auth->getSession("admin_auth");
$mode = Sanitizer::filter('mode', 'get');

$error = array();

switch($mode) {
    
    case "table":
        $categories = $category->getCategories();
        foreach($categories as $key => $v) {
            $categories[$key]['cs_category_action'] = '<a class="btn-small orange darken-2 white-text" onclick="updateTag.call(this)" data-id="'.$categories[$key]['cs_category_id'].'" data-name="'.$categories[$key]['cs_category_name'].'">Tags</a> ';
            $categories[$key]['cs_category_action'] .= '<a class="btn-small green darken-2 white-text" onclick="updateCategory.call(this)" data-id="'.$categories[$key]['cs_category_id'].'"><i class="material-icons">sync</i></a> ';
            $categories[$key]['cs_category_action'] .= '<a class="btn-small red darken-2 white-text data-delete" onclick="dataDelete.call(this)" data-mode="category" data-target="'.$categories[$key]['cs_category_id'].'"><i class="material-icons">delete</i></a>';
            $categories[$key]['cs_category_desciption'] = ($categories[$key]['cs_category_desciption']) ?: 'No description provided';
        }
        $response = json_encode(array("data" => $categories));
        break;
    
    case "get":
        $id = Sanitizer::filter('id', 'get', 'int');
        $response = json_encode($category->getCategory($id));
        break;

    case "get-tags":
        $id = Sanitizer::filter('id', 'get', 'int');
        $tags = $category->getCategoryTags($id);
        $response = "";

        if(!empty($tags)) {
            foreach($tags as $key=>$value){
                $response .= '
                <a class="btn-small red darken-2 white-text data-delete" onclick="dataDelete.call(this)" data-mode="tag" data-target="'.$tags[$key]['cs_tag_id'].'">'.$tags[$key]['cs_tag'].'<i class="material-icons right">close</i></a>
                ';
            }
        }
        
        break;
    default:
        $response = json_encode(array("code" => 0, "message" => "Sorry we can't find what you're looking for."));
        
}

echo $response;

