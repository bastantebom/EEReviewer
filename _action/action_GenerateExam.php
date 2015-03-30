<?php
session_start();
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;

    if(empty($_POST['studentId'])){echo "Opps! Somethings wrong";}
    else{
        echo $newAction->generateExam($_POST['studentId']);
    }

?>
