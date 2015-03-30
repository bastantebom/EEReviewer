<?php
session_start();
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;
    if(empty($_POST['actualAnswer'])){echo "Opps! Somethings wrong";}
    else{
        return $newAction->checkAnswer($_POST['actualAnswer'], $_POST['currentQuestion'],$_POST['category']);
    }
?>
