<!-- CSS + JS -->
<link rel="stylesheet" href="/assets/css/trangchu.css">
<script src="/assets/js/trangchu.js" defer></script>

<!-- 1. DANH MỤC TRÒN -->
<section class="category-round">

    <ul class="category-round__list">

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="/uploads/image_cate_1.webp" alt="Áo nữ">
            </div>
            <span class="category-round__label">Áo nữ</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="/uploads/image_cate_2.webp" alt="Váy">
            </div>
            <span class="category-round__label">Váy</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="/uploads/image_cate_3.webp" alt="Áo nam">
            </div>
            <span class="category-round__label">Áo nam</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="/uploads/image_cate_5.webp" alt="Quần">
            </div>
            <span class="category-round__label">Quần</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="/uploads/image_cate_6.webp" alt="Áo khoác">
            </div>
            <span class="category-round__label">Áo khoác</span>
        </li>

        <li class="category-round__item">
            <div class="category-round__thumb">
                <img src="/uploads/image_cate_8.webp" alt="Phụ kiện">
            </div>
            <span class="category-round__label">Phụ kiện</span>
        </li>

    </ul>
</section>

<!-- 2. VOUCHER SLIDER -->
<div class="voucher">
    <div class="voucher__title">
        <div class="voucher__title-line voucher__title-line--left"></div>
        <span>DÀNH RIÊNG CHO BẠN</span>
        <div class="voucher__title-line voucher__title-line--right"></div>
    </div>

    <div class="voucher-slider" id="voucherSlider">
        <div class="voucher-slider__nav voucher-slider__nav--prev">←</div>
        
        <div class="voucher-slider__track" id="voucherTrack">
            <?php
            $voucherList = [
                ["title" => "Miễn phí vận chuyển", "desc" => "Cho đơn hàng đầu tiên", "code" => "FREE-SHIP"],
                ["title" => "Giảm 15%", "desc" => "Áp dụng cho đơn từ 699K", "code" => "SAVE15"],
                ["title" => "Giảm 25%", "desc" => "Áp dụng cho đơn từ 1.049K", "code" => "VIP25"],
                ["title" => "Giảm 40%", "desc" => "Tuần lễ sinh nhật", "code" => "BDAY40"],
                ["title" => "Giảm 60%", "desc" => "BLACK FRIDAY", "code" => "BLACK60"],
            ];
            foreach ($voucherList as $i => $v):
            ?>
                <div class="voucher-card <?= $i === 1 ? 'active' : '' ?>">
                    <div class="voucher-card__top">
                        <div class="voucher-card__title"><?= $v["title"] ?></div>
                        <div class="voucher-card__desc"><?= $v["desc"] ?></div>
                    </div>
                    <div class="voucher-card__bottom">
                        <div class="voucher-card__code"><?= $v["code"] ?></div>
                        <a href="#" class="voucher-card__btn">Sử dụng ngay →</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="voucher-slider__nav voucher-slider__nav--next">→</div>
    </div>


</div>

<!-- 3. GỢI Ý HÔM NAY -->
<div class="promo__title">
    <div class="promo__title-line promo__title-line--left"></div>
    <span>GỢI Ý HÔM NAY</span>
    <div class="promo__title-line promo__title-line--right"></div>
</div>

<div class="promo-grid">
    <a href="#" class="promo-grid__item promo-grid__item--tall">
        <img src="/assets/images/img_banner_1.webp" alt="Tuần lễ thời trang" class="promo-grid__image">
        <div class="promo-grid__overlay">
            <div class="d-flex gap-2 mt-3 flex-wrap">
            </div>
        </div>
    </a>

    <a href="#" class="promo-grid__item promo-grid__item--wide">
        <img src="/assets/images/img_banner_2.webp" alt="BST Mùa Thu 2024" class="promo-grid__image">
        <div class="promo-grid__overlay wide-overlay">
        </div>
    </a>

    <a href="#" class="promo-grid__item promo-grid__item--square">
        <img src="/assets/images/img_banner_3.webp" alt="Giảm đến 50%" class="promo-grid__image">
        <div class="promo-grid__overlay text-center">
        </div>
    </a>

    <a href="#" class="promo-grid__item promo-grid__item--jeans">
        <img src="/assets/images/img_banner_4.webp" alt="Bộ sưu tập Jeans" class="promo-grid__image">
        <div class="promo-grid__overlay jeans-overlay">
        </div>
    </a>
</div>

<!-- 4.LOOKBOOK -->
<div class="lookbook" id="lookbook">
    <div class="lookbook__track" id="lookbookTrack">
        
        <!-- Item 1 -->
        <div class="lookbook__item lookbook__item--active">
            <div class="lookbook__media">
                <img src="/assets/images/image_lookbook_1.webp" alt="Enchanting Dress 2024">
            </div>
            <div class="lookbook__content">
                <h2 class="lookbook__title">ENCHANTING DRESS 2024</h2>
                <p class="lookbook__desc">
                    Khám phá bộ sưu tập hơn 20 sản phẩm váy hoa với thiết kế thanh thoát và nữ tính. 
                    Những họa tiết hoa tươi sáng và chất liệu mềm mại mang đến sự quyến rũ cho mọi dịp.
                </p>
                <a href="#" class="lookbook__btn">XEM THÊM →</a>
            </div>
        </div>

        <!-- Item 2 -->
        <div class="lookbook__item">
            <div class="lookbook__media">
                <img src="/assets/images/image_lookbook_2.webp" alt="Autumn Collection">
            </div>
            <div class="lookbook__content">
                <h2 class="lookbook__title">AUTUMN VIBES 2024</h2>
                <p class="lookbook__desc">
                    Bộ sưu tập thu đông mới nhất với tông màu đất ấm áp, chất liệu cao cấp, 
                    mang đến vẻ ngoài sang trọng và tinh tế.
                </p>
                <a href="#" class="lookbook__btn">KHÁM PHÁ NGAY →</a>
            </div>
        </div>

        <!-- Item 3 -->
        <div class="lookbook__item">
            <div class="lookbook__media">
                <img src="/assets/images/image_lookbook_3.webp" alt="Sale 50%">
            </div>
            <div class="lookbook__content">
                <h2 class="lookbook__title">SALE UP TO 50%</h2>
                <p class="lookbook__desc">
                    Chỉ trong 7 ngày vàng! Áp dụng toàn bộ sản phẩm thu đông.
                </p>
                <a href="#" class="lookbook__btn">SĂN SALE LIỀN TAY →</a>
            </div>
        </div>


    </div>

    <!-- Nút điều hướng -->
    <div class="lookbook__nav lookbook__nav--prev">←</div>
    <div class="lookbook__nav lookbook__nav--next">→</div>

    <!-- Dots -->
    <div class="lookbook__dots" id="lookbookDots"></div>
</div>