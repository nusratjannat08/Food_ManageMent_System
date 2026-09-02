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
$available = $_POST["available"] ?? "";

if (!$food_id) {
    $_SESSION["updateError"] = "Food ID is required";
    header("Location: ../../View/Restaurant/update-availability.php");
    exit();
}

if (!ctype_digit($food_id) || (int)$food_id <= 0) {
    $_SESSION["updateError"] = "Invalid Food ID";
    header("Location: ../../View/Restaurant/update-availability.php");
    exit();
}

if ($available !== "1" && $available !== "0") {
    $_SESSION["updateError"] = "Invalid availability";
    header("Location: ../../View/Restaurant/update-availability.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();

$query = new restaurantQueries();

$foodResult = $query->getFood(
    $connection,
    (int)$food_id,
    $restaurant_username
);

if (!$foodResult || $foodResult->num_rows == 0) {
    $_SESSION["updateError"] = "Food not found in your menu";
    header("Location: ../../View/Restaurant/update-availability.php");
    exit();
}

$result = $query->updateFoodAvailability(
    $connection,
    (int)$food_id,
    $restaurant_username,
    (int)$available
);

if ($result) {
    $_SESSION["updateSuccess"] = "Food availability updated successfully";
} else {
    $_SESSION["updateError"] = "Failed to update food availability";
}

header("Location: ../../View/Restaurant/update-availability.php");
exit();

?>