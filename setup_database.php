<?php
require_once 'db_connect.php';

try {
    $pdo = getDBConnection();
    
    // Create categories table
    $sql = "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) UNIQUE NOT NULL
    )";
    $pdo->exec($sql);
    echo "Categories table created successfully<br>";
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Users table created successfully<br>";
    
    // Create books table
    $sql = "CREATE TABLE IF NOT EXISTS books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(150),
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        stock INT DEFAULT 0,
        category_id INT,
        image_url VARCHAR(255),
        rating DECIMAL(3,2) DEFAULT 0.00,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id)
    )";
    $pdo->exec($sql);
    echo "Books table created successfully<br>";
    
    // Create orders table
    $sql = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        total_price DECIMAL(10,2) NOT NULL,
        order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $pdo->exec($sql);
    echo "Orders table created successfully<br>";
    
    // Create order_items table
    $sql = "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT,
        book_id INT,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id),
        FOREIGN KEY (book_id) REFERENCES books(id)
    )";
    $pdo->exec($sql);
    echo "Order items table created successfully<br>";
    
    // Create cart table
    $sql = "CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        book_id INT,
        quantity INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
        UNIQUE KEY unique_user_book (user_id, book_id)
    )";
    $pdo->exec($sql);
    echo "Cart table created successfully<br>";
    
    // Insert default categories
    $categories = ['Fiction', 'Non-Fiction', 'Children', 'Comics', 'Technology'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name) VALUES (?)");
    
    foreach ($categories as $category) {
        $stmt->execute([$category]);
    }
    echo "Default categories inserted successfully<br>";
    
    // Insert sample books
    $books = [
        ['The Midnight Library', 'Matt Haig', 'A dazzling novel about all the ways to live.', 450.00, 10, 1, 'images/indexpicture.png', 4.5],
        ['The Kite Runner', 'Khaled Hosseini', 'A powerful story of friendship and redemption.', 500.00, 8, 1, 'images/indexpic2.png', 4.2],
        ['Sapiens', 'Yuval Noah Harari', 'A brief history of humankind.', 650.00, 15, 2, 'images/indexpic3.png', 4.8],
        ['Man\'s Search for Meaning', 'Viktor E. Frankl', 'A psychiatrist\'s experiences in Nazi concentration camps.', 400.00, 12, 2, 'images/indexpic4.png', 4.9],
        ['Quiet', 'Susan Cain', 'The power of introverts in a world that can\'t stop talking.', 550.00, 7, 2, 'images/indexpic5.png', 4.3],
        ['The Innovators', 'Walter Isaacson', 'How a group of hackers, geniuses, and geeks created the digital revolution.', 700.00, 9, 5, 'images/indexpic6.png', 4.4],
        ['Atomic Habits', 'James Clear', 'Tiny changes, remarkable results.', 500.00, 20, 2, 'images/indexpic8.png', 4.7],
        ['Thinking, Fast and Slow', 'Daniel Kahneman', 'The two systems that drive the way we think.', 600.00, 11, 2, 'images/indexpic9.png', 4.6]
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO books (title, author, description, price, stock, category_id, image_url, rating) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($books as $book) {
        $stmt->execute($book);
    }
    echo "Sample books inserted successfully<br>";
    
    echo "<br>Database setup completed successfully!";
    
} catch(PDOException $e) {
    die("Database setup failed: " . $e->getMessage());
}

closeDBConnection();
?>

