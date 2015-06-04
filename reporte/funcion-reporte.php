<?php 
require_once('../res/conexion.php'); 
require_once('../res/fpdf/fpdf.php'); 


$pdf = new FPDF();
$pdf->Open();
$pdf->SetMargins(0, 0);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

$content = 'thisis a test';

$pdf->SetXY(20, 20);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->MultiCell(150, 5, $content, 0, 'L');

$pdf->Output();

exit;


 ?>