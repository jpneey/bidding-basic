<?php

require_once 'controller/controller.auth.php';

$auth = new Auth();
$auth->sessionDie("../home/?unauth=2");
exit();

?>