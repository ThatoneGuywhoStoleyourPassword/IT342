<?php
// api/logout.php - runs on backend

session_start();

// Wipe PHP session (backend side)
$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

session_destroy();

// Also clear the cookies the frontend uses for auth
setcookie('user_id', '', time() - 3600, '/', '', false, true);
setcookie('username', '', time() - 3600, '/', '', false, true);

// Send user back to login with a “logged out” message
header("Location: /login.php?logout=1");
exit;

