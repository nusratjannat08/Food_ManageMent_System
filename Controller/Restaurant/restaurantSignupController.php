<?php
include "../../Config/DBConnection.php";
include "../../Model/Restaurant/restaurantQueries.php";

session_start();

$username        = $_POST["username"];
$name            = $_POST["name"];
$email           = $_POST["email"];
$phone           = $_POST["phone"];
$address         = $_POST["address"];
$password        = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

$_SESSION["username"] = $username;
$_SESSION["name"]     = $name;
$_SESSION["email"]    = $email;
$_SESSION["phone"]    = $phone;
$_SESSION["address"]  = $address;

$hasError = false;

if (!$username) { $_SESSION["usernameError"] = "Username is required"; $hasError = true; }
if (!$name)     { $_SESSION["nameError"] = "Restaurant name is required"; $hasError = true; }
if (!$email)    { $_SESSION["emailError"] = "Email is required"; $hasError = true; }
if (!$phone)    { $_SESSION["phoneError"] = "Phone is required"; $hasError = true; }
if (!$address)  { $_SESSION["addressError"] = "Address is required"; $hasError = true; }
if (!$password) { $_SESSION["passwordError"] = "Password is required"; $hasError = true; }
if (!$confirmPassword || $confirmPassword !== $password) {
    $_SESSION["confirmError"] = "Passwords do not match";
    $hasError = true;
}

if ($hasError) {
    Header("Location: ../../View/Restaurant/restaurant-signup.php");
    exit;
}

$db = new DatabaseConnection();
$connection = $db->openConnection();
$query = new restaurantQueries();
$result = $query->restaurantSignup($connection, "restaurant", $username, $password, $name, $email, $phone, $address);

if ($result) {
    unset($_SESSION["username"], $_SESSION["name"], $_SESSION["email"], $_SESSION["phone"], $_SESSION["address"]);
    Header("Location: ../../View/Restaurant/restaurant-login.php");
    exit;
} else {
    $_SESSION["usernameError"] = "Failed to signup: " . $connection->error;
    Header("Location: ../../View/Restaurant/restaurant-signup.php");
    exit;
}