<?php
$userId    = $_COOKIE['user_id']   ?? null;
$username  = $_COOKIE['username'] ?? null;
$isLoggedIn = !empty($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9 - Blog View</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#020617; color:#e5e7eb; }
        header { background:#111827; border-bottom:1px solid #1f2933; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center;}
        .logo { font-weight:bold; }
        nav a { color:#9ca3af; margin-left:1rem; text-decoration:none; }
        nav a:hover { color:#ffffff; }
        .container { max-width:800px; margin:1.5rem auto; padding:0 1rem; }
        .meta { font-size:.85rem; color:#9ca3af; margin-bottom:.7rem; display:flex; flex-wrap:wrap; gap:.5rem; }
        .badge { padding:.15rem .6rem; border-radius:999px; font-size:.7rem; background:#16a34a; }
        .badge.expiring { background:#b91c1c; }
        .actions { display:flex; flex-wrap:wrap; gap:.5rem; margin:1rem 0; }
        .btn { border:none; border-radius:.5rem; padding:.5rem .9rem; cursor:pointer; font-size:.85rem; }
        .btn.primary { background:#4f46e5; color:#fff; }
        .btn.outline { background:transparent; border:1px solid #4b5563; color:#e5e7eb;}
        .content { line-height:1.6; margin-bottom:1.5rem; }
        .attachments ul { list-style:none; padding:0; }
        .attachments a { color:#60a5fa; text-decoration:none; font-size:.9rem; }
        .attachments a:hover { text-decoration:underline; }
        .section-title { font-size:1rem; margin:1.5rem 0 .7rem; }
        .reply-form textarea { width:100%; min-height:80px; padding:.6rem .8rem; border-radius:.5rem; border:1px solid #374151; background:#020617; color:#e5e7eb; }
        .reply-form button { margin-top:.5rem; }
        .reply-list { margin-top:1rem; display:flex; flex-direction:column; gap:.75rem; }
        .reply { background:#020617; border-radius:.75rem; border:1px solid #1f2937; padding:.7rem .8rem; }
        .reply .meta { margin-bottom:.3rem; font-size:.8rem; }
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
    </nav>
</header>

<main class="container">
    <!-- PHP: Load blog by ID from $_GET['id'] -->
    <h1>Sample Blog Title About AWS</h1>
    <div class="meta">
        <span>by <a href="profile.php?user=john_doe">@john_doe</a></span>
        <span>Posted 3 hours ago</span>
        <span class="badge">Verified</span>
        <span class="badge expiring">Expires on 2025-11-30</span>
    </div>

    <div class="actions">
        <!-- PHP: Show follow/unfollow depending on current user -->
        <button class="btn primary">Follow Author</button>
        <!-- PHP: Toggle email notifications for this blog -->
        <button class="btn outline">Notify me on replies</button>
        <button class="btn outline">Send DM</button>
    </div>

    <article class="content">
        <!-- PHP: Echo blog body (escaped / sanitized) -->
        <p>
            This is where the full blog content will appear. You can talk about your AWS project,
            architecture diagrams, and anything else. Blogs that expire will stop being visible after
            the configured date.
        </p>
    </article>

    <section class="attachments">
        <h2 class="section-title">Attachments</h2>
        <!-- PHP: Loop blog attachments -->
        <ul>
            <li><a href="#">design-diagram.pdf</a></li>
            <li><a href="#">aws-architecture.png</a></li>
        </ul>
    </section>

    <section class="replies">
        <h2 class="section-title">Replies</h2>

        <!-- PHP: only show form if user logged in -->
        <form class="reply-form" method="post" action="">
            <!-- PHP: CSRF token / hidden blog_id -->
            <textarea name="reply_body" placeholder="Write a reply..."></textarea>
            <button class="btn primary" type="submit">Post reply</button>
        </form>

        <div class="reply-list">
            <!-- PHP: Loop replies -->
            <article class="reply">
                <div class="meta">
                    <span><a href="profile.php?user=aws_fan">@aws_fan</a></span>
                    <span>• 20 minutes ago</span>
                </div>
                <p>Love this design! How are you handling IAM roles?</p>
            </article>
        </div>
    </section>
</main>
</body>
</html>

