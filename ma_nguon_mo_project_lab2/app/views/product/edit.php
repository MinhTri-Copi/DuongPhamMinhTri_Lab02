<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Sửa sản phẩm</h1>
    
    <div id="error-container" class="alert alert-danger" style="display: none;">
        <ul id="error-list"></ul>
    </div>
    
    <form id="edit-product-form" class="needs-validation" novalidate>
        <input type="hidden" id="product-id" value="<?php echo $product->id; ?>">
        <div class="form-group">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
            <div class="invalid-feedback">Vui lòng nhập tên sản phẩm.</div>
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
            <div class="invalid-feedback">Vui lòng nhập mô tả sản phẩm.</div>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
            <div class="invalid-feedback">Vui lòng nhập giá sản phẩm.</div>
        </div>
        <div class="form-group">
            <label for="category_id">Danh mục:</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Vui lòng chọn danh mục.</div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Lưu thay đổi</button>
    </form>
    
    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product" class="btn btn-secondary mt-3">Quay lại danh sách sản phẩm</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('edit-product-form');
        const errorContainer = document.getElementById('error-container');
        const errorList = document.getElementById('error-list');
        const productId = document.getElementById('product-id').value;

        // Hiển thị log cho category_id ban đầu
        console.log('Initial category_id:', document.getElementById('category_id').value);

        // Tạo trình debug để hiển thị thông tin
        const debugInfo = document.createElement('div');
        debugInfo.style.backgroundColor = '#f8f9fa';
        debugInfo.style.padding = '10px';
        debugInfo.style.marginTop = '20px';
        debugInfo.style.border = '1px solid #ddd';
        debugInfo.style.borderRadius = '5px';
        debugInfo.style.fontFamily = 'monospace';
        debugInfo.style.display = 'none';
        form.after(debugInfo);

        // Thêm checkbox để hiển thị debug info
        const debugCheck = document.createElement('div');
        debugCheck.className = 'form-check mt-3';
        debugCheck.innerHTML = `
            <input class="form-check-input" type="checkbox" id="show-debug">
            <label class="form-check-label" for="show-debug">
                Hiển thị thông tin debug
            </label>
        `;
        form.after(debugCheck);

        document.getElementById('show-debug').addEventListener('change', function() {
            debugInfo.style.display = this.checked ? 'block' : 'none';
        });

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
                category_id: parseInt(document.getElementById('category_id').value, 10) // Ensure category_id is a number
            };
            
            // Hiển thị dữ liệu gửi đi trong debug
            debugInfo.innerHTML = `
                <h5>Dữ liệu gửi đi:</h5>
                <pre>${JSON.stringify(formData, null, 2)}</pre>
                <h5>API Endpoint:</h5>
                <pre>${`/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/ProductApi/update/${productId}`}</pre>
            `;
            
            // Log the data being sent
            console.log('Sending data:', formData);
            console.log('API Endpoint:', `/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/ProductApi/update/${productId}`);
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.textContent;
            submitBtn.textContent = 'Đang xử lý...';
            submitBtn.disabled = true;
            
            // Clear previous errors
            errorList.innerHTML = '';
            errorContainer.style.display = 'none';
            
            // Send API request
            fetch(`/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/ProductApi/update/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json().then(data => {
                    return { status: response.status, data };
                });
            })
            .then(result => {
                console.log('Response data:', result.data);
                
                // Hiển thị kết quả trong debug
                debugInfo.innerHTML += `
                    <h5>Kết quả từ máy chủ:</h5>
                    <pre>${JSON.stringify(result.data, null, 2)}</pre>
                `;
                
                // Reset button state
                submitBtn.textContent = originalBtnText;
                submitBtn.disabled = false;
                
                if (result.status >= 400) {
                    // Show error message
                    errorList.innerHTML = '';
                    const li = document.createElement('li');
                    li.textContent = result.data.message || 'Đã xảy ra lỗi khi cập nhật sản phẩm.';
                    errorList.appendChild(li);
                    
                    if (result.data.error) {
                        const errorLi = document.createElement('li');
                        errorLi.textContent = result.data.error;
                        errorList.appendChild(errorLi);
                    }
                    
                    errorContainer.style.display = 'block';
                } else if (result.data.errors) {
                    // Show validation errors
                    errorList.innerHTML = '';
                    Object.values(result.data.errors).forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorList.appendChild(li);
                    });
                    errorContainer.style.display = 'block';
                } else if (result.data.message === 'Product updated successfully') {
                    // Show success message before redirecting
                    alert('Sản phẩm đã được cập nhật thành công!');
                    
                    // Nếu có dữ liệu sản phẩm, hiển thị trong debug
                    if (result.data.product) {
                        debugInfo.innerHTML += `
                            <h5>Dữ liệu sản phẩm sau khi cập nhật:</h5>
                            <pre>${JSON.stringify(result.data.product, null, 2)}</pre>
                        `;
                    }
                    
                    // Redirect to product list
                    window.location.href = '/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Hiển thị lỗi trong debug
                debugInfo.innerHTML += `
                    <h5>Lỗi:</h5>
                    <pre>${error.toString()}</pre>
                `;
                
                // Reset button state
                submitBtn.textContent = originalBtnText;
                submitBtn.disabled = false;
                
                // Show error message
                errorList.innerHTML = '';
                const li = document.createElement('li');
                li.textContent = 'Đã xảy ra lỗi khi gửi yêu cầu. Vui lòng thử lại sau.';
                errorList.appendChild(li);
                errorContainer.style.display = 'block';
            });
        });
    });
</script>

<?php include 'app/views/shares/footer.php'; ?>
