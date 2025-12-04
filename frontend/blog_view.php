<?php
$userId   = $_COOKIE['user_id'] ?? null;
$username = $_COOKIE['username'] ?? 'Guest';
$isLoggedIn = !empty($userId);
$blogId = $_GET['id'] ?? 1;
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
        .blog-title { font-size:1.5rem; color:#00bcd4; margin-bottom:.5rem; }
        .meta { font-size:.85rem; color:#555; margin-bottom:1rem; display:flex; gap:.5rem; flex-wrap:wrap;}
        .badge { padding:.1rem .5rem; border-radius:999px; font-size:.75rem; background:#00bcd4; color:#fff;}
        .badge.expiring { background:#e53935; }
        .badge.verified { background:#4caf50; }
        .blog-content { font-size:1rem; line-height:1.5; color:#111; }
    </style>
</head>
<body>
<header>
    <div class="logo">Cloud9</div>
    <nav>
        <?php if ($isLoggedIn): ?>
            <a href="index.php">Home</a>
            <a href="browse.php">Browse</a>
            <a href="inbox.php">DMs</a>
            <a href="profile.php">My Profile</a>
            <a href="/api/logout.php">Logout</a>
        <?php else: ?>
            <a href="index.php">Home</a>
            <a href="browse.php">Browse</a>
            <a href="login.php">Login</a>
            <a href="register.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <h1 class="blog-title">Sample Blog Title</h1>
    <div class="meta">
        <span>by <a href="profile.php?user=john_doe" class="btn-link">john_doe</a></span>
        <span>2 hours ago</span>
        <span class="badge verified">Verified</span>
    </div>
    <div class="blog-content">
        <p>This is the full blog content. Users can read all of it here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque nisi eu felis blandit, eget egestas leo cursus.</p>
        <p>Additional paragraphs of content would appear here...</p>
    </div>
</main>
</body>
</html>
