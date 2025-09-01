<?php
session_start();
header('Content-Type: application/json');
require_once '../db_connect.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    $pdo = getDBConnection();
    
    switch ($action) {
        case 'add':
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'error' => 'User not logged in']);
                exit;
            }
            
            $book_id = (int)$_POST['book_id'];
            $quantity = (int)$_POST['quantity'];
            
            // Check if book exists and has stock
            $stmt = $pdo->prepare("SELECT * FROM books WHERE id = ? AND stock > 0");
            $stmt->execute([$book_id]);
            $book = $stmt->fetch();
            
            if (!$book) {
                echo json_encode(['success' => false, 'error' => 'Book not available']);
                exit;
            }
            
            // Check if item already in cart
            $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND book_id = ?");
            $stmt->execute([$_SESSION['user_id'], $book_id]);
            $cartItem = $stmt->fetch();
            
            if ($cartItem) {
                // Update quantity
                $newQuantity = $cartItem['quantity'] + $quantity;
                $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
                $stmt->execute([$newQuantity, $cartItem['id']]);
            } else {
                // Add new item
                $stmt = $pdo->prepare("INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$_SESSION['user_id'], $book_id, $quantity]);
            }
            
            echo json_encode(['success' => true, 'message' => 'Item added to cart']);
            break;
            
        case 'get':
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'error' => 'User not logged in']);
                exit;
            }
            
            $stmt = $pdo->prepare("
                SELECT c.*, b.title, b.author, b.price, b.image_url 
                FROM cart c 
                JOIN books b ON c.book_id = b.id 
                WHERE c.user_id = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $cartItems = $stmt->fetchAll();
            
            echo json_encode(['success' => true, 'cart' => $cartItems]);
            break;
            
        case 'update':
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'error' => 'User not logged in']);
                exit;
            }
            
            $cart_id = (int)$_POST['cart_id'];
            $quantity = (int)$_POST['quantity'];
            
            if ($quantity <= 0) {
                // Remove item
                $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
                $stmt->execute([$cart_id, $_SESSION['user_id']]);
            } else {
                // Update quantity
                $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
                $stmt->execute([$quantity, $cart_id, $_SESSION['user_id']]);
            }
            
            echo json_encode(['success' => true, 'message' => 'Cart updated']);
            break;
            
        case 'clear':
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'error' => 'User not logged in']);
                exit;
            }
            
            $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            
            echo json_encode(['success' => true, 'message' => 'Cart cleared']);
            break;
            
        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
    }
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}

closeDBConnection();
?>
