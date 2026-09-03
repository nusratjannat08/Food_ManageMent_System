<?php

session_start();


// =========================
// CHECK LOGIN
// =========================

if (
    !isset($_SESSION["isLoggedIn"]) ||
    $_SESSION["isLoggedIn"] !== true
) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

    <link rel="stylesheet"
          type="text/css"
          href="style.css">

    <style>

        /* =========================
           BODY
           ========================= */

        body {
            background-color: olive;
            margin: 0;
            font-family: Cambria, Cochin, Georgia,
                         Times, "Times New Roman", serif;
        }


        /* =========================
           MAIN CONTAINER
           ========================= */

        #mainContainer {
            width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
        }


        /* =========================
           MAIN HEADING
           ========================= */

        h1 {
            text-align: center;
            color: olive;
            background-color: #d4a017;
            margin: 20px;
            padding: 15px 20px;
        }


        /* =========================
           WELCOME TEXT
           ========================= */

        #welcome {
            text-align: center;
            color: olive;
            font-size: 18px;
            margin: 20px;
        }


        /* =========================
           FIELDSET
           ========================= */

        fieldset {
            margin: 15px 20px;
            padding: 20px;
            background-color: beige;
            border: 2px solid #d4a017;
        }


        /* =========================
           LEGEND
           ========================= */

        legend {
            background-color: olive;
            color: white;
            padding: 8px 20px;
            font-size: 18px;
        }


        /* =========================
           TABLE
           ========================= */

        table {
            margin: 10px auto;
        }


        td {
            padding: 12px 15px;
            color: olive;
            font-size: 16px;
            text-align: center;
        }


        /* =========================
           MANAGEMENT BUTTON
           ========================= */

        .dashboardButton {
            display: inline-block;
            margin: 5px 10px;
            padding: 10px 30px;
            background-color: #d4a017;
            color: olive;
            border: 1px solid olive;
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
        }


        .dashboardButton:hover {
            background-color: olive;
            color: white;
        }


        /* =========================
           LOGOUT BUTTON
           ========================= */

        #logoutButton {
            display: block;
            width: 180px;
            margin: 30px auto 20px auto;
            padding: 10px 20px;
            background-color: olive;
            color: white;
            border: 1px solid olive;
            font-size: 15px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }


        #logoutButton:hover {
            background-color: #d4a017;
            color: olive;
        }

    </style>

</head>


<body>


<div id="mainContainer">


    <!-- =========================
         DASHBOARD TITLE
         ========================= -->

    <h1>Admin Dashboard</h1>


    <!-- =========================
         WELCOME
         ========================= -->

    <p id="welcome">

        Welcome,
        <?php
        echo htmlspecialchars(
            $_SESSION["loggedInUsername"] ?? "Admin"
        );
        ?>

    </p>


    <!-- =========================
         CUSTOMER MANAGEMENT
         ========================= -->

    <fieldset>

        <legend>Customer Management</legend>

        <table>

            <tr>

                <td>

                    <a
                        href="../../Controller/Admin/viewCustomerController.php"
                        class="dashboardButton"
                    >
                        View All Customer
                    </a>

                </td>

            </tr>

        </table>

    </fieldset>


    <!-- =========================
         MANAGER MANAGEMENT
         ========================= -->

    <fieldset>

        <legend>Manager Management</legend>

        <table>

            <tr>

                <td>

                    <a
                        href="../../Controller/Admin/viewManagerController.php"
                        class="dashboardButton"
                    >
                        View All Manager
                    </a>

                </td>

            </tr>

        </table>

    </fieldset>


    <!-- =========================
         DELIVERY MANAGEMENT
         ========================= -->

    <fieldset>

        <legend>Delivery Management</legend>

        <table>

            <tr>

                <td>

                    <a
                        href="#"
                        class="dashboardButton"
                    >
                        Delivery Management
                    </a>

                </td>

            </tr>

        </table>

    </fieldset>


    <!-- =========================
         LOGOUT
         ========================= -->

    <a
        href="../../Controller/Admin/logoutController.php"
        id="logoutButton"
    >
        Logout
    </a>


</div>


</body>

</html>