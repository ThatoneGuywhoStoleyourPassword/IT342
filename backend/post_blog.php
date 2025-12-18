<?php
require 'db.php';
session_start();

$userId = $_SESSION['user_id'] ?? null;
if(!$userId) exit;

$title = $_POST['title'] ?? '';
$content = $_POST['content'] ?? '';
$isCloud = isset($_POST['cloud_blog']) ? 1 : 0;
$imagePath = null;

if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imagePath = 'uploads/' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../'.$imagePath);
}

$expires_at = $isCloud ? date('Y-m-d H:i:s', time() + 24*60*60) : null;

$stmt = $db->prepare("INSERT INTO blogs (user_id, title, content, image, cloud_blog, expires_at, created_at) VALUES (?,?,?,?,?,?,?)");
$stmt->execute([$userId, $title, $content, $imagePath, $isCloud, $expires_at, date('Y-m-d H:i:s')]);

// Notify followers by email
$stmt = $db->prepare("SELECT u.email FROM follows f JOIN users u ON f.follower_id = u.id WHERE f.following_id=?");
$stmt->execute([$userId]);
$followers = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($followers as $follower){
    mail($follower['email'], "New blog from ".$_SESSION['username'],
        "Check out the new blog: http://IT342-Project-ALB-1012094198.us-east-2.elb.amazonaws.com/frontend/blog_view.php?id=".$db->lastInsertId());
}

header('Location: /profile.php');
