<?php

include "../../Config/DBconnection.php";
include "../../Model/Restaurant/restaurantQueries.php";

session_start();

if (!isset($_COOKIE["restaurantUsername"])) {
    header("Location: ../../View/Restaurant/restaurant-login.php");
    exit();
}

$restaurant_username = $_COOKIE["restaurantUsername"];

$food_name   = trim($_POST["food_name"] ?? "");
$description = trim($_POST["description"] ?? "");
$price       = trim($_POST["price"] ?? "");
$available   = $_POST["available"] ?? "";

$_SESSION["food_name"] = $food_name;
$_SESSION["description"] = $description;
$_SESSION["price"] = $price;
$_SESSION["available"] = $available;

$hasError = false;

if (!$food_name) {
    $_SESSION["foodNameError"] = "Food name is required";
    $hasError = true;
}

if (!$description) {
    $_SESSION["descriptionError"] = "Description is required";
    $hasError = true;
}

if (!$price) {
    $_SESSION["priceError"] = "Price is required";
    $hasError = true;
} elseif (!is_numeric($price) || $price <= 0) {
    $_SESSION["priceError"] = "Enter a valid price";
    $hasError = true;
}

if ($available !== "1" && $available !== "0") {
    $_SESSION["availabilityError"] = "Select food availability";
    $hasError = true;
}

if ($hasError) {
    header("Location: ../../View/Restaurant/add-food.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();

$query = new restaurantQueries();

$food_name = $connection->real_escape_string($food_name);
$description = $connection->real_escape_string($description);
$price = (float)$price;
$available = (int)$available;

$result = $query->addFood(
    $connection,
    $restaurant_username,
    $food_name,
    $description,
    $price,
    $available
);

if ($result) {
    unset(
        $_SESSION["food_name"],
        $_SESSION["description"],
        $_SESSION["price"],
        $_SESSION["available"]
    );

    $_SESSION["successMessage"] = "Food added successfully";
} else {
    $_SESSION["foodNameError"] = "Failed to add food: " . $connection->error;
}

header("Location: ../../View/Restaurant/add-food.php");
exit();

?>