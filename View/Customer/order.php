<?php
session_start();
require_once __DIR__ . "/../../Model/Customer/customerQueries.php";
if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: login.php");
    exit();
}
$selected = array_values(array_unique(array_map("intval", $_SESSION["selectedCart"] ?? [])));
$cart = $_SESSION["cart"] ?? [];
$foods = getFoodsByIds($selected);
$items = [];
$total = 0;
foreach ($selected as $foodId) {
    if (isset($foods[$foodId], $cart[$foodId])) {
        $quantity = max(1, (int)$cart[$foodId]);
        $line = (float)$foods[$foodId]["price"] * $quantity;
        $items[] = ["name" => $foods[$foodId]["food_name"], "qty" => $quantity, "line" => $line];
        $total += $line;
    }
}
$orderError = $_SESSION["orderError"] ?? "";
unset($_SESSION["orderError"]);
$name = $_SESSION["orderName"] ?? $_SESSION["customerName"] ?? "";
$number = $_SESSION["orderNumber"] ?? $_SESSION["customerNumber"] ?? "";
$address = $_SESSION["orderAddress"] ?? $_SESSION["customerLocation"] ?? "";
unset($_SESSION["orderName"], $_SESSION["orderNumber"], $_SESSION["orderAddress"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-shell"><div class="page-container">
<?php include "header.php"; ?>
<h1>Place Order</h1>
<p class="subtitle">Enter your delivery details and choose a payment method.</p>
<?php if ($orderError): ?><div class="notice error"><?php echo htmlspecialchars($orderError); ?></div><?php endif; ?>
<div class="dashboard-grid">
<section class="card">
<h2>Customer Details</h2>
<form action="../../Controller/Customer/placeOrder.php" method="post" class="form-grid">
<div><label for="name">Name</label><input id="name" type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></div>
<div><label for="number">Number</label><input id="number" type="text" name="number" value="<?php echo htmlspecialchars($number); ?>"></div>
<div><label for="address">Address</label><input id="address" type="text" name="address" value="<?php echo htmlspecialchars($address); ?>"></div>
<div><label for="payment">Payment Method</label><select id="payment" name="payment_method"><option value="">Select payment method</option><option value="cash">Cash</option><option value="bkash">bKash</option><option value="nagad">Nagad</option></select></div>
<div class="button-row"><button class="btn" type="submit">Place Order</button><a class="btn outline" href="cartDetails.php">Back to Cart</a></div>
</form>
</section>
<section class="card"><h2>Order Summary</h2>
<?php if (empty($items)): ?><div class="notice error">No selected food is available.</div><?php else: ?><dl class="detail-list"><?php foreach ($items as $item): ?><div class="detail-row"><dt><?php echo htmlspecialchars($item["name"]); ?> × <?php echo $item["qty"]; ?></dt><dd>৳<?php echo number_format($item["line"], 2); ?></dd></div><?php endforeach; ?><div class="detail-row"><dt>Total</dt><dd class="price">৳<?php echo number_format($total, 2); ?></dd></div></dl><?php endif; ?>
</section>
</div>
</div></div>
</body>
</html>
