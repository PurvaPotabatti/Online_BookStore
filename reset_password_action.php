<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signin.html');
    exit;
}

$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if ($password === '' || $password !== $confirm) {
    echo "<script>alert('Passwords do not match'); window.history.back();</script>";
    exit;
}

$pdo = getDBConnection();
$stmt = $pdo->prepare("SELECT email, expires_at FROM password_resets WHERE token = ? LIMIT 1");
$stmt->execute([$token]);
$reset = $stmt->fetch();

if (!$reset || strtotime($reset['expires_at']) < time()) {
    echo "<script>alert('Invalid or expired link'); window.location.href='forgot_password.html';</script>";
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$pdo->prepare("UPDATE users SET password = ? WHERE email = ?")->execute([$hashed, $reset['email']]);
$pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$reset['email']]);

echo "<script>alert('Password reset successful. Please sign in.'); window.location.href='signin.html';</script>";
?>
