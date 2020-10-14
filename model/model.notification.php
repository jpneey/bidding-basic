<?php

class Notification extends DBHandler {

    private $userId;

    public function __construct($userid){
        $this->userId = $userid;
    }

    public function getUnread($asCount = true) {

        $connection = $this->connectDB();
        $userId = $this->userId;

        $stmt = $connection->prepare("SELECT cs_notif, cs_added, cs_notif_id FROM cs_notifications WHERE cs_user_id = ? AND cs_notif_read = 0 ORDER BY cs_added DESC");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        if($asCount) { $count = $stmt->get_result()->num_rows;}
        else { $count = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);}
        $stmt->close();
        return $count;
    }

    public function getRead($asCount = true) {

        $connection = $this->connectDB();
        $userId = $this->userId;

        $stmt = $connection->prepare("SELECT cs_notif, cs_added FROM cs_notifications WHERE cs_user_id = ? AND cs_notif_read != 0 ORDER BY cs_added DESC LIMIT 5");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        if($asCount) { $count = $stmt->get_result()->num_rows;}
        else { $count = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);}
        $stmt->close();
        return $count;
    }


    
}