<?php
require 'db.php';
$code = $_GET['code'] ?? '';

if(!$code) { die("Invalid verification code."); }

$stmt = $db->prepare("SELECT id FROM users WHERE verification_code=?");
$stmt->execute([$code]);
$user = $stmt->fetch();

if(!$user) {
    die("Invalid verification code.");
}

// Update user to verified
$update = $db->prepare("UPDATE users SET is_verified=1, verification_code=NULL WHERE id=?");
$update->execute([$user['id']]);

echo "Email verified! You can now <a href='/login.php'>login</a>.";
