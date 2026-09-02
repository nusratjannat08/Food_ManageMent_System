<?php
 session_start();
if (!isset($_SESSION["restaurant"])) {
   header("Location: ../../Controller/Restaurant/restaurantDashboardController.php");
     exit();
 }

$restaurant = $_SESSION["restaurant"];
?>
<html>
<head>
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="dashboard">
    <h1>Restaurant Dashboard</h1>
    <fieldset>
        <legend>Restaurant Information</legend>

        <label>Restaurant Name:</label>
        <p><?php echo $restaurant["username"]; ?></p>
        <label>Phone:</label>
        <p><?php echo $restaurant["phone"]; ?></p>
        <label>Email:</label>
        <p><?php echo $restaurant["email"]; ?></p>
        <label>Address:</label>
        <p><?php echo $restaurant["address"]; ?></p>

        <form action="../../Controller/Restaurant/restaurantLogoutController.php" method="post">
            <button type="submit">Log Out</button>
        </form>
    </fieldset>


    <div class="menu">

        <a href="view-orders.php">
            <div class="card">
                <h3>View Incoming Orders</h3>
                <p>Check new customer orders</p>
            </div>
        </a>

        <a href="add-food.php">
            <div class="card">
                <h3>Add Food</h3>
                <p>Add a new food item</p>
            </div>
        </a>

        <a href="delete-food.php">
            <div class="card">
                <h3>Delete Food</h3>
                <p>Remove food items</p>
            </div>
        </a>

        <a href="update-availability.php">
            <div class="card">
                <h3>Update Food Availability</h3>
                <p>Change food availability</p>
            </div>
        </a>

    </div>

</div>

</body>
</html>