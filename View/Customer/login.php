<?php
session_start();
if ($_SESSION["isLoggedIn"] ?? false) {
    header("Location: dashboard.php");
    exit();
}
$loginError = $_SESSION["loginError"] ?? "";
$loginMessage = $_SESSION["loginMessage"] ?? "";
$loginUsername = $_SESSION["loginUsername"] ?? "";
unset($_SESSION["loginError"], $_SESSION["loginMessage"], $_SESSION["loginUsername"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-shell"><div class="page-container">
<?php include "header.php"; ?>
<div class="center-card card">
    <?php if ($loginError): ?><div class="notice error"><?php echo htmlspecialchars($loginError); ?></div><?php endif; ?>
    <?php if ($loginMessage): ?><div class="notice"><?php echo htmlspecialchars($loginMessage); ?></div><?php endif; ?>
    <h1>Customer Login</h1>
    <p class="subtitle">Login to manage your food orders.</p>
    <form action="../../Controller/Customer/loginValidation.php" method="post" class="form-grid">
        <div><label for="username">Username</label><input id="username" type="text" name="username" value="<?php echo htmlspecialchars($loginUsername); ?>"></div>
        <div><label for="password">Password</label><input id="password" type="password" name="password"></div>
        <div class="button-row"><button class="btn" type="submit">Login</button></div>
    </form>
</div>
</div></div>
</body>
</html>
