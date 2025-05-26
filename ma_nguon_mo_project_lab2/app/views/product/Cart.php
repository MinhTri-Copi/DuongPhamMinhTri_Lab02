<?php include 'app/views/shares/header.php'; ?>
<h1>Giỏ hàng</h1>
<?php if (!empty($cart)): ?>
<ul class="list-group">
<?php foreach ($cart as $id => $item): ?>
<li class="list-group-item">
<h2><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
?></h2>
<?php if ($item['image']): ?>
<img src="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/<?php echo $item['image']; ?>" alt="Product
Image" style="max-width: 100px;">
<?php endif; ?>
<p>Giá: <?php echo htmlspecialchars(number_format($item['price'], 0, ',', '.'), ENT_QUOTES, 'UTF-8'); ?> VND</p>
<div class="quantity-controls">
    <p>Số lượng: 
        <button class="btn btn-sm btn-secondary decrease-quantity" data-id="<?php echo $id; ?>">-</button>
        <span class="quantity" id="quantity-<?php echo $id; ?>"><?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></span>
        <button class="btn btn-sm btn-secondary increase-quantity" data-id="<?php echo $id; ?>">+</button>
    </p>
    <p>Thành tiền: <span class="item-total" id="total-<?php echo $id; ?>"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></span> VND</p>
</div>
</li>
<?php endforeach; ?>
</ul>
<div class="mt-3">
    <h3>Tổng giá tiền: <span id="cart-total"><?php 
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        echo number_format($total, 0, ',', '.');
    ?></span> VND</h3>
</div>
<?php else: ?>
<p>Giỏ hàng của bạn đang trống.</p>
<?php endif; ?>
<a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product" class="btn btn-secondary mt-2">Tiếp tục mua sắm</a>
<a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/checkout" class="btn btn-secondary mt-2">Thanh Toán</a>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
                    document.getElementById('quantity-' + id).textContent = response.quantity;
                    // Update the item total
                    document.getElementById('total-' + id).textContent = response.itemTotal;
                    // Update cart total
                    document.getElementById('cart-total').textContent = response.cartTotal;
                    
                    // If quantity is 0, consider refreshing the page to remove the item
                    if (response.quantity === 0) {
                        window.location.reload();
                    }
                }
            }
        };
        xhr.send('id=' + id + '&change=' + change);
    }
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
