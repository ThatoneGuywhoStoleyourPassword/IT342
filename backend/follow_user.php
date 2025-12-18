<?php
require 'auth.php';
require 'db.php';
require 'email.php';

$followUserId = $_POST['follow_user_id'] ?? null;
if (!$followUserId) die("Missing user id.");

$stmt = $db->prepare("INSERT IGNORE INTO follows (follower_id, following_id) VALUES (?, ?)");
$stmt->execute([$_SESSION['user_id'], $followUserId]);

// Notify the followed user
$stmt = $db->prepare("SELECT email, username FROM users WHERE id=?");
$stmt->execute([$followUserId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if($user){
    send_email($user['email'], "New follower on Cloud9", "User @{$_SESSION['username']} started following you!");
}

header("Location: /profile.php?user_id=$followUserId");
exit;
