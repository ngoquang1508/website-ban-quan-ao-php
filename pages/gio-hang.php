<link rel="stylesheet" href="/assets/css/cart.css">

<div class="cart">
    <h1 class="cart__title">Giỏ hàng của bạn</h1>

    <div class="cart__list">
        <div class="cart-item">
            <div class="cart-item__body">
                <div class="cart-item__image">
                    <img src="/uploads/ao-thun-seventy-seven-04-h-ng-1174883171.webp" alt="Áo thun">
                </div>

                <div class="cart-item__details">
                    <h2 class="cart-item__title">Đầm liền váy nữ</h2>
                    <p class="cart-item__desc">Mô tả sản phẩm</p>

                    <div class="cart-item__controls">
                        <div class="cart-qty">
                            <button type="button" class="cart-qty__btn cart-qty__btn--decrease">
                                <i class="fa-solid fa-minus"></i>
                            </button>

                            <input
                                class="cart-qty__input"
                                type="text"
                                name="quantity"
                                value="1"
                                min="1"
                                max="<?= $product['stock'] ?>"
                                onchange="if(this.value == 0) this.value = 1"
                                onkeypress="if (isNaN(this.value + String.fromCharCode(event.keyCode))) return false"
                                data-stock="<?= $product['stock'] ?>">

                            <button type="button" class="cart-qty__btn cart-qty__btn--increase">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>

                        <p class="cart-item__price">190.000<u>đ</u></p>
                    </div>

                    <button type="button" class="cart-item__remove">×</button>
                </div>
            </div>
        </div>

        <!-- Lặp lại nhiều cart-item nếu có nhiều sản phẩm -->
    </div>

    <!-- Tổng tiền toàn giỏ hàng -->
    <div class="cart__summary">
        <span class="cart__summary-label">Tổng cộng:</span>
        <span class="cart__summary-total">1.900.000<u>đ</u></span>
    </div>

    <!-- Nút thanh toán -->
     <div class="cart__checkout">
         <button class="cart__checkout-btn" type="button">Thanh toán ngay</button>
     </div>
</div>