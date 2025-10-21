<div class="banner__container">
    <picture>
        <source media="(min-width: 1200px)" srcset="assets/images/banner_1.webp" type="image/webp">
        <source media="(min-width: 1024px)" srcset="assets/images/banner_1.webp" type="image/webp">
        <source media="(min-width: 768px)" srcset="assets/images/banner_1.webp" type="image/webp">
        <img src="assets/images/banner_1.webp" alt="Banner chính" loading="lazy" style="display:block; margin:0 auto; max-width:100%;">
    </picture>

    <div class="banner__policy">
        <div class="banner__policy-list">
            <div class="banner__policy-item">
                <div class="banner__policy-icon">
                    <img src="assets/images/icon_policy_1.webp" alt="Giao hàng toàn quốc" loading="lazy">
                </div>
                <div class="banner__policy-text">
                    <h4>Giao hàng toàn quốc</h4>
                    <p>Thanh toán (COD) khi nhận hàng</p>
                </div>
            </div>

            <div class="banner__policy-item">
                <div class="banner__policy-icon">
                    <img src="assets/images/icon_policy_2.webp" alt="Miễn phí giao hàng" loading="lazy">
                </div>
                <div class="banner__policy-text">
                    <h4>Miễn phí giao hàng</h4>
                    <p>Theo chính sách</p>
                </div>
            </div>

            <div class="banner__policy-item">
                <div class="banner__policy-icon">
                    <img src="assets/images/icon_policy_3.webp" alt="Đổi trả trong 7 ngày" loading="lazy">
                </div>
                <div class="banner__policy-text">
                    <h4>Đổi trả trong 7 ngày</h4>
                    <p>Kể từ ngày mua hàng</p>
                </div>
            </div>

            <div class="banner__policy-item">
                <div class="banner__policy-icon">
                    <img src="assets/images/icon_policy_4.webp" alt="Hỗ trợ 24/7" loading="lazy">
                </div>
                <div class="banner__policy-text">
                    <h4>Hỗ trợ 24/7</h4>
                    <p>Theo chính sách</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ==============================
        POLICY BAR (MOBILE)
    ============================== */
    .banner__container {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-bottom: 4rem;
    }
    .banner__policy {
        width: 94%;
        padding: 2rem 4rem;
        margin-top: 4rem;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        background: #fff;
        box-shadow: 0 0 6px rgba(0 , 0, 0, 0.3);
        border-radius: 2rem;
        overflow: hidden;
    }

    .banner__policy-list {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-wrap: nowrap;
        gap: 2rem;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
    }

    .banner__policy-list::-webkit-scrollbar {
        display: none;
    }

    .banner__policy-list {
        scrollbar-width: none;
    }

    .banner__policy-item {
        display: flex;
        flex: 0 0 28rem;
        justify-content: flex-start;
        align-items: center;
        scroll-snap-align: center;
        transition: transform 0.2s ease;
    }

    .banner__policy-icon {
        width: var(--policy-icon-size);
        height: var(--policy-icon-size);
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .banner__policy-icon img {
        max-width: 100%;
        max-height: 100%;
    }

    .banner__policy-text {
        white-space: nowrap;
        line-height: 2.4rem;
    }

    .banner__policy-text h4 {
        font-size: 1.4rem;
        color: #000;
        font-weight: 600;
    }

    .banner__policy-text p {
        font-size: 1.2rem;
        color: #333;
    }
    @media (min-width: 768px) {
        .banner__container {
            margin-bottom: -3rem;
        }
        .banner__policy {
            padding: 3.8rem 4rem;
            transform: translateY(-70%);
        }
    }
</style>