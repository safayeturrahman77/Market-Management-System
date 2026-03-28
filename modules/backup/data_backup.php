<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

$filename = 'vendors_backup_' . date('Y-m-d') . '.xls';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename);
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

// Print column headers
echo "Vendor ID\tName\tPhone\tShop Name\n";

$result = mysqli_query($conn, "SELECT * FROM vendors");

while ($row = mysqli_fetch_assoc($result)) {
    // Sanitize tab/newline characters from each field
    $line = array_map(function($val) {
        return str_replace(["\t", "\n", "\r"], ' ', $val);
    }, $row);
    echo implode("\t", $line) . "\n";
}
?>
