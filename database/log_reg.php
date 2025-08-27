<?php
require_once "database_init.php";
session_start();

$db = new Database();
$conn = $db->getConnection();


define('REMEMBER_COOKIE_NAME', 'rememberme');
define('REMEMBER_COOKIE_EXPIRE', 60*60*24*30);

function set_remember_cookie($userId, $token) {
    setcookie(REMEMBER_COOKIE_NAME, $userId . ':' . $token, time() + REMEMBER_COOKIE_EXPIRE, '/', '', false, true);
}

function clear_remember_cookie() {
    setcookie(REMEMBER_COOKIE_NAME, '', time() - 3600, '/', '', false, true);
}

if (isset($_POST["register"])) {
    $username = trim($_POST['username']); 
    $email = trim($_POST['email']); 
    $password = $_POST['password']; 
    $confirm = $_POST['confirm_password']; 
    $role = 'user';

    if ($password !== $confirm) {
        $_SESSION['register_error'] = htmlspecialchars("Passwords are not matching!", ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $_SESSION['active_form'] = 'register';
        header("Location: ../php/login_forum.php");
        exit;
    }

    if (strlen($password) < 8) {
        $_SESSION['register_error'] = htmlspecialchars("Password must be at least 8 characters long!", ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $_SESSION['active_form'] = 'register';
        header("Location: ../php/login_forum.php");
        exit;
    }

    if (!preg_match('/[A-Z]/', $password) || 
        !preg_match('/[a-z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[\W]/', $password)) {
        $_SESSION['register_error'] = htmlspecialchars("Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character!", ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $_SESSION['active_form'] = 'register';
        header("Location: ../php/login_forum.php");
        exit;
    }

    $conn = $db->getConnection();
    $check = $conn->prepare("SELECT id FROM ".TBL_USERS." WHERE ".COL_EMAIL." = :email");
    $check->bindValue(":email", $email);
    $check->execute();

    if ($check->rowCount() > 0) {
        $_SESSION['register_error'] = htmlspecialchars('Email already exists!', ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $_SESSION['active_form'] = 'register';
        header("Location: ../php/login_forum.php");
        exit;
    }

    if ($db->insertVezbe($username, $email, $password, $role)) {
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $username;
        $_SESSION['role'] = $role;
        header("Location: ../php/user_index.php");
        exit;
    } else {
        $_SESSION['register_error'] = htmlspecialchars('Registration failed!', ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $_SESSION['active_form'] = 'register';
        header("Location: ../index.php");
        exit;
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $conn = $db->getConnection(); 
	$stmt = $conn->prepare("SELECT * FROM ".TBL_USERS." WHERE ".COL_EMAIL." = :email"); 
	$stmt->bindValue(":email", $email); 
	$stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user[COL_PASSWORD])) {
            $_SESSION['name']  = $user[COL_USERNAME];
            $_SESSION['username'] = $user[COL_USERNAME];
            $_SESSION['email'] = $user[COL_EMAIL];
			$_SESSION['role'] = $user[COL_ROLE];
            $_SESSION['user_id'] = $user['id'];

            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $db->setRememberToken($user['id'], $token);
                set_remember_cookie($user['id'], $token);
            } else {
                $db->clearRememberToken($user['id']);
                clear_remember_cookie();
            }

            if ($user[COL_ROLE] === 'admin') {
                header("Location: ../php/admin_index.php");
            } else {
                header("Location: ../php/user_index.php");
            }
            exit();
        }
    }

    $_SESSION['login_error'] = htmlspecialchars('Incorrect email or password', ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $_SESSION['active_form'] = 'login';
	header("Location: ../php/login_forum.php");
    exit();
}


if (isset($_GET['logout']) && isset($_SESSION['user_id'])) {
    $db->clearRememberToken($_SESSION['user_id']);
    clear_remember_cookie();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}
