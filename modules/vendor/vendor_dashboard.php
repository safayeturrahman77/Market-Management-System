<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'vendor') {
    header("Location: /auth/login.php");
    exit();
}

$page_title = 'Vendor Dashboard';
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="dashboard">
    <h2 style="text-align:center;">Vendor Dashboard</h2>
    <a href="/modules/vendor/vendor_profile.php?id=<?php echo (int)$_SESSION['vendor_id']; ?>">My Profile</a>
    <a href="/modules/vendor/vendor_report.php">Vendor Report</a>
    <a href="/auth/logout.php">Logout</a>
</div>

<link rel="stylesheet" href="/assets/css/admin_dashboard.css">

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
