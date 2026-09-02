<?php
session_start();
require_once __DIR__ . "/../../Config/DBconnection.php";

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

if ($username === "" || $password === "") {
    $_SESSION["loginError"] = "Username and password are required.";
    $_SESSION["loginUsername"] = $username;
    header("Location: ../../View/Customer/login.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();
$stmt = $connection->prepare("SELECT username, password, name, email, phone, address FROM customer WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
$stmt->close();
$db->closeConnection($connection);

if (!$customer) {
    $_SESSION["loginError"] = "Invalid username or password.";
    $_SESSION["loginUsername"] = $username;
    header("Location: ../../View/Customer/login.php");
    exit();
}

session_regenerate_id(true);
$_SESSION["loggedInUsername"] = $customer["username"];
$_SESSION["customerName"] = $customer["name"];
$_SESSION["customerEmail"] = $customer["email"];
$_SESSION["customerNumber"] = $customer["phone"];
$_SESSION["customerLocation"] = $customer["address"];
$_SESSION["isLoggedIn"] = true;
$_SESSION["cart"] = $_SESSION["cart"] ?? [];
header("Location: ../../View/Customer/dashboard.php");
exit();
?>
