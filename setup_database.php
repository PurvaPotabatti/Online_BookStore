<?php
// Database setup script for Online Bookstore
// Run this script once to create the necessary database and tables

$host = "localhost";
$user = "root";
$pass = "";
$db_name = "online_bookstore";

try {
    // Create connection without database
    $conn = new mysqli($servername, $username, $password, $database);

    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($conn->query($sql) === TRUE) {
        echo "Database '$db_name' created successfully or already exists<br>";
    } else {
        throw new Exception("Error creating database: " . $conn->error);
    }
    
    // Select the database
    $conn->select_db($db_name);
    
    // Create users table
    $users_table = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_username (username),
        INDEX idx_email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($users_table) === TRUE) {
        echo "Users table created successfully or already exists<br>";
    } else {
        throw new Exception("Error creating users table: " . $conn->error);
    }
    
    // Create books table
    $books_table = "CREATE TABLE IF NOT EXISTS books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        category VARCHAR(100) NOT NULL,
        image_url VARCHAR(500),
        rating DECIMAL(3,2) DEFAULT 0.00,
        stock_quantity INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_category (category),
        INDEX idx_author (author),
        INDEX idx_title (title)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($books_table) === TRUE) {
        echo "Books table created successfully or already exists<br>";
    } else {
        throw new Exception("Error creating books table: " . $conn->error);
    }
    
    // Create orders table
    $orders_table = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        total_amount DECIMAL(10,2) NOT NULL,
        status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_user_id (user_id),
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($orders_table) === TRUE) {
        echo "Orders table created successfully or already exists<br>";
    } else {
        throw new Exception("Error creating orders table: " . $conn->error);
    }
    
    // Create order_items table
    $order_items_table = "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        book_id INT NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
        INDEX idx_order_id (order_id),
        INDEX idx_book_id (book_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($order_items_table) === TRUE) {
        echo "Order items table created successfully or already exists<br>";
    } else {
        throw new Exception("Error creating order items table: " . $conn->error);
    }
    
    // Create cart table
    $cart_table = "CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        book_id INT NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
        UNIQUE KEY unique_user_book (user_id, book_id),
        INDEX idx_user_id (user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($cart_table) === TRUE) {
        echo "Cart table created successfully or already exists<br>";
    } else {
        throw new Exception("Error creating cart table: " . $conn->error);
    }
    
    // Insert sample books data
    $sample_books = [
        ['The Great Gatsby', 'F. Scott Fitzgerald', 'A story of the fabulously wealthy Jay Gatsby and his love for the beautiful Daisy Buchanan.', 12.99, 'Fiction', 'images/beautiful.jpg', 4.5, 50],
        ['To Kill a Mockingbird', 'Harper Lee', 'The story of young Scout Finch and her father Atticus in a racially divided Alabama town.', 14.99, 'Fiction', 'images/becoming.jpg', 4.8, 45],
        ['1984', 'George Orwell', 'A dystopian novel about totalitarianism and surveillance society.', 11.99, 'Fiction', 'images/bird_box.jpg', 4.6, 60],
        ['Pride and Prejudice', 'Jane Austen', 'A romantic novel of manners that follows the emotional development of Elizabeth Bennet.', 13.99, 'Fiction', 'images/blue_train.jpg', 4.7, 40],
        ['The Hobbit', 'J.R.R. Tolkien', 'A fantasy novel about Bilbo Baggins journey with thirteen dwarves.', 15.99, 'Fantasy', 'images/hobbit.jpg', 4.9, 55]
    ];
    
    $insert_book = "INSERT IGNORE INTO books (title, author, description, price, category, image_url, rating, stock_quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_book);
    
    foreach ($sample_books as $book) {
        $stmt->bind_param("ssdssdi", $book[0], $book[1], $book[2], $book[3], $book[4], $book[5], $book[6], $book[7]);
        $stmt->execute();
    }
    
    echo "Sample books data inserted successfully<br>";
    $stmt->close();
    
    echo "<br><strong>Database setup completed successfully!</strong><br>";
    echo "You can now use the signup and signin functionality.<br>";
    echo "<a href='signup.html'>Go to Signup Page</a> | <a href='index.html'>Go to Home Page</a>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>

