<?php include 'app/views/shares/header.php'; ?>

<div class="product-detail-container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white shadow-sm">
            <li class="breadcrumb-item"><a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/">Sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page" id="product-name-breadcrumb">Đang tải...</li>
        </ol>
    </nav>

    <div id="product-container">
        <!-- Product details will be loaded here -->
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Đang tải...</span>
            </div>
            <p>Đang tải thông tin sản phẩm...</p>
        </div>
    </div>
</div>

<style>
    .product-detail-container {
        margin-bottom: 50px;
    }
    
    .breadcrumb {
        border-radius: 10px;
        padding: 15px;
    }
    
    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .main-image-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 400px;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    #main-product-image {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }
    
    .thumbnails {
        gap: 10px;
    }
    
    .thumbnail {
        width: 70px;
        height: 70px;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .thumbnail.active {
        border-color: var(--primary-color);
    }
    
    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    
    .placeholder-thumb {
        width: 100%;
        height: 100%;
        background-color: #e9ecef;
    }
    
    .product-badges .badge {
        padding: 5px 12px;
        margin-right: 8px;
        font-weight: 500;
    }
    
    .product-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--dark-color);
    }
    
    .ratings {
        font-size: 0.9rem;
    }
    
    .rating-count {
        color: #6c757d;
        font-size: 0.9rem;
        margin-left: 5px;
    }
    
    .price-container {
        border-radius: 8px;
    }
    
    .current-price {
        font-size: 2rem;
        font-weight: 700;
        color: var(--danger-color);
    }
    
    .description-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .description-content {
        font-size: 0.95rem;
        color: #505050;
        line-height: 1.6;
    }
    
    .service-info {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        font-size: 0.9rem;
    }
    
    .service-item {
        color: #505050;
    }
    
    .no-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0;
        color: #aaa;
        font-size: 18px;
        font-weight: 500;
        border-radius: 8px;
    }
    
    .main-image-container.no-image {
        background-color: #f8f9fa;
    }
</style>

<script>
// Định nghĩa biến isAdmin từ PHP
const isAdmin = <?php echo SessionHelper::isAdmin() ? 'true' : 'false'; ?>;

