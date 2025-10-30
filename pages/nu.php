<?php
require "config/db.php";
require "includes/product-card.php";
require "includes/sidebar.php";
require "includes/sort-dropdown.php";

// --- Bộ lọc sản phẩm ---
$where = "sexual='Nữ'";

// --- Cấu hình phân trang ---
$limit = 6; // số sản phẩm mỗi trang
$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if ($currentPage < 1) $currentPage = 1;

// --- Đếm tổng số sản phẩm ---
$sql_count = "SELECT COUNT(*) AS total FROM products WHERE $where";
$result_count = $conn->query($sql_count);
$totalRow = $result_count->fetch_assoc()['total'];

// --- Tính toán vị trí bắt đầu và tổng số trang ---
$totalPages = ceil($totalRow / $limit);
if ($totalPages == 0) $currentPage = 1; // Tránh chia 0 nếu không có sản phẩm
if ($currentPage > $totalPages) $currentPage = $totalPages; // Nếu người dùng nhập trang > tổng số trang thì đưa về trang cuối

$start = ($currentPage - 1) * $limit;

// --- Lấy danh sách sản phẩm ---
$sql = "SELECT * FROM products WHERE $where LIMIT $start, $limit";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>


<div>
    <div class="product-container">
        <div class="product-main">
            <?= SortDropdown() ?>
            <div class="products">
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <?= ProductCard($row['id'], $row['name'], $row['price'], $row['url_image'], $row['created_at']) ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="empty-product">Không có sản phẩm nào.</div>
                <?php endif; ?>
            </div>

            <!-- ====== PHÂN TRANG ====== -->
            <div class="pagination">
                <?php
                if ($totalPages > 0):
                    $prevPage = max(1, $currentPage - 1);
                    $nextPage = min($totalPages, $currentPage + 1);

                    // << Nút trước
                    echo '<a href="?page=nu&p=' . $prevPage . '" class="page-link ' . ($currentPage == 1 ? 'disabled' : '') . '">&laquo;</a>';

                    // Nếu tổng trang nhỏ hơn 7 => hiển thị hết
                    if ($totalPages <= 7) {
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo '<a href="?page=nu&p=' . $i . '" class="page-link ' . ($i == $currentPage ? 'active' : '') . '">' . $i . '</a>';
                        }
                    } else {
                        // Nếu đang ở gần đầu (1–4)
                        if ($currentPage <= 4) {
                            for ($i = 1; $i <= 5; $i++) {
                                echo '<a href="?page=nu&p=' . $i . '" class="page-link ' . ($i == $currentPage ? 'active' : '') . '">' . $i . '</a>';
                            }
                            echo '<span class="page-dots">...</span>';
                            echo '<a href="?page=nu&p=' . $totalPages . '" class="page-link">' . $totalPages . '</a>';
                        }
                        // Nếu đang ở giữa
                        elseif ($currentPage > 4 && $currentPage < $totalPages - 3) {
                            echo '<a href="?page=nu&p=1" class="page-link">1</a>';
                            echo '<span class="page-dots">...</span>';
                            for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++) {
                                echo '<a href="?page=nu&p=' . $i . '" class="page-link ' . ($i == $currentPage ? 'active' : '') . '">' . $i . '</a>';
                            }
                            echo '<span class="page-dots">...</span>';
                            echo '<a href="?page=nu&p=' . $totalPages . '" class="page-link">' . $totalPages . '</a>';
                        }
                        // Nếu đang ở cuối
                        else {
                            echo '<a href="?page=nu&p=1" class="page-link">1</a>';
                            echo '<span class="page-dots">...</span>';
                            for ($i = $totalPages - 4; $i <= $totalPages; $i++) {
                                echo '<a href="?page=nu&p=' . $i . '" class="page-link ' . ($i == $currentPage ? 'active' : '') . '">' . $i . '</a>';
                            }
                        }
                    }

                    // >> Nút sau
                    echo '<a href="?page=nu&p=' . $nextPage . '" class="page-link ' . ($currentPage == $totalPages ? 'disabled' : '') . '">&raquo;</a>';
                endif;
                ?>
            </div>
        </div>

        <?= SidebarFilter() ?>
    </div>
</div>


