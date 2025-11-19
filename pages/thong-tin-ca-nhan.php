<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/profile.css">

<?php
require_once "config/db.php";


$user_id = $_SESSION['user']['id'];
$role = "user"; // Mặc định role là USER

// Lấy thông tin user
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND role = ?");
$stmt->bind_param("is", $user_id, $role);
$stmt->execute();
$result = $stmt->get_result();

$user = [];

while ($row = $result->fetch_assoc()) {
    $user['username'] = $row['username'];
    $user['email'] = $row['email'];
    $user['avatar'] = $row['avatar'];
    $user['phone'] = $row['phone'];
    $user['address'] = $row['address'];
}

// Lấy thông tin mua hàng của user
$sql = "
    SELECT
        `order_items`.`quantity`,
        `orders`.`total_price`,
        `orders`.`created_at`,
        `products`.`name`,
        `products`.`url_image`,
        `products`.`price`,
        `orders`.`payment_method`
    FROM
        `order_items`
    JOIN `orders` ON `order_items`.`order_id` = `orders`.`id`
    JOIN `products` ON `products`.`id` = `order_items`.`product_id`
    WHERE
        `orders`.`user_id` = ?
";
$stmt_get_order = $conn->prepare($sql);
$stmt_get_order->bind_param("i", $user_id);
$stmt_get_order->execute();
$order = $stmt_get_order->get_result();

$nav_settings = [
    "0" => [
        "title" => "Thông tin tài khoản",
        "icon_class" => "fa-solid fa-user"
    ],
    "1" => [
        "title" => "Đổi mật khẩu",
        "icon_class" => "fa-solid fa-lock"
    ],
    "2" => [
        "title" => "Đơn hàng của tôi",
        "icon_class" => "fa-solid fa-cart-shopping"
    ],
];
?>

<div class="profile__container">
    <div class="profile__wrapper">
        <!-- Thanh điều hướng bên trái -->
        <div class="profile-nav">
            <?php foreach ($nav_settings as $item): ?>
                <div class="item">
                    <i class="<?= $item['icon_class'] ?>"></i>
                    <span class=""><?= $item['title'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Giao diện bên phải-->
        <div class="profile-content">
            <!-- THÔNG TIN CÁ NHÂN -->
            <div class="profile__info item active">
                <h2>Thông tin tài khoản</h2>

                <div class="input-group">
                    <label>Tên khách hàng</label>
                    <div>
                        <input type="text" value="<?= $user['username'] ?>" name="username">
                        <i class="fa-solid fa-pen"></i>
                    </div>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <div>
                        <input type="text" value="<?= $user['email'] ?>" disabled>
                        <i class="fa-solid fa-pen" style="pointer-events: none; opacity: 0.6; cursor: no-drop;"></i>
                    </div>
                </div>
                <div class="input-group">
                    <label>Số điện thoại</label>
                    <div>
                        <input type="text" value="<?= $user['phone'] ?? "Chưa có" ?>" name="phone">
                        <i class="fa-solid fa-pen"></i>
                    </div>
                </div>
                <div class="input-group">
                    <label>Địa chỉ</label>
                    <div>
                        <input type="text" value="<?= $user['address'] ?? "Chưa có" ?>" name="address">
                        <i class="fa-solid fa-pen"></i>
                    </div>
                </div>

                <button class="save-btn" id="submit-info-btn">Lưu</button>
            </div>

            <!-- ĐỔI MẬT KHẨU -->
            <div class="profile__change-pwd item">
                <h2>Thay đổi mật khẩu</h2>
                <div class="input-group">
                    <label>Mật khẩu cũ</label>
                    <input class="input-pass-old" type="password">
                </div>
                <div class="input-group">
                    <label>Mật khẩu mới</label>
                    <input class="input-pass-new" type="password">
                </div>
                <div class="input-group">
                    <label>Nhập lại mật khẩu mới</label>
                    <input class="input-pass-re" type="password">
                </div>

                <button class="save-btn" id="change-pwd-btn">Lưu</button>
            </div>

            <!-- ĐƠN HÀNG -->
            <div class="profile__carts item">
                <h2>Đơn hàng của bạn</h2>
                <?php if ($order->num_rows > 0): ?>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền (VNĐ)</th>
                                    <th>Hình thức thanh toán</th>
                                    <th>Ngày mua</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $order->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <img class="profile-image" src="<?= htmlspecialchars($row['url_image']) ?>" alt="ảnh sản phẩm">
                                                <?= htmlspecialchars($row['name']) ?>
                                            </div>
                                        </td>
                                        <td><?= formatPrice($row['price']) ?><u>đ</u></td>
                                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                                        <td><?= formatPrice($row['price'] * $row['quantity']) ?><u>đ</u></td>
                                        <td><?= htmlspecialchars($row['payment_method']) === "cod" ? "COD" : "Chuyển khoản" ?></td>
                                        <td><?= (new DateTime($row['created_at']))->format("H:i:s d-m-Y") ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="profile_carts-empty">
                        <p>Chưa có sản phẩm nào. <a href="">Mua ngay</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script type="module" src="<?= BASE_URL ?>assets/js/profile.js"></script>