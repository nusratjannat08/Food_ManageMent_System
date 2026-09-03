<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    Header("Location: ../View/login.php");
    exit();
}

require_once(__DIR__ . "/../Model/ManagerModel.php");
$model = new ManagerModel();

$searchKeyword = trim($_GET["search"] ?? "");

if ($searchKeyword !== "") {
    $managers = $model->search($searchKeyword);
} else {
    $managers = $model->getAll();
}

require_once(__DIR__ . "/../View/viewManager.php");
