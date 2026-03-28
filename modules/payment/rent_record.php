<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

$page_title = 'Rent Records';
require_once __DIR__ . '/../../includes/header.php';

$msg = htmlspecialchars($_GET['msg'] ?? '');
?>

<h2 style="text-align:center; margin-top:20px;">Rent Record</h2>

<?php if ($msg): ?>
    <div class="alert alert-success"><?php echo $msg; ?></div>
<?php endif; ?>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Vendor</th><th>Shop</th><th>Monthly Rent</th><th>Total Paid</th><th>Due</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT vendors.vendor_id, vendors.name, vendors.shop_name, shops.rent
                FROM vendors
                JOIN shops ON vendors.shop_name = shops.shop_name";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)):
            $vendor_id = (int)$row['vendor_id'];

            $pay_stmt = mysqli_prepare($conn, "SELECT SUM(amount) AS total_paid FROM payments WHERE vendor_id=?");
            mysqli_stmt_bind_param($pay_stmt, "i", $vendor_id);
            mysqli_stmt_execute($pay_stmt);
            $pay_result = mysqli_stmt_get_result($pay_stmt);
            $pay_data   = mysqli_fetch_assoc($pay_result);
            mysqli_stmt_close($pay_stmt);

            $total_paid = $pay_data['total_paid'] ?? 0;
            $due        = $row['rent'] - $total_paid;
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['shop_name']); ?></td>
            <td><?php echo htmlspecialchars($row['rent']); ?> TK</td>
            <td><?php echo htmlspecialchars($total_paid); ?> TK</td>
            <td class="due-amount"><?php echo htmlspecialchars($due); ?></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<p style="text-align:center;margin-top:20px;">
    <a href="/public/add_payment.html">+ Add Payment</a> &nbsp;|&nbsp;
    <a href="/modules/admin/dashboard.php">Back to Dashboard</a>
</p>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
