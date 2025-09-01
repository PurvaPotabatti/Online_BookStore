<?php
// Database configuration
$host = 'localhost';
$dbname = 'online_bookstore';
$username = 'root';
$password = ''; // Try empty first, if it fails, set your MySQL root password

try {
    // Connect to MySQL server (without selecting database first)
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if database exists, if not create it
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("CREATE DATABASE $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Database '$dbname' created successfully<br>";
    }

    // Connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        die("❌ Database connection failed: Access denied.<br>
             ✅ Check solutions:<br>
             1. Make sure XAMPP MySQL service is running<br>
             2. Check if MySQL root user has a password<br>
             3. If yes, update \$password in db_connect.php<br>
             4. Try using 'root' as username<br><br>
             Error: " . $e->getMessage());
    } else {
        die("❌ Connection failed: " . $e->getMessage());
    }
}

// Function to get DB connection
function getDBConnection() {
    global $pdo;
    return $pdo;
}

// Function to close DB connection
function closeDBConnection() {
    global $pdo;
    $pdo = null;
}
?>
