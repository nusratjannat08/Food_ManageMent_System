<?php

require_once(__DIR__ . "/../../Config/DBconnection.php");

class CustomerModel
{
    // Show all customers
    function getAll()
    {
        $db = new DatabaseConnection();

        $connection = $db->openConnection();

        $sql = "SELECT * FROM customer";

        $result = $connection->query($sql);

        $rows = [];

        if ($result) {

            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

        }

        $db->closeConnection($connection);

        return $rows;
    }


    // Search customer
    function search($keyword)
    {
        $db = new DatabaseConnection();

        $connection = $db->openConnection();

        $keyword = $connection->real_escape_string($keyword);

        $sql = "SELECT * FROM customer
                WHERE name LIKE '%$keyword%'
                OR username LIKE '%$keyword%'
                OR email LIKE '%$keyword%'
                OR phone LIKE '%$keyword%'
                OR address LIKE '%$keyword%'";

        $result = $connection->query($sql);

        $rows = [];

        if ($result) {

            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

        }

        $db->closeConnection($connection);

        return $rows;
    }


    // Get one customer
    function getOne($username)
    {
        $db = new DatabaseConnection();

        $connection = $db->openConnection();

        $username = $connection->real_escape_string($username);

        $sql = "SELECT * FROM customer
                WHERE username='$username'";

        $result = $connection->query($sql);

        $row = false;

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }

        $db->closeConnection($connection);

        return $row;
    }


    // Delete customer
    function delete($username)
    {
        $db = new DatabaseConnection();

        $connection = $db->openConnection();

        $username = $connection->real_escape_string($username);

        $sql = "DELETE FROM customer
                WHERE username='$username'";

        $result = $connection->query($sql);

        $db->closeConnection($connection);

        return $result;
    }
}

?>