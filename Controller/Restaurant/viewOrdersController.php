<?php

include "../../Config/DBconnection.php";
include "../../Model/Restaurant/restaurantQueries.php";

session_start();

if (!isset($_COOKIE["restaurantUsername"])) {
    header("Location: ../../View/Restaurant/restaurant-login.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();

$query = new restaurantQueries();

$restaurant_username = $_COOKIE["restaurantUsername"];

/* Accept / Reject */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $order_id = trim($_POST["order_id"] ?? "");
    $action = $_POST["action"] ?? "";

    $hasError = false;

    if (!$order_id || !ctype_digit($order_id) || (int)$order_id <= 0) {
        $_SESSION["orderError"] = "Invalid Order ID";
        $hasError = true;
    }

    if ($action !== "accept" && $action !== "reject") {
        $_SESSION["orderError"] = "Invalid order action";
        $hasError = true;
    }

    if (!$hasError) {

        if ($action == "accept") {
            $status = "accepted";
        } else {
            /* The orders table has no 'rejected' status.
               Therefore rejection is stored as 'cancelled'. */
            $status = "cancelled";
        }

        $result = $query->updateOrderStatus(
            $connection,
            (int)$order_id,
            $restaurant_username,
            $status
        );

        if ($result && $connection->affected_rows > 0) {
            $_SESSION["orderSuccess"] =
                ($action == "accept")
                ? "Order accepted successfully"
                : "Order rejected successfully";
        } else {
            $_SESSION["orderError"] =
                "Order was not changed. It may already have been processed.";
        }
    }
}

header("Location: ../../View/Restaurant/view-orders.php");
exit();

?>