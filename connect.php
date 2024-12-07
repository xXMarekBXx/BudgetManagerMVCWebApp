<?php

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

loadEnv(__DIR__ . '/.env');

$dbHost = getenv('DB_HOST');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');
$dbName = getenv('DB_NAME');

function getDatabaseConnection()
{
    global $dbHost, $dbUser, $dbPassword, $dbName;

    $connection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if ($connection->connect_error) {
        die("Database connection failed: " . $connection->connect_error);
    }

    return $connection;
}
