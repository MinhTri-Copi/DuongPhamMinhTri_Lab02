<?php include 'app/views/shares/header.php'; ?>

<div class="featured-header-container">
    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col-lg-7 col-md-7">
                <h1 class="featured-title">Sản phẩm nổi bật</h1>
                <p class="featured-subtitle">Khám phá các sản phẩm chính hãng với giá tốt nhất</p>
            </div>
            <div class="col-lg-5 col-md-5 text-right">
                <?php if (SessionHelper::isAdmin()): ?>
                <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/add" class="btn btn-success rounded-pill btn-add-product">
                    <i class="fas fa-plus-circle mr-1"></i> Thêm sản phẩm mới
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Category Filter -->
<div class="category-filter-container mb-4">
    <div class="container">
        <div class="category-filter">
            <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/searchAndFilter" class="category-filter-item <?php echo empty($_GET['category_id']) ? 'active' : ''; ?>">
                <div class="category-filter-icon">
                    <i class="fas fa-th-large"></i>
                </div>
                <div class="category-filter-name">Tất cả</div>
            </a>
            
            <?php 
            // Define category mappings with their icons and potential IDs
            $categoryMappings = [
                'Điện thoại' => ['icon' => 'fas fa-mobile-alt', 'ids' => []],
                'Máy tính bảng' => ['icon' => 'fas fa-tablet-alt', 'ids' => []],
                'Laptop' => ['icon' => 'fas fa-laptop', 'ids' => []],
                'Thiết bị âm thanh' => ['icon' => 'fas fa-headphones', 'ids' => []],
                'Đồng hồ' => ['icon' => 'fas fa-clock', 'ids' => []],
                'Phụ kiện' => ['icon' => 'fas fa-sim-card', 'ids' => []]
            ];
            
            // Make sure $categories is defined before using it
            if (isset($categories) && !empty($categories)) {
                // Map category IDs to their respective types
                foreach ($categories as $category) {
                    $catName = strtolower($category->name);
                    foreach ($categoryMappings as $key => $value) {
                        if (strpos($catName, strtolower($key)) !== false) {
                            $categoryMappings[$key]['ids'][] = $category->id;
                        }
                    }
                }
            }
            
            // Display category filter items
            foreach ($categoryMappings as $name => $details): 
                $isActive = false;
                if (!empty($_GET['category_id']) && !empty($details['ids'])) {
                    $isActive = in_array($_GET['category_id'], $details['ids']);
                }
                
                // Get the first category ID for this type or use an empty string
                $categoryId = !empty($details['ids']) ? $details['ids'][0] : '';
            ?>
            <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/searchAndFilter?category_id=<?php echo $categoryId; ?>" 
               class="category-filter-item <?php echo $isActive ? 'active' : ''; ?>">
                <div class="category-filter-icon">
                    <i class="<?php echo $details['icon']; ?>"></i>
                </div>
                <div class="category-filter-name"><?php echo $name; ?></div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Search and filter form -->
<div class="search-filter-container bg-white p-3 mb-4 rounded shadow-sm">
    <div class="container">
        <form method="GET" action="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/searchAndFilter" class="mb-0" id="searchForm">
            <div class="row">
                <div class="col-md-7">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="keyword" class="form-control search-input" placeholder="Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($_GET['keyword'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="category-select-wrapper">
                        <i class="fas fa-th-list category-icon"></i>
                        <select name="category_id" class="form-control category-select" id="categorySelect">
                            <option value="">Tất cả danh mục</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>" <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Hidden submit button for pressing enter -->
            <button type="submit" style="display: none;">Search</button>
        </form>
    </div>
</div>

<div class="row" id="product-container">
    <!-- Products will be loaded dynamically -->
</div>

