<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    Header("Location: ../View/login.php");
    exit();
}

require_once(__DIR__ . "/../Model/CustomerModel.php");
$model = new CustomerModel();

$username = $_GET["username"] ?? "";
$customer = $model->getOne($username);

if (!$customer) {
    Header("Location: ../View/viewCustomer.php");
    exit();
}

require_once(__DIR__ . "/../View/userInfo.php");
