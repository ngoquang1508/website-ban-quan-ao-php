<?php

include __DIR__ . "/../../config/db.php";

$product_id = $_GET['id'];

$sql_delete_product = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql_delete_product);
$stmt->bind_param("i", $product_id);

if (!$stmt->execute()) {
    echo "Xóa sản phẩm thất bại";
    exit;
}
$stmt->close();
header("Location: ../index.php?page=products");
exit;

