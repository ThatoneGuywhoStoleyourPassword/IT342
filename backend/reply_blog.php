<?php
require 'db.php';
session_start();

$userId = $_SESSION['user_id'] ?? null;
if(!$userId) exit;

$blogId = $_POST['blog_id'] ?? '';
$content = $_POST['content'] ?? '';
if(!$blogId || !$content) exit;

$stmt = $db->prepare("INSERT INTO blog_replies (blog_id, user_id, content, created_at) VALUES (?,?,?,?)");
$stmt->execute([$blogId, $userId, $content, date('Y-m-d H:i:s')]);

// Notify blog author
$stmt = $db->prepare("SELECT u.email FROM blogs b JOIN users u ON b.user_id = u.id WHERE b.id=?");
$stmt->execute([$blogId]);
$author = $stmt->fetch(PDO::FETCH_ASSOC);
if($author){
    mail($author['email'], "New reply on your blog",
        "Someone replied to your blog: http://IT342-Project-ALB-1012094198.us-east-2.elb.amazonaws.com/frontend/blog_view.php?id=$blogId");
}

header('Location: ../frontend/blog_view.php?id='.$blogId);
