<?php
session_start();
require_once __DIR__ . "/../../Config/DBconnection.php";
require_once __DIR__ . "/../../Model/Customer/customerQueries.php";

if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: ../../View/Customer/login.php");
    exit();
}

$username = $_SESSION["loggedInUsername"];
$name = trim($_POST["name"] ?? "");
$number = trim($_POST["number"] ?? "");
$address = trim($_POST["address"] ?? "");
$payment = $_POST["payment_method"] ?? "";
$selected = array_values(array_unique(array_map("intval", $_SESSION["selectedCart"] ?? [])));
$cart = $_SESSION["cart"] ?? [];

if ($name === "" || $number === "" || $address === "" || !in_array($payment, ["cash", "bkash", "nagad"], true) || count($selected) === 0) {
    $_SESSION["orderError"] = "Please enter your name, number, address, payment method, and select food.";
    $_SESSION["orderName"] = $name;
    $_SESSION["orderNumber"] = $number;
    $_SESSION["orderAddress"] = $address;
    header("Location: ../../View/Customer/order.php");
    exit();
}

$foods = getFoodsByIds($selected);
$itemsByRestaurant = [];
$total = 0;

foreach ($selected as $foodId) {
    if (!isset($foods[$foodId]) || !isset($cart[$foodId])) {
        continue;
    }
    $quantity = max(1, (int)$cart[$foodId]);
    $food = $foods[$foodId];
    $lineTotal = (float)$food["price"] * $quantity;
    $restaurant = $food["restaurant_username"];
    $itemsByRestaurant[$restaurant][] = [
        "food_id" => $foodId,
        "food_name" => $food["food_name"],
        "price" => (float)$food["price"],
        "quantity" => $quantity,
        "line_total" => $lineTotal
    ];
    $total += $lineTotal;
}

if (empty($itemsByRestaurant)) {
    $_SESSION["orderError"] = "The selected food is no longer available.";
    header("Location: ../../View/Customer/cartDetails.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();
$connection->begin_transaction();
$createdOrders = [];

try {
    foreach ($itemsByRestaurant as $restaurant => $items) {
        $stmt = $connection->prepare("INSERT INTO orders (customer_username, restaurant_username, order_date, status) VALUES (?, ?, NOW(), 'pending')");
        $stmt->bind_param("ss", $username, $restaurant);
        $stmt->execute();
        $orderId = $connection->insert_id;
        $stmt->close();

        $itemStmt = $connection->prepare("INSERT INTO order_items (order_id, food_id, quantity) VALUES (?, ?, ?)");
        foreach ($items as $item) {
            $itemStmt->bind_param("iii", $orderId, $item["food_id"], $item["quantity"]);
            $itemStmt->execute();
        }
        $itemStmt->close();
        $createdOrders[] = $orderId;
    }
    $connection->commit();
} catch (Throwable $e) {
    $connection->rollback();
    $db->closeConnection($connection);
    $_SESSION["orderError"] = "The order could not be placed.";
    header("Location: ../../View/Customer/order.php");
    exit();
}

$db->closeConnection($connection);

foreach ($selected as $foodId) {
    unset($_SESSION["cart"][$foodId]);
}
$_SESSION["selectedCart"] = [];
$_SESSION["lastOrderIds"] = $createdOrders;
$_SESSION["lastPaymentMethod"] = $payment;
$_SESSION["lastOrderTotal"] = $total;
header("Location: ../../View/Customer/orderHistory.php");
exit();
?>
