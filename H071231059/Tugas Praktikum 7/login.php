<?php
include './config/config.php';
session_start();

if (isset($_SESSION['id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";
$success = "";


if (isset($_GET['success'])) {
    $success = $_GET['success'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["nim"]) && !empty($_POST["password"])) {
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM mahasiswa WHERE nim='$nim'";
    $executeQGet = mysqli_query($conn, $query);
    $data = mysqli_fetch_array($executeQGet);

    if (mysqli_num_rows($executeQGet) == 1) {
        if ($password === $data['password']) {
            $_SESSION['id'] = $data['id'];
            header("Location: dashboard.php");
        exit();
        } else {
            $error = "Invalid password for NIM.";
        }
        
    } else {
        $error = "NIM is not found.";
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
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
</head>
<body class="bg-orange-800">

    <?php if ($success) { ?>
        <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                <?php echo $success ?>
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>    
    <?php } ?>

    <div class="flex justify-center items-center min-h-screen">
        <div class="flex max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="w-2/5">
                <img src="assets/images/login2-bg.jpg" alt="Image" class="object-cover w-full h-full">
            </div>
            
            <div class="w-3/5 p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 mt-7">Login</h2>
                <form action="#" method="POST">
                    <div class="mb-4">
                        <label class="block text-black text-sm font-bold mb-2" for="nim">NIM</label>
                        <input type="text" id="nim" name="nim" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Enter your NIM">
                    </div>
                    <div class="mb-1">
                        <label class="block text-black text-sm font-bold mb-2" for="password">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Enter your password">
                    </div>
                    <div id="alertText" class="text-sm font-semibolds text-red-600">
                        <?php echo $error; ?>
                    </div>
                    <div class="mb-4 mt-4 text-sm font-medium text-black">
                        Not registered? <a href="register.php" class="text-orange-500 hover:underline">Create account</a>
                    </div>  
                    <button type="submit" class="w-full bg-orange-500 text-white py-2 px-4 rounded-xl hover:bg-orange-600 focus:outline-none focus:bg-orange-600">Login</button>
                    
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>
