<?php
session_start();
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;

if($_POST['security']==""){
    return $newAction->displayDivLayerOpening("", "", "msg msg-error", "<p><strong>Not allowed direct Access!</strong></p>");

}
else{
    //echo "Test";
    echo $newAction->saveQuestion($_POST['question'],$_POST['answer'],$_POST['optionOne'],$_POST['optionTwo'],$_POST['optionThree'],$_POST['category'],$_POST['difficulty']);
    //echo "Action";
}
?>
