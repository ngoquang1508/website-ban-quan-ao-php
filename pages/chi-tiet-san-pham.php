<link rel="stylesheet" href="/assets/css/product-detail.css">
<?php
require_once "config/db.php";
require_once "includes/functions.php";
$product_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();


// Đếm số người đặt trong giỏ hàng
$stmt_count_user_card = $conn->prepare("SELECT COUNT(DISTINCT user_id) AS total_user FROM cards WHERE product_id = ?");
$stmt_count_user_card->bind_param("i", $product_id);
$stmt_count_user_card->execute();
$total_user = $stmt_count_user_card->get_result()->fetch_assoc()['total_user'];

// Đếm số người yêu thích
$stmt_count_user_favorite = $conn->prepare("SELECT COUNT(DISTINCT user_id) AS total_user_favorite FROM favorites WHERE product_id = ?");
$stmt_count_user_favorite->bind_param("i", $product_id);
$stmt_count_user_favorite->execute();
$total_user_favorite = $stmt_count_user_favorite->get_result()->fetch_assoc()['total_user_favorite'];

$stmt_count_user_card->close();
$stmt_count_user_favorite->close();
$stmt->close();
?>

<div class="product-detail__container">
    <div class="product-detail__img">
        <img src="<?= $product['url_image'] ?>" alt="<?= $product['name'] ?>">
    </div>

    <div class="product-detail__content">
        <h2 class="product-detail__title"><?= $product['name'] ?></h2>
        <div class="product-detail__price"><?= formatPrice($product['price']) ?><u>đ</u></div>
        <div class="product-detail__desc"><?= $product['description'] ?></div>
        <div class="product-detail__info">
            <p><b>Tình trạng:</b> <strong><?= $product['stock'] > 0 ? "Còn {$product['stock']} sản phẩm" : "Hết hàng" ?></strong></p>
        </div>
        <form action="" method="post">
            <div class="group-input">
                <label>Số lượng:</label>
                <div class="quantity-selector">
                    <button type="button" class="decrement-btn"><i class="fa-solid fa-minus"></i></button>
                    <input
                        class="quantity"
                        type="text"
                        name="quantity"
                        size="4"
                        maxlength="3"
                        value="1"
                        min="1"
                        max="<?= $product['stock'] ?>"
                        onchange="if(this.value == 0) this.value = 1"
                        onkeypress="if (isNaN(this.value + String.fromCharCode(event.keyCode))) return false"
                        data-stock="<?= $product['stock'] ?>">
                    <button type="button" class="increment-btn"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <button class="add-to-card" type="submit" name="add-to-cart" data-id="<?= $product['id'] ?>">Thêm vào giỏ hàng</button>
            <button class="buy-now" type="submit" name="buy-now">Mua ngay</button>
        </form>

        <div class="product-detail__notice">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="22" viewBox="0 0 18 22" fill="none">
                    <path d="M11.8308 1H5.10256L1 11.3385H6.64103L5.61538 21L16.3846 6.57949H9.86154L11.8308 1Z" stroke="var(--primary-color)" stroke-width="1.4" stroke-linejoin="round"></path>
                </svg>
            </div>
            <p>Sản phẩm hiện có có <strong><?= $total_user ?></strong> người thêm vào giỏ hàng, <strong><?= $total_user_favorite ?></strong> người yêu thích.</p>
        </div>

        <div class="product-detail__policy">
            <div class="item">
                <div class="icon">
                    <img src="/assets/images/icon_policy_1.webp" alt="policy-icon">
                </div>
                <div class="info">
                    Giao hàng toán quốc: <p>Thanh toán (COD) khi nhận hàng</p>
                </div>
            </div>
            <div class="item">
                <div class="icon">
                    <img src="/assets/images/icon_policy_2.webp" alt="policy-icon">
                </div>
                <div class="info">
                    Miễn phí giao hàng: <p>Theo chính sách</p>
                </div>
            </div>
            <div class="item">
                <div class="icon">
                    <img src="/assets/images/icon_policy_3.webp" alt="policy-icon">
                </div>
                <div class="info">
                    Đổi trả trong 7 ngày: <p>Kể từ ngày mua hàng</p>
                </div>
            </div>
            <div class="item">
                <div class="icon">
                    <img src="/assets/images/icon_policy_4.webp" alt="policy-icon">
                </div>
                <div class="info">
                    Hỗ trợ 24/7: <p>Theo chính sách</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module" src="/assets/js/card.js"></script>