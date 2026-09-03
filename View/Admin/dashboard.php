<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    Header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <div id="mainContainer">

        <h1>Admin Dashboard</h1>

        <p id="welcome">
            Welcome, <?php echo $_SESSION["loggedInUsername"]; ?>
        </p>


        <fieldset>

            <legend>Customer Management</legend>

            <table>
                <tr>
                    <td>
                        <a href="../Controller/viewCustomerController.php">
                            <button type="button">View All Customer</button>
                        </a>
                    </td>
                </tr>
            </table>

        </fieldset>


        <fieldset>

            <legend>Manager Management</legend>

            <table>
                <tr>
                    <td>
                        <a href="../Controller/viewManagerController.php">
                            <button type="button">View All Manager</button>
                        </a>
                    </td>
                </tr>
            </table>

        </fieldset>


        <fieldset>

            <legend>Delivery Management</legend>

            <table>
                <tr>
                    <td>
                        <button type="button">Delivery Management</button>
                    </td>
                </tr>
            </table>

        </fieldset>

        <a href="../Controller/logoutController.php">
            <button type="button" id="logoutButton">
                Logout
            </button>
        </a>

    </div>

</body>

</html>
