<?php
session_start();
require_once __DIR__ . "/../../Model/Customer/customerQueries.php";

if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: ../../View/Customer/login.php");
    exit();
}

$_SESSION["cart"] = $_SESSION["cart"] ?? [];
$foodId = (int)($_POST["food_id"] ?? 0);
$action = $_POST["action"] ?? "";

if ($action === "remove") {
    unset($_SESSION["cart"][$foodId]);
} elseif ($action === "increase" && isset($_SESSION["cart"][$foodId])) {
    $foods = getFoodsByIds([$foodId]);
    if (isset($foods[$foodId])) {
        $_SESSION["cart"][$foodId]++;
    }
} elseif ($action === "decrease" && isset($_SESSION["cart"][$foodId])) {
    $_SESSION["cart"][$foodId]--;
    if ($_SESSION["cart"][$foodId] <= 0) {
        unset($_SESSION["cart"][$foodId]);
    }
} elseif ($action === "order") {
    $selected = array_values(array_unique(array_map("intval", $_POST["selected"] ?? [])));
    $_SESSION["selectedCart"] = $selected;
    if (count($selected) === 0) {
        $_SESSION["cartError"] = "Please select at least one food to order.";
        header("Location: ../../View/Customer/cartDetails.php");
        exit();
    }
    header("Location: ../../View/Customer/order.php");
    exit();
}

header("Location: ../../View/Customer/cartDetails.php");
exit();
?>
