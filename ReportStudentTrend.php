<?php
//echo $_POST['studentId']. $_POST['examNumberDropDown'];

require '_config/general.php';

$link = mysql_connect(HOST, USERNAME, PASSWORD);
if (!$link) {
    die('Could not connect to MySQL server: ' . mysql_error());
}
$dbname = DATABASE_NAME;
$db_selected = mysql_select_db($dbname, $link);
if (!$db_selected) {
    die("Could not set $dbname: " . mysql_error());
}

///Get Number of Sub Category
$sqlSub = "SELECT * FROM tbl_category";
$resultSub = mysql_query($sqlSub);
$resultSubRow = mysql_fetch_array($resultSub);
$numberOfCategory = mysql_num_rows($resultSub);
$studId=$_POST['studentId'];
// Queries user exam number///
$sql = "SELECT eer_numberTakeOfExam,eer_fullName FROM tbl_user WHERE eer_userId = '$studId'";
$result = mysql_query($sql);
$resultGraph = mysql_fetch_array($result);
$resultExamResult=array();
//print $resultGraph['eer_numberTakeOfExam']; 
for($JGP = 1; $JGP <= $resultGraph['eer_numberTakeOfExam'] ; $JGP++){
    $sqlActualExam = "SELECT * FROM tbl_studentquestion WHERE eer_studentId = '$studId' AND eer_examNumber = '$JGP' AND eer_isCorrect = 1";
    $resultExam = mysql_query($sqlActualExam);
    $totalCorrect = mysql_num_rows($resultExam);
    $resultExamResultTemp = ($totalCorrect/($numberOfCategory*NO_QUESTION_SUB)) * 100;
    $resultExamResult[$JGP] = $resultExamResultTemp;
    //print "Number of Question".NO_QUESTION_SUB."<br />";
    //print "Number of Categories".$numberOfCategory."<br />";
    //print "Correct Answer".$totalCorrect."<br />";
    //print $resultExamResult[$JGP]."<br />";
    $resultLabel[$JGP] = "Exam ".$JGP;
}
//print_r($resultExamResult);
//print_r($resultLabel);
// Get student Exam

// Instanciation of inherited class
//$pdf = new PDF();
//$pdf->AliasNbPages();
//$pdf->AddPage();
  
 /* CAT:Bar Chart */ 

 /* pChart library inclusions */ 
 include("_chart/pData.class.php"); 
 include("_chart/pDraw.class.php"); 
 include("_chart/pImage.class.php"); 

 /* Create and populate the pData object */ 
 $MyData = new pData();   
 $MyData->addPoints($resultExamResult,"Percentage"); 
 $MyData->setAxisName(0,"Percentage (%)", 13); 
 $MyData->addPoints($resultLabel,"Options"); 
 $MyData->setAbscissa("Options", 13); 

 /* Create the pChart object */ 
 $myPicture = new pImage(500,220,$MyData); 

 /* Write the chart title */  
 $myPicture->setFontProperties(array("FontName"=>"_chart/fonts/Forgotte.ttf","FontSize"=>15)); 
 $myPicture->drawText(20,34,"Exam Trend Result of ".$resultGraph['eer_fullName'],array("FontSize"=>20)); 

 /* Define the default font */  
 $myPicture->setFontProperties(array("FontName"=>"_chart/fonts/pf_arma_five.ttf","FontSize"=>8)); 

 /* Set the graph area */  
 $myPicture->setGraphArea(70,60,480,200); 
 $myPicture->drawGradientArea(70,60,480,200,DIRECTION_HORIZONTAL,array("StartR"=>200,"StartG"=>200,"StartB"=>200,"EndR"=>240,"EndG"=>240,"EndB"=>240,"Alpha"=>30)); 

 /* Draw the chart scale */  
 $scaleSettings = array("DrawXLines"=>FALSE,"Mode"=>SCALE_MODE_START0,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM); 
 $myPicture->drawScale($scaleSettings);  

 /* Turn on shadow computing */  
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

 /* Draw the chart */  
 $myPicture->drawBarChart(array("Rounded"=>TRUE,"Surrounding"=>30)); 

 /* Render the picture (choose the best way) */ 
 $myPicture->autoOutput("_chart/pictures/example.drawBarChart.poll.png"); 
?>
