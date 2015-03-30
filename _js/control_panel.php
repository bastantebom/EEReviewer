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
						<h2 class="left">Activate Student Exam</h2>
						<div class="right">
							<label>search student</label>
							<input type="text" class="field small-field" id="searching" />
						</div>
					</div>
					<!-- End Box Head -->	

					<!-- Table -->
                                        <div class='table'>
                                             <span class='messageListener'></span>
                                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                             <tr>
                                                <th style="width: 30px;">    </th>
                                                <th style="width: 40px;">#</th>
                                                <th style="width: 150px;">Student #</th>
                                                <th style="width: 200px;">Student Name</th>
                                                <th>Last Exam</th>
                                                <th style="width: 60px;">Number of Exam</th>
                                            </tr>
                                                </table>
                                        </div>        
                                        <div id="studentList">
                                            <?php echo $componentsCreator->retrieveStudent("*"); ?>
                                        </div>
                                         <div class="pagging">
                                            <input type="button" class="button" value="activate exam" onclick="activateExam();" />
					</div>
                                         <div style="width: 100%;height:55px; border-top: solid 1px #949494; background-color: #C5C5EC; margin-top: 10px;">
                                                <span style="float: left; width:45%;margin: 10px 0px 0px 10px;">To print student trend select student then Click the button</span>
                                                <form action="ReportStudentTrend.php" method="post" target="_blank" style="float: right; width:50%;margin: 8px 0px 0px 10px;">
                                                    <?php echo $componentsCreator->retrieveListOfStudents(); ?>
                                                    <input type="submit" value="Print Student Trend" style="height: 25px; width: 150px;"/>
                                                </form>
                                        </div>
                                       
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