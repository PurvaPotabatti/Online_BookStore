<?php
require_once 'db_connect.php';

try {
    $pdo = getDBConnection();
    echo "<h2>Database Connection Test</h2>";
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // Test tables
    $tables = ['categories', 'users', 'books', 'orders', 'order_items', 'cart'];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Table '$table' exists</p>";
            
            // Count records
            $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
            echo "<p>📊 Records in $table: $count</p>";
        } else {
            echo "<p style='color: red;'>❌ Table '$table' does not exist</p>";
        }
    }
    
    // Test sample data
    echo "<h3>Sample Data Test</h3>";
    
    // Categories
    $stmt = $pdo->query("SELECT * FROM categories LIMIT 5");
    $categories = $stmt->fetchAll();
    echo "<h4>Categories:</h4>";
    foreach ($categories as $cat) {
        echo "<p>- {$cat['name']}</p>";
    }
    
    // Books
    $stmt = $pdo->query("SELECT b.*, c.name as category_name FROM books b LEFT JOIN categories c ON b.category_id = c.id LIMIT 3");
    $books = $stmt->fetchAll();
    echo "<h4>Sample Books:</h4>";
    foreach ($books as $book) {
        echo "<p>- {$book['title']} by {$book['author']} (₹{$book['price']}) - {$book['category_name']}</p>";
    }
    
    echo "<br><p><strong>Database is working correctly!</strong></p>";
    echo "<p><a href='index.html'>Go to Homepage</a></p>";
    
} catch(PDOException $e) {
    echo "<h2>Database Connection Test</h2>";
    echo "<p style='color: red;'>❌ Connection failed: " . $e->getMessage() . "</p>";
    echo "<p>Please make sure:</p>";
    echo "<ul>";
    echo "<li>XAMPP is running</li>";
    echo "<li>MySQL service is started</li>";
    echo "<li>Database 'online_bookstore' exists</li>";
    echo "<li>Run setup_database.php first</li>";
    echo "</ul>";
}

closeDBConnection();
?>
