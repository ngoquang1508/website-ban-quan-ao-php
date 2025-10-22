<div class="add-product__wrapper">
    <a class="add-product__go-back" href="?page=products">Quay lại</a>

    <div class="add-product__container">
        <h2>Thêm sản phẩm</h2>

        <form action="xuly/add-product.php" method="post" enctype="multipart/form-data" >
            <label for="">Tên sản phẩm</label>
            <input class="nameInput" type="text" name="name">

            <label for="">Mô tả</label>
            <input class="desInput" type="text" name="description">

            <div class="add-product__form-row">
                <label for="">Giá</label>
                <input class="priceInput" type="number" name="price" min="0">
    
                <label for="">Số lượng</label>
                <input class="stockInput" type="number" name="stock" min="0">

                <label for="">Kiểu</label>
                <select name="type" id="">
                    <option value="Áo">Áo</option>
                    <option value="Quần">Quần</option>
                    <option value="Phụ kiện">Phụ kiện</option>
                </select>
            </div>

            <div class="file-upload">
                <label for="product-image" class="file-upload__label">
                    Chọn ảnh <i class="fa-solid fa-upload"></i>
                </label>
                <input id="product-image" type="file" name="photo" class="file-upload__input photoInput">
                <span class="file-upload__name">Chưa có file</span>
            </div>
            <input class="submitBtn" type="submit" value="Thêm" name="add">
        </form>
    </div>
</div>

<script src="assets/js/product.js"></script>