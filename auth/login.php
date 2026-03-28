<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /public/login.html");
    exit();
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    header("Location: /public/login.html?error=All+fields+required");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username=?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['role']     = $row['role'] ?? 'user';

        mysqli_stmt_close($stmt);

        if ($_SESSION['role'] === 'admin') {
            header("Location: /modules/admin/dashboard.php");
        } elseif ($_SESSION['role'] === 'vendor') {
            header("Location: /modules/vendor/vendor_dashboard.php");
        } else {
            header("Location: /modules/admin/dashboard.php");
        }
        exit();
    }
}

mysqli_stmt_close($stmt);
header("Location: /public/login.html?error=Invalid+username+or+password");
exit();
?>
