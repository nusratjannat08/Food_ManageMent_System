<!DOCTYPE html>
<html>

<head>
    <title>View All Managers</title>
    <link rel="stylesheet" type="text/css" href="../View/style.css">
</head>

<body>

    <div id="mainContainer">

        <h1>View All Managers</h1>


        <fieldset>

            <legend>Search Manager</legend>

            <form method="get" action="../Controller/viewManagerController.php">

                <table>

                    <tr>

                        <td>Search Manager:</td>

                        <td>
                            <input type="text" name="search" id="searchManager" placeholder="Enter manager name" value="<?php echo htmlspecialchars($searchKeyword ?? ""); ?>">
                        </td>

                        <td>
                            <button type="submit">Search</button>
                        </td>

                    </tr>

                </table>

            </form>

        </fieldset>


        <fieldset>

            <legend>Manager Information</legend>

            <table id="managerTable" class="dataTable">

                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                </tr>

                <?php if (!empty($managers)): ?>
                    <?php foreach ($managers as $manager): ?>
                        <tr>
                            <td><a href="../Controller/managerInfoController.php?username=<?php echo urlencode($manager["username"] ?? ""); ?>"><?php echo htmlspecialchars($manager["username"] ?? ""); ?></a></td>
                            <td><a href="../Controller/managerInfoController.php?username=<?php echo urlencode($manager["username"] ?? ""); ?>"><?php echo htmlspecialchars($manager["name"] ?? ""); ?></a></td>
                            <td><?php echo htmlspecialchars($manager["email"] ?? ""); ?></td>
                            <td><?php echo htmlspecialchars($manager["phone"] ?? ""); ?></td>
                            <td><?php echo htmlspecialchars($manager["address"] ?? ""); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No managers found.</td>
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
