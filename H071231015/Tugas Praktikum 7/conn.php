<?php

function getConnectionWithoutDB()
{
    $host = "localhost";
    $user = "root";
    $password = "";

    $conn = new mysqli($host, $user, $password);

    if ($conn->connect_error) {
        die("Error: " . $conn->connect_error);
    }

    return $conn;
}

function getConnectionWithDB()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sikola";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error: " . $conn->connect_error);
    }

    return $conn;
}

// inisiasi db
$conn = getConnectionWithoutDB();

$sql = "CREATE DATABASE IF NOT EXISTS sikola";
if ($conn->query($sql) === FALSE) {
    die("Error: " . $conn->error);
}

$conn->close();


// reconnect db
$conn = getConnectionWithDB();

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50) NOT NULL,
    nim VARCHAR(15) UNIQUE,
    prodi VARCHAR(50),
    foto LONGBLOB,
    alamat TEXT,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan'),
    tanggal_lahir DATE,
    no_hp VARCHAR(15),
    email VARCHAR(50) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    account_activation_hash VARCHAR(64) NULL DEFAULT NULL,
    reset_token_hash VARCHAR(64) NULL DEFAULT NULL,
    reset_token_expires_at DATETIME NULL DEFAULT NULL,
    role ENUM('mahasiswa', 'admin') NOT NULL DEFAULT 'mahasiswa',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    edited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE (account_activation_hash),
    UNIQUE (reset_token_hash)
)";
if ($conn->query($sql) === FALSE) {
    die("Error users: " . $conn->error);
}

// admin handling

$sql = "SELECT * FROM users WHERE role = 'admin'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    $admin_username = "admin";
    $admin_password = password_hash("admin123", PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (nama, email, username, password, role) VALUES ('Admin', 'admin@gmail.com', '$admin_username', '$admin_password', 'admin')";
    if ($conn->query($sql) === FALSE) {
        die("Error admin: ". $conn->error);
    }
}
