<?php
require 'backend/auth.php';
require 'backend/db.php';

$userId   = $_SESSION['user_id'];
$username = $_SESSION['username'];
$viewUserId = $_GET['user_id'] ?? $userId;

/* =========================
   HANDLE BLOG DELETE (OWNER ONLY)
   ========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_blog_id'])) {
    $blogId = (int)$_POST['delete_blog_id'];

    // Ensure blog belongs to logged-in user
    $stmt = $db->prepare("SELECT id FROM blogs WHERE id=? AND user_id=?");
    $stmt->execute([$blogId, $userId]);

    if ($stmt->fetch()) {
        $del = $db->prepare("DELETE FROM blogs WHERE id=?");
        $del->execute([$blogId]);
    }

    header("Location: profile.php");
    exit;
}

/* =========================
   FETCH PROFILE DATA
   ========================= */
$stmt = $db->prepare("SELECT username FROM users WHERE id=?");
$stmt->execute([$viewUserId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$user) die("User not found");

$stmt = $db->prepare("SELECT COUNT(*) FROM blogs WHERE user_id=?");
$stmt->execute([$viewUserId]);
$blogCount = $stmt->fetchColumn();

$stmt = $db->prepare("SELECT COUNT(*) FROM follows WHERE following_id=?");
$stmt->execute([$viewUserId]);
$followers = $stmt->fetchColumn();

$stmt = $db->prepare("SELECT COUNT(*) FROM follows WHERE follower_id=?");
$stmt->execute([$viewUserId]);
$following = $stmt->fetchColumn();

$stmt = $db->prepare("
    SELECT * FROM blogs 
    WHERE user_id=? AND (expires_at IS NULL OR expires_at > NOW()) 
    ORDER BY created_at DESC
");
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
.card { position:relative; background:#f0f9f9; border-radius:.75rem; padding:1rem; border:1px solid #b2ebf2; }
.card:hover .delete-btn { opacity:1; }
.delete-btn {
    position:absolute;
    top:8px;
    right:10px;
    background:none;
    border:none;
    color:#e53935;
    font-size:1rem;
    cursor:pointer;
    opacity:0;
}
.delete-btn:hover { transform:scale(1.1); }
.btn-link { color:#00bcd4; text-decoration:none; font-size:.9rem; }
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
                    <form method="post" action="backend/follow_user.php">
                        <input type="hidden" name="follow_user_id" value="<?= $viewUserId ?>">
                        <button class="btn primary">Follow</button>
                    </form>
                    <a class="btn outline" href="inbox.php?start_thread=<?= $viewUserId ?>">Message</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if($userId === $viewUserId): ?>
    <section>
        <h2 class="section-title">Post a new blog</h2>
        <form id="blog-form" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title" required style="width:100%;margin-bottom:.5rem;">
            <textarea name="content" placeholder="Content" required style="width:100%;margin-bottom:.5rem;"></textarea>
            <label><input type="checkbox" name="cloud_blog"> Cloud blog (expires in 24h)</label><br><br>
            <input type="file" name="image"><br><br>
            <button type="submit">Post</button>
        </form>
        <div id="blog-message" style="margin-top:.5rem;color:green;"></div>
    </section>
    <?php endif; ?>

    <section>
        <h2 class="section-title">Recent blogs</h2>
        <div class="blog-list">
            <?php foreach($blogs as $b): ?>
                <div class="card">
                    <?php if($userId === $viewUserId): ?>
                        <form method="post" style="position:absolute;top:0;right:0;">
                            <input type="hidden" name="delete_blog_id" value="<?= $b['id'] ?>">
                            <button class="delete-btn" title="Delete">✕</button>
                        </form>
                    <?php endif; ?>

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

<script>
document.getElementById('blog-form')?.addEventListener('submit', async (e)=>{
    e.preventDefault();
    const formData = new FormData(e.target);
    const res = await fetch('backend/post_blog.php', { method:'POST', body:formData });
    if(res.ok){
        document.getElementById('blog-message').innerText = 'Blog posted!';
        setTimeout(()=>location.reload(), 800);
    } else {
        document.getElementById('blog-message').innerText = 'Failed to post blog';
    }
});
</script>
</body>
</html>
