<?php
session_start();
require_once 'data.php';

if (!isset($_SESSION['new_user'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['check_username'])) {
    $username = test_input($_POST['username']);

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['count'];

    echo json_encode(['exists' => $count > 0]);
    exit;
}

if (isset($_POST['check_nim'])) {
    $nim = test_input($_POST['nim']);

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE nim = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['count'];

    echo json_encode(['exists' => $count > 0]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['check_username'])) {
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $gender = test_input($_POST['gender']);
    $nim = test_input($_POST['nim']);
    $prodi = test_input($_POST['prodi']);

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // User additional data
    if (registerUser(
        $_SESSION['new_user']['name'],
        $username,
        $_SESSION['new_user']['email'],
        $hashedPassword,
        'mahasiswa',
        $gender,
        [
            'nim' => $nim,
            'prodi' => $prodi,
            'alamat' => null,
            'tanggal_lahir' => null,
            'no_hp' => null
        ]
    )) {
        // Logged in user
        $_SESSION['user'] = [
            'email' => $_SESSION['new_user']['email'],
            'username' => $username,
            'name' => $_SESSION['new_user']['name'],
            'gender' => $gender,
            'nim' => $nim,
            'prodi' => $prodi
        ];

        unset($_SESSION['new_user']);

        header('Location: dashboard.php');
        exit;
    } else {
        $error = "There was an issue registering your account. Please try again.";
    }
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
    <style>
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-xl font-bold">Set Up Your Account</h1>

            <?php if (isset($error)): ?>
                <div class="bg-red-500 text-white p-2 rounded-lg text-center mb-4">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form class="mt-6" method="POST" id="setupForm" onsubmit="return validateForm()">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold">Username</label>
                    <input type="text" id="username" name="username" placeholder="Your username"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                    <div id="usernameError" class="error-message hidden">Username already taken</div>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                </div>

                <div class="mb-4">
                    <label for="gender" class="block text-gray-700 text-sm font-bold">Gender</label>
                    <select id="gender" name="gender"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="nim" class="block text-gray-700 text-sm font-bold">NIM</label>
                    <input type="text" id="nim" name="nim" placeholder="Your NIM"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                    <div id="nimError" class="error-message hidden">NIM already registered</div>
                </div>

                <div class="mb-4">
                    <label for="prodi" class="block text-gray-700 text-sm font-bold">Prodi</label>
                    <input type="text" id="prodi" name="prodi" placeholder="Your Program Studi"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    Submit
                </button>
            </form>
        </div>
    </div>

    <script>
        let usernameValid = false;
        let nimValid = false;
        const usernameInput = document.getElementById('username');
        const nimInput = document.getElementById('nim');
        const usernameError = document.getElementById('usernameError');
        const nimError = document.getElementById('nimError');
        const submitBtn = document.getElementById('submitBtn');
        let checkUsernameTimeout = null;
        let checkNimTimeout = null;

        // Username
        usernameInput.addEventListener('input', function() {
            if (checkUsernameTimeout) {
                clearTimeout(checkUsernameTimeout);
            }

            checkUsernameTimeout = setTimeout(function() {
                const username = usernameInput.value;

                if (username.length < 1) {
                    usernameError.classList.add('hidden');
                    usernameInput.classList.remove('border-red-500');
                    usernameValid = false;
                    return;
                }

                fetch('user_setup.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'check_username=1&username=' + encodeURIComponent(username)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            usernameError.classList.remove('hidden');
                            usernameInput.classList.add('border-red-500');
                            usernameValid = false;
                        } else {
                            usernameError.classList.add('hidden');
                            usernameInput.classList.remove('border-red-500');
                            usernameValid = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }, 300);
        });


        // NIM
        nimInput.addEventListener('input', function() {
            if (checkNimTimeout) {
                clearTimeout(checkNimTimeout);
            }

            checkNimTimeout = setTimeout(function() {
                const nim = nimInput.value;

                if (nim.length < 1) {
                    nimError.classList.add('hidden');
                    nimInput.classList.remove('border-red-500');
                    nimValid = false;
                    return;
                }

                fetch('user_setup.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'check_nim=1&nim=' + encodeURIComponent(nim)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            nimError.classList.remove('hidden');
                            nimInput.classList.add('border-red-500');
                            nimValid = false;
                        } else {
                            nimError.classList.add('hidden');
                            nimInput.classList.remove('border-red-500');
                            nimValid = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }, 300);
        });

        function validateForm() {
            if (!usernameValid) {
                usernameError.classList.remove('hidden');
                return false;
            }
            if (!nimValid) {
                nimError.classList.remove('hidden');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>