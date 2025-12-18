<?php
require 'backend/auth.php';
require 'backend/db.php';

$userId   = $_SESSION['user_id'];
$username = $_SESSION['username'];

$viewUserId = $_GET['user_id'] ?? $userId;

// Fetch user info
$stmt = $db->prepare("SELECT username FROM users WHERE id=?");
$stmt->execute([$viewUserId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$user) die("User not found");

// Blog counts
$stmt = $db->prepare("SELECT COUNT(*) FROM blogs WHERE user_id=?");
$stmt->execute([$viewUserId]);
$blogCount = $stmt->fetchColumn();

// Followers/following
$stmt = $db->prepare("SELECT COUNT(*) FROM follows WHERE following_id=?");
$stmt->execute([$viewUserId]);
$followers = $stmt->fetchColumn();

$stmt = $db->prepare("SELECT COUNT(*) FROM follows WHERE follower_id=?");
$stmt->execute([$viewUserId]);
$following = $stmt->fetchColumn();

// Fetch user's blogs
$stmt = $db->prepare("SELECT * FROM blogs WHERE user_id=? AND (expires_at IS NULL OR expires_at > NOW()) ORDER BY created_at DESC");
$stmt->execute([$viewUserId]);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <a href="browse.php">Browse</a>
        <a href="inbox.php">DMs</a>
        <a href="profile.php">My Profile</a>
        <a href="backend/logout.php">Logout</a>
    </nav>
</header>

<main class="container">
    <section class="profile-header">
        <div class="avatar"></div>
        <div>
            <h1>@<?= htmlspecialchars($user['username']) ?></h1>
            <div class="stats">
                <span><?= $blogCount ?> blogs</span>
                <span><?= $followers ?> followers</span>
                <span><?= $following ?> following</span>
            </div>
            <?php if($viewUserId !== $userId): ?>
                <div class="actions">
                    <form method="post" action="backend/follow_user.php" style="display:inline;">
                        <input type="hidden" name="follow_user_id" value="<?= $viewUserId ?>">
                        <button class="btn primary">Follow</button>
                    </form>
                    <a class="btn outline" href="inbox.php?start_thread=<?= $viewUserId ?>">Message</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section>
        <h2 class="section-title">Recent blogs</h2>
        <div class="blog-list">
            <?php foreach($blogs as $b): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($b['title']) ?></h3>
                    <?php if($b['image']): ?>
                        <img src="<?= htmlspecialchars($b['image']) ?>" style="width:100%; max-height:200px; object-fit:cover; margin-bottom:.5rem;">
                    <?php endif; ?>
                    <div><?= nl2br(htmlspecialchars(substr($b['content'],0,150))) ?>...</div>
                    <a class="btn-link" href="blog_view.php?id=<?= $b['id'] ?>">Read more</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
</body>
</html>
