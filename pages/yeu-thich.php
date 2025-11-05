<link rel="stylesheet" href="/assets/css/products.css">
<?php
require_once "config/db.php";
require_once "includes/fetch-favorites.php";
require_once "includes/product-card.php";
require_once "includes/fetch-products.php";

$sql = "SELECT * FROM `favorites` f JOIN `products` p ON f.product_id = p.id;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$user_id = $_SESSION['user']['id'] ?? null;
$favorites = getUserFavorites($conn, $user_id);
$carts = getUserCartProductIds($conn, $user_id);
?>

<div class="yeu-thich-container">
    <?php if (!$user_id): ?>

        <p>Đăng nhập để thêm vào danh sách yêu thích.
            <a href="?page=dang-nhap&redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>">Đăng nhập ngay</a>
        </p>

    <?php elseif ($result->num_rows == 0): ?>
        <p>Chưa có sản phẩm yêu thích nào, Hãy thêm vào nhé!</p>
    <?php else: ?>
        <div class="products">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?= ProductCard($row['id'], $row['name'], $row['price'], $row['url_image'], $row['created_at'], $favorites, $carts) ?>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-product">Không có sản phẩm nào.</div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .yeu-thich-container {
        font-size: 1.6rem;
    }

    .yeu-thich-container p a {
        color: #1a73e8;
        font-weight: 600;
    }

    .yeu-thich-container p a:hover {
        color: #ff6347;
        text-decoration: underline;
    }

    .yeu-thich-container p {
        width: 100%;
        padding: 1rem;
        background: #fff3cd;
    }
</style>

<script type="module" src="/assets/js/favorite.js"></script>