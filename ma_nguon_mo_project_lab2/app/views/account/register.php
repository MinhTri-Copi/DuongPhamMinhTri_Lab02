<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $err): ?>
                                    <li><?php echo $err; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <form action="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/account/save" method="post">
                            <div class="mb-md-4 mt-md-3">
                                <h2 class="fw-bold mb-3 text-uppercase">Đăng Ký</h2>
                                <p class="text-white-50 mb-4">Vui lòng điền đầy đủ thông tin để đăng ký tài khoản mới!</p>
                                
                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="username" id="username" class="form-control form-control-lg" required />
                                    <label class="form-label" for="username">Tên đăng nhập</label>
                                </div>
                                
                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="fullname" id="fullname" class="form-control form-control-lg" required />
                                    <label class="form-label" for="fullname">Họ và tên</label>
                                </div>
                                
                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" required />
                                    <label class="form-label" for="password">Mật khẩu</label>
                                </div>
                                
                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control form-control-lg" required />
                                    <label class="form-label" for="confirmpassword">Xác nhận mật khẩu</label>
                                </div>
                                
                                <button class="btn btn-outline-light btn-lg px-5 mt-3" type="submit">Đăng Ký</button>
                            </div>
                            
                            <div class="mt-3">
                                <p class="mb-0">Đã có tài khoản? <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/account/login" class="text-white-50 fw-bold">Đăng nhập</a></p>
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
