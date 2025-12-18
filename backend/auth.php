// backend/auth.php
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hard redirect only when required
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
