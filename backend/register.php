<?php
require 'db.php';

$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if(!$email || !$username || !$password || !$password_confirm) {
    header('Location: ../frontend/register.php?error=All fields are required');
    exit;
}

if($password !== $password_confirm) {
    header('Location: ../frontend/register.php?error=Passwords do not match');
    exit;
}

// Check if email or username already exists
$stmt = $db->prepare("SELECT id FROM users WHERE email=? OR username=?");
$stmt->execute([$email, $username]);
if($stmt->fetch()) {
    header('Location: ../frontend/register.php?error=Email or username already taken');
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $db->prepare("INSERT INTO users (email, username, password_hash) VALUES (?,?,?)");
$stmt->execute([$email, $username, $password_hash]);

// Send verification email
$token = bin2hex(random_bytes(16));
$stmt = $db->prepare("INSERT INTO email_verifications (user_id, token) VALUES (?,?)");
$stmt->execute([$db->lastInsertId(), $token]);

mail($email, "Verify your Cloud9 account",
    "Click this link to verify: http://IT342-Project-ALB-1012094198.us-east-2.elb.amazonaws.com/api/verify_email.php?token=$token");

header('Location: ../frontend/login.php?success=Check your email for verification');
exit;
