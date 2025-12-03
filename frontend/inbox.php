<?php
$userId    = $_COOKIE['user_id']   ?? null;
$username  = $_COOKIE['username'] ?? null;
$isLoggedIn = !empty($userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9 - Inbox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#020617; color:#e5e7eb; }
        header { background:#111827; border-bottom:1px solid #1f2933; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center;}
        .logo { font-weight:bold; }
        nav a { color:#9ca3af; margin-left:1rem; text-decoration:none; }
        nav a:hover { color:#ffffff; }
        .container { max-width:1000px; margin:1.5rem auto; padding:0 1rem; display:grid; grid-template-columns:280px 1fr; gap:1rem; }
        .thread-list { background:#020617; border-radius:.75rem; border:1px solid #1f2937; overflow:hidden; }
        .thread-list h2 { margin:0; padding:.9rem 1rem; border-bottom:1px solid #1f2937; font-size:1rem;}
        .thread { padding:.7rem 1rem; border-bottom:1px solid #111827; cursor:pointer; }
        .thread:hover { background:#030712; }
        .thread strong { display:block; font-size:.9rem; }
        .thread span { display:block; font-size:.8rem; color:#9ca3af; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .chat { background:#020617; border-radius:.75rem; border:1px solid #1f2937; display:flex; flex-direction:column; }
        .chat-header { padding:.9rem 1rem; border-bottom:1px solid #1f2937; display:flex; justify-content:space-between; align-items:center;}
        .messages { padding:1rem; flex:1; display:flex; flex-direction:column; gap:.5rem; overflow-y:auto; max-height:420px;}
        .msg { max-width:70%; padding:.5rem .7rem; border-radius:.75rem; font-size:.85rem; }
        .msg.me { margin-left:auto; background:#4f46e5; }
        .msg.them { background:#111827; }
        .msg-meta { font-size:.7rem; color:#9ca3af; margin-top:.2rem; }
        form { border-top:1px solid #1f2937; display:flex; gap:.5rem; padding:.7rem 1rem; }
        textarea { flex:1; resize:none; min-height:50px; border-radius:.5rem; border:1px solid #374151; background:#020617; color:#e5e7eb; padding:.5rem .7rem;}
        button { border:none; border-radius:.5rem; padding:.5rem 1rem; background:#4f46e5; color:#fff; cursor:pointer;}
        button:hover { background:#6366f1; }
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
    <!-- Left: list of DM threads -->
    <section class="thread-list">
        <h2>Messages</h2>
        <!-- PHP: Loop through DM threads for logged-in user -->
        <div class="thread">
            <strong>@tazio</strong>
            <span>Let’s finalize the AWS architecture tonight...</span>
        </div>
    </section>

    <!-- Right: selected conversation -->
    <section class="chat">
        <!-- PHP: Load selected conversation based on thread id -->
        <div class="chat-header">
            <div>
                <strong>@tazio</strong>
                <div style="font-size:.8rem; color:#9ca3af;">Last seen 5 min ago</div>
            </div>
        </div>
        <div class="messages">
            <!-- PHP: Loop messages -->
            <div class="msg them">
                <div>Hey, did you push the latest front-end changes to GitHub?</div>
                <div class="msg-meta">Today • 9:41 AM</div>
            </div>
            <div class="msg me">
                <div>Almost done, working on the blog pages now.</div>
                <div class="msg-meta">Today • 9:43 AM</div>
            </div>
        </div>
        <form method="post" action="">
            <!-- PHP: hidden thread_id + CSRF -->
            <textarea name="message" placeholder="Type a message..."></textarea>
            <button type="submit">Send</button>
        </form>
    </section>
</main>
</body>
</html>

