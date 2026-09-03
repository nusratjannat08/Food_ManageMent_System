<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <div id="loginContainer">

        <h1>Admin Login</h1>

        <fieldset>

            <form action="../Controller/loginController.php" method="post">

                <table>

                    <tr>
                        <td>Username:</td>
                        <td>
                            <input type="text" name="username" placeholder="Enter username">
                            <br>
                            <span class="error"><?php echo $_SESSION["usernameError"] ?? ""; unset($_SESSION["usernameError"]); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td>Password:</td>
                        <td>
                            <input type="password" name="password" placeholder="Enter password">
                            <br>
                            <span class="error"><?php echo $_SESSION["passwordError"] ?? ""; unset($_SESSION["passwordError"]); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <span class="error"><?php echo $_SESSION["loginError"] ?? ""; unset($_SESSION["loginError"]); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember me</label>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <button type="submit">Login</button>
                        </td>
                    </tr>

                </table>

            </form>

        </fieldset>

    </div>

</body>

</html>
