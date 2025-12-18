<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$userId = $_SESSION['user_id'] ?? null;
if(!$userId) exit;

$receiver_id = $_POST['receiver_id'] ?? '';
$content = $_POST['content'] ?? '';
if(!$receiver_id || !$content) exit;

$stmt = $db->prepare("SELECT id FROM threads WHERE (user1_id=? AND user2_id=?) OR (user1_id=? AND user2_id=?)");
$stmt->execute([$userId, $receiver_id, $receiver_id, $userId]);
$thread = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$thread){
    $stmt = $db->prepare("INSERT INTO threads (user1_id, user2_id, last_message, updated_at) VALUES (?,?,?,?)");
    $stmt->execute([$userId, $receiver_id, $content, date('Y-m-d H:i:s')]);
    $thread_id = $db->lastInsertId();
} else {
    $thread_id = $thread['id'];
}

$stmt = $db->prepare("INSERT INTO messages (thread_id, sender_id, receiver_id, content, created_at) VALUES (?,?,?,?,?)");
$stmt->execute([$thread_id, $userId, $receiver_id, $content, date('Y-m-d H:i:s')]);

$stmt = $db->prepare("UPDATE threads SET last_message=?, updated_at=? WHERE id=?");
$stmt->execute([$content, date('Y-m-d H:i:s'), $thread_id]);

header('Location: /inbox.php');
