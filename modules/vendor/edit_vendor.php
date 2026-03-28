<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: /modules/vendor/vendor_report.php");
    exit();
}

if (isset($_POST['update'])) {
    $name  = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    $stmt = mysqli_prepare($conn, "UPDATE vendors SET name=?, phone=? WHERE vendor_id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $name, $phone, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Fixed: was redirecting to non-existent manage_vendors.php
    header("Location: /modules/vendor/vendor_report.php?msg=Vendor+Updated");
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

$page_title = 'Edit Vendor';
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="form-box">
    <h2>Edit Vendor</h2>
    <form method="POST">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
        <button name="update">Update Vendor</button>
    </form>
    <p><a href="/modules/vendor/vendor_report.php">Back to Vendor Report</a></p>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
