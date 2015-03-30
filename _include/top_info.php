<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="top-navigation">
                                
                                <?php 
				if($_SESSION['utype']=="Administrator"){ 
                                       echo "Welcome <a href='control_panel.php'><strong>$_SESSION[name]</strong></a>";
                                }
                                else{
					echo "Welcome <a href='student_panel.php'><strong>$_SESSION[name]</strong></a>";
				}
                                
                                ?>
				<span>|</span>
				<?php 
				if($_SESSION['utype']=="Administrator"){ 
					echo "<a href='change_password.php'>Change Password</a>"; 
				}
				else{
					echo "<a href='change_student_password.php'>Change Password</a>"; 
				}
				
				?>
				<span>|</span>
				<a href="index.php">Log out</a>
</div>