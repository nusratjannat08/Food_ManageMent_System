<!DOCTYPE html>
<html>

<head>
    <title>Manager Details</title>
    <link rel="stylesheet" type="text/css" href="../View/style.css">
</head>

<body>

    <div id="mainContainer" class="detailContainer">

        <h1 class="detailHeading">Manager Details</h1>

        <fieldset>

            <legend>Manager Information</legend>

            <table>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" id="managerId" value="<?php echo htmlspecialchars($manager["username"] ?? ""); ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td>Name:</td>
                    <td>
                        <input type="text" id="name" value="<?php echo htmlspecialchars($manager["name"] ?? ""); ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td>Email:</td>
                    <td>
                        <input type="text" id="email" value="<?php echo htmlspecialchars($manager["email"] ?? ""); ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td>Phone:</td>
                    <td>
                        <input type="text" id="phone" value="<?php echo htmlspecialchars($manager["phone"] ?? ""); ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td>Address:</td>
                    <td>
                        <input type="text" id="address" value="<?php echo htmlspecialchars($manager["address"] ?? ""); ?>" readonly>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <form action="../Controller/deleteController.php" method="post" onsubmit="return confirm('Are you sure you want to delete this manager?');">
                            <input type="hidden" name="tableName" value="manager">
                            <input type="hidden" name="username" value="<?php echo htmlspecialchars($manager["username"] ?? ""); ?>">
                            <button type="submit" class="deleteButton">
                                Delete Manager
                            </button>
                        </form>
                    </td>
                </tr>

            </table>

            <p id="deleteMessage"></p>

        </fieldset>

        <a href="../Controller/viewManagerController.php">
            <button type="button" class="secondaryButton backToListButton">Back to List</button>
        </a>

    </div>

</body>

</html>
