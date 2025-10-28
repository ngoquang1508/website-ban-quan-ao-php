<?php
require "config/db.php";
require "includes/product-card.php";
require "includes/sidebar.php";

$where = "sexual='Nữ'";

$sql = "SELECT * FROM products WHERE $where";
$stmt_get_all = $conn->prepare($sql);
$stmt_get_all->execute();
$result = $stmt_get_all->get_result();
?>

<div>
    <div class="product-container">
        <div class="products">
            <?php while ($row = $result->fetch_assoc()) {
                echo ProductCard($row['id'], $row['name'], $row['price'], $row['url_image']);
            } ?>

        </div>
        <?php echo SidebarFilter() ?>
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

    /* ====== Danh sách sản phẩm ====== */
    .products {
        flex: 0 0 74%;
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
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

    /* Chỉ hiện sidebar khi màn hình đủ rộng */
    @media (min-width: 1024px) {
        .sidebar-filter__wrapper {
            display: block;
        }

        .products {
            flex: 0 0 76%;
        }
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
        transform: scale(1.5);
        accent-color: #ff6347;
        /* Màu chủ đạo */
        cursor: pointer;
    }

    /* ====== Responsive ====== */
    @media (max-width: 1023px) {
        .product-container {
            flex-direction: column;
        }

        .sidebar-filter__wrapper {
            display: none;
        }
    }

    @media (min-width: 450px) {
        .products {
            justify-content: flex-start;
        }
    }
</style>