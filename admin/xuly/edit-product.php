<?php

include __DIR__ . "/../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    die("Lỗi xảy ra");
}

// Lấy ra id
$product_id = $_POST['id'];

// Lấy các trường của products
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$type = $_POST['type'];

$targetDir = 'uploads/';
$photoOld = $_POST['photo_old'];
$newPhoto = "";

$fileName = $_FILES['photo_update']['name'];
$fileSize = $_FILES['photo_update']['size'];

$maxSize = 5 * 1024 * 1024;

if ($fileSize > $maxSize) {
    die("Kích thước file > 5MB. Vui lòng nhỏ hơn");
}

// Kiểm tra nếu không update file mới thì giữ nguyên file cũ
if ($fileName === '') {
    $newPhoto = $photoOld;
} else {
    $newPhoto = $targetDir . $fileName;
}

$sqlUpdateProduct = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, type = ? WHERE id = ?";
$stmt = $conn->prepare($sqlUpdateProduct);
$stmt->bind_param("sssssi", $name, $description, $price, $stock, $type, $product_id);

if ($stmt->execute()) {
    echo "Cập nhật sản phẩm thành công";
    header("Location: ../index.php?page=products");
    exit;
} else {
    die("Cập nhật không thành công");
}
