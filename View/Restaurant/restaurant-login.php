<?php
session_start();

if (isset($_COOKIE["restaurantUsername"])) {
    $_SESSION["isLoggedIn"] = true;
    header("Location: restaurant-dashboard.php");
    exit();
}

$usernameError = $_SESSION["usernameError"] ?? "";
$passwordError = $_SESSION["passwordError"] ?? "";
$email = $_SESSION["email"] ?? "";

unset($_SESSION["usernameError"]);
unset($_SESSION["passwordError"]);
unset($_SESSION["email"]);
?>

<html>
<head>
    <title>Restaurant Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<fieldset>
    <legend>Restaurant Login</legend>

    <form action="../../Controller/Restaurant/restaurantLoginController.php" method="post">

        <label>Restaurant Username:</label>
        <input
            type="Text"
            name="username"
            
        />
        <p style="color:red"><?php echo $usernameError; ?></p>

        <label>Password:</label>
        <input
            type="password"
            name="password"
        />
        <p style="color:red"><?php echo $passwordError; ?></p>

        <button type="submit">Login</button>

        <p>
            Don't have an account?
            <a href="restaurant-signup.php">Sign Up</a>
        </p>

    </form>

</fieldset>

<a href="../../HomePage.php">Back to Homepage</a>

</body>
</html>