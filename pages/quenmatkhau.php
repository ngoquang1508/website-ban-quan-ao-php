<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="assets/css/pages/dangnhap.css">
</head>

<body>
    <div class="login__container">
        <div class="login__form">
            <h1 class="login__form-title">Quên mật khẩu</h1>
            <form class="login__form-main" action="xuly/quenmatkhau.php" method="post">
                <div class="input-box">
                    <input type="email" name="email" placeholder=" " required>
                    <span>Email</span>
                </div>

                <button type="submit" name="submit">Tiếp tục</button>

                <a class="login__prev-login" href="index.php?page=dangnhap">Quay lại trang đăng nhập</a>
            </form>
        </div>
    </div>
</body>

</html>