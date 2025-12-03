<?php

$userId   = $_COOKIE['user_id'] ?? null;
$username = $_COOKIE['username'] ?? 'Guest';
$isLoggedIn = !empty($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9g - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#0f172a; color:#e5e7eb; }
        header { background:#111827; border-bottom:1px solid #1f2933; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center;}
        .logo { font-weight:bold; font-size:1.3rem; }
        nav a { color:#9ca3af; margin-left:1rem; text-decoration:none; }
        nav a:hover { color:#ffffff; }
        .container { max-width:1100px; margin:1.5rem auto; padding:0 1rem; }
        .search-bar { display:flex; gap:.5rem; margin-bottom:1.5rem; }
        .search-bar input, .search-bar select { flex:1; padding:.6rem .8rem; border-radius:.5rem; border:1px solid #374151; background:#020617; color:#e5e7eb; }
        .search-bar button { padding:.6rem 1.2rem; border-radius:.5rem; border:none; background:#4f46e5; color:#fff; cursor:pointer; }
        .search-bar button:hover { background:#6366f1; }
        .section-title { font-size:1.1rem; margin:1.5rem 0 .8rem; }
        .grid { display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); }
        .card { background:#020617; border-radius:.75rem; padding:1rem; border:1px solid #1f2937; }
        .card h3 { margin-top:0; margin-bottom:.4rem; font-size:1rem; }
        .meta { font-size:.8rem; color:#9ca3af; margin-bottom:.4rem; display:flex; gap:.5rem; flex-wrap:wrap;}
        .badge { padding:.1rem .5rem; border-radius:999px; font-size:.7rem; background:#1d4ed8; color:#e5e7eb;}
        .badge.expiring { background:#b91c1c; }
        .badge.verified { background:#16a34a; }
        .blog-snippet { font-size:.9rem; color:#d1d5db; margin-bottom:.6rem; }
        .card-footer { display:flex; justify-content:space-between; align-items:center; font-size:.8rem; }
        .btn-link { color:#60a5fa; text-decoration:none; }
        .btn-link:hover { text-decoration:underline; }
    </style>
</head>
<body>
<header>
    <div class="logo">Cloud9</div>

    <nav>
        <!-- Always show Browse -->
        <a href="browse.php">Browse</a>

        <?php if ($isLoggedIn): ?>
            <!-- Logged IN links -->
            <a href="index.php">Home</a>
            <a href="inbox.php">DMs</a>
            <a href="profile.php">My Profile</a>
            <a href="/api/logout.php">Logout</a>
        <?php else: ?>
            <!-- Logged OUT links -->
            <a href="login.php">Login</a>
            <a href="register.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>


<main class="container">
    <section>
        <h2 class="section-title">Search blogs &amp; bloggers</h2>
        <form class="search-bar" method="get" action="browse.php">
            <input type="text" name="q" placeholder="Search blog titles, tags, or bloggers...">
            <select name="type">
                <option value="blogs">Blogs</option>
                <option value="bloggers">Bloggers</option>
            </select>
            <button type="submit">Search</button>
        </form>
    </section>

    <section>
        <h2 class="section-title">Latest blogs</h2>
        <div class="grid">
            <!-- PHP: Loop through latest blogs -->
            <article class="card">
                <h3>Sample Blog Title</h3>
                <div class="meta">
                    <span>by <a class="btn-link" href="profile.php?user=john_doe">john_doe</a></span>
                    <span>2 hours ago</span>
                    <span class="badge verified">Verified</span>
                    <span class="badge expiring">Expires in 5 days</span>
                </div>
                <p class="blog-snippet">
                    This is a short preview of the blog content. Non-users can read this snippet and open the full post.
                </p>
                <div class="card-footer">
                    <a class="btn-link" href="blog_view.php?id=1">Read more</a>
                    <span>123 views • 12 replies</span>
                </div>
            </article>
            <!-- /PHP loop -->
        </div>
    </section>
</main>
</body>
</html>

