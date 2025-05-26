<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
class ProductController
{
private $productModel;
private $db;
public function __construct()
{
$this->db = (new Database())->getConnection();
$this->productModel = new ProductModel($this->db);
}
public function index()
{
$products = $this->productModel->getProducts();
include 'app/views/product/list.php';
}
public function show($id)
{
$product = $this->productModel->getProductById($id);
if ($product) {
include 'app/views/product/show.php';
} else {
echo "Không thấy sản phẩm.";
}
}
public function add()
{
$categories = (new CategoryModel($this->db))->getCategories();
include_once 'app/views/product/add.php';
}
public function save()
{
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? '';
$category_id = $_POST['category_id'] ?? null;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
$image = $this->uploadImage($_FILES['image']);
} else {
$image = "";
}
$result = $this->productModel->addProduct($name, $description, $price,
$category_id, $image);
if (is_array($result)) {
$errors = $result;
$categories = (new CategoryModel($this->db))->getCategories();
include 'app/views/product/add.php';
} else {
    header('Location: /DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product');
}
}
}
public function edit($id)
{
$product = $this->productModel->getProductById($id);
$categories = (new CategoryModel($this->db))->getCategories();
if ($product) {
include 'app/views/product/edit.php';
} else {
echo "Không thấy sản phẩm.";
}
}
public function update()
{
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$category_id = $_POST['category_id'];
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
$image = $this->uploadImage($_FILES['image']);
} else {
$image = $_POST['existing_image'];
}
$edit = $this->productModel->updateProduct($id, $name, $description,
$price, $category_id, $image);
if ($edit) {
header('Location: /DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product');
} else {
echo "Đã xảy ra lỗi khi lưu sản phẩm.";
}
}
}
public function delete($id)
{
if ($this->productModel->deleteProduct($id)) {
header('Location: /DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product');
} else {    
    echo "Đã xảy ra lỗi khi xóa sản phẩm.";
}
}
private function uploadImage($file)
{
$target_dir = "uploads/";
// Kiểm tra và tạo thư mục nếu chưa tồn tại
if (!is_dir($target_dir)) {
mkdir($target_dir, 0777, true);
}
$target_file = $target_dir . basename($file["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Kiểm tra xem file có phải là hình ảnh không
$check = getimagesize($file["tmp_name"]);
if ($check === false) {
throw new Exception("File không phải là hình ảnh.");
}
// Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
if ($file["size"] > 10 * 1024 * 1024) {
throw new Exception("Hình ảnh có kích thước quá lớn.");
}
// Chỉ cho phép một số định dạng hình ảnh nhất định
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !=
"jpeg" && $imageFileType != "gif" && $imageFileType != "jfif") {
throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
}
// Lưu file
if (!move_uploaded_file($file["tmp_name"], $target_file)) {
throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
}
return $target_file;
}
public function addToCart($id)
{
$product = $this->productModel->getProductById($id);
if (!$product) {
echo "Không tìm thấy sản phẩm.";
return;
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity']++;
    } else {
    $_SESSION['cart'][$id] = [
    'name' => $product->name,
    'price' => $product->price,
    'quantity' => 1,
    'image' => $product->image
    ];
    }
    header('Location: /DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/cart');
    }
    public function cart()
    {
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    include 'app/views/product/cart.php';
    }
    public function checkout()
    {
    include 'app/views/product/checkout.php';
    }
    public function processCheckout()
    {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'] ?? '';
    $note = $_POST['note'] ?? '';
    $payment_method = $_POST['payment_method'] ?? 'cod';
    
    // Kiểm tra giỏ hàng
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Giỏ hàng trống.";
    return;
    }
    
    // Calculate total for order
    $total = 0;
    $cart = $_SESSION['cart'];
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    // Add VAT (10%)
    $total += $total * 0.1;
    
    // Bắt đầu giao dịch
    $this->db->beginTransaction();
    try {
    // Lưu thông tin đơn hàng vào bảng orders
    $query = "INSERT INTO orders (name, phone, address, email, note, payment_method, total) VALUES (:name,
:phone, :address, :email, :note, :payment_method, :total)";
$stmt = $this->db->prepare($query);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':note', $note);
$stmt->bindParam(':payment_method', $payment_method);
$stmt->bindParam(':total', $total);
$stmt->execute();
$order_id = $this->db->lastInsertId();

