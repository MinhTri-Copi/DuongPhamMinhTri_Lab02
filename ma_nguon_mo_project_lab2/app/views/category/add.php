<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm danh mục</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .form-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        textarea {
            height: 100px;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        @media (max-width: 600px) {
            .form-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<?php include 'app/views/shares/header.php'; ?>

    <div class="form-container">
        <h1>Thêm danh mục</h1>
        <form action="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Category/save" method="POST">
            <label for="name">Tên danh mục:</label>
            <input type="text" id="name" name="name" required>
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" required></textarea>
            <button type="submit">Lưu</button>
        </form>
        <?php include 'app/views/shares/footer.php'; ?>

    </div>
</body>
</html>