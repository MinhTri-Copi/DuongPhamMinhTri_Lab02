<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
class ProductApiController
{
private $productModel;
private $db;
public function __construct()
{
$this->db = (new Database())->getConnection();
$this->productModel = new ProductModel($this->db);
}
// Lấy tất cả sản phẩm
public function index()
{
    header('Content-Type: application/json');
    $products = $this->productModel->getProductsForApi();
    echo json_encode($products);
}
// Lấy sản phẩm theo ID
public function show($id = null)
{
    header('Content-Type: application/json');
    if (!$id) {
        http_response_code(400);
        echo json_encode(['message' => 'Product ID is required']);
        return;
    }
    $product = $this->productModel->getProductByIdForApi($id);
    if ($product) {
        echo json_encode($product);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Product not found']);
    }
}
// Thêm sản phẩm mới
public function store()
{
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'] ?? '';
$description = $data['description'] ?? '';
$price = $data['price'] ?? '';
$category_id = $data['category_id'] ?? null;

// Kiểm tra category tồn tại
if ($category_id) {
    $checkCategory = "SELECT id FROM category WHERE id = :category_id";
    $stmt = $this->db->prepare($checkCategory);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->execute();
    
    if (!$stmt->fetch()) {
        http_response_code(400);
        echo json_encode(['message' => 'Category không tồn tại']);
        return;
    }
}

$result = $this->productModel->addProduct($name, $description, $price, 
$category_id);
if (is_array($result)) {
    http_response_code(400);
    echo json_encode(['errors' => $result]);
    } else {
    http_response_code(201);
    echo json_encode(['message' => 'Product created successfully']);
    }
}
// Cập nhật sản phẩm theo ID
public function update($id = null)
{
header('Content-Type: application/json');

if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Product ID is required for update']);
    return;
}

// Kiểm tra sản phẩm tồn tại trước khi cập nhật
$currentProduct = $this->productModel->getProductByIdForApi($id);
if (!$currentProduct) {
    http_response_code(404);
    echo json_encode(['message' => 'Product not found']);
    return;
}

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents("php://input"), true);

// Ghi log dữ liệu nhận được
error_log("Received data for update: " . print_r($data, true));

// Sử dụng giá trị hiện tại nếu không có giá trị mới
$name = isset($data['name']) && !empty($data['name']) ? $data['name'] : $currentProduct['name'];
$description = isset($data['description']) && !empty($data['description']) ? $data['description'] : $currentProduct['description'];
$price = isset($data['price']) && !empty($data['price']) ? $data['price'] : $currentProduct['price'];

// Xử lý category - chỉ sử dụng category_id
$category_id = null;
if (isset($data['category_id']) && !empty($data['category_id'])) {
    $category_id = (int)$data['category_id'];
}

// Nếu không có category_id mới, giữ nguyên giá trị cũ
if ($category_id === null && isset($currentProduct['category_id'])) {
    $category_id = (int)$currentProduct['category_id'];
    error_log("Using existing category ID: $category_id");
}

// Debug
error_log("Updating product ID: $id");
error_log("Name: $name");
error_log("Description: $description");
error_log("Price: $price");
error_log("Category ID: $category_id");

// Kiểm tra category tồn tại
if ($category_id) {
    $checkCategory = "SELECT id FROM category WHERE id = :category_id";
    $stmt = $this->db->prepare($checkCategory);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->execute();
    
    $categoryExists = $stmt->fetch();
    error_log("Category exists check result: " . print_r($categoryExists, true));
    
    if (!$categoryExists) {
        http_response_code(400);
        echo json_encode(['message' => 'Category không tồn tại']);
        return;
    }
}

try {
    $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id);
    if ($result) {
        // Lấy dữ liệu sau khi cập nhật để kiểm tra
        $updatedProduct = $this->productModel->getProductByIdForApi($id);
        error_log("Updated product data: " . print_r($updatedProduct, true));
        
        echo json_encode([
            'message' => 'Product updated successfully',
            'product' => $updatedProduct
        ]);
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Product update failed']);
    }
} catch (PDOException $e) {
    error_log("PDO Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'message' => 'Database error occurred',
        'error' => $e->getMessage()
    ]);
}
}
// Xóa sản phẩm theo ID
public function destroy($id)
{
header('Content-Type: application/json');
$result = $this->productModel->deleteProduct($id);
if ($result) {
echo json_encode(['message' => 'Product deleted successfully']);
} else {
http_response_code(400);
echo json_encode(['message' => 'Product deletion failed']);
}
}
}
?>
    