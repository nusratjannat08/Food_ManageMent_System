<?php
session_start();
require_once __DIR__ . "/../../Model/Customer/customerQueries.php";
if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: login.php");
    exit();
}
$search = trim($_GET["search"] ?? "");
$foods = getAvailableFoods($search);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-shell"><div class="page-container">
<?php include "header.php"; ?>
<h1>Food Dashboard</h1>
<p class="subtitle">Search available food and add it to your cart.</p>
<form class="search-bar" method="get" action="foodDashboard.php">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search food name">
    <button class="btn" type="submit">Search</button>
</form>
<div class="food-grid">
<?php if (empty($foods)): ?>
    <section class="card"><h2>No food found</h2><p>Try another food name.</p></section>
<?php else: ?>
<?php foreach ($foods as $food): ?>
    <section class="card food-card">
        <h2><?php echo htmlspecialchars($food["food_name"]); ?></h2>
        <p><?php echo htmlspecialchars($food["description"] ?? ""); ?></p>
        <div class="food-meta"><span>Restaurant: <?php echo htmlspecialchars($food["restaurant_username"]); ?></span><span class="price">৳<?php echo number_format((float)$food["price"], 2); ?></span></div>
        <form action="../../Controller/Customer/addToCart.php" method="post"><input type="hidden" name="food_id" value="<?php echo (int)$food["food_id"]; ?>"><button class="btn" type="submit">Add to Cart</button></form>
    </section>
<?php endforeach; ?>
<?php endif; ?>
</div>
</div></div>
</body>
</html>
