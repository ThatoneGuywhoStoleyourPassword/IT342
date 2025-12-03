<?php
$dsn = 'mysql:host=10.0.21.56;dbname=blog;charset=utf8mb4';
$dbUser = 'admin';           
$dbPass = 'IT342Pass!';

try {
    $db = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}

