<?php
session_start();

if (!isset($_COOKIE["restaurantUsername"])) {
    header("Location: restaurant-login.php");
    exit();
}

include "../../Config/DBconnection.php";
include "../../Model/Restaurant/restaurantQueries.php";

$db = new DatabaseConnection();
$connection = $db->openConnection();
$query = new restaurantQueries();

$restaurant_username = $_COOKIE["restaurantUsername"];

$result = $query->getIncomingOrders(
    $connection,
    $restaurant_username
);

$orderError = $_SESSION["orderError"] ?? "";
$orderSuccess = $_SESSION["orderSuccess"] ?? "";

unset($_SESSION["orderError"]);
unset($_SESSION["orderSuccess"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Incoming Orders</title>

    <style>
        body {
            margin: 0;
            background-color: #f7f4df;
            font-family: Arial, sans-serif;
            color: #263b25;
        }

        .page {
            width: 850px;
            margin: 50px auto;
        }

        h1 {
            color: #31572c;
        }

        .section-title {
            color: #31572c;
            margin-top: 25px;
        }

        .order {
            background-color: #fffef4;
            border: 2px solid #d4a017;
            padding: 20px;
            margin-bottom: 20px;
        }

        .order h2 {
            color: #31572c;
            margin-top: 0;
        }

        .people {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .person {
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background-color: #31572c;
            color: white;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        button {
            padding: 8px 15px;
            margin-top: 10px;
            margin-right: 5px;
            background-color: #31572c;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #496f32;
        }

        .reject {
            background-color: #8a6d1d;
        }

        .reject:hover {
            background-color: #a38428;
        }

        .back {
            background-color: #d4a017;
            color: #263b25;
        }

        .status {
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="page">

    <h1>Incoming Orders</h1>

    <?php if ($orderError) { ?>
        <p style="color:red"><?php echo $orderError; ?></p>
    <?php } ?>

    <?php if ($orderSuccess) { ?>
        <p style="color:green"><?php echo $orderSuccess; ?></p>
    <?php } ?>

    <?php

    if ($result && $result->num_rows > 0) {

        $hasPending = false;
        $hasProcessed = false;

        while ($order = $result->fetch_assoc()) {

            if ($order["status"] == "pending" && !$hasPending) {
                $hasPending = true;
                echo '<h2 class="section-title">Unaccepted Orders</h2>';
            }

            if ($order["status"] != "pending" && !$hasProcessed) {
                $hasProcessed = true;
                echo '<h2 class="section-title">Accepted / Rejected Orders</h2>';
            }
    ?>

        <div class="order">

            <h2>
                Order #<?php echo $order["order_id"]; ?>
            </h2>

            <div class="people">

                <div class="person">
                    <p>
                        <strong>Customer:</strong>
                        <?php echo htmlspecialchars($order["customer_name"]); ?>
                    </p>

                    <p>
                        <strong>Customer Phone:</strong>
                        <?php echo htmlspecialchars($order["customer_phone"]); ?>
                    </p>
                </div>

                <div class="person">
                    <p>
                        <strong>Deliveryman:</strong>
                        <?php
                        echo $order["deliveryman_name"]
                            ? htmlspecialchars($order["deliveryman_name"])
                            : "Not assigned";
                        ?>
                    </p>

                    <p>
                        <strong>Deliveryman Phone:</strong>
                        <?php
                        echo $order["deliveryman_phone"]
                            ? htmlspecialchars($order["deliveryman_phone"])
                            : "Not assigned";
                        ?>
                    </p>
                </div>

            </div>

            <p>
                <strong>Order Date:</strong>
                <?php echo htmlspecialchars($order["order_date"]); ?>
            </p>

            <table>

                <tr>
                    <th>Food</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>

                <?php
                $items = $query->getOrderItems(
                    $connection,
                    $order["order_id"],
                    $restaurant_username
                );

                if ($items && $items->num_rows > 0) {
                    while ($item = $items->fetch_assoc()) {
                ?>

                    <tr>
                        <td>
                            <?php echo htmlspecialchars($item["food_name"]); ?>
                        </td>

                        <td>
                            <?php echo $item["quantity"]; ?>
                        </td>

                        <td>
                            ৳<?php echo number_format($item["price"], 2); ?>
                        </td>

                        <td>
                            ৳<?php echo number_format($item["item_total"], 2); ?>
                        </td>
                    </tr>

                <?php
                    }
                }
                ?>

            </table>

            <p>
                <strong>Total Price:</strong>
                ৳<?php echo number_format($order["total_price"], 2); ?>
            </p>

            <p class="status">
                <strong>Status:</strong>
                <?php
                if ($order["status"] == "pending") {
                    echo "Pending";
                } elseif ($order["status"] == "accepted") {
                    echo "Accepted";
                } elseif ($order["status"] == "cancelled") {
                    echo "Rejected";
                } else {
                    echo htmlspecialchars($order["status"]);
                }
                ?>
            </p>

            <?php if ($order["status"] == "pending") { ?>

                <form action="../../Controller/Restaurant/viewOrdersController.php"
                      method="post">

                    <input type="hidden"
                           name="order_id"
                           value="<?php echo $order["order_id"]; ?>">

                    <button
                        type="submit"
                        name="action"
                        value="accept">
                        Accept
                    </button>

                    <button
                        type="submit"
                        name="action"
                        value="reject"
                        class="reject">
                        Reject
                    </button>

                </form>

            <?php } ?>

        </div>

    <?php
        }

    } else {
    ?>

        <div class="order">
            <p>No incoming orders found.</p>
        </div>

    <?php } ?>

    <a href="restaurant-dashboard.php">
        <button class="back">Back to Dashboard</button>
    </a>

</div>

</body>
</html>