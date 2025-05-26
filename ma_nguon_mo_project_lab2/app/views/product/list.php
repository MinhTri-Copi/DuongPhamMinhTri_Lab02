<?php include 'app/views/shares/header.php'; ?>

<div class="product-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="display-4 mb-0">Sản phẩm nổi bật</h1>
            <p class="text-muted">Khám phá các sản phẩm chính hãng với giá tốt nhất</p>
        </div>
        <div class="col-md-6 text-right">
            <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/add" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Thêm sản phẩm mới
            </a>
        </div>
    </div>
</div>

<!-- Form tìm kiếm và lọc -->
<div class="search-filter-container bg-white p-3 mb-4 rounded shadow-sm">
    <form method="GET" action="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/searchAndFilter" class="mb-0">
        <div class="row align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                    </div>
                    <input type="text" name="keyword" class="form-control border-left-0" placeholder="Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($_GET['keyword'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </div>
            <div class="col-md-5">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0">
                            <i class="fas fa-list text-primary"></i>
                        </span>
                    </div>
                    <select name="category_id" class="form-control border-left-0">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>" <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-filter"></i> Lọc
                </button>
            </div>
        </div>
    </form>
</div>

<div class="row">
    <?php foreach ($products as $product): ?>
    <div class="col-md-4 col-sm-6 mb-4">
        <div class="card product-card h-100 shadow-sm">
            <?php if ($product->image): ?>
            <div class="product-image-container">
                <img src="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/<?php echo $product->image; ?>" class="card-img-top product-image" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                <span class="badge badge-category"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
            <?php endif; ?>
            
            <div class="card-body">
                <h5 class="card-title product-name">
                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/show/<?php echo $product->id; ?>">
                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h5>
                
                <div class="product-rating mb-2">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star-half-alt text-warning"></i>
                    <small class="text-muted ml-1">(4.5)</small>
                </div>
                
                <p class="card-text product-description">
                    <?php echo substr(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'), 0, 100) . (strlen($product->description) > 100 ? '...' : ''); ?>
                </p>
                
                <div class="product-price mb-3">
                    <span class="price"><?php echo number_format($product->price, 0, ',', '.'); ?> ₫</span>
                    <small class="text-success ml-2">Còn hàng</small>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top-0">
                <div class="btn-group w-100">
                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary flex-fill">
                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                    </a>
                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/show/<?php echo $product->id; ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-eye"></i>
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/edit/<?php echo $product->id; ?>">
                                <i class="fas fa-edit text-warning"></i> Sửa
                            </a>
                            <a class="dropdown-item" href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/delete/<?php echo $product->id; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                <i class="fas fa-trash text-danger"></i> Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
    .product-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
    }
    
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 8px;
        overflow: hidden;
        border: none;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.12);
    }
    
    .product-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
        background-color: #f8f9fa;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 10px;
        transition: transform 0.5s;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .badge-category {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--primary-color);
        color: white;
        border-radius: 15px;
        padding: 0.4rem 0.8rem;
        font-weight: 500;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    .product-name {
        font-weight: bold;
        height: 48px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .product-name a {
        color: #212121;
        text-decoration: none;
    }
    
    .product-name a:hover {
        color: var(--primary-color);
    }
    
    .product-description {
        font-size: 0.85rem;
        color: #6c757d;
        height: 48px;
        overflow: hidden;
    }
    
    .product-price .price {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--danger-color);
    }
    
    .card-footer .btn-group {
        gap: 5px;
    }
    
    .search-filter-container {
        border-radius: 10px;
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>