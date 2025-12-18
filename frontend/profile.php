<?php
require '../backend/auth.php';
$userId   = $_SESSION['user_id'];
$username = $_SESSION['username'];
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
.actions { margin-top:.6rem; display:flex; gap:.5rem; flex-wrap:wrap; }
.btn { border:none; border-radius:.5rem; padding:.4rem .9rem; cursor:pointer; font-size:.85rem; }
.btn.primary { background:#00bcd4; color:#fff; }
.btn.outline { background:transparent; border:1px solid #00bcd4; color:#111; }
.stats { display:flex; gap:1.5rem; margin-top:.6rem; font-size:.85rem; color:#555; }
.section-title { margin:1.5rem 0 .7rem; font-size:1rem; color:#111; }
.blog-list { display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); }
.card { background:#f0f9f9; border-radius:.75rem; padding:1rem; border:1px solid #b2ebf2; }
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
        <a href="../backend/logout.php">Logout</a>
    </nav>
</header>

<main class="container">
    <section class="profile-header">
        <div class="avatar"></div>
        <div>
            <h1>@<?= htmlspecialchars($username) ?></h1>
            <p>Welcome to your Cloud9 profile, <?= htmlspecialchars($username) ?>.</p>
            <div class="actions">
                <button class="btn primary">Follow</button>
                <button class="btn outline">Message</button>
            </div>
            <div class="stats">
                <span>0 blogs</span>
                <span>0 followers</span>
                <span>0 following</span>
            </div>
        </div>
    </section>

    <section>
        <h2 class="section-title">Recent blogs</h2>
        <div class="blog-list">
            <!-- Empty; dynamic content loads here -->
        </div>
    </section>
</main>
</body>
</html>
