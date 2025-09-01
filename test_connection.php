<?php
echo "<h2>MySQL Connection Test</h2>";

// Test different connection methods
$host = 'localhost';
$username = 'root';
$password = '';

echo "<h3>Testing Connection Methods:</h3>";

// Method 1: Try without password
echo "<h4>Method 1: No password</h4>";
try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    echo "✅ Success: Connected to MySQL server without password<br>";
    $pdo = null;
} catch(PDOException $e) {
    echo "❌ Failed: " . $e->getMessage() . "<br>";
}

// Method 2: Try with common XAMPP password
echo "<h4>Method 2: Common XAMPP password</h4>";
try {
    $pdo = new PDO("mysql:host=$host", $username, '');
    echo "✅ Success: Connected to MySQL server with empty password<br>";
    $pdo = null;
} catch(PDOException $e) {
    echo "❌ Failed: " . $e->getMessage() . "<br>";
}

// Method 3: Try with 'root' as password
echo "<h4>Method 3: 'root' as password</h4>";
try {
    $pdo = new PDO("mysql:host=$host", $username, 'root');
    echo "✅ Success: Connected to MySQL server with 'root' password<br>";
    $pdo = null;
} catch(PDOException $e) {
    echo "❌ Failed: " . $e->getMessage() . "<br>";
}

// Method 4: Try with 'admin' as password
echo "<h4>Method 4: 'admin' as password</h4>";
try {
    $pdo = new PDO("mysql:host=$host", $username, 'admin');
    echo "✅ Success: Connected to MySQL server with 'admin' password<br>";
    $pdo = null;
} catch(PDOException $e) {
    echo "❌ Failed: " . $e->getMessage() . "<br>";
}

echo "<br><h3>Next Steps:</h3>";
echo "<p>1. If any method above shows 'Success', update the \$password variable in db_connect.php</p>";
echo "<p>2. If all methods fail, check XAMPP Control Panel:</p>";
echo "<ul>";
echo "<li>Make sure MySQL service is running (should show green)</li>";
echo "<li>Click on MySQL 'Admin' button to open phpMyAdmin</li>";
echo "<li>Check if you can access phpMyAdmin</li>";
echo "</ul>";

echo "<p>3. If you can access phpMyAdmin, the issue might be with the PHP connection</p>";
echo "<p>4. Try restarting XAMPP completely</p>";

echo "<br><p><a href='index.html'>← Back to Homepage</a></p>";
?>
