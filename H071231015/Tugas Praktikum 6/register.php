<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
</head>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'data.php'; 

    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $faculty = $_POST['faculty'];
    $batch = $_POST['batch'];

    registerUser($name, $username, $email, $password, $gender, $faculty, $batch);

    header('Location: login.php');
    exit;
}
?>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center text-gray-800">Create an Account</h2>
            <p class="mt-2 text-center text-gray-600">Join SIKOLA 3.0 today!</p>

            <form class="mt-6" action="register.php" method="post">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold">Name</label>
                    <input type="text" id="name" name="name" placeholder="Your full name"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold">Username</label>
                    <input type="text" id="username" name="username" placeholder="Your username"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold">Email</label>
                    <input type="email" id="email" name="email" placeholder="Your email address"
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
                    Register
                </button>
            </form>

            <p class="mt-6 text-center text-gray-600">Already have an account?
                <a href="login.php" class="text-blue-600 hover:underline">Sign in here</a>
            </p>
        </div>
    </div>


</body>

</html>