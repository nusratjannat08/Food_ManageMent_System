<?php
session_start();

if (!isset($_COOKIE["restaurantUsername"])) {
    header("Location: restaurant-login.php");
    exit();
}

$foodNameError = $_SESSION["foodNameError"] ?? "";
$descriptionError = $_SESSION["descriptionError"] ?? "";
$priceError = $_SESSION["priceError"] ?? "";
$availabilityError = $_SESSION["availabilityError"] ?? "";
$successMessage = $_SESSION["successMessage"] ?? "";

$foodName = $_SESSION["food_name"] ?? "";
$description = $_SESSION["description"] ?? "";
$price = $_SESSION["price"] ?? "";
$available = $_SESSION["available"] ?? "1";

unset(
    $_SESSION["foodNameError"],
    $_SESSION["descriptionError"],
    $_SESSION["priceError"],
    $_SESSION["availabilityError"],
    $_SESSION["successMessage"],
    $_SESSION["food_name"],
    $_SESSION["description"],
    $_SESSION["price"],
    $_SESSION["available"]
);
?>

<html>
<head>
    <title>Add Food</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<fieldset>
    <legend>Add Food</legend>

    <?php if ($successMessage) { ?>
        <p style="color:green"><?php echo $successMessage; ?></p>
    <?php } ?>

    <form action="../../Controller/Restaurant/addFoodController.php" method="post">

        <label>Food Name:</label>
        <input type="text" name="food_name"
               value="<?php echo htmlspecialchars($foodName); ?>">
        <p style="color:red"><?php echo $foodNameError; ?></p>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" min="0.01"
               value="<?php echo htmlspecialchars($price); ?>">
        <p style="color:red"><?php echo $priceError; ?></p>

        <label>Description:</label>
        <textarea name="description"><?php echo htmlspecialchars($description); ?></textarea>
        <p style="color:red"><?php echo $descriptionError; ?></p>

        <label>Availability:</label>
        <select name="available">
            <option value="1" <?php if ($available === "1") echo "selected"; ?>>
                Available
            </option>
            <option value="0" <?php if ($available === "0") echo "selected"; ?>>
                Not Available
            </option>
        </select>
        <p style="color:red"><?php echo $availabilityError; ?></p>

        <button type="submit">Add Food</button>

    </form>
</fieldset>

<a href="restaurant-dashboard.php"><button>Back to Dashboard</button></a>

</body>
</html>