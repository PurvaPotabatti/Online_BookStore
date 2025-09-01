<?php
// Start session for user management
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the enhanced database connection
require_once 'db_connect.php';

try {
    // Get database connection
    $conn = getConnection();
    
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // Validate and sanitize input
            $username = trim($_POST['username']);
            $email    = trim($_POST['email']);
            $password = $_POST['password'];
            
            // Input validation
            if (empty($username) || empty($email) || empty($password)) {
                throw new Exception("All fields are required");
            }
            
            if (strlen($username) < 3 || strlen($username) > 50) {
                throw new Exception("Username must be between 3 and 50 characters");
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Please enter a valid email address");
            }
            
            if (strlen($password) < 6) {
                throw new Exception("Password must be at least 6 characters long");
            }
            
            // Hash password with strong algorithm
            $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
            
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
                
                if (!$conn->query($createTable)) {
                    throw new Exception("Error creating users table: " . $conn->error);
                }
            }
            
            // Check if user already exists
            $check_sql = "SELECT id FROM users WHERE username = ? OR email = ?";
            $check_stmt = $conn->prepare($check_sql);
            if (!$check_stmt) {
                throw new Exception("Prepare statement failed: " . $conn->error);
            }
            
            $check_stmt->bind_param("ss", $username, $email);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            
            if ($result->num_rows > 0) {
                throw new Exception("Username or Email already exists! Please choose another.");
            }
            
            // Insert new user with prepared statement
            $insert_sql = "INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())";
            $insert_stmt = $conn->prepare($insert_sql);
            if (!$insert_stmt) {
                throw new Exception("Prepare statement failed: " . $conn->error);
            }
            
            $insert_stmt->bind_param("sss", $username, $email, $hashed_password);
            
            if ($insert_stmt->execute()) {
                // Success - redirect to signin page with success message
                echo "<script>
                    alert('Account created successfully! Please sign in with your credentials.');
                    window.location.href='signin.html?from=signup';
                </script>";
                exit();
            } else {
                throw new Exception("Error creating account: " . $insert_stmt->error);
            }
            
        } catch (Exception $e) {
            // Display error message
            echo "<script>
                alert('" . addslashes($e->getMessage()) . "'); 
                window.location.href='signup.html';
            </script>";
        } finally {
            // Close prepared statements
            if (isset($check_stmt)) $check_stmt->close();
            if (isset($insert_stmt)) $insert_stmt->close();
        }
    }
    
} catch (Exception $e) {
    echo "<script>alert('Database error: " . addslashes($e->getMessage()) . "\\n\\nPlease make sure:\\n1. XAMPP is running\\n2. MySQL service is started\\n3. Database connection is working'); window.location.href='signup.html';</script>";
} finally {
    // Close connection
    closeConnection();
}
?>
