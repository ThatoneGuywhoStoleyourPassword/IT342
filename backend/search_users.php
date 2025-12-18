<?php
require 'auth.php';
require 'db.php';
header('Content-Type: application/json');

$q = $_GET['q'] ?? '';
$userId = $_SESSION['user_id'] ?? 0;
if(!$q) { echo json_encode([]); exit; }

$stmt = $db->prepare("SELECT id, username FROM users WHERE username LIKE ? AND id != ?");
$stmt->execute(["%$q%", $userId]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
