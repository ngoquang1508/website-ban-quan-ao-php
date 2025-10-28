<?php
function ProductCard($id, $name, $price, $url_image, $date)
{
?>
    <div class="product-card"
        data-price="<?= $price ?>"
        data-date="<?= $date ?>"
    >

        <a href="?page=chi-tiet-san-pham&id=<?= $id ?>" class="product-card__img">
            <img src="<?= $url_image ?>" alt="<?= $name ?>">
        </a>

        <div class="product-card__info">
            <h2><?= $name ?></h2>
            <span><?= $price ?> <u>đ</u></span>
        </div>
        <a href="?page=chi-tiet-san-pham&id=<?= $id ?>" class="product-card__detail">Xem chi tiết</a>

        <a href="javascript:void(0)" class="product-card__add-to-cart">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>

        <a href="javascript:void(0)" class="product-card__favorite">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9932 5.44636C9.9938 3.10895 6.65975 2.48019 4.15469 4.62056C1.64964 6.76093 1.29697 10.3395 3.2642 12.8709C4.89982 14.9757 9.84977 19.4146 11.4721 20.8514C11.6536 21.0121 11.7444 21.0925 11.8502 21.1241C11.9426 21.1516 12.0437 21.1516 12.1361 21.1241C12.2419 21.0925 12.3327 21.0121 12.5142 20.8514C14.1365 19.4146 19.0865 14.9757 20.7221 12.8709C22.6893 10.3395 22.3797 6.73842 19.8316 4.62056C17.2835 2.5027 13.9925 3.10895 11.9932 5.44636Z" stroke="#000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </a>
    </div>
<?php
}
?>


<style>
    /* ===== PRODUCT CARD ===== */
    .product-card {
        position: relative;
        width: 30rem;
        height: 48rem;
        display: flex;
        flex-direction: column;
        border-radius: 1.2rem;
        overflow: hidden;
        background: #fff;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    /* --- Image --- */
    .product-card__img {
        width: 100%;
        height: 70%;
        min-height: 36rem;
        overflow: hidden;
        border-radius: 1.2rem;
    }

    .product-card__img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-card__img img {
        transform: scale(1.1);
    }

    /* --- Info --- */
    .product-card__info {
        padding: 1rem;
        text-align: left;
    }

    .product-card__info h2 {
        font-size: 1.8rem;
        color: #222;
        margin-bottom: 0.5rem;
    }

    .product-card__info span {
        font-size: 1.6rem;
        font-weight: 600;
        color: #ff6347;
    }

    /* --- Detail Button --- */
    .product-card__detail {
        position: absolute;
        bottom: 5rem;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        padding: 1.2rem 0;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 500;
        color: #333;
        background: #fff;
        border-radius: 3rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .product-card:hover .product-card__detail {
        bottom: 12.5rem;
        opacity: 1;
    }

    .product-card__detail:hover {
        background: #ff6347;
        color: #fff;
    }

    /* --- Add to cart --- */
    .product-card__add-to-cart {
        position: absolute;
        right: 1rem;
        bottom: 1rem;
        padding: 1.3rem;
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, 0.1);
        font-size: 1.6rem;
        background: #fff;
        transition: all 0.3s ease;
    }

    .product-card__add-to-cart:hover {
        background: #ff6347;
        color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    /* --- Favorite Button --- */
    .product-card__favorite {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.8rem;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        transform: translateX(130%);
        transition: all 0.3s ease;
    }

    .product-card:hover .product-card__favorite {
        transform: translateX(0);
    }

    .product-card__favorite:hover {
        background: #ff6347;
    }

    .product-card__favorite:hover svg path {
        stroke: #fff;
    }

    /* --- Responsive --- */
    @media (min-width: 450px) {
        .product-card {
            flex: 0 0 42%;
        }
    }

    @media (min-width: 768px) {
        .product-card {
            flex: 0 0 31%;
        }
    }
</style>