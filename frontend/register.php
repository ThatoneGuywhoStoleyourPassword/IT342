<?php
$userId   = $_COOKIE['user_id'] ?? null;
$username = $_COOKIE['username'] ?? 'Guest';
$isLoggedIn = !empty($userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#ffffff; color:#111; display:flex; align-items:center; justify-content:center; height:100vh;}
        .card { background:#f0f9f9; border-radius:.75rem; border:1px solid #b2ebf2; padding:2rem; width:360px; }
        h1 { margin-top:0; margin-bottom:1rem; font-size:1.5rem; color:#00bcd4; text-align:center;}
        label { display:block; font-size:.85rem; margin-bottom:.25rem; }
        input { width:100%; padding:.5rem .7rem; margin-bottom:.8rem; border-radius:.5rem; border:1px solid #00bcd4; background:#fff; color:#111;}
        button { width:100%; padding:.6rem; border-radius:.5rem; border:none; background:#00bcd4; color:#fff; cursor:pointer; margin-top:.5rem;}
        button:hover { background:#00acc1; }
        a { color:#00bcd4; font-size:.85rem; text-decoration:none;}
        a:hover { text-decoration:underline; }
        .back-home { display:block; text-align:center; margin-bottom:1rem; }
    </style>
</head>
<body>
<div class="card">
    <h1>Register</h1>
    <a class="back-home" href="index.php">Back to Home</a>

    <?php if (!empty($_GET['error'])): ?>
        <div class="error" style="color:#e53935; font-size:.85rem; margin-bottom:.5rem;"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form method="post" action="/api/register.php">
        <label for="username">Username</label>
        <input id="username" name="username" required>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <button type="submit">Sign Up</button>
    </form>

    <p style="margin-top:.8rem; font-size:.85rem; text-align:center;">
        Already have an account? <a href="login.php">Login</a>
    </p>
</div>
</body>
</html>
