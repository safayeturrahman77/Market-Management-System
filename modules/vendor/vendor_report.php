<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

$page_title = 'Vendor Report';
require_once __DIR__ . '/../../includes/header.php';

$msg = htmlspecialchars($_GET['msg'] ?? '');
?>

<h2 style="text-align:center; margin-top:20px;">Vendor Report</h2>

<?php if ($msg): ?>
    <div class="alert alert-success"><?php echo $msg; ?></div>
<?php endif; ?>

<div style="width:90%;margin:0 auto 10px;">
    <input type="text" id="live-search" data-table="vendor-table" placeholder="🔍 Search vendors by name, phone or shop...">
</div>

<div class="table-wrapper">
    <table id="vendor-table">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Phone</th><th>Shop Name</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM vendors");
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <tr>
            <td><?php echo (int)$row['vendor_id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['shop_name']); ?></td>
            <td>
                <a href="/modules/vendor/edit_vendor.php?id=<?php echo (int)$row['vendor_id']; ?>">Edit</a> |
                <a href="/modules/vendor/vendor_profile.php?id=<?php echo (int)$row['vendor_id']; ?>">Profile</a> |
                <a href="/modules/vendor/delete_vendor.php?id=<?php echo (int)$row['vendor_id']; ?>"
                   data-confirm="Delete vendor '<?php echo htmlspecialchars($row['name'], ENT_QUOTES); ?>'? This cannot be undone.">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<p style="text-align:center;margin-top:20px;">
    <a href="/public/add_vendor.html">+ Add New Vendor</a> &nbsp;|&nbsp;
    <a href="/modules/admin/dashboard.php">Back to Dashboard</a>
</p>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
