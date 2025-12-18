<?php
session_start();
$userId   = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#ffffff; color:#111; }
        header { background:#e0f7fa; border-bottom:1px solid #b2ebf2; padding:1rem 2rem; display:flex; justify-content:flex-end; align-items:center;}
        .logo { position:absolute; left:2rem; font-weight:bold; font-size:1.5rem; color:#00bcd4; }
        nav a { color:#00bcd4; margin-left:1.5rem; text-decoration:none; font-weight:bold; }
        nav a:hover { text-decoration:underline; }
        .container { max-width:1100px; margin:2rem auto; padding:0 1rem; }
        .search-bar { display:flex; gap:.5rem; margin-bottom:1.5rem; }
        .search-bar input, .search-bar select { flex:1; padding:.6rem .8rem; border-radius:.5rem; border:1px solid #00bcd4; background:#ffffff; color:#111; }
        .search-bar button { padding:.6rem 1.2rem; border-radius:.5rem; border:none; background:#00bcd4; color:#fff; cursor:pointer; }
        .search-bar button:hover { background:#00acc1; }
        .section-title { font-size:1.2rem; margin:1.5rem 0 .8rem; color:#111; }
        .grid { display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); }
        .card { background:#f0f9f9; border-radius:.75rem; padding:1rem; border:1px solid #b2ebf2; }
        .card h3 { margin-top:0; margin-bottom:.4rem; font-size:1rem; }
        .meta { font-size:.85rem; color:#555; margin-bottom:.4rem; display:flex; gap:.5rem; flex-wrap:wrap;}
        .badge { padding:.1rem .5rem; border-radius:999px; font-size:.75rem; background:#00bcd4; color:#fff;}
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
        <a href="index.php">Home</a>
        <a href="browse.php">Browse</a>
        <a href="inbox.php">DMs</a>
        <a href="profile.php">My Profile</a>
        <a href="../backend/logout.php">Logout</a>
    </nav>
</header>

<main class="container">
    <section>
        <h2 class="section-title">Search blogs & bloggers</h2>
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
            <!-- No blogs yet -->
        </div>
    </section>
</main>
</body>
</html>