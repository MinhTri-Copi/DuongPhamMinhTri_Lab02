<!-- filepath: /c:/laragon/www/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/app/views/shares/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneStore - Cửa hàng điện thoại chính hãng</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #2962ff;
            --secondary-color: #0039cb;
            --dark-color: #212121;
            --light-color: #f5f5f5;
            --success-color: #4caf50;
            --danger-color: #f44336;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.6rem;
            color: #fff !important;
        }
        
        .navbar-brand i {
            margin-right: 8px;
        }
        
        .nav-link {
            color: #fff !important;
            font-weight: 500;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: #ffe082 !important;
            transform: translateY(-2px);
        }
        
        .cart-icon {
            position: relative;
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .search-form {
            position: relative;
            margin-right: 10px;
        }
        
        .search-input {
            border-radius: 20px;
            padding-left: 15px;
            border: none;
        }
        
        .search-button {
            position: absolute;
            right: 5px;
            top: 5px;
            border: none;
            background: transparent;
            color: var(--primary-color);
        }
        
        .navbar-toggler {
            border: none;
        }
        
        .promotion-banner {
            background-color: #ffe082;
            color: var(--dark-color);
            text-align: center;
            padding: 8px 0;
            font-weight: 500;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-categories {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 10px;
        }
        
        .category-item {
            text-align: center;
            padding: 10px;
            transition: transform 0.3s ease;
        }
        
        .category-item:hover {
            transform: translateY(-5px);
        }
        
        .category-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 8px;
        }
        
        .category-name {
            font-size: 0.9rem;
            color: var(--dark-color);
        }
    </style>
</head>
<body>
<div class="promotion-banner">
    🔥 Khuyến mãi hot - Giảm đến 50% cho các dòng điện thoại mới nhất! 🔥
</div>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/">
            <i class="fas fa-mobile-alt"></i> PhoneStore
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <form class="form-inline my-2 my-lg-0 search-form ml-auto" action="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/searchAndFilter" method="GET">
                <input class="form-control mr-sm-2 search-input" type="search" name="keyword" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                <button class="search-button" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/">
                        <i class="fas fa-home"></i> Trang chủ
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-list"></i> Danh mục
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category/">Xem danh mục</a>
                        <a class="dropdown-item" href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category/add">Thêm danh mục</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-mobile"></i> Sản phẩm
                    </a>
                    <div class="dropdown-menu" aria-labelledby="productsDropdown">
                        <a class="dropdown-item" href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/">Danh sách sản phẩm</a>
                        <a class="dropdown-item" href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/add">Thêm sản phẩm</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link cart-icon" href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/cart">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
                        <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span class="cart-badge"><?php echo count($_SESSION['cart']); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <?php if(isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'Product/cart') === false && strpos($_SERVER['REQUEST_URI'], 'Product/checkout') === false): ?>
    <div class="main-categories mb-4">
        <div class="row">
            <div class="col-4 col-md-2 category-item">
                <div class="category-icon"><i class="fas fa-mobile-alt"></i></div>
                <div class="category-name">Điện thoại</div>
            </div>
            <div class="col-4 col-md-2 category-item">
                <div class="category-icon"><i class="fas fa-tablet-alt"></i></div>
                <div class="category-name">Máy tính bảng</div>
            </div>
            <div class="col-4 col-md-2 category-item">
                <div class="category-icon"><i class="fas fa-laptop"></i></div>
                <div class="category-name">Laptop</div>
            </div>
            <div class="col-4 col-md-2 category-item">
                <div class="category-icon"><i class="fas fa-headphones"></i></div>
                <div class="category-name">Âm thanh</div>
            </div>
            <div class="col-4 col-md-2 category-item">
                <div class="category-icon"><i class="fas fa-clock"></i></div>
                <div class="category-name">Đồng hồ</div>
            </div>
            <div class="col-4 col-md-2 category-item">
                <div class="category-icon"><i class="fas fa-sim-card"></i></div>
                <div class="category-name">Phụ kiện</div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
</body>
</html>