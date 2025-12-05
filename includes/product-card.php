<?php
function ProductCard($id, $name, $price, $stock, $url_image, $date, $favorites = [], $carts = [])
{
    $activeClass = in_array($id, $favorites) ? 'active' : '';
    $cartClass = in_array($id, $carts) ? 'active' : '';
?>
    <div class="product-card"
        data-price="<?= $price ?>"
        data-date="<?= $date ?>">

        <a href="?page=chi-tiet-san-pham&id=<?= $id ?>" class="product-card__img">
            <img src="<?= isset($url_image) && $url_image ? BASE_URL . $url_image : BASE_URL . "assets/images/no-image.jpg" ?>" alt="<?= htmlspecialchars($name) ?>">
        </a>
        
        <div class="product-card__info">
            <h2><?= $name ?></h2>
            <span><?= formatPrice($price) ?><u>đ</u></span> <br>
            <div class="stock <?= $stock > 0 ? "" : "hetHang" ?>"><?= $stock > 0 ? "Còn " . $stock : "Hết hàng" ?></div>
        </div>
        <a href="?page=chi-tiet-san-pham&id=<?= $id ?>" class="product-card__detail">Xem chi tiết</a>

        <a href="javascript:void(0)" class="product-card__add-to-cart <?= $cartClass ?>" data-id="<?= $id ?>" data-stock="<?= $stock ?>">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>

        <a href="javascript:void(0)" class="product-card__favorite <?= $activeClass ?>" data-id="<?= $id ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9932 5.44636C9.9938 3.10895 6.65975 2.48019 4.15469 4.62056C1.64964 6.76093 1.29697 10.3395 3.2642 12.8709C4.89982 14.9757 9.84977 19.4146 11.4721 20.8514C11.6536 21.0121 11.7444 21.0925 11.8502 21.1241C11.9426 21.1516 12.0437 21.1516 12.1361 21.1241C12.2419 21.0925 12.3327 21.0121 12.5142 20.8514C14.1365 19.4146 19.0865 14.9757 20.7221 12.8709C22.6893 10.3395 22.3797 6.73842 19.8316 4.62056C17.2835 2.5027 13.9925 3.10895 11.9932 5.44636Z" stroke="#000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </a>
    </div>
<?php
}
?>

<script type="module" src="<?= BASE_URL ?>assets/js/addToCart.js"></script>