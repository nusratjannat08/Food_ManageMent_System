<?php
require_once __DIR__ . "/../../Config/DBconnection.php";

function getCustomer($username)
{
    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    $stmt = $connection->prepare("SELECT username, name, email, phone, address FROM customer WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
    $stmt->close();
    $db->closeConnection($connection);
    return $customer;
}

function getAvailableFoods($search = "")
{
    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    if ($search !== "") {
        $like = "%" . $search . "%";
        $stmt = $connection->prepare("SELECT food_id, restaurant_username, food_name, description, price, available FROM menu WHERE available = TRUE AND food_name LIKE ? ORDER BY food_id DESC");
        $stmt->bind_param("s", $like);
    } else {
        $stmt = $connection->prepare("SELECT food_id, restaurant_username, food_name, description, price, available FROM menu WHERE available = TRUE ORDER BY food_id DESC");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $foods = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $db->closeConnection($connection);
    return $foods;
}

function getFoodsByIds($ids)
{
    if (empty($ids)) {
        return [];
    }
    $ids = array_values(array_unique(array_map("intval", $ids)));
    $placeholders = implode(",", array_fill(0, count($ids), "?"));
    $types = str_repeat("i", count($ids));
    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    $stmt = $connection->prepare("SELECT food_id, restaurant_username, food_name, description, price, available FROM menu WHERE food_id IN ($placeholders) AND available = TRUE");
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $result = $stmt->get_result();
    $foods = [];
    while ($row = $result->fetch_assoc()) {
        $foods[(int)$row["food_id"]] = $row;
    }
    $stmt->close();
    $db->closeConnection($connection);
    return $foods;
}

function getCustomerOrders($username)
{
    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    $stmt = $connection->prepare("SELECT o.order_id, o.restaurant_username, o.order_date, o.status, m.food_name, m.price, oi.quantity FROM orders o INNER JOIN order_items oi ON o.order_id = oi.order_id INNER JOIN menu m ON oi.food_id = m.food_id WHERE o.customer_username = ? ORDER BY o.order_date DESC, o.order_id DESC");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orderId = (int)$row["order_id"];
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = [
                "order_id" => $orderId,
                "restaurant_username" => $row["restaurant_username"],
                "order_date" => $row["order_date"],
                "status" => $row["status"],
                "items" => [],
                "total" => 0
            ];
        }
        $lineTotal = (float)$row["price"] * (int)$row["quantity"];
        $orders[$orderId]["items"][] = [
            "food_name" => $row["food_name"],
            "price" => (float)$row["price"],
            "quantity" => (int)$row["quantity"],
            "line_total" => $lineTotal
        ];
        $orders[$orderId]["total"] += $lineTotal;
    }
    $stmt->close();
    $db->closeConnection($connection);
    return array_values($orders);
}
?>
