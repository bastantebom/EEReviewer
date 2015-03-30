<?php
session_start();
require "../_config/general.php";
require "../". VIEW_LIBRARIES."/generateController.php";
$newAction = new Controller;
    //echo "<script>alert()</script>";
if(trim($_POST['searchString'])==""){echo "Can't search an empty string";}
else
echo $newAction->retrieveStudent($_POST['searchString']);

?>
