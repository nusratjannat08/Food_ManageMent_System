<!DOCTYPE html>
<html>

<head>
    <title>View All Customers</title>
    <link rel="stylesheet" type="text/css" href="../View/style.css">
</head>

<body>

    <div id="mainContainer">

        <h1>View All Customers</h1>


        <fieldset>

            <legend>Search User</legend>

            <form method="get" action="../Controller/viewCustomerController.php">

                <table>

                    <tr>

                        <td>Search User:</td>

                        <td>
                            <input type="text" name="search" id="searchUser" placeholder="Enter customer name" value="<?php echo htmlspecialchars($searchKeyword ?? ""); ?>">
                        </td>

                        <td>
                            <button type="submit">Search</button>
                        </td>

                    </tr>

                </table>

            </form>

        </fieldset>


        <fieldset>

            <legend>Customer Information</legend>

            <table id="customerTable" class="dataTable">

                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                </tr>

                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><a href="../Controller/userInfoController.php?username=<?php echo urlencode($customer["username"] ?? ""); ?>"><?php echo htmlspecialchars($customer["username"] ?? ""); ?></a></td>
                            <td><a href="../Controller/userInfoController.php?username=<?php echo urlencode($customer["username"] ?? ""); ?>"><?php echo htmlspecialchars($customer["name"] ?? ""); ?></a></td>
                            <td><?php echo htmlspecialchars($customer["email"] ?? ""); ?></td>
                            <td><?php echo htmlspecialchars($customer["phone"] ?? ""); ?></td>
                            <td><?php echo htmlspecialchars($customer["address"] ?? ""); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No customers found.</td>
                    </tr>
                <?php endif; ?>

            </table>

        </fieldset>

        <a href="../View/dashboard.php">
            <button type="button" id="backButton" class="secondaryButton">Back</button>
        </a>

    </div>

</body>

</html>
