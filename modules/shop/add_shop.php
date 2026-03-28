<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /public/add_shop.html");
    exit();
}

$shop_name  = trim($_POST['shop_name'] ?? '');
$owner_name = trim($_POST['owner_name'] ?? '');
$location   = trim($_POST['location'] ?? '');
$rent       = trim($_POST['rent'] ?? '');

if ($shop_name === '' || $owner_name === '' || $location === '' || $rent === '') {
    die("All fields are required.");
}

$stmt = mysqli_prepare($conn, "INSERT INTO shops (shop_name, owner_name, location, rent) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssd", $shop_name, $owner_name, $location, $rent);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: /modules/shop/manage_shop.php?msg=Shop+Added+Successfully");
    exit();
} else {
    echo "Error: " . htmlspecialchars(mysqli_error($conn));
}
?>
