<?php
// Alternative Database Connection with Multiple Fallback Methods
$host = 'localhost';
$dbname = 'online_bookstore';
$username = 'root';

// Try different password combinations
$passwords = ['', 'root', 'admin', 'password', '123456'];

$pdo = null;
$connected = false;

foreach ($passwords as $password) {
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
        
        $connected = true;
        echo "✅ Connected successfully with password: " . ($password === '' ? '(empty)' : $password) . "<br>";
        break;
        
    } catch(PDOException $e) {
        // Continue to next password
        continue;
    }
}

if (!$connected) {
    die("❌ All connection attempts failed!<br><br>
         Please check:<br>
         1. XAMPP MySQL service is running<br>
         2. MySQL is accessible<br>
         3. Try accessing phpMyAdmin from XAMPP Control Panel<br>
         4. Restart XAMPP completely<br><br>
         Last error: " . $e->getMessage());
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
