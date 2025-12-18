<?php
session_start();
$userId   = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;
$blogId = $_GET['id'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cloud9 - Blog</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { margin:0; font-family: Arial, sans-serif; background:#ffffff; color:#111;}
header { background:#e0f7fa; border-bottom:1px solid #b2ebf2; padding:1rem 2rem; display:flex; justify-content:flex-end; align-items:center;}
.logo { position:absolute; left:2rem; font-weight:bold; font-size:1.5rem; color:#00bcd4; }
nav a { color:#00bcd4; margin-left:1.5rem; text-decoration:none; font-weight:bold; }
nav a:hover { text-decoration:underline; }
.container { max-width:900px; margin:2rem auto; padding:0 1rem; }
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
        <a href="../backend/logout.php">Logout</a>
    </nav>
</header>

<main class="container">
    <!-- Blog content will load here dynamically -->
</main>
</body>
</html>