<?php
session_start();
require_once dirname(__DIR__) . '/database/database_init.php';

if (isset($_SESSION['user_id'])) {
    $db = new Database();
    $db->clearRememberToken($_SESSION['user_id']);
    setcookie('rememberme', '', time() - 3600, '/', '', false, true);
}

$_SESSION = array();
session_destroy();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
header("Location: ../php/login_forum.php");
exit();
