<?php

include("conn.php");

function checkLogin($emailOrUsername, $password) {
    global $conn;
    
    $field = filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
    $stmt = $conn->prepare("
        SELECT id, nama, email, username, password, role, jenis_kelamin, nim, prodi 
        FROM users 
        WHERE $field = ?
    ");
    
    $stmt->bind_param("s", $emailOrUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }
    }
    
    return false;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isLogin()
{
    return isset($_SESSION['user']);
}


function registerUser($nama, $username, $email, $password, $role, $jenis_kelamin, $additionalData = []) {
    global $conn;
    
    try {
        $conn->begin_transaction();
        
        $stmt = $conn->prepare("
            INSERT INTO users (
                nama, 
                username, 
                email, 
                password, 
                role, 
                jenis_kelamin, 
                nim, 
                prodi,
                tanggal_lahir,
                no_hp,
                alamat
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )");
        
        $nim = $additionalData['nim'] ?? null;
        $prodi = $additionalData['prodi'] ?? null;
        $tanggal_lahir = $additionalData['tanggal_lahir'] ?? null;
        $no_hp = $additionalData['no_hp'] ?? null;
        $alamat = $additionalData['alamat'] ?? null;
        
        $stmt->bind_param("sssssssssss", 
            $nama,
            $username,
            $email,
            $password, 
            $role,
            $jenis_kelamin,
            $nim,
            $prodi,
            $tanggal_lahir,
            $no_hp,
            $alamat
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Error inserting: " . $stmt->error);
        }
        
        $conn->commit();
        return true;
        
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Registration error: " . $e->getMessage());
        return false;
    }
}


function checkGoogleUser($email, $name)
{
    $conn = getConnectionWithDB();

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['new_user'] = [
            'email' => $email,
            'name' => $name
        ];
        header('Location: user_setup.php');
        exit;
    }
}



// // Update user details with or without a photo
// function updateUser($id, $name, $username, $password, $gender, $role, $additionalData = [], $photo = null)
// {
//     $conn = getConnectionWithDB();

//     $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//     if ($photo) {
//         $photoContent = file_get_contents($photo['tmp_name']);
//         $stmt = $conn->prepare("UPDATE users SET nama = ?, username = ?, password = ?, jenis_kelamin = ?, role = ?, foto = ? WHERE id = ?");
//         $stmt->bind_param("ssssssi", $name, $username, $hashed_password, $gender, $role, $photoContent, $id);
//     } else {
//         $stmt = $conn->prepare("UPDATE users SET nama = ?, username = ?, password = ?, jenis_kelamin = ?, role = ? WHERE id = ?");
//         $stmt->bind_param("sssssi", $name, $username, $hashed_password, $gender, $role, $id);
//     }

//     if (!$stmt->execute()) {
//         die("Error: " . $stmt->error);
//     }

//     // Update additional fields for mahasiswa
//     if ($role === 'mahasiswa') {
//         $stmt = $conn->prepare("UPDATE users SET nim = ?, prodi = ?, alamat = ?, tanggal_lahir = ?, no_hp = ? WHERE id = ?");
//         $stmt->bind_param("sssssi", $additionalData['nim'], $additionalData['prodi'], $additionalData['alamat'], $additionalData['tanggal_lahir'], $additionalData['no_hp'], $id);

//         if (!$stmt->execute()) {
//             die("Error: " . $stmt->error);
//         }
//     }

//     return true;
// }

// // Fetch user by id (mahasiswa or other roles)
// function getUserById($id)
// {
//     $conn = getConnectionWithDB();
//     $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
//     $stmt->bind_param("i", $id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     return $result->fetch_assoc();
// }

// // Delete user by id
// function deleteUser($id)
// {
//     $conn = getConnectionWithDB();
//     $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
//     $stmt->bind_param("i", $id);

//     if ($stmt->execute()) {
//         return true;
//     } else {
//         return false;
//     }
// }