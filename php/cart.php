<?php
session_start();
$title = "Shopping Cart | Ecom Games";

$user = $_SESSION['username'] ?? $_SESSION['name'] ?? (isset($_SESSION['email']) ? explode('@', $_SESSION['email'])[0] : 'User');

$cart = [];
$total = 0;
$itemCount = 0;

if (isset($_COOKIE['cart'])) {
    $cartData = json_decode($_COOKIE['cart'], true);
    if (is_array($cartData)) {
        $cart = $cartData;
        
        foreach ($cart as $item) {
            if (isset($item['price']) && isset($item['qty']) && is_numeric($item['price']) && is_numeric($item['qty'])) {
                $total += (float)$item['price'] * (int)$item['qty'];
                $itemCount += (int)$item['qty'];
            }
        }
    }
}

if (isset($_GET['remove']) && isset($_GET['id'])) {
    $removeId = (int)$_GET['id'];
    if (isset($cart[$removeId])) {
        unset($cart[$removeId]);
        setcookie('cart', json_encode($cart), time() + (30 * 24 * 60 * 60), '/');
        header('Location: cart.php');
        exit;
    }
}

if (isset($_POST['update_qty']) && isset($_POST['id']) && isset($_POST['qty'])) {
    $updateId = (int)$_POST['id'];
    $newQty = (int)$_POST['qty'];
    
    if (isset($cart[$updateId])) {
        if ($newQty > 0) {
            $cart[$updateId]['qty'] = $newQty;
        } else {
            unset($cart[$updateId]);
        }
        setcookie('cart', json_encode($cart), time() + (30 * 24 * 60 * 60), '/');
        header('Location: cart.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/gameshop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
       
    </style>
</head>
<body class="cart-page">
    <nav class="navbar">
        <div class="navbar__container">
            <a href="../index.php" id="navbar__logo">
                <i class="fas fa-gamepad"></i>
            </a>
            
            <li class="shop-icon">
                <a href="cart.php" class="btn" id="cartBtn" style="margin-right:10px; position: relative;">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <?php if ($itemCount > 0): ?>
                        <span class="ic"><?= $itemCount ?></span>
                    <?php endif; ?>
                </a>
            </li>
            
            <li class="navbar__btn">
                <?php if (isset($_SESSION['email'])): ?>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" onclick="toggleDropdown()">
                            <i class="fa-solid fa-user"></i> <?php echo $user; ?>
                        </button>
                        <ul class="dropdown-menu" id="dropdownMenu">
                            <li><a href="settings.php"><i class="fa-solid fa-gear"></i> Settings</a></li>
                            <li><a href="orders.php"><i class="fa-solid fa-box"></i> My Orders</a></li>
                            <li><a href="../php/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login_forum.php" class="btn" id="signupBtn">
                        <i class="fa-solid fa-user"></i> Login
                    </a>
                <?php endif; ?>
            </li>
        </div>
    </nav>

    <div class="cart-header"></div>

    <div class="cart-container">
        <?php if (isset($_GET['checkout']) && $_GET['checkout'] == 'success'): ?>
            <div class="cart-success">
                <i class="fas fa-check-circle"></i> <strong>Checkout Successful!</strong> Your order has been processed and the cart has been cleared.
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="cart-error">
                <i class="fas fa-exclamation-triangle"></i> <strong>Error:</strong> 
                <?php 
                if ($_GET['error'] == 'empty_cart') {
                    echo 'Your cart is empty.';
                } elseif ($_GET['error'] == 'invalid_cart') {
                    echo 'Invalid cart data.';
                } elseif ($_GET['error'] == 'checkout_failed' && isset($_GET['message'])) {
                    echo htmlspecialchars($_GET['message'], ENT_QUOTES);
                } else {
                    echo 'An error occurred during checkout.';
                }
                ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h2>Your cart is empty</h2>
                <p>Add some games to get started!</p>
                <a href="user_index.php" class="continue-shopping">Continue Shopping</a>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                <div>
                    <div class="cart-items-list">
                        <?php foreach ($cart as $itemId => $item): ?>
                            <?php if (is_array($item) && isset($item['title']) && isset($item['qty'])): ?>
                                <div class="cart-item-row">
                                    <img src="../imgs/items/<?= htmlspecialchars($item['image'], ENT_QUOTES) ?>" 
                                         alt="<?= htmlspecialchars($item['title'], ENT_QUOTES) ?>" 
                                         class="cart-item-small-img">
                                    <div class="cart-item-info">
                                        <div class="cart-item-name"><?= htmlspecialchars($item['title'], ENT_QUOTES) ?></div>
                                        <div class="cart-item-price"><?= number_format($item['price'], 2) ?> €</div>
                                    </div>
                                    <div class="cart-item-quantity">
                                        <span class="qty-badge"><?= $item['qty'] ?></span>
                                    </div>
                                    <div class="cart-item-actions">
                                        <a href="?remove=1&id=<?= $item['id'] ?>" 
                                           class="btn-remove-small" 
                                           onclick="return confirm('Remove <?= htmlspecialchars($item['title'], ENT_QUOTES) ?> from cart?')">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="cart-summary">
                    <h3><i class="fas fa-receipt"></i> Order Summary</h3>
                    <div class="summary-row">
                        <span>Items (<?= $itemCount ?>):</span>
                        <span><?= number_format($total, 2) ?> €</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total:</span>
                        <span><?= number_format($total, 2) ?> €</span>
                    </div>
                    <a href="../database/checkout.php" class="checkout-btn" style="text-decoration: none; display: block;">
                        <i class="fas fa-credit-card"></i> Proceed to Checkout
                    </a>
                    <a href="user_index.php" class="continue-shopping">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="../js/app.js"></script>
</body>
</html>
