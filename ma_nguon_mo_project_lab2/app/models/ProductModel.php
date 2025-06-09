<?php
class ProductModel
{
private $conn;
private $table_name = "product";
public function __construct($db)
{
$this->conn = $db;
}
public function getProducts()
{
$query = "SELECT p.*, c.name as category_name
FROM " . $this->table_name . " p
LEFT JOIN category c ON p.category_id = c.id";
$stmt = $this->conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
return $result;
}
public function getProductById($id)
{
    $query = "SELECT p.*, c.name as category_name 
    FROM " . $this->table_name . " p 
    LEFT JOIN category c ON p.category_id = c.id 
    WHERE p.id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result;
}
public function addProduct($name, $description, $price, $category_id, $image = null)
{
$errors = [];
if (empty($name)) {
$errors['name'] = 'Tên sản phẩm không được để trống';
}
if (empty($description)) {
$errors['description'] = 'Mô tả không được để trống';
}
if (!is_numeric($price) || $price < 0) {
$errors['price'] = 'Giá sản phẩm không hợp lệ';
}
if (count($errors) > 0) {
return $errors;
}
$query = "INSERT INTO " . $this->table_name . " (name, description, price,
category_id, image) VALUES (:name, :description, :price, :category_id, :image)";
$stmt = $this->conn->prepare($query);
$name = htmlspecialchars(strip_tags($name));
$description = htmlspecialchars(strip_tags($description));
$price = htmlspecialchars(strip_tags($price));
$category_id = htmlspecialchars(strip_tags($category_id));
if ($image) {
    $image = htmlspecialchars(strip_tags($image));
}
$stmt->bindParam(':name', $name);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':price', $price);
$stmt->bindParam(':category_id', $category_id);
$stmt->bindParam(':image', $image);
if ($stmt->execute()) {
return true;
}
return false;
}
public function updateProduct(
$id,
$name,
$description,
$price,
$category_id,
$image = null
) {
    // Bắt đầu transaction
    $this->conn->beginTransaction();

    try {
        // Kiểm tra xem sản phẩm có tồn tại không
        $checkProduct = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($checkProduct);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            $this->conn->rollBack();
            return false;
        }

        // Kiểm tra category_id
        if ($category_id !== null) {
            $checkCategory = "SELECT id FROM category WHERE id = :category_id";
            $stmt = $this->conn->prepare($checkCategory);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->execute();
            
            if (!$stmt->fetch()) {
                $this->conn->rollBack();
                return false;
            }
        }
        
        // Chỉ cập nhật các trường có giá trị
        $updateFields = [];
        $bindParams = [];
        
        if (!empty($name)) {
            $updateFields[] = "name = :name";
            $bindParams[':name'] = htmlspecialchars(strip_tags($name));
        }
        
        if (!empty($description)) {
            $updateFields[] = "description = :description";
            $bindParams[':description'] = htmlspecialchars(strip_tags($description));
        }
        
        if (!empty($price)) {
            $updateFields[] = "price = :price";
            $bindParams[':price'] = htmlspecialchars(strip_tags($price));
        }
        
        if ($category_id !== null) {
            $updateFields[] = "category_id = :category_id";
            $bindParams[':category_id'] = $category_id;
        }
        
        // Xử lý trường hợp image
        if ($image !== null) {
            // Có hình ảnh
            $updateFields[] = "image = :image";
            $bindParams[':image'] = htmlspecialchars(strip_tags($image));
        } else if ($image === null) {
            // Nếu image được gửi là null, đặt cột image thành NULL trong database
            $updateFields[] = "image = NULL";
        }
        
        // Nếu không có trường nào cần cập nhật
        if (empty($updateFields)) {
            $this->conn->commit();
            return true;
        }
        
        // Tạo câu query cập nhật
        $query = "UPDATE " . $this->table_name . " SET " . implode(", ", $updateFields) . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Bind ID
        $stmt->bindParam(':id', $id);
        
        // Bind các tham số khác
        foreach ($bindParams as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        
        $result = $stmt->execute();
        
        if ($result) {
            $this->conn->commit();
            return true;
        } else {
            $this->conn->rollBack();
            return false;
        }
    } catch (PDOException $e) {
        $this->conn->rollBack();
        throw $e;
    }
}
public function deleteProduct($id)
{
$query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
$stmt = $this->conn->prepare($query);
$stmt->bindParam(':id', $id);
if ($stmt->execute()) {
return true;
}
return false;
}
public function searchAndFilterProducts($keyword, $category_id) {
    $query = "SELECT p.*, c.name AS category_name 
              FROM product p 
              LEFT JOIN category c ON p.category_id = c.id 
              WHERE 1=1";

    // Thêm điều kiện tìm kiếm theo từ khóa
    if (!empty($keyword)) {
        $query .= " AND (p.name LIKE :keyword OR p.description LIKE :keyword)";
    }

    // Thêm điều kiện lọc theo danh mục
    if (!empty($category_id)) {
        $query .= " AND p.category_id = :category_id";
    }

    $stmt = $this->conn->prepare($query);

    // Gán giá trị cho các tham số
    if (!empty($keyword)) {
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    }
    if (!empty($category_id)) {
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

// Phương thức dành cho API - không bao gồm category_name
public function getProductsForApi()
{
    $query = "SELECT p.id, p.name, p.description, p.price, p.category_id, p.image
    FROM " . $this->table_name . " p";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $result;
}

// Phương thức dành cho API - không bao gồm category_name
public function getProductByIdForApi($id)
{
    $query = "SELECT p.* 
    FROM " . $this->table_name . " p 
    WHERE p.id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result;
}
}