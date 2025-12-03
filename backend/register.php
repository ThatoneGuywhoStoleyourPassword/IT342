<?php
session_start();
require 'db.php';

$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$pass     = $_POST['password'] ?? '';
// FIXED: match the frontend field name
$confirm  = $_POST['password_confirm'] ?? '';

if (!$username || !$email || !$pass || !$confirm) {
    header("Location: /register.php?error=" . urlencode("All fields are required."));
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: /register.php?error=" . urlencode("Invalid email."));
    exit;
}

if ($pass !== $confirm) {
    header("Location: /register.php?error=" . urlencode("Passwords do not match."));
    exit;
}

$hash = password_hash($pass, PASSWORD_DEFAULT);

try {
    $stmt = $db->prepare(
        "INSERT INTO users (email, username, password_hash) VALUES (?, ?, ?)"
    );
    $stmt->execute([$email, $username, $hash]);

    // Auto-login
    $_SESSION['user_id']  = $db->lastInsertId();
    $_SESSION['username'] = $username;

    header("Location: /login.php?registered=1");
    exit;

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        header("Location: /register.php?error=" . urlencode("Username or email already exists."));
        exit;
    }
    // For debugging you can temporarily do:
    // die("DB error: " . $e->getMessage());
    throw $e;
}

