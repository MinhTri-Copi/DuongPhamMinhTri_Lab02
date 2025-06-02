<?php include 'app/views/shares/header.php'; ?>

<div class="checkout-page">
    <div class="container py-4">
        <?php if (isset($_SESSION['is_buy_now']) && $_SESSION['is_buy_now']): ?>
        <div class="alert alert-info alert-dismissible fade show buy-now-alert" role="alert">
            <i class="fas fa-info-circle mr-2"></i> Bạn đang mua ngay sản phẩm này. Hãy điền thông tin giao hàng để hoàn tất đơn hàng.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-8">
                <!-- Invoice-like Order Summary -->
                <div class="invoice-card">
                    <div class="invoice-header">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="invoice-title">
                                    <h3>Hóa đơn thanh toán</h3>
                                    <p class="invoice-id">Mã hóa đơn: INV-<?php echo date('Ymd') . rand(1000, 9999); ?></p>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right">
                                <div class="invoice-date">
                                    <p>Ngày: <?php echo date('d/m/Y'); ?></p>
                                    <p>Thời gian: <?php echo date('H:i'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="invoice-company">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="company-details">
                                    <h5>PhoneStore</h5>
                                    <p>Cửa hàng điện thoại chính hãng</p>
                                    <p>273 An Dương Vương, Phường 3, Quận 5, TPHCM</p>
                                    <p>0123 456 789 | contact@phonestore.com</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-right">
                                <div class="logo-container">
                                    <i class="fas fa-mobile-alt company-logo"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="invoice-products">
                        <h5 class="section-title">Chi tiết đơn hàng</h5>
                        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                            <div class="table-responsive">
                                <table class="table invoice-table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th class="text-center">Giá</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-right">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $total = 0;
                                        $subtotal = 0;
                                        $itemCount = 0;
                                        foreach ($_SESSION['cart'] as $id => $item): 
                                            $itemTotal = $item['price'] * $item['quantity'];
                                            $subtotal += $itemTotal;
                                            $itemCount += $item['quantity'];
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="product-info">
                                                    <div class="product-name"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></div>
                                                    <div class="product-id">Mã SP: <?php echo $id; ?></div>
                                                </div>
                                            </td>
                                            <td class="text-center"><?php echo number_format($item['price'], 0, ',', '.'); ?>₫</td>
                                            <td class="text-center"><?php echo $item['quantity']; ?></td>
                                            <td class="text-right item-total"><?php echo number_format($itemTotal, 0, ',', '.'); ?>₫</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="invoice-summary">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="payment-details">
                                            <h6>Phương thức thanh toán</h6>
                                            <div class="payment-method">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="payment1" value="cod" checked>
                                                    <label class="form-check-label" for="payment1">
                                                        <i class="fas fa-money-bill-wave"></i> Thanh toán khi nhận hàng
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="payment2" value="bank">
                                                    <label class="form-check-label" for="payment2">
                                                        <i class="fas fa-university"></i> Chuyển khoản ngân hàng
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="payment3" value="card">
                                                    <label class="form-check-label" for="payment3">
                                                        <i class="far fa-credit-card"></i> Thẻ tín dụng/ghi nợ
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="price-calculation">
                                            <div class="price-row">
                                                <div class="price-label">Tạm tính (<?php echo $itemCount; ?> sản phẩm):</div>
                                                <div class="price-value"><?php echo number_format($subtotal, 0, ',', '.'); ?>₫</div>
                                            </div>
                                            <div class="price-row">
                                                <div class="price-label">Phí vận chuyển:</div>
                                                <div class="price-value shipping-fee">Miễn phí</div>
                                            </div>
                                            <?php
                                            // Calculate VAT (10% for example)
                                            $vat = $subtotal * 0.1;
                                            $total = $subtotal + $vat;
                                            ?>
                                            <div class="price-row">
                                                <div class="price-label">Thuế VAT (10%):</div>
                                                <div class="price-value"><?php echo number_format($vat, 0, ',', '.'); ?>₫</div>
                                            </div>
                                            <div class="price-row total">
                                                <div class="price-label">Tổng thanh toán:</div>
                                                <div class="price-value total-value"><?php echo number_format($total, 0, ',', '.'); ?>₫</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="empty-cart-message">
                                <i class="fas fa-shopping-cart empty-cart-icon"></i>
                                <p>Giỏ hàng trống.</p>
                                <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product" class="btn btn-primary">Tiếp tục mua sắm</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="shipping-details">
                    <div class="section-header">
                        <h5>Thông tin giao hàng</h5>
                    </div>
                    <div class="section-body">
                        <form method="POST" action="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/processCheckout" id="checkoutForm">
                            <div class="form-group">
                                <label for="name">Họ tên người nhận *</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại *</label>
                                <input type="text" id="phone" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ nhận hàng *</label>
                                <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="note">Ghi chú</label>
                                <textarea id="note" name="note" class="form-control" rows="2"></textarea>
                            </div>
                            
                            <div class="checkout-actions">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">Xác nhận đặt hàng</button>
                                <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/cart" class="btn btn-outline-secondary btn-block mt-3">
                                    <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .checkout-page {
        background-color: #f8f9fa;
        min-height: 80vh;
        padding-bottom: 50px;
    }
    
    .buy-now-alert {
        border-left: 4px solid #2962ff;
        background-color: rgba(41, 98, 255, 0.1);
    }
    
    /* Invoice card styling */
    .invoice-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .invoice-header {
        padding: 20px 25px;
        border-bottom: 1px solid #eaeaea;
        background-color: #f8f9fa;
    }
    
    .invoice-title h3 {
        font-size: 22px;
        font-weight: 600;
        color: #333;
        margin: 0 0 5px 0;
    }
    
    .invoice-id {
        font-size: 14px;
        color: #666;
        margin: 0;
    }
    
    .invoice-date p {
        margin: 0 0 3px 0;
        font-size: 14px;
        color: #666;
    }
    
    .invoice-company {
        padding: 20px 25px;
        border-bottom: 1px solid #eaeaea;
    }
    
    .company-details h5 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .company-details p {
        margin: 0 0 3px 0;
        font-size: 14px;
        color: #555;
    }
    
    .logo-container {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        height: 100%;
    }
    
    .company-logo {
        font-size: 48px;
        color: #2962ff;
        opacity: 0.8;
    }
    
    .invoice-products {
        padding: 20px 25px;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eaeaea;
    }
    
    .invoice-table {
        margin-bottom: 25px;
    }
    
    .invoice-table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-top: none;
        border-bottom: 2px solid #eaeaea;
        color: #555;
        font-size: 15px;
    }
    
    .invoice-table tbody td {
        vertical-align: middle;
        border-color: #eaeaea;
        padding: 12px;
    }
    
    .product-info {
        margin-bottom: 0;
    }
    
    .product-name {
        font-weight: 500;
        color: #333;
        margin-bottom: 3px;
    }
    
    .product-id {
        font-size: 13px;
        color: #888;
    }
    
    .item-total {
        font-weight: 600;
        color: #333;
    }
    
    .invoice-summary {
        padding-top: 20px;
        border-top: 1px solid #eaeaea;
    }
    
    .payment-details h6 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 12px;
    }
    
    .payment-method {
        margin-bottom: 0;
    }
    
    .form-check {
        margin-bottom: 8px;
    }
    
    .form-check-label {
        font-size: 14px;
        color: #333;
    }
    
    .form-check-label i {
        margin-right: 5px;
        color: #2962ff;
    }
    
    .price-calculation {
        background-color: #f8f9fa;
        border-radius: 6px;
        padding: 15px;
    }
    
    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    
    .price-label {
        color: #555;
    }
    
    .price-value {
        font-weight: 500;
    }
    
    .shipping-fee {
        color: #4caf50;
    }
    
    .price-row.total {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed #ddd;
    }
    
    .total-value {
        font-size: 18px;
        font-weight: 700;
        color: #e53935;
    }
    
    /* Shipping details */
    .shipping-details {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .section-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eaeaea;
        background-color: #f8f9fa;
    }
    
    .section-header h5 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        color: #333;
    }
    
    .section-body {
        padding: 20px 20px;
    }
    
    .form-group label {
        font-size: 14px;
        font-weight: 500;
        color: #555;
    }
    
    .checkout-actions {
        margin-top: 25px;
    }
    
    .btn-primary {
        background-color: #2962ff;
        border-color: #2962ff;
    }
    
    .btn-primary:hover {
        background-color: #1c54e9;
        border-color: #1c54e9;
    }
    
    .empty-cart-message {
        text-align: center;
        padding: 30px 0;
    }
    
    .empty-cart-icon {
        font-size: 48px;
        color: #ddd;
        margin-bottom: 15px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // You could add any JavaScript functionality here
    // For example, validating the form, showing different payment options, etc.
    
    // Simple form validation
    const form = document.getElementById('checkoutForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const address = document.getElementById('address').value.trim();
            
            let valid = true;
            let errorMessage = '';
            
            if (!name) {
                valid = false;
                errorMessage += 'Vui lòng nhập họ tên.\n';
            }
            
            if (!phone) {
                valid = false;
                errorMessage += 'Vui lòng nhập số điện thoại.\n';
            } else if (!/^[0-9]{10,11}$/.test(phone)) {
                valid = false;
                errorMessage += 'Số điện thoại không hợp lệ.\n';
            }
            
            if (!address) {
                valid = false;
                errorMessage += 'Vui lòng nhập địa chỉ giao hàng.';
            }
            
            if (!valid) {
                e.preventDefault();
                alert(errorMessage);
            }
        });
    }
});
</script>

<?php include 'app/views/shares/footer.php'; ?>