<style>
    /* Category Filter Styles */
    .category-filter-container {
        background-color: white;
        padding: 15px 0;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }
    
    .category-filter {
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 10px;
        padding: 0 10px;
    }
    
    .category-filter-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 80px;
        text-decoration: none;
        color: #666;
        padding: 8px 5px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    
    .category-filter-item:hover, .category-filter-item.active {
        color: var(--primary-color);
        background-color: rgba(41,98,255,0.08);
        transform: translateY(-2px);
    }
    
    .category-filter-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 50%;
        margin-bottom: 8px;
    }
    
    .category-filter-item:hover .category-filter-icon, 
    .category-filter-item.active .category-filter-icon {
        background-color: rgba(41,98,255,0.12);
    }
    
    .category-filter-icon i {
        font-size: 1.5rem;
    }
    
    .category-filter-name {
        font-size: 0.8rem;
        text-align: center;
        white-space: nowrap;
    }
    
    /* Hide scrollbar for Chrome, Safari and Opera */
    .category-filter::-webkit-scrollbar {
        display: none;
    }
    
    /* Hide scrollbar for IE, Edge and Firefox */
    .category-filter {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    
    /* Featured header styles */
    .featured-header-container {
        padding: 25px 0 5px 0;
        background-color: #e3f2fd;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .featured-title {
        position: relative;
        font-size: 1.8rem;
        font-weight: 700;
        color: #2962ff;
        margin-bottom: 6px;
        padding-bottom: 8px;
        display: inline-block;
        overflow: hidden;
    }
    
    .featured-title:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 3px;
        background: #2962ff;
        animation: underlineGrow 1.2s ease-out;
        transform-origin: left;
    }
    
    @keyframes underlineGrow {
        0% {
            transform: scaleX(0);
        }
        100% {
            transform: scaleX(1);
        }
    }
    
    .featured-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 400;
        margin-bottom: 0;
    }
    
    .btn-add-product {
        padding: 8px 20px;
        font-weight: 500;
        font-size: 0.95rem;
        background-color: #4caf50;
        border-color: #4caf50;
        box-shadow: 0 2px 6px rgba(76, 175, 80, 0.3);
        transition: all 0.2s;
    }
    
    .btn-add-product:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(76, 175, 80, 0.4);
    }
    
    /* Product card styles */
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 8px;
        overflow: hidden;
        border: none;
        position: relative;
        opacity: 0;
        animation: fadeIn 0.5s ease forwards;
        animation-delay: calc(var(--product-index, 0) * 0.1s);
    }
    
    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(41, 98, 255, 0.15);
    }
    
    .product-image-container {
        height: 180px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        padding: 5px;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.3s;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 2;
    }
    
    .product-badge .badge {
        padding: 5px 8px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .product-name {
        font-size: 0.95rem;
        font-weight: 600;
        height: 40px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .product-name a {
        color: #333;
        text-decoration: none;
    }
    
    .product-name a:hover {
        color: var(--primary-color);
    }
    
    .product-rating {
        font-size: 0.8rem;
    }
    
    .product-price {
        display: flex;
        align-items: center;
    }
    
    .current-price {
        font-size: 1rem;
        font-weight: 700;
        color: #e53935;
    }
    
    .original-price {
        font-size: 0.8rem;
        text-decoration: line-through;
        color: #9e9e9e;
        margin-left: 8px;
    }
    
    .stock-status {
        font-size: 0.8rem;
    }
    
    .card-footer .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    /* Redesigned search and filter styles */
    .search-filter-container {
        padding: 16px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08) !important;
    }
    
    .search-input-wrapper, .category-select-wrapper {
        position: relative;
        margin-bottom: 0;
    }
    
    .search-input, .category-select {
        height: 48px;
        border-radius: 24px;
        padding-left: 45px;
        border: 1px solid #e0e0e0;
        font-size: 0.95rem;
        transition: all 0.3s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .search-input:focus, .category-select:focus {
        border-color: #2962ff;
        box-shadow: 0 0 0 3px rgba(41,98,255,0.15);
    }
    
    .search-icon, .category-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #2962ff;
        font-size: 1rem;
        z-index: 10;
    }
    
    .category-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%232962ff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
        padding-right: 40px;
    }
    
    .no-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0;
        color: #aaa;
        font-size: 14px;
        font-weight: 500;
    }
</style>

<!-- JavaScript for animations -->
<script>
// Định nghĩa biến isAdmin từ PHP
const isAdmin = <?php echo SessionHelper::isAdmin() ? 'true' : 'false'; ?>;

// JavaScript function to handle card clicks
function goToProductDetails(productId) {
    window.location.href = '/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/show/' + productId;
}