// Lưu chi tiết đơn hàng vào bảng order_details
$cart = $_SESSION['cart'];
foreach ($cart as $product_id => $item) {
$query = "INSERT INTO order_details (order_id, product_id,
quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
$stmt = $this->db->prepare($query);
$stmt->bindParam(':order_id', $order_id);
$stmt->bindParam(':product_id', $product_id);
$stmt->bindParam(':quantity', $item['quantity']);
$stmt->bindParam(':price', $item['price']);
$stmt->execute();
}

// Store order info in session for the confirmation page
$_SESSION['last_order'] = [
    'order_id' => $order_id,
    'name' => $name,
    'phone' => $phone,
    'address' => $address,
    'email' => $email,
    'note' => $note,
    'payment_method' => $payment_method,
    'total' => $total,
    'items' => $cart,
    'order_date' => date('Y-m-d H:i:s'),
    'is_buy_now' => isset($_SESSION['is_buy_now']) ? true : false
];

// Xóa giỏ hàng và flag mua ngay sau khi đặt hàng thành công
unset($_SESSION['cart']);
if (isset($_SESSION['is_buy_now'])) {
    unset($_SESSION['is_buy_now']);
}
if (isset($_SESSION['buy_now_product'])) {
    unset($_SESSION['buy_now_product']);
}

// Commit giao dịch
$this->db->commit();
// Chuyển hướng đến trang xác nhận đơn hàng
header('Location: /DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/orderConfirmation');
} catch (Exception $e) {
// Rollback giao dịch nếu có lỗi
$this->db->rollBack();
echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
}
}
}
public function orderConfirmation()
{
include 'app/views/product/orderConfirmation.php';
}
public function updateCart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['change'])) {
        $id = $_POST['id'];
        $change = (int)$_POST['change'];
        
        // Check if cart exists and the product is in the cart
        if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$id])) {
            // Update quantity, ensure it's at least 0
            $_SESSION['cart'][$id]['quantity'] = max(0, $_SESSION['cart'][$id]['quantity'] + $change);
            
            // If quantity is 0, remove the item from cart
            if ($_SESSION['cart'][$id]['quantity'] === 0) {
                unset($_SESSION['cart'][$id]);
            }
            
            // Calculate item total and cart total
            $itemTotal = 0;
            $cartTotal = 0;
            
            if (isset($_SESSION['cart'][$id])) {
                $itemTotal = $_SESSION['cart'][$id]['price'] * $_SESSION['cart'][$id]['quantity'];
            }
            
            foreach ($_SESSION['cart'] as $item) {
                $cartTotal += $item['price'] * $item['quantity'];
            }
            
            // Return response as JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'quantity' => isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id]['quantity'] : 0,
                'itemTotal' => number_format($itemTotal, 0, ',', '.'),
                'cartTotal' => number_format($cartTotal, 0, ',', '.')
            ]);
            exit;
        }
    }
    
    // Return error if something went wrong
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request or product not found in cart']);
    exit;
}
public function searchAndFilter() {
    $keyword = $_GET['keyword'] ?? ''; // Lấy từ khóa tìm kiếm từ query string
    $category_id = $_GET['category_id'] ?? ''; // Lấy ID danh mục từ query string

    // Lấy danh sách danh mục để hiển thị trong bộ lọc
    $categories = (new CategoryModel($this->db))->getCategories();

    // Gọi model để tìm kiếm và lọc sản phẩm
    $products = $this->productModel->searchAndFilterProducts($keyword, $category_id);

    // Hiển thị danh sách sản phẩm
    include 'app/views/product/list.php';
}

public function buyNow($id)
{
    $product = $this->productModel->getProductById($id);
    if (!$product) {
        echo "Không tìm thấy sản phẩm.";
        return;
    }
    
    // Lấy số lượng từ query parameter (được gửi từ trang sản phẩm)
    $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
    
    // Đảm bảo số lượng hợp lệ
    if ($quantity < 1) {
        $quantity = 1;
    }
    
    // Xóa giỏ hàng hiện tại để chỉ mua sản phẩm này
    $_SESSION['cart'] = [];
    
    // Đánh dấu là đang mua ngay (sử dụng cho checkout)
    $_SESSION['is_buy_now'] = true;
    
    // Thêm sản phẩm vào giỏ hàng
    $_SESSION['cart'][$id] = [
        'name' => $product->name,
        'price' => $product->price,
        'quantity' => $quantity,
        'image' => $product->image
    ];
    
    // Lưu lại ID của sản phẩm "Mua ngay" để sử dụng sau này nếu cần
    $_SESSION['buy_now_product'] = $id;
    
    // Chuyển hướng đến trang thanh toán
    header('Location: /DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/checkout');
}
}

?>