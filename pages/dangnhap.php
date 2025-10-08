<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/pages/dangnhap.css">
</head>

<body>
    <div class="login__container">
        <div class="login__form">
            <h1 class="login__form-title">Đăng nhập</h1>
            <form class="login__form-main" action="xuly/dangnhap.php" method="post">
                <div class="input-box">
                    <input type="text" name="email" placeholder=" " required>
                    <span>Email</span>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder=" " required>
                    <span>Mật khẩu</span>
                </div>
                <a class="login__forgot-pass" href="index.php?page=quenmatkhau">Quên mật khẩu</a>
                <button type="submit" name="submit">Đăng nhập</button>
            </form>

            <p>Bạn chưa có tài khoản? <a href="index.php?page=dangky">Đăng ký</a></p>
        </div>
    </div>
</body>

</html>