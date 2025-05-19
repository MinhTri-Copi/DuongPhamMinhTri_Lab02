<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .action-links a {
            margin-right: 10px;
        }
        .btn-add {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include 'app/views/shares/header.php'; ?>

    <div class="table-container">
        <h1 class="mb-4">Danh sách danh mục</h1>
        <a href="/ma_nguon_mo_project_lab2/Category/add" class="btn btn-primary btn-add">Thêm danh mục</a>
        
        <?php if (empty($categories)): ?>
            <div class="alert alert-info">Không có danh mục nào được tìm thấy.</div>
        <?php else: ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tên danh mục</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= htmlspecialchars($category->id) ?></td>
                            <td><?= htmlspecialchars($category->name) ?></td>
                            <td><?= htmlspecialchars($category->description) ?></td>
                            <td class="action-links">
                                <a href="/ma_nguon_mo_project_lab2/Category/edit/<?= $category->id ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <a href="/ma_nguon_mo_project_lab2/Category/show/<?= $category->id ?>" class="btn btn-sm btn-info">Xem</a>

                                <a href="/ma_nguon_mo_project_lab2/Category/delete/<?= $category->id ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php include 'app/views/shares/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>