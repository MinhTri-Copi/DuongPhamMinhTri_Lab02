<?php include 'app/views/shares/header.php'; ?>
<h1>Thanh toán</h1>

<div class="card mb-4">
    <div class="card-header">
        <h4>Đơn hàng của bạn</h4>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $id => $item): 
                        $itemTotal = $item['price'] * $item['quantity'];
                        $total += $itemTotal;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($itemTotal, 0, ',', '.'); ?> VND</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Tổng cộng:</th>
                        <th><?php echo number_format($total, 0, ',', '.'); ?> VND</th>
                    </tr>
                </tfoot>
            </table>
        <?php else: ?>
            <p>Giỏ hàng trống. <a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product">Tiếp tục mua sắm</a></p>
        <?php endif; ?>
    </div>
</div>

<form method="POST" action="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/processCheckout">
<div class="form-group">
<label for="name">Họ tên:</label>
<input type="text" id="name" name="name" class="form-control" required>
</div>
<div class="form-group">
<label for="phone">Số điện thoại:</label>
<input type="text" id="phone" name="phone" class="form-control" required>
</div>
<div class="form-group">
<label for="address">Địa chỉ:</label>
<textarea id="address" name="address" class="form-control"
required></textarea>
</div>
<button type="submit" class="btn btn-primary">Thanh toán</button>
</form>
<a href="/DuongPhamMinhTri_Lab02/ma_nguon_mo_project_lab2/Product/cart" class="btn btn-secondary mt-2">Quay lại giỏ
hàng</a>
<?php include 'app/views/shares/footer.php'; ?>