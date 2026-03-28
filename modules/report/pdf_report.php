<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

// FPDF library should be placed at: vendor/fpdf/fpdf.php
// Download from http://www.fpdf.org/
$fpdf_path = __DIR__ . '/../../vendor/fpdf/fpdf.php';

if (!file_exists($fpdf_path)) {
    die("FPDF library not found. Please download fpdf.php from http://www.fpdf.org/ and place it at vendor/fpdf/fpdf.php");
}

require($fpdf_path);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Vendor Report', 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'ID', 1);
$pdf->Cell(70, 10, 'Name', 1);
$pdf->Cell(50, 10, 'Phone', 1);
$pdf->Cell(40, 10, 'Shop', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 11);

$result = mysqli_query($conn, "SELECT * FROM vendors");
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(30, 10, $row['vendor_id'], 1);
    $pdf->Cell(70, 10, $row['name'], 1);
    $pdf->Cell(50, 10, $row['phone'], 1);
    $pdf->Cell(40, 10, $row['shop_name'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'vendor_report_' . date('Y-m-d') . '.pdf');
?>