<style>
    /* ====== Layout chính ====== */
    .product-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2.5rem;
    }

    /* ====== Cột sản phẩm chính ====== */
    .product-main {
        flex: 0 0 75%;
        display: flex;
        flex-direction: column;
    }

    /* Sort dropdown hiển thị trên danh sách */
    .sort-dropdown {
        align-self: flex-end;
        margin-bottom: 1.5rem;
    }

    /* ====== Danh sách sản phẩm ====== */
    .products {
        position: relative;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(30rem, 1fr));
        gap: 2rem;
        width: 100%;
        justify-items: start;
    }

    /* Giúp mỗi thẻ product-card chiếm toàn cột của nó */
    .product-card {
        width: 100%;
        box-sizing: border-box;
    }

    /* ====== Sidebar lọc ====== */
    .sidebar-filter__wrapper {
        flex: 1;
        position: sticky;
        top: 10px;
        align-self: flex-start;
        flex-shrink: 0;
        min-width: 16rem;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        display: none;
    }

    /* ====== Tiêu đề Sidebar ====== */
    .sidebar-filter__wrapper h2 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ====== Danh sách checkbox ====== */
    .sidebar-filter__list {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 1.5rem;
        color: #222;
    }

    .sidebar-filter__item {
        margin-bottom: 1rem;
        white-space: nowrap;
        user-select: none;
    }

    .sidebar-filter__item label {
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .sidebar-filter__item label:hover {
        color: #ff6347;
    }

    /* ====== Checkbox ====== */
    .sidebar-filter__item input[type="checkbox"] {
        transform: scale(1.2);
        accent-color: #ff6347;
        cursor: pointer;
    }

    /* ====== Sort drop down ====== */
    .sort-dropdown__wrapper {
        margin-bottom: 2rem;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: .8rem;
    }

    .sort-dropdown__wrapper label {
        font-size: 1.6rem;
    }

    .sort-dropdown__wrapper select {
        appearance: none;
        /* ẩn icon mặc định (Chrome, Edge, Safari) */
        -webkit-appearance: none;
        -moz-appearance: none;

        padding: .8rem 3rem .8rem 1.2rem;
        font-size: 1.6rem;
        border: 1px solid #ccc;
        border-radius: .6rem;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='gray' viewBox='0 0 24 24'%3E%3Cpath d='M7 10l5 5 5-5H7z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 1.6rem;
        outline: none;
        cursor: pointer;
        transition: 0.2s;
    }

    .sort-dropdown__wrapper select:hover {
        border-color: #ff6347;
    }

    /* ====== Sản phẩm trống ====== */
    .empty-product {
        position: relative;
        grid-column: 1 / -1;
        top: 0;
        left: 0;
        width: 100%;
        padding: 1.5rem;
        font-size: 1.8rem;
        color: #664d03;
        background-color: #fff3cd;
        border-color: #ffecb5;
        border-radius: .6rem;
    }

    /* ====== PHÂN TRANG ====== */
    .pagination {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin: 2rem 0 1rem;
        user-select: none;
    }

    .page-link {
        display: flex;
        width: 3.5rem;
        height: 3.5rem;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1px solid #e9e9e9;
        border-radius: .6rem;
        color: #333;
        font-weight: 600;
        font-size: 1.6rem;
        transition: all 0.2s;
    }

    .page-link:hover {
        color: #ff6347;
        border-color: #ff6347;
    }

    .page-link.active {
        border: none;
        background-color: #ff6347;
        color: #fff;
        font-weight: 600;
    }

    .page-link.disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .page-dots {
        display: inline-block;
        padding: 8px 10px;
        color: #888;
    }

    /* ====== Desktop: hiện sidebar ====== */
    @media (min-width: 1024px) {
        .sidebar-filter__wrapper {
            display: block;
        }
    }

    /* ====== Responsive ====== */
    @media (max-width: 1023px) {
        .product-container {
            flex-direction: column;
        }

        .sidebar-filter__wrapper {
            display: none;
        }

        .product-main {
            width: 100%;
        }

        /* Grid trên mobile: 1–2 cột tuỳ chiều rộng */
        .products {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
    }
</style>

<script src="/assets/js/filterProducts.js"></script>