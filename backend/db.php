<?php
// Database connection
$host = '10.0.21.56';
$dbname = 'cloud9';
$user = 'cloud9user';
$pass = 'cloud9pass';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
