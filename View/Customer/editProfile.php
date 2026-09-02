<?php
session_start();
require_once __DIR__ . "/../../Model/Customer/customerQueries.php";
if (!($_SESSION["isLoggedIn"] ?? false)) {
    header("Location: login.php");
    exit();
}
$customer = getCustomer($_SESSION["loggedInUsername"]);
$profileError = $_SESSION["profileError"] ?? "";
unset($_SESSION["profileError"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-shell"><div class="page-container">
<?php include "header.php"; ?>
<div class="center-card card">
    <?php if ($profileError): ?><div class="notice error"><?php echo htmlspecialchars($profileError); ?></div><?php endif; ?>
    <h1>Edit Profile</h1>
    <p class="subtitle">Edit your personal details</p>
    <form action="../../Controller/Customer/updateProfile.php" method="post" class="form-grid">
        <div><label>Username</label><input type="text" value="<?php echo htmlspecialchars($customer["username"]); ?>" disabled></div>
        <div><label for="name">Name</label><input id="name" type="text" name="name" value="<?php echo htmlspecialchars($customer["name"]); ?>"></div>
        <div><label for="email">Email</label><input id="email" type="email" name="email" value="<?php echo htmlspecialchars($customer["email"]); ?>"></div>
        <div><label for="phone">Number</label><input id="phone" type="text" name="phone" value="<?php echo htmlspecialchars($customer["phone"]); ?>"></div>
        <div><label for="address">Location / Address</label><input id="address" type="text" name="address" value="<?php echo htmlspecialchars($customer["address"]); ?>"></div>
        <div class="button-row"><button class="btn" type="submit">Update</button><a class="btn outline" href="dashboard.php">Back</a></div>
    </form>
</div>
</div></div>
</body>
</html>
