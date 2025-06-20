<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 gradient-custom">
<div class="container py-5 h-100">
<div class="row d-flex justify-content-center align-items-center h-100">    
<div class="col-12 col-md-8 col-lg-6 col-xl-5">
<div class="card bg-dark text-white" style="border-radius: 1rem;">
<div class="card-body p-5 text-center">
<form action="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/account/checklogin" method="post">
<div class="mb-md-5 mt-md-4 pb-5">
<h2 class="fw-bold mb-2 text-uppercase">Đăng Nhập</h2>
<p class="text-white-50 mb-5">Vui lòng nhập tên đăng nhập và mật khẩu!</p>
<div class="form-outline form-white mb-4">
<input type="text" name="username" class="form-control form-control-lg" required />
<label class="form-label" for="typeEmailX">Tên đăng nhập</label>
</div>
<div class="form-outline form-white mb-4">
<input type="password" name="password" class="form-control form-control-lg" required />
<label class="form-label" for="typePasswordX">Mật khẩu</label>
</div>
<p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Quên mật khẩu?</a></p>
<button class="btn btn-outline-light btn-lg px-5"
type="submit">Đăng Nhập</button>
<div class="d-flex justify-content-center text-center mt-4 pt-1">
<a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
<a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 
px-2"></i></a>
<a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
</div>
</div>
<div>
<p class="mb-0">Chưa có tài khoản? <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/account/register" class="text-white-50 fw-bold">Đăng ký</a>
</p>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>

<style>
    .gradient-custom {
        background: linear-gradient(to right, rgba(41, 98, 255, 0.7), rgba(0, 57, 203, 0.7));
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>
