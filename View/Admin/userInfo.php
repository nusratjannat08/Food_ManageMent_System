<!DOCTYPE html>
<html>

<head>
    <title>User Details</title>
    <link rel="stylesheet" type="text/css" href="../View/style.css">
</head>

<body>

    <div id="mainContainer" class="detailContainer">

        <h1 class="detailHeading">User Details</h1>

        <fieldset>

            <legend>Customer Information</legend>

            <table>

                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" id="name" value="<?php echo htmlspecialchars($customer["name"] ?? ""); ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" id="customerId" value="<?php echo htmlspecialchars($customer["username"] ?? ""); ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td>Email:</td>
                    <td>
                        <input type="text" id="email" value="<?php echo htmlspecialchars($customer["email"] ?? ""); ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td>Phone:</td>
                    <td>
                        <input type="text" id="phone" value="<?php echo htmlspecialchars($customer["phone"] ?? ""); ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td>Address:</td>
                    <td>
                        <input type="text" id="address" value="<?php echo htmlspecialchars($customer["address"] ?? ""); ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <form action="../Controller/deleteController.php" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <input type="hidden" name="tableName" value="customer">
                            <input type="hidden" name="username" value="<?php echo htmlspecialchars($customer["username"] ?? ""); ?>">
                            <button type="submit" class="deleteButton">
                                Delete User
                            </button>
                        </form>
                    </td>
                </tr>

            </table>

            <p id="deleteMessage"></p>

        </fieldset>
        <a href="../Controller/viewCustomerController.php">
            <button type="button" class="secondaryButton backToListButton">Back to List</button>
        </a>
    </div>

</body>

</html>
