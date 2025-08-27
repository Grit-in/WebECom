<?php
session_start();
require_once __DIR__ . '/database_init.php';

if (!isset($_SESSION['email'])) {
    header('Location: ../php/login_forum.php');
    exit;
}

if (!isset($_COOKIE['cart'])) {
    header('Location: ../php/cart.php?error=empty_cart');
    exit;
}

$cartData = json_decode($_COOKIE['cart'], true);
if (!is_array($cartData) || empty($cartData)) {
    header('Location: ../php/cart.php?error=empty_cart');
    exit;
}

$validCartItems = [];
foreach ($cartData as $item) {
    if (is_array($item) && isset($item['id']) && isset($item['qty']) && isset($item['title'])) {
        $validCartItems[] = $item;
    }
}

if (empty($validCartItems)) {
    header('Location: ../php/cart.php?error=invalid_cart');
    exit;
}

$db = new Database();
$result = $db->processCheckout($validCartItems);

if ($result['success']) {
    setcookie('cart', '', time() - 3600, '/');
    
    header('Location: ../php/cart.php?checkout=success');
    exit;
} else {
    $errorMessage = implode(', ', $result['errors']);
    header('Location: ../php/cart.php?error=checkout_failed&message=' . urlencode($errorMessage));
    exit;
}
?>
