<?php
session_start();
require_once 'db_connect.php';

/* Always return JSON; never echo HTML from this file */
header('Content-Type: application/json');

/* Show errors in logs, not in output (prevents broken JSON) */
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'success' => false,
            'errors'  => ['Invalid request method']
        ]);
        exit;
    }

    // Read fields safely (prevents "Undefined array key")
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = $_POST['password'] ?? '';
    // IMPORTANT: matches name="confirm_password" in signup.html
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation (unchanged logic, just safer access)
    $errors = [];

    if ($username === '') {
        $errors[] = "Username is required";
    } elseif (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long";
    }

    if ($email === '') {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }

    if ($password === '') {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    // DB work (PDO path consistent with getDBConnection)
    $pdo = getDBConnection();

    // Check username dup
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'errors' => ['Username already exists']]);
        exit;
    }

    // Check email dup
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'errors' => ['Email already exists']]);
        exit;
    }

    // Create user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashed_password]);

    echo json_encode([
        'success' => true,
        'message' => 'Registration successful! You can now sign in.'
    ]);
    exit;

} catch (PDOException $e) {
    // Return JSON, not raw PHP error text
    echo json_encode([
        'success' => false,
        'errors'  => ['Registration failed: ' . $e->getMessage()]
    ]);
    exit;
}
