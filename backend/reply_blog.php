<?php
require 'db.php';
require 'email.php';
session_start();

$userId = $_SESSION['user_id'] ?? null;
if(!$userId) exit;

$blogId = $_POST['blog_id'] ?? '';
$content = $_POST['content'] ?? '';
if(!$blogId || !$content) exit;

$stmt = $db->prepare("INSERT INTO blog_replies (blog_id, user_id, content, created_at) VALUES (?,?,?,?)");
$stmt->execute([$blogId, $userId, $content, date('Y-m-d H:i:s')]);

$stmt = $db->prepare("SELECT u.email, u.username FROM blogs b JOIN users u ON b.user_id = u.id WHERE b.id=?");
$stmt->execute([$blogId]);
$author = $stmt->fetch(PDO::FETCH_ASSOC);

if($author){
    $link = "http://{$_SERVER['HTTP_HOST']}/blog_view.php?id=$blogId";
    send_email($author['email'], "New reply on your blog", "Someone replied to your blog: <a href='$link'>$link</a>");
}

header('Location: /blog_view.php?id='.$blogId);
exit;
