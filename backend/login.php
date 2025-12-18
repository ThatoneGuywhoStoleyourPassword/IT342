<?php
require 'db.php';
session_start();

$identifier = $_POST['email'] ?? ''; 
$password = $_POST['password'] ?? ''; 

if(!$identifier || !$password) {
    header('Location: ../frontend/login.php?error=All fields required'); 
    exit; 
} 

$stmt = $db->prepare("SELECT * FROM users WHERE email=? OR username=?"); 
$stmt->execute([$identifier, $identifier]); 
$user = $stmt->fetch(PDO::FETCH_ASSOC); 

if(!$user || !password_verify($password, $user['password_hash'])) { 
    header('Location: ../frontend/login.php?error=Invalid credentials'); 
    exit; 
} 

if(!$user['verified']) { 
    header('Location: ../frontend/login.php?error=Email not verified'); 
    exit; 
} 

$_SESSION['user_id'] = $user['id']; 
$_SESSION['username'] = $user['username']; 

header('Location: ../frontend/index.php'); 
exit;