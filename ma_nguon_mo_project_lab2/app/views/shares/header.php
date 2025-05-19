<!-- filepath: /c:/laragon/www/ma_nguon_mo_project_lab2/app/views/shares/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #007bff !important;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .nav-link:hover {
            color: #d4d4d4 !important;
        }
        .navbar-toggler-icon {
            filter: invert(1);
        }
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/ma_nguon_mo_project_lab2/Product/">Danh sách sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/ma_nguon_mo_project_lab2/Product/add">Thêm sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/ma_nguon_mo_project_lab2/Category/">Danh mục</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-4">