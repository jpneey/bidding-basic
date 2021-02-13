<?php

class Payment extends DBHandler {

    private $conn;

    public function __construct() {
        $this->conn = $this->connectDB();
    }

    public function getPayments() {
        $query = "SELECT p.*, u.* FROM cs_plans p LEFT JOIN cs_users u ON u.cs_user_id = p.cs_user_id GROUP BY p.cs_plan_id";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function hasActivePlan($userId, $strict = false){
        
        $passedId = (int)$userId;
        $connection = $this->conn;
        $query = "SELECT p.* FROM cs_plans p WHERE p.cs_user_id = ? AND (p.cs_plan_status = 1 OR p.cs_plan_status = 0)";
        if($strict){
            $query = "SELECT p.* FROM cs_plans p WHERE p.cs_user_id = ? AND (p.cs_plan_status = 1)";
        }
        $stmt = $connection->prepare($query);
        $stmt->bind_param('i', $passedId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return (empty($result)) ? false : true;
    }

    public function toNotif($message, $path, $userid){
        $notificationMessage = "<a data-to='".$path."'><b>".$message."</b></a>";
        date_default_timezone_set('Asia/Manila');
        $currentDateTimeStamp = date('Y-m-d H:i:s');
        $connection = $this->conn;

        $stmt = $connection->prepare("INSERT INTO cs_notifications(cs_notif, cs_user_id, cs_added) VALUES(?,?,?)");
        $stmt->bind_param("sis", $notificationMessage,$userid, $currentDateTimeStamp);
        $stmt->execute();
        $stmt->close();
    }

    public function updateStatus($uid, $tid, $val){

        date_default_timezone_set('Asia/Manila');
        $nextYear = date('Y-m-d H:i:s', strtotime('+1 year'));

        $query = "UPDATE cs_plans SET cs_plan_status = ?, expires = ? WHERE cs_plan_id = ? AND cs_user_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "isii", array($val, $nextYear, $tid, $uid));
        return $this->execute($stmt);
    }

    public function deletePayment($uid, $tid){
        $query = "SELECT cs_plan_status FROM cs_plans WHERE cs_plan_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($tid));
        $status = $this->fetchRow($stmt);
        if(!empty($status)){
            switch($status[0]) {
                case "0":
                case 0:
                    $this->toNotif("Your PRO plan request was cancelled.", "my/plan/", $uid);
                    break;
                case "1":
                case 1:
                    $this->toNotif("Your PRO plan was terminated.", "my/plan/", $uid);
                    break;
            }
        }
        $query = "DELETE FROM cs_plans WHERE cs_plan_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($tid));
        return $this->execute($stmt);
    }

    public function toPro($uid){
        $connection = $this->conn;
        $passedId = (int)$uid;
        $mod = "Admin";
        $hash = "Awarded by admin";
        $toView = 4;
        $toOpen = 4;
        $toFeat = 4;

        
        date_default_timezone_set('Asia/Manila');
        $currentDateTime = date('Y-m-d H:i:s');
        $nextYear = date('Y-m-d H:i:s', strtotime('+1 year'));

        $query = "INSERT INTO 
            cs_plans(cs_user_id, cs_plan_status, 
                    cs_to_open, cs_to_view, cs_to_featured, 
                    date_added, cs_plan_payment, cs_gateway_comment, expires) 
            VALUES (?, 1, ?, ?, ?, ?, '$mod', ?, ?)";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("iiiisss", $passedId, $toOpen, $toView, $toFeat, $currentDateTime, $hash, $nextYear);
        $exec = $stmt->execute();
        $stmt->close();

        return $exec;

    }

    public function toFree($uid){
        $connection = $this->conn;
        $passedId = (int)$uid;

        $query = "DELETE FROM cs_plans WHERE cs_plan_status = 1 AND cs_user_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $passedId);
        $stmt->execute();
        $stmt->close();

        return;
    }

}