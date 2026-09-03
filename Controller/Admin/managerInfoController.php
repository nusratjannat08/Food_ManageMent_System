<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    Header("Location: ../View/login.php");
    exit();
}

require_once(__DIR__ . "/../Model/ManagerModel.php");
$model = new ManagerModel();

$username = $_GET["username"] ?? "";
$manager = $model->getOne($username);

if (!$manager) {
    Header("Location: ../View/viewManager.php");
    exit();
}

require_once(__DIR__ . "/../View/managerInfo.php");
