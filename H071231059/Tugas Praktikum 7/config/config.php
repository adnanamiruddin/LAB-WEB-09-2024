<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_university";

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi ke database GAGAL");
}
