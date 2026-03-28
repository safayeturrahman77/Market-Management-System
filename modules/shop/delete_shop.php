<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: /modules/shop/manage_shop.php");
    exit();
}

$stmt = mysqli_prepare($conn, "DELETE FROM shops WHERE shop_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: /modules/shop/manage_shop.php?msg=Shop+Deleted");
} else {
    echo "Error deleting shop: " . htmlspecialchars(mysqli_error($conn));
}
?>
