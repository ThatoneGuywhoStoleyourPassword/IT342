<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud9 - Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#020617; color:#e5e7eb; display:flex; align-items:center; justify-content:center; height:100vh;}
        .card { background:#020617; border-radius:.75rem; border:1px solid #1f2937; padding:2rem; width:360px;}
        h1 { margin-top:0; margin-bottom:1rem; font-size:1.2rem; }
        label { display:block; font-size:.85rem; margin-bottom:.25rem; }
        input { width:100%; padding:.5rem .7rem; margin-bottom:.8rem; border-radius:.5rem; border:1px solid #374151; background:#020617; color:#e5e7eb;}
        button { width:100%; padding:.6rem; border-radius:.5rem; border:none; background:#4f46e5; color:#fff; cursor:pointer;}
        button:hover { background:#6366f1; }
        a { color:#60a5fa; font-size:.85rem; text-decoration:none;}
        a:hover { text-decoration:underline; }
    </style>
</head>
<body>
<div class="card">
    <h1>Create account</h1>
     <?php if (!empty($_GET['error'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <!-- form now posts to backend -->
    <form method="post" action="/api/register.php">
        <label for="username">Username</label>
        <input id="username" name="username" required>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <label for="password_confirm">Confirm password</label>
        <input id="password_confirm" name="password_confirm" type="password" required>

        <button type="submit">Register</button>
    </form>
    <p style="margin-top:.8rem; font-size:.85rem;">
        Already have an account? <a href="login.php">Sign in</a>
    </p>
</div>
</body>
</html>

