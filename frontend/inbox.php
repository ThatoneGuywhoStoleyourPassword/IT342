<?php
require '../backend/auth.php';
$userId   = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cloud9 - Inbox</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { margin:0; font-family: Arial, sans-serif; background:#ffffff; color:#111; }
header { background:#e0f7fa; border-bottom:1px solid #b2ebf2; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; }
.logo { font-weight:bold; font-size:1.5rem; color:#00bcd4; }
nav a { color:#00bcd4; margin-left:1rem; text-decoration:none; font-weight:bold; }
nav a:hover { text-decoration:underline; }
.container { max-width:1000px; margin:1.5rem auto; padding:0 1rem; display:grid; grid-template-columns:280px 1fr; gap:1rem; }
.thread-list { background:#f0f9f9; border-radius:.75rem; border:1px solid #b2ebf2; overflow:hidden; }
.thread-list h2 { margin:0; padding:.9rem 1rem; border-bottom:1px solid #b2ebf2; font-size:1rem; }
.thread { padding:.7rem 1rem; border-bottom:1px solid #e0f7fa; cursor:pointer; }
.thread:hover { background:#e0f7fa; }
.chat { background:#f0f9f9; border-radius:.75rem; border:1px solid #b2ebf2; display:flex; flex-direction:column; }
.chat-header { padding:.9rem 1rem; border-bottom:1px solid #b2ebf2; display:flex; justify-content:space-between; align-items:center; }
.messages { padding:1rem; flex:1; display:flex; flex-direction:column; gap:.5rem; overflow-y:auto; max-height:420px; }
.msg { max-width:70%; padding:.5rem .7rem; border-radius:.75rem; font-size:.85rem; }
.msg.me { margin-left:auto; background:#00bcd4; color:#fff; }
.msg.them { background:#e0f7fa; }
.msg-meta { font-size:.7rem; color:#555; margin-top:.2rem; }
form { border-top:1px solid #b2ebf2; display:flex; gap:.5rem; padding:.7rem 1rem; }
textarea { flex:1; resize:none; min-height:50px; border-radius:.5rem; border:1px solid #00bcd4; background:#fff; color:#111; padding:.5rem .7rem; }
button { border:none; border-radius:.5rem; padding:.5rem 1rem; background:#00bcd4; color:#fff; cursor:pointer; }
button:hover { background:#00acc1; }
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
    <section class="thread-list">
        <h2>Messages</h2>
        <!-- Empty; threads will load dynamically -->
    </section>

    <section class="chat">
        <div class="chat-header">
            <div>
                <strong>Select a thread</strong>
            </div>
        </div>
        <div class="messages">
            <!-- Empty; messages will load dynamically -->
        </div>
        <form method="post" action="../backend/send_message.php">
            <textarea name="content" placeholder="Type a message..."></textarea>
            <button type="submit">Send</button>
        </form>
    </section>
</main>
</body>
</html>
