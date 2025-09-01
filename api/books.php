<?php
header('Content-Type: application/json');
require_once '../db_connect.php';

try {
    $pdo = getDBConnection();
    
    // Get category filter if provided
    $category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    // Build query
    $sql = "SELECT b.*, c.name as category_name 
            FROM books b 
            LEFT JOIN categories c ON b.category_id = c.id 
            WHERE 1=1";
    $params = [];
    
    if ($category_id) {
        $sql .= " AND b.category_id = ?";
        $params[] = $category_id;
    }
    
    if ($search) {
        $sql .= " AND (b.title LIKE ? OR b.author LIKE ? OR b.description LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    $sql .= " ORDER BY b.created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $books = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'books' => $books
    ]);
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}

closeDBConnection();
?>
