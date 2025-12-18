<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$identifier = $_POST['email'] ?? '';
$password   = $_POST['password'] ?? '';

if (!$identifier || !$password) {
    header('Location: /login.php?error=All fields required');
    exit;
}

$stmt = $db->prepare("SELECT * FROM users WHERE email=? OR username=?");
$stmt->execute([$identifier, $identifier]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location: /login.php?error=Invalid credentials');
    exit;
}

// Remove email verification check
// if (!$user['verified']) {
//     header('Location: /login.php?error=Email not verified');
//     exit;
// }

$_SESSION['user_id']  = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['email']    = $user['email'];

header('Location: /index.php');
exit;
