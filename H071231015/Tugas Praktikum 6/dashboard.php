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

$users = json_decode(file_get_contents('users.json'), true);
$userEmail = $_SESSION['user']['email'];

foreach ($users as $u) {
    if ($u['email'] === $userEmail) {
        $_SESSION['user'] = $u; 
        break;
    }
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: login.php');
        exit;
    } elseif (isset($_POST['delete_user'])) {
        $emailToDelete = $_POST['delete_user'];

        deleteUser($emailToDelete);

        if ($emailToDelete === $user['email']) {
            if ($user['email'] !== 'admin@gmail.com') {
                session_destroy();
                header('Location: login.php?message=account_deleted');
                exit;
            }
        }

        header('Location: dashboard.php');
        exit;
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
                                <th class="px-4 py-2 text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                                <?php if ($u['email'] === 'admin@gmail.com') continue; ?>
                                <tr class="bg-white border-b">
                                    <td class="px-4 py-2"><?= htmlspecialchars($u['name']); ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($u['email']); ?></td>
                                    <td class="px-4 py-2">
                                        <a href="edit_user.php?email=<?= urlencode($u['email']); ?>" class="text-blue-600 hover:underline">Edit</a>
                                        <form method="POST" action="" class="inline-block">
                                            <input type="hidden" name="delete_user" value="<?= htmlspecialchars($u['email']); ?>">
                                            <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                                        </form>
                                    </td>
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
                <p class="mt-2"><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
                <p class="mt-2"><strong>Gender:</strong> <?= htmlspecialchars($user['gender']); ?></p>
                <p class="mt-2"><strong>Faculty:</strong> <?= htmlspecialchars($user['faculty']); ?></p>
                <p class="mt-2"><strong>Batch:</strong> <?= htmlspecialchars($user['batch']); ?></p>
                <div class="mt-4">
                    <a href="edit_user.php?email=<?= urlencode($user['email']); ?>" class="text-blue-600 hover:underline">Edit your profile</a>
                    <form method="POST" action="" class="inline-block">
                        <input type="hidden" name="delete_user" value="<?= htmlspecialchars($user['email']); ?>">
                        <button type="submit" class="text-red-600 hover:underline ml-2">Delete Account</button>
                    </form>
                </div>
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