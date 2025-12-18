<?php
require 'auth.php';
require 'db.php';

$followUserId = $_POST['follow_user_id'] ?? null;
if (!$followUserId) die("Missing user id.");

$stmt = $db->prepare("INSERT IGNORE INTO follows (follower_id, following_id) VALUES (?, ?)");
$stmt->execute([$_SESSION['user_id'], $followUserId]);

header("Location: /profile.php?user_id=$followUserId");
exit;
