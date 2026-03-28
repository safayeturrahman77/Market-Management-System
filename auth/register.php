<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /public/register.html");
    exit();
}

$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $email === '' || $password === '') {
    header("Location: /public/register.html?error=All+fields+required");
    exit();
}

// Check username is not already taken
$check = mysqli_prepare($conn, "SELECT user_id FROM users WHERE username=?");
mysqli_stmt_bind_param($check, "s", $username);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) > 0) {
    mysqli_stmt_close($check);
    header("Location: /public/register.html?error=Username+already+taken");
    exit();
}
mysqli_stmt_close($check);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    // Fixed: original code echoed then redirected — headers already sent
    header("Location: /public/login.html?msg=Registration+Successful");
    exit();
} else {
    echo "Error: " . htmlspecialchars(mysqli_error($conn));
}
?>
