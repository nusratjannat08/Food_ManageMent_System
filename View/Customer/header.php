<?php
$isLoggedIn = $_SESSION["isLoggedIn"] ?? false;
?>
<header class="site-header">
    <div class="brand">Food <span>Management</span></div>
    <?php if ($isLoggedIn): ?>
        <nav class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="foodDashboard.php">Browse Food</a>
            <a href="cartDetails.php">Cart</a>
            <a href="orderHistory.php">Order History</a>
            <a href="../../Controller/Customer/logout.php">Logout</a>
        </nav>
    <?php else: ?>
        <nav class="nav">
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        </nav>
    <?php endif; ?>
</header>
