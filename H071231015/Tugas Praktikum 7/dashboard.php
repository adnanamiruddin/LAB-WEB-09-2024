<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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


$userEmail = $_SESSION['user']['email'];
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$_SESSION['user'] = $user;


$limit = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $_GET['search'] : '';





if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: login.php');
        exit;
    } elseif (isset($_POST['delete_user'])) {
        $emailToDelete = $_POST['delete_user'];

    
        $deleteStmt = $conn->prepare("DELETE FROM users WHERE email = ?");
        $deleteStmt->bind_param("s", $emailToDelete);
        $deleteStmt->execute();

        if ($emailToDelete === $user['email']) {
            session_destroy();
            header('Location: login.php?message=account_deleted');
            exit;
        }

        header('Location: dashboard.php');
        exit;
    } elseif (isset($_POST['add_user'])) {
        try {
            $name = $_POST['name'];
            $nim = $_POST['nim'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $prodi = $_POST['prodi'];
            $gender = $_POST['gender'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $addStmt = $conn->prepare("INSERT INTO users (nama, nim, email, username, prodi, jenis_kelamin, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$addStmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $addStmt->bind_param("sssssss", $name, $nim, $email, $username, $prodi, $gender, $password);

            if (!$addStmt->execute()) {
                throw new Exception("Execute failed: " . $addStmt->error);
            }

            header('Location: dashboard.php?message=user_added');
            exit;
        } catch (Exception $e) {
            error_log("Error adding user: " . $e->getMessage());
            header('Location: daswshboard.php?error=' . urlencode($e->getMessage()));
            exit;
        }
    }
}


$userSearchQuery = "SELECT * FROM users WHERE email != 'admin@gmail.com' AND (nama LIKE ? OR nim LIKE ? OR email LIKE ?) LIMIT ?, ?";
$searchTerm = "%$search%";
$stmt = $conn->prepare($userSearchQuery);
$stmt->bind_param("sssii", $searchTerm, $searchTerm, $searchTerm, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();


$countStmt = $conn->prepare("SELECT COUNT(*) as total FROM users WHERE email != 'admin@gmail.com' AND (nama LIKE ? OR nim LIKE ? OR email LIKE ?)");
$countStmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalUsers = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalUsers / $limit);
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
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="container mx-auto py-10">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg mx-auto text-center">
            <h1 class="text-3xl font-bold text-gray-800">Welcome, <?= htmlspecialchars($user['nama']); ?>!</h1>
            <p class="text-gray-600 mt-2"><?= htmlspecialchars($user['email']); ?></p>

            <!-- fotonya -->
            <?php if (!empty($user['foto'])): ?>
                <div class="mt-4">
                    <img src="data:image/jpeg;base64,<?= base64_encode($user['foto']); ?>" alt="User Photo" class="w-32 h-32 rounded-full mx-auto">
                </div>
            <?php else: ?>
                <div class="mt-4">
                    <img src="assets/images/null.jpg" alt="No Photo Available" class="w-32 h-32 rounded-full mx-auto">
                </div>
            <?php endif; ?>
        </div>

        <?php if ($user['email'] === 'admin@gmail.com'): ?>
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">All Users</h2>
                    <button data-modal-target="addUserModal" data-modal-toggle="addUserModal"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                        Add User
                    </button>
                </div>

                
                <form class="mb-4" method="GET" action="">
                    <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" class="border px-4 py-2" placeholder="Search by name, NIM, or email...">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
                </form>

                
                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-gray-600">Name</th>
                                <th class="px-4 py-2 text-gray-600">Email</th>
                                <th class="px-4 py-2 text-gray-600">NIM</th>
                                <th class="px-4 py-2 text-gray-600">Program</th>
                                <th class="px-4 py-2 text-gray-600">Photo</th>
                                <th class="px-4 py-2 text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($u = $result->fetch_assoc()): ?>
                                <tr class="bg-white border-b">
                                    <td class="px-4 py-2"><?= htmlspecialchars($u['nama']); ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($u['email']); ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($u['nim']); ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($u['prodi']); ?></td>
                                    <td class="px-4 py-2">
                                        <?php if (!empty($u['foto'])): ?>
                                            <img src="data:image/jpeg;base64,<?= base64_encode($u['foto']); ?>" alt="User Photo" class="w-12 h-12 rounded-full">
                                        <?php else: ?>
                                            <img src="assets\images\null.jpg" alt="No Photo Available" class="w-12 h-12 rounded-full">
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="edit_user.php?email=<?= urlencode($u['email']); ?>" class="text-blue-600 hover:underline">Edit</a>
                                        <form method="POST" action="" class="inline-block">
                                            <input type="hidden" name="delete_user" value="<?= htmlspecialchars($u['email']); ?>">
                                            <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>" class="px-3 py-1 border rounded <?= $i === $page ? 'bg-blue-500 text-white' : 'bg-white text-blue-500' ?>">
                            <?= $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6 max-w-lg mx-auto">
                <h2 class="text-2xl font-bold text-gray-800">Your Details</h2>
                <div class="mt-4 space-y-2">
                    <p><strong class="font-semibold">Name:</strong>
                        <?= !empty($user['nama']) ? htmlspecialchars($user['nama']) : '<span class="text-gray-500 italic">No information available</span>'; ?>
                    </p>
                    <p><strong class="font-semibold">Email:</strong>
                        <?= !empty($user['email']) ? htmlspecialchars($user['email']) : '<span class="text-gray-500 italic">No information available</span>'; ?>
                    </p>
                    <p><strong class="font-semibold">Username:</strong>
                        <?= !empty($user['username']) ? htmlspecialchars($user['username']) : '<span class="text-gray-500 italic">No information available</span>'; ?>
                    </p>
                    <p><strong class="font-semibold">NIM:</strong>
                        <?= !empty($user['nim']) ? htmlspecialchars($user['nim']) : '<span class="text-gray-500 italic">No information available</span>'; ?>
                    </p>
                    <p><strong class="font-semibold">Program:</strong>
                        <?= !empty($user['prodi']) ? htmlspecialchars($user['prodi']) : '<span class="text-gray-500 italic">No information available</span>'; ?>
                    </p>
                    <p><strong class="font-semibold">Gender:</strong>
                        <?= !empty($user['jenis_kelamin']) ? htmlspecialchars($user['jenis_kelamin']) : '<span class="text-gray-500 italic">No information available</span>'; ?>
                    </p>
                    <p><strong class="font-semibold">Date of Birth:</strong>
                        <?= !empty($user['tanggal_lahir']) ? htmlspecialchars($user['tanggal_lahir']) : '<span class="text-gray-500 italic">No information available</span>'; ?>
                    </p>
                    <p><strong class="font-semibold">Phone:</strong>
                        <?= !empty($user['no_hp']) ? htmlspecialchars($user['no_hp']) : '<span class="text-gray-500 italic">No information available</span>'; ?>
                    </p>
                    <p><strong class="font-semibold">Address:</strong>
                        <?= !empty($user['alamat']) ? htmlspecialchars($user['alamat']) : '<span class="text-gray-500 italic">No information available</span>'; ?>
                    </p>
                </div>

                <div class="mt-6 flex gap-4 justify-center">
                    <a href="edit_user.php?email=<?= urlencode($user['email']); ?>"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        Edit Profile
                    </a>
                    <form method="POST" action="" class="inline-block">
                        <input type="hidden" name="delete_user" value="<?= htmlspecialchars($user['email']); ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                            Delete Account
                        </button>
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


    <div id="addUserModal" tabindex="-1" class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden flex items-center justify-center bg-black bg-opacity-50">
        <div class="relative w-full max-w-2xl mx-auto p-4">
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow-lg animate-fade-in">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-4 border-b rounded-t">
                    <h3 class="text-xl font-bold text-gray-900">
                        Add New User
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg p-1.5 ml-auto inline-flex items-center" data-modal-hide="addUserModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-4">
                    <form id="addUserForm" method="POST" action="">
                        <input type="hidden" name="add_user" value="1">
                        <!-- Input fields for adding user -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 border rounded-md text-gray-700">
                        </div>
                        <div>
                            <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                            <input type="text" id="nim" name="nim" required class="mt-1 block w-full px-3 py-2 border rounded-md text-gray-700">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border rounded-md text-gray-700">
                        </div>
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" id="username" name="username" required class="mt-1 block w-full px-3 py-2 border rounded-md text-gray-700">
                        </div>
                        <div>
                            <label for="prodi" class="block text-sm font-medium text-gray-700">Program</label>
                            <input type="text" id="prodi" name="prodi" required class="mt-1 block w-full px-3 py-2 border rounded-md text-gray-700">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 border rounded-md text-gray-700">
                        </div>
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select id="gender" name="gender" required class="mt-1 block w-full px-3 py-2 border rounded-md text-gray-700">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <button type="submit" class="mt-4 w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Flowbite JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script>
        // opening and closing
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.getElementById(button.getAttribute('data-modal-target'));
                modal.classList.toggle('hidden');
            });
        });

        // Close1
        document.addEventListener('click', (event) => {
            const modal = document.getElementById('addUserModal');
            if (!modal.contains(event.target) && event.target.dataset.modalTarget !== 'addUserModal' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
            }
        });

        // Close2
        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', () => {
                button.closest('.fixed').classList.add('hidden');
            });
        });
    </script>
</body>

</html>