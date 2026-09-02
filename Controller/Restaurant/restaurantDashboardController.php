<?php
session_start();

if (!isset($_COOKIE["restaurantUsername"])) {
    header("Location: restaurant-login.php");
    exit();
}

include "../../Config/DBConnection.php";
include "../../Model/Restaurant/restaurantQueries.php";

$db = new DatabaseConnection();
$connection = $db->openConnection();

$query = new restaurantQueries();

$result = $query->getRestaurantInfo(
    $connection,
    "restaurant",
    $_COOKIE["restaurantUsername"]
);

if ($result && $result->num_rows > 0) {

    $restaurant = $result->fetch_assoc();

    
    $_SESSION["restaurant"] = $restaurant;
    $_SESSION["isLoggedIn"] = true;

 
    header("Location: ../../View/Restaurant/restaurant-dashboard.php");
    exit();

} else {

    session_destroy();


    header("Location: ../../View/Restaurant/restaurant-login.php");
    exit();
}
?>