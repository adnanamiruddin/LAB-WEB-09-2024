<?php 
session_start();
include 'data.php';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    if ($user['email'] === 'admin@gmail.com') {
        header("Location: adminDashboard.php");
        exit();
    } else {
        header("Location: userDashboard.php");
        exit();
    }
}

$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["emailOrUsername"]) && !empty($_POST["password"])) {
    $input = $_POST["emailOrUsername"];
    $password = $_POST["password"];

    $userFound = false; 

    foreach ($users as $user) {
        if ($user['email'] == $input || $user['username'] == $input) {
            $userFound = true;
            if (password_verify($password, $user['password'])) {
                if ($user['email'] === 'admin@gmail.com') {
                    $_SESSION['user'] = $user;
                    header("Location: adminDashboard.php");
                } else {
                    $_SESSION['user'] = $user;
                    header("Location: userDashboard.php");
                }
                exit();
            } else {
                $error = "Invalid password for email.";
            }
            break;
        } 
    }    
    if (!$userFound) {
    $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-[url('images/background.jpg')] bg-cover bg-center bg-fixed ">
    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-sm p-4 bg-white/5 backdrop-blur-sm border border-gray-300 rounded-lg shadow sm:p-6 md:p-8">
            <form class="space-y-6" action="#" method="POST">
                <h5 class="text-3xl  text-gray-500 text-center font-bold">Login</h5>
                <div>
                    <label for="emailOrUsername" class="block mb-2 text-sm font-medium text-gray-400">Email or Username</label>
                    <input type="text" name="emailOrUsername" id="emailOrUsername" class="bg-gray-50/70 border border-gray-300 text-gray-900 text-sm rounded-3xl focus:ring-pink-200 focus:border-pink-200 block w-full p-2.5 " placeholder="name@example.com" required />
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-400">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50/70 border border-gray-300 text-gray-900 text-sm rounded-3xl focus:ring-pink-200 focus:border-pink-200 block w-full p-2.5 " required />
                </div>
                <button type="submit" class="w-full text-white bg-pink-200 hover:bg-pink-300 focus:ring-4 focus:outline-none focus:ring-pink-100 font-medium rounded-3xl text-sm px-5 py-2.5 text-center">Login to your account</button>
                <div class="text-sm font-medium text-gray-300">
                    Not registered? <a href="#" class="text-pink-200 hover:underline">Create account</a>
                </div>        
                <div id="alertText" class="text-sm text-center text-red-600">
                    <?php echo $error; ?>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>
