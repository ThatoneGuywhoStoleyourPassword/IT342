<?php
require 'backend/db.php';
session_start();

$userId   = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;

$blogId = $_GET['id'] ?? null;
if(!$blogId) die("Blog not specified.");

// Fetch blog
$stmt = $db->prepare("
    SELECT b.*, u.username 
    FROM blogs b 
    JOIN users u ON b.user_id = u.id
    WHERE b.id=? AND (b.expires_at IS NULL OR b.expires_at > NOW())
");
$stmt->execute([$blogId]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$blog) die("Blog not found.");

// Fetch replies
$stmt = $db->prepare("
    SELECT r.*, u.username 
    FROM blog_replies r
    JOIN users u ON r.user_id = u.id
    WHERE r.blog_id=?
    ORDER BY r.created_at ASC
");
$stmt->execute([$blogId]);
$replies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cloud9 - <?= htmlspecialchars($blog['title']) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { margin:0; font-family: Arial, sans-serif; background:#ffffff; color:#111; }
header { background:#e0f7fa; border-bottom:1px solid #b2ebf2; padding:1rem 2rem; display:flex; justify-content:flex-end; align-items:center;}
.logo { position:absolute; left:2rem; font-weight:bold; font-size:1.5rem; color:#00bcd4; }
nav a { color:#00bcd4; margin-left:1.5rem; text-decoration:none; font-weight:bold; }
nav a:hover { text-decoration:underline; }
.container { max-width:900px; margin:2rem auto; padding:0 1rem; }
.blog-card { background:#f0f9f9; border-radius:.75rem; border:1px solid #b2ebf2; padding:1rem; margin-bottom:1rem; }
.blog-card img { width:100%; max-height:300px; object-fit:cover; margin-bottom:.5rem; }
.blog-card h2 { margin-top:0; margin-bottom:.5rem; }
.blog-card .meta { font-size:.85rem; color:#555; margin-bottom:.8rem; }
.reply-section { margin-top:1.5rem; }
.reply { border-top:1px solid #b2ebf2; padding:.5rem 0; }
.reply .username { font-weight:bold; font-size:.9rem; margin-bottom:.2rem; }
textarea { width:100%; min-height:60px; padding:.5rem .7rem; border-radius:.5rem; border:1px solid #00bcd4; margin-bottom:.5rem; }
button { padding:.5rem 1rem; border:none; border-radius:.5px; background:#00bcd4; color:#fff; cursor:pointer; }
button:hover { background:#00acc1; }
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
    <div class="blog-card">
        <h2><?= htmlspecialchars($blog['title']) ?></h2>
        <div class="meta">By @<?= htmlspecialchars($blog['username']) ?> | <?= date('M j, Y H:i', strtotime($blog['created_at'])) ?></div>
        <?php if($blog['image']): ?>
            <img src="<?= htmlspecialchars($blog['image']) ?>" alt="Blog Image">
        <?php endif; ?>
        <div><?= nl2br(htmlspecialchars($blog['content'])) ?></div>
    </div>

    <?php if($userId): ?>
        <div class="reply-section">
            <form method="post" action="backend/reply_blog.php">
                <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                <textarea name="content" placeholder="Write a reply..." required></textarea>
                <button type="submit">Reply</button>
            </form>
        </div>
    <?php else: ?>
        <p><a href="login.php">Login</a> to reply.</p>
    <?php endif; ?>

    <div class="reply-section">
        <?php foreach($replies as $r): ?>
            <div class="reply">
                <div class="username">@<?= htmlspecialchars($r['username']) ?> <span style="font-size:.75rem;color:#555;"><?= date('M j, Y H:i', strtotime($r['created_at'])) ?></span></div>
                <div><?= nl2br(htmlspecialchars($r['content'])) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
