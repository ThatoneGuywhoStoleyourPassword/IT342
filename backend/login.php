<?php
session_start();
require 'db.php';

$login = trim($_POST['email'] ?? '');
$pass  = $_POST['password'] ?? '';

if (!$login || !$pass) {
    die("Missing credentials.");
}

$stmt = $db->prepare(
    "SELECT id, username, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1"
);
$stmt->execute([$login, $login]);
$user = $stmt->fetch();

if (!$user) {
    die("Invalid login.");
}

if (!password_verify($pass, $user['password_hash'])) {
    die("Invalid login.");
}

session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];

// 🔑 Simple cookie-based "session" for frontend
$cookieLifetime = time() + 3600; // 1 hour

setcookie('user_id', $user['id'], $cookieLifetime, '/', '', false, true);
setcookie('username', $user['username'], $cookieLifetime, '/', '', false, true);


header("Location: /index.php");
exit;

