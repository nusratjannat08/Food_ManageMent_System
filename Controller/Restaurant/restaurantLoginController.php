<?php

include "../../Config/DBConnection.php";
include "../../Model/Restaurant/restaurantQueries.php";

session_start();

$username = $_POST["username"];
$password = $_POST["password"];

$hasUsernameError = false;
$hasPasswordError = false;

if(!$username){
    $_SESSION["usernameError"] = "Username Required";
    $hasUsernameError = true;
}

if(!$password){
    $_SESSION["passwordError"] = "Password Required";
    $hasPasswordError = true;
}

if($hasUsernameError || $hasPasswordError){
    header("Location: ../../View/Restaurant/restaurant-login.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();

$query = new restaurantQueries();

$result = $query->restaurantLogin(
    $connection,
    "restaurant",
    $username,
    $password
);

if($result->num_rows > 0){

    $_SESSION["isLoggedIn"] = true;

    setcookie(
        "restaurantUsername",
        $username,
        time()+3600,
        "/"
    );

    header("Location: ../../View/Restaurant/restaurant-dashboard.php");
    exit();

}else{

    $_SESSION["passwordError"] = "Invalid Username or Password";

    header("Location: ../../View/Restaurant/restaurant-login.php");
    exit();

}
?>