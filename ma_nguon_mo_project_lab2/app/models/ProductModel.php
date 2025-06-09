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
public function addProduct($name, $description, $price, $category_id)
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
category_id) VALUES (:name, :description, :price, :category_id)";
$stmt = $this->conn->prepare($query);
$name = htmlspecialchars(strip_tags($name));
$description = htmlspecialchars(strip_tags($description));
$price = htmlspecialchars(strip_tags($price));
$category_id = htmlspecialchars(strip_tags($category_id));
$stmt->bindParam(':name', $name);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':price', $price);
$stmt->bindParam(':category_id', $category_id);
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
$category_id
) {
    // Bắt đầu transaction
    $this->conn->beginTransaction();

    try {
        // Ghi log các giá trị trước khi cập nhật
        error_log("ProductModel::updateProduct - ID: $id");
        error_log("ProductModel::updateProduct - Name: $name");
        error_log("ProductModel::updateProduct - Description: $description");
        error_log("ProductModel::updateProduct - Price: $price");
        error_log("ProductModel::updateProduct - Category ID: $category_id");

        // Kiểm tra xem sản phẩm có tồn tại không
        $checkProduct = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($checkProduct);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            error_log("ProductModel::updateProduct - Product ID $id not found");
            $this->conn->rollBack();
            return false;
        }
        
        error_log("ProductModel::updateProduct - Existing product: " . print_r($product, true));

        // Kiểm tra category_id
        if ($category_id !== null) {
            $checkCategory = "SELECT id FROM category WHERE id = :category_id";
            $stmt = $this->conn->prepare($checkCategory);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->execute();
            
            if (!$stmt->fetch()) {
                error_log("ProductModel::updateProduct - Category ID $category_id not found");
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
        
        // Nếu không có trường nào cần cập nhật
        if (empty($updateFields)) {
            error_log("ProductModel::updateProduct - No fields to update");
            $this->conn->commit();
            return true;
        }
        
        // Tạo câu query cập nhật
        $query = "UPDATE " . $this->table_name . " SET " . implode(", ", $updateFields) . " WHERE id = :id";
        error_log("ProductModel::updateProduct - Update query: $query");
        
        $stmt = $this->conn->prepare($query);
        
        // Bind ID
        $stmt->bindParam(':id', $id);
        
        // Bind các tham số khác
        foreach ($bindParams as $param => $value) {
            $stmt->bindValue($param, $value);
            error_log("ProductModel::updateProduct - Binding $param: $value");
        }
        
        $result = $stmt->execute();
        error_log("ProductModel::updateProduct - Execute result: " . ($result ? 'true' : 'false'));
        
        if ($result) {
            $this->conn->commit();
            
            // Kiểm tra lại dữ liệu sau khi cập nhật
            $checkUpdated = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($checkUpdated);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $updatedProduct = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("ProductModel::updateProduct - Updated product: " . print_r($updatedProduct, true));
            
            return true;
        } else {
            $this->conn->rollBack();
            error_log("ProductModel::updateProduct - Update failed");
            return false;
        }
    } catch (PDOException $e) {
        $this->conn->rollBack();
        error_log("ProductModel::updateProduct - PDO Error: " . $e->getMessage());
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