<?php

function breadCrumb() {
    
    $root = '<a href="index.php">Trang chủ</a>';
    $page = $_GET['page'];
    return "<span class='bread-crumb'>$root > $page</span>";
}

?>

