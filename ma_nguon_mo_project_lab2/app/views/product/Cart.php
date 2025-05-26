<?php include 'app/views/shares/header.php'; ?>

<div class="cart-page">
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-main-content">
                    <div class="cart-header">
                        <h2>Giỏ hàng của bạn</h2>
                    </div>
                    
                    <?php if (!empty($cart)): ?>
                        <div class="cart-items">
                            <?php foreach ($cart as $id => $item): ?>
                            <div class="cart-item" data-id="<?php echo $id; ?>" data-price="<?php echo $item['price']; ?>">
                                <div class="cart-item-inner">
                                    <div class="item-select">
                                        <input type="checkbox" class="item-checkbox" id="check-<?php echo $id; ?>" checked data-id="<?php echo $id; ?>">
                                    </div>
                                    
                                    <div class="item-image">
                                        <?php if ($item['image']): ?>
                                        <img src="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="item-details">
                                        <h3 class="item-name"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                        <div class="item-meta">Mã sản phẩm: SP-<?php echo $id; ?></div>
                                        
                                        <div class="item-price-qty">
                                            <div class="item-price"><?php echo number_format($item['price'], 0, ',', '.'); ?>₫</div>
                                            
                                            <div class="quantity-control">
                                                <button class="qty-btn decrease-quantity" data-id="<?php echo $id; ?>">−</button>
                                                <input type="text" class="qty-input" id="quantity-<?php echo $id; ?>" value="<?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                <button class="qty-btn increase-quantity" data-id="<?php echo $id; ?>">+</button>
                                            </div>
                                            
                                            <div class="item-total" id="total-<?php echo $id; ?>"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>₫</div>
                                        </div>
                                    </div>
                                    
                                    <div class="item-actions">
                                        <button class="remove-item" data-id="<?php echo $id; ?>">
                                            <i class="fas fa-times"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-cart">
                            <div class="empty-cart-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h3>Giỏ hàng của bạn đang trống</h3>
                            <p>Có vẻ như bạn chưa thêm bất kỳ sản phẩm nào vào giỏ hàng.</p>
                            <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product" class="btn btn-primary">Tiếp tục mua sắm</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="cart-summary">
                    <div class="summary-header">
                        <h3>Thông tin đơn hàng</h3>
                    </div>
                    
                    <div class="summary-body">
                        <?php if (!empty($cart)): ?>
                            <div class="summary-row">
                                <div class="summary-label">Sản phẩm (<span id="selected-count"><?php echo count($cart); ?></span>)</div>
                                <div class="summary-value" id="subtotal">
                                    <?php 
                                        $subtotal = 0;
                                        foreach ($cart as $item) {
                                            $subtotal += $item['price'] * $item['quantity'];
                                        }
                                        echo number_format($subtotal, 0, ',', '.');
                                    ?>₫
                                </div>
                            </div>
                            
                            <div class="summary-row">
                                <div class="summary-label">Phí vận chuyển</div>
                                <div class="summary-value shipping">Miễn phí</div>
                            </div>
                            
                            <div class="summary-total">
                                <div class="total-label">Tổng cộng</div>
                                <div class="total-value" id="cart-total"><?php echo number_format($subtotal, 0, ',', '.'); ?>₫</div>
                            </div>
                            
                            <div class="summary-actions">
                                <form id="checkout-form" action="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/checkout" method="POST">
                                    <input type="hidden" name="selected_items" id="selected-items-input" value="">
                                    <button type="submit" class="btn-checkout">Tiến hành thanh toán</button>
                                </form>
                                <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product" class="btn-continue-shopping">Tiếp tục mua sắm</a>
                            </div>
                        <?php else: ?>
                            <div class="empty-summary">
                                <p>Không có sản phẩm nào để thanh toán</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="payment-methods">
                    <div class="payment-header">
                        <h4>Chấp nhận thanh toán</h4>
                    </div>
                    <div class="payment-icons">
                        <span class="payment-icon visa"><i class="fab fa-cc-visa"></i></span>
                        <span class="payment-icon mastercard"><i class="fab fa-cc-mastercard"></i></span>
                        <span class="payment-icon amex"><i class="fab fa-cc-amex"></i></span>
                        <span class="payment-icon paypal"><i class="fab fa-cc-paypal"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Cart page styles */
    .cart-page {
        background-color: #f5f5f5;
        padding: 30px 0;
        min-height: 80vh;
    }
    
    /* Make container wider */
    .cart-page .container {
        max-width: 1280px;
    }
    
    /* Cart main content */
    .cart-main-content {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .cart-header {
        padding: 20px 25px;
        border-bottom: 1px solid #eee;
        background-color: #f8f9fa;
    }
    
    .cart-header h2 {
        font-size: 22px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    /* Cart items */
    .cart-items {
        padding: 0;
    }
    
    .cart-item {
        position: relative;
        border-bottom: 1px solid #eee;
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
    
    .cart-item-inner {
        display: flex;
        align-items: center;
        padding: 24px 25px;
    }
    
    .item-select {
        padding-right: 20px;
    }
    
    .item-checkbox {
        width: 22px;
        height: 22px;
        accent-color: #2979ff;
        cursor: pointer;
    }
    
    .item-image {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 25px;
        background-color: #fff;
        border-radius: 8px;
        padding: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    
    .item-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    .item-details {
        flex: 1;
    }
    
    .item-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    
    .item-meta {
        font-size: 14px;
        color: #777;
        margin-bottom: 15px;
    }
    
    .item-price-qty {
        display: flex;
        align-items: center;
    }
    
    .item-price {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        width: 140px;
    }
    
    .quantity-control {
        display: flex;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 140px;
        height: 40px;
        margin-right: 30px;
    }
    
    .qty-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: #f5f5f5;
        font-size: 20px;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .qty-btn:hover {
        background: #e0e0e0;
    }
    
    .qty-input {
        width: 60px;
        border: none;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        text-align: center;
        font-size: 16px;
        font-weight: 500;
        background: #fff;
    }
    
    .item-total {
        font-weight: 700;
        color: #f44336;
        font-size: 18px;
        min-width: 120px;
        text-align: right;
    }
    
    .item-actions {
        margin-left: 20px;
    }
    
    .remove-item {
        background: none;
        border: none;
        color: #777;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: all 0.2s;
        padding: 8px;
    }
    
    .remove-item:hover {
        color: #f44336;
    }
    
    .remove-item i {
        margin-right: 6px;
        font-size: 16px;
    }
    
    /* Empty cart */
    .empty-cart {
        padding: 60px 30px;
        text-align: center;
    }
    
    .empty-cart-icon {
        font-size: 70px;
        color: #ddd;
        margin-bottom: 20px;
    }
    
    .empty-cart h3 {
        font-size: 24px;
        margin-bottom: 15px;
        color: #333;
    }
    
    .empty-cart p {
        color: #777;
        font-size: 16px;
        margin-bottom: 30px;
    }
    
    .empty-cart .btn-primary {
        padding: 12px 30px;
        font-size: 16px;
    }
    
    /* Cart summary */
    .cart-summary {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        overflow: hidden;
        margin-bottom: 25px;
    }
    
    .summary-header {
        padding: 20px 25px;
        border-bottom: 1px solid #eee;
        background-color: #f8f9fa;
    }
    
    .summary-header h3 {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
        color: #333;
    }
    
    .summary-body {
        padding: 25px;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        font-size: 16px;
    }
    
    .summary-label {
        color: #333;
    }
    
    .summary-value {
        font-weight: 500;
    }
    
    .shipping {
        color: #4caf50;
        font-weight: 600;
    }
    
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 25px 0;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .total-label {
        font-weight: 600;
        font-size: 18px;
        color: #333;
    }
    
    .total-value {
        font-weight: 700;
        font-size: 22px;
        color: #f44336;
    }
    
    .summary-actions {
        margin-top: 25px;
    }
    
    .btn-checkout {
        display: block;
        width: 100%;
        padding: 15px;
        background-color: #2979ff;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 17px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        margin-bottom: 15px;
    }
    
    .btn-checkout:hover {
        background-color: #2462cc;
    }
    
    .btn-continue-shopping {
        display: block;
        width: 100%;
        padding: 14px 15px;
        background-color: transparent;
        color: #555;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .btn-continue-shopping:hover {
        background-color: #f5f5f5;
        text-decoration: none;
        color: #333;
    }
    
    .empty-summary {
        text-align: center;
        color: #777;
        font-size: 16px;
        padding: 15px 0;
    }
    
    /* Payment methods */
    .payment-methods {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        padding: 20px 25px;
    }
    
    .payment-header h4 {
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 16px 0;
        color: #333;
    }
    
    .payment-icons {
        display: flex;
        gap: 15px;
    }
    
    .payment-icon {
        font-size: 30px;
        color: #999;
        transition: all 0.2s;
    }
    
    /* Flash animation for price updates */
    .price-updated {
        animation: flash-price 0.5s ease;
    }
    
    @keyframes flash-price {
        0% { color: #f44336; }
        50% { color: #ff9800; }
        100% { color: #f44336; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize selected items
    updateSelectedItems();
    
    // Item checkboxes
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSummary();
        });
    });
    
    // Increase quantity
    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            updateQuantity(id, 1);
        });
    });

    // Decrease quantity
    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            updateQuantity(id, -1);
        });
    });
    
    // Remove item
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                updateQuantity(id, -99999); // Large negative number to ensure removal
            }
        });
    });
    
    // Update selected items before checkout form submission
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            updateSelectedItems();
        });
    }

    // Function to update quantity
    function updateQuantity(id, change) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/updateCart', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Update the displayed quantity
                    document.getElementById('quantity-' + id).value = response.quantity;
                    
                    // Update the item total with animation
                    const totalElement = document.getElementById('total-' + id);
                    totalElement.textContent = response.itemTotal + '₫';
                    totalElement.classList.add('price-updated');
                    setTimeout(() => {
                        totalElement.classList.remove('price-updated');
                    }, 500);
                    
                    // Update summary
                    updateSummary();
                    
                    // If quantity is 0, refresh the page to remove the item
                    if (response.quantity === 0) {
                        window.location.reload();
                    }
                }
            }
        };
        xhr.send('id=' + id + '&change=' + change);
    }
    
    // Function to update summary based on selected items
    function updateSummary() {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        const selectedCount = checkboxes.length;
        
        // Update selected count
        document.getElementById('selected-count').textContent = selectedCount;
        
        // Calculate total for selected items
        let total = 0;
        checkboxes.forEach(checkbox => {
            const id = checkbox.getAttribute('data-id');
            const itemElement = document.querySelector(`.cart-item[data-id="${id}"]`);
            const price = parseFloat(itemElement.getAttribute('data-price'));
            const quantity = parseInt(document.getElementById('quantity-' + id).value);
            total += price * quantity;
        });
        
        // Update subtotal and total
        document.getElementById('subtotal').textContent = formatPrice(total) + '₫';
        document.getElementById('cart-total').textContent = formatPrice(total) + '₫';
        
        // Update selected items for checkout
        updateSelectedItems();
    }
    
    // Function to update the hidden input with selected item IDs
    function updateSelectedItems() {
        const selectedItems = [];
        document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
            selectedItems.push(checkbox.getAttribute('data-id'));
        });
        
        const selectedItemsInput = document.getElementById('selected-items-input');
        if (selectedItemsInput) {
            selectedItemsInput.value = selectedItems.join(',');
        }
    }
    
    // Function to format price
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
