<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    Header("Location: ../View/login.php");
    exit();
}

require_once(__DIR__ . "/../Model/CustomerModel.php");
require_once(__DIR__ . "/../Model/ManagerModel.php");

$tableName = $_POST["tableName"] ?? "";
$username = $_POST["username"] ?? "";

if ($tableName == "customer") {
    $model = new CustomerModel();
    $model->delete($username);
    Header("Location: ../View/viewCustomer.php");
} else {
    $model = new ManagerModel();
    $model->delete($username);
    Header("Location: ../View/viewManager.php");
}
exit();
