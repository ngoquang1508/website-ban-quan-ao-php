<div class="auth__container">
    <div class="auth__form">
        <h1 class="auth__form-title">Đặt lại mật khẩu</h1>

        <form class="auth__form-main" method="post">
            <!-- Ẩn email để biết user nào cần đổi -->
            <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">

            <div class="input-box">
                <input type="password" name="password" placeholder=" " required>
                <span>Mật khẩu mới</span>
            </div>

            <div class="input-box">
                <input type="password" name="confirm_password" placeholder=" " required>
                <span>Xác nhận mật khẩu</span>
            </div>

            <button id="submitBtn" type="submit" name="submit">Đổi mật khẩu</button>
            <a class="auth__prev-login" href="?page=dang-nhap">Quay lại trang đăng nhập</a>
        </form>
    </div>
</div>