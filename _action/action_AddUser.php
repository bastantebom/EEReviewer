<?php
session_start();
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;


    //echo "Test";
$password = md5($_POST['lastName']);
$name = $_POST['lastName'].", ".$_POST['firstName']." ".$_POST['middleName'];
echo $newAction->uploadStudent($_POST['studentNumber'],$name,$password);
    //echo "Action";
?>
