<?php
$userId   = $_COOKIE['user_id'] ?? null;
$username = $_COOKIE['username'] ?? 'Guest';
$isLoggedIn = !empty($userId);
if (!$isLoggedIn) { header('Location: login.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#ffffff; color:#111;}
        header { background:#e0f7fa; border-bottom:1px solid #b2ebf2; padding:1rem 2rem; display:flex; justify-content:flex-end; align-items:center;}
        .logo { position:absolute; left:2rem; font-weight:bold; font-size:1.5rem; color:#00bcd4; }
        nav a { color:#00bcd4; margin-left:1.5rem; text-decoration:none; font-weight:bold; }
        nav a:hover { text-decoration:underline; }
        .container { max-width:900px; margin:2rem auto; padding:0 1rem; }
        .card { background:#f0f9f9; border-radius:.75rem; border:1px solid #b2ebf2; padding:1rem; margin-bottom:1rem; display:flex; justify-content:space-between; align-items:center; }
        .card h3 { margin:0; font-size:1rem; }
        .btn-link { color:#00bcd4; text-decoration:none; }
        .btn-link:hover { text-decoration:underline; }
        .message-meta { font-size:.85rem; color:#555; }
    </style>
</head>
<body>
<header>
    <div class="logo">Cloud9</div>
    <nav>
        <a href="index.php">Home</a>
        <a href="browse.php">Browse</a>
        <a href="inbox.php">DMs</a>
        <a href="profile.php">My Profile</a>
        <a href="/api/logout.php">Logout</a>
    </nav>
</header>

<main class="container">
    <h2 class="section-title">Inbox</h2>
    <div class="card">
        <div>
            <h3><a class="btn-link" href="chat.php?user=jane_doe">jane_doe</a></h3>
            <div class="message-meta">2 hours ago • New message</div>
        </div>
        <a class="btn-link" href="chat.php?user=jane_doe">Open</a>
    </div>
</main>
</body>
</html>
