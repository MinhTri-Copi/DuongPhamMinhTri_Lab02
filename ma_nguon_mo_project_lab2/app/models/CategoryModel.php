<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Phương thức cơ bản - trả về danh sách danh mục (dùng cho cả giao diện web và API)
    public function getCategories()
    {
        $query = "SELECT id, name, description FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    // Lấy thông tin danh mục theo ID (dùng cho cả giao diện web và API)
    public function getCategoryById($id)
    {
        $query = "SELECT id, name, description FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Tạo danh mục mới
    public function createCategory($name, $description)
    {
        // Kiểm tra dữ liệu đầu vào
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên danh mục không được để trống';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        // Chuẩn hóa dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));

        $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cập nhật danh mục
    public function updateCategory($id, $name, $description)
    {
        // Bắt đầu transaction
        $this->conn->beginTransaction();

        try {
            // Kiểm tra danh mục có tồn tại không
            $checkCategory = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($checkCategory);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$category) {
                $this->conn->rollBack();
                return false;
            }
            
            // Chuẩn hóa dữ liệu
            $name = htmlspecialchars(strip_tags($name));
            $description = htmlspecialchars(strip_tags($description));
            
            $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            
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

    // Xóa danh mục
    public function deleteCategory($id)
    {
        // Bắt đầu transaction
        $this->conn->beginTransaction();
        
        try {
            // Kiểm tra danh mục có tồn tại không
            $checkCategory = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($checkCategory);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$category) {
                $this->conn->rollBack();
                return false;
            }
            
            // Kiểm tra xem danh mục có đang được sử dụng không
            $checkUsage = "SELECT COUNT(*) FROM product WHERE category_id = :id";
            $stmt = $this->conn->prepare($checkUsage);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            
            if ($count > 0) {
                $this->conn->rollBack();
                return ['error' => 'Category is in use', 'count' => $count];
            }
            
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
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

    // Phương thức chuyên biệt cho API - Đếm số sản phẩm trong danh mục
    public function getProductCountInCategory($id)
    {
        $query = "SELECT COUNT(*) FROM product WHERE category_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Phương thức chuyên biệt cho API - Lấy danh mục với số lượng sản phẩm
    public function getCategoriesWithProductCount()
    {
        $query = "SELECT c.id, c.name, c.description, COUNT(p.id) as product_count 
                 FROM " . $this->table_name . " c
                 LEFT JOIN product p ON c.id = p.category_id
                 GROUP BY c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>