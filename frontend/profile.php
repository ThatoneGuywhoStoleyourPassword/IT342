<?php
$userId   = $_COOKIE['user_id'] ?? null;
$username = $_COOKIE['username'] ?? 'Guest';
$isLoggedIn = !empty($userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9 - Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#ffffff; color:#111; }
        header { background:#e0f7fa; border-bottom:1px solid #b2ebf2; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; }
        .logo { font-weight:bold; font-size:1.5rem; color:#00bcd4; }
        nav a { color:#00bcd4; margin-left:1rem; text-decoration:none; font-weight:bold; }
        nav a:hover { text-decoration:underline; }
        .container { max-width:900px; margin:1.5rem auto; padding:0 1rem; }
        .profile-header { display:flex; gap:1.5rem; align-items:flex-start; }
        .avatar { width:72px; height:72px; border-radius:999px; background:#b2ebf2; }
        .badge { padding:.15rem .6rem; border-radius:999px; font-size:.7rem; background:#00bcd4; color:#fff; margin-left:.5rem; }
        .badge.verified { background:#4caf50; }
        .actions { margin-top:.6rem; display:flex; gap:.5rem; flex-wrap:wrap; }
        .btn { border:none; border-radius:.5rem; padding:.4rem .9rem; cursor:pointer; font-size:.85rem; }
        .btn.primary { background:#00bcd4; color:#fff; }
        .btn.outline { background:transparent; border:1px solid #00bcd4; color:#111; }
        .stats { display:flex; gap:1.5rem; margin-top:.6rem; font-size:.85rem; color:#555; }
        .section-title { margin:1.5rem 0 .7rem; font-size:1rem; color:#111; }
        .blog-list { display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); }
        .card { background:#f0f9f9; border-radius:.75rem; padding:1rem; border:1px solid #b2ebf2; }
        .card h3 { margin-top:0; font-size:1rem; }
        .card p { font-size:.9rem; color:#333; }
        .btn-link { color:#00bcd4; text-decoration:none; font-size:.9rem; }
        .btn-link:hover { text-decoration:underline; }
    </style>
</head>
<body>
<header>
    <div class="logo">Cloud9</div>
    <nav>
        <a href="index.php">Home</a>
        <a href="browse.php">Explore</a>
        <a href="inbox.php">DMs</a>
        <a href="profile.php">My Profile</a>
        <?php if ($isLoggedIn): ?>
            <a href="/api/logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <section class="profile-header">
        <div class="avatar"></div>
        <div>
            <h1>@<?= htmlspecialchars($username) ?> <span class="badge verified">Verified</span></h1>
            <p>Welcome to your Cloud9 profile, <?= htmlspecialchars($username) ?>.</p>
            <div class="actions">
                <button class="btn primary">Follow</button>
                <button class="btn outline">Message</button>
            </div>
            <div class="stats">
                <span>42 blogs</span>
                <span>120 followers</span>
                <span>88 following</span>
            </div>
        </div>
    </section>

    <section>
        <h2 class="section-title">Recent blogs</h2>
        <div class="blog-list">
            <article class="card">
                <h3>AWS IAM Best Practices</h3>
                <p>Short description of the blog...</p>
                <a class="btn-link" href="blog_view.php?id=1">Open blog</a>
            </article>
        </div>
    </section>
</main>
</body>
</html>
