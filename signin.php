<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if this is a POST request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // If not POST, show a helpful message instead of error
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Bookly - Sign In</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
            .container { max-width: 500px; margin: 0 auto; }
            .error { color: #d32f2f; background: #ffebee; padding: 20px; border-radius: 8px; margin: 20px 0; }
            .info { color: #1976d2; background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0; }
            .btn { background: #0FA4AF; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; margin: 10px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>🚫 Access Denied</h1>
            <div class='error'>
                <h3>This page cannot be accessed directly</h3>
                <p>The signin.php file is designed to handle form submissions, not direct browser access.</p>
            </div>
            <div class='info'>
                <h3>How to use:</h3>
                <p>1. Go to the <a href='signin.html' class='btn'>Sign In Page</a></p>
                <p>2. Fill out the form with your email and password</p>
                <p>3. Click the SIGN IN button</p>
            </div>
            <p><a href='index.html' class='btn'>← Back to Homepage</a></p>
        </div>
    </body>
    </html>";
    exit();
}

session_start();

// Include the enhanced database connection
require_once 'db_connect.php';

try {
    // Get database connection
    $conn = getConnection();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        
        // Basic validation
        if (empty($email) || empty($password)) {
            echo "<script>alert('Please fill in all fields.'); window.location.href='signin.html';</script>";
            exit();
        }
        
        // Email format validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Please enter a valid email address.'); window.location.href='signin.html';</script>";
            exit();
        }
        
        // Check if users table exists, if not create it
        $tableCheck = $conn->query("SHOW TABLES LIKE 'users'");
        if ($tableCheck->num_rows == 0) {
            // Create users table
            $createTable = "CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) UNIQUE NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            if ($conn->query($createTable) === TRUE) {
                echo "<script>alert('Users table created. Please sign up first.'); window.location.href='signup.html';</script>";
                exit();
            } else {
                throw new Exception("Error creating users table: " . $conn->error);
            }
        }
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ? LIMIT 1");
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $conn->error);
        }
        
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Success → Start session and store user info
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['is_logged_in'] = true;
                
                // Store in localStorage for frontend use
                $userData = [
                    'id' => $user['id'],
                    'name' => $user['username'],
                    'email' => $user['email'],
                    'isLoggedIn' => true
                ];
                
                // Redirect to homepage with success message
                echo "<script>
                    localStorage.setItem('booklyUser', JSON.stringify(" . json_encode($userData) . "));
                    alert('Welcome back, " . htmlspecialchars($user['username']) . "! You have successfully signed in.');
                    window.location.href='index.html';
                </script>";
                
            } else {
                // Wrong password
                echo "<script>alert('Incorrect password. Please try again.'); window.location.href='signin.html';</script>";
            }
        } else {
            // Email not found - redirect to signup
            echo "<script>
                if (confirm('This email is not registered. Would you like to create a new account?')) {
                    window.location.href='signup.html';
                } else {
                    window.location.href='signin.html';
                }
            </script>";
        }
        
        $stmt->close();
        
    }
    
} catch (Exception $e) {
    echo "<script>alert('Database error: " . addslashes($e->getMessage()) . "\\n\\nPlease make sure:\\n1. XAMPP is running\\n2. MySQL service is started\\n3. Database connection is working'); window.location.href='signin.html';</script>";
} finally {
    // Close connection
    closeConnection();
}
?>
