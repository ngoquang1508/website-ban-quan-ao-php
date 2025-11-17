<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/cam-on.css">

<?php
require_once "config/db.php";

// Nếu chưa có session order_success → quay về trang chủ
if (!isset($_SESSION['order_success'])) {
    header("Location: ?page=trang-chu");
    exit;
}

$orders = $_SESSION['order_success'];

// --- Lấy danh sách product_id từ session ---
$product_ids = array_column($orders['items'], 'product_id');

if (!empty($product_ids)) {
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));

    $stmt = $conn->prepare("SELECT id, name, url_image FROM products WHERE id IN ($placeholders)");

    // Bind params động
    $types = str_repeat('i', count($product_ids));
    $stmt->bind_param($types, ...$product_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    $names_map = [];
    $image_map = [];
    while ($row = $result->fetch_assoc()) {
        $names_map[$row['id']] = $row['name'];
        $image_map[$row['id']] = $row['url_image'];
    }

    // Thêm tên vào từng item
    foreach ($orders['items'] as $key => $item) {
        $orders['items'][$key]['name'] = $names_map[$item['product_id']] ?? '';
        $orders['items'][$key]['url_image'] = $image_map[$item['product_id']] ?? '';
    }
}
?>

<div class="thankyou__container">

    <div class="thankyou__logo">
        <a href="<?= BASE_URL ?>">
            <h1>ND Style</h1>
        </a>
    </div>

    <div class="thankyou__header">
        <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
            <g fill="none" stroke="#8EC343" stroke-width="2">
                <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
            </g>
        </svg>
        <div>
            <h2>Cảm ơn bạn đã đặt hàng</h2>
            <p>Một email xác nhận đã được gửi tới <u><?= htmlspecialchars($orders['email']) ?></u></p>
            <p>Xin vui lòng kiểm tra email của bạn</p>
        </div>
    </div>

    <div class="thankyou__info">
        <div class="thankyou__info-column">
            <h3>Thông tin mua hàng</h3>
            <p>Tên: <?= htmlspecialchars($orders['name']) ?></p>
            <p>Email: <?= htmlspecialchars($orders['email']) ?></p>
            <p>SĐT: <?= htmlspecialchars("+84" . strtr($orders['phone'], 0, 1)) ?></p>
        </div>

        <div class="thankyou__info-column">
            <h3>Địa chỉ nhận hàng</h3>
            <p>Tên: <?= htmlspecialchars($orders['name']) ?></p>
            <p>Địa chỉ: <?= htmlspecialchars($orders['address']) ?></p>
            <p>SĐT: <?= htmlspecialchars("+84" . strtr($orders['phone'], 0, 1)) ?></p>
        </div>

        <div class="thankyou__info-column">
            <h3>Phương thức thanh toán</h3>
            <p><?= $orders['payment_method'] === "cod" ? "COD" : "Chuyển khoản" ?></p>
        </div>
        <div class="thankyou__info-column">
            <h3>Phương thức vận chuyển</h3>
            <p>Giao hàng tận nơi</p>
        </div>
    </div>

    <div class="thankyou__order">
        <div class="title-wrapper">
            <h2>Đơn hàng #<?= $orders['order_id'] ?> (<?= count($orders['items']) ?> sản phẩm)</h2>
            <div class="more">
                <span>Xem chi tiết</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </div>
        <div class="thankyou__products">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders['items'] as $item): ?>
                            <tr>
                                <td>
                                    <div>
                                        <?php if (!empty($item['url_image'])): ?>
                                            <img src="<?= htmlspecialchars($item['url_image']) ?>" class="product-image" alt="">
                                        <?php endif; ?>
                                        <?= htmlspecialchars($item['name']) ?>
                                    </div>
                                </td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= formatPrice($item['price']) ?><u>đ</u></td>
                                <td><?= formatPrice($item['price'] * $item['quantity']) ?><u>đ</u></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="thankyou__summary">
            <div><span>Tạm tính</span><span><?= formatPrice($orders['total_price'] - 40000) ?><u>đ</u></span></div>
            <div><span>Phí vận chuyển</span><span>40.000<u>đ</u></span></div>
            <div><span>Tổng cộng</span><span class="highlight"><?= formatPrice($orders['total_price']) ?><u>đ</u></span></div>
        </div>
    </div>

    <div class="thankyou__actions">
        <a href="<?= BASE_URL ?>">Tiếp tục mua hàng</a>
        <button onclick="window.print()">
            <i class="fa-solid fa-print"></i>
            <span>In</span>
        </button>
    </div>
</div>

<?php
// Xóa session sau khi hiển thị để tránh reload lại hiển thị dữ liệu cũ
unset($_SESSION['order_success']);
?>

<script>
    const more = document.querySelector(".title-wrapper .more");
    const icon = document.querySelector(".more i");
    const table = document.querySelector(".table-wrapper");

    more.addEventListener("click", () => {
        icon.classList.toggle("rotate");
        table.classList.toggle("hidden");
    });
</script>