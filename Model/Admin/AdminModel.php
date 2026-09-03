<?php
require_once(__DIR__ . "/../Config/DBconnection.php");

class AdminModel
{
    function login($username, $password)
    {
        $db = new DatabaseConnection();
        $connection = $db->openConnection();

        $username = $connection->real_escape_string($username);
        $password = $connection->real_escape_string($password);

        $sql = "SELECT * FROM admin WHERE username='" . $username . "' AND password='" . $password . "'";
        $result = $connection->query($sql);

        $row = false;
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }

        $db->closeConnection($connection);
        return $row;
    }
}
