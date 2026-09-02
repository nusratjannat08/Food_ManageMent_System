<?php

class restaurantQueries
{
 

  function restaurantSignup($connection,$tableName,$username,$password,$name,$email,$phone,$address)
{

$sql = "INSERT INTO $tableName
(username,password,name,email,phone,address)
VALUES
(
'$username',
'$password',
'$name',
'$email',
'$phone',
'$address'
)";

$result = $connection->query($sql);

return $result;

}
function restaurantLogin($connection, $tableName, $username, $password)
{
    $sql = "SELECT * FROM $tableName
            WHERE username='$username'
            AND password='$password'";

    $result = $connection->query($sql);

    return $result;
}

 function getRestaurantInfo($connection,$tableName,$username)
    {
        $sql = "SELECT * FROM $tableName
                WHERE username='$username'";

        return $connection->query($sql);
    }

    function addFood($connection,$restaurant_username,$food_name,$description,$price,$available)
{
    $sql = "INSERT INTO menu
            (restaurant_username,food_name,description,price,available)
            VALUES
            (
                '$restaurant_username',
                '$food_name',
                '$description',
                '$price',
                '$available'
            )";

    return $connection->query($sql);
}

function getRestaurantMenu($connection,$restaurant_username)
{
    $sql = "SELECT * FROM menu
            WHERE restaurant_username='$restaurant_username'
            ORDER BY food_id ASC";

    return $connection->query($sql);
}


function deleteFood($connection,$food_id,$restaurant_username)
{
    $sql = "DELETE FROM menu
            WHERE food_id='$food_id'
            AND restaurant_username='$restaurant_username'";

    return $connection->query($sql);
}


function getFood($connection,$food_id,$restaurant_username)
{
    $sql = "SELECT * FROM menu
            WHERE food_id='$food_id'
            AND restaurant_username='$restaurant_username'";

    return $connection->query($sql);
}

function updateFoodAvailability($connection,$food_id,$restaurant_username,$available)
{
    $sql = "UPDATE menu
            SET available='$available'
            WHERE food_id='$food_id'
            AND restaurant_username='$restaurant_username'";

    return $connection->query($sql);
}


function getIncomingOrders($connection,$restaurant_username)
{
    $sql = "SELECT
                o.order_id,
                o.order_date,
                o.status,
                c.name AS customer_name,
                c.phone AS customer_phone,
                d.name AS deliveryman_name,
                d.phone AS deliveryman_phone,
                SUM(oi.quantity * m.price) AS total_price
            FROM orders o
            INNER JOIN customer c
                ON o.customer_username=c.username
            LEFT JOIN deliveryman d
                ON o.deliveryman_username=d.username
            INNER JOIN order_items oi
                ON o.order_id=oi.order_id
            INNER JOIN menu m
                ON oi.food_id=m.food_id
            WHERE o.restaurant_username='$restaurant_username'
            GROUP BY
                o.order_id,
                o.order_date,
                o.status,
                c.name,
                c.phone,
                d.name,
                d.phone
            ORDER BY
                CASE
                    WHEN o.status='pending' THEN 1
                    WHEN o.status='accepted' THEN 2
                    WHEN o.status='cancelled' THEN 3
                    ELSE 4
                END,
                o.order_date DESC";

    return $connection->query($sql);
}


function getOrderItems($connection,$order_id,$restaurant_username)
{
    $sql = "SELECT
                m.food_name,
                oi.quantity,
                m.price,
                (oi.quantity * m.price) AS item_total
            FROM order_items oi
            INNER JOIN menu m
                ON oi.food_id=m.food_id
            INNER JOIN orders o
                ON oi.order_id=o.order_id
            WHERE oi.order_id='$order_id'
            AND o.restaurant_username='$restaurant_username'
            ORDER BY m.food_name ASC";

    return $connection->query($sql);
}


function updateOrderStatus($connection,$order_id,$restaurant_username,$status)
{
    $sql = "UPDATE orders
            SET status='$status'
            WHERE order_id='$order_id'
            AND restaurant_username='$restaurant_username'
            AND status='pending'";

    return $connection->query($sql);
}
function checkUsername($connection, $tableName, $username)
{
    $sql = "SELECT username FROM $tableName
            WHERE username='$username'";

    return $connection->query($sql);
}
}

?>