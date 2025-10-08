<?php
include __DIR__ . "/../../../config/db.php";

$sql_product = "SELECT * FROM products";
$products = $conn->query($sql_product);
$i = 1;
?>

<div class="main-product__container">
    <div class="main-product__head">
        <h1 class="main-product__head-title">Danh sách sản phẩm</h1>

        <a class="main-product__head-add-btn" href="index.php?page=products&action=add">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm</span>
        </a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="main-product__no_result">
            <?php echo $_SESSION['error'];
            unset($_SESSION['error']); ?>
        </p>

    <?php elseif (isset($_SESSION['search_product_result'])): ?>
        <?php if (count($_SESSION['search_product_result']) > 0): ?>
            <h2>Kết quả tìm kiếm</h2>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Mô tả</th>
                        <th>Ngày tạo</th>
                        <th>Ảnh</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($_SESSION['search_product_result'] as $row): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td style="white-space: nowrap"><?php echo number_format($row['price']); ?> đ</td>
                            <td><?php echo $row['stock']; ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td style="white-space: nowrap"><?php echo date("d/m/Y H:i:s", strtotime($row['created_at'])); ?></td>
                            <td>
                                <?php if (!empty($row['url_image'])): ?>
                                    <img src="<?php echo $row['url_image']; ?>" alt="Ảnh sản phẩm" width="100">
                                <?php else: ?>
                                    Chưa có ảnh
                                <?php endif; ?>
                            </td>
                            <td class="main-product__btn">
                                <a class="main-product__btn-edit" href="index.php?page=products&action=edit&id=<?php echo $row['id'] ?>">Sửa</a>
                                <a class="main-product__btn-delete" href="xuly/delete-product.php?id=<?php echo $row['id'] ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="main-product__no_result">Không tìm thấy sản phẩm nào.</p>
        <?php endif; ?>
        <?php unset($_SESSION['search_product_result']); ?>

    <?php else: ?>
        <!-- DANH SÁCH MẶC ĐỊNH -->
        <?php if ($products->num_rows === 0): ?>
            <p class="main-product__empty">Không có sản phẩm nào</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Mô tả</th>
                        <th>Ngày tạo</th>
                        <th>Ảnh</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $products->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td class="main-product__name"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td style="white-space: nowrap"><?php echo number_format($row['price']); ?> đ</td>
                            <td><?php echo $row['stock']; ?></td>
                            <td class="main-product__description"><?php echo htmlspecialchars($row['description']); ?></td>
                            <td style="white-space: nowrap"><?php echo date("d/m/Y H:i:s", strtotime($row['created_at']));
                                                            ?></td>
                            <td>
                                <?php if (!empty($row['url_image'])): ?>
                                    <img src="<?php echo $row['url_image']; ?>" alt="Ảnh sản phẩm" width="50">
                                <?php else: ?>
                                    Chưa có ảnh
                                <?php endif; ?>
                            </td>
                            <td class="main-product__btn">
                                <a class="main-product__btn-edit" href="index.php?page=products&action=edit&id=<?php echo $row['id'] ?>">Sửa</a>
                                <a class="main-product__btn-delete" href="xuly/delete-product.php?id=<?php echo $row['id'] ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>


<?php

if (isset($_GET['action'])) {
    echo "<script src='assets/js/product.js'></script>";
}
