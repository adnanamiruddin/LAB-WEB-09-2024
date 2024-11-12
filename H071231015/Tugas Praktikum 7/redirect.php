<?php

session_start();
require __DIR__ . '/vendor/autoload.php';
require_once 'data.php'; 

$client = new Google\Client;
$client->setClientId('GOOGLE_CLIENT_ID');
$client->setClientSecret('GOOGLE_CLIENT_SECRET');
$client->setRedirectUri("http://localhost/t7/redirect.php");

if (!isset($_GET['code'])) {
    exit("Login failed");
}

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
$client->setAccessToken($token['access_token']);

$oauth = new Google\Service\Oauth2($client);
$userinfo = $oauth->userinfo->get();

$email = $userinfo->email;
$name = $userinfo->name;

$user = checkGoogleUser($email, $name);

if ($user === null) {
    // For new users
    $_SESSION['new_user'] = [
        'email' => $email,
        'name' => $name
    ];
    $_SESSION['auth_type'] = 'google_new';
} else {
    // For existing users
    $_SESSION['user'] = $user;
    $_SESSION['auth_type'] = 'google_existing';
}

header('Location: user_setup.php');
exit;
?>
