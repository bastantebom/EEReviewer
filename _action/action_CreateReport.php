<?php
session_start();
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;
    if(empty($_POST['studId'])){echo "Opps! Somethings wrong";}
    else{
        $newAction->createReport($_POST['studId'],$_POST['examNumberReport']);
          header("location:ReportPerUser.php");
          exit();
    }
?>
