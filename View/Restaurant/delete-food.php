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

$result = $query->getRestaurantMenu(
    $connection,
    $restaurant_username
);

$deleteError = $_SESSION["deleteError"] ?? "";
$deleteSuccess = $_SESSION["deleteSuccess"] ?? "";

unset($_SESSION["deleteError"]);
unset($_SESSION["deleteSuccess"]);
?>

<html>
<head>
    <title>Delete Food</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">

    <h1>Delete Food</h1>

    <?php if ($deleteError) { ?>
        <p style="color:red"><?php echo $deleteError; ?></p>
    <?php } ?>

    <?php if ($deleteSuccess) { ?>
        <p style="color:green"><?php echo $deleteSuccess; ?></p>
    <?php } ?>

    <table>
        <tr>
            <th>Food ID</th>
            <th>Food Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>

        <?php
        if ($result && $result->num_rows > 0) {
            while ($food = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $food["food_id"]; ?></td>
            <td><?php echo htmlspecialchars($food["food_name"]); ?></td>
            <td>৳<?php echo number_format($food["price"], 2); ?></td>
            <td>
                <form action="../../Controller/Restaurant/deleteFoodController.php"
                      method="post">
                    <input type="hidden"
                           name="food_id"
                           value="<?php echo $food["food_id"]; ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php
            }
        } else {
        ?>
        <tr>
            <td colspan="4">No food found in your menu.</td>
        </tr>
        <?php } ?>
    </table>

    <a href="restaurant-dashboard.php">
        <button>Back to Dashboard</button>
    </a>

</div>

</body>
</html>