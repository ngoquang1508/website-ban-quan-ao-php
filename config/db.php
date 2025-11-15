<?php
$env = parse_ini_file(__DIR__ . '/.env');

$host = $env['DB_HOST'];
$user = $env['DB_USER'];
$pass = $env['DB_PASS'];
$dbname = $env['DB_NAME'];
// $port = isset($env['DB_PORT']) ? $env['DB_PORT'] : 3306; // default 3306

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
