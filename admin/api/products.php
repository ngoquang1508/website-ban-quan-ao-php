<?php
require_once "../../config/db.php";
header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';
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

        // Xóa bản ghi có khóa ngoại với bảng favorites
        $delete_foreign_key_favorites = $conn->prepare("DELETE FROM favorites WHERE product_id = ?");
        $delete_foreign_key_favorites->bind_param("i", $id);
        $delete_foreign_key_favorites->execute();
        $delete_foreign_key_favorites->close();

        // Xóa bản ghi có khóa ngoại với bảng order_items
        $delete_foreign_key_order_items = $conn->prepare("DELETE FROM order_items WHERE product_id = ?");
        $delete_foreign_key_order_items->bind_param("i", $id);
        $delete_foreign_key_order_items->execute();
        $delete_foreign_key_order_items->close();

        // Xóa bản ghi tại bảng products
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
        $rows = isset($_POST['rows']) ? json_decode($_POST['rows'], true) : null;

        if (!$rows || !is_array($rows)) {
            echo json_encode([
                "status" => "error",
                "message" => "Dữ liệu Excel không hợp lệ!"
            ]);
            exit;
        }

        $success = 0;
        $fails = [];
        $products = [];

        foreach ($rows as $index => $p) {

            $name    = trim($p["name"] ?? "");
            $desc    = trim($p["description"] ?? "");
            $price   = floatval($p["price"] ?? 0);
            $stock   = intval($p["stock"] ?? 0);
            $type    = trim($p["type"] ?? "");
            $sexual  = trim($p["sexual"] ?? "");
            $imgUrl  = trim($p["url_image"] ?? "");

            // Check thiếu dữ liệu
            $missing = [];
            if (!$name)   $missing[] = "name";
            if (!$price)  $missing[] = "price";
            if (!$stock)  $missing[] = "stock";
            if (!$type)   $missing[] = "type";
            if (!$sexual) $missing[] = "sexual";

            if (!empty($missing)) {
                $fails[] = "Dòng " . ($index + 2) . " thiếu: " . implode(", ", $missing);
                continue;
            }

            // DOWNLOAD IMAGE
            $savedPath = "";
            if ($imgUrl !== "") {
                $ext = pathinfo(parse_url($imgUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: "jpg";
                $fileName = time() . "_" . uniqid() . "." . strtolower($ext);
                $localPath = "../../uploads/products/" . $fileName;

                $imgData = @file_get_contents($imgUrl);
                if ($imgData === false) {
                    $fails[] = "Dòng " . ($index + 2) . " không tải được ảnh: $imgUrl";
                } else {
                    file_put_contents($localPath, $imgData);
                    $savedPath = "uploads/products/" . $fileName;
                }
            }

            // INSERT DB
            $stmt = $conn->prepare("
            INSERT INTO products(name, description, price, stock, type, sexual, url_image)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
            $stmt->bind_param("ssdisss", $name, $desc, $price, $stock, $type, $sexual, $savedPath);

            if ($stmt->execute()) {
                $success++;
                $products[] = [
                    "id" => $stmt->insert_id,
                    "name" => $name,
                    "description" => $desc,
                    "price" => $price,
                    "stock" => $stock,
                    "type" => $type,
                    "sexual" => $sexual,
                    "url_image" => $savedPath
                ];
            } else {
                $fails[] = "Dòng " . ($index + 2) . " lỗi SQL: " . $stmt->error;
            }
        }

        // Trả JSON
        echo json_encode([
            "status" => "success",
            "message" => "Nhập thành công $success sản phẩm. Lỗi: " . count($fails),
            "fails" => $fails,
            "products" => $products
        ]);
        break;



    default:
        echo json_encode(['status' => 'error', 'message' => 'Action không hợp lệ']);
}
