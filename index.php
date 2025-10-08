<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/pages/trangchu.css">
</head>

<body>

    <?php
    session_start();
    $page = $_GET['page'] ?? 'trangchu';


    // HEADER CHUNG CHO PAGES
    if ($page !== 'dangnhap' &&  $page !== 'dangky' && $page !== 'quenmatkhau' && $page !== 'doimatkhau') {
        include 'includes/header.php';
    }

    // ROUTER
    switch ($page) {
        case 'trangchu':
            include 'pages/trangchu.php';
            break;
        case 'ao':
            include 'pages/ao.php';
            break;

        case 'quan':
            include 'pages/quan.php';
            break;

        case 'phukien':
            include 'pages/phukien.php';
            break;

        case 'tintuc':
            include 'pages/tintuc.php';
            break;

        case 'lienhe':
            include 'pages/lienhe.php';
            break;

        case 'dangnhap':
            include 'pages/dangnhap.php';
            break;

        case 'dangky':
            include 'pages/dangky.php';
            break;

        case 'quenmatkhau':
            include 'pages/quenmatkhau.php';
            break;

        case 'doimatkhau':
            include 'pages/doimatkhau.php';
            break;

        default:
            include 'pages/404.php';
            break;
    }

    // FOOTER CHUNG CHO PAGES
    if ($page !== 'dangnhap' && $page !== 'dangky' && $page !== 'quenmatkhau' && $page !== 'doimatkhau') {
        include 'includes/footer.php';
    }

    ?>
</body>

</html>