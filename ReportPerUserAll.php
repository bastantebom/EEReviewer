<?php
//echo $_POST['studentId']. $_POST['examNumberDropDown'];
require '_config/general.php';
require('fpdf.php');


$link = mysql_connect(HOST, USERNAME, PASSWORD);
if (!$link) {
    die('Could not connect to MySQL server: ' . mysql_error());
}
$dbname = DATABASE_NAME;
$db_selected = mysql_select_db($dbname, $link);
if (!$db_selected) {
    die("Could not set $dbname: " . mysql_error());
}


class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
     $this->Image('_css/images/logo.gif',35,2,30,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(50);
    // Title
    $this->Cell(90,10,'Electrical Engineering Reviewer',0,0,'C');
    $this->Ln(7);
    $this->SetFont('Arial','B',12);
    $this->Cell(50);
    // Title
    $this->Cell(90,10,'Lyceum of the Philippines - Laguna',0,0,'C');
    $this->Ln(5);
    $this->Cell(50);
    // Title
    $this->SetFont('Arial','B',8);
    $this->Cell(90,10,'Km. 54 National Highway, Brgy. Makiling, Calamba City',0,0,'C');
    // Line break
    //$this->Ln(15);
    $this->SetFont('Arial','B',12);
    
    /////for user info
    $sqlUser = "SELECT * FROM tbl_user WHERE  eer_userId = '$_POST[studentId]'";
    $resultUser = mysql_query($sqlUser);
    $resultRawUser = mysql_fetch_array($resultUser);
    /////for score and answerSELECT * FROM tbl_studentquestion INNER JOIN tbl_category ON tbl_studentquestion.eer_categoryId=tbl_category.eer_categoryId WHERE eer_examNumber ='$_POST[examNumberDropDown]' AND eer_studentId = '$_POST[studentId]' AND eer_categoryId = '$_POST[categoryId]' AND eer_actualAnswer !='' 
    $sql = "SELECT * FROM tbl_studentquestion WHERE eer_examNumber ='$_POST[examNumberDropDown]' AND eer_studentId = '$_POST[studentId]'";
    $result = mysql_query($sql);
    $totalItem=mysql_num_rows($result);
    //////for counting sub category
    //$sqlCountSub = "SELECT * FROM tbl_category";
    //$resultCount = mysql_query($sqlCountSub);
    //$resultRawSub = mysql_num_rows($resultCount);
    //$totalItems = $resultRawSub * NO_QUESTION_SUB;
    $correctItems =0;
    while($resultRawCorrect = mysql_fetch_array($result)){
        if($resultRawCorrect['eer_isCorrect']==1){
            $correctItems++;
        }
    }
    if($correctItems!=0){
        $percentage = ($correctItems/$totalItem) * 100;
    }
    else{
         $percentage = 0;
    }
    $this->Ln(18);
    $this->Cell(12);
    $this->SetFont('Arial','B',11);
    $this->Multicell(148,5,'Name: '.$resultRawUser['eer_fullName'].'');
    //$this->Ln(8);
    $this->Cell(79,10,'Student Number: '.$resultRawUser['eer_userId'],0,0,'C');
    $this->Cell(168,10,'Raw Score: '.$correctItems.'/'.$totalItem,0,0,'C');
    $this->Ln(5);
    $this->Cell(71,10,'Number Take of Exam: '.$resultRawUser['eer_numberTakeOfExam'],0,0,'C');
     $this->Cell(193,10,'Percentage: '.number_format($percentage, 2).'%',0,0,'C');
    // Title
   
    // Line break
    $this->Ln(5);
    $this->Cell(200,5,'____________________________________________________________________________________',0,0,'C');
     $this->Ln(8);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function ChapterBody($file)
{
    // Read text file
    $txt = file_get_contents($file);
    // Times 12
    $this->SetFont('Times','',12);
    // Output justified text
    $this->MultiCell(0,5,$txt);
    // Line break
    $this->Ln();
    // Mention in italics
    $this->SetFont('','I');
    $this->Cell(0,5,'(end of excerpt)');
}

function ChapterTitle($num, $label)
{
    // Arial 12
    $this->SetFont('Arial','',12);
    // Background color
    $this->SetFillColor(200,220,255);
    // Title
    $this->Cell(0,6,"Chapter $num : $label",0,1,'L',true);
    // Line break
    $this->Ln(4);
}

function PrintChapter($num, $title, $file)
{
    $this->AddPage();
    $this->ChapterTitle($num,$title);
    $this->ChapterBody($file);
}

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(220,50,50);
$pdf->Cell(12);
$sql = "SELECT * FROM tbl_studentquestion WHERE eer_examNumber ='$_POST[examNumberDropDown]' AND eer_studentId = '$_POST[studentId]' AND eer_actualAnswer !='' ";
$result = mysql_query($sql);

$sqlCountSubCategory = "SELECT * FROM tbl_category WHERE eer_categoryId = '$_POST[categoryId]'";
$resultCountSubCategory = mysql_query($sqlCountSubCategory);
$categoryName= mysql_fetch_array($resultCountSubCategory);
$pdf->SetFont('Times','BU',15);
$pdf->Cell(60,10,'Category: '.$categoryName['eer_categoryName'],0,1);
$pdf->SetFont('Times','',12);
$number = 1;
$pdf->SetTextColor(1,1,1);
$questionQuantity = mysql_num_rows($result);
$ctr = $questionQuantity;

while($resultRaw = mysql_fetch_array($result)){
   // if($ctr == $questionQuantity){
        
       // $pdf->Ln(4);
        //$pdf->SetFont('Times','B',14);
        //$pdf->Cell(13);
       // $pdf->MultiCell(170,5,$resultRaw['eer_subCategoryName'].' Subcategory');
       // $pdf->SetFont('Times','',12);
       // $pdf->Ln(4);
       // $ctr = 0;
    //}
    $pdf->Cell(18);
    $pdf->MultiCell(170,5,$number.")  ".html_entity_decode($resultRaw['eer_question']));

    if($resultRaw['eer_isCorrect'] == 0){
        $pdf->Cell(22);
        $pdf->SetTextColor(220,50,50);
        $pdf->Cell(60,5,'- Wrong the correct answer is : '.html_entity_decode($resultRaw['eer_keyAnswer']),0,1);
        $pdf->SetTextColor(1,1,1);
    }
    else{
        $pdf->SetTextColor(102,205,170);
        $pdf->Cell(22);
        $pdf->Cell(60,5,'- Correct the answer is : '.html_entity_decode($resultRaw['eer_keyAnswer']),0,1);
        $pdf->SetTextColor(1,1,1);
    }
    $number++;
    $ctr++;
}


$pdf->Output();
?>
