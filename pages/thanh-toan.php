<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/thanh-toan.css">

<?php
require_once "config/db.php";

// Lấy danh sách sản phẩm trong giỏ hàng
// $stmt = $conn->prepare("");

// Lấy sản phẩm mà người dùng chọn

?>

<div class="checkout__container">
    <div class="checkout__info">
        <div class="logo">
            <a href="<?= BASE_URL ?>">ND Style</a>
        </div>

        <div class="row">
            <div class="col">
                <!-- THÔNG TIN NHẬN HÀNG -->
                <div class="title">
                    <i class="fa-regular fa-id-card"></i>
                    <h2>Thông tin nhận hàng</h2>
                </div>

                <div class="input-group">
                    <input type="email" name="email" placeholder="">
                    <span>Email</span>
                </div>
                <div class="input-group">
                    <input type="text" name="" placeholder="">
                    <span>Họ và tên</span>
                </div>
                <div class="input-group">
                    <input type="text" name="" placeholder="">
                    <span>Số điện thoại</span>
                </div>
                <div class="input-group">
                    <input type="text" name="" placeholder="">
                    <span>Địa chỉ</span>
                </div>
                <div class="input-group">
                    <textarea name="" maxlength="500" placeholder="" oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"></textarea>
                    <span>Ghi chú (tùy chọn)</span>
                </div>
            </div>

            <div class="col">
                <!-- VẬN CHUYỂN -->
                <div class="title">
                    <i class="fa-solid fa-truck"></i>
                    <h2>Vận chuyển</h2>
                </div>
                <div class="transport">
                    <label class="checkout__option">
                        <input type="radio" checked />
                        <div class="name">
                            <span>Giao hàng tận nơi</span>
                            <span>40.000<u>đ</u></span>
                        </div>
                    </label>
                </div>
                <!-- PHƯƠNG THỨC THANH TOÁN -->
                <div class="title">
                    <i class="fa-regular fa-credit-card"></i>
                    <h2>Thanh toán</h2>
                </div>
                <div class="checkout__method">
                    <label class="checkout__option">
                        <input type="radio" name="payment_method" value="transfer" />
                        <div class="name">
                            <span>Chuyển khoản</span>
                            <span><i class="fa-regular fa-money-bill-1"></i></span>
                        </div>
                    </label>

                    <label class="checkout__option">
                        <input type="radio" name="payment_method" value="cod" />
                        <div class="name">
                            <span>Thu hộ (COD)</span>
                            <span><i class="fa-regular fa-money-bill-1"></i></span>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- ĐƠN HÀNG -->
    <div class="checkout__orders">
        <div class="col">
            <h2>Đơn hàng (1 sản phẩm)</h2>

            <!-- SẢN PHẨM -->
            <div class="list">
                <div class="item">
                    <div class="image">
                        <img src="<?= BASE_URL ?>uploads/products/sp11.webp" alt="">
                        <span class="qty">1</span>
                    </div>
                    <div class="decs">
                        <span class="name">Áo Len Gilet Nữ Cổ Tim Dệt Thừng</span>
                    </div>
                    <div class="qty-price">
                        <span>868.000<u>đ</u></span>
                    </div>
                </div>
            </div>

            <!-- MÃ GIẢM GIÁ -->
            <div class="discount">
                <input type="text" placeholder="Nhập mã giảm giá">
                <button>Áp dụng</button>
            </div>

            <!-- SUMMARY -->
            <div class="checkout__summary">
                <div class="item">
                    <span class="label">Tạm tính</span>
                    <span class="value">868.000<u>đ</u></span>
                </div>
                <div class="item">
                    <span class="label">Phí vận chuyển</span>
                    <span class="value">868.000<u>đ</u></span>
                </div>
            </div>
            <!-- TỔNG TIỀN  -->
            <div class="checkout__total">
                <div class="item">
                    <span class="label">Tổng cộng</span>
                    <span class="value">868.000<u>đ</u></span>
                </div>
                <div class="item">
                    <!-- go back -->
                    <a href="" class="go-back">
                        <i class="fa-solid fa-angle-left"></i>
                        Quay lại
                    </a>
                    <!-- button -->
                    <button class="submit">Đặt hàng</button>
                </div>
            </div>
        </div>
    </div>

</div>