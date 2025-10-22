
<?php

include __DIR__ . "/../../config/db.php";

if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    $sql_edit = "UPDATE users SET username = ?, email = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_edit);
    $stmt->bind_param("sssi", $username, $email, $status, $id);

    if ($stmt->execute()) {
        header("Location: ../?page=users");
        exit;
    } else {
        echo "<span>Cập nhật thất bại!</span>";
    }
    $stmt->close();
}


?>