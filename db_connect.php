<?php
// Enhanced Database Connection with Error Handling
$servername = "localhost";
$username = "root"; // default XAMPP user
$password = "";     // default empty password in XAMPP
$dbname = "online_bookstore";

try {
    // First, try to connect to MySQL server (without selecting database)
    $conn = mysqli_connect("localhost", "root", "");

    
    if ($conn->connect_error) {
        throw new Exception("Connection to MySQL server failed: " . $conn->connect_error);
    }
    
    // Set charset for security
    $conn->set_charset("utf8mb4");
    
    // Check if database exists, if not create it
    $result = $conn->query("SHOW DATABASES LIKE '$dbname'");
    if ($result->num_rows == 0) {
        // Database doesn't exist, create it
        $sql = "CREATE DATABASE $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        if ($conn->query($sql) === TRUE) {
            echo "Database '$dbname' created successfully<br>";
        } else {
            throw new Exception("Error creating database: " . $conn->error);
        }
    }
    
    // Now select the database
    if (!$conn->select_db($dbname)) {
        throw new Exception("Error selecting database: " . $conn->error);
    }
    
    // Test the connection
    if ($conn->ping()) {
        // Connection is working
        $conn->query("SELECT 1"); // Simple test query
    } else {
        throw new Exception("Database connection lost");
    }
    
} catch (Exception $e) {
    die("Database Error: " . $e->getMessage() . "<br>Please make sure XAMPP is running and MySQL service is started.");
}

// Function to get connection
function getConnection() {
    global $conn;
    return $conn;
}

// Function to close connection
function closeConnection() {
    global $conn;
    if ($conn) {
        $conn->close();
    }
}
?>
