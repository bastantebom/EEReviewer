<?php
session_start();
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;
    //echo "<script>alert()</script>";

echo $newAction->getListOfExam();
   //echo "Test";
?>
