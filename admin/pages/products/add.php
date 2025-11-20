<div class="add-product__wrapper">
    <a class="add-product__go-back" href="?page=products">Quay lại</a>

    <div class="add-product__container">
        <h2>Thêm sản phẩm mới</h2>

        <form action="xuly/add-product.php" method="post" enctype="multipart/form-data">
            <!-- Tên sản phẩm -->
            <div>
                <label for="name">Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       class="nameInput" 
                       placeholder="Nhập tên sản phẩm..." 
                       required>
            </div>

            <!-- Dòng 4 ô ngang -->
            <div class="add-product__form-row">
                <div>
                    <label for="price">Giá (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           class="priceInput" 
                           min="0" 
                           placeholder="0" 
                           required>
                </div>

                <div>
                    <label for="stock">Số lượng <span class="text-danger">*</span></label>
                    <input type="number" 
                           id="stock" 
                           name="stock" 
                           class="stockInput" 
                           min="0" 
                           placeholder="0" 
                           required>
                </div>

                <div>
                    <label for="type">Kiểu sản phẩm</label>
                    <select name="type" id="type" required>
                        <option value="" disabled selected>Chọn kiểu</option>
                        <option value="Áo">Áo</option>
                        <option value="Quần">Quần</option>
                        <option value="Phụ kiện">Phụ kiện</option>
                    </select>
                </div>

                <div>
                    <label for="sexual">Giới tính</label>
                    <select name="sexual" id="sexual" required>
                        <option value="" disabled selected>Chọn giới tính</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Unisex">Unisex</option>
                    </select>
                </div>
            </div>

            <!-- Upload ảnh -->
            <div class="file-upload">
                <label for="product-image" class="file-upload__label">
                    Chọn ảnh sản phẩm <i class="fa-solid fa-upload"></i>
                </label>
                <input type="file" 
                       id="product-image" 
                       name="photo" 
                       class="file-upload__input photoInput" 
                       accept="image/*" 
                       required>
                <span class="file-upload__name">Chưa chọn file nào</span>
            </div>

            <!-- Nút submit -->
            <input type="submit" value="Thêm sản phẩm" name="add" class="submitBtn">
        </form>
    </div>
</div>

<script src="assets/js/product.js"></script>