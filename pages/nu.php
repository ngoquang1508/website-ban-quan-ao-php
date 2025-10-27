<?php
require "config/db.php";
require "includes/product-card.php";
$sql = "SELECT * FROM products WHERE sexual='Nữ'";
$stmt_get_all = $conn->prepare($sql);
$stmt_get_all->execute();
$result = $stmt_get_all->get_result();
?>

<div>
    <div class="products">
        <?php while ($row = $result->fetch_assoc()) {
            echo ProductCard($row['id'], $row['name'], $row['price'], $row['url_image']);
        } ?>
    </div>
</div>