document.addEventListener('DOMContentLoaded', function() {
    const productId = window.location.pathname.split('/').pop();
    
    // Fetch product details from API
    fetch(`/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/getProductJson/${productId}`)
        .then(response => {
            console.log('API Response status:', response.status);
            if (!response.ok) {
                throw new Error('Product not found');
            }
            return response.json();
        })
        .then(product => {
            console.log('Product received:', product);
            // Update breadcrumb
            document.getElementById('product-name-breadcrumb').textContent = product.name;
            
            // Format product details HTML
            const productHTML = `
                <div class="row">
                    <div class="col-lg-5 mb-4">
                        <div class="product-gallery card border-0 shadow-sm">
                            <div class="card-body p-0">
                                ${product.image ? `
                                <div class="main-image-container">
                                    <img id="main-product-image" src="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/${product.image}" 
                                        class="img-fluid" alt="${product.name}" onerror="this.src='/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/public/images/placeholder.jpg'; this.onerror=null;">
                                </div>
                                ` : `
                                <div class="main-image-container no-image">
                                    <div class="no-image-placeholder">Không có ảnh</div>
                                </div>
                                `}
                            </div>
                            
                            <!-- Dummy thumbnails for visual effect -->
                            <div class="thumbnails mt-3 d-flex justify-content-center flex-wrap">
                                ${product.image ? `
                                <div class="thumbnail active">
                                    <img src="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/${product.image}"
                                        class="img-thumbnail" alt="Thumbnail 1">
                                </div>
                                ` : ''}
                                <!-- Add some placeholder thumbnails for visual effect -->
                                <div class="thumbnail">
                                    <div class="placeholder-thumb"></div>
                                </div>
                                <div class="thumbnail">
                                    <div class="placeholder-thumb"></div>
                                </div>
                                <div class="thumbnail">
                                    <div class="placeholder-thumb"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-7">
                        <div class="product-info card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="product-badges mb-3">
                                    <span class="badge badge-danger">Giảm 10%</span>
                                    <span class="badge badge-success">Mới</span>
                                    <span class="badge badge-primary">${product.category_name || 'Chưa phân loại'}</span>
                                </div>
                                
                                <h1 class="product-title mb-2">${product.name}</h1>
                                
                                <div class="product-meta d-flex align-items-center mb-3">
                                    <div class="ratings mr-3">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                        <span class="rating-count">(142)</span>
                                    </div>
                                    <span class="text-muted">|</span>
                                    <span class="sold-count ml-3"><i class="fas fa-shopping-cart text-secondary mr-1"></i> Đã bán 48 sản phẩm</span>
                                </div>
                                
                                <div class="price-container bg-light p-3 rounded mb-4">
                                    <div class="current-price mb-2">${Number(product.price).toLocaleString('vi-VN')} ₫</div>
                                    <div class="original-price text-muted"><del>${Number(product.price * 1.1).toLocaleString('vi-VN')} ₫</del> -10%</div>
                                </div>
                                
                                <div class="category-info mb-3">
                                    <p class="mb-0">
                                        <strong>Danh mục:</strong> ${product.category_name || 'Chưa phân loại'}
                                    </p>
                                </div>
                                
                                <div class="product-description mb-4">
                                    <h5 class="description-title">Thông tin sản phẩm</h5>
                                    <div class="description-content">
                                        ${product.description}
                                    </div>
                                </div>
                                
                                <div class="quantity-section mb-4">
                                    <h5 class="mb-3">Số lượng</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="input-group quantity-control" style="width: 130px;">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary" type="button" id="decrease-qty">-</button>
                                            </div>
                                            <input type="text" class="form-control text-center" id="product-quantity" value="1">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="increase-qty">+</button>
                                            </div>
                                        </div>
                                        <span class="ml-3 text-muted">Còn <strong class="text-success">99</strong> sản phẩm</span>
                                    </div>
                                </div>
                                
                                <div class="action-buttons">
                                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/addToCart/${product.id}" class="btn btn-primary btn-lg mr-2">
                                        <i class="fas fa-cart-plus mr-2"></i> Thêm vào giỏ hàng
                                    </a>
                                    <button id="buy-now-btn" class="btn btn-danger btn-lg">
                                        <i class="fas fa-bolt mr-2"></i> Mua ngay
                                    </button>
                                </div>
                                
                                <div class="service-info mt-4">
                                    <div class="service-item d-flex align-items-center mb-2">
                                        <i class="fas fa-shipping-fast text-primary mr-2"></i>
                                        <span>Giao hàng miễn phí toàn quốc cho đơn hàng từ 500.000₫</span>
                                    </div>
                                    <div class="service-item d-flex align-items-center mb-2">
                                        <i class="fas fa-shield-alt text-primary mr-2"></i>
                                        <span>Bảo hành chính hãng 12 tháng</span>
                                    </div>
                                    <div class="service-item d-flex align-items-center">
                                        <i class="fas fa-exchange-alt text-primary mr-2"></i>
                                        <span>Đổi trả trong 7 ngày nếu sản phẩm lỗi</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-white border-top-0 p-0 pb-3 px-3">
                                <div class="admin-actions d-flex justify-content-end">
                                    ${isAdmin ? `
                                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/edit/${product.id}" class="btn btn-warning btn-sm mr-2">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Insert product details into container
            document.getElementById('product-container').innerHTML = productHTML;
            
            // Setup quantity control
            const qtyInput = document.getElementById('product-quantity');
            const decreaseBtn = document.getElementById('decrease-qty');
            const increaseBtn = document.getElementById('increase-qty');
            
            if (decreaseBtn && increaseBtn && qtyInput) {
                decreaseBtn.addEventListener('click', function() {
                    const currentValue = parseInt(qtyInput.value);
                    if (currentValue > 1) {
                        qtyInput.value = currentValue - 1;
                    }
                });
                
                increaseBtn.addEventListener('click', function() {
                    const currentValue = parseInt(qtyInput.value);
                    qtyInput.value = currentValue + 1;
                });
                
                // Prevent non-numeric input
                qtyInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value === '' || parseInt(this.value) < 1) {
                        this.value = 1;
                    }
                });
            }
            
            // Setup Buy Now button
            const buyNowBtn = document.getElementById('buy-now-btn');
            if (buyNowBtn) {
                buyNowBtn.addEventListener('click', function() {
                    const quantity = parseInt(qtyInput.value);
                    window.location.href = `/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/buyNow/${product.id}?quantity=${quantity}`;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('product-container').innerHTML = `
                <div class="alert alert-danger text-center">
                    <h4>Không tìm thấy sản phẩm!</h4>
                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/" class="btn btn-primary mt-2">Quay về trang sản phẩm</a>
                </div>
            `;
        });
    
    // Function to delete product
    window.deleteProduct = function(productId) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            fetch(`/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/ProductApi/destroy/${productId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Product deleted successfully') {
                    window.location.href = '/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product';
                } else {
                    alert('Xóa sản phẩm thất bại');
                }
            })
            .catch(error => {
                console.error('Error deleting product:', error);
                alert('Đã xảy ra lỗi khi xóa sản phẩm');
            });
        }
    };
});
</script>

<?php include 'app/views/shares/footer.php'; ?>