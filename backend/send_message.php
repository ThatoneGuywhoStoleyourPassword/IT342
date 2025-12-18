<?php
require 'db.php';
session_start();

$userId = $_SESSION['user_id'] ?? null;
if(!$userId) exit;

$thread_id = $_POST['thread_id'] ?? '';
$content = $_POST['content'] ?? '';
if(!$thread_id || !$content) exit;

// Insert message
$stmt = $db->prepare("INSERT INTO messages (thread_id, sender_id, content, created_at) VALUES (?,?,?,?)");
$stmt->execute([$thread_id, $userId, $content, date('Y-m-d H:i:s')]);

// Update thread last_message
$update = $db->prepare("UPDATE threads SET last_message=?, updated_at=? WHERE id=?");
$update->execute([$content, date('Y-m-d H:i:s'), $thread_id]);

header('Location: ../frontend/inbox.php');
