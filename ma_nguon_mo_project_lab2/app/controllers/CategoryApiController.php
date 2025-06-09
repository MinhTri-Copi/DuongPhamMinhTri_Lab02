<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
class CategoryApiController
{
private $categoryModel;
private $db;
public function __construct()
{
$this->db = (new Database())->getConnection();
$this->categoryModel = new CategoryModel($this->db);
}
// Lấy danh sách danh mục
public function index()
{
    header('Content-Type: application/json');
    
    // Kiểm tra xem có muốn lấy kèm số lượng sản phẩm không
    $includeProductCount = isset($_GET['include_product_count']) && $_GET['include_product_count'] === 'true';
    
    if ($includeProductCount) {
        $categories = $this->categoryModel->getCategoriesWithProductCount();
    } else {
        $categories = $this->categoryModel->getCategories();
    }
    
    echo json_encode($categories);
}

// Lấy danh mục theo ID
public function show($id = null)
{
    header('Content-Type: application/json');
    
    if (!$id) {
        http_response_code(400);
        echo json_encode(['message' => 'Category ID is required']);
        return;
    }
    
    $category = $this->categoryModel->getCategoryById($id);
    if ($category) {
        // Kiểm tra xem có muốn lấy kèm số lượng sản phẩm không
        $includeProductCount = isset($_GET['include_product_count']) && $_GET['include_product_count'] === 'true';
        
        if ($includeProductCount) {
            $productCount = $this->categoryModel->getProductCountInCategory($id);
            $category->product_count = $productCount;
        }
        
        echo json_encode($category);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Category not found']);
    }
}

// Thêm danh mục mới
public function store()
{
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Kiểm tra dữ liệu đầu vào
    if (!isset($data['name']) || empty($data['name'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Category name is required']);
        return;
    }
    
    $name = $data['name'];
    $description = $data['description'] ?? '';
    
    try {
        $result = $this->categoryModel->createCategory($name, $description);
        
        if (is_array($result)) {
            // Trả về lỗi validation
            http_response_code(400);
            echo json_encode(['message' => 'Validation failed', 'errors' => $result]);
            return;
        }
        
        if ($result) {
            http_response_code(201);
            echo json_encode([
                'message' => 'Category created successfully',
                'category_id' => $this->db->lastInsertId()
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to create category']);
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

// Cập nhật danh mục
public function update($id = null)
{
    header('Content-Type: application/json');
    
    if (!$id) {
        http_response_code(400);
        echo json_encode(['message' => 'Category ID is required']);
        return;
    }
    
    // Kiểm tra danh mục tồn tại
    $category = $this->categoryModel->getCategoryById($id);
    if (!$category) {
        http_response_code(404);
        echo json_encode(['message' => 'Category not found']);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Sử dụng giá trị hiện tại nếu không có dữ liệu mới
    $name = isset($data['name']) && !empty($data['name']) ? $data['name'] : $category->name;
    $description = isset($data['description']) ? $data['description'] : $category->description;
    
    try {
        $result = $this->categoryModel->updateCategory($id, $name, $description);
        if ($result) {
            // Lấy dữ liệu sau khi cập nhật
            $updatedCategory = $this->categoryModel->getCategoryById($id);
            echo json_encode([
                'message' => 'Category updated successfully',
                'category' => $updatedCategory
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to update category']);
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

// Xóa danh mục
public function destroy($id = null)
{
    header('Content-Type: application/json');
    
    if (!$id) {
        http_response_code(400);
        echo json_encode(['message' => 'Category ID is required']);
        return;
    }
    
    // Kiểm tra danh mục tồn tại
    $category = $this->categoryModel->getCategoryById($id);
    if (!$category) {
        http_response_code(404);
        echo json_encode(['message' => 'Category not found']);
        return;
    }
    
    try {
        $result = $this->categoryModel->deleteCategory($id);
        
        // Kiểm tra kết quả nếu là mảng thì có lỗi
        if (is_array($result) && isset($result['error'])) {
            http_response_code(400);
            echo json_encode([
                'message' => 'Cannot delete category. It is being used by ' . $result['count'] . ' product(s)',
                'products_count' => $result['count']
            ]);
            return;
        }
        
        if ($result) {
            echo json_encode(['message' => 'Category deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to delete category']);
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
}
?>
