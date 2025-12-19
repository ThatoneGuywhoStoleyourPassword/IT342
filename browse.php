<?php
session_start();
require 'backend/db.php';

$userId = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;

$queryStr = $_GET['q'] ?? '';
$type = $_GET['type'] ?? 'blogs';

$blogs = [];
if($type==='blogs'){
    $stmt = $db->prepare("
        SELECT b.id, b.title, b.content, b.image, b.is_cloud_blog, b.expires_at, u.username
        FROM blogs b
        JOIN users u ON b.user_id = u.id
        WHERE (b.expires_at IS NULL OR b.expires_at > NOW())
        AND (b.title LIKE ? OR b.content LIKE ?)
        ORDER BY b.created_at DESC
    ");
    $likeQuery = "%$queryStr%";
    $stmt->execute([$likeQuery, $likeQuery]);
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$users = [];
if($type==='bloggers' && $queryStr){
    $stmt = $db->prepare("SELECT id, username FROM users WHERE username LIKE ?");
    $stmt->execute(["%$queryStr%"]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cloud9 - Browse</title>
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
.btn-link { color:#00bcd4; text-decoration:none; }
.btn-link:hover { text-decoration:underline; }
</style>
</head>
<body>
<header>
    <div class="logo">Cloud9</div>
    <nav>
        <a href="/index.php">Home</a>
        <a href="/browse.php">Browse</a>
        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="/inbox.php">DMs</a>
            <a href="/profile.php">My Profile</a>
            <a href="/backend/logout.php">Logout</a>
        <?php else: ?>
            <a href="/login.php">Login</a>
            <a href="/register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>


<main class="container">
    <form class="search-bar" method="get">
        <input type="text" name="q" placeholder="Search..." value="<?= htmlspecialchars($queryStr) ?>">
        <select name="type">
            <option value="blogs" <?= $type==='blogs'?'selected':'' ?>>Blogs</option>
            <option value="bloggers" <?= $type==='bloggers'?'selected':'' ?>>Bloggers</option>
        </select>
        <button type="submit">Search</button>
    </form>

    <div class="grid">
        <?php if($type==='blogs'): ?>
            <?php foreach($blogs as $blog): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($blog['title']) ?></h3>
                    <div class="meta">@<?= htmlspecialchars($blog['username']) ?> <?php if($blog['is_cloud_blog']) echo '<span class="badge">Cloud</span>'; ?></div>
                    <?php if($blog['image']): ?>
                        <img src="<?= htmlspecialchars($blog['image']) ?>" style="width:100%; max-height:200px; object-fit:cover; margin-bottom:.5rem;">
                    <?php endif; ?>
                    <div><?= nl2br(htmlspecialchars(substr($blog['content'],0,150))) ?>...</div>
                    <a class="btn-link" href="blog_view.php?id=<?= $blog['id'] ?>">Read more</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <?php foreach($users as $u): ?>
                <div class="card">
                    <h3>@<?= htmlspecialchars($u['username']) ?></h3>
                    <a class="btn-link" href="profile.php?user_id=<?= $u['id'] ?>">View profile</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
