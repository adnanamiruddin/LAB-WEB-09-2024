<?php

session_start();
require_once 'data.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrUsername = $_POST['emailOrUsername'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = checkLogin($emailOrUsername, $password);

    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        header('Location: login.php?error=1');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}

?>