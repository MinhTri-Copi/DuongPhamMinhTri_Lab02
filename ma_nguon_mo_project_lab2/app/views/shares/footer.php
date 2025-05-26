<!-- filepath: /c:/laragon/www/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/app/views/shares/footer.php -->
</div> <!-- Kết thúc container -->

<footer class="mt-5">
    <div class="footer-top bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5 class="text-uppercase font-weight-bold mb-4">
                        <i class="fas fa-mobile-alt mr-2"></i> PhoneStore
                    </h5>
                    <p class="mb-4">Cửa hàng chuyên cung cấp các sản phẩm điện thoại, laptop và phụ kiện chính hãng với giá tốt nhất thị trường.</p>
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="#" class="social-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="social-link">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="social-link">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5 class="text-uppercase font-weight-bold mb-4">Sản phẩm</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-white">iPhone</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white">Samsung</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white">Oppo</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white">Xiaomi</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white">Phụ kiện</a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase font-weight-bold mb-4">Hỗ trợ</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-white">Hướng dẫn mua hàng</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white">Chính sách bảo hành</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white">Chính sách đổi trả</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white">Vận chuyển & Thanh toán</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white">Chính sách bảo mật</a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase font-weight-bold mb-4">Liên hệ</h5>
                    <div class="mb-3">
                        <i class="fas fa-home mr-3"></i> 123 Nguyễn Văn Linh, Quận 7, TP HCM
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-envelope mr-3"></i> info@phonestore.com
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-phone mr-3"></i> 1900 1234
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-print mr-3"></i> 028 3123 4567
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="payment-methods py-3 bg-secondary">
        <div class="container text-center">
            <h6 class="text-white mb-3">Phương thức thanh toán</h6>
            <div class="d-flex justify-content-center align-items-center flex-wrap">
                <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Icon-VNPAY-QR.png" alt="VNPAY" height="30" class="mx-2 mb-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/MasterCard_Logo.svg/1200px-MasterCard_Logo.svg.png" alt="Mastercard" height="30" class="mx-2 mb-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" height="30" class="mx-2 mb-2">
                <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-ZaloPay-Square.png" alt="ZaloPay" height="30" class="mx-2 mb-2">
                <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-MoMo-Square.png" alt="MoMo" height="30" class="mx-2 mb-2">
            </div>
        </div>
    </div>
    
    <div class="footer-bottom py-3 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-left mb-2 mb-md-0">
                    <p class="m-0 text-white">
                        &copy; <?php echo date('Y'); ?> PhoneStore. Tất cả quyền được bảo lưu.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="text-white">
                        <small>Developed by Duong Pham Minh Tri</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    footer {
        color: #fff;
    }
    
    footer a {
        transition: all 0.3s ease;
    }
    
    footer a:hover {
        color: #ffe082 !important;
        text-decoration: none;
        padding-left: 5px;
    }
    
    .social-link {
        display: inline-block;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: rgba(255,255,255,0.2);
        color: #fff !important;
        text-align: center;
        line-height: 36px;
        margin-right: 8px;
        transition: all 0.3s ease;
    }
    
    .social-link:hover {
        background-color: #2962ff;
        transform: translateY(-3px);
    }
    
    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    .payment-methods img {
        filter: brightness(0) invert(1);
        transition: all 0.3s ease;
    }
    
    .payment-methods img:hover {
        transform: translateY(-3px);
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>