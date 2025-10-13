<?php
session_start();
require_once "config/const.php";
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
    
    $page = $_GET['page'] ?? "trangchu";
    $file = "pages/$page" . ".php";

    // Ẩn header các trang auth
    if (!in_array($page, ['dangnhap', 'dangky', 'quenmatkhau', 'doimatkhau'])) {
        require_once 'includes/header.php';
    }

    if (file_exists($file)) {
        require $file;
    } else {
        require 'pages/404.php';
    }

    // Ẩn footer các trang auth
    if (!in_array($page, ['dangnhap', 'dangky', 'quenmatkhau', 'doimatkhau'])) {
        require_once 'includes/footer.php';
    }
    
    ?>
</body>

</html>