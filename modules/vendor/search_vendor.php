<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../config/db.php';

$search = trim($_GET['search'] ?? '');
$page_title = 'Search Vendor';
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="form-box" style="width:600px;">
    <h2>Search Vendor</h2>
    <form method="GET" style="display:flex;gap:8px;">
        <input type="text" name="search" placeholder="Search by name" value="<?php echo htmlspecialchars($search); ?>" style="flex:1;">
        <button type="submit" style="width:auto;padding:8px 16px;">Search</button>
    </form>
</div>

<?php if ($search !== ''): ?>
<table border="1" width="80%" style="margin:0 auto;border-collapse:collapse;">
    <tr>
        <th>ID</th><th>Name</th><th>Phone</th><th>Shop</th><th>Actions</th>
    </tr>
    <?php
    $like = "%$search%";
    $stmt = mysqli_prepare($conn, "SELECT * FROM vendors WHERE name LIKE ?");
    mysqli_stmt_bind_param($stmt, "s", $like);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)):
    ?>
    <tr>
        <td><?php echo (int)$row['vendor_id']; ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['phone']); ?></td>
        <td><?php echo htmlspecialchars($row['shop_name']); ?></td>
        <td>
            <a href="/modules/vendor/edit_vendor.php?id=<?php echo (int)$row['vendor_id']; ?>">Edit</a> |
            <a href="/modules/vendor/delete_vendor.php?id=<?php echo (int)$row['vendor_id']; ?>"
               onclick="return confirm('Delete this vendor?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; mysqli_stmt_close($stmt); ?>
</table>
<?php endif; ?>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
