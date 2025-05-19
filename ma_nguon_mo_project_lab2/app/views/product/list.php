<!-- filepath: /c:/laragon/www/ThucHanhMaNguonMo/ma_nguon_mo_project_lab2/app/views/product/list.php -->
<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Danh sách sản phẩm</h1>

    <!-- Form tìm kiếm và lọc -->
    <form method="GET" action="/ThucHanhMaNguonMo/ma_nguon_mo_project_lab2/Product/searchAndFilter" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($_GET['keyword'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="col-md-4">
                <select name="category_id" class="form-control">
                    <option value="">Tất cả danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>" <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $category->id) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
            </div>
        </div>
    </form>

    <div class="row">
        <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm custom-card">
                <?php if ($product->image): ?>
                <img src="/ThucHanhMaNguonMo/ma_nguon_mo_project_lab2/<?php echo $product->image; ?>" class="card-img-top img-fluid" alt="Hình ảnh sản phẩm">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/ThucHanhMaNguonMo/ma_nguon_mo_project_lab2/Product/show/<?php echo $product->id; ?>" class="text-decoration-none"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></a>
                    </h5>
                    <p class="card-text"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="card-text"><strong>Giá:</strong> <?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>
                    <p class="card-text"><strong>Danh mục:</strong> <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="card-footer text-center">
                    <a href="/ThucHanhMaNguonMo/ma_nguon_mo_project_lab2/Product/show/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">Xem</a>
                    <a href="/ThucHanhMaNguonMo/ma_nguon_mo_project_lab2/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="/ThucHanhMaNguonMo/ma_nguon_mo_project_lab2/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>