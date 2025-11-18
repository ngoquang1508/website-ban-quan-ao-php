<!-- CSS -->
<link rel="stylesheet" href="/assets/css/trangchu.css">
<script src="/assets/js/trangchu.js"></script>

<!-- BLOCK -->
<section class="category-round">
    <!-- ELEMENT -->
    <ul class="category-round__list">

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="#" alt="Áo nữ">
            </div>
            <span class="category-round__label">Áo nữ</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="#" alt="Váy">
            </div>
            <span class="category-round__label">Váy</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="#" alt="Áo nam">
            </div>
            <span class="category-round__label">Áo nam</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="#" alt="Sơ mi">
            </div>
            <span class="category-round__label">Sơ mi</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="#" alt="Quần">
            </div>
            <span class="category-round__label">Quần</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="#" alt="Áo khoác">
            </div>
            <span class="category-round__label">Áo khoác</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="#" alt="Giày dép">
            </div>
            <span class="category-round__label">Giày dép</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="#" alt="Phụ kiện">
            </div>
            <span class="category-round__label">Phụ kiện</span>
        </li>

    </ul>
</section>
<?php

$voucherList = [
    ["title" => "Miễn phí vận chuyển", "desc" => "Cho đơn hàng đầu tiên", "code" => "FREE-SHIP"],
    ["title" => "Giảm 15%", "desc" => "Áp dụng cho đơn từ 699K", "code" => "SAVE15"],
    ["title" => "Giảm 25%", "desc" => "Áp dụng cho đơn từ 1.049K", "code" => "VIP25"],
    ["title" => "Giảm 40%", "desc" => "Tuần lễ sinh nhật", "code" => "BDAY40"],
    ["title" => "Giảm 60%", "desc" => "BLACK FRIDAY", "code" => "BLACK60"],
];
?>
<div class="voucher__title">
        <div class="voucher__title-line voucher__title-line--left"></div>
        <span>Dành riêng cho bạn</span>
        <div class="voucher__title-line voucher__title-line--right"></div>
    </div>
<div class="voucher">
    <div class="voucher-slider" id="voucherSlider">
        <!-- Nút Prev -->
        <div class="voucher-slider__nav voucher-slider__nav--prev" id="prevBtn">
            <svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
        </div>

        <!-- Track -->
        <div class="voucher-slider__track" id="voucherTrack">
            <?php foreach ($voucherList as $v): ?>
                <div class="voucher-card">
                    <div class="voucher-card__top">
                        <div class="voucher-card__title"><?= htmlspecialchars($v["title"]) ?></div>
                        <div class="voucher-card__desc"><?= htmlspecialchars($v["desc"]) ?></div>
                    </div>
                    <div class="voucher-card__bottom">
                        <div class="voucher-card__code"><?= $v["code"] ?></div>
                        <a href="#" class="voucher-card__btn">Sử dụng ngay →</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Nút Next -->
        <div class="voucher-slider__nav voucher-slider__nav--next" id="nextBtn">
            <svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </div>
    </div>

    <!-- Dots -->
    <div class="voucher-slider__dots" id="dotsContainer"></div>
</div>

<!-- GOI Y HOM NAY -->
 <div class="promo__title">
        <div class="promo__title-line promo__title-line--left"></div>
        <span>GỢI Ý HÔM NAY</span>
        <div class="promo__title-line promo__title-line--right"></div>
    </div>
<div class="promo-grid">
    <!-- Card lớn dọc -->
    <div class="promo-grid__item promo-grid__item--">
        <img src="/assets/images/img_banner_1.webp" alt="Tuần lễ thời trang" class="promo-grid__image">
    </div>

    <!-- Card ngang nhỏ -->
    <div class="promo-grid__item promo-grid__item--wide">
        <img src="/assets/images/img_banner_2.webp" alt="Áo khoác" class="promo-grid__image">
    </div>

    <!-- Card giảm giá -->
    <div class="promo-grid__item promo-grid__item--square">
        <img src="/assets/images/img_banner_3.webp" alt="Giảm giá" class="promo-grid__image">
    </div>

    <!-- Card jeans -->
    <div class="promo-grid__item promo-grid__item--jeans">
        <img src="/assets/images/img_banner_4.webp" alt="Jeans" class="promo-grid__image">
    </div>
</div>

