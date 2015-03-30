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
    $this->Ln(15);
    $this->SetFont('Arial','B',12);
    $this->Cell(200,5,'_____________________________________________________________________________',0,0,'C');
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
$sql = "SELECT * FROM tbl_category";
$result = mysql_query($sql);

$pdf->Ln(10);
$pdf->Cell(10);
$pdf->SetFont('Times','BU',15);
$pdf->Cell(60,10,'Questionnaires and Key to Answer',0,1);
$pdf->SetFont('Times','',12);

$pdf->SetTextColor(1,1,1);


while($resultRaw = mysql_fetch_array($result)){
    $number = 1;
     $pdf->Ln(10);
     $pdf->Cell(18);
     $pdf->SetTextColor(220,50,50);
     $pdf->SetFont('Times','BU',15);
     $pdf->MultiCell(170,5,$resultRaw['eer_categoryName']);
     
     $pdf->Ln(5);
    $sqlQuestion =  "SELECT * FROM tbl_question WHERE eer_categoryId = '$resultRaw[eer_categoryId]'";
    $resultQuestion = mysql_query($sqlQuestion);
    while($resultRawQuestion = mysql_fetch_array($resultQuestion)){
        $pdf->Cell(18);
        $pdf->SetFont('Times','',12);
        $pdf->SetTextColor(1,1,1);
        $pdf->MultiCell(170,5,$number.")  ".html_entity_decode($resultRawQuestion['eer_question'])." (".html_entity_decode($resultRawQuestion['eer_answer']).")");
        $number++;
    }
}


$pdf->Output();
?>
