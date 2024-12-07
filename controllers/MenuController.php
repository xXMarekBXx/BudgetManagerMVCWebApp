<?php
session_start();
require_once '../models/MenuModel.php';
require_once __DIR__ . '/../connect.php';

if (!function_exists('loadEnv')) {
    function loadEnv($filePath)
    {
        if (!file_exists($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!isset($_ENV[$name])) {
                putenv("$name=$value");
                $_ENV[$name] = $value;
            }
        }
    }
}

loadEnv(__DIR__ . '/../.env');

$dbHost = getenv('DB_HOST');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$dbName = getenv('DB_NAME');

$menuModel = new MenuModel($dbHost, $dbUser, $dbPassword, $dbName);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}

$userId = $_SESSION['user_id'];
$username = $menuModel->getUserData($userId);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout']) && $_POST['logout'] == 'true') {
    $menuModel->logout();
    header("Location: ../index.php");
    exit();
}

require_once '../views/MenuView.php';
