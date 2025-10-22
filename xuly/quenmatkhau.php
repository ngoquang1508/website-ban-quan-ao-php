<?php
include_once __DIR__ . "/../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $email = $_POST['email'];

    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<p>Email không hợp lệ</p>";
        exit;
    }
}

$stmt->close();
$conn->close();

header("Location: ../?page=doimatkhau&email=" . urlencode($email));
exit;