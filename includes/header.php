<header class="header">

    <div class="header__topbar">
        <div class="header__topbar-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="#">Chào đón bộ sưu tập thu đông 2025</a>
                </div>
                <div class="swiper-slide">
                    <a href="#">Phái đẹp để yêu, vạn deal cưng chiều</a>
                </div>
                <div class="swiper-slide">
                    <a href="#">đồ mặc cả nhà, êm ái cả ngày</a>
                </div>
            </div>
            <div class="header__topbar-btn-prev">
                <i class="fa-solid fa-chevron-left"></i>
            </div>
            <div class="header__topbar-btn-next">
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </div>
    </div>
    <div class="nav-menu">
        <div class="menu-head">
            <div class="menu-title">Menu</div>
        </div>
        <ul class="menu-body">
            <li><a href="/">Trang chủ</a></li>

            <li class="has-submenu">
                <a href="#">
                    Nữ
                    <i class="fa-solid fa-caret-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="?page=nu#tat-ca">Tất cả</a></li>
                    <li><a href="?page=nu#ao-nu">Áo nữ</a></li>
                    <li><a href="?page=nu#quan-nu">Quần nữ</a></li>
                    <li><a href="?page=nu#phu-kien-nu">Phụ kiện nữ</a></li>
                </ul>
            </li>

            <li class="has-submenu">
                <a href="#">
                    Nam
                    <i class="fa-solid fa-caret-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="?page=nam#tat-ca">Tất cả</a></li>
                    <li><a href="?page=nam#ao-nam">Áo nam</a></li>
                    <li><a href="?page=nam#quan-nam">Quần nam</a></li>
                    <li><a href="?page=nam#phu-kien-nam">Phụ kiện nam</a></li>
                </ul>
            </li>

            <li><a href="?page=lienhe">Liên hệ</a></li>
            <li><a href="?page=hethongcuahang">Hệ thống cửa hàng</a></li>
        </ul>


    </div>
    <div class="overlay"></div>

    <div class="header__middle">
        <div class="header__logo">
            <a class="header__logo-wrapper" href="/">
                <img src="/assets/images/logo.webp" alt="logo">
            </a>
        </div>
        <div class="header__search">
            <form action="" method="post">
                <input type="search" name="search" id="" placeholder="Tìm kiếm...">
                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>
        <div class="header__menu-bar">
            <div class="header__menu-item header__hamburger">
                <a href="javascript:void(0)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M1.43652 7H17.9365M1.43652 1.5H17.9365M1.43652 12.5H17.9365" stroke="var(--primary-color)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    Menu
                </a>
            </div>

            <div class="header__menu-item header__wishlist">
                <a href="?page=yeuthich">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9932 5.44636C9.9938 3.10895 6.65975 2.48019 4.15469 4.62056C1.64964 6.76093 1.29697 10.3395 3.2642 12.8709C4.89982 14.9757 9.84977 19.4146 11.4721 20.8514C11.6536 21.0121 11.7444 21.0925 11.8502 21.1241C11.9426 21.1516 12.0437 21.1516 12.1361 21.1241C12.2419 21.0925 12.3327 21.0121 12.5142 20.8514C14.1365 19.4146 19.0865 14.9757 20.7221 12.8709C22.6893 10.3395 22.3797 6.73842 19.8316 4.62056C17.2835 2.5027 13.9925 3.10895 11.9932 5.44636Z" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    Yêu thích
                </a>
            </div>


            <!-- Nếu tồn tại session người dùng  -->
            <?php if (isset($_SESSION['user'])): ?>
                <div class="header__menu-item header__account avatar">
                    <a href="?page=thongtincanhan">
                        <!-- Nếu người dùng chưa có avatar thì mặc định là avatar default -->
                        <img src="<?php echo $_SESSION['user']['avatar'] ?: '/assets/images/avatar-default.jpg' ?>" alt="avatar">
                        <?= $_SESSION['user']['username'] ?>
                    </a>
                    <div class="header__account-dropdown">
                        <a href="?page=thongtincanhan" class="header__account-item">Thông tin cá nhân</a>
                        <a href="xuly/dangxuat.php" class="header__account-item">Đăng xuất</a>
                    </div>
                </div>

            <!-- Nếu không tồn tại session người dùng -->
            <?php else: ?>
                <div class="header__menu-item header__account">
                    <a href="?page=dangnhap">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M4.3163 18.9238C4.92462 17.4906 6.34492 16.4854 8 16.4854H14C15.6551 16.4854 17.0754 17.4906 17.6837 18.9238M15 8.98535C15 11.1945 13.2091 12.9854 11 12.9854C8.79086 12.9854 7 11.1945 7 8.98535C7 6.77621 8.79086 4.98535 11 4.98535C13.2091 4.98535 15 6.77621 15 8.98535ZM21 11.4854C21 17.0082 16.5228 21.4854 11 21.4854C5.47715 21.4854 1 17.0082 1 11.4854C1 5.9625 5.47715 1.48535 11 1.48535C16.5228 1.48535 21 5.9625 21 11.4854Z" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Tài khoản
                    </a>

                    <div class="header__account-dropdown">
                        <a href="?page=dangnhap" class="header__account-item">Đăng nhập</a>
                        <a href="?page=dangky" class="header__account-item">Đăng ký</a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="header__menu-item header__cart">
                <!-- php count item -->
                <a href="">
                    <span class="count-item">9</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M14.9996 6.48535C14.9996 7.54622 14.5782 8.56363 13.828 9.31378C13.0779 10.0639 12.0605 10.4854 10.9996 10.4854C9.93872 10.4854 8.92131 10.0639 8.17116 9.31378C7.42102 8.56363 6.99959 7.54622 6.99959 6.48535M2.63281 5.88674L1.93281 14.2867C1.78243 16.0913 1.70724 16.9935 2.01227 17.6895C2.28027 18.3011 2.74462 18.8057 3.33177 19.1236C4.00006 19.4853 4.90545 19.4853 6.71623 19.4853H15.283C17.0937 19.4853 17.9991 19.4853 18.6674 19.1236C19.2546 18.8057 19.7189 18.3011 19.9869 17.6895C20.2919 16.9935 20.2167 16.0913 20.0664 14.2867L19.3664 5.88673C19.237 4.3341 19.1723 3.55779 18.8285 2.97021C18.5257 2.45279 18.0748 2.03795 17.5341 1.7792C16.92 1.48535 16.141 1.48535 14.583 1.48535L7.41623 1.48535C5.85821 1.48535 5.07921 1.48535 4.4651 1.7792C3.92433 2.03795 3.47349 2.45279 3.17071 2.97021C2.82689 3.55778 2.76219 4.3341 2.63281 5.88674Z" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    Giỏ hàng
                </a>
            </div>
        </div>
    </div>

    <div class="header__nav">
        <ul class="header__nav-links">
            <li class="header__nav-link"><a href="/">Trang chủ</a></li>
            <li class="header__nav-link dropdown">
                <a href="?page=nu#tat-ca">
                    Nữ
                    <i class="fa-solid fa-caret-down"></i>
                </a>
                <div class="nav-content">
                    <ul class="nav-list">
                        <li class="nav-item"><a href="?page=nu#ao-nu">Áo nữ</a></li>
                        <li class="nav-item"><a href="?page=nu#quan-nu">Quần nữ</a></li>
                        <li class="nav-item"><a href="?page=nu#phu-kien-nu">Phụ kiện nữ</a></li>
                    </ul>
                </div>
            </li>
            <li class="header__nav-link dropdown">
                <a href="?page=nam#tat-ca">
                    Nam
                    <i class="fa-solid fa-caret-down"></i>
                </a>
                <div class="nav-content">
                    <ul class="nav-list">
                        <li class="nav-item"><a href="?page=nam#ao-nam">Áo nam</a></li>
                        <li class="nav-item"><a href="?page=nam#quan-nam">Quần nam</a></li>
                        <li class="nav-item"><a href="?page=nam#phu-kien-nam">Phụ kiện nam</a></li>
                    </ul>
                </div>
            </li>
            <li class="header__nav-link"><a href="?page=lienhe">Liên hệ</a></li>
            <li class="header__nav-link"><a href="?page=hethongcuahang">Hệ thống cửa hàng</a></li>
        </ul>
    </div>
