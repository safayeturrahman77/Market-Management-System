<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /public/add_vendor.html");
    exit();
}

$name      = trim($_POST['name'] ?? '');
$phone     = trim($_POST['phone'] ?? '');
$shop_name = trim($_POST['shop_name'] ?? '');

if ($name === '' || $phone === '' || $shop_name === '') {
    die("All fields are required.");
}

$stmt = mysqli_prepare($conn, "INSERT INTO vendors (name, phone, shop_name) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $name, $phone, $shop_name);

if (mysqli_stmt_execute($stmt)) {
    header("Location: /modules/vendor/vendor_report.php?msg=Vendor+Added+Successfully");
    exit();
} else {
    echo "Error: " . htmlspecialchars(mysqli_error($conn));
}

mysqli_stmt_close($stmt);
?>
