<?php
session_start();
require_once __DIR__ . '/database_init.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../php/admin_index.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    header('Location: ../php/admin_index.php?error=invalid_id');
    exit;
}

$db = new Database();
$game = $db->getGameById($id);

if (!$game) {
    header('Location: ../php/admin_index.php?error=game_not_found');
    exit;
}

if ($db->deleteGame($id)) {
    header('Location: ../php/admin_index.php?delete=success');
} else {
    header('Location: ../php/admin_index.php?error=delete_failed');
}
exit;