document.addEventListener('DOMContentLoaded', function() {
    // Fetch products from API with category name
    fetch('/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/getProductsJson')
        .then(response => {
            console.log('API Response status:', response.status);
            return response.json();
        })
        .then(products => {
            console.log('Products received from API:', products);
            
            // Kiểm tra từng sản phẩm và danh mục
            if (products && products.length > 0) {
                products.forEach(product => {
                    console.log(`Product ID: ${product.id}, Name: ${product.name}, Category ID: ${product.category_id}, Category Name: ${product.category_name || 'Không có'}`);
                });
            }
            
            const productContainer = document.getElementById('product-container');
            productContainer.innerHTML = ''; // Clear the container
            
            if (!products || products.length === 0) {
                productContainer.innerHTML = '<div class="col-12 text-center"><p>Không có sản phẩm nào</p></div>';
                return;
            }
            
            products.forEach(product => {
                const productHTML = `
                    <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                        <div class="card product-card h-100 shadow-sm" onclick="goToProductDetails(${product.id})">
                            <div class="product-badge">
                                <span class="badge badge-danger">-10%</span>
                            </div>
                            
                            <div class="product-image-container">
                                ${product.image ? 
                                    `<img src="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/${product.image}" class="product-image" alt="${product.name}" onerror="this.src='/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/public/images/placeholder.jpg'; this.onerror=null;">` : 
                                    `<div class="no-image-placeholder">No Image</div>`
                                }
                            </div>
                            
                            <div class="card-body p-2">
                                <h5 class="card-title product-name mb-1">
                                    ${product.name}
                                </h5>
                                
                                <div class="product-rating">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                    <small class="text-muted">(4.5)</small>
                                </div>
                                
                                <div class="product-price mt-2">
                                    <span class="current-price">${Number(product.price).toLocaleString('vi-VN')}₫</span>
                                    <span class="original-price">${Number(product.price * 1.1).toLocaleString('vi-VN')}₫</span>
                                </div>
                                
                                <div class="mt-2">
                                    <small class="text-success stock-status">Còn hàng</small>
                                </div>
                                
                                <div class="mt-2">
                                    <small class="text-muted">Danh mục: ${product.category_name || 'Chưa phân loại'}</small>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-white border-top-0 p-2">
                                <div class="d-flex gap-2 flex-wrap">
                                    ${isAdmin ? `
                                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/edit/${product.id}" class="btn btn-warning btn-sm w-100 mb-1" onclick="event.stopPropagation()">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <button class="btn btn-danger btn-sm w-100 mb-1" onclick="event.stopPropagation(); deleteProduct(${product.id})">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                    ` : ''}
                                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/addToCart/${product.id}" class="btn btn-sm btn-primary w-100 add-to-cart-btn" onclick="event.stopPropagation()">
                                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                productContainer.innerHTML += productHTML;
            });
            
            // Make product cards look clickable
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach((card) => {
                card.style.cursor = 'pointer';
            });
            
            // Set animation delay for each product card
            productCards.forEach((card, index) => {
                card.style.setProperty('--product-index', index);
            });
            
            // Add pulse animation to "Add to Cart" buttons
            const addToCartButtons = document.querySelectorAll('.card-footer .btn');
            addToCartButtons.forEach(button => {
                button.addEventListener('mouseover', function() {
                    this.classList.add('pulse-animation');
                });
                button.addEventListener('animationend', function() {
                    this.classList.remove('pulse-animation');
                });
            });
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            document.getElementById('product-container').innerHTML = '<div class="col-12"><div class="alert alert-danger">Lỗi khi tải sản phẩm. Vui lòng thử lại sau.</div></div>';
        });
    
    // Add subtle animation to featured section elements
    const featuredTitle = document.querySelector('.featured-title');
    const featuredSubtitle = document.querySelector('.featured-subtitle');
    
    // Subtle bounce effect on page load
    featuredTitle.classList.add('text-focus-in');
    if (featuredSubtitle) {
        setTimeout(() => {
            featuredSubtitle.classList.add('text-focus-in');
        }, 300);
    }
    
    // Auto-submit form when category is changed
    const categorySelect = document.getElementById('categorySelect');
    if(categorySelect) {
        categorySelect.addEventListener('change', function() {
            document.getElementById('searchForm').submit();
        });
    }
});

// Function to delete a product
function deleteProduct(id) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        fetch(`/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/ProductApi/destroy/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product deleted successfully') {
                // Reload the page to reflect the changes
                location.reload();
            } else {
                alert('Xóa sản phẩm thất bại');
            }
        })
        .catch(error => {
            console.error('Error deleting product:', error);
            alert('Đã xảy ra lỗi khi xóa sản phẩm');
        });
    }
}

// Add CSS for additional animations
const styleSheet = document.createElement('style');
styleSheet.textContent = `
    .pulse-animation {
        animation: pulse 0.5s ease-in-out;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .text-focus-in {
        animation: text-focus-in 0.8s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
    }
    
    @keyframes text-focus-in {
        0% {
            filter: blur(8px);
            opacity: 0;
        }
        100% {
            filter: blur(0px);
            opacity: 1;
        }
    }
    
    .btn-add-product {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }
`;
document.head.appendChild(styleSheet);
</script>

<?php include 'app/views/shares/footer.php'; ?>