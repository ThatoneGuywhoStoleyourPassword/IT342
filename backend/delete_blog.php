<?php
require 'auth.php';
require 'db.php';

$blogId = $_POST['blog_id'] ?? null;
$userId = $_SESSION['user_id'];

if (!$blogId) {
    http_response_code(400);
    exit;
}

// Ensure ownership
$stmt = $db->prepare("SELECT id FROM blogs WHERE id=? AND user_id=?");
$stmt->execute([$blogId, $userId]);

if (!$stmt->fetch()) {
    http_response_code(403);
    exit;
}

// Delete blog
$stmt = $db->prepare("DELETE FROM blogs WHERE id=?");
$stmt->execute([$blogId]);

echo "OK";
