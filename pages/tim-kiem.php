<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/products.css">
<?php
require "config/db.php";
require "includes/product-card.php";
require "includes/fetch-products.php";
require "includes/pagination.php";

$keyword = isset($_GET['query']) ? trim($_GET['query']) : '';
$where = "1"; // mặc định tránh lỗi SQL

if ($keyword !== '') {
    // Thêm điều kiện tìm kiếm
    $where = "name LIKE '%" . $keyword . "%'";
}

// --- Phân trang ---
$limit = 12;
$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if ($currentPage < 1) $currentPage = 1;

// --- Đếm tổng sản phẩm ---
$totalRow = getTotalProduct($where);
$total_search = $totalRow; // cùng giá trị

// --- Tính phân trang ---
$pagination = getPaginationInfo($totalRow, $limit, $currentPage);

// --- Lấy sản phẩm ---
$result = getProducts($where, $pagination['start'], $limit);

$currentPage = $pagination['currentPage'];
$totalPages = $pagination['totalPages'];

$user_id = $_SESSION['user']['id'] ?? null;
$favorites = [];

if ($user_id) {
    $favResult = $conn->query("SELECT product_id FROM favorites WHERE user_id = $user_id");
    while ($row = $favResult->fetch_assoc()) {
        $favorites[] = $row['product_id'];
    }
}
?>

<div>
    <h2 class="search-result">
        <?php if ($keyword !== ''): ?>
            Kết quả tìm kiếm cho: "<?= htmlspecialchars($keyword) ?>"
        <?php else: ?>
            Tất cả sản phẩm
        <?php endif; ?>
    </h2>

    <p class="search-total">
        Có <strong><?= $total_search ?></strong> kết quả phù hợp.
    </p>

    <div class="search-products">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?= ProductCard($row['id'], $row['name'], $row['price'], $row['stock'], $row['url_image'], $row['created_at'], $favorites) ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <?php Pagination($currentPage, $totalPages, "tim-kiem&query=" . urlencode($keyword)); ?>
</div>

<script type="module" src="<?= BASE_URL ?>assets/js/favorite.js"></script>

<style>
    .search-products {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 3rem;
    }

    .search-result {
        font-size: 2.4rem;
        margin-bottom: 2rem;
    }

    .search-total {
        font-size: 1.6rem;
        margin-bottom: 2rem;
    }

    .search-total strong {
        color: #ff6347;
    }

    @media (max-width: 1200px) {
        .search-products {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 900px) {
        .search-products {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .search-products {
            justify-items: center;
            grid-template-columns: 1fr;
        }
    }
</style>