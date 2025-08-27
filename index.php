<?php
session_start();
if(isset($_SESSION['email'])){
    if($_SESSION['role'] === 'admin'){
        header("Location: ./php/admin_index.php");
        exit();
    } else {
        header("Location: ./php/user_index.php");
        exit();
    }
}
$title = "Ecom Games";

$errors = [
    'login'    => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];

$activeForm = $_SESSION['active_form'] ?? 'login';


session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="./css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
      <div class="navbar__container">
        <a href="index.php" id="navbar__logo">
          <i class="fas fa-gamepad"></i>
        </a>

        <ul class="navbar__menu">
          <li class="navbar__item">
            <a href="#" class="navbar__links">MatchUp Guide</a>
          </li>
          <li class="navbar__item">
            <a href="#" class="navbar__links">Character Guide</a>
          </li>
          <li class="navbar__item">
            <a href="#" class="navbar__links">Forum</a>
          </li>
          <li class="navbar__item">
            <a href="#" class="navbar__links">Frame Data</a>
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
              <a href="./php/login_forum.php" class="btn" id="signupBtn">
                <i class="fa-solid fa-user"></i> Login
              </a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </nav>

    <div class="hero-banner"></div>
    
    <main class="main">
      <div class="main__container">
        <div class="main__content">
          <h1>Welcome back, <?php echo $user; ?> 👋</h1>
          <h2>Admin Dashboard</h2>
          <p>Manage users, settings and content from here.</p>
          <button class="main__btn"><a href="#">Go to Panel</a></button>
        </div>
        <div class="main-img--container">
          <img src="./img/ctrail.jpg" alt="dashboard preview" id="main-img">
        </div>
      </div>
    </main>
    
    <script src="./js/app.js"></script>
</body>
</html>
