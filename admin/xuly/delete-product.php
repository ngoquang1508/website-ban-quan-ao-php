<?php

include __DIR__ . "/../../config/db.php";

$product_id = $_GET['id'];

$sql_delete_product = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql_delete_product);
$stmt->bind_param("i", $product_id);

$sql_select_file = "SELECT url_image FROM products WHERE id = ?";
$stmt_file = $conn->prepare($sql_select_file);
$stmt_file->bind_param("i", $product_id);
$stmt_file->execute();
$product = $stmt_file->get_result()->fetch_assoc();

$target_file_uploads = '../' . $product['url_image'];

if (!file_exists($target_file_uploads)) {
    echo "Lỗi không tìm thấy thư mục lưu file";
    exit;
}

if (!$stmt->execute()) {
    echo "Xóa sản phẩm thất bại";
    exit;
}

unlink($target_file_uploads);

$stmt_file->close();
$stmt->close();
header("Location: ../?page=products");
exit;