</header>


<script>
    const wrapper = document.querySelector('.swiper-wrapper');
    const slides = document.querySelectorAll('.swiper-slide');
    const btnPrev = document.querySelector('.header__topbar-btn-prev');
    const btnNext = document.querySelector('.header__topbar-btn-next');

    let currentIndex = 0;

    function goToSlide(index) {
        const slideWidth = slides[0].offsetWidth;
        wrapper.scrollTo({
            left: slideWidth * index,
            behavior: 'smooth'
        });
    }

    function updateButtons() {
        // Nếu đang ở slide đầu tiên → disable Prev
        if (currentIndex === 0) {
            btnPrev.classList.add('disabled');
        } else {
            btnPrev.classList.remove('disabled');
        }

        // Nếu đang ở slide cuối cùng → disable Next
        if (currentIndex === slides.length - 1) {
            btnNext.classList.add('disabled');
        } else {
            btnNext.classList.remove('disabled');
        }
    }

    // Nút Next
    btnNext.addEventListener('click', () => {
        if (currentIndex < slides.length - 1) {
            currentIndex++;
            goToSlide(currentIndex);
            updateButtons();
        }
    });

    // Nút Prev
    btnPrev.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            goToSlide(currentIndex);
            updateButtons();
        }
    });

    // Khi người dùng cuộn bằng tay → cập nhật nút
    wrapper.addEventListener('scroll', () => {
        const slideWidth = slides[0].offsetWidth;
        currentIndex = Math.round(wrapper.scrollLeft / slideWidth);
        updateButtons();
    });

    // Gọi lần đầu khi load
    updateButtons();
