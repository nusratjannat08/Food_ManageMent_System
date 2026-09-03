<!DOCTYPE html>
<html>

<head>

    <title>View Customers</title>

    <link rel="stylesheet"
          type="text/css"
          href="style.css">

    <style>

        body {
            background-color: olive !important;
            margin: 0;
            font-family: Cambria, Cochin, Georgia,
                         Times, "Times New Roman", serif;
        }

        #mainContainer {
            width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
        }

        h1 {
            text-align: center;
            color: olive;
            background-color: #d4a017;
            margin: 20px;
            padding: 15px 20px;
        }

        fieldset {
            margin: 15px 20px;
            padding: 20px;
            background-color: beige;
            border: 2px solid #d4a017;
        }

        legend {
            background-color: olive;
            color: white;
            padding: 8px 20px;
            font-size: 18px;
        }

        .searchTable {
            margin: 10px auto;
        }

        .searchTable td {
            padding: 8px;
        }

        input[type="text"] {
            width: 300px;
            padding: 8px;
            border: 1px solid goldenrod;
            font-size: 14px;
        }

        input[type="submit"] {
            margin: 5px 10px;
            padding: 10px 30px;
            background-color: #d4a017;
            color: olive;
            border: 1px solid olive;
            font-size: 15px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: olive;
            color: white;
        }

        .dataTable {
            width: 100%;
            border-collapse: collapse;
            margin: 15px auto;
        }

        .dataTable th {
            background-color: olive;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .dataTable td {
            padding: 10px;
            text-align: center;
            border: 1px solid #d4a017;
            color: olive;
            font-size: 15px;
            background-color: white;
        }

        .backButton {
            display: inline-block;
            margin: 20px 10px 5px 10px;
            padding: 10px 30px;
            background-color: olive;
            color: white;
            border: 1px solid olive;
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
        }

        .backButton:hover {
            background-color: #d4a017;
            color: olive;
        }

        #deleteMessage {
            text-align: center;
            color: red;
            font-size: 16px;
            margin-top: 20px;
        }

    </style>

</head>


<body>

<div id="mainContainer">

    <h1>Customer List</h1>

    <fieldset>

        <legend>All Customers</legend>


        <!-- Search -->

        <form method="GET"
              action="../../Controller/Admin/viewCustomerController.php">

            <table class="searchTable">

                <tr>

                    <td>

                        <input
                            type="text"
                            name="search"
                            value="<?php
                                echo htmlspecialchars(
                                    $_GET["search"] ?? ""
                                );
                            ?>"
                            placeholder="Search customer">

                    </td>

                    <td>

                        <input
                            type="submit"
                            value="Search">

                    </td>

                </tr>

            </table>

        </form>


        <br>


        <!-- Customer Table -->

        <?php if (!empty($customers)) { ?>

            <table
                id="customerTable"
                class="dataTable">

                <tr>

                    <?php

                    foreach (
                        array_keys($customers[0])
                        as $column
                    ) {

                        echo "<th>" .
                             htmlspecialchars($column) .
                             "</th>";

                    }

                    ?>

                </tr>


                <?php foreach ($customers as $customer) { ?>

                    <tr>

                        <?php foreach ($customer as $value) { ?>

                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $value ?? ""
                                );
                                ?>

                            </td>

                        <?php } ?>

                    </tr>

                <?php } ?>

            </table>


        <?php } else { ?>

            <p id="deleteMessage">
                No customers found.
            </p>

        <?php } ?>


        <!-- Back to Dashboard -->

        <a
            href="/Food_ManageMent_System_/.~/View/Admin/dashboard.php"
            class="backButton">

            Back to Dashboard

        </a>


    </fieldset>

</div>

</body>

</html>