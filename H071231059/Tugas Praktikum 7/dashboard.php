<?php 
session_start();
include './config/config.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];

$errorMsg = "";
$error = "";
$success = "";

$query = "SELECT * FROM mahasiswa WHERE id='$id'";
$executeQGet = mysqli_query($conn, $query);
$data = mysqli_fetch_array($executeQGet);

$nimShow = $data['nim'];
$nameShow = $data['name'];
$studyProgramShow = $data['studyProgram'];

$split = explode(' ', $nameShow);  
$nickname = $split[0]; 


if (isset($_POST['saveAdd'])) {
    $name = $_POST['name'];
    $nim = $_POST['nim'];
    $studyProgram = $_POST['studyProgram'];

    $split2 = explode(' ', $name);

    $inisial = "";
    foreach ($split2 as $kata) {
        $inisial .= strtoupper($kata[0]);
    }

    $akhiranNIM = substr($nim, -2);

    $password = $inisial . $akhiranNIM;

    if ($nim && $name && $studyProgram) {
        $queryInsert = "INSERT INTO mahasiswa(`name`, nim, studyProgram, `password`) VALUES ('$name', '$nim', '$studyProgram', '$password')";
        try {
            $executeQInsert = mysqli_query($conn, $queryInsert);
            if ($executeQInsert) {
                $success = "Your data has been added successfully";
            }
        } catch (mysqli_sql_exception $err) {
            $error = "Your data failed to be added";
        }
    
    } else {
        $errorMsg = "All forms must be filled in!";
    }

} elseif (isset($_POST['saveEdit'])) {
    $name = $_POST['name'];
    $nim = $_POST['nim'];
    $studyProgram = $_POST['studyProgram'];
    $idEdit = $_POST['idEdit'];

    if ($nim && $name && $studyProgram) {
        $queryUpdate = "UPDATE mahasiswa SET `name`='$name', nim='$nim', studyProgram='$studyProgram' WHERE id='$idEdit'";
        $executeQUpdate = mysqli_query($conn, $queryUpdate);
        if ($executeQUpdate) {
            $success = "Your data has been updated successfully";
        } else {
            $error = "Your data failed to be update";
        }
    } else {
        $errorMsg = "All forms must be filled in!";
    }
} elseif(isset($_POST['deleteFR'])) {
    $idDelete = $_POST['idDelete'];
    $queryDelete = "DELETE FROM mahasiswa WHERE id='$idDelete'";
    $executeQDelete = mysqli_query($conn, $queryDelete);
    if ($executeQDelete) {
        $success = "Berhasil menghapus data";
    } else {
        $error = "Gagal menghapus data";
    }
}

