<!DOCTYPE html>
<html>
<head>
    <title>Food Delivery System</title>

    <style>
        body {
            margin: 0;
            background-color: #f7f4df;
            font-family: Arial, sans-serif;
            color: #263b25;
        }

        .dashboard {
            width: 800px;
            margin: 80px auto;
            text-align: center;
        }

        h1 {
            color: #31572c;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            padding: 30px;
            background-color: #fffef4;
            border: 2px solid #d4a017;
        }

        .card:hover {
            background-color: #f0e5ae;
        }

        .card h3 {
            color: #31572c;
            margin: 0 0 10px;
        }

        .card p {
            color: #555;
        }

        .menu a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>

<body>

<div class="dashboard">

    <h1>Food Delivery System</h1>

    <p>Select an option to sign up</p>

    <div class="menu">

        <a href="admin-signup.php">
            <div class="card">
                <h3>Admin</h3>
                <p>Sign up as an administrator</p>
            </div>
        </a>

        <a href="restaurant-signup.php">
            <div class="card">
                <h3>Restaurant</h3>
                <p>Sign up as a restaurant</p>
            </div>
        </a>

       <a href="./View/Customer/signup.php">
            <div class="card">
                <h3>Customer</h3>
                <p>Sign up as a customer</p>
            </div>
        </a>

        <a href="deliveryman-signup.php">
            <div class="card">
                <h3>Deliveryman</h3>
                <p>Sign up as a deliveryman</p>
            </div>
        </a>

    </div>

</div>

</body>
</html>