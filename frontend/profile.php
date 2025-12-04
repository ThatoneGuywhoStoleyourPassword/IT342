<?php
$userId   = $_COOKIE['user_id'] ?? null;
$username = $_GET['user'] ?? ($_COOKIE['username'] ?? 'Guest');
$isLoggedIn = !empty($userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9 - <?= htmlspecialchars($username) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#ffffff; color:#111;}
        header { background:#e0f7fa; border-bottom:1px solid #b2ebf2; padding:1rem 2rem; display:flex; justify-content:flex-end; align-items:center;}
        .logo { position:absolute; left:2rem; font-weight:bold; font-size:1.5rem; color:#00bcd4; }
        nav a { color:#00bcd4; margin-left:1.5rem; text-decoration:none; font-weight:bold; }
        nav a:hover { text-decoration:underline; }
        .container { max-width:900px; margin:2rem auto; padding:0 1rem; }
        .profile-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; }
        .profile-name { font-size:1.5rem; color:#00bcd4; font-weight:bold; }
        .btn-link { color:#00bcd4; text-decoration:none; }
        .btn-link:hover { text-decoration:underline; }
        .card { background:#f0f9f9; border-radius:.75rem; border:1px solid #b2ebf2; padding:1rem; margin-bottom:1rem; }
        .card h3 { margin-top:0; margin-bottom:.4rem; font-size:1rem; }
        .meta { font-size:.85rem; color:#555; margin-bottom:.4rem; display:flex; gap:.5rem; flex-wrap:wrap;}
        .badge { padding:.1rem .5rem; border-radius:999px; font-size:.75rem; background:#00bcd4; color:#fff;}
        .badge.expiring { background:#e53935; }
        .badge.verified { background:#4caf50; }
        .blog-snippet { font-size:.9rem; color:#333; margin-bottom:.6rem; }
        .card-footer { display:flex; justify-content:space-between; align-items:center; font-size:.85rem; }
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
    <div class="profile-header">
        <div class="profile-name"><?= htmlspecialchars($username) ?></div>
        <?php if ($isLoggedIn && $username === $_COOKIE['username']): ?>
            <a class="btn-link" href="edit_profile.php">Edit Profile</a>
        <?php endif; ?>
    </div>

    <section>
        <h2 class="section-title">Blogs by <?= htmlspecialchars($username) ?></h2>
        <div class="card">
            <h3>Sample Blog Title</h3>
            <div class="meta">
                <span>2 hours ago</span>
                <span class="badge verified">Verified</span>
                <span class="badge expiring">Expires in 5 days</span>
            </div>
            <p class="blog-snippet">Short preview of the blog content...</p>
            <div class="card-footer">
                <a class="btn-link" href="blog_view.php?id=1">Read more</a>
                <span>123 views • 12 replies</span>
            </div>
        </div>
    </section>
</main>
</body>
</html>
