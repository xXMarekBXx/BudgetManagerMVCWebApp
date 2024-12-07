<?php
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../views/login.php');
    exit();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    echo 'Brak wymaganych danych sesji. Przekierowywanie do logowania...';
    header('Location: ../views/login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (empty($userId) || empty($username)) {
    echo 'Błąd: Brak danych użytkownika w sesji. Przekierowywanie do logowania...';
    header('Location: ../views/login.php');
    exit();
}

$userData = [
    'username' => $username,
    'user_id' => $userId,
];

require_once __DIR__ . '../models/SettingsModel.php';
$model = new SettingsModel();

$userDataFromDb = $model->getUserData($_SESSION);

if (!$userDataFromDb) {
    echo 'Nie udało się pobrać danych użytkownika z bazy. Przekierowywanie do logowania...';
    header('Location: ../views/login.php');
    exit();
}

$userData['username'] = $userDataFromDb['username'];
$userData['user_id'] = $userDataFromDb['user_id'];

require_once __DIR__ . '/../views/SettingsView.php';
