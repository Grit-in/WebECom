<?php
session_start();
require_once __DIR__ . '/database_init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../php/game.php?id=' . (isset($_POST['id']) ? (int)$_POST['id'] : 0));
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    header('Location: ../php/index.php');
    exit;
}

$db = new Database();
$game = $db->getGameById($id);

if (!$game) {
    header('Location: ../php/index.php');
    exit;
}

$cart = [];
if (isset($_COOKIE['cart'])) {
    $cartData = json_decode($_COOKIE['cart'], true);
    if (is_array($cartData)) {
        $cart = $cartData;
    }
}

if (!is_array($cart)) {
    $cart = [];
}

if (isset($cart[$id]) && is_array($cart[$id]) && isset($cart[$id]['qty'])) {
    $cart[$id]['qty'] = (int)$cart[$id]['qty'] + 1;
} else {
    $cart[$id] = [
        'id'    => $id,
        'title' => $game['title'],
        'price' => (float)$game['price'],
        'qty'   => 1,
        'image' => $game['image'] ?? null,
    ];
}

setcookie('cart', json_encode($cart), time() + (30 * 24 * 60 * 60), '/');

header('Location: ../php/game.php?id=' . $id . '&added=1');
exit;
