<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bookly - Contact</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      /* Contact Page Styling */
      .contact-page {
        padding: 2rem;
        max-width: 1100px;
        margin: auto;
      }
      .contact-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        align-items: start;
      }
      .contact-form {
        background: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }
      .contact-form label {
        font-weight: 600;
        margin-bottom: 0.25rem;
      }
      .contact-form input,
      .contact-form textarea {
        padding: 0.75rem 1rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        width: 100%;
      }
      .contact-form input:focus,
      .contact-form textarea:focus {
        border-color: #FF69B4;
        outline: none;
        box-shadow: 0 0 0 2px rgba(255,105,180,0.2);
      }
      .contact-form button {
        background: #FF69B4;
        color: white;
        border: none;
        padding: 0.75rem;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
      }
      .contact-form button:hover {
        background: #FF1493;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255,20,147,0.3);
      }
      .map-section {
        background: #fff;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      }
      .map-section h3 {
        margin-bottom: 1rem;
      }
      .map-section iframe {
        width: 100%;
        height: 350px;
        border: none;
        border-radius: 8px;
      }
      @media (max-width: 768px) {
        .contact-wrapper {
          grid-template-columns: 1fr;
        }
      }
    </style>
  </head>
  <body>
    <div class="main-container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="relative-content">
          <a href="index.html" class="logo-link"><h1>Bookly</h1></a>
          <nav class="sidebar-nav">
            <a href="category-fiction.html">Fiction</a>
            <a href="non-fiction.html">Non-Fiction</a>
            <a href="children.html">Children</a>
            <a href="comics.html">Comics</a>
            <a href="technology.html">Technology</a>
          </nav>
        </div>
      </aside>

      <!-- Main Content -->
      <main class="main-content">
        <!-- Header -->
        <header class="header">
          <div class="header-top">
            <nav class="header-nav">
              <a href="index.html">HOME</a>
              <a href="help.html">HELP</a>
              <a href="about.html">ABOUT US</a>
              <a href="contact.php" class="active">CONTACT</a>
              <a href="faq.html">FAQ'S</a>
            </nav>
            <div class="header-actions">
              <a href="#" class="header-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor">
                  <circle cx="9" cy="21" r="1"></circle>
                  <circle cx="20" cy="21" r="1"></circle>
                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>CART</span>
              </a>
              <a href="signin.html" class="header-button" id="authButton"><span>SIGN IN</span></a>
              <a href="signin.html" class="profile-button" id="profileButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
              </a>
            </div>
          </div>
        </header>


<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$successMsg = '';
$errorMsg = '';

if(isset($_POST['send'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if(empty($name) || empty($email) || empty($message)) {
        $errorMsg = "Please fill in all required fields.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Please enter a valid email address.";
    } else {
        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'potabattipurva21@gmail.com'; // your Gmail
            $mail->Password   = 'jnstkdelhjzzftvx';          // App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($email, $name);
            $mail->addAddress('potabattipurva21@gmail.com', 'Bookly Contact'); // your receiving email

            $mail->isHTML(true);
            $mail->Subject = "New Contact Form Submission";
            $mail->Body    = "
                <h3>Contact Form Details</h3>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Message:</strong><br>$message</p>
            ";

            $mail->send();
            $successMsg = "✅ Message sent successfully!";
        } catch (Exception $e) {
            $errorMsg = "⚠️ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bookly - Contact</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      /* Contact Page Styling */
      .contact-page { padding: 2rem; max-width: 1100px; margin: auto; }
      .contact-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start; }
      .contact-form { background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); display: flex; flex-direction: column; gap: 1rem; }
      .contact-form label { font-weight: 600; margin-bottom: 0.25rem; }
      .contact-form input, .contact-form textarea { padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem; width: 100%; }
      .contact-form input:focus, .contact-form textarea:focus { border-color: #FF69B4; outline: none; box-shadow: 0 0 0 2px rgba(255,105,180,0.2); }
      .contact-form button { background: #FF69B4; color: white; border: none; padding: 0.75rem; border-radius: 6px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
      .contact-form button:hover { background: #FF1493; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255,20,147,0.3); }
      .map-section { background: #fff; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
      .map-section h3 { margin-bottom: 1rem; }
      .map-section iframe { width: 100%; height: 350px; border: none; border-radius: 8px; }
      .alert { background-color: rgb(252,59,59); color: #fff; text-align: center; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; }
      .success { background-color: rgb(44,158,24); color: #fff; text-align: center; padding: 0.75rem; border-radius: 6px; margin-bottom: 1rem; }
      @media (max-width: 768px) { .contact-wrapper { grid-template-columns: 1fr; } }
    </style>
  </head>
  <body>
    <div class="page-content contact-page">
      <h2>Contact Us</h2>
      <p style="margin-bottom: 2rem; font-size: 1.1rem; color: #5a5a5a;">
        We'd love to hear from you! Whether you have a question about our books, need help with your order, or just want to say hello — fill out the form below and we'll get back to you soon.
      </p>

      <?php if($errorMsg): ?>
        <div class="alert"><?= $errorMsg ?></div>
      <?php endif; ?>
      <?php if($successMsg): ?>
        <div class="success"><?= $successMsg ?></div>
      <?php endif; ?>

      <div class="contact-wrapper">
        <!-- Contact Form -->
        <form class="contact-form" method="POST" action="">
          <label for="name">👤 Full Name</label>
          <input type="text" id="name" name="name" required />

          <label for="email">📧 Email</label>
          <input type="email" id="email" name="email" required />

          <label for="phone">📱 Phone Number</label>
          <input type="tel" id="phone" name="phone" />

          <label for="message">📝 Message</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <button type="submit" name="send">Send Message</button>
        </form>

        <!-- Map -->
        <div class="map-section">
          <h3>📍 Our Location</h3>
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3781.672676690277!2d73.84870167496308!3d18.48620368260657!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2ea6b61fc0297%3A0xfbcfc58ae1e78e82!2sPune%20Institute%20Of%20Computer%20Technology%20(PICT)!5e0!3m2!1sen!2sin!4v1725558012345!5m2!1sen!2sin" 
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>
  </body>
</html>
