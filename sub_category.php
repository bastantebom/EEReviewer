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
		<!-- Logo + Top Nav -->
                <img src="_css/images/logo.gif" style="width:85px; height: 80px; float: left;"/>
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
						<h2 class="left">Manage Question</h2>
					</div>
					<!-- End Box Head -->	

					<!-- Table -->
					<div class="table">
                                                 <!-- Additional Info on the Page -->
                                                 <div class="breadcrumbs">
                                                  
                                                 <?php 
                                                    $category_title = $componentsCreator->retrieveCategoryName($_GET['category']);
                                                    //$subcategory_title = $componentsCreator->retrieveSubCategoryName($_GET['subcategory']);
                                                    //$subcategoryId = base64_decode($_GET['subcategory']);
                                                    $category_id = base64_decode($_GET['category']);
                                                    echo "<h3 class='categoryTitle'><a href='exam_management.php'>Category</a> > <a href='sub_category.php?category=$_GET[category]'> $category_title</a> </h3>"; 
                                                 ?>
                                                 </div>    
                                                 <span class="messageListener"></span>
						<form>
						
						<!-- Form -->
                                                   <div class="form">
                                                        <input type="hidden" value='<?php echo $category_id ?>' id="categoryId" />
                                                       
								<p>
									<span class="req">max 500 characters</span>
									<label>Question <span>(Required Field)</span></label>
									<textarea class="field size1" id="question" rows="10" cols="30"></textarea>
								</p>
                                                                
                                                                <p>
									<span class="req">max 100 characters</span>
									<label>Answer<span>(Required Field)</span></label>
									<input type="text" class="field size1" id="answer"  />
								</p>
                                                                
                                                                <p>
									<span class="req">max 100 characters</span>
									<label>Option 1 <span>(Required Field)</span></label>
									<input type="text" class="field size1" id="optionOne" />
								</p>
                                                                
                                                                <p>
									<span class="req">max 100 characters</span>
									<label>Option 2 <span>(Required Field)</span></label>
									<input type="text" class="field size1" id="optionTwo" />
								</p>
                                                        
                                                                <p>
									<span class="req">max 100 characters</span>
									<label>Option 3 <span>(Required Field)</span></label>
									<input type="text" class="field size1" id="optionThree" />
								</p>
                                                        
                                                               <label>Level of Difficulty</label>
                                                                <select class="field" id="levelOfQuestion">
                                                                    <option value="" style="color:#d2d1cb;font-style:italic;">select difficulty</option>
                                                                    <option value="1">Easy</option>
                                                                    <option value="2">Moderate</option>
                                                                    <option value="3">Difficult</option>
                                                                </select>
                                                    </div>
                                                    </div>
						
						<!-- End Form -->
						
						<!-- Form Buttons -->
                                                   <div class="buttons">
							<input type="button" class="button" value="save" onclick="saveQuestion('go')" />
                                                        <input type="button" class="button" value="clear"  onclick="clearQuestionForm()" />
                                                    </div>
						<!-- End Form Buttons -->
                                            </form>
                                            <!-- Additional Info on the Page -->
                                            <br />
                                             <div id="categoryList">
                                                 <?php echo $componentsCreator->retrieveQuestion($category_id); ?>
                                            </div>  
                                            <div style="width: 100%;height:40px; border-top: solid 1px #949494; background-color: #C5C5EC; margin-top: 10px;">
                                                <span style="float: left; width:45%;margin: 10px 0px 0px 10px;">To print all questionnaires Click the button</span>
                                                <form action="ReportAllQuestionnaire.php" method="post" target="_blank" style="float: right; width:50%;margin: 8px 0px 0px 10px;">
                                                    <input type="submit" value="Print Questionnaire" style="height: 25px; width: 150px;"/>
                                                </form>
                                            </div>
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