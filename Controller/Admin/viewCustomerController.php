<?php

session_start();

if (
    !isset($_SESSION["isLoggedIn"]) ||
    $_SESSION["isLoggedIn"] !== true
) {
    header("Location: ../../View/Admin/login.php");
    exit();
}

require_once(__DIR__ . "/../../Model/Admin/CustomerModel.php");

$model = new CustomerModel();

$searchKeyword = trim($_GET["search"] ?? "");


if ($searchKeyword !== "") {

    $customers = $model->search($searchKeyword);

} else {

    $customers = $model->getAll();

}


require_once(__DIR__ . "/../../View/Admin/viewCustomer.php");

?>