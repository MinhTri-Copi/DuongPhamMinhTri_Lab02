<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa danh mục</h3>
                </div>
                <div class="card-body">
                    <div id="loading" class="text-center py-4 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                        <p class="mt-2">Đang tải thông tin danh mục...</p>
                    </div>

                    <div id="error-container" class="alert alert-danger d-none">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <span id="error-message"></span>
                    </div>

                    <form id="edit-category-form" class="needs-validation" novalidate>
                        <input type="hidden" id="category-id" value="<?= $category->id ?>">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input type="text" class="form-control" id="name" required>
                            <div class="invalid-feedback">Vui lòng nhập tên danh mục.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" rows="3"></textarea>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryId = document.getElementById('category-id').value;
    const form = document.getElementById('edit-category-form');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const errorContainer = document.getElementById('error-container');
    const errorMessage = document.getElementById('error-message');
    const loadingElement = document.getElementById('loading');
    
    // Hiển thị thông báo lỗi
    function showError(message) {
        errorMessage.textContent = message;
        errorContainer.classList.remove('d-none');
    }
    
    // Ẩn thông báo lỗi
    function hideError() {
        errorContainer.classList.add('d-none');
    }
    
    // Hiển thị loading
    function showLoading() {
        loadingElement.classList.remove('d-none');
        form.classList.add('d-none');
        hideError();
    }
    
    // Ẩn loading
    function hideLoading() {
        loadingElement.classList.add('d-none');
        form.classList.remove('d-none');
    }
    
    // Lấy thông tin danh mục
    function fetchCategoryDetails() {
        showLoading();
        
        fetch(`/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/CategoryApi/show/${categoryId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Không thể tải thông tin danh mục. Mã lỗi: ' + response.status);
                }
                return response.json();
            })
            .then(category => {
                hideLoading();
                // Điền thông tin vào form
                nameInput.value = category.name || '';
                descriptionInput.value = category.description || '';
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                showError(error.message || 'Đã xảy ra lỗi khi tải thông tin danh mục');
            });
    }
    
    // Cập nhật danh mục
    function updateCategory(formData) {
        fetch(`/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/CategoryApi/update/${categoryId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Category updated successfully') {
                alert('Danh mục đã được cập nhật thành công!');
                // Chuyển về trang danh sách
                window.location.href = '/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category';
            } else {
                showError(data.message || 'Đã xảy ra lỗi khi cập nhật danh mục');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Đã xảy ra lỗi khi gửi yêu cầu cập nhật');
        });
    }
    
    // Xử lý sự kiện submit form
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Kiểm tra validation
        if (!form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        // Thu thập dữ liệu từ form
        const formData = {
            name: nameInput.value.trim(),
            description: descriptionInput.value.trim()
        };
        
        // Gửi request cập nhật
        updateCategory(formData);
    });
    
    // Tải thông tin danh mục khi trang được tải
    fetchCategoryDetails();
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>