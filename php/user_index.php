<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: ../index.php");
    exit();
}

$title = "Ecom Games User Page";
$user = $_SESSION['username'] ?? $_SESSION['name'] ?? (isset($_SESSION['email']) ? explode('@', $_SESSION['email'])[0] : 'User');
require_once dirname(__DIR__) . '/database/database_init.php';
$db = new Database();
$games = $db->getAllGames();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../css/output.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
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
          <div class="dropdown">
            <button class="btn dropdown-toggle" onclick="toggleDropdown()">
              <i class="fa-solid fa-user"></i>
              <?= htmlspecialchars($user, ENT_QUOTES|ENT_HTML5, 'UTF-8') ?>
            </button>
            <ul class="dropdown-menu" id="dropdownMenu">
              <li><a href="settings.php"><i class="fa-solid fa-gear"></i> Settings</a></li>
              <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
            </ul>
          </div>
        </li>
      </div>
    </nav>

     <div class="hero-banner" style="background-image: url('../imgs/navbarimg.jpg');"></div>

    <main class="main">
      <div class="main__container">
        <div class="main__content">
          <h2>Currently Popular ></h2>
          <div class="games-admin-grid">
            <?php foreach($games as $g): ?>
              <div class="card">
                <div class="imgBox">
                    <img src="../imgs/items/<?= htmlspecialchars($g['image'],ENT_QUOTES) ?>" alt="<?= htmlspecialchars($g['title'],ENT_QUOTES) ?>" class="mouse">
                </div>
                <div class="contentBox">
                    <h3><?= htmlspecialchars($g['title'],ENT_QUOTES) ?></h3>
                    <h2 class="price"><?= number_format($g['price'],2) ?> <small>€</small></h2>
                    <a href="game.php?id=<?= (int)$g['id'] ?>" class="buy">Buy Now</a>
                </div>
              </div> 
            <?php endforeach; ?>
          </div>
      </div>
    </main>
    
    <script src="../js/app.js"></script>
</body>
</html>
