<?php

class restaurantQueries
{
 

  function restaurantSignup($connection,$tableName,$username,$password,$name,$email,$phone,$address)
{

$sql = "INSERT INTO $tableName
(username,password,name,email,phone,address)
VALUES
(
'$username',
'$password',
'$name',
'$email',
'$phone',
'$address'
)";

$result = $connection->query($sql);

return $result;

}
function restaurantLogin($connection, $tableName, $username, $password)
{
    $sql = "SELECT * FROM $tableName
            WHERE username='$username'
            AND password='$password'";

    $result = $connection->query($sql);

    return $result;
}

 function getRestaurantInfo($connection,$tableName,$username)
    {
        $sql = "SELECT * FROM $tableName
                WHERE username='$username'";

        return $connection->query($sql);
    }
}

?>