<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" href="assets/css/pages/dangnhap.css">
</head>
<body>
    <div class="login__container">
        <div class="login__form">
            <h1 class="login__form-title">Đặt lại mật khẩu</h1>

            <form class="login__form-main" action="xuly/doimatkhau.php" method="post">
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

                <button type="submit" name="submit">Đổi mật khẩu</button>
                <a class="login__prev-login" href="index.php?page=dangnhap">Quay lại trang đăng nhập</a>
            </form>
        </div>
    </div>
</body>
</html>
