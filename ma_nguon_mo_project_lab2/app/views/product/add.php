<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Thêm sản phẩm mới</h1>

    <div id="error-container" class="alert alert-danger" style="display: none;">
        <ul id="error-list"></ul>
    </div>

    <form id="add-product-form" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" required>
            <div class="invalid-feedback">Vui lòng nhập tên sản phẩm.</div>
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
            <div class="invalid-feedback">Vui lòng nhập mô tả sản phẩm.</div>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" required>
            <div class="invalid-feedback">Vui lòng nhập giá sản phẩm.</div>
        </div>
        <div class="form-group">
            <label for="category_id">Danh mục:</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->id; ?>"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Vui lòng chọn danh mục.</div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Thêm sản phẩm</button>
    </form>

    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/index" class="btn btn-secondary mt-3">Quay lại danh sách sản phẩm</a>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<style>
    .form-group {
        margin-bottom: 20px;
    }
    .btn-block {
        width: 100%;
    }
    .alert ul {
        margin-bottom: 0;
    }
    .form-control.is-invalid, .form-control-file.is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        display: none;
    }
    .was-validated .form-control:invalid, .was-validated .form-control-file:invalid {
        border-color: #dc3545;
    }
    .was-validated .form-control:invalid ~ .invalid-feedback,
    .was-validated .form-control-file:invalid ~ .invalid-feedback {
        display: block;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('add-product-form');
        const errorContainer = document.getElementById('error-container');
        const errorList = document.getElementById('error-list');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            if (form.checkValidity() === false) {
                event.stopPropagation();
                form.classList.add('was-validated');
                return;
            }
            
            // Get form data
            const formData = {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                price: document.getElementById('price').value,
                category_id: document.getElementById('category_id').value
            };
            
            // Send API request
            fetch('/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/ProductApi/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    // Show validation errors
                    errorList.innerHTML = '';
                    Object.values(data.errors).forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorList.appendChild(li);
                    });
                    errorContainer.style.display = 'block';
                } else if (data.message === 'Product created successfully') {
                    // Redirect to product list
                    window.location.href = '/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã xảy ra lỗi khi thêm sản phẩm. Vui lòng thử lại sau.');
            });
        });
    });
</script>