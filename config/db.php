<?php
$env = parse_ini_file(__DIR__ . '/.env');

$host = $env['DB_HOST'] ?? 'localhost';
$user = $env['DB_USER'] ?? 'root';
$pass = $env['DB_PASS'] ?? '';
$dbname = $env['DB_NAME'] ?? 'clothing_website';

// Danh sách port phổ biến có thể dùng
$ports = [3306, 3307, 3308];

$conn = null;
$connected = false;

foreach ($ports as $port) {
    $conn = @new mysqli($host, $user, $pass, $dbname, $port);
    if (!$conn->connect_errno) {
        $connected = true;
        break;
    }
}

if (!$connected) {
    die("Không thể kết nối MySQL ở các cổng: " . implode(', ', $ports));
}

