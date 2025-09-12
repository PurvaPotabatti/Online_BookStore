<?php
require_once 'db_connect.php';
$token = $_GET['token'] ?? '';

if (!$token) {
    die("Invalid request");
}

$pdo = getDBConnection();
$stmt = $pdo->prepare("SELECT email, expires_at FROM password_resets WHERE token = ? LIMIT 1");
$stmt->execute([$token]);
$reset = $stmt->fetch();

if (!$reset || strtotime($reset['expires_at']) < time()) {
    die("Invalid or expired link. Request a new one.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bookly - Reset Password</title>
  <style>
    body {
        font-family: 'Arial', sans-serif;
        background: #fff0f6;
        margin: 0;
        padding: 2rem;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
    }
    .auth-container {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        width: 360px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        text-align: center;
    }
    h2 {
        color: #FF1493;
        margin-bottom: 1.5rem;
        font-size: 1.8rem;
    }
    .input-field {
        width: 100%;
        padding: 0.9rem;
        border: 1px solid #ffc0de;
        border-radius: 10px;
        margin-bottom: 1rem;
        font-size: 1rem;
    }
    .auth-submit-btn {
        width: 100%;
        padding: 1rem;
        background: #FF1493;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: 0.3s;
    }
    .auth-submit-btn:hover {
        background: #3a2120;
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <h2>Reset Password</h2>
    <form action="reset_password_action.php" method="POST">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
      <input class="input-field" type="password" name="password" placeholder="New password" required minlength="6">
      <input class="input-field" type="password" name="confirm_password" placeholder="Confirm password" required minlength="6">
      <button class="auth-submit-btn" type="submit">Reset Password</button>
    </form>
  </div>
</body>
</html>
