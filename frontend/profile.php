<?php

if (empty($_COOKIE['user_id'])) {
    header("Location: /login.php?error=" . urlencode("Please log in first."));
    exit;
}

$userId   = $_COOKIE['user_id'];
$username = $_COOKIE['username'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9 - Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#020617; color:#e5e7eb; }
        header { background:#111827; border-bottom:1px solid #1f2933; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center;}
        .logo { font-weight:bold; }
        nav a { color:#9ca3af; margin-left:1rem; text-decoration:none; }
        nav a:hover { color:#ffffff; }
        .container { max-width:900px; margin:1.5rem auto; padding:0 1rem; }
        .profile-header { display:flex; gap:1.5rem; align-items:flex-start; }
        .avatar { width:72px; height:72px; border-radius:999px; background:#1f2937; }
        .badge { padding:.15rem .6rem; border-radius:999px; font-size:.7rem; background:#16a34a; margin-left:.5rem; }
        .actions { margin-top:.6rem; display:flex; gap:.5rem; flex-wrap:wrap;}
        .btn { border:none; border-radius:.5rem; padding:.4rem .9rem; cursor:pointer; font-size:.85rem; }
        .btn.primary { background:#4f46e5; color:#fff; }
        .btn.outline { background:transparent; border:1px solid #4b5563; color:#e5e7eb;}
        .stats { display:flex; gap:1.5rem; margin-top:.6rem; font-size:.85rem; color:#9ca3af; }
        .section-title { margin:1.5rem 0 .7rem; font-size:1rem; }
        .blog-list { display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); }
        .card { background:#020617; border-radius:.75rem; padding:1rem; border:1px solid #1f2937; }
        .card h3 { margin-top:0; font-size:1rem; }
        .card p { font-size:.9rem; color:#d1d5db; }
        .btn-link { color:#60a5fa; text-decoration:none; font-size:.9rem;}
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
    </nav>
</header>

<main class="container">
    <!-- PHP: Load user from $_GET['user'] or current session -->
    <section class="profile-header">
        <div class="avatar"></div>
        <div>
                        <h1>@<?= htmlspecialchars($username) ?> <span class="badge">Verified</span></h1>
            <p>Welcome to your Cloud9 profile, <?= htmlspecialchars($username) ?>.</p>

            <div class="actions">
                <!-- PHP: If viewing someone else -->
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
            <!-- PHP: Loop user's blogs -->
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

