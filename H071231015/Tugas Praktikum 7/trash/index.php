<?php
session_start();
include 'conn.php';

$conn = getConnectionWithDB();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Cek apakah role sudah terdefinisi
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] == 'admin';

// Flash message
$flash_message = isset($_SESSION['flash']) ? $_SESSION['flash'] : '';
unset($_SESSION['flash']);

// Tambah mahasiswa
if (isset($_POST['add'])) {
    $nim = $_POST['nim'];
    $name = $_POST['name'];
    $prodi = $_POST['prodi'];

    // Menggunakan prepared statements
    $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, name, prodi) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nim, $name, $prodi);
    if ($stmt->execute()) {
        $_SESSION['flash'] = "Mahasiswa berhasil ditambahkan.";
    } else {
        $_SESSION['flash'] = "Terjadi kesalahan saat menambahkan mahasiswa.";
    }
    $stmt->close();

    header('Location: index.php');
    exit;
}

// Hapus mahasiswa
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Menggunakan prepared statements
    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['flash'] = "Mahasiswa berhasil dihapus.";
    } else {
        $_SESSION['flash'] = "Terjadi kesalahan saat menghapus mahasiswa.";
    }
    $stmt->close();

    header('Location: index.php');
    exit;
}

// Ambil data mahasiswa
$students = $conn->query("SELECT * FROM mahasiswa");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-center mb-6">Data Mahasiswa</h2>

            <!-- Flash message -->
            <?php if ($flash_message) { ?>
                <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                    <?php echo $flash_message; ?>
                </div>
            <?php } ?>

            <!-- Form tambah mahasiswa (hanya untuk admin) -->
            <?php if ($is_admin) { ?>
                <form method="POST" class="mb-6">
                    <div class="mb-4">
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                        <input type="text" name="nim" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">name</label>
                        <input type="text" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                        <input type="text" name="prodi" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <button type="submit" name="add" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition duration-150 ease-in-out">Tambah Mahasiswa</button>
                </form>
            <?php } ?>

            <!-- Tabel data mahasiswa -->
            <table class="table-auto w-full text-left">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">NIM</th>
                        <th class="px-4 py-2">name</th>
                        <th class="px-4 py-2">Program Studi</th>
                        <?php if ($is_admin) { echo "<th class='px-4 py-2'>Aksi</th>"; } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $students->fetch_assoc()) { ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo $row['nim']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['name']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['prodi']; ?></td>
                            <?php if ($is_admin) { ?>
                                <td class="border px-4 py-2">
                                    <a href="?delete=<?php echo $row['id']; ?>" class="text-red-500">Hapus</a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>
</html>
