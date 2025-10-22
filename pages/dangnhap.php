<div class="auth__container">
    <div class="auth__form">
        <h1 class="auth__form-title">Đăng nhập</h1>
        <form class="auth__form-main" action="xuly/dangnhap.php" method="post">
            <div class="input-box">
                <input type="text" name="email" placeholder=" " required>
                <span>Email</span>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder=" " required>
                <span>Mật khẩu</span>
            </div>
            <button type="submit" name="submit">Đăng nhập</button>
        </form>
        <a class="auth__forgot-pass" href="index.php?page=quenmatkhau">Quên mật khẩu</a>

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

        <p>Bạn chưa có tài khoản? <a href="index.php?page=dangky">Đăng ký</a></p>
    </div>
</div>

