<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

// Total Vendors
$vendor_result = mysqli_query($conn, "SELECT COUNT(*) AS total_vendors FROM vendors");
$vendor_data   = mysqli_fetch_assoc($vendor_result);

// Total Shops
$shop_result = mysqli_query($conn, "SELECT COUNT(*) AS total_shops FROM shops");
$shop_data   = mysqli_fetch_assoc($shop_result);

// Total Rent
$rent_result = mysqli_query($conn, "SELECT SUM(rent) AS total_rent FROM shops");
$rent_data   = mysqli_fetch_assoc($rent_result);

// Total Payments Collected
$pay_result = mysqli_query($conn, "SELECT SUM(amount) AS total_paid FROM payments");
$pay_data   = mysqli_fetch_assoc($pay_result);

$page_title = 'Market Report';
require_once __DIR__ . '/../../includes/header.php';
?>

<link rel="stylesheet" href="/assets/css/report.css">

<h2 style="text-align:center; margin-top:20px;">Market Report Summary</h2>

<div class="report-box">
    <p><strong>Total Vendors:</strong> <?php echo (int)$vendor_data['total_vendors']; ?></p>
    <p><strong>Total Shops:</strong> <?php echo (int)$shop_data['total_shops']; ?></p>
    <p><strong>Total Monthly Rent:</strong> <?php echo htmlspecialchars($rent_data['total_rent'] ?? 0); ?> TK</p>
    <p><strong>Total Payments Collected:</strong> <?php echo htmlspecialchars($pay_data['total_paid'] ?? 0); ?> TK</p>
    <p style="margin-top:16px;">
        <a href="/modules/report/pdf_report.php">Download PDF Report</a>
    </p>
</div>

<p style="text-align:center; margin-top:20px;">
    <a href="/modules/admin/dashboard.php">Back to Dashboard</a>
</p>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
