<?php
require "config/db.php";
require "includes/product-card.php";
require "includes/sidebar.php";
require "includes/sort-dropdown.php";

$where = "sexual='Nam'";

$sql = "SELECT * FROM products WHERE $where";
$stmt_get_all = $conn->prepare($sql);
$stmt_get_all->execute();
$result = $stmt_get_all->get_result();
?>

<div>
    <div class="product-container">
        <!-- Cột chính -->
        <div class="product-main">
            <?= SortDropdown() ?>
            <div class="products">
                <?php while ($row = $result->fetch_assoc()) {
                    echo ProductCard($row['id'], $row['name'], $row['price'], $row['url_image'], $row['created_at']);
                } ?>
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
        position: absolute;
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