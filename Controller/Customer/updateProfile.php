<?php
session_start();
require_once __DIR__ . "/../../Config/DBconnection.php";

if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: ../../View/Customer/login.php");
    exit();
}

$username = $_SESSION["loggedInUsername"];
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$address = trim($_POST["address"] ?? "");

if ($name === "" || $email === "" || $phone === "" || $address === "") {
    $_SESSION["profileError"] = "Please fill in all fields.";
    header("Location: ../../View/Customer/editProfile.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["profileError"] = "Please enter a valid email address.";
    header("Location: ../../View/Customer/editProfile.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();
$stmt = $connection->prepare("SELECT username FROM customer WHERE email = ? AND username <> ?");
$stmt->bind_param("ss", $email, $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $stmt->close();
    $db->closeConnection($connection);
    $_SESSION["profileError"] = "That email is already in use.";
    header("Location: ../../View/Customer/editProfile.php");
    exit();
}
$stmt->close();

$stmt = $connection->prepare("UPDATE customer SET name = ?, email = ?, phone = ?, address = ? WHERE username = ?");
$stmt->bind_param("sssss", $name, $email, $phone, $address, $username);
$stmt->execute();
$stmt->close();
$db->closeConnection($connection);

$_SESSION["customerName"] = $name;
$_SESSION["customerEmail"] = $email;
$_SESSION["customerNumber"] = $phone;
$_SESSION["customerLocation"] = $address;
header("Location: ../../View/Customer/dashboard.php");
exit();
?>
