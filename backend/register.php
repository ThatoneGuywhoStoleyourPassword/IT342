<?php
require 'db.php';
require 'email.php';

$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if(!$email || !$username || !$password || !$password_confirm) {
    header('Location: /register.php?error=All fields are required');
    exit;
}

if($password !== $password_confirm) {
    header('Location: /register.php?error=Passwords do not match');
    exit;
}

$stmt = $db->prepare("SELECT id FROM users WHERE email=? OR username=?");
$stmt->execute([$email, $username]);
if($stmt->fetch()) {
    header('Location: /register.php?error=Email or username already taken');
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $db->prepare("INSERT INTO users (email, username, password_hash, verified) VALUES (?,?,?,0)");
$stmt->execute([$email, $username, $password_hash]);

$token = bin2hex(random_bytes(16));
$stmt = $db->prepare("INSERT INTO email_verifications (user_id, token) VALUES (?,?)");
$stmt->execute([$db->lastInsertId(), $token]);

$verify_link = "http://{$_SERVER['HTTP_HOST']}/backend/verify_email.php?token=$token";
$subject = "Verify your Cloud9 account";
$body = "Click this link to verify your account: <a href='$verify_link'>$verify_link</a>";

send_email($email, $subject, $body);

header('Location: /login.php?success=Check your email for verification');
exit;
