<?php
require_once 'db_connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert'>Enter a valid email</div>";
        exit;
    }

    try {
        $pdo = getDBConnection();

        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Always show same response for security
        if ($user) {
            // Delete existing token for this email (optional)
            $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

            // Generate token & expiry
            $token = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Insert token into DB
            $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)")
                ->execute([$email, $token, $expires_at]);

            // Generate reset link
            $resetLink = "http://127.0.0.1//HCI_Project/reset_password.php?token=" . urlencode($token);

            // PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'potabattipurva21@gmail.com'; // your Gmail
                $mail->Password   = 'jnstkdelhjzzftvx';          // App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->setFrom('no-reply@bookstore.com', 'Bookly Support');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "
                    <h3>Password Reset Request</h3>
                    <p>Hello,</p>
                    <p>We received a request to reset your password. Click the link below to reset it:</p>
                    <a href='$resetLink'>$resetLink</a>
                    <p>This link will expire in 1 hour.</p>
                    <p>If you didn't request a password reset, you can safely ignore this email.</p>
                ";

                $mail->send();
                echo "<div class='success'>If this email exists, a reset link has been sent.</div>";
            } catch (Exception $e) {
                echo "<div class='alert'>Mailer Error: {$mail->ErrorInfo}</div>";
            }
        } else {
            // Always show success message for security
            echo "<div class='success'>If this email exists, a reset link has been sent.</div>";
        }

    } catch (Exception $e) {
        echo "<div class='alert'>Server error. Please try again later.</div>";
    }
}
?>
