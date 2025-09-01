<?php
// Database Connection Test
echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Connection Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .success { color: #2e7d32; background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { color: #d32f2f; background: #ffebee; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .info { color: #1976d2; background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .btn { background: #0FA4AF; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🧪 Database Connection Test</h1>
        
        <div class='info'>
            <strong>Purpose:</strong> This page tests if your database connection is working correctly.
        </div>";

try {
    echo "<h2>Step 1: Testing Database Connection</h2>";
    
    // Test basic connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    
    $conn = mysqli_connect("localhost", "root", "");

    
    if ($conn->connect_error) {
        throw new Exception("Connection to MySQL server failed: " . $conn->connect_error);
    }
    
    echo "<div class='success'>
        <h3>✅ MySQL Server Connection Successful!</h3>
        <p><strong>Server:</strong> " . $servername . "</p>
        <p><strong>Username:</strong> " . $username . "</p>
        <p><strong>PHP Version:</strong> " . phpversion() . "</p>
        <p><strong>MySQL Version:</strong> " . $conn->server_info . "</p>
    </div>";
    
    // Test database creation
    echo "<h2>Step 2: Testing Database Creation</h2>";
    $dbname = "online_bookstore";
    
    $result = $conn->query("SHOW DATABASES LIKE '$dbname'");
    if ($result->num_rows == 0) {
        // Create database
        $sql = "CREATE DATABASE $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='success'>
                <h3>✅ Database Created Successfully!</h3>
                <p><strong>Database Name:</strong> $dbname</p>
            </div>";
        } else {
            throw new Exception("Error creating database: " . $conn->error);
        }
    } else {
        echo "<div class='success'>
            <h3>✅ Database Already Exists!</h3>
            <p><strong>Database Name:</strong> $dbname</p>
        </div>";
    }
    
    // Select database
    if (!$conn->select_db($dbname)) {
        throw new Exception("Error selecting database: " . $conn->error);
    }
    
    echo "<div class='success'>
        <h3>✅ Database Selected Successfully!</h3>
        <p><strong>Current Database:</strong> $dbname</p>
    </div>";
    
    // Test table creation
    echo "<h2>Step 3: Testing Table Creation</h2>";
    
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
            echo "<div class='success'>
                <h3>✅ Users Table Created Successfully!</h3>
                <p><strong>Table Name:</strong> users</p>
            </div>";
        } else {
            throw new Exception("Error creating users table: " . $conn->error);
        }
    } else {
        echo "<div class='success'>
            <h3>✅ Users Table Already Exists!</h3>
            <p><strong>Table Name:</strong> users</p>
        </div>";
    }
    
    // Test insert and select
    echo "<h2>Step 4: Testing Data Operations</h2>";
    
    // Try to insert a test user
    $testUsername = "test_user_" . time();
    $testEmail = "test" . time() . "@example.com";
    $testPassword = password_hash("test123", PASSWORD_DEFAULT);
    
    $insertTest = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertTest);
    
    if ($stmt) {
        $stmt->bind_param("sss", $testUsername, $testEmail, $testPassword);
        
        if ($stmt->execute()) {
            echo "<div class='success'>
                <h3>✅ Test User Inserted Successfully!</h3>
                <p><strong>Username:</strong> $testUsername</p>
                <p><strong>Email:</strong> $testEmail</p>
            </div>";
            
            // Now test select
            $selectTest = "SELECT id, username, email FROM users WHERE username = ?";
            $selectStmt = $conn->prepare($selectTest);
            $selectStmt->bind_param("s", $testUsername);
            $selectStmt->execute();
            $result = $selectStmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                echo "<div class='success'>
                    <h3>✅ Test User Retrieved Successfully!</h3>
                    <p><strong>ID:</strong> " . $user['id'] . "</p>
                    <p><strong>Username:</strong> " . $user['username'] . "</p>
                    <p><strong>Email:</strong> " . $user['email'] . "</p>
                </div>";
            }
            
            $selectStmt->close();
            
            // Clean up test user
            $deleteTest = "DELETE FROM users WHERE username = ?";
            $deleteStmt = $conn->prepare($deleteTest);
            $deleteStmt->bind_param("s", $testUsername);
            $deleteStmt->execute();
            $deleteStmt->close();
            
        } else {
            throw new Exception("Error inserting test user: " . $stmt->error);
        }
        
        $stmt->close();
    } else {
        throw new Exception("Error preparing insert statement: " . $conn->error);
    }
    
    echo "<div class='success'>
        <h3>🎉 All Database Tests Passed!</h3>
        <p>Your database connection is working perfectly. You can now use the signup and signin functionality.</p>
    </div>";
    
    // Show current tables
    echo "<h2>Step 5: Current Database Structure</h2>";
    $tables = $conn->query("SHOW TABLES");
    if ($tables->num_rows > 0) {
        echo "<div class='info'>
            <h3>Tables in Database:</h3>
            <ul>";
        while ($table = $tables->fetch_array()) {
            echo "<li><strong>" . $table[0] . "</strong></li>";
        }
        echo "</ul></div>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>
        <h3>❌ Database Test Failed!</h3>
        <p><strong>Error:</strong> " . $e->getMessage() . "</p>
        <p><strong>Common Solutions:</strong></p>
        <ul>
            <li>Make sure XAMPP is running</li>
            <li>Start MySQL service in XAMPP Control Panel</li>
            <li>Check if port 3306 is available</li>
            <li>Verify MySQL credentials (default: root, no password)</li>
        </ul>
    </div>";
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}

echo "<div style='text-align: center; margin-top: 30px;'>
    <a href='index.html' class='btn'>← Back to Homepage</a>
    <a href='signup.html' class='btn'>Try Sign Up</a>
    <a href='signin.html' class='btn'>Try Sign In</a>
</div>
</div>
</body>
</html>";
?>
