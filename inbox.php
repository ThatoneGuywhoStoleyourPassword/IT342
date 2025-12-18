<?php
require 'backend/auth.php';
require 'backend/db.php';
$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch threads (keep existing code)
$selectedThread = $_GET['thread'] ?? null;
$threads = [];
$stmt = $db->prepare("
    SELECT t.*, u1.username as user1_name, u2.username as user2_name
    FROM threads t
    JOIN users u1 ON t.user1_id = u1.id
    JOIN users u2 ON t.user2_id = u2.id
    WHERE t.user1_id=? OR t.user2_id=?
    ORDER BY t.updated_at DESC
");
$stmt->execute([$userId,$userId]);
$threads = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch messages for selected thread
$messages = [];
if($selectedThread){
    $stmt = $db->prepare("SELECT m.*, u.username FROM messages m JOIN users u ON m.sender_id=u.id WHERE m.thread_id=? ORDER BY created_at ASC");
    $stmt->execute([$selectedThread]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// User search
$searchResults = [];
if(!empty($_GET['search_user'])){
    $searchTerm = $_GET['search_user'];
    $stmt = $db->prepare("SELECT id, username FROM users WHERE username LIKE ? AND id != ?");
    $stmt->execute(["%$searchTerm%", $userId]);
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cloud9 - Inbox</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { margin:0; font-family: Arial, sans-serif; background:#fff; color:#111; }
header { background:#e0f7fa; border-bottom:1px solid #b2ebf2; padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; }
.logo { font-weight:bold; font-size:1.5rem; color:#00bcd4; }
nav a { color:#00bcd4; margin-left:1rem; text-decoration:none; font-weight:bold; }
nav a:hover { text-decoration:underline; }
.container { max-width:1000px; margin:1.5rem auto; padding:0 1rem; display:grid; grid-template-columns:280px 1fr; gap:1rem; }
.thread-list { background:#f0f9f9; border-radius:.75rem; border:1px solid #b2ebf2; overflow:hidden; }
.thread-list h2 { margin:0; padding:.9rem 1rem; border-bottom:1px solid #b2ebf2; font-size:1rem; }
.thread { padding:.7rem 1rem; border-bottom:1px solid #e0f7fa; cursor:pointer; }
.thread:hover, .thread.active { background:#e0f7fa; }
.chat { background:#f0f9f9; border-radius:.75rem; border:1px solid #b2ebf2; display:flex; flex-direction:column; }
.chat-header { padding:.9rem 1rem; border-bottom:1px solid #b2ebf2; display:flex; justify-content:space-between; align-items:center; }
.messages { padding:1rem; flex:1; display:flex; flex-direction:column; gap:.5rem; overflow-y:auto; max-height:420px; }
.msg { max-width:70%; padding:.5rem .7rem; border-radius:.75rem; font-size:.85rem; }
.msg.me { margin-left:auto; background:#00bcd4; color:#fff; }
.msg.them { background:#e0f7fa; }
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
        <a href="backend/logout.php">Logout</a>
    </nav>
</header>

<main class="container">
    <section class="thread-list">
        <h2>Messages</h2>
        <input type="text" id="user-search" placeholder="Search users..." style="width:100%; padding:.5rem; margin-bottom:.5rem;">
        <div id="search-results"></div>
        <?php foreach($threads as $t): 
            $otherUser = ($t['user1_id']==$userId)? $t['user2_name'] : $t['user1_name'];
        ?>
            <a class="thread <?= ($selectedThread==$t['id'])?'active':'' ?>" href="inbox.php?thread=<?= $t['id'] ?>">
                <?= htmlspecialchars($otherUser) ?><br>
                <span style="font-size:.75rem;color:#555;"><?= substr($t['last_message'],0,30) ?>...</span>
            </a>
        <?php endforeach; ?>
    </section>

    <section class="chat">
        <?php if($selectedThread): ?>
            <div class="chat-header"><div><strong>Chat with <?= htmlspecialchars($otherUser) ?></strong></div></div>
            <div class="messages">
                <?php foreach($messages as $m): ?>
                    <div class="msg <?= ($m['sender_id']==$userId)?'me':'them' ?>">
                        <?= nl2br(htmlspecialchars($m['content'])) ?>
                        <div class="msg-meta"><?= htmlspecialchars($m['username']) ?> - <?= date('M j H:i', strtotime($m['created_at'])) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <form method="post" action="backend/send_message.php">
                <input type="hidden" name="thread_id" value="<?= $selectedThread ?>">
                <textarea name="content" placeholder="Type a message..." required></textarea>
                <button type="submit">Send</button>
            </form>
        <?php else: ?>
            <div class="chat-header"><strong>Select a thread to start chatting</strong></div>
        <?php endif; ?>
    </section>
</main>

<script>
// AJAX search users
const searchInput = document.getElementById('user-search');
const resultsDiv = document.getElementById('search-results');

searchInput.addEventListener('input', async ()=>{
    const term = searchInput.value.trim();
    if(!term){ resultsDiv.innerHTML=''; return; }
    const res = await fetch('backend/search_users.php?q='+encodeURIComponent(term));
    const users = await res.json();
    resultsDiv.innerHTML = users.map(u=>`<div><a href="inbox.php?start_thread=${u.id}">@${u.username}</a></div>`).join('');
});
</script>
</body>
</html>
