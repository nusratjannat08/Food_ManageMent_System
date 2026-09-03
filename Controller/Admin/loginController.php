<?php
session_start();
require_once(__DIR__ . "/../Model/AdminModel.php");

$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

$_SESSION["username"] = $username;
$hasUsernameError = $hasPasswordError = true;

if (!$username) {
    $_SESSION["usernameError"] = "Username is required";
} else {
    unset($_SESSION["usernameError"]);
    $hasUsernameError = false;
}

if (!$password) {
    $_SESSION["passwordError"] = "Password is required";
} else {
    unset($_SESSION["passwordError"]);
    $hasPasswordError = false;
}

if ($hasUsernameError || $hasPasswordError) {
    Header("Location: ../View/login.php");
} else {
    $model = new AdminModel();
    $admin = $model->login($username, $password);

    if ($admin) {
        $_SESSION["loggedInUsername"] = $username;
        $_SESSION["isLoggedIn"] = true;
        Header("Location: ../View/dashboard.php");
        exit();
    } else {
        $_SESSION["loginError"] = "Invalid username or password";
        Header("Location: ../View/login.php");
    }
}
