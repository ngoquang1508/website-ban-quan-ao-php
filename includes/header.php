<header>
    <a href="index.php">
        <img src="assets/images/logo.jpg" alt="logo">
    </a>

    <!-- Desktop nav -->
    <nav class="header__desktop-nav">
        <a href="index.php">Trang chủ</a>
        <a href="index.php?page=nu">Nữ</a>
        <a href="index.php?page=nam">Nam</a>
        <a href="index.php?page=tintuc">Tin tức</a>
        <a href="index.php?page=lienhe">Liên hệ</a>
    </nav>

    <?php if (isset($_SESSION['user'])): ?>
        <a class="header__desktop-logout-btn" href="xuly/dangxuat.php">Đăng xuất</a>
    <?php else: ?>
        <div class="header__account">
            <i class="fa-solid fa-user"></i>

            <ul class="header__account-list">
                <li>
                    <a class="header__account-item" href="index.php?page=dangnhap">Đăng nhập</a>
                </li>
                <li>
                    <a class="header__account-item" href="index.php?page=dangky">Đăng ký</a>
                </li>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Mobile nav -->
    <div class="header__mobile-nav">
        <i class="fa-solid fa-list"></i>
        <div class="header__mobile-list">
            <a class="header__mobile-item" href="index.php">Trang chủ</a>
            <a class="header__mobile-item" href="index.php?page=nu">Nữ</a>
            <a class="header__mobile-item" href="index.php?page=nam">Nam</a>
            <a class="header__mobile-item" href="index.php?page=tintuc">Tin tức</a>
            <a class="header__mobile-item" href="index.php?page=lienhe">Liên hệ</a>

            <?php if (isset($_SESSION['user'])): ?>
                <a class="header__mobile-item" href="xuly/dangxuat.php">Đăng xuất</a>
            <?php else: ?>
                <a class="header__mobile-item" href="index.php?page=dangnhap">Đăng nhập</a>
                <a class="header__mobile-item" href="index.php?page=dangky">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
    const icon = document.querySelector('.header__mobile-nav .fa-list');
    const list = document.querySelector('.header__mobile-list');
    icon.addEventListener("click", () => list.classList.toggle('active'));
</script>