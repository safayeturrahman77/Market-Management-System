<?php
$page_title = $page_title ?? 'Market Management System';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/main.js" defer></script>
</head>
<body>
<div class="navbar">
    <h1 class="logo">Market Management System</h1>
    <div class="nav-links">
        <a href="/public/index.php">Home</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="/modules/admin/dashboard.php">Dashboard</a>
            <a href="/auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="/auth/login.php">Login</a>
            <a href="/auth/register.php">Register</a>
        <?php endif; ?>
    </div>
</div>
