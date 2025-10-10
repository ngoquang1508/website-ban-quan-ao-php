<?php
session_start();
require "config/const.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>assets/css/index.css">
    <link rel="stylesheet" href="<?= ROOT ?>assets/css/pages/trangchu.css">
</head>

<body>

    <?php
    $page = $_GET['page'] ?? 'trangchu';
    $file = "pages/$page.php";

    // HEADER CHUNG CHO PAGES
    if ($page !== 'dangnhap' &&  $page !== 'dangky' && $page !== 'quenmatkhau' && $page !== 'doimatkhau') {
        require_once __DIR__ . '/includes/header.php';
    }

    // ROUTER
    switch ($page) {
        case 'trangchu':
            require __DIR__ . '/pages/trangchu.php';
            break;
        case 'ao':
            require __DIR__ . '/pages/ao.php';
            break;

        case 'quan':
            require __DIR__ . '/pages/quan.php';
            break;

        case 'phukien':
            require __DIR__ . '/pages/phukien.php';
            break;

        case 'tintuc':
            require __DIR__ . '/pages/tintuc.php';
            break;

        case 'lienhe':
            require __DIR__ . '/pages/lienhe.php';
            break;

        case 'dangnhap':
            require __DIR__ . '/pages/dangnhap.php';
            break;

        case 'dangky':
            require __DIR__ . '/pages/dangky.php';
            break;

        case 'quenmatkhau':
            require __DIR__ . '/pages/quenmatkhau.php';
            break;

        case 'doimatkhau':
            require __DIR__ . '/pages/doimatkhau.php';
            break;

        default:
            require __DIR__ . '/pages/404.php';
            break;
    }

    // FOOTER CHUNG CHO PAGES
    if ($page !== 'dangnhap' && $page !== 'dangky' && $page !== 'quenmatkhau' && $page !== 'doimatkhau') {
        require_once __DIR__ . '/includes/footer.php';
    }

    ?>
</body>

</html>