<?php
session_start();
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;

if($_POST['security']==""){
    return $newAction->displayDivLayerOpening("", "", "msg msg-error", "<p><strong>Not allowed direct Access!</strong></p>");

}
else{
    //echo "<script>alert()</script>";
    echo $newAction->changePassword($_POST['old'],$_POST['npass'],$_POST['confirmpass']);
    //echo "Action";
}
?>
