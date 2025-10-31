<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    
</head>

<body>
    <?php

    $page = $_GET['page'] ?? "trang-chu";
    $file = "pages/$page" . ".php";

    // header chung
    require_once 'includes/header.php';
    ?>

    <!-- Nội dung chính -->
    <main>
        <?php
        if ($page == "trang-chu") {
            require "includes/banner.php";
        }
        ?>

        <div class="main__content">
            <!-- bread crumb -->
            <?php
            require "includes/functions.php";
            if ($page !== "trang-chu") {
                echo breadCrumb($page);
            }
            ?>


            <?php
            if (file_exists($file)) {
                require $file;
            } else {
                require 'pages/404.php';
            }
            ?>
        </div>

    </main>

    <?php

    // footer chung
    require_once 'includes/footer.php';

    ?>
</body>

</html>