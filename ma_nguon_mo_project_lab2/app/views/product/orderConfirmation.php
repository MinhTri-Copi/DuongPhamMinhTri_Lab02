<?php include 'app/views/shares/header.php'; ?>

<div class="order-success-page">
    <div class="container py-5">
        <div class="success-card">
            <div class="success-icon-container">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            
            <div class="success-content">
                <h1>Đặt hàng thành công!</h1>
                <p class="success-message">Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>
                
                <!-- Order Info -->
                <div class="order-info">
                    <div class="order-number">
                        <span class="info-label">Mã đơn hàng:</span>
                        <span class="info-value">#ORD-<?php echo date('Ymd') . rand(1000, 9999); ?></span>
                    </div>
                    <div class="order-date">
                        <span class="info-label">Ngày đặt hàng:</span>
                        <span class="info-value"><?php echo date('d/m/Y H:i'); ?></span>
                    </div>
                </div>
                
                <!-- Estimated Delivery -->
                <div class="delivery-info">
                    <div class="truck-animation">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="delivery-text">
                        <p>Dự kiến giao hàng trong khoảng:</p>
                        <p class="delivery-date"><?php 
                            $today = new DateTime();
                            $today->add(new DateInterval('P3D')); // Add 3 days
                            echo $today->format('d/m/Y');
                        ?> - <?php 
                            $today->add(new DateInterval('P2D')); // Add 2 more days
                            echo $today->format('d/m/Y');
                        ?></p>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <?php if (isset($_SESSION['last_order']) && !empty($_SESSION['last_order'])): ?>
                <div class="order-summary">
                    <h3>Tóm tắt đơn hàng</h3>
                    <div class="summary-details">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="summary-block customer-info">
                                    <h4>Thông tin khách hàng</h4>
                                    <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($_SESSION['last_order']['name'] ?? ''); ?></p>
                                    <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($_SESSION['last_order']['phone'] ?? ''); ?></p>
                                    <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($_SESSION['last_order']['address'] ?? ''); ?></p>
                                    <?php if (!empty($_SESSION['last_order']['email'])): ?>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['last_order']['email']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="summary-block payment-info">
                                    <h4>Thông tin thanh toán</h4>
                                    <p><strong>Phương thức:</strong> <?php 
                                        $payment = $_SESSION['last_order']['payment_method'] ?? 'cod';
                                        switch($payment) {
                                            case 'card':
                                                echo 'Thẻ tín dụng/ghi nợ';
                                                break;
                                            case 'bank':
                                                echo 'Chuyển khoản ngân hàng';
                                                break;
                                            default:
                                                echo 'Thanh toán khi nhận hàng (COD)';
                                        }
                                    ?></p>
                                    <p><strong>Tổng tiền:</strong> <span class="order-total">
                                        <?php 
                                            echo isset($_SESSION['last_order']['total']) 
                                                ? number_format($_SESSION['last_order']['total'], 0, ',', '.') . '₫' 
                                                : 'Đã thanh toán';
                                        ?>
                                    </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Steps -->
                <div class="next-steps">
                    <h3>Các bước tiếp theo</h3>
                    <div class="step-blocks">
                        <div class="step">
                            <div class="step-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="step-content">
                                <h4>Kiểm tra email</h4>
                                <p>Chúng tôi đã gửi email xác nhận đơn hàng đến địa chỉ email của bạn</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="step-content">
                                <h4>Theo dõi đơn hàng</h4>
                                <p>Bạn có thể theo dõi trạng thái đơn hàng trong tài khoản của mình</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="step-content">
                                <h4>Hỗ trợ</h4>
                                <p>Liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi nào về đơn hàng</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <?php if (isset($_SESSION['last_order']['is_buy_now']) && $_SESSION['last_order']['is_buy_now']): ?>
                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/" class="btn btn-primary btn-lg mr-2">
                        <i class="fas fa-shopping-bag mr-2"></i> Tiếp tục mua sắm
                    </a>
                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/cart" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-shopping-cart mr-2"></i> Xem giỏ hàng
                    </a>
                    <?php else: ?>
                    <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag mr-2"></i> Tiếp tục mua sắm
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .order-success-page {
        background-color: #f8f9fa;
        min-height: 80vh;
        padding: 20px 0 60px;
    }
    
    .success-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        padding: 0;
        max-width: 900px;
        margin: 0 auto;
        overflow: hidden;
        position: relative;
    }
    
    .success-icon-container {
        background: linear-gradient(135deg, #4CAF50, #8BC34A);
        text-align: center;
        padding: 30px 0;
        position: relative;
        overflow: hidden;
    }
    
    .success-icon {
        width: 100px;
        height: 100px;
        background-color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        position: relative;
        z-index: 2;
        animation: pulse 2s infinite;
    }
    
    .success-icon i {
        font-size: 50px;
        color: #4CAF50;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255,255,255, 0.7);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(255,255,255, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255,255,255, 0);
        }
    }
    
    .success-content {
        padding: 30px 40px;
        text-align: center;
    }
    
    .success-content h1 {
        color: #333;
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .success-message {
        font-size: 18px;
        color: #666;
        margin-bottom: 30px;
    }
    
    .order-info {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 30px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
    }
    
    .info-label {
        color: #666;
        margin-right: 8px;
    }
    
    .info-value {
        font-weight: 600;
        color: #333;
    }
    
    .delivery-info {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F0F7FF;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .truck-animation {
        margin-right: 20px;
        font-size: 30px;
        color: #2962ff;
        animation: truck 2s infinite;
    }
    
    @keyframes truck {
        0% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        100% { transform: translateX(-5px); }
    }
    
    .delivery-text p {
        margin: 0;
        color: #555;
    }
    
    .delivery-date {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-top: 5px !important;
    }
    
    .order-summary {
        margin-bottom: 30px;
        text-align: left;
    }
    
    .order-summary h3 {
        font-size: 22px;
        margin-bottom: 20px;
        color: #333;
        position: relative;
        padding-bottom: 10px;
    }
    
    .order-summary h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background-color: #4CAF50;
    }
    
    .summary-block {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        height: 100%;
    }
    
    .summary-block h4 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
    }
    
    .summary-block p {
        margin-bottom: 8px;
        color: #555;
    }
    
    .order-total {
        color: #e53935;
        font-weight: 700;
    }
    
    .next-steps {
        margin-bottom: 30px;
        text-align: left;
    }
    
    .next-steps h3 {
        font-size: 22px;
        margin-bottom: 20px;
        color: #333;
        position: relative;
        padding-bottom: 10px;
    }
    
    .next-steps h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background-color: #4CAF50;
    }
    
    .step-blocks {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-between;
        margin-top: 20px;
    }
    
    .step {
        flex: 1;
        min-width: 200px;
        display: flex;
        align-items: flex-start;
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
    }
    
    .step-icon {
        width: 50px;
        height: 50px;
        background-color: #e3f2fd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .step-icon i {
        font-size: 22px;
        color: #2962ff;
    }
    
    .step-content {
        text-align: left;
    }
    
    .step-content h4 {
        font-size: 16px;
        margin-bottom: 5px;
        color: #333;
    }
    
    .step-content p {
        font-size: 14px;
        color: #666;
        margin: 0;
    }
    
    .action-buttons {
        margin-top: 30px;
    }
    
    .btn-primary {
        background-color: #4CAF50;
        border-color: #4CAF50;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 500;
        border-radius: 6px;
        box-shadow: 0 4px 6px rgba(76, 175, 80, 0.15);
    }
    
    .btn-primary:hover {
        background-color: #3d9040;
        border-color: #3d9040;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(76, 175, 80, 0.2);
    }
    
    /* Responsive styles */
    @media (max-width: 768px) {
        .success-content {
            padding: 25px;
        }
        
        .step-blocks {
            flex-direction: column;
        }
        
        .step {
            width: 100%;
        }
        
        .success-content h1 {
            font-size: 24px;
        }
        
        .order-info {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Celebrate with confetti if available
    if (typeof confetti === 'function') {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 }
        });
    }
    
    // Simulate loading previous order data (in a real app, this would come from backend)
    if (!window.sessionStorage.getItem('order_viewed')) {
        window.sessionStorage.setItem('order_viewed', 'true');
        
        // You could add additional animations or effects here
    }
});
</script>

<?php include 'app/views/shares/footer.php'; ?>