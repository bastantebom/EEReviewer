<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
session_start();

//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
if(!isset($_SESSION['username']) || !isset($_SESSION['password'])){
   header("location:index.php");
   exit();
}

require "_config/general.php";
require VIEW_LIBRARIES."/generateController.php";
//$content = "";

//Instanciate the View Object
$componentsCreator = new Controller;
$componentsCreator->createPageHeader(COMPANY_NAME,JQUERY_DIR,JAVASCRIPT_DIR,CSS_DIR);
?>

<div id="header">
	<div class="shell">
            <img src="_css/images/logo.gif" style="width:85px; height: 80px; float: left;"/>
		<!-- Logo + Top Nav -->
		<div id="top">
                    
			<h1><?php echo COMPANY_NAME ?></h1>
                        
			<?php include "_include/top_info.php" ?>
		</div>
		<!-- End Logo + Top Nav -->
		
		<!-- Main Nav -->
		<div id="navigation">
			<?php require "_include/admin_menu.php" ?>
		</div>
		<!-- End Main Nav -->
	</div>
</div>
<!-- End Header -->

<!-- Container -->
<div id="container">
	<div class="shell">
		
		
		<br />
		<!-- Main -->
		<div id="main">
			<div class="cl">&nbsp;</div>
			
			<!-- Content -->
			<div id="content">
				
				<!-- Box -->
				<div class="box">
					<!-- Box Head -->
					<div class="box-head">
						<h2 class="left">Change Password</h2>
					</div>
					<!-- End Box Head -->	

					<!-- Table -->
					<span class="messageListener"></span>
                                <p>
									<span class="req"></span>
									<label>Old Pssword<span>(Required Field)</span></label>
									<input type="password" class="field size1" id="oldpass"  />
								</p>
                                                                
                                <p>
									<span class="req"></span>
									<label>New Password<span>(Required Field)</span></label>
									<input type="password" class="field size1" id="newpass" />
								</p>
                                                                
                                <p>
									<span class="req"></span>
									<label>Confirmed Password<span>(Required Field)</span></label>
									<input type="password" class="field size1" id="confirmpass" />
								</p>
                                                        
                                <input type="button" class="button" value="save" onclick="changePassword('go')" />       
                         
					<!-- Table -->
					
				</div>
				<!-- End Box -->
				
				<!-- Box -->
				

			</div>
			<!-- End Content -->
			
			<!-- Sidebar -->
			<div id="sidebar">
				
				<!-- Box -->
				<div class="box">
					
					<!-- Box Head -->
					<div class="box-head">
						<h2>Profile</h2>
					</div>
					<!-- End Box Head-->
					
					<div class="box-content" style="font-weight: bold; ">
						<label>Login As:</label> <u><span style="color: #8c3521;"><?php echo  $_SESSION['name']; ?></span></u><br />
                                                <label>User Type:</label> <u><span style="color: #8c3521;"><?php echo  $_SESSION['utype']; ?></span></u>
                                                
						<!-- End Sort -->
						
					</div>
				</div>
				<!-- End Box -->
			</div>
			<!-- End Sidebar -->
			
			<div class="cl">&nbsp;</div>			
		</div>
		<!-- Main -->
	</div>
</div>
<!-- End Container -->

<!-- Footer -->
<div id="footer" >
	<div class="shell">
		<span class="left">&copy; 2012 - <?php echo COMPANY_NAME ?></span>
		<span class="right"> <?php echo COMPANY_ADDRESS ?>
		</span>
	</div>
</div>
<!-- End Footer -->
	
</body>
</html>