<?php
// Database configuration
$host = 'localhost';
$dbname = 'online_bookstore';
$username = 'root';
$password = ''; // Try empty first, if it fails, you may need to set a password

try {
    // First try to connect to MySQL server without selecting database
    $pdo = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if database exists, if not create it
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
    if ($stmt->rowCount() == 0) {
        // Create database
        $pdo->exec("CREATE DATABASE $dbname CHARACTER SET utf8 COLLATE utf8_general_ci");
        echo "Database '$dbname' created successfully<br>";
    }
    
    // Now connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // If connection fails, try to provide helpful error message
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        die("Database connection failed: Access denied. Please check your MySQL credentials.<br><br>
             Common solutions:<br>
             1. Make sure XAMPP MySQL service is running<br>
             2. Check if MySQL root user has a password<br>
             3. If you set a password for root user, update the \$password variable in db_connect.php<br>
             4. Try using 'root' as username and your MySQL root password<br><br>
             Error details: " . $e->getMessage());
    } else {
        die("Connection failed: " . $e->getMessage());
    }
}

// Function to get database connection
function getDBConnection() {
    global $pdo;
    return $pdo;
}

// Function to close database connection
function closeDBConnection() {
    global $pdo;
    $pdo = null;
}
?>
