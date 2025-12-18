<?php
require 'db.php';
require 'email.php';
session_start();

$userId = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;
if(!$userId) exit;

$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';
$isCloud = isset($_POST['cloud_blog']) ? 1 : 0;
$imagePath = null;

if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imagePath = 'uploads/' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../' . $imagePath);
}

$expires_at = $isCloud ? date('Y-m-d H:i:s', time() + 24*60*60) : null;

$stmt = $db->prepare("INSERT INTO blogs (user_id, title, content, image, is_cloud_blog, expires_at, created_at) VALUES (?,?,?,?,?,?,?)");
$stmt->execute([$userId, $title, $content, $imagePath, $isCloud, $expires_at, date('Y-m-d H:i:s')]);

// Notify followers
$stmt = $db->prepare("SELECT u.email FROM follows f JOIN users u ON f.follower_id = u.id WHERE f.following_id=?");
$stmt->execute([$userId]);
$followers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$blogId = $db->lastInsertId();
$link = "http://{$_SERVER['HTTP_HOST']}/blog_view.php?id=$blogId";
foreach($followers as $follower){
    send_email($follower['email'], "New blog from $username", "Check out the new blog: <a href='$link'>$link</a>");
}

header('Location: /profile.php');
exit;
