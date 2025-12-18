<?php
session_start();
require 'backend/db.php';

$userId   = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;

// Fetch latest blogs (exclude expired cloud blogs)
$query = $db->prepare("
    SELECT b.id, b.title, b.content, b.image, b.is_cloud_blog, b.expires_at, u.username
    FROM blogs b
    JOIN users u ON b.user_id = u.id
    WHERE b.expires_at IS NULL OR b.expires_at > NOW()
    ORDER BY b.created_at DESC
    LIMIT 12
");
$query->execute();
$blogs = $query->fetchAll(PDO::FETCH_ASSOC);
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
        <?php if($userId): ?>
            <a href="inbox.php">DMs</a>
            <a href="profile.php">My Profile</a>
            <a href="backend/logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <section>
        <h2 class="section-title">Latest blogs</h2>
        <div class="grid">
            <?php foreach($blogs as $blog): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($blog['title']) ?></h3>
                    <div class="meta">@<?= htmlspecialchars($blog['username']) ?> <?php if($blog['is_cloud_blog']) echo '<span class="badge">Cloud</span>'; ?></div>
                    <?php if($blog['image']): ?>
                        <img src="<?= htmlspecialchars($blog['image']) ?>" style="width:100%; max-height:200px; object-fit:cover; margin-bottom:.5rem;">
                    <?php endif; ?>
                    <div class="blog-snippet"><?= nl2br(htmlspecialchars(substr($blog['content'],0,150))) ?>...</div>
                    <div class="card-footer"><a class="btn-link" href="blog_view.php?id=<?= $blog['id'] ?>">Read more</a></div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
</body>
</html>
