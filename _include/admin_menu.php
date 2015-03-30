<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
?>

<ul>
    
    <li><a href="control_panel.php" <?php if(curPageName()=="control_panel.php"){echo "class='active'";} ?> ><span>Control Panel</span></a></li>
    <li><a href="exam_management.php" <?php if(curPageName()=="exam_management.php"){echo "class='active'";} ?> ><span>Exam Management</span></a></li>
    <li><a href="user_management.php" <?php if(curPageName()=="user_management.php"){echo "class='active'";} ?>><span>User Uploading</span></a></li>
     <li><a href="add_user.php" <?php if(curPageName()=="add_user.php"){echo "class='active'";} ?>><span>Add User</span></a></li>
    
</ul>