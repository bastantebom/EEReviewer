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
						<h2 class="left">Upload Student</h2>
					</div>
					<!-- End Box Head -->	

					<!-- Table -->
					<div class="table">
                                                    <?php
                                                    if ((($_FILES["file"]["type"] == "application/vnd.ms-excel")) && ($_FILES["file"]["size"] < 200000)){
                                                    if ($_FILES["file"]["error"] > 0)
                                                        {
                                                        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                                                        }
                                                    else
                                                        {
                                                            echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                                                            echo "Type: " . $_FILES["file"]["type"] . "<br />";
                                                            echo "Size: " . ($_FILES["file"]["size"] / 20000) . " Kb<br />";
                                                            //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                                                            if (file_exists("_upload/" . $_FILES["file"]["name"])){
                                                               unlink("_upload/" . $_FILES["file"]["name"]);
                                                               move_uploaded_file($_FILES["file"]["tmp_name"],"_upload/" . $_FILES["file"]["name"]);
                                                            }
                                                            else{
                                                                move_uploaded_file($_FILES["file"]["tmp_name"],"_upload/" . $_FILES["file"]["name"]);
                                                                echo "Stored in: " . "_upload/" . $_FILES["file"]["name"];
                                                            }
                                                            ////Start upload////
                                                                    include '_upload/reader.php';
                                                                    $excel = new Spreadsheet_Excel_Reader();
                                                                    $excel->read("_upload/" . $_FILES["file"]["name"]);
                                                                        $x=1;
                                                                            //echo "<table>";
                                                                            while($x<=$excel->sheets[0]['numRows']) {
                                                                                //echo "\t<tr>\n";
                                                                                //$y=1;
                                                                                //while($y<=$excel->sheets[0]['numCols']) {
                                                                                    $studentNumber = isset($excel->sheets[0]['cells'][$x][2]) ? htmlentities($excel->sheets[0]['cells'][$x][2]) : '';
                                                                                    $studentName = isset($excel->sheets[0]['cells'][$x][3]) ? htmlentities($excel->sheets[0]['cells'][$x][3]) : '';
                                                                                    
                                                                                    $tempName = explode(",", $studentName);
                                                                                    $encryptedPassword = md5(trim($tempName[0]));
                                                                                    $componentsCreator->uploadStudent($studentNumber, $studentName, $encryptedPassword);
                                                                                    //echo $studentNumber." ".$studentName." ".$tempPass."<br />";
                                                                                    //$cell = htmlspecialchars_decode($cell);
                                                                                   // print "\t\t<td>$cell</td>\n"; 
                                                                                    //$y++;
                                                                                //} 
                                                                                //echo "\t</tr>\n";
                                                                                $x++;
                                                                            }
                                                                            echo $componentsCreator->createDivLayerOpening("", "", "msg msg-ok", "<p><strong>Your file was uploaded successfully!</strong></p>");
                                                                            
                                                                            // echo "</table>";
                                                                ////End upload////
                                                        }
                                                    }
                                                    else{
                                                        echo "Invalid file";
                                                    }
                                                  ?>
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
				<!--<div class="box">
					
					<!-- Box Head -->
					<!--<div class="box-head">
						<h2>Profile</h2>
					</div>
					<!-- End Box Head-->
					
					<!--<div class="box-content" style="font-weight: bold; ">
						<label>Login As:</label> <u><span style="color: #8c3521;"><?php //echo  $_SESSION['name']; ?></span></u><br />
                                                <label>User Type:</label> <u><span style="color: #8c3521;"><?php //echo  $_SESSION['utype']; ?></span></u>
                                                
						<!-- End Sort -->
						
					<!--</div>-->
				<!--</div>
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