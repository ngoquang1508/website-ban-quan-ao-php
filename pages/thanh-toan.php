<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/thanh-toan.css">

<?php
require_once "config/db.php";
require_once "includes/functions.php";

$user_id = $_SESSION['user']['id'] ?? null;
$product_id = $_POST['id'] ?? $_GET['id'] ?? null;
$type = $_GET['type'] ?? $_POST['type'] ?? null;

$result = null;
$total = 0;
$quantity = 1;

if ($type === "cart") {
    // Lấy sản phẩm từ giỏ hàng
    $sql = "
        SELECT user_id, product_id, name, price, quantity, url_image
        FROM carts c
        JOIN products p ON c.product_id = p.id
        WHERE user_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $sql_total = "SELECT COUNT(product_id) AS total FROM carts WHERE user_id = ?";
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->bind_param("i", $user_id);
    $stmt_total->execute();
    $total = $stmt_total->get_result()->fetch_assoc()['total'];
} elseif ($type === "single") {
    // Mua ngay 1 sản phẩm

    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    $sql = "SELECT id AS product_id, name, price, url_image FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 1;
}

// quay lại trang cũ
$go_back = BASE_URL;
if ($type === "cart") {
    $go_back = "?page=gio-hang";
} else {
    $go_back = "?page=chi-tiet-san-pham&id=$product_id";
}
?>

<div class="checkout__container">
    <div class="checkout__info">
        <div class="logo">
            <a href="<?= BASE_URL ?>">ND Style</a>
        </div>

        <div class="row">
            <div class="col">
                <!-- THÔNG TIN NHẬN HÀNG -->
                <div class="title">
                    <i class="fa-regular fa-id-card"></i>
                    <h2>Thông tin nhận hàng</h2>
                </div>

                <div class="input-group">
                    <input type="text" name="name" placeholder="">
                    <span>Họ và tên</span>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="">
                    <span>Email</span>
                </div>
                <div class="input-group">
                    <input type="text" name="phone" placeholder="">
                    <span>Số điện thoại</span>
                </div>
                <div class="input-group">
                    <input type="text" name="address" placeholder="">
                    <span>Địa chỉ</span>
                </div>
                <div class="input-group">
                    <textarea name="note" maxlength="500" placeholder="" oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"></textarea>
                    <span>Ghi chú (tùy chọn)</span>
                </div>
            </div>

            <div class="col">
                <!-- VẬN CHUYỂN -->
                <div class="title">
                    <i class="fa-solid fa-truck"></i>
                    <h2>Vận chuyển</h2>
                </div>
                <div class="transport">
                    <label class="checkout__option">
                        <input type="radio" checked />
                        <div class="name">
                            <span>Giao hàng tận nơi</span>
                            <span>40.000<u>đ</u></span>
                        </div>
                    </label>
                </div>

                <!-- PHƯƠNG THỨC THANH TOÁN -->
                <div class="title">
                    <i class="fa-regular fa-credit-card"></i>
                    <h2>Thanh toán</h2>
                </div>
                <div class="checkout__method">
                    <label class="checkout__option">
                        <input type="radio" name="payment_method" value="transfer" />
                        <div class="name">
                            <span>Chuyển khoản</span>
                            <span><i class="fa-regular fa-money-bill-1"></i></span>
                        </div>
                    </label>

                    <label class="checkout__option">
                        <input type="radio" name="payment_method" value="cod" />
                        <div class="name">
                            <span>Thu hộ (COD)</span>
                            <span><i class="fa-regular fa-money-bill-1"></i></span>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- ĐƠN HÀNG -->
    <div class="checkout__orders">
        <div class="col">
            <h2>Đơn hàng (<?= $total ?> sản phẩm)</h2>

            <!-- DANH SÁCH SẢN PHẨM -->
            <div class="list">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()):
                        $qty = $row['quantity'] ?? $quantity;
                        $subtotal = $row['price'] * $qty;
                    ?>
                        <div class="item"
                            data-product-id="<?= $row['product_id'] ?>"
                            data-qty="<?= $qty ?>"
                            data-price="<?= $row['price'] ?>">
                            <div class="image">
                                <img src="<?= BASE_URL . $row['url_image'] ?>" alt="">
                                <span class="qty"><?= $qty ?></span>
                            </div>
                            <div class="decs">
                                <span class="name"><?= htmlspecialchars($row['name']) ?></span>
                            </div>
                            <div class="qty-price">
                                <span><?= formatPrice($subtotal) ?><u>đ</u></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="font-size: 1.6rem; font-weight: 600;">Không có sản phẩm nào</p>
                <?php endif; ?>
            </div>

            <!-- MÃ GIẢM GIÁ -->
            <div class="discount">
                <input type="text" placeholder="Nhập mã giảm giá">
                <button>Áp dụng</button>
            </div>

            <!-- SUMMARY -->
            <div class="checkout__summary">
                <div class="item">
                    <span class="label">Tạm tính</span>
                    <span class="value tam-tinh"></span>
                </div>
                <div class="item">
                    <span class="label">Phí vận chuyển</span>
                    <span class="value">40.000<u>đ</u></span>
                </div>
            </div>

            <!-- TỔNG TIỀN -->
            <div class="checkout__total">
                <div class="item">
                    <span class="label">Tổng cộng</span>
                    <span class="value total"></span>
                </div>
                <div class="item">
                    <a href="<?= $go_back ?>" class="go-back">
                        <i class="fa-solid fa-angle-left"></i> Quay lại
                    </a>
                    <button class="submit" data-type="<?= $type ?>">Đặt hàng</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module" src="<?= BASE_URL ?>assets/js/thanh-toan.js"></script>