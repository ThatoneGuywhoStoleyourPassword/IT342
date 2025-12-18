<?php
require 'db.php';
require 'email.php';

$token = $_GET['token'] ?? '';
if(!$token) { die("Invalid verification token."); }

$stmt = $db->prepare("SELECT user_id FROM email_verifications WHERE token=?");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user) { die("Invalid or expired verification token."); }

$update = $db->prepare("UPDATE users SET verified=1 WHERE id=?");
$update->execute([$user['user_id']]);

$stmt = $db->prepare("DELETE FROM email_verifications WHERE token=?");
$stmt->execute([$token]);

echo "Email verified! You can now <a href='/login.php'>login</a>.";
