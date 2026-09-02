<?php

include "../../Config/DBconnection.php";
include "../../Model/Restaurant/restaurantQueries.php";

session_start();

if (!isset($_COOKIE["restaurantUsername"])) {
    header("Location: ../../View/Restaurant/restaurant-login.php");
    exit();
}

$restaurant_username = $_COOKIE["restaurantUsername"];
$food_id = trim($_POST["food_id"] ?? "");

if (!$food_id) {
    $_SESSION["deleteError"] = "Food ID is required";
    header("Location: ../../View/Restaurant/delete-food.php");
    exit();
}

if (!ctype_digit($food_id) || (int)$food_id <= 0) {
    $_SESSION["deleteError"] = "Enter a valid Food ID";
    header("Location: ../../View/Restaurant/delete-food.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();

$query = new restaurantQueries();

$result = $query->getFood(
    $connection,
    (int)$food_id,
    $restaurant_username
);

if (!$result || $result->num_rows == 0) {
    $_SESSION["deleteError"] = "Food not found in your menu";
    header("Location: ../../View/Restaurant/delete-food.php");
    exit();
}

$deleteResult = $query->deleteFood(
    $connection,
    (int)$food_id,
    $restaurant_username
);

if ($deleteResult) {
    $_SESSION["deleteSuccess"] = "Food deleted successfully";
} else {
    $_SESSION["deleteError"] = "Food could not be deleted. It may already be used in an order.";
}

header("Location: ../../View/Restaurant/delete-food.php");
exit();

?>