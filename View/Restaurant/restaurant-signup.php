<?php
session_start();

if(isset($_COOKIE["restaurantUsername"])){
    $_SESSION["isLoggedIn"] = true;
    header("Location: restaurant-dashboard.php");
}

$usernameError = $_SESSION["usernameError"] ?? "";
$nameError      = $_SESSION["nameError"] ?? "";
$emailError     = $_SESSION["emailError"] ?? "";
$phoneError     = $_SESSION["phoneError"] ?? "";
$addressError   = $_SESSION["addressError"] ?? "";
$passwordError  = $_SESSION["passwordError"] ?? "";
$confirmError   = $_SESSION["confirmError"] ?? "";

$username = $_SESSION["username"] ?? "";
$name     = $_SESSION["name"] ?? "";
$email    = $_SESSION["email"] ?? "";
$phone    = $_SESSION["phone"] ?? "";
$address  = $_SESSION["address"] ?? "";

unset($_SESSION["usernameError"]);
unset($_SESSION["nameError"]);
unset($_SESSION["emailError"]);
unset($_SESSION["phoneError"]);
unset($_SESSION["addressError"]);
unset($_SESSION["passwordError"]);
unset($_SESSION["confirmError"]);
unset($_SESSION["username"]);
unset($_SESSION["name"]);
unset($_SESSION["email"]);
unset($_SESSION["phone"]);
unset($_SESSION["address"]);
?>

<html>
<head>
    <title>Restaurant Signup</title>
    <link rel="stylesheet" href="style.css">
    <script src="restaurant-signup-ajax.js"></script>
</head>
<body>

<fieldset>
    <legend>Restaurant Signup</legend>

    <form id="restaurantSignupForm" action="../../Controller/Restaurant/restaurantSignupController.php" method="post">
        <label>Username:</label>
<input type="text"
       name="username"
       id="username"
       value="<?php echo htmlspecialchars($username); ?>"
       onkeyup="checkUsername(this.value)" />

<p id="usernameStatus" style="color:red">
    <?php echo htmlspecialchars($usernameError); ?>
</p>

<label>Restaurant Name:</label>
<input type="text" name="name" value="<?php echo $name; ?>"/>
<p style="color:red"><?php echo $nameError; ?></p>

<label>Email:</label>
<input type="email" name="email" value="<?php echo $email; ?>" />
<p style="color:red"><?php echo $emailError; ?></p>

<label>Phone:</label>
<input type="text" name="phone" value="<?php echo $phone; ?>" />
<p style="color:red"><?php echo $phoneError; ?></p>

<label>Address:</label>
<input type="text" name="address" value="<?php echo $address; ?>" />
<p style="color:red"><?php echo $addressError; ?></p>

<label>Password:</label>
<input type="password" name="password" />
<p style="color:red"><?php echo $passwordError; ?></p>

<label>Confirm Password:</label>
<input type="password" name="confirmPassword"/>
<p style="color:red"><?php echo $confirmError; ?></p>

<button type="submit">Sign Up</button>

        <p>Already have an account?
            <a href="restaurant-login.php">Login</a>
        </p>
    </form>
</fieldset>

<a href="../../HomePage.php">Back to Homepage</a>
</body>
</html>
