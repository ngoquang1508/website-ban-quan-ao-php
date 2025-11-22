<?php
require_once "../../config/db.php";
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$uploadDir = '../../uploads/products/';

if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

switch ($action) {
    case 'add':
        $name = $_POST['name'] ?? '';
        $desc = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;
        $stock = $_POST['stock'] ?? 0;
        $type = $_POST['type'] ?? '';
        $sexual = $_POST['sexual'] ?? '';

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName);
            $url_image = "uploads/products/" . $fileName;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Chưa chọn ảnh']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO products(name, description, price, stock, type, sexual, url_image) VALUES(?,?,?,?,?,?,?)");
        $stmt->bind_param("ssidsss", $name, $desc, $price, $stock, $type, $sexual, $url_image);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'product' => [
                'id' => $stmt->insert_id,
                'name' => $name,
                'description' => $desc,
                'price' => $price,
                'stock' => $stock,
                'type' => $type,
                'sexual' => $sexual,
                'url_image' => $url_image
            ]]);
        } else echo json_encode(['status' => 'error', 'message' => 'Thêm thất bại']);
        break;

    case 'edit':
        $id = $_POST['id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $desc = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;
        $stock = $_POST['stock'] ?? 0;
        $type = $_POST['type'] ?? '';
        $sexual = $_POST['sexual'] ?? '';
        $url_image = '';

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName);
            $url_image = "uploads/products/" . $fileName;
        }

        if ($url_image) {
            $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, stock=?, type=?, sexual=?, url_image=? WHERE id=?");
            $stmt->bind_param("ssidsssi", $name, $desc, $price, $stock, $type, $sexual, $url_image, $id);
        } else {
            $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, stock=?, type=?, sexual=? WHERE id=?");
            $stmt->bind_param("ssidssi", $name, $desc, $price, $stock, $type, $sexual, $id);
        }

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'url_image' => $url_image]);
        } else echo json_encode(['status' => 'error', 'message' => 'Cập nhật thất bại']);
        break;

    case 'delete':
        header('Content-Type: application/json; charset=utf-8');

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ']);
            exit;
        }

        // Lấy url_image trước khi xóa
        $stmt = $conn->prepare("SELECT url_image FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $product = $res->fetch_assoc();
        $stmt->close();

        if (!$product) {
            echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);
            exit;
        }

        // Xóa file ảnh nếu tồn tại
        $filePath = "../../" . $product['url_image'];
        if (file_exists($filePath) && is_file($filePath)) {
            @unlink($filePath); // @ để tránh warning nếu lỗi
        }

        // Xóa bản ghi
        $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Xóa thất bại']);
        }
        $stmt->close();
        break;

    case "importExcel":
        // Lấy JSON từ body
        $json = file_get_contents("php://input");
        $rows = json_decode($json, true);

        if (!$rows || !is_array($rows)) {
            echo json_encode([
                "status" => "error",
                "message" => "Dữ liệu Excel không hợp lệ!",
                "raw" => $json
            ]);
            exit;
        }

        $success = 0;
        $fails = [];

        foreach ($rows as $index => $p) {
            // Chuẩn hóa dữ liệu
            $name    = trim($p["name"] ?? "");
            $desc    = trim($p["description"] ?? "");
            $price   = floatval($p["price"] ?? 0);
            $stock   = intval($p["stock"] ?? 0);
            $type    = trim($p["type"] ?? "");
            $sexual  = trim($p["sexual"] ?? "");
            $img     = trim($p["image_url"] ?? "");

            // Debug log
            file_put_contents("php://stderr", "Row " . ($index + 2) . ": " . json_encode($p) . "\n");

            // Kiểm tra dữ liệu bắt buộc
            $missing = [];
            if (!$name) $missing[] = "name";
            if (!$price) $missing[] = "price";
            if (!$stock) $missing[] = "stock";
            if (!$type) $missing[] = "type";
            if (!$sexual) $missing[] = "sexual";

            if (!empty($missing)) {
                $fails[] = "Dòng " . ($index + 2) . " thiếu dữ liệu: " . implode(", ", $missing);
                continue;
            }

            // Insert DB
            $stmt = $conn->prepare("
            INSERT INTO products(name, description, price, stock, type, sexual, url_image)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
            $stmt->bind_param("ssdisss", $name, $desc, $price, $stock, $type, $sexual, $img);

            if ($stmt->execute()) {
                $success++;
            } else {
                $fails[] = "Dòng " . ($index + 2) . " lỗi SQL: " . $stmt->error;
            }
        }

        echo json_encode([
            "status" => "success",
            "message" => "Nhập thành công $success sản phẩm. Lỗi: " . count($fails),
            "fails" => $fails
        ]);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Action không hợp lệ']);
}
