<?php
session_start();
require_once __DIR__ . "/../../Model/Customer/customerQueries.php";
if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: login.php");
    exit();
}
$orders = getCustomerOrders($_SESSION["loggedInUsername"]);
$lastOrderIds = $_SESSION["lastOrderIds"] ?? [];
$lastTotal = $_SESSION["lastOrderTotal"] ?? null;
unset($_SESSION["lastOrderIds"], $_SESSION["lastOrderTotal"], $_SESSION["lastPaymentMethod"]);
function displayStatus($status)
{
    $map = ["pending" => "Received", "accepted" => "Accepted", "delivery_accepted" => "Delivery Accepted", "delivered" => "Delivered", "cancelled" => "Cancelled"];
    return $map[$status] ?? $status;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-shell"><div class="page-container">
<?php include "header.php"; ?>
<h1>Order History</h1>
<p class="subtitle">View your previous orders and their current status.</p>
<?php if (!empty($lastOrderIds)): ?><div class="notice">Order <?php echo htmlspecialchars(implode(", ", $lastOrderIds)); ?> placed successfully<?php echo $lastTotal !== null ? " — Total ৳" . number_format($lastTotal, 2) : ""; ?>.</div><?php endif; ?>
<div class="table-wrap"><table><thead><tr><th>Order Number</th><th>Food Name</th><th>Date</th><th>Total</th><th>Status</th></tr></thead><tbody>
<?php if (empty($orders)): ?><tr><td colspan="5">No previous orders found.</td></tr><?php else: ?>
<?php foreach ($orders as $order): $foodNames = []; foreach ($order["items"] as $item) { $foodNames[] = $item["food_name"] . " × " . $item["quantity"]; } $status = displayStatus($order["status"]); ?>
<tr><td>ORD-<?php echo (int)$order["order_id"]; ?></td><td><?php echo htmlspecialchars(implode(", ", $foodNames)); ?></td><td><?php echo htmlspecialchars($order["order_date"]); ?></td><td>৳<?php echo number_format($order["total"], 2); ?></td><td><span class="status<?php echo $order["status"] === "cancelled" ? " cancelled" : ""; ?>"><?php echo htmlspecialchars($status); ?></span></td></tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody></table></div>
<div class="button-row"><a class="btn" href="dashboard.php">Back to Dashboard</a></div>
</div></div>
</body>
</html>
