<?php
session_start();
require_once __DIR__ . "/../../Model/Customer/customerQueries.php";

if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: ../../View/Customer/login.php");
    exit();
}

$foodId = (int)($_POST["food_id"] ?? 0);
$foods = getFoodsByIds([$foodId]);

if (isset($foods[$foodId])) {
    $_SESSION["cart"] = $_SESSION["cart"] ?? [];
    $_SESSION["cart"][$foodId] = ($_SESSION["cart"][$foodId] ?? 0) + 1;
}

header("Location: ../../View/Customer/foodDashboard.php");
exit();
?>
