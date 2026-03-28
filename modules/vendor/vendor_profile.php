<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: /modules/vendor/vendor_report.php");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT * FROM vendors WHERE vendor_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    die("Vendor not found.");
}

$page_title = 'Vendor Profile';
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="form-box">
    <h2>Vendor Profile</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
    <p><strong>Shop Name:</strong> <?php echo htmlspecialchars($row['shop_name']); ?></p>
    <p><a href="/modules/vendor/edit_vendor.php?id=<?php echo (int)$row['vendor_id']; ?>">Edit Vendor</a></p>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
