<?php
session_start();
require_once __DIR__ . "/../../Model/Customer/customerQueries.php";
if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION["loggedInUsername"];
$customer = getCustomer($username);
if (!$customer) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION["customerName"] = $customer["name"];
$_SESSION["customerEmail"] = $customer["email"];
$_SESSION["customerNumber"] = $customer["phone"];
$_SESSION["customerLocation"] = $customer["address"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-shell"><div class="page-container">
<?php include "header.php"; ?>
<h1>Customer Dashboard</h1>
<p class="subtitle">Welcome back, <?php echo htmlspecialchars($customer["name"]); ?>.</p>
<section class="card">
    <div class="section-heading"><h2>Your Details</h2><a class="btn" href="editProfile.php">Edit Profile</a></div>
    <dl class="detail-list">
        <div class="detail-row"><dt>Username</dt><dd><?php echo htmlspecialchars($customer["username"]); ?></dd></div>
        <div class="detail-row"><dt>Name</dt><dd><?php echo htmlspecialchars($customer["name"]); ?></dd></div>
        <div class="detail-row"><dt>Email</dt><dd><?php echo htmlspecialchars($customer["email"]); ?></dd></div>
        <div class="detail-row"><dt>Number</dt><dd><?php echo htmlspecialchars($customer["phone"]); ?></dd></div>
        <div class="detail-row"><dt>Location / Address</dt><dd><?php echo htmlspecialchars($customer["address"]); ?></dd></div>
    </dl>
</section>
</div></div>
</body>
</html>
