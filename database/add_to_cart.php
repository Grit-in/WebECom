<?php
<?php
session_start();
require_once __DIR__ . '/database_init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../php/admin_index.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    header('Location: ../php/admin_index.php');
    exit;
}

$db = new Database();
$game = $db->getGameById($id);

if (!$game) {
    header('Location: ../php/admin_index.php');
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['qty'] += 1;
} else {
    $_SESSION['cart'][$id] = [
        'id'    => $id,
        'title' => $game['title'],
        'price' => (float)$game['price'],
        'qty'   => 1,
        'image' => $game['image'] ?? null,
    ];
}

header('Location: ../php/cart.php');
exit;
