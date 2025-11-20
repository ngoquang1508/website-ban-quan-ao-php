<?php

include __DIR__ . "/../../../config/db.php";

$id_product = $_GET["id"] ?? null;

if (!$id_product || !is_numeric($id_product)) {
    header("Location: .. ?page=products");
    exit;
}

$sql_check_id = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql_check_id);
$stmt->bind_param("i", $id_product);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Nếu không có id user nào khớp -> chặn
if (!$product) {
    header("Location: /?page=products");
    exit;
}
$stmt->close();

?>

<div class="edit-product__wrapper">
    <a class="edit-product__go-back" href="?page=products">Quay lại</a>

    <div class="edit-product__container">
        <h2>Sửa sản phẩm có id = <?php echo $product['id'] ?></h2>

        <form action="xuly/edit-product.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id'] ?>">


            <div class="edit-product__image">
                <img id="preview-image" src="<?php echo BASE_URL . "../" . $product['url_image'] ?>" alt="<?php echo $product['name'] ?>" width="150">
                <input type="hidden" name="photo_old" value="<?php echo $product['url_image'] ?>">
                <div class="file-upload">
                    <label for="product-image" class="file-upload__label">
                        Tải ảnh lên <i class="fa-solid fa-upload"></i>
                    </label>
                    <input id="product-image" type="file" name="photo_update" class="file-upload__input photoInput url_image">
                </div>
            </div>

            <div class="edit-product__inputs">
                <label>Tên sản phẩm</label>
                <input type="text" name="name" value="<?php echo $product['name'] ?>">
                
                <label>Giá tiền (vnđ)</label>
                <input type="number" name="price" value="<?php echo $product['price'] ?>">

                <label>Số lượng tồn</label>
                <input type="number" name="stock" value="<?php echo $product['stock'] ?>">

                <label>Loại sản phẩm</label>
                <select name="type" id="">
                    <option value="Áo" <?php echo $product['type'] === 'Áo' ? 'selected' : '' ?>>Áo</option>
                    <option value="Quần" <?php echo $product['type'] === 'Quần' ? 'selected' : '' ?>>Quần</option>
                    <option value="Phụ kiện" <?php echo $product['type'] === 'Phụ kiện' ? 'selected' : '' ?>>Phụ kiện</option>
                </select>
                <input type="submit" value="Lưu" name="save">
            </div>

        </form>

    </div>
</div>


<script>
    document.querySelector('.url_image').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('preview-image').src = URL.createObjectURL(file);
        }
    });
</script>