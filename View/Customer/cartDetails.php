<?php
session_start();
require_once __DIR__ . "/../../Model/Customer/customerQueries.php";
if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: login.php");
    exit();
}
$cart = $_SESSION["cart"] ?? [];
$foods = getFoodsByIds(array_keys($cart));
$selected = array_map("intval", $_SESSION["selectedCart"] ?? []);
if (empty($_SESSION["selectedCart"])) {
    $selected = array_keys($cart);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-shell"><div class="page-container">
<?php include "header.php"; ?>
<h1>Cart Details</h1>
<p class="subtitle">Select food, change quantity, or remove food from your cart.</p>
<?php if (!empty($_SESSION["cartError"])): ?><div class="notice error"><?php echo htmlspecialchars($_SESSION["cartError"]); unset($_SESSION["cartError"]); ?></div><?php endif; ?>
<?php if (empty($cart) || empty($foods)): ?>
<section class="card"><h2>Your cart is empty</h2><a class="btn" href="foodDashboard.php">Browse Food</a></section>
<?php else: ?>
<form id="cartForm" action="../../Controller/Customer/updateCart.php" method="post">
<div class="table-wrap"><table><thead><tr><th>Food Name</th><th>Price</th><th>Quantity</th><th>Select</th><th>Remove</th></tr></thead><tbody>
<?php $cartTotal = 0; foreach ($cart as $foodId => $quantity): if (!isset($foods[(int)$foodId])) continue; $food = $foods[(int)$foodId]; $line = (float)$food["price"] * (int)$quantity; $cartTotal += $line; ?>
<tr>
<td><?php echo htmlspecialchars($food["food_name"]); ?></td>
<td>৳<?php echo number_format((float)$food["price"], 2); ?></td>
<td><div class="quantity-control"><button class="quantity-btn" type="submit" name="action" value="decrease" formaction="../../Controller/Customer/updateCart.php">−</button><span><?php echo (int)$quantity; ?></span><button class="quantity-btn" type="submit" name="action" value="increase" formaction="../../Controller/Customer/updateCart.php">+</button><input type="hidden" name="food_id" value="<?php echo (int)$foodId; ?>"></div></td>
<td><input class="select-food" type="checkbox" name="selected[]" value="<?php echo (int)$foodId; ?>" <?php echo in_array((int)$foodId, $selected, true) ? "checked" : ""; ?>></td>
<td><button class="btn small danger" type="submit" name="action" value="remove" formaction="../../Controller/Customer/updateCart.php">Remove</button></td>
</tr>
<?php endforeach; ?>
</tbody></table></div>
<div class="cart-summary"><span>Total Price</span><strong id="totalPrice">৳0.00</strong></div>
<div class="button-row"><button class="btn" type="submit" name="action" value="order">Order Selected</button><a class="btn outline" href="foodDashboard.php">Continue Shopping</a></div>
</form>
<script>
const prices = <?php echo json_encode(array_map(function($id) use ($foods) { return isset($foods[(int)$id]) ? (float)$foods[(int)$id]["price"] : 0; }, array_keys($cart))); ?>;
const quantities = <?php echo json_encode(array_map("intval", array_values($cart))); ?>;
const ids = <?php echo json_encode(array_map("intval", array_keys($cart))); ?>;
function updateTotal() {
    let total = 0;
    document.querySelectorAll('.select-food:checked').forEach(function(box) {
        const index = ids.indexOf(parseInt(box.value));
        if (index >= 0) total += prices[index] * quantities[index];
    });
    document.getElementById('totalPrice').textContent = '৳' + total.toFixed(2);
}
document.querySelectorAll('.select-food').forEach(function(box) { box.addEventListener('change', updateTotal); });
updateTotal();
</script>
<?php endif; ?>
</div></div>
</body>
</html>
