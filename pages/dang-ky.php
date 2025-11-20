<div class="auth__container">
    <div class="auth__form">
        <h1 class="auth__form-title">Đăng Ký</h1>
        <form class="auth__form-main" action="xuly/dang-ky.php" method="post">
            <div class="input-box">
                <input type="text" name="hoten" placeholder=" " required>
                <span>Họ tên</span>
            </div>

            <div class="input-box">
                <input type="email" name="email" placeholder=" " required>
                <span>Email</span>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder=" " required>
                <span>Mật khẩu</span>
            </div>

            <div class="input-box">
                <input type="password" name="confirm_password" placeholder=" " required>
                <span>Xác nhận mật khẩu</span>
            </div>

            <button type="submit" name="submit">Đăng Ký</button>
        </form>
        
        <div class="auth__social">
            <span class="auth__social-or">hoặc</span>
            <span class="auth__social-title">Đăng nhập bằng</span>
            <ul class="auth__social-list">
                <li class="auth__social-item">
                    <a class="fb" href="javascript:void(0)">
                        <i class="fa-brands fa-facebook"></i>
                        <span>Facebook</span>
                    </a>
                </li>
                <li class="auth__social-item">
                    <a class="gg" href="javascript:void(0)">
                        <i class="fa-brands fa-google"></i>
                        <span>Google</span>
                    </a>
                </li>
            </ul>
        </div>

        <p>Bạn đã có tài khoản? <a href="?page=dang-nhap">Đăng nhập</a></p>
    </div>
</div>