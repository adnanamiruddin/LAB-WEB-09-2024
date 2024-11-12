<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
require_once 'data.php';

// Google Client Setup
$client = new Google\Client;
$client->setClientId("810163562901-q5gcr04rbf5ifp9fdk1un4f4lg9cncki.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/t7/redirect.php");

$client->addScope(Google\Service\Oauth2::USERINFO_EMAIL);
$client->addScope(Google\Service\Oauth2::USERINFO_PROFILE);

$googleLoginUrl = $client->createAuthUrl();

// Add this endpoint for AJAX username check
if (isset($_POST['check_username'])) {
    $username = test_input($_POST['username']);
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['count'];

    header('Content-Type: application/json');
    echo json_encode(['exists' => $count > 0]);
    exit;
}

if (isset($_POST['check_email'])) {
    $email = test_input($_POST['email']);
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['count'];

    header('Content-Type: application/json');
    echo json_encode(['exists' => $count > 0]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nama = test_input($_POST['nama']);
        $username = test_input($_POST['username']);
        $email = test_input($_POST['email']);
        $password = test_input($_POST['password']);
        $nim = test_input($_POST['nim']);
        $prodi = test_input($_POST['prodi']);
        $nama = test_input($_POST['nama']);
        $jenis_kelamin = test_input($_POST['jenis_kelamin']);

        // reCAPTCHA verification
        $recaptchaSecret = "6LdZhWoqAAAAAHBCKDkoXGEvhLU4ausueD32rTQb";
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";
        $response = file_get_contents($recaptchaUrl . "?secret=" . $recaptchaSecret . "&response=" . $recaptchaResponse);
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            throw new Exception("reCAPTCHA verification failed. Please try again.");
        }

        // Check if user exists by email or username
        $existingUser = checkUserExistence($username, $email, $nim);

        if ($existingUser) {
            throw new Exception("User with this email, username, or NIM already exists.");
        }

        // Hash password and register user
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if (registerNewUser($username, $email, $hashedPassword, $nim, $prodi, $nama, $jenis_kelamin)) {
            $_SESSION['new_user'] = [
                'email' => $email,
                'username' => $username
            ];

            header("Location: dashboard.php");
            exit();
        } else {
            throw new Exception("Registration failed. Please try again.");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: register.php');
        exit();
    }
}

function checkUserExistence($username, $email, $nim)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ? OR nim = ?");
    $stmt->bind_param("sss", $username, $email, $nim);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function registerNewUser($username, $email, $hashedPassword, $nim, $prodi, $nama, $jenis_kelamin) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, nim, prodi, nama, jenis_kelamin) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $username, $email, $hashedPassword, $nim, $prodi, $nama, $jenis_kelamin);
        return $stmt->execute();
    } catch (Exception $e) {
        error_log("Registration Error: " . $e->getMessage());
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100">Register to SIKOLA 3.0</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-500 text-white p-2 rounded-lg text-center mb-4">
                    <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form class="mt-6" action="register.php" method="post" onsubmit="return validateForm()">
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 dark:text-gray-300 text-sm font-bold">Nama</label>
                    <input id="nama" type="text" name="nama" placeholder="Masukkan nama"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 dark:text-gray-300 text-sm font-bold">Username</label>
                    <input id="username" type="text" name="username" placeholder="Masukkan username"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    <p id="usernameError" class="text-red-500 text-sm mt-1 hidden">Username sudah digunakan</p>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-bold">Email</label>
                    <input id="email" type="email" name="email" placeholder="Masukkan email"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    <p id="emailError" class="text-red-500 text-sm mt-1 hidden">Email sudah digunakan</p>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 dark:text-gray-300 text-sm font-bold">Password</label>
                    <input id="password" type="password" name="password" placeholder="Masukkan password"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="nim" class="block text-gray-700 dark:text-gray-300 text-sm font-bold">NIM</label>
                    <input id="nim" type="text" name="nim" placeholder="Masukkan NIM"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="prodi" class="block text-gray-700 dark:text-gray-300 text-sm font-bold">Program Studi</label>
                    <input id="prodi" type="text" name="prodi" placeholder="Masukkan Program Studi"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="jenis_kelamin" class="block text-gray-700 dark:text-gray-300 text-sm font-bold">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="g-recaptcha" data-sitekey="6LdZhWoqAAAAAMf3PI3SSmcNx7-jNVvQl_UNuqKU"></div>

                <button id="submitBtn" type="submit" class="relative inline-flex items-center justify-center w-full p-0.5 mb-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-500 to-lime-400 group-hover:from-green-500 group-hover:to-lime-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 mt-4">
                    <span class="relative w-full px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                        Register
                    </span>
                </button>

                <div class="mt-4 flex flex-wrap justify-center gap-2">
                    <a href="<?= $googleLoginUrl ?>" class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55">
                        <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                            <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd" />
                        </svg>
                        Sign in with Google
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let usernameValid = false;
        let emailValid = false;
        const usernameInput = document.getElementById('username');
        const emailInput = document.getElementById('email');
        const usernameError = document.getElementById('usernameError');
        const emailError = document.getElementById('emailError');
        let checkUsernameTimeout = null;
        let checkEmailTimeout = null;

        // Username validation
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

                fetch('register.php', {
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

        // Email validation
        emailInput.addEventListener('input', function() {
            if (checkEmailTimeout) {
                clearTimeout(checkEmailTimeout);
            }

            checkEmailTimeout = setTimeout(function() {
                const email = emailInput.value;

                if (email.length < 1) {
                    emailError.classList.add('hidden');
                    emailInput.classList.remove('border-red-500');
                    emailValid = false;
                    return;
                }

                fetch('register.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'check_email=1&email=' + encodeURIComponent(email)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            emailError.classList.remove('hidden');
                            emailInput.classList.add('border-red-500');
                            emailValid = false;
                        } else {
                            emailError.classList.add('hidden');
                            emailInput.classList.remove('border-red-500');
                            emailValid = true;
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
            if (!emailValid) {
                emailError.classList.remove('hidden');
                return false;
            }
            return true;
        }
    </script>

</body>

</html>