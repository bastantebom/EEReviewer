<?php
session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//if(!isset($_POST['direct_access'])){echo "Invalid Direct Access";}
//else{
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;
$newAction->checkUser($_POST['uname'],$_POST['password']);

//echo $_POST['direct_access'];
//}
//header("location:../admin.php");
//exit();
?>
