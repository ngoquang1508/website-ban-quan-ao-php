<?php
include __DIR__ . "/../../../config/db.php";

$sql_product = "SELECT id, name, price, stock, type, sexual, url_image FROM products ORDER BY id DESC";
$products = $conn->query($sql_product);
$i = 1;
?>

<div class="main-product__container">
    <div class="main-product__head">
        <h1 class="main-product__head-title">Danh sách sản phẩm</h1>

        <a class="main-product__head-add-btn" href="?page=products&action=add">
            <i class="fa-solid fa-plus"></i> Thêm sản phẩm
        </a>
    </div>

    <!-- Thông báo lỗi -->
    <?php if (isset($_SESSION['error'])): ?>
        <p class="main-product__no_result">
            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </p>
    <?php endif; ?>

    <!-- Kết quả tìm kiếm -->
    <?php if (isset($_SESSION['search_product_result'])): 
        $items = $_SESSION['search_product_result'];
        unset($_SESSION['search_product_result']);
        $is_search = true;
    ?>
        <h2 style="margin: 2rem 0 1rem; color: #333;">
            Kết quả tìm kiếm (<?php echo count($items); ?> sản phẩm)
        </h2>
    <?php else: 
        $is_search = false;
        $items = [];
        if ($products && $products->num_rows > 0) {
            while ($row = $products->fetch_assoc()) {
                $items[] = $row;
            }
        }
    ?>
    <?php endif; ?>

    <!-- Bảng sản phẩm (dùng chung cho cả tìm kiếm và danh sách thường) -->
    <?php if (!empty($items)): ?>
        <div class="main-product__table-wrapper">
            <table class="main-product__container-table">
                <thead>
                    <tr>
                        <th width="60">STT</th>
                        <th width="90">Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Kiểu</th>
                        <th>Giới tính</th>
                        <th width="140">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $index => $row): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <?php if (!empty($row['url_image'])): ?>
                                    <img src="<?php echo BASE_URL . '../' . htmlspecialchars($row['url_image']); ?>" 
                                         alt="Ảnh" 
                                         style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                                <?php else: ?>
                                    <div style="width:70px;height:70px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:12px;color:#aaa;">
                                        No image
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td style="font-weight:600; max-width:280px;">
                                <?php echo htmlspecialchars($row['name']); ?>
                            </td>
                            <td style="white-space:nowrap; color:#e74c3c; font-weight:600;">
                                <?php echo number_format($row['price']); ?> đ
                            </td>
                            <td>
                                <span style="padding:4px 12px; border-radius:20px; font-size:13px; font-weight:600;
                                    <?php echo $row['stock'] > 10 ? 'background:#d4edda;color:#155724;' : 
                                             ($row['stock'] > 0 ? 'background:#fff3cd;color:#856404;' : 'background:#f8d7da;color:#721c24;'); ?>">
                                    <?php echo $row['stock']; ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($row['type'] ?? '—'); ?></td>
                            <td>
                                <?php 
                                $gender = $row['sexual'] ?? 'Unisex';
                                $color = $gender === 'Nam' ? '#007bff' : ($gender === 'Nữ' ? '#e91e63' : '#6c757d');
                                ?>
                                <span style="color:<?php echo $color; ?>; font-weight:600;">
                                    <?php echo $gender; ?>
                                </span>
                            </td>
                            <td class="main-product__btn">
                                <a class="main-product__btn-edit" 
                                   href="?page=products&action=edit&id=<?php echo $row['id']; ?>" 
                                   title="Sửa sản phẩm">
                                    Sửa
                                </a>
                                <a class="main-product__btn-delete" 
                                   href="xuly/delete-product.php?id=<?php echo $row['id']; ?>" 
                                   title="Xóa sản phẩm"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?\nHành động này không thể hoàn tác!')">
                                    Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>
        <p class="main-product__empty">
            <?php echo $is_search ? 'Không tìm thấy sản phẩm nào phù hợp.' : 'Chưa có sản phẩm nào trong cửa hàng.'; ?><br><br>
            <?php if (!$is_search): ?>
                <a href="?page=products&action=add" style="color:var(--primary); font-weight:600; text-decoration:underline;">
                    Thêm sản phẩm đầu tiên ngay!
                </a>
            <?php endif; ?>
        </p>
    <?php endif; ?>
</div>

<script>
    const deleteBtns = document.querySelectorAll('.main-product__btn-delete');
    deleteBtns.forEach(deleteBtn => {
        deleteBtn.addEventListener("click", (e) => {
            if (!confirm("Xác nhận xóa sản phẩm này?")) {
                e.preventDefault();
            }
        });
    })
</script>