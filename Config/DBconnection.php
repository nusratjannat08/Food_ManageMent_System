<?php

class DatabaseConnection
{
    function openConnection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = ""; 
        $db_name = "Food_Management_system"; 

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

        if ($connection->connect_error) {
            die("Failed to connect database: " . $connection->connect_error);
        }

        return $connection;
    }

    function closeConnection($connection)
    {
        $connection->close();
    }
} 


// Test the connection
$db = new DatabaseConnection();
$conn = $db->openConnection();

if ($conn) {
    echo "<h3 style='color:green;'>✓ Database connected successfully!</h3>";
    $db->closeConnection($conn);
}
?>

