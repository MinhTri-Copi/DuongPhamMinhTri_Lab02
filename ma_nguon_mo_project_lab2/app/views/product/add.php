<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Thêm sản phẩm mới</h1>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <form method="POST" action="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();" class="needs-validation" novalidate>
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
        <div class="form-group">
            <label for="image">Hình ảnh:</label>
            <input type="file" id="image" name="image" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Thêm sản phẩm</button>
    </form>

    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/" class="btn btn-secondary mt-3">Quay lại danh sách sản phẩm</a>
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
    // JavaScript để xử lý validation của Bootstrap
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>