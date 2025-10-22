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
            <a class="auth__forgot-pass" href="index.php?page=quenmatkhau">Quên mật khẩu</a>
            <button type="submit" name="submit">Đăng nhập</button>
        </form>

        <p>Bạn chưa có tài khoản? <a href="index.php?page=dangky">Đăng ký</a></p>
    </div>
</div>

