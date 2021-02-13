<?php

require_once "../controller.sanitizer.php";
require_once "../controller.utility.php";
require_once "../controller.auth.php";
require_once "../controller.db.php";

require_once "../../model/model.payment.php";

$auth = new Auth();
$dbhandle = new DBHandler();
$payment = new Payment();

$isLoggedIn = $auth->getSession("admin_auth");
$mode = Sanitizer::filter('mode', 'get');

$error = array();

switch($mode) {

    
    case "table":
        $payments = $payment->getPayments();
        foreach($payments as $k => $payment){
            $payments[$k]["user"] = "
            <a href='view/?user=".$payments[$k]['cs_user_name']."'>".$payments[$k]['cs_user_name']." / ".$payments[$k]['cs_user_email']."</a>
            ";
            

            switch($payments[$k]['cs_plan_status']){
                case 0:
                    $status = "Processing";
                break;
                case 1:
                    $status = "Paid";
                break;
                case 2:
                    $status = "Expired";
                break;
            }

            $payments[$k]["cs_plan_to"] = $payments[$k]["cs_to_open"] . " / " . $payments[$k]["cs_to_view"] . " / " . $payments[$k]["cs_to_featured"];

            $payments[$k]["statuss"] = "
            
            <select class=\"account-status\" name=\"type\" data-current=\"".$payments[$k]['cs_plan_status']."\" data-target=\"".$payments[$k]["cs_user_id"]."\" data-tid=\"".$payments[$k]["cs_plan_id"]."\" style='display: inline-block' >
                <option value=\"".$payments[$k]['cs_plan_status']."\" selected disabled>".$status."</option>  
                <option value=\"1\">Paid</option>
                <option value=\"0\">Processing</option>
                <option value=\"2\">Expired</option>
                <option value=\"3\">Delete</option>
            </select>";

            $payments[$k]["cs_plan_id"] = "#CNPPRO".$payments[$k]["cs_plan_id"];

        }
        $response = json_encode(array("data" => $payments));
        break;
    default:
        $response = json_encode(array("code" => 0, "message" => "Sorry we can't find what you're looking for."));
        
}

echo $response;

