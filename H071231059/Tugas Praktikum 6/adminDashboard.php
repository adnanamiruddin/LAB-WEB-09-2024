<?php 
include 'data.php';

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    if ($user['email'] != 'admin@gmail.com') {
        header("Location: userDashboard.php");
        exit();
    } 
}


$user = $_SESSION['user'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-[url('images/background.jpg')] bg-cover bg-center bg-fixed ">
    <div class="relative h-screen">
        <div class="absolute inset-0 bg-black opacity-55"></div>
        <div class="flex justify-center items-center min-h-screen flex-col relative z-10">
            <h1 class=" mb-7 text-3xl font-extrabold md:text-5xl lg:text-6xl ">
                <span class="text-transparent bg-clip-text bg-gradient-to-r to-pink-300 from-orange-200">Welcome,</span>  
                <span id="nameHeading" class="text-white"><?php echo $user['name']; ?></span>
            </h1>

            <dl class="max-w-md text-white divide-y divide-gray-200">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-400 md:text-lg ">Email </dt>
                    <dd id="emailUserDash" class="text-lg font-semibold"><?php echo $user['email']; ?>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-400 md:text-lg ">Username</dt>
                    <dd id="usernameUserDash" class="text-lg font-semibold"><?php echo $user['username']; ?>
                </div>
            </dl>
            <a href="logout.php" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 mt-10 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-200 via-red-300 to-yellow-200 group-hover:from-red-200 group-hover:via-red-300 group-hover:to-yellow-200  focus:ring-4 focus:outline-none focus:ring-red-100">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white bg-opacity-75 rounded-md group-hover:bg-opacity-0">
                    Log out
                </span>
            </a>
            
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-white ">
                    <thead class="text-xs text-gray-700 uppercase bg-white bg-opacity-40">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Username
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Gender
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Faculty
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Batch
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                            <?php if ($user['username'] != 'adminxxx'): ?>
                                <tr class=" border-b">
                                    <th scope="row" class="px-6 py-4 font-medium">
                                        <?= $user['name']?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?= $user['email']?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $user['username']?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $user['gender']?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $user['faculty']?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= $user['batch']?>
                                    </td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>
