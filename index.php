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

$user = $_SESSION['username'] ?? $_SESSION['name'] ?? (isset($_SESSION['email']) ? explode('@', $_SESSION['email'])[0] : 'Guest');

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
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
      <div class="navbar__container">
        <a href="index.php" id="navbar__logo">
          <i class="fas fa-gamepad"></i>
        </a>


        <li class="navbar__btn">
          <div class="dropdown">
            <button class="btn dropdown-toggle" onclick="toggleDropdown()">
              <i class="fa-solid fa-user"></i>
              <a href="./php/login_forum.php" class="btn" id="signupBtn">Sign Up</a>
            </button>
          </div>
        </li>
      </div>
    </nav>

     <div class="hero-banner" style="background-image: url('./imgs/navbarimg.jpg');"></div>

    
    <script src="../js/app.js"></script>
</body>
</html>
