<?php
session_start();
require_once "controllers/AuthController.php";

$controller = new AuthController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller->login();
} else {
    $controller->showLoginForm();
}
