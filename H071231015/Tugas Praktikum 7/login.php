<?php
session_start();

include 'data.php';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$emailOrUsernameErr = $passwordErr = "";
$emailOrUsername = $password = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["emailOrUsername"])) {
        $emailOrUsernameErr = "Email or Username is required";
    } else {
        $emailOrUsername = test_input($_POST["emailOrUsername"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($emailOrUsernameErr) && empty($passwordErr)) {
        $user = checkLogin($emailOrUsername, $password);
        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: dashboard.php');
            exit;
        } else {
            $passwordErr = "Invalid email/username or password.";
        }
    }
}


// Google OAuth Login Setup
require __DIR__ . "/vendor/autoload.php";
$client = new Google\Client();
$client->setClientId('GOOGLE_CLIENT_ID');
$client->setClientSecret('GOOGLE_CLIENT_SECRET');
$client->setRedirectUri("http://localhost/t7/redirect.php");
$client->addScope("email");
$client->addScope("profile");

$googleLoginUrl = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            <img src="assets/images/logo.png" alt="logo unhas" class="mx-auto mb-4 h-16">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100">Welcome to SIKOLA 3.0</h2>
            <p class="mt-2 text-center text-gray-600 dark:text-gray-300">Please sign in to your account</p>

            <form class="mt-6" action="login.php" method="post">
                <div class="mb-4">
                    <label for="emailOrUsername" class="block text-gray-700 dark:text-gray-300 text-sm font-bold">Email or Username</label>
                    <input id="emailOrUsername" type="text" name="emailOrUsername" placeholder="Enter your email or username"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    <span class="text-red-500 text-sm"><?php echo $emailOrUsernameErr; ?></span>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 dark:text-gray-300 text-sm font-bold">Password</label>
                    <input id="password" type="password" name="password" placeholder="Enter your password"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    <span class="text-red-500 text-sm"><?php echo $passwordErr; ?></span>
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="relative inline-flex items-center justify-center w-full p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-600 to-orange-500 group-hover:from-red-600 group-hover:to-orange-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                        <span class="relative w-full px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                            Sign In
                        </span>
                    </button>
                </div>

                <div class="mt-4 flex flex-wrap justify-center gap-2">
                    <a href="<?= $googleLoginUrl ?>" class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55">
                        <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                            <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd" />
                        </svg>
                        Sign in with Google
                    </a>
                </div>
            </form>

            <p class=" mt-6 text-center text-gray-600 dark:text-gray-300">Don't have an account?
                <a href="register.php" class="text-blue-600 hover:underline">Register here</a>
            </p>
        </div>
    </div>

    <script src="assets/js/login.js"></script>
    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>

</html>
