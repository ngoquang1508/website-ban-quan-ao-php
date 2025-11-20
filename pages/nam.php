<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/products.css">
<?php
require_once "includes/fetch-products.php";
require_once "includes/product-card.php";
require_once "includes/sidebar.php";
require_once "includes/sort-dropdown.php";
require_once "includes/pagination.php";
require_once "includes/fetch-favorites.php";
require_once "includes/fetch-products.php";


$where = "sexual='Nam'";
$limit = 12;
$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;

// Đọc category để lấy đúng danh mục
$cat = $_GET['cat'] ?? '';
switch($cat) {
    case "ao-nam": $where .= " AND type='Áo'"; break;
    case "quan-nam": $where .= " AND type='Quần'"; break;
    case "phu-kien-nam": $where .= " AND type='Phụ kiện'"; break;
    default: break;
}

// Đếm sản phẩm
$totalRow = getTotalProduct($where);

// Tính thông tin phân trang
$pagination = getPaginationInfo($totalRow, $limit, $currentPage);

// Lấy danh sách sản phẩm
$result = getProducts($where, $pagination['start'], $limit);

$currentPage = $pagination['currentPage'];
$totalPages = $pagination['totalPages'];


$user_id = $_SESSION['user']['id'] ?? null;
$favorites = getUserFavorites($conn, $user_id);
$carts = getUserCartProductIds($conn, $user_id);
?>

<div>
    <div class="product-container">
        <div class="product-main">
            <?php if ($result->num_rows > 0): ?>
                <?= SortDropdown() ?>
            <?php endif; ?>

            <div class="products">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?= ProductCard($row['id'], $row['name'], $row['price'], $row['url_image'], $row['created_at'], $favorites, $carts) ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-product">Sản phẩm đang được cập nhật.</div>
                <?php endif; ?>
            </div>

            <?php if ($result->num_rows > 0): ?>
                <?= Pagination($currentPage, $totalPages, "nam", $cat); ?>
            <?php endif; ?>
        </div>

        <?= SidebarFilter() ?>
    </div>
</div>

<script src="<?= BASE_URL ?>assets/js/filterProducts.js"></script>
<script src="<?= BASE_URL ?>assets/js/favorite.js" type="module"></script>