</script>

<script>
    const hamburger = document.querySelector('.header__hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const overlay = document.querySelector('.overlay');

    // Toggle mở/đóng menu mobile
    hamburger.addEventListener('click', (e) => {
        e.preventDefault();
        navMenu.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    // Click overlay → đóng menu
    overlay.addEventListener('click', () => {
        navMenu.classList.remove('active');
        overlay.classList.remove('active');
    });

    // Toggle submenu (Nữ / Nam)
    document.querySelectorAll('.has-submenu > a').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();

            const icon = link.querySelector('.fa-caret-down');
            const submenu = link.nextElementSibling;

            // Đóng các submenu khác
            document.querySelectorAll('.submenu').forEach(menu => {
                if (menu !== submenu) {
                    menu.classList.remove('open');
                    const otherIcon = menu.previousElementSibling.querySelector('.fa-caret-down');
                    if (otherIcon) otherIcon.classList.remove('active');
                }
            });

            // Toggle submenu hiện tại
            submenu.classList.toggle('open');
            icon.classList.toggle('active');
        });
    });

    // Khi resize cửa sổ → reset trạng thái menu về mặc định
    window.addEventListener('resize', () => {
        const width = window.innerWidth;
        if (width > 768) {
            // Ẩn menu mobile khi chuyển sang desktop
            navMenu.classList.remove('active');
            overlay.classList.remove('active');

            // Đóng submenu & reset icon
            document.querySelectorAll('.submenu').forEach(menu => {
                menu.classList.remove('open');
            });
            document.querySelectorAll('.fa-caret-down').forEach(icon => {
                icon.classList.remove('active');
            });
        }
    });
</script>