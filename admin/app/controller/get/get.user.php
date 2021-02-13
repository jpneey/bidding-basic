<?php

require_once "../controller.sanitizer.php";
require_once "../controller.utility.php";
require_once "../controller.auth.php";
require_once "../controller.db.php";

require_once "../../model/model.user.php";

$auth = new Auth();
$dbhandle = new DBHandler();
$user = new User();

$isLoggedIn = $auth->getSession("admin_auth");
$mode = Sanitizer::filter('mode', 'get');

$error = array();

switch($mode) {
    
    case "table":
        $t = Sanitizer::filter('t', 'get', 'int');
        $users = $user->getAllUsers($t);
        if($t == 2) {
            foreach($users as $key=>$value){
                $users[$key]["cs_user_role"] = 
                ($users[$key]["cs_user_role"] == 2) ? 'Supplier' : 'Client';
                
                
                $roleText = 
                ($users[$key]["cs_account_status"] == 2) ? 'Premium' : 'Free';

                $option = "
                    <a href='../view/?user=".$users[$key]["cs_user_name"]."'>Details</a>
                ";

                $users[$key]["cs_account_status"] = $option;
                $users[$key]["cs_account_statuss"] = "Premium";
                if(!$users[$key]["cs_plan_id"]){
                    $users[$key]["cs_account_statuss"] = "<a href='#!' class='uptopro' data-target='".$users[$key]["cs_user_id"]."'>Free</a>";
                } else {
                    $users[$key]["cs_account_statuss"] = "<a href='#!' class='todefault' data-target='".$users[$key]["cs_user_id"]."'>Premium</a>";
                }

                $users[$key]['cs_rate'] = number_format($users[$key]['cs_rate'], '2', '.', ',');
            }
        } else {
            foreach($users as $key=>$value){
                $users[$key]["cs_user_role"] = 
                ($users[$key]["cs_user_role"] == 2) ? 'Supplier' : 'Client';
                
                $roleText = 
                ($users[$key]["cs_account_status"] == 2) ? 'Premium' : 'Free';

                $option = "
                    <a href='../view/?user=".$users[$key]["cs_user_name"]."'>Login as</a>
                ";

                $users[$key]["cs_account_status"] = $option;

                $users[$key]['cs_rate'] = number_format($users[$key]['cs_rate'], '2', '.', ',');

                $users[$key]["cs_account_statuss"] = "Premium";
                if(!$users[$key]["cs_plan_id"]){
                    $users[$key]["cs_account_statuss"] = "<a href='#!' class='uptopro' data-target='".$users[$key]["cs_user_id"]."'>Free</a>";
                } else {
                    $users[$key]["cs_account_statuss"] = "<a href='#!' class='todefault' data-target='".$users[$key]["cs_user_id"]."'>Premium</a>";
                }

                $users[$key]["cs_allowed_view"] = "
                    <input type='number' value=".number_format($users[$key]['cs_allowed_view'], '0', '.', ',')."
                    data-target=\"".$users[$key]["cs_user_id"]."\" class=\"viewable\" min=\"1\" step=\"1\" />";
            } 
        }
        $response = json_encode(array("data" => $users));
        break;        
}

echo $response;

