<?php
session_start();
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;
    //echo "<script>alert()</script>";
$studentId = explode(".", $_POST['temp']);
if(count($studentId)>=1){
    if(empty($_POST['temp'])){echo "Opps! Somethings wrong";}
    else{
        echo $newAction->activateExam($_POST['temp']);
    }
}

else{
    echo "Opps! Please select Student to activate Exam";
}
?>
