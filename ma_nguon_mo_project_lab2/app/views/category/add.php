<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm danh mục</title>
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
                    <h3 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Thêm danh mục mới</h3>
                </div>
                <div class="card-body">
                    <div id="error-container" class="alert alert-danger d-none">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <span id="error-message"></span>
                    </div>

                    <form id="add-category-form" class="needs-validation" novalidate>
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
                                <i class="bi bi-save me-1"></i> Lưu danh mục
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
    const form = document.getElementById('add-category-form');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const errorContainer = document.getElementById('error-container');
    const errorMessage = document.getElementById('error-message');
    
    // Hiển thị thông báo lỗi
    function showError(message) {
        errorMessage.textContent = message;
        errorContainer.classList.remove('d-none');
    }
    
    // Ẩn thông báo lỗi
    function hideError() {
        errorContainer.classList.add('d-none');
    }
    
    // Tạo danh mục mới
    function createCategory(formData) {
        fetch('/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/CategoryApi/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Category created successfully') {
                alert('Danh mục đã được tạo thành công!');
                // Chuyển về trang danh sách
                window.location.href = '/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category';
            } else if (data.errors) {
                // Hiển thị lỗi validation
                const errorMessages = Object.values(data.errors).join('\n');
                showError(errorMessages);
            } else {
                showError(data.message || 'Đã xảy ra lỗi khi tạo danh mục');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Đã xảy ra lỗi khi gửi yêu cầu');
        });
    }
    
    // Xử lý sự kiện submit form
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Ẩn thông báo lỗi
        hideError();
        
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
        
        // Gửi request tạo danh mục
        createCategory(formData);
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>