<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="assets/css/pages/dangnhap.css">
</head>

<body>
    <div class="login__container">
        <div class="login__form">
            <h1 class="login__form-title">Đăng Ký</h1>
            <form class="login__form-main" action="xuly/dangky.php" method="post">
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

            <p>Bạn đã có tài khoản? <a href="index.php?page=dangnhap">Đăng nhập</a></p>
        </div>
    </div>
</body>

</html>