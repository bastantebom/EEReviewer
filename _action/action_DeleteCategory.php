<?php
session_start();
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;

if($_POST['id']==""){
    return $newAction->displayDivLayerOpening("", "", "msg msg-error", "<p><strong>Not allowed direct Access!</strong></p>");

}
else{
    //echo "<script>alert()</script>";
    echo $newAction->removeCategory($_POST['id']);
}
?>
