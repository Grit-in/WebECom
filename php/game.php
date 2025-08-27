<?php
session_start();
require_once dirname(__DIR__) . '/database/database_init.php';
$db = new Database();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$game = $db->getGameById($id);
if (!$game) {
    http_response_code(404);
    echo '<h1>Game not found</h1>';
    exit();
}
$title = $game['title'] . ' | Ecom Games';
$bgImg = '../imgs/items/' . htmlspecialchars($game['image'], ENT_QUOTES);
$user = $_SESSION['username'] ?? $_SESSION['name'] ?? (isset($_SESSION['email']) ? explode('@', $_SESSION['email'])[0] : 'User');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title, ENT_QUOTES) ?></title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/gameshop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
      <div class="navbar__container">
        <a href="index.php" id="navbar__logo">
          <i class="fas fa-gamepad"></i>
        </a>
          <li class="shop-icon">
           <a href="cart.php" class="btn" id="cartBtn" style="margin-right:10px;">
              <i class="fa-solid fa-cart-shopping"></i>
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
                  <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
                </ul>
              </div>
            <?php else: ?>
              <a href="../php/login_forum.php" class="btn" id="signupBtn">
                <i class="fa-solid fa-user"></i> Login
              </a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </nav>

  <main class="game-detail-row">
    <div class="game-detail-img-wrapper">
      <img 
        src="<?= $bgImg ?>" 
        alt="<?= htmlspecialchars($game['title'], ENT_QUOTES) ?>" 
        class="game-detail-card-img"
      >
    </div>
    <div class="game-detail-info-card">
      <div class="game-detail-title"><?= htmlspecialchars($game['title'],ENT_QUOTES) ?></div>
      <div class="game-detail-price-row">
        <span class="game-detail-price"><?= number_format($game['price'],2) ?> €</span>
        <form action="../database/add_to_cart.php" method="post" class="add-to-cart-form">
              <input type="hidden" name="id" value="<?= (int)$id ?>">
                <button type="submit" class="game-detail-buy-btn">
                  <i class="fa-solid fa-cart-shopping"></i> Add to cart
                </button>
          </form>
      </div>
      <h2 class = "game-detail-quantity">In Stock: <span id="quantity"><?= htmlspecialchars($game['number_of_pieces'],ENT_QUOTES) ?></span></h2>
      <div class="game-detail-about">
        <h2>Description</h2>
        <div><?= nl2br(htmlspecialchars($game['description'],ENT_QUOTES|ENT_HTML5)) ?></div>
      </div>
    </div>
  </main>
<script src="../js/app.js"></script>
</body>
</html>
