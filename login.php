<?php
session_start();
// REMOVED auto-redirect so Login always loads even if logged in
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cloud9 - Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { margin:0; font-family: Arial, sans-serif; background:#ffffff; color:#111; display:flex; align-items:center; justify-content:center; height:100vh; }
.card { background:#f0f9f9; border-radius:.75rem; border:1px solid #b2ebf2; padding:2rem; width:360px; }
h1 { margin-top:0; margin-bottom:1rem; font-size:1.5rem; color:#00bcd4; text-align:center; }
label { display:block; font-size:.85rem; margin-bottom:.25rem; }
input { width:100%; padding:.5rem .7rem; margin-bottom:.8rem; border-radius:.5rem; border:1px solid #00bcd4; background:#fff; color:#111; }
button { width:100%; padding:.6rem; border-radius:.5rem; border:none; background:#00bcd4; color:#fff; cursor:pointer; margin-top:.5rem; }
button:hover { background:#00acc1; }
a { color:#00bcd4; font-size:.85rem; text-decoration:none; }
a:hover { text-decoration:underline; }
.back-home { display:block; text-align:center; margin-bottom:1rem; }
.error { color:#e53935; font-size:.85rem; margin-bottom:.5rem; text-align:center; }
.success { color:green; font-size:.85rem; margin-bottom:.5rem; text-align:center; }
</style>
</head>
<body>
<div class="card">
    <h1>Cloud9</h1>
    <a class="back-home" href="/index.php">Back to Home</a>

    <?php if (!empty($_GET['error'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php elseif(!empty($_GET['success'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <form method="post" action="/backend/login.php">
        <label for="email">Email or Username</label>
        <input id="email" name="email" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <button type="submit">Login</button>
    </form>

    <p style="margin-top:.8rem; font-size:.85rem; text-align:center;">
        Don’t have an account? <a href="/register.php">Sign Up</a>
    </p>
</div>
</body>
</html>
