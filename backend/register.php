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

// Set verified = 1 so users don't need email verification
$stmt = $db->prepare("INSERT INTO users (email, username, password_hash, verified) VALUES (?,?,?,1)");
$stmt->execute([$email, $username, $password_hash]);

// Skip email verification entirely
header('Location: /login.php?success=Account created, you can now login');
exit;
