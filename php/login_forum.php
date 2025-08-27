<?php
session_start();
require_once dirname(__DIR__) . '/database/database_init.php';

if (!isset($_SESSION['email']) && isset($_COOKIE['rememberme'])) {
    $db = new Database();
    list($userId, $token) = explode(':', $_COOKIE['rememberme'], 2);
    $user = $db->getUserByRememberToken($userId, $token);
    if ($user) {
        $_SESSION['name']  = $user[COL_USERNAME];
        $_SESSION['email'] = $user[COL_EMAIL];
        $_SESSION['role']  = $user[COL_ROLE];
        $_SESSION['user_id'] = $user['id'];
        if ($user[COL_ROLE] === 'admin') {
            header("Location: admin_index.php");
            exit();
        } else {
            header("Location: user_index.php");
            exit();
        }
    } else {
        setcookie('rememberme', '', time() - 3600, '/', '', false, true);
    }
}

if (isset($_SESSION['email']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin_index.php");
        exit();
    } else {
        header("Location: user_index.php");
        exit();
    }
}


$errors = [
    'login'    => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

unset($_SESSION['login_error'], $_SESSION['register_error'], $_SESSION['active_form']);

function showError($error) {
    return !empty($error) ? "<p class='error-message'>" . htmlspecialchars($error, ENT_QUOTES | ENT_HTML5, 'UTF-8') . "</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>
  <div class="wrapper">
    <div class="form-box <?= isActiveForm('login',$activeForm); ?>" id="login-form">
      <form method="post" action="../database/log_reg.php">
        <h2>Login Form</h2>
        <?= showError($errors['login']); ?>
        <div class="input-field">
          <input type="text" name="email" required />
          <label>Enter your email</label>
        </div>
        <div class="input-field">
          <input type="password" name="password" required />
          <label>Enter your password</label>
        </div>
        <div class="forget">
          <label for="remember">
            <input type="checkbox" id="remember" name="remember">
            <p>Remember me</p>
          </label>
          <a href="#">Forgot password?</a>
        </div>
        <button type="submit" action="../database/log_reg.php" name="login">Login</button>
        <div class="register">
          <p>Don't have an account? 
            <a href="#" onclick="showForm('register-form')">Register</a>
          </p>
        </div>
      </form>
    </div>
    <div class="form-box <?= isActiveForm('register',$activeForm); ?>" id="register-form">
      <form method="post" action="../database/log_reg.php">
        <h2>Registration Form</h2>
        <?= showError($errors['register']); ?>
        <div class="input-field">
          <input type="text" name="username"required />
          <label>Enter your username</label>
        </div>
        <div class="input-field">
          <input type="email" name="email" required />
          <label>Enter your email</label>
        </div>
        <div class="input-field">
          <input type="password" name="password" required />
          <label>Enter your password</label>
        </div>
        <div class="input-field">
          <input type="password" name="confirm_password"required />
          <label>Confirm your password</label>
        </div>
        <div class="forget">
          <label for="remember">
            <input type="checkbox" id="remember">
            <p>Remember me</p>
          </label>
          <a href="#">Forgot password?</a>
        </div>
        <button type="submit" action="../database/log_reg.php" name="register">Register</button>
        <div class="register">
          <p>Already have an account? 
            <a href="#" onclick="showForm('login-form')">Log In</a>
          </p>
        </div>
      </form>
    </div>
  </div>
  
  <script src="../js/app.js"></script>
</body>
</html>
