<?php

session_start();
require_once 'data.php';

if (!isset($_GET['email'])) {
    header('Location: dashboard.php');
    exit;
}

$users = json_decode(file_get_contents('users.json'), true);
$email = $_GET['email'];
$user = null;

foreach ($users as $u) {
    if ($u['email'] === $email) {
        $user = $u;
        break;
    }
}

if (!$user) {
    echo "User not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user['email'] !== 'admin@gmail.com') { 
        $username = $_POST['username'] ?? $user['username'];
        $name = $_POST['name'] ?? $user['name'];
        $password = $_POST['password'] ?? $user['password'];
    } else { 
        $username = $user['username']; 
        $name = $user['name']; 
        $password = $user['password'];
    }

    $faculty = $_POST['faculty'] ?? $user['faculty'];
    $batch = $_POST['batch'] ?? $user['batch'];
    $gender = $_POST['gender'] ?? $user['gender'];

    updateUser($email, $username, $name, $password, $gender, $faculty, $batch);

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit User</h2>

            <form action="edit_user.php?email=<?= urlencode($user['email']); ?>" method="POST">
                <?php if ($user['email'] !== 'admin@gmail.com'): ?>
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 text-sm font-bold">Username</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>"
                            class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold">Name</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>"
                            class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 text-sm font-bold">Password</label>
                        <input type="password" id="password" name="password" placeholder="Create a password"
                            class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                <?php endif; ?>

                <div class="mb-4">
                    <label for="gender" class="block text-gray-700 text-sm font-bold">Gender</label>
                    <select id="gender" name="gender"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="faculty" class="block text-gray-700 text-sm font-bold">Faculty</label>
                    <input type="text" id="faculty" name="faculty" value="<?= htmlspecialchars($user['faculty']); ?>"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="batch" class="block text-gray-700 text-sm font-bold">Batch</label>
                    <input type="text" id="batch" name="batch" value="<?= htmlspecialchars($user['batch']); ?>"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
</body>
</html>
