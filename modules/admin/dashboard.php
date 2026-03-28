<?php
require_once __DIR__ . '/../../includes/auth.php';
$page_title = 'Admin Dashboard';
require_once __DIR__ . '/../../includes/header.php';
?>

<h2 style="text-align:center; margin-top:20px;">Admin Dashboard</h2>

<div class="dashboard">

    <a href="/modules/vendor/add_vendor.php">Add Vendor</a>
    <a href="/modules/vendor/search_vendor.php">Search Vendor</a>
    <a href="/modules/vendor/vendor_report.php">Vendor Report</a>

    <a href="/modules/shop/add_shop.php">Add Shop</a>
    <a href="/modules/shop/manage_shop.php">Manage Shops</a>

    <a href="/modules/payment/add_payment.php">Add Payment</a>
    <a href="/modules/payment/rent_record.php">Rent Records</a>

    <a href="/modules/report/report.php">System Report</a>
    <a href="/modules/backup/data_backup.php">Backup Data</a>

    <a href="/auth/logout.php">Logout</a>

</div>

<link rel="stylesheet" href="/assets/css/admin_dashboard.css">

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
