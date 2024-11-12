<?php
session_start();
require_once 'data.php';

if (!isset($_SESSION['new_user'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $faculty = $_POST['faculty'];
    $batch = $_POST['batch'];

    registerUser(
        $_SESSION['new_user']['name'],
        $username,
        $_SESSION['new_user']['email'],
        $password,
        $gender,
        $faculty,
        $batch
    );

    $_SESSION['user'] = [
        'email' => $_SESSION['new_user']['email'],
        'username' => $username,
        'name' => $_SESSION['new_user']['name'],
        'gender' => $gender,
        'faculty' => $faculty,
        'batch' => $batch
    ];

    unset($_SESSION['new_user']);

    header('Location: dashboard.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Setup</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
</head>


<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1>Set Up Your Account</h1>
            <form class="mt-6"method="POST">
            

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold">Username</label>
                    <input type="text" id="username" name="username" placeholder="Your username"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="gender" class="block text-gray-700 text-sm font-bold">Gender</label>
                    <select id="gender" name="gender"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="faculty" class="block text-gray-700 text-sm font-bold">Faculty</label>
                    <input type="text" id="faculty" name="faculty" placeholder="Your faculty"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="batch" class="block text-gray-700 text-sm font-bold">Batch</label>
                    <input type="text" id="batch" name="batch" placeholder="Your batch year"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    Submit
                </button>
            </form>
        </div>
    </div>


</body>
</html>
