<?php
session_start();
require_once 'data.php';

$timeout = 1800;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header('Location: login.php?error=session_timeout');
    exit;
}

$_SESSION['last_activity'] = time();

if (!isLogin()) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: login.php');
        exit;
    } elseif (isset($_POST['delete_user'])) {
        $delete_email = $_POST['delete_user'];
        if ($user['email'] === 'admin@gmail.com' || $user['email'] === $delete_email) {
            // Admin atau user yang ingin menghapus dirinya sendiri bisa menghapus user
            deleteUser($delete_email);
            if ($user['email'] === $delete_email) {
                session_destroy();
                header('Location: login.php');
                exit;
            }
        }
    }
}

// Fungsi deleteUser
function deleteUser($email) {
    global $users;
    foreach ($users as $key => $u) {
        if ($u['email'] === $email) {
            unset($users[$key]);
            file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
            break;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="container mx-auto py-10">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg mx-auto text-center">
            <h1 class="text-3xl font-bold text-gray-800">Welcome, <?= htmlspecialchars($user['name']); ?>!</h1>
            <p class="text-gray-600 mt-2"><?= htmlspecialchars($user['email']); ?></p>
        </div>

        <?php if ($user['email'] === 'admin@gmail.com'): ?>
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">All Users</h2>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-gray-600">Name</th>
                                <th class="px-4 py-2 text-gray-600">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                                <?php if ($u['email'] === 'admin@gmail.com') continue; ?>
                                <tr class="bg-white border-b">
                                    <td class="px-4 py-2"><?= htmlspecialchars($u['name']); ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($u['email']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6 max-w-lg mx-auto">
                <h2 class="text-2xl font-bold text-gray-800">Your Details</h2>
                <p class="mt-4"><strong>Name:</strong> <?= htmlspecialchars($user['name']); ?></p>
                <p class="mt-2"><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
            </div>
        <?php endif; ?>

        <div class="mt-8 text-center">
            <form method="POST" action="">
                <button type="submit" name="logout" class="bg-red-500 text-white px-6 py-3 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Flowbite JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>

</html>