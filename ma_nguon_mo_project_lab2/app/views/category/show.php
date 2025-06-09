<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-0"><i class="bi bi-info-circle me-2"></i>Chi tiết danh mục</h3>
                </div>
                <div class="card-body">
                    <div id="loading" class="text-center py-4">
                        <div class="spinner-border text-info" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                        <p class="mt-2">Đang tải thông tin danh mục...</p>
                    </div>

                    <div id="error-container" class="alert alert-danger d-none">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <span id="error-message"></span>
                    </div>

                    <div id="category-details" class="d-none">
                        <div class="mb-3">
                            <h5 class="text-muted">ID</h5>
                            <p class="fs-5" id="category-id-display"></p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted">Tên danh mục</h5>
                            <p class="fs-5" id="category-name"></p>
                        </div>
                        
                        <div class="mb-3">
                            <h5 class="text-muted">Mô tả</h5>
                            <p class="fs-5" id="category-description"></p>
                        </div>
                        
                        <div id="product-count-container" class="mb-3 d-none">
                            <h5 class="text-muted">Số lượng sản phẩm</h5>
                            <p class="fs-5">
                                <span id="product-count" class="badge bg-success"></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Quay lại
                        </a>
                        <div>
                            <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category/edit/<?= $category->id ?>" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i> Sửa
                            </a>
                            <button onclick="deleteCategory(<?= $category->id ?>)" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i> Xóa
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryId = <?= $category->id ?>;
    const loadingElement = document.getElementById('loading');
    const errorContainer = document.getElementById('error-container');
    const errorMessage = document.getElementById('error-message');
    const categoryDetails = document.getElementById('category-details');
    const categoryIdDisplay = document.getElementById('category-id-display');
    const categoryName = document.getElementById('category-name');
    const categoryDescription = document.getElementById('category-description');
    const productCountContainer = document.getElementById('product-count-container');
    const productCount = document.getElementById('product-count');
    
    // Hiển thị thông báo lỗi
    function showError(message) {
        errorMessage.textContent = message;
        errorContainer.classList.remove('d-none');
        loadingElement.classList.add('d-none');
    }
    
    // Hiển thị loading
    function showLoading() {
        loadingElement.classList.remove('d-none');
        categoryDetails.classList.add('d-none');
        errorContainer.classList.add('d-none');
    }
    
    // Hiển thị chi tiết danh mục
    function showCategoryDetails() {
        loadingElement.classList.add('d-none');
        categoryDetails.classList.remove('d-none');
    }
    
    // Lấy thông tin danh mục
    function fetchCategoryDetails() {
        showLoading();
        
        fetch(`/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/CategoryApi/show/${categoryId}?include_product_count=true`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Không thể tải thông tin danh mục. Mã lỗi: ' + response.status);
                }
                return response.json();
            })
            .then(category => {
                // Điền thông tin danh mục
                categoryIdDisplay.textContent = category.id;
                categoryName.textContent = category.name || 'Không có tên';
                categoryDescription.textContent = category.description || 'Không có mô tả';
                
                // Hiển thị số lượng sản phẩm nếu có
                if (category.product_count !== undefined) {
                    productCount.textContent = category.product_count;
                    productCountContainer.classList.remove('d-none');
                }
                
                // Hiển thị chi tiết
                showCategoryDetails();
            })
            .catch(error => {
                console.error('Error:', error);
                showError(error.message || 'Đã xảy ra lỗi khi tải thông tin danh mục');
            });
    }
    
    // Tải thông tin danh mục khi trang được tải
    fetchCategoryDetails();
});

// Hàm xóa danh mục
function deleteCategory(id) {
    if (!confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
        return;
    }
    
    fetch(`/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/CategoryApi/destroy/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === 'Category deleted successfully') {
            alert('Danh mục đã được xóa thành công!');
            // Chuyển về trang danh sách
            window.location.href = '/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category';
        } else if (data.message && data.message.includes('Cannot delete category')) {
            alert('Không thể xóa danh mục này vì nó đang được sử dụng bởi ' + data.products_count + ' sản phẩm.');
        } else {
            alert('Đã xảy ra lỗi khi xóa danh mục: ' + (data.message || 'Lỗi không xác định'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi khi gửi yêu cầu xóa');
    });
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>