<?php
session_start();

// Check admin login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../?page=dangnhap");
    exit;
}

// Lấy tham số page và action
$page   = $_GET['page']   ?? 'dashboard';
$action = $_GET['action'] ?? null;

// Định nghĩa routes
$routes = [
    "dashboard" => [
        "index" => "pages/dashboard.php",
    ],
    "users" => [
        "list" => "pages/users/list.php",
        "add"  => "pages/users/add.php",
        "edit" => "pages/users/edit.php",
    ],
    "products" => [
        "list" => "pages/products/list.php",
        "add"  => "pages/products/add.php",
        "edit" => "pages/products/edit.php",
    ],
];

// Nếu chưa có action thì set mặc định
if ($action === null) {
    if (isset($routes[$page]['index'])) {
        $action = 'index'; // fallback nếu page có action index
    } else {
        $action = array_key_first($routes[$page] ?? []); // lấy action đầu tiên
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/users.css">
    <link rel="stylesheet" href="assets/css/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <?php include "includes/nav.php"; ?>

    <main>
        <?php include "includes/header.php"; ?>

        <?php
            if (isset($routes[$page][$action])) {
                include $routes[$page][$action];
            } else {
                include "pages/404.php";
            }
        ?>
    </main>

    <script>
        const btnL = document.querySelector('.main_header-btn');
        const nav = document.querySelector('nav');
        const main = document.querySelector('main');
        const navHeader = document.querySelector('.nav__header');

        btnL.addEventListener('click', function() {
            nav.classList.toggle('active');
            navHeader.classList.toggle('active');
            main.classList.toggle('active');
            btnL.classList.toggle('active');
        })
    </script>
</body>

</html>