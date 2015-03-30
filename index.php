<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
session_start();

//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['name']);
}

require "_config/general.php";
require VIEW_LIBRARIES."/generateView.php";
//$content = "";

//Instanciate the Components Object
$componentsCreator = new View;
$componentsCreator->createPageHeader(COMPANY_NAME,JQUERY_DIR,JAVASCRIPT_DIR,CSS_DIR);
?>

<!-- Container -->
<div id="container" style="text-align:center;">
	<div class="shell">
		
		
		<br />
		<!-- Main -->
		<div id="main" style="width:750px;margin:0 auto;">
			<div class="cl">&nbsp;</div>
		
			<!-- Content -->
			<div id="content">
				
				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h2 class="left">Login Page</h2>
						
					</div>
					<!-- End Box Head -->	
                                <form action="_action/action_Authenticate.php" method="post">
                                    <label>Username: </label><input type="text" name="uname" style="margin-top: 20px; width: 250px;"/><br />
                                    <label>Password : </label><input type="password" name="password" style="margin-top: 10px; width: 250px;"/><br />
                                    <input type="submit" class="button" value="Login" style=" width: 100px; margin: 10px 0px 5px 220px;"/>
                                </form>
				</div>
				<!-- End Box -->
				
				<!-- Box -->
				

			</div>
			<!-- End Content -->
			
			
			
			<div class="cl">&nbsp;</div>			
		</div>
		<!-- Main -->
	</div>
</div>
<!-- End Container -->

<!-- Footer -->
<div style="width: 40%;margin: 0 auto;">
	
		<span class="left">&copy; 2012 - <?php echo COMPANY_NAME ?></span>
		<span class="right"> <?php echo COMPANY_ADDRESS ?>
		</span>
	
</div>
<!-- End Footer -->
	
</body>
</html>