<?php
session_start();
if ($_SESSION["isLoggedIn"] ?? false) {
    header("Location: dashboard.php");
    exit();
}
$signupError = $_SESSION["signupError"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page-shell"><div class="page-container">
<?php include "header.php"; ?>
<div class="center-card card">
    <?php if ($signupError): ?><div class="notice error"><?php echo htmlspecialchars($signupError); unset($_SESSION["signupError"]); ?></div><?php endif; ?>
    <div id="signupMessage"></div>
        <h1>Customer Sign Up</h1>
    <p class="subtitle">Create your customer account.</p>
<form id="signupForm" action="../../Controller/Customer/signupValidation.php" method="post" class="form-grid">        <div><label for="username">Username</label><input id="username" type="text" name="username"></div>        
<div><label for="name">Name</label><input id="name" type="text" name="name"></div>        
<div><label for="email">Email</label><input id="email" type="email" name="email"></div>
<div><label for="phone">Number</label><input id="phone" type="text" name="phone"></div>
<div><label for="address">Location / Address</label><input id="address" type="text" name="address"></div>
<div><label for="password">Create Password</label><input id="password" type="password" name="password"></div>        
<div class="button-row"><button class="btn" type="submit">Submit</button><a class="btn outline" href="login.php">Login</a></div>
    </form>
</div>
</div></div>
<script>
document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const form = this;
    const message = document.getElementById("signupMessage");

    fetch(form.action, {
        method: "POST",
        body: new FormData(form),
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(response => response.json())
    .then(data => {
        message.innerHTML = data.message;

        if (data.success) {
            setTimeout(function() {
                window.location.href = data.redirect;
            }, 1000);
        }
    })
    .catch(error => {
        message.innerHTML = "Something went wrong. Please try again.";
    });
});
</script>
</body>
</html>
