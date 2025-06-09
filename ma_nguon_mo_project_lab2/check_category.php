<?php
require_once 'app/config/database.php';

// Kết nối database
$database = new Database();
$db = $database->getConnection();

try {
    // Kiểm tra bảng category có tồn tại không
    $query = "SHOW TABLES LIKE 'category'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $tableExists = $stmt->fetchColumn();
    
    echo "<h2>Kiểm tra bảng category</h2>";
    echo "Bảng category " . ($tableExists ? "tồn tại" : "không tồn tại") . "<br>";
    
    if ($tableExists) {
        // Lấy cấu trúc bảng category
        $query = "DESCRIBE category";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $structure = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Cấu trúc bảng category</h3>";
        echo "<pre>";
        print_r($structure);
        echo "</pre>";
        
        // Lấy dữ liệu từ bảng category
        $query = "SELECT * FROM category";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Dữ liệu trong bảng category</h3>";
        echo "<pre>";
        print_r($categories);
        echo "</pre>";
    }
    
    // Kiểm tra các sản phẩm và danh mục của chúng
    $query = "SELECT p.id, p.name, p.category_id, c.id as cat_id, c.name as category_name
              FROM product p
              LEFT JOIN category c ON p.category_id = c.id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Kiểm tra JOIN giữa product và category</h3>";
    echo "<pre>";
    print_r($products);
    echo "</pre>";
    
} catch (PDOException $e) {
    echo "<h2>Lỗi</h2>";
    echo "<p>Đã xảy ra lỗi: " . $e->getMessage() . "</p>";
}
?> 