<?php

session_start();

session_destroy();

setcookie(
    "restaurantUsername",
    "",
    time()-3600,
    "/"
);

header("Location: ../../View/Restaurant/restaurant-login.php");
exit();

?>