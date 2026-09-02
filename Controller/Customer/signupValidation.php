<?php
session_start();
require_once __DIR__ . "/../../Config/DBconnection.php";

$isAjax = isset($_SERVER["HTTP_X_REQUESTED_WITH"]) 
    && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest";
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$address = trim($_POST["address"] ?? "");

$_SESSION["signupUsername"] = $username;
$_SESSION["signupName"] = $name;
$_SESSION["signupEmail"] = $email;
$_SESSION["signupPhone"] = $phone;
$_SESSION["signupAddress"] = $address;

if ($username === "" || $password === "" || $name === "" || $email === "" || $phone === "" || $address === "") {
    $_SESSION["signupError"] = "Please fill in all fields.";

    if ($isAjax) {
        header("Content-Type: application/json");
        echo json_encode([
            "success" => false,
            "message" => "Please fill in all fields."
        ]);
        exit();
    }

    header("Location: ../../View/Customer/signup.php");
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["signupError"] = "Please enter a valid email address.";

    if ($isAjax) {
        header("Content-Type: application/json");
        echo json_encode([
            "success" => false,
            "message" => "Please enter a valid email address."
        ]);
        exit();
    }

    header("Location: ../../View/Customer/signup.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();
$stmt = $connection->prepare("SELECT username FROM customer WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $stmt->close();
    $db->closeConnection($connection);
    $_SESSION["signupError"] = "Username or email already exists.";

    if ($isAjax) {
        header("Content-Type: application/json");
        echo json_encode([
            "success" => false,
            "message" => "Username or email already exists."
        ]);
        exit();
    }

    header("Location: ../../View/Customer/signup.php");
    exit();
}
$stmt->close();

$stmt = $connection->prepare("INSERT INTO customer (username, password, name, email, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $username, $password, $name, $email, $phone, $address);
$success = $stmt->execute();
$stmt->close();
$db->closeConnection($connection);

if (!$success) {
    $_SESSION["signupError"] = "Account could not be created.";

    if ($isAjax) {
        header("Content-Type: application/json");
        echo json_encode([
            "success" => false,
            "message" => "Account could not be created."
        ]);
        exit();
    }

    header("Location: ../../View/Customer/signup.php");
    exit();
}
unset($_SESSION["signupUsername"], $_SESSION["signupName"], $_SESSION["signupEmail"], $_SESSION["signupPhone"], $_SESSION["signupAddress"], $_SESSION["signupError"]);
$_SESSION["loginMessage"] = "Account created successfully. Please login.";

if ($isAjax) {
    header("Content-Type: application/json");
    echo json_encode([
        "success" => true,
        "message" => "Account created successfully. Redirecting to login...",
        "redirect" => "login.php"
    ]);
    exit();
}

header("Location: ../../View/Customer/login.php");
exit();
?>