if (isset($_GET['success'])) {
    $success = $_GET['success'];
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-fixed bg-cover bg-center bg-[url('assets/images/dashboard-bg.jpg')] ">

    <?php if ($error) { ?>
        <div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
            <?php echo $error ?>
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-2" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    <?php header("refresh:3;url=dashboard.php");
    } ?>

    <?php if ($success) { ?>
        <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                <?php echo $success ?>
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>    
    <?php header("refresh:5;url=dashboard.php");
    } ?>

    <section>
        <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-28">
            <h1 class="mb-8 text-4xl font-extrabold tracking-tight leading-none text-slate-900 md:text-5xl lg:text-6xl">
                Welcome, <?php echo $nickname; ?>
            </h1>
            <?php if ($id != 1): ?>
                <ul class="max-w-2xl divide-y divide-slate-900 mx-auto mt-20">
                    <li class="pb-3 sm:pb-4">
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-medium text-gray-900 truncate">
                                Fullname:
                            </p>
                            <p class="text-lg font-semibold text-gray-900">
                                <?php echo $nameShow; ?>
                            </p>
                        </div>
                    </li>
                    <li class="py-3 sm:py-4">
                        <div class="flex justify-between items-center" >
                            <p class="text-lg font-medium text-gray-900 truncate">
                                NIM:
                            </p>
                            <p class="text-lg font-semibold text-gray-900">
                                <?php echo $nimShow; ?>
                            </p>
                        </div>
                    </li>
                    <li class="py-3 sm:py-4">
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-medium text-gray-900 truncate">
                                Study Program:
                            </p>
                            <p class="text-lg font-semibold text-gray-900">
                                <?php echo $studyProgramShow; ?>
                            </p>
                        </div>
                    </li>
                </ul>
            <?php endif; ?>
            <div class="flex flex-col mt-10 space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                <a href="logout.php" class="inline-flex justify-center hover:text-gray-100 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-black rounded-lg border border-black hover:bg-gray-900 focus:ring-4 focus:ring-gray-400">
                    Logout
                </a>  
            </div>
        </div>
    </section>


    <?php if ($id == 1): ?>
        <div class="relative ">
            <div class="pb-4 flex justify-between items-center">
                <div class="relative ml-5">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative mt-1 flex justify-between items-center">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-slate-900 focus:border-slate-900" placeholder="Enter NIM">
                        <button onclick="searchAndScroll()" class="ml-3 mb-2 mt-2 text-white bg-slate-700 hover:bg-slate-800 px-4 py-2 rounded">Search</button>
                    </div>
                </div>

                <div class="mr-5">
                    <button name="add" data-modal-target="add-modal" data-modal-toggle="add-modal" class="text-white inline-flex items-center bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Add new student
                    </button>
                </div>
            </div>
        </div>
        
        <div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No.
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NIM
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Study Program
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $number = 1;
                        $queryGet = "SELECT * FROM mahasiswa ORDER BY id ASC";
                        $executeQGet = mysqli_query($conn, $queryGet);
                        while ($data = mysqli_fetch_array($executeQGet)) {
                            $id2 = $data['id'];
                            $nim2 = $data['nim'];
                    ?>
                    <tr id="student-<?= $nim2 ?>" class="bg-gray-100 border-b">
                        <?php if ($id2 != 1): ?>
                        <td class="px-6 py-4"><?= $number++ ?></td>
                        <td class="px-6 py-4"><?= $data['nim'] ?></td>
                        <td class="px-6 py-4"><?= $data['name'] ?></td>
                        <td class="px-6 py-4"><?= $data['studyProgram'] ?></td>
                        <td class="px-6 py-4">
                            <button 
                                name="editModal" 
                                id="editModal-<?= $id2 ?>" 
                                data-modal-target="edit-modal-<?= $id2 ?>" 
                                data-modal-toggle="edit-modal-<?= $id2 ?>" 
                                class="mr-4 font-medium text-slate-600 hover:underline">
                                Edit
                            </button>

                            <button 
                                name="deleteModal" 
                                id="deleteModal-<?= $id2 ?>" 
                                data-modal-target="delete-modal-<?= $id2 ?>" 
                                data-modal-toggle="delete-modal-<?= $id2 ?>" 
                                class="font-medium text-red-600 hover:underline">
                                Delete
                            </button>

                            <!-- EDIT MODAL -->
                            <div id="edit-modal-<?= $id2 ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                            <h3 class="text-lg font-semibold text-gray-900 ">
                                                Edit Student Data
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="edit-modal-<?= $id2 ?>">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <form class="p-4 md:p-5" action="#" method="POST">
                                            <input type="hidden" name="idEdit" value="<?= $id2 ?>">
                                            <div class="grid gap-4 mb-4 grid-cols-2">
                                                <div class="col-span-2">
                                                    <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 ">NIM</label>
                                                    <input type="text" name="nim" id="nim" value="<?php echo $data['nim'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                                                    <input type="text" name="name" id="name" value="<?php echo $data['name'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="studyProgram" class="block mb-2 text-sm font-medium text-gray-900 ">Study Program</label>
                                                    <input type="text" name="studyProgram" id="studyProgram" value="<?php echo $data['studyProgram'] ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                                                    <p class="text-sm font-semibolds text-red-600 mt-1 ml-2">
                                                        <?php echo $errorMsg; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <button name="saveEdit" type="submit" class="text-white inline-flex items-center bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                Save Edit
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <!-- DELETE MODAL -->
                            <div name="delete-modal-<?= $id2 ?>" id="delete-modal-<?= $id2 ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow">
                                       
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="delete-modal-<?= $id2 ?>">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500">Are you sure you want to delete this student data?</h3>
                                            <div class="flex justify-center space-x-2">
                                                <form action="#" method="POST">
                                                    <input type="hidden" name="idDelete" value="<?= $id2 ?>">
                                                    <button name="deleteFR" type="submit" id="delete" data-modal-hide="delete-modal-<?= $id2 ?>" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                        Yes, I'm sure
                                                    </button>
                                                </form>
                                                <button data-modal-hide="delete-modal-<?= $id2 ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-slate-900 focus:outline-none bg-slate-100 rounded-lg border border-slate-200 hover:bg-slate-900 hover:text-blue-100 focus:z-10 focus:ring-4 focus:ring-slate-100">No, cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </td>
                        <?php endif ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <!-- ADD MODAL -->
        <div id="add-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow ">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                        <h3 class="text-lg font-semibold text-gray-900 ">
                            add Student Data
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="add-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form class="p-4 md:p-5" action="#" method="POST">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 ">NIM</label>
                                <input type="text" name="nim" id="nim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                            </div>
                            <div class="col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                            </div>
                            <div class="col-span-2">
                                <label for="studyProgram" class="block mb-2 text-sm font-medium text-gray-900 ">Study Program</label>
                                <input type="text" name="studyProgram" id="studyProgram" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                                <p class="text-sm font-semibolds text-red-600 mt-1 ml-2">
                                    <?php echo $errorMsg; ?>
                                </p>
                            </div>
                        </div>
                        <button name="saveAdd" type="submit" class="text-white inline-flex items-center bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Add Student
                        </button>
                    </form>
                </div>
            </div>
        </div>

        



    <?php endif; ?>



    

    <script>
        function searchAndScroll() {
            // Ambil nilai dari search bar
            var inputNIM = document.getElementById('table-search').value;
            
            // Cek apakah NIM diisi
            if (inputNIM) {
                // Temukan baris yang memiliki ID sesuai dengan NIM yang dimasukkan
                var studentRow = document.getElementById('student-' + inputNIM);
                
                if (studentRow) {
                    // Scroll ke elemen jika ditemukan
                    studentRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    // Highlight baris yang ditemukan (opsional)
                    studentRow.style.backgroundColor = '#d1d5db'; // Beri warna highlight sementara
                    setTimeout(function() {
                        studentRow.style.backgroundColor = ''; // Kembalikan warna semula setelah beberapa saat
                    }, 4000);
                } else {
                    alert('Student is not found.');
                }
            } else {
                alert('Enter NIM first.');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>
