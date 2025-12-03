<?php


$userId    = $_COOKIE['user_id']   ?? null;
$username  = $_COOKIE['username'] ?? null;
$isLoggedIn = !empty($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9 - Explore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#020617; color:#e5e7eb; }
        header { background:#111827; border-bottom:1px solid #1f2933; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center;}
        .logo { font-weight:bold; }
        nav a { color:#9ca3af; margin-left:1rem; text-decoration:none; }
        nav a:hover { color:#ffffff; }
        .container { max-width:1100px; margin:1.5rem auto; padding:0 1rem; }
        form { display:flex; gap:.5rem; margin-bottom:1.5rem;}
        input, select { flex:1; padding:.6rem .8rem; border-radius:.5rem; border:1px solid #374151; background:#020617; color:#e5e7eb; }
        button { padding:.6rem 1.2rem; border-radius:.5rem; border:none; background:#4f46e5; color:#fff; cursor:pointer; }
        button:hover { background:#6366f1; }
        .results { display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); }
        .card { background:#020617; border-radius:.75rem; padding:1rem; border:1px solid #1f2937; }
        .card h3 { margin-top:0; font-size:1rem; }
        .meta { font-size:.8rem; color:#9ca3af; margin-bottom:.3rem; display:flex; gap:.4rem; flex-wrap:wrap; }
        .badge { padding:.1rem .5rem; border-radius:999px; font-size:.7rem; background:#1d4ed8; }
        .btn-link { color:#60a5fa; text-decoration:none; font-size:.9rem; }
        .btn-link:hover { text-decoration:underline; }
        .snippet { font-size:.9rem; color:#d1d5db; }
    </style>
</head>
<body>
<header>
    <div class="logo">Cloud9</div>
    <nav>
        <a href="browse.php">Browse</a>
        <?php if ($isLoggedIn): ?>
            <a href="index.php">Home</a>
            <a href="inbox.php">DMs</a>
            <a href="profile.php">My Profile</a>
            <a href="/api/logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
    <h2>Explore</h2>
    <!-- PHP: Use current search values from $_GET -->
    <form method="get">
        <input type="text" name="q" placeholder="Search..." >
        <select name="type">
            <option value="blogs">Blogs</option>
            <option value="bloggers">Bloggers</option>
        </select>
        <button type="submit">Search</button>
    </form>

    <section class="results">
        <!-- PHP: If type = blogs, loop blog results -->
        <article class="card">
            <h3>Sample Blog Result</h3>
            <div class="meta">
                <span>by <a class="btn-link" href="profile.php?user=john_doe">john_doe</a></span>
                <span>Tag: aws</span>
                <span class="badge">Top</span>
            </div>
            <p class="snippet">Snippet of the blog that matches the query...</p>
            <a class="btn-link" href="blog_view.php?id=1">Open blog</a>
        </article>

        <!-- PHP: If type = bloggers, show blogger cards instead -->
        <!--
        <article class="card">
            <h3>@john_doe</h3>
            <div class="meta">
                <span>42 blogs</span>
                <span>120 followers</span>
            </div>
            <a class="btn-link" href="profile.php?user=john_doe">View profile</a>
        </article>
        -->
    </section>
</main>
</body>
</html>

