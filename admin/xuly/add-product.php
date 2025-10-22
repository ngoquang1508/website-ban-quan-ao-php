<?php

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Có lỗi xảy ra";
}

// XỬ LÝ UPLOAD FILE ẢNH
if (!isset($_FILES["photo"]) && $_FILES["photo"]["error"] !== 0) {
    echo $_FILES['photo']['error'];
}

$filename = $_FILES['photo']['name'];
$filetype = $_FILES['photo']['type'];
$filesize = $_FILES['photo']['size'];

// Lấy đuôi file
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

// Vị trí lưu file
$targetDir = '../uploads/';

// Giới hạn dung lượng file < 5mb;
$maxsize = 2 * 1024 * 1024;
if ($filesize > $maxsize) {
    die("Dung lượng file lớn hớn 2MB: " . $filesize);
}

// Đảm bảo thư mục /uploads tồn tại
if (!is_dir($targetDir)) {
    mkdir("../../uploads", 0777, true);
}

// upload file
if (move_uploaded_file($_FILES['photo']['tmp_name'], "../" . $targetDir . $filename)) {
    echo "Tải ảnh thành công!";
} else {
    die("Lỗi không di chuyển ảnh đến thư mục");
}


$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$type = $_POST['type'];
$url = $targetDir . $filename;


$sql_add_product = "INSERT INTO products(name, description, price, stock, type, url_image) VALUES(?,?,?,?,?,?)";
$stmt = $conn->prepare($sql_add_product);
$stmt->bind_param("ssssss", $name, $description, $price, $stock, $type, $url);
if($stmt->execute()) {
    echo "Thêm sản phẩm thành công";
    header("Location: ../?page=products");
    exit;
} else {
    die("Thêm sản phẩm thất bại");
}