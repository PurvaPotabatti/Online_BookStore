<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Validation
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    if (empty($errors)) {
        try {
            $pdo = getDBConnection();
            
            // Check if user exists and verify password
            $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['is_logged_in'] = true;
                
                $response = [
                    'success' => true,
                    'message' => 'Login successful!',
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email']
                    ]
                ];
                echo json_encode($response);
                exit;
            } else {
                $errors[] = "Invalid username/email or password";
            }
            
        } catch(PDOException $e) {
            $errors[] = "Login failed: " . $e->getMessage();
        }
    }
    
    if (!empty($errors)) {
        $response = [
            'success' => false,
            'errors' => $errors
        ];
        echo json_encode($response);
        exit;
    }
}

// If not POST request, redirect to signin page
header('Location: signin.html');
exit;
?>
