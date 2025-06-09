<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .action-links a {
            margin-right: 10px;
        }
        .btn-add {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h1>Danh sách danh mục</h1>
        </div>
        <div class="col-auto">
            <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category/add" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Thêm danh mục
            </a>
        </div>
    </div>

    <!-- Mô tả API -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="bi bi-code-slash"></i> API Endpoints
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Method</th>
                            <th>URL</th>
                            <th>Mô tả</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-success">GET</span></td>
                            <td><code>/CategoryApi</code></td>
                            <td>Lấy danh sách tất cả danh mục</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-success">GET</span></td>
                            <td><code>/CategoryApi?include_product_count=true</code></td>
                            <td>Lấy danh sách danh mục kèm số lượng sản phẩm</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-success">GET</span></td>
                            <td><code>/CategoryApi/show/{id}</code></td>
                            <td>Lấy thông tin chi tiết một danh mục</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-primary">POST</span></td>
                            <td><code>/CategoryApi/store</code></td>
                            <td>Tạo danh mục mới</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-warning text-dark">PUT</span></td>
                            <td><code>/CategoryApi/update/{id}</code></td>
                            <td>Cập nhật thông tin danh mục</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-danger">DELETE</span></td>
                            <td><code>/CategoryApi/destroy/{id}</code></td>
                            <td>Xóa danh mục</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh sách danh mục</h5>
            <button id="toggleProductCount" class="btn btn-sm btn-outline-light">Hiển thị số lượng sản phẩm</button>
        </div>
        <div class="card-body p-0">
            <div class="alert alert-info m-3 d-none" id="loadingMessage">
                <i class="bi bi-hourglass-split"></i> Đang tải dữ liệu...
            </div>
            <div class="alert alert-danger m-3 d-none" id="errorMessage">
                <i class="bi bi-exclamation-triangle"></i> <span id="errorText"></span>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col" id="productCountHeader" class="d-none">Số sản phẩm</th>
                            <th scope="col" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTableBody">
                        <!-- Dữ liệu sẽ được nạp bằng JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryTableBody = document.getElementById('categoryTableBody');
    const loadingMessage = document.getElementById('loadingMessage');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    const toggleProductCountBtn = document.getElementById('toggleProductCount');
    const productCountHeader = document.getElementById('productCountHeader');
    
    let showProductCount = false;
    
    // Hiển thị thông báo đang tải
    function showLoading() {
        loadingMessage.classList.remove('d-none');
        errorMessage.classList.add('d-none');
    }
    
    // Hiển thị thông báo lỗi
    function showError(message) {
        loadingMessage.classList.add('d-none');
        errorMessage.classList.remove('d-none');
        errorText.textContent = message;
    }
    
    // Ẩn tất cả thông báo
    function hideMessages() {
        loadingMessage.classList.add('d-none');
        errorMessage.classList.add('d-none');
    }
    
    // Tải danh sách danh mục từ API
    function loadCategories() {
        showLoading();
        
        const url = `/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/CategoryApi${showProductCount ? '?include_product_count=true' : ''}`;
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Không thể tải dữ liệu. Mã lỗi: ' + response.status);
                }
                return response.json();
            })
            .then(categories => {
                // Cập nhật UI
                hideMessages();
                renderCategories(categories);
                
                // Hiển thị/ẩn cột số lượng sản phẩm
                if (showProductCount) {
                    productCountHeader.classList.remove('d-none');
                } else {
                    productCountHeader.classList.add('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError(error.message || 'Đã xảy ra lỗi khi tải dữ liệu');
            });
    }
    
    // Render danh sách danh mục
    function renderCategories(categories) {
        categoryTableBody.innerHTML = '';
        
        if (categories.length === 0) {
            categoryTableBody.innerHTML = `
                <tr>
                    <td colspan="${showProductCount ? '5' : '4'}" class="text-center py-4">
                        <i class="bi bi-info-circle me-2"></i> Không có danh mục nào được tìm thấy
                    </td>
                </tr>
            `;
            return;
        }
        
        categories.forEach(category => {
            const row = document.createElement('tr');
            
            row.innerHTML = `
                <td>${category.id}</td>
                <td>${escapeHtml(category.name)}</td>
                <td>${escapeHtml(category.description || '')}</td>
                ${showProductCount ? `<td class="text-center">${category.product_count || 0}</td>` : ''}
                <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category/show/${category.id}" class="btn btn-info" title="Xem">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category/edit/${category.id}" class="btn btn-warning" title="Sửa">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-danger" title="Xóa" onclick="deleteCategory(${category.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            
            categoryTableBody.appendChild(row);
        });
    }
    
    // Hàm escape HTML để tránh XSS
    function escapeHtml(text) {
        if (!text) return '';
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    
    // Xử lý sự kiện khi nhấn nút hiển thị số lượng sản phẩm
    toggleProductCountBtn.addEventListener('click', function() {
        showProductCount = !showProductCount;
        this.textContent = showProductCount ? 'Ẩn số lượng sản phẩm' : 'Hiển thị số lượng sản phẩm';
        loadCategories();
    });
    
    // Tải danh sách danh mục khi trang được tải
    loadCategories();
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
            // Tải lại danh sách danh mục
            window.location.reload();
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