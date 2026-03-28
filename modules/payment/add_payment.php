<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /public/add_payment.html");
    exit();
}

$vendor_id = isset($_POST['vendor_id']) ? (int)$_POST['vendor_id'] : 0;
$amount    = trim($_POST['amount'] ?? '');
$method    = trim($_POST['payment_method'] ?? '');
$date      = trim($_POST['payment_date'] ?? '');

if ($vendor_id <= 0 || $amount === '' || $method === '' || $date === '') {
    die("All fields are required.");
}

$stmt = mysqli_prepare($conn, "INSERT INTO payments (vendor_id, amount, payment_method, payment_date) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "idss", $vendor_id, $amount, $method, $date);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: /modules/payment/rent_record.php?msg=Payment+Recorded+Successfully");
    exit();
} else {
    echo "Error: " . htmlspecialchars(mysqli_error($conn));
}
?>
