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
    </style>
</head>

<body>

<div class="page">

    <h1>Incoming Orders</h1>

    <?php

    $orders = [
        [
            "order_id" => 1001,
            "customer" => "Rahim",
            "status" => "Pending",

            "items" => [
                [
                    "food" => "Chicken Burger",
                    "quantity" => 2,
                    "price" => 250
                ],

                [
                    "food" => "French Fries",
                    "quantity" => 1,
                    "price" => 120
                ]
            ]
        ],

        [
            "order_id" => 1002,
            "customer" => "Karim",
            "status" => "Pending",

            "items" => [
                [
                    "food" => "Pizza",
                    "quantity" => 1,
                    "price" => 500
                ]
            ]
        ]
    ];

    foreach ($orders as $order) {
    ?>

        <div class="order">

            <h2>
                Order #<?php echo $order["order_id"]; ?>
            </h2>

            <p>
                <strong>Customer:</strong>
                <?php echo $order["customer"]; ?>
            </p>

            <table>

                <tr>
                    <th>Food</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>

                <?php foreach ($order["items"] as $item) { ?>

                    <tr>
                        <td>
                            <?php echo $item["food"]; ?>
                        </td>

                        <td>
                            <?php echo $item["quantity"]; ?>
                        </td>

                        <td>
                            ৳<?php echo $item["price"]; ?>
                        </td>
                    </tr>

                <?php } ?>

            </table>

            <p>
                <strong>Status:</strong>
                <?php echo $order["status"]; ?>
            </p>

            <form method="POST">

                <input
                    type="hidden"
                    name="order_id"
                    value="<?php echo $order["order_id"]; ?>"
                >

                <button
                    type="submit"
                    name="action"
                    value="accept"
                >
                    Accept
                </button>

                <button
                    type="submit"
                    name="action"
                    value="reject"
                    class="reject"
                >
                    Reject
                </button>

            </form>

        </div>

    <?php
    }
    ?>

    <button class="back">
        Back to Dashboard
    </button>

</div>

</body>
</html>