<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

$page_title = 'Manage Shops';
require_once __DIR__ . '/../../includes/header.php';

$msg = htmlspecialchars($_GET['msg'] ?? '');
?>

<h2 style="text-align:center; margin-top:20px;">Shop Records</h2>

<?php if ($msg): ?>
    <div class="alert alert-success"><?php echo $msg; ?></div>
<?php endif; ?>

<div style="width:90%;margin:0 auto 10px;">
    <input type="text" id="live-search" data-table="shop-table" placeholder="🔍 Search shops by name, owner or location...">
</div>

<div class="table-wrapper">
    <table id="shop-table">
        <thead>
            <tr>
                <th>ID</th><th>Shop Name</th><th>Owner</th><th>Location</th><th>Monthly Rent</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM shops");
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <tr>
            <td><?php echo (int)$row['shop_id']; ?></td>
            <td><?php echo htmlspecialchars($row['shop_name']); ?></td>
            <td><?php echo htmlspecialchars($row['owner_name']); ?></td>
            <td><?php echo htmlspecialchars($row['location']); ?></td>
            <td><?php echo htmlspecialchars($row['rent']); ?> TK</td>
            <td>
                <a href="/modules/shop/delete_shop.php?id=<?php echo (int)$row['shop_id']; ?>"
                   data-confirm="Delete shop '<?php echo htmlspecialchars($row['shop_name'], ENT_QUOTES); ?>'? This cannot be undone.">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<p style="text-align:center;margin-top:20px;">
    <a href="/public/add_shop.html">+ Add New Shop</a> &nbsp;|&nbsp;
    <a href="/modules/admin/dashboard.php">Back to Dashboard</a>
</p>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
