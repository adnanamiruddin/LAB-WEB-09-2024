<?php
session_start();
require_once 'data.php';

if (!isset($_GET['email'])) {
    header('Location: dashboard.php');
    exit;
}

$email = $_GET['email'];
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? $user['nama'];
    $prodi = $_POST['prodi'] ?? $user['prodi'];
    $gender = $_POST['gender'] ?? $user['jenis_kelamin'];
    $address = $_POST['address'] ?? $user['alamat'];
    $phone = $_POST['phone'] ?? $user['no_hp'];
    $birthdate = $_POST['birthdate'] ?? $user['tanggal_lahir'];
    
    
    $updateFields = [];
    $paramTypes = "";
    $paramValues = [];
    
    // Basic user data
    $updateFields[] = "nama = ?";
    $updateFields[] = "prodi = ?";
    $updateFields[] = "jenis_kelamin = ?";
    $updateFields[] = "alamat = ?";
    $updateFields[] = "no_hp = ?";
    $updateFields[] = "tanggal_lahir = ?";
    $paramTypes .= "ssssss";
    array_push($paramValues, $name, $prodi, $gender, $address, $phone, $birthdate);

    // Handle password update
    if (!empty($_POST['new_password']) && !empty($_POST['current_password']) && !empty($_POST['confirm_password'])) {
    
        if (!password_verify($_POST['current_password'], $user['password'])) {
            $_SESSION['error'] = "Current password is incorrect";
            header('Location: edit_user.php?email=' . urlencode($email));
            exit;
        }

        if ($_POST['new_password'] !== $_POST['confirm_password']) {
            $_SESSION['error'] = "New passwords do not match";
            header('Location: edit_user.php?email=' . urlencode($email));
            exit;
        }

        $hashedNewPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        $updateFields[] = "password = ?";
        $paramTypes .= "s";
        $paramValues[] = $hashedNewPassword;
    }

    // Handle photo upload 
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
        $updateFields[] = "foto = ?";
        $paramTypes .= "s";
        $paramValues[] = $photo;
    }

    $paramTypes .= "s";
    $paramValues[] = $email;

    $sql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    $params = array_merge([$paramTypes], $paramValues);
    $refs = [];
    foreach($params as $key => $value) {
        $refs[$key] = &$params[$key];
    }
    
    // call_user_func_array([$stmt, 'bind_param'], $refs);
    
    $stmt->bind_param($paramTypes, ...$paramValues);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully!";
        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['error'] = "Failed to update profile";
        header('Location: edit_user.php?email=' . urlencode($email));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            position: relative;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit User</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    <?= $_SESSION['error']; ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    <?= $_SESSION['success']; ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form action="edit_user.php?email=<?= urlencode($user['email']); ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold">Name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['nama']); ?>"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <div class="mb-4">
                    <label for="prodi" class="block text-gray-700 text-sm font-bold">Program</label>
                    <input type="text" id="prodi" name="prodi" value="<?= htmlspecialchars($user['prodi']); ?>"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="mb-4">
                    <label for="gender" class="block text-gray-700 text-sm font-bold">Gender</label>
                    <select id="gender" name="gender"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                        <option value="Laki-laki" <?= $user['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $user['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-700 text-sm font-bold">Address</label>
                    <textarea id="address" name="address" rows="4"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"><?= htmlspecialchars($user['alamat']); ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-bold">Phone</label>
                    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user['no_hp']); ?>"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="mb-4">
                    <label for="birthdate" class="block text-gray-700 text-sm font-bold">Date of Birth</label>
                    <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($user['tanggal_lahir']); ?>"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 text-sm font-bold">Current Password</label>
                    <input type="password" id="current_password" name="current_password"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700 text-sm font-bold">New Password</label>
                    <input type="password" id="new_password" name="new_password"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password"
                        class="mt-2 block w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="mb-4">
                    <label for="photo" class="block text-gray-700 text-sm font-bold">Upload Photo</label>
                    <input type="file" id="photo" name="photo"
                        class="mt-2 block w-full px-4 py-2 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="flex justify-between">
                    <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Back
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <h2 class="text-xl font-bold mb-4">Confirm Password Change</h2>
            <p class="mb-4">Are you sure you want to change your password?</p>
            <div class="flex justify-end gap-2">
                <button onclick="confirmPasswordChange()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Yes, Change Password
                </button>
                <button onclick="closePasswordModal()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const currentPassword = document.getElementById('current_password').value;

            
            if (newPassword || confirmPassword || currentPassword) {
                e.preventDefault();

                
                if (!newPassword || !confirmPassword || !currentPassword) {
                    alert('All password fields must be filled to change password');
                    return;
                }

            
                if (newPassword !== confirmPassword) {
                    alert('New passwords do not match!');
                    return;
                }

                document.getElementById('passwordModal').style.display = 'block';
            }
        });

        function confirmPasswordChange() {
            document.getElementById('passwordModal').style.display = 'none';
            document.querySelector('form').submit();
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
            document.getElementById('new_password').value = '';
            document.getElementById('confirm_password').value = '';
            document.getElementById('current_password').value = '';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('passwordModal');
            if (event.target == modal) {
                closePasswordModal();
            }
        }
    </script>
</body>

</html>