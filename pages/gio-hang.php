<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/cart.css">

<?php
require_once "config/db.php";
require_once "includes/functions.php";

$user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
$stmt = $conn->prepare("SELECT * FROM cards c JOIN products p ON c.product_id = p.id WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_price = 0;
?>

<div class="cart">
    <h1 class="cart__title">Giỏ hàng của bạn</h1>

    <div class="cart__list">
        <?php if (!isset($_SESSION['user'])): ?>
            <p class="info">Đăng nhập để thêm sản phẩm vào giỏ hàng của bạn.</p>
        <?php elseif ($result->num_rows == 0): ?>
            <p class="info">Không có sản phẩm nào trong giỏ hàng của bạn.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>

                <!-- Tính tổng số tiền các mặt hàng -->
                <?php $total_price += $row['price'] * $row['quantity']; ?>

                <div class="cart-item" data-id="<?= $row['product_id'] ?>">
                    <div class="cart-item__body">
                        <div class="cart-item__image">
                            <img src="<?= $row['url_image'] ?>" alt="<?= $row['name'] ?>">
                        </div>

                        <div class="cart-item__details">
                            <h2 class="cart-item__title"><?= $row['name'] ?></h2>
                            <p class="cart-item__desc"><?= $row['description'] ?></p>

                            <div class="cart-item__controls">
                                <div class="cart-qty">
                                    <button type="button" class="cart-qty__btn cart-qty__btn--decrease">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>

                                    <input
                                        class="quantity"
                                        type="text"
                                        name="quantity"
                                        value="<?= $row['quantity']; ?>"
                                        min="1"
                                        max="<?= $row['stock'] ?>"
                                        onchange="if(this.value == 0) this.value = 1"
                                        onkeypress="if (isNaN(this.value + String.fromCharCode(event.keyCode))) return false"
                                        data-stock="<?= $row['stock'] ?>">

                                    <button type="button" class="cart-qty__btn cart-qty__btn--increase">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>

                                <p class="cart-item__price"><?= formatPrice($row['price'] * $row['quantity']) ?><u>đ</u></p>
                            </div>

                            <button type="button" class="cart-item__remove">×</button>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

            <!-- Tổng tiền toàn giỏ hàng -->
            <div class="cart__summary">
                <span class="cart__summary-label">Tổng cộng:</span>
                <span class="cart__summary-total"><?= formatPrice($total_price) ?><u>đ</u></span>
            </div>

            <!-- Nút thanh toán -->
            <div class="cart__checkout">
                <button class="cart__checkout-btn" type="button">Thanh toán ngay</button>
            </div>

        <?php endif; ?>
    </div>

</div>

<script type="module" src="<?= BASE_URL ?>assets/js/gio-hang.js"></script>