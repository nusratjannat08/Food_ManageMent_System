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

$updateError = $_SESSION["updateError"] ?? "";
$updateSuccess = $_SESSION["updateSuccess"] ?? "";

unset($_SESSION["updateError"]);
unset($_SESSION["updateSuccess"]);
?>

<html>
<head>
    <title>Update Food Availability</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page">

    <h1>Update Food Availability</h1>

    <?php if ($updateError) { ?>
        <p style="color:red"><?php echo $updateError; ?></p>
    <?php } ?>

    <?php if ($updateSuccess) { ?>
        <p style="color:green"><?php echo $updateSuccess; ?></p>
    <?php } ?>

    <table>
        <tr>
            <th>Food ID</th>
            <th>Food Name</th>
            <th>Availability</th>
            <th>Action</th>
        </tr>

        <?php
        if ($result && $result->num_rows > 0) {
            while ($food = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $food["food_id"]; ?></td>
            <td><?php echo htmlspecialchars($food["food_name"]); ?></td>
            <td>
                <form action="../../Controller/Restaurant/updateAvailabilityController.php"
                      method="post">
                    <input type="hidden"
                           name="food_id"
                           value="<?php echo $food["food_id"]; ?>">

                    <select name="available">
                        <option value="1"
                            <?php if ($food["available"] == 1) echo "selected"; ?>>
                            Available
                        </option>
                        <option value="0"
                            <?php if ($food["available"] == 0) echo "selected"; ?>>
                            Not Available
                        </option>
                    </select>
            </td>
            <td>
                    <button type="submit">Update</button>
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