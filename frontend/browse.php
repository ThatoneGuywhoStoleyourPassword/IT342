<?php
$userId   = $_COOKIE['user_id'] ?? null;
$username = $_COOKIE['username'] ?? 'Guest';
$isLoggedIn = !empty($userId);
$query = $_GET['q'] ?? '';
$type  = $_GET['type'] ?? 'blogs';
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
        .container { max-width:1100px; margin:2rem auto; padding:0 1rem; }
        .search-bar { display:flex; gap:.5rem; margin-bottom:1.5rem; }
        .search-bar input, .search-bar select { flex:1; padding:.6rem .8rem; border-radius:.5rem; border:1px solid #00bcd4; background:#fff; color:#111; }
        .search-bar button { padding:.6rem 1.2rem; border-radius:.5rem; border:none; background:#00bcd4; color:#fff; cursor:pointer; }
        .search-bar button:hover { background:#00acc1; }
        .grid { display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); }
        .card { background:#f0f9f9; border-radius:.75rem; border:1px solid #b2ebf2; padding:1rem; }
        .card h3 { margin-top:0; margin-bottom:.4rem; font-size:1rem; }
        .meta { font-size:.85rem; color:#555; margin-bottom:.4rem; display:flex; gap:.5rem; flex-wrap:wrap;}
        .badge { padding:.1rem .5rem; border-radius:999px; font-size:.75rem; background:#00bcd4; color:#fff;}
        .badge.expiring { background:#e53935; }
        .badge.verified { background:#4caf50; }
        .blog-snippet { font-size:.9rem; color:#333; margin-bottom:.6rem; }
        .card-footer { display:flex; justify-content:space-between; align-items:center; font-size:.85rem; }
        .btn-link { color:#00bcd4; text-decoration:none; }
        .btn-link:hover { text-decoration:underline; }
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
    <form class="search-bar" method="get">
        <input type="text" name="q" placeholder="Search..." value="<?= htmlspecialchars($query) ?>">
        <select name="type">
            <option value="blogs" <?= $type==='blogs'?'selected':'' ?>>Blogs</option>
            <option value="bloggers" <?= $type==='bloggers'?'selected':'' ?>>Bloggers</option>
        </select>
        <button type="submit">Search</button>
    </form>

    <div class="grid">
        <div class="card">
            <h3>Sample Blog Title</h3>
            <div class="meta">
                <span>by <a class="btn-link" href="profile.php?user=john_doe">john_doe</a></span>
                <span>2 hours ago</span>
                <span class="badge verified">Verified</span>
            </div>
            <p class="blog-snippet">Short preview of the blog content...</p>
            <div class="card-footer">
                <a class="btn-link" href="blog_view.php?id=1">Read more</a>
                <span>123 views • 12 replies</span>
            </div>
        </div>
    </div>
</main>
</body>
</html>
