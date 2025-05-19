<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết danh mục</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        strong {
            color: #555;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            text-align: center;
        }
        a:hover {
            background-color: #45a049;
        }
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
<?php include 'app/views/shares/header.php'; ?>

    <div class="container">
        <h1>Chi tiết danh mục</h1>
        <p><strong>ID:</strong> <?= $category->id ?></p>
        <p><strong>Tên danh mục:</strong> <?= $category->name ?></p>
        <p><strong>Mô tả:</strong> <?= $category->description ?></p>
        <a href="/ThucHanhMaNguonMo/ma_nguon_mo_project_lab2/Category">Quay lại danh sách</a>
    </div>
    <?php include 'app/views/shares/footer.php'; ?>
</body>
